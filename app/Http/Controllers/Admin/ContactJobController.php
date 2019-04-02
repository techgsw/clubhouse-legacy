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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;

class ContactJobController extends Controller
{
    public function pipelineForward(Request $request)
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

                $contact_job = DB::transaction(function () use ($contact_job, $job_pipeline) {
                    $contact_job->pipeline_id += 1;
                    $contact_job->status = null;
                    $contact_job->reason = null;
                    $contact_job->save();

                    $this->createNote(
                        $contact_job->id,
                        "Moved forward from " . $job_pipeline[$contact_job->pipeline_id-2]->name . " to " . $job_pipeline[$contact_job->pipeline_id-1]->name . "."
                    );

                    if ($contact_job->pipeline_id == 2) {
                        try {
                            if ($contact_job->job->recruiting_type_code == "active") {
                                if ($request->input('comm_type') == "warm") {
                                    Mail::to($contact_job->contact)->send(new ContactWarmComm($contact_job));

                                } else if ($request->input('comm_type') == 'cold'){
                                    Mail::to($contact_job->contact)->send(new ContactColdComm($contact_job));                                
                                }
                            }
                        } catch (Exception $e) {
                            Log::error($e->getMessage());
                        }
                    }

                    return $contact_job;
                });
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
        } else if ($contact_job->status == 'halted') {
            return response()->json([
                'type' => 'success',
                'contact_id' => $request->input('id'),
                'pipeline_id' => $contact_job->pipeline_id,
                'pipeline_name' => $contact_job->job_pipeline->name,
                'status' => $contact_job->status,
            ]);
        }
        try {
            $contact_job = DB::transaction(function () use ($contact_job, $job_pipeline, $request) {
                $contact_job->status = 'halted';
                $contact_job->reason = $request->reason;
                $contact_job->save();

                $this->createNote(
                    $contact_job->id,
                    "Halted on " . $job_pipeline[$contact_job->pipeline_id-1]->name . ". Reason: ". strtoupper($request->input('reason'))
                );

                return $contact_job;
            });
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
        } elseif ($contact_job->status == 'paused') {
            return response()->json([
                'type' => 'success',
                'contact_id' => $request->input('id'),
                'pipeline_id' => $contact_job->pipeline_id,
                'pipeline_name' => $contact_job->job_pipeline->name,
                'status' => $contact_job->status,
            ]);
        }
        try {
            $contact_job = DB::transaction(function () use ($contact_job, $job_pipeline) {
                $contact_job->status = 'paused';
                $contact_job->reason = null;
                $contact_job->save();

                $this->createNote(
                    $contact_job->id,
                    "Paused on " . $job_pipeline[$contact_job->pipeline_id-1]->name . "."
                );

                return $contact_job;
            });
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
            $contact_job = DB::transaction(function () use ($contact_job, $job_pipeline) {
                $contact_job->pipeline_id -= 1;
                $contact_job->status = null;
                $contact_job->reason = null;
                $contact_job->save();

                $this->createNote(
                    $contact_job->id,
                    "Moved backwards from " . $job_pipeline[$contact_job->pipeline_id]->name . " to " . $job_pipeline[$contact_job->pipeline_id-1]->name  . "."
                );

                return $contact_job;
            });
        } catch (\Exception $e) {
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

    public function createNote($contact_job_id, $content)
    {
        $this->authorize('create-contact-note');

        $contact = ContactJob::find($contact_job_id);
        if (!$contact) {
            throw new \Exception('Note creation failed');
        }

        $note = new Note();
        $note->user_id = Auth::user()->id;
        $note->notable_id = $contact_job_id;
        $note->notable_type = "App\ContactJob";
        $note->content = $content;
        $note->save();

        return response()->json([
            'type' => 'success',
            'content' => $note->content,
            'user' => Auth::user()
        ]);
    }
}
