<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactJob;
use App\Contact;
use App\ContactJob;
use App\Job;
use App\Message;
use App\Note;
use App\User;
use App\JobInterestResponse;
use App\Http\Requests\StoreJob;
use App\Mail\InquiryRated;
use App\Mail\InquirySubmitted;
use App\Mail\NewContactJobResponseNotification;
use App\Mail\NewContactJobAssignmentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

        if ($job->job_status_id == JOB_STATUS_ID['expired']) {
            return response()->json([
                'type' => 'failure',
                'message' => 'This job has expired. Contact can no longer be assigned.'
            ]);
        }

        $contact = Contact::find($request['contact_id']);
        if (!$contact || $contact->do_not_contact) {
            return response()->json([
                'type' => 'failure',
                'message' => 'Unable to assign contact.'
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
            $contact_job->generateJobInterestToken();
            $contact_job->save();

            $note->user_id = Auth::user()->id;
            $note->notable_id = $contact_job->contact->id;
            $note->notable_type = "App\Contact";
            $note->content = "Assigned to " . $contact_job->job->title . " [id:" . $contact_job->job->id . "].";
            $note->save();

            return $contact_job;
        });

        try {
            if ($job->user && !$job->user->can('view-admin-dashboard')) {
                Mail::to($job->user)->send(new NewContactJobAssignmentNotification($job, $contact_job, $job->user));
            }
        } catch (\Throwable $t) {
            Log::error($t);
        }

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

        if (!$contact_job || $contact_job->pipeline_id > 1 ) {
            return response()->json([
                'type' => 'failure',
                'message' => 'Unable to find requested job contact relationship or the user has progressed in the pipeline.'
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

    public function feedback(Request $request, $id)
    {
        $token = $request->input('token');
        $interest_code = $request->input('interest');

        $request_type = ((preg_match('/user-assigned/', $request->getPathInfo())) ? 'user-assigned' : 'contact');

        if (is_null($token) || is_null($id) || is_null($interest_code)) {
            return redirect('/');
        }
        
        $contact_job = ContactJob::where([
            ['id','=',$id],
            ['job_interest_token','=',$token]
        ])->first();

        if (is_null($contact_job)) {
            return redirect('/');
        }

        if (!is_null($contact_job->job_interest_response_code) && !$request->input('override')) {
            return view('job/feedback/' . $request_type . '/default-expired-code', [
                'contact_job' => $contact_job
            ]);
        }

        $job_interest_response = JobInterestResponse::where('code','=',$interest_code)->first();

        $contact_job->job_interest_response_code = $job_interest_response->code;
        $contact_job->job_interest_response_date = new \DateTime('now');
        $contact_job->save();

        try {
            Mail::to($contact_job->job->user)->send(new NewContactJobResponseNotification($contact_job->job, $contact_job, $contact_job->job->user));
        } catch (\Throwable $t) {
            Log::error($t);
        }

        if ($job_interest_response->code == 'interested') {
            return view('job/feedback/' . $request_type . '/default-interested', [
                'contact_job' => $contact_job
            ]);
        } elseif ($job_interest_response->code == 'not-interested') {
            return view('job/feedback/' . $request_type . '/default-not-interested', [
                'contact_job' => $contact_job
            ]);
        } elseif ($job_interest_response->code == 'do-not-contact' && $request_type == 'contact') {
            $contact = $contact_job->contact;

            $contact->do_not_contact = true;
            $contact->save();

            return view('job/feedback/contact/default-do-not-contact', [
                'contact_job' => $contact_job
            ]);
        }
        return redirect('/');
    }

    public function feedbackNegativeReason(Request $request, $id)
    {
        $negative_interest_reasons = array('dream-job', 'recently-promoted', 'cant-leave-team-city', 'dislike-team-city', 'personal-reasons', 'other');

        $token = $request->input('token');
        $negative_interest_reason = $request->input('negative_interest_reason');

        $request_type = ((preg_match('/user-assigned/', $request->getPathInfo())) ? 'user-assigned' : 'contact');

        if (is_null($token) || is_null($id) || !in_array($negative_interest_reason, $negative_interest_reasons)) {
            return redirect('/');
        }
        
        $contact_job = ContactJob::where([
            ['id','=',$id],
            ['job_interest_token','=',$token]
        ])->first();

        if (is_null($contact_job)) {
            return redirect('/');
        }

        $contact_job->job_interest_response_code = 'not-interested';
        $contact_job->job_interest_negative_response = $negative_interest_reason;
        $contact_job->save();

        $request->session()->flash('message', new Message(
            "Thank you for your feedback!",
            "success",
            $code = null,
            $icon = "check_circle"
        ));

        return view('job/feedback/' . $request_type . '/default-thank-you', [
            'contact_job' => $contact_job
        ]);
    }
}
