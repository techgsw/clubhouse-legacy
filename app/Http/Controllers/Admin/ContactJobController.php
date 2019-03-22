<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInquiry;
use App\ContactJob;
use App\Job;
use App\JobPipeline;
use App\Message;
use App\Note;
use App\User;
use App\Contact;
use App\Http\Requests\StoreJob;
use App\Mail\Admin\ContactColdComm;
use App\Mail\Admin\ContactWarmComm;
use App\Mail\InquiryContacted;
use App\Mail\InquirySubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class ContactJobController extends Controller
{
    public function pipelineForward(Request $request, $comm_type)
    {
        $this->authorize('edit-contact');

        $contact_job = ContactJob::find($request->input('id'));
        $job_pipeline = JobPipeline::all();

        if (!$contact_job) {
            return response()->json([
                'type' => 'failure',
                'message' => 'We failed!'
            ]);
        }

        $max_pipeline_step = JobPipeline::orderBy('pipeline_id', 'desc')->first();

        if ($contact_job->pipeline_id < $max_pipeline_step->pipeline_id) {
            try {

                $contact_job->pipeline_id += 1;
                $contact_job->status = null;
                $contact_job->save();

                ContactJobController::createNote(
                    $contact_job->contact->id,
                    "Moved forward from " . $job_pipeline[$contact_job->pipeline_id-2]->name . " to " . $job_pipeline[$contact_job->pipeline_id-1]->name . " [id: " . $contact_job->job->id . "]."
                );

                if ($contact_job->pipeline_id == 2) {
                    try {
                        if ($contact_job->job->recruiting_type_code == "active") {
                            if ($comm_type == "warm") {
                                Mail::to($contact_job->contact)->send(new ContactWarmComm($contact_job, 'active-positive'));

                            } else if ($comm_type == 'cold'){
                                Mail::to($contact_job->contact)->send(new ContactColdComm($contact_job, 'passive-positive'));                                
                            }
                        }
                    } catch (Exception $e) {
                        Log::error($e->getMessage());
                    }
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                return response()->json([
                    'type' => 'failure',
                    'message' => 'We failed!'
                ]);
            }
        }

        return response()->json([
            'type' => 'success',
            'contactJob_id' => $request->input('id'),
            'pipeline_id' => $contact_job->pipeline_id,
            'pipeline_name' => $contact_job->job_pipeline->name,
            'status' => $contact_job->status,
        ]);
    }

    public function pipelineHalt(Request $request)
    {
        $this->authorize('edit-contact');

        $contact_job = ContactJob::find($request->input('id'));
        $job_pipeline = JobPipeline::all();

        if (!$contact_job) {
            return response()->json([
                'type' => 'failure',
                'message' => 'We failed!'
            ]);
        }
        try {
            $contact_job->status = "halted";
            $contact_job->save();

            ContactJobController::createNote(
                $contact_job->contact->id,
                "Halted on " . $job_pipeline[$contact_job->pipeline_id-1]->name . " [id: " . $contact_job->job->id . "]."
            );

            if ($contact_job->pipeline_id == 1) {
                try {
                    switch ($contact_job->job->recruiting_type_code) {
                        case 'active':
                            Mail::to($contact_job->user)->send(new InquiryContacted($contact_job, 'active-negative'));
                            break;
                        case 'passive':
                            Mail::to($contact_job->user)->send(new InquiryContacted($contact_job, 'passive-negative'));
                            break;
                        default:
                            break;
                    }
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'type' => 'failure',
                'message' => 'We failed!'
            ]);
        }

        return response()->json([
            'type' => 'success',
            'contact_id' => $request->input('id'),
            'pipeline_id' => $contact_job->pipeline_id,
            'pipeline_name' => $contact_job->job_pipeline->name,
            'status' => $contact_job->status,
        ]);
    }

    public function pipelinePause(Request $request)
    {
        $this->authorize('edit-contact');

        $contact_job = ContactJob::find($request->input('id'));
        $job_pipeline = JobPipeline::all();

        if (!$contact_job) {
            return response()->json([
                'type' => 'failure',
                'message' => 'We failed!'
            ]);
        }
        try {
            $contact_job->status = "paused";
            $contact_job->save();

            ContactJobController::createNote(
                $contact_job->contact->id,
                "Paused on " . $job_pipeline[$contact_job->pipeline_id-1]->name . " [id: " . $contact_job->job->id . "]."
            );

            if ($contact_job->pipeline_id == 1) {
                try {
                    switch ($contact_job->job->recruiting_type_code) {
                        case 'active':
                            Mail::to($contact_job->user)->send(new InquiryContacted($contact_job, 'active-maybe'));
                            break;
                        case 'passive':
                            Mail::to($contact_job->user)->send(new InquiryContacted($contact_job, 'passive-maybe'));
                            break;
                        default:
                            break;
                    }
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'type' => 'failure',
                'message' => 'We failed!'
            ]);
        }

        return response()->json([
            'type' => 'success',
            'contact_id' => $request->input('id'),
            'pipeline_id' => $contact_job->pipeline_id,
            'pipeline_name' => $contact_job->job_pipeline->name,
            'status' => $contact_job->status,
        ]);
    }

    public function pipelineBackward(Request $request)
    {
        $this->authorize('edit-contact');

        $contact_job = ContactJob::find($request->input('id'));
        $job_pipeline = JobPipeline::all();

        if (!$contact_job) {
            return response()->json([
                'type' => 'danger',
                'message' => 'Unable to find contact!'
            ]);
        }

        if ($contact_job->pipeline_id < 3) {
            return response()->json([
                'type' => 'danger',
                'message' => 'Cannot go backwards!'
            ]);
        }

        try {
            $contact_job->pipeline_id -= 1;
            $contact_job->status = null;
            $contact_job->save();

            ContactJobController::createNote(
                $contact_job->contact->id,
                "Moved backwards from " . $job_pipeline[$contact_job->pipeline_id]->name . " to " . $job_pipeline[$contact_job->pipeline_id-1]->name  . " [id:" . $contact_job->job->id . "]."
            );
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'type' => 'danger',
                'message' => 'We failed!'
            ]);
        }

        return response()->json([
            'type' => 'success',
            'contact_id' => $request->input('id'),
            'pipeline_id' => $contact_job->pipeline_id,
            'pipeline_name' => $contact_job->job_pipeline->name,
            'status' => $contact_job->status,
        ]);
    }

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

    public function createNote($id, $content)
    {
        $this->authorize('create-contact-note');

        $contact = Contact::find($id);
        if (!$contact) {
            return abort(404);
        }

        $note = new Note();
        $note->user_id = Auth::user()->id;
        $note->notable_id = $id;
        $note->notable_type = "App\Contact";
        $note->content = $content;
        $note->save();

        return response()->json([
            'type' => 'success',
            'content' => $note->content,
            'user' => Auth::user()
        ]);
    }
}
