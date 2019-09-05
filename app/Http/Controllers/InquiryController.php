<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiry;
use App\Inquiry;
use App\Job;
use App\Message;
use App\Note;
use App\User;
use App\JobInterestResponse;
use App\Http\Requests\StoreJob;
use App\Mail\InquiryRated;
use App\Mail\InquirySubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mail;

class InquiryController extends Controller
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreInquiry $request, $id)
    {
        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }

        $inquiry = Inquiry::where('user_id','=',Auth::user()->id)->where('job_id','=',$job->id)->first();

        if (!is_null($inquiry)) {
            $request->session()->flash('message', new Message(
                "You have already applied to this job.",
                "danger"
            ));
            return back()->withInput();
        }

        if (request('use_profile_resume')) {
            $resume = Auth::user()->profile->resume_url;

            if (!$resume) {
                // TODO Need to do multiples
                $request->session()->flash('message', new Message(
                    "Please upload a resume to your profile.",
                    "danger"
                ));
                return back()->withInput();
            }
        } else if (request('resume')) {
            $resume = request()->file('resume')->store('resume', 'public');
            if (!$resume) {
                // TODO Need to do multiples
                $request->session()->flash('message', new Message(
                    "Please attach a resume.",
                    "danger"
                ));
                return back()->withInput();
            }
        } else {
            // TODO Need to do multiples
            $request->session()->flash('message', new Message(
                "It looks like you forgot to upload a resume.",
                "error"
            ));
            return back()->withInput();
        }


        $inquiry = Inquiry::create([
            'user_id' => Auth::user()->id,
            'job_id' => $id,
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'resume' => $resume,
        ]);
        $inquiry->save();

        try {
            Mail::to(Auth::user())->send(new InquirySubmitted($job, Auth::user()));
            Mail::to(User::find($job->user_id))->send(new InquiryNotification($job, Auth::user(), User::find($job->user_id)));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        $request->session()->flash('message', new Message(
            "Thank you! We've received your résumé and you are being considered for the position.",
            "success"
        ));

        return redirect()->action('JobController@show', [$job]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showNotes($id)
    {
        $this->authorize('view-inquiry-notes');

        $notes = Note::inquiry($id)
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
        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            return abort(404);
        }

        $this->authorize('create-inquiry-note', $inquiry);

        $note = new Note();
        $note->user_id = Auth::user()->id;
        $note->notable_id = $id;
        $note->notable_type = "App\Inquiry";
        $note->content = request("note");
        $note->save();

        return response()->json([
            'type' => 'success',
            'content' => $note->content,
            'user' => Auth::user()
        ]);
    }
}
