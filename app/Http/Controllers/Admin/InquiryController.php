<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInquiry;
use App\Inquiry;
use App\Job;
use App\JobPipeline;
use App\Message;
use App\Note;
use App\User;
use App\Http\Requests\StoreJob;
use App\Mail\InquiryContacted;
use App\Mail\InquirySubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class InquiryController extends Controller
{
    public function pipelineForward(Request $request, $comm_type)
    {
        $this->authorize('edit-inquiry');

        $inquiry = Inquiry::find($request->input('id'));
        $job_pipeline = JobPipeline::all();

        if (!$inquiry) {
            return response()->json([
                'type' => 'failure',
                'message' => 'We failed!'
            ]);
        }

        $max_pipeline_step = JobPipeline::orderBy('pipeline_id', 'desc')->first();

        if ($inquiry->pipeline_id < $max_pipeline_step->pipeline_id) {
            try {
                $inquiry->pipeline_id += 1;
                $inquiry->status = null;
                $inquiry->save();

                InquiryController::createNote(
                    $inquiry->id,
                    "Moved forward from " . $job_pipeline[$inquiry->pipeline_id-2]->name . " to " . $job_pipeline[$inquiry->pipeline_id-1]->name . " [id: " . $inquiry->job->id . "]."
                );

                if ($inquiry->pipeline_id == 2) {
                    try {
                        switch ($inquiry->job->recruiting_type_code) {
                            case 'active':
                                Mail::to($inquiry->user)->send(new InquiryContacted($inquiry, 'active-positive'));
                                break;
                            case 'passive':
                                Mail::to($inquiry->user)->send(new InquiryContacted($inquiry, 'passive-positive'));
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
        }

        return response()->json([
            'type' => 'success',
            'inquiry_id' => $request->input('id'),
            'pipeline_id' => $inquiry->pipeline_id,
            'pipeline_name' => $inquiry->job_pipeline->name,
            'status' => $inquiry->status,
        ]);
    }

    public function pipelineHalt(Request $request)
    {
        $this->authorize('edit-inquiry');

        $inquiry = Inquiry::find($request->input('id'));
        $job_pipeline = JobPipeline::all();

        if (!$inquiry) {
            return response()->json([
                'type' => 'failure',
                'message' => 'We failed!'
            ]);
        }
        try {
            $inquiry->status = "halted";
            $inquiry->save();

            InquiryController::createNote(
                $inquiry->id,
                "Halted on " . $job_pipeline[$inquiry->pipeline_id-1]->name . " [id: " . $inquiry->job->id . "]."
            );

            if ($inquiry->pipeline_id == 1) {
                try {
                    switch ($inquiry->job->recruiting_type_code) {
                        case 'active':
                            Mail::to($inquiry->user)->send(new InquiryContacted($inquiry, 'active-negative'));
                            break;
                        case 'passive':
                            Mail::to($inquiry->user)->send(new InquiryContacted($inquiry, 'passive-negative'));
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
            'inquiry_id' => $request->input('id'),
            'pipeline_id' => $inquiry->pipeline_id,
            'pipeline_name' => $inquiry->job_pipeline->name,
            'status' => $inquiry->status,
        ]);
    }

    public function pipelinePause(Request $request)
    {
        $this->authorize('edit-inquiry');

        $inquiry = Inquiry::find($request->input('id'));
        $job_pipeline = JobPipeline::all();

        if (!$inquiry) {
            return response()->json([
                'type' => 'failure',
                'message' => 'We failed!'
            ]);
        }
        try {
            $inquiry->status = "paused";
            $inquiry->save();

            InquiryController::createNote(
                $inquiry->id,
                "Paused on " . $job_pipeline[$inquiry->pipeline_id-1]->name . " [id: " . $inquiry->job->id . "]."
            );

            if ($inquiry->pipeline_id == 1) {
                try {
                    switch ($inquiry->job->recruiting_type_code) {
                        case 'active':
                            Mail::to($inquiry->user)->send(new InquiryContacted($inquiry, 'active-maybe'));
                            break;
                        case 'passive':
                            Mail::to($inquiry->user)->send(new InquiryContacted($inquiry, 'passive-maybe'));
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
            'inquiry_id' => $request->input('id'),
            'pipeline_id' => $inquiry->pipeline_id,
            'pipeline_name' => $inquiry->job_pipeline->name,
            'status' => $inquiry->status,
        ]);
    }

    public function pipelineBackward(Request $request)
    {
        $this->authorize('edit-inquiry');

        $inquiry = Inquiry::find($request->input('id'));
        $job_pipeline = JobPipeline::all();

        if (!$inquiry) {
            return response()->json([
                'type' => 'danger',
                'message' => 'Unable to find inquiry!'
            ]);
        }

        if ($inquiry->pipeline_id < 3) {
            return response()->json([
                'type' => 'danger',
                'message' => 'Cannot go backwards!'
            ]);
        }

        try {
            $inquiry->pipeline_id -= 1;
            $inquiry->status = null;
            $inquiry->save();

            InquiryController::createNote(
                $inquiry->id,
                "Moved backwards from " . $job_pipeline[$inquiry->pipeline_id]->name . " to " . $job_pipeline[$inquiry->pipeline_id-1]->name  . " [id:" . $inquiry->job->id . "]."
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
            'inquiry_id' => $request->input('id'),
            'pipeline_id' => $inquiry->pipeline_id,
            'pipeline_name' => $inquiry->job_pipeline->name,
            'status' => $inquiry->status,
        ]);
    }

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

    public function createNote($id, $content)
    {
        $this->authorize('create-inquiry-note');

        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            return abort(404);
        }

        $note = new Note();
        $note->user_id = Auth::user()->id;
        $note->notable_id = $id;
        $note->notable_type = "App\Inquiry";
        $note->content = $content;
        $note->save();

        return response()->json([
            'type' => 'success',
            'content' => $note->content,
            'user' => Auth::user()
        ]);
    }
}
