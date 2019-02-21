<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactJob;
use App\ContactJob;
use App\Job;
use App\Message;
use App\Note;
use App\User;
use App\Http\Requests\StoreJob;
use App\Mail\InquiryRated;
use App\Mail\InquirySubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class ContactJobController extends Controller
{
    public function store(Request $request)
    {
        $job = Job::find($request['job_id']);
        if (!$job) {
            return response()->json([
                'type' => 'failure',
                'message' => 'Unable to find requested job.'
            ]);
        }

        $contact_job = ContactJob::create([
            'contact_id' => request('contact_id'),
            'admin_user_id' => Auth::user()->id,
            'job_id' => $request['job_id'],
        ]);

        return response()->json([
            'type' => 'success',
            'message' => 'Contact successfully assigned to job.',
            'values' => array(
                'admin_name' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                'created_at' => $contact_job->created_at->format('Y-m-d H:i:s')
            )
        ]);
    }

    public function delete(Request $request)
    {
        $contact_job = ContactJob::where('contact_id', $request['contact_id'])->where('job_id', $request['job_id'])->first();

        if (!$contact_job) {
            return response()->json([
                'type' => 'failure',
                'message' => 'Unable to find requested job contact relationship.'
            ]);
        }

        $contact_job->delete();

        return response()->json([
            'type' => 'success',
            'message' => 'Contact successfully unassigned to job.'
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rateUp($id)
    {
        $contact_job = ContactJob::find($id);
        if (!$contact_job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job assignment' . $id]);
        }
        $this->authorize('edit-inquiry');

        $contact_job->rating = 1;
        $contact_job->save();

        return response()->json([
            'type' => 'success',
            'contact_job_id' => $id,
            'rating' => 1
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rateMaybe($id)
    {
        $contact_job = ContactJob::find($id);
        if (!$contact_job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job assignment.' . $id]);
        }
        $this->authorize('edit-inquiry');

        $contact_job->rating = 0;
        $contact_job->save();

        return response()->json([
            'type' => 'success',
            'contact_job_id' => $id,
            'rating' => 0
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rateDown($id)
    {
        // echo "Here is the user id: " . $id;
        $contact_job = ContactJob::find($id);
        if (!$contact_job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job assignment.' . $id]);
        }
        $this->authorize('edit-inquiry');

        $contact_job->rating = -1;
        $contact_job->save();

        return response()->json([
            'type' => 'success',
            'contact_job_id' => $id,
            'rating' => -1
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showNotes($id)
    {
        $this->authorize('view-inquiry-notes');

        $notes = Note::contactJob($id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('inquiry/notes/show', [
            'notes' => $notes
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createNote($id)
    {
        $this->authorize('create-inquiry-note');

        $contact_job = ContactJob::find($id);
        if (!$contact_job) {
            return abort(404);
        }

        $note = new Note();
        $note->user_id = Auth::user()->id;
        $note->notable_id = $id;
        $note->notable_type = "App\ContactJob";
        $note->content = request("note");
        $note->save();

        return response()->json([
            'type' => 'success',
            'content' => $note->content,
            'user' => Auth::user()
        ]);
    }
}
