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
use Illuminate\Support\Facades\DB;
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

        $contact_job = ContactJob::where('contact_id','=',request('contact_id'))->where('job_id','=',$job->id)->first();

        if (!is_null($contact_job)) {
            return response()->json([
                'type' => 'failur',
                'message' => 'Contact already assigned to job.',
                'values' => array(
                )
            ]);
        }

        $note = new Note();

        $contact_job = DB::transaction(function() use($request, $note) {
            $contact_job = ContactJob::create([
                'contact_id' => request('contact_id'),
                'admin_user_id' => Auth::user()->id,
                'job_id' => $request['job_id'],
            ]);

            $note->user_id = Auth::user()->id;
            $note->notable_id = $contact_job->contact->id;
            $note->notable_type = "App\Contact";
            $note->content = "Assigned to " . $contact_job->job->title . " [id:" . $contact_job->job->id . "].";
            $note->save();

            return $contact_job;
        });

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

        if (!$contact_job || $contact_job->pipeline_id > 1) {
            return response()->json([
                'type' => 'failure',
                'message' => 'Unable to find requested job contact relationship.'
            ]);
        }

        $note = Note::where('notable_type','=','App\\ContactJob')->where('notable_id','=',$contact_job->id)->first();

        if (!is_null($note)) {
            return response()->json([
                'type' => 'failure',
                'message' => 'Contact cannot be unassigned from job.'
            ]);
        }

        $note = new Note();

        DB::transaction(function() use($contact_job, $note) {
            $contact_job->delete();

            $note->user_id = Auth::user()->id;
            $note->notable_id = $contact_job->contact->id;
            $note->notable_type = "App\Contact";
            $note->content = "Unassigned from " . $contact_job->job->title . " [id:" . $contact_job->job->id . "].";
            $note->save();
        });

        return response()->json([
            'type' => 'success',
            'message' => 'Contact successfully unassigned to job.'
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showNotes($id)
    {
        $this->authorize('view-contact-notes');

        $notes = Note::contactJob($id)
            ->orderBy('created_at', 'desc')
            ->get();


        return view('contact/notes/show', [
            'notes' => $notes
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createNote($id)
    {
        $this->authorize('create-contact-note');

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
