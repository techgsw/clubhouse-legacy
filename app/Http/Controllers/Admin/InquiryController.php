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
use App\Mail\InquiryRated;
use App\Mail\InquirySubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class InquiryController extends Controller
{
    public function pipelineForward(Request $request)
    {
        $this->authorize('edit-inquiry');

        $inquiry = Inquiry::find($request->input('id'));

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
                $inquiry->save();

                if ($inquiry->pipeline_id == 2) {
                    try {
                        switch ($inquiry->job->recruiting_type_code) {
                            case 'active':
                                Mail::to($inquiry->user)->send(new InquiryRated($inquiry, 'active-up'));
                                break;
                            case 'passive':
                                Mail::to($inquiry->user)->send(new InquiryRated($inquiry, 'passive-up'));
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
        ]);
    }

    public function pipelineBackward(Request $request)
    {
        $this->authorize('edit-inquiry');

        $inquiry = Inquiry::find($request->input('id'));

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
            $inquiry->save();
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
        ]);
    }

    public function rateMaybe($id)
    {
        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            return redirect()->back()->withErrors(['msg' => 'Could not find inquiry ' . $id]);
        }
        $this->authorize('edit-inquiry');

        $inquiry->rating = 0;
        $inquiry->save();

        try {
            switch ($inquiry->job->recruiting_type_code) {
                case 'active':
                    Mail::to($inquiry->user)->send(new InquiryRated($inquiry, 'active-maybe'));
                    break;
                case 'passive':
                    Mail::to($inquiry->user)->send(new InquiryRated($inquiry, 'passive-maybe'));
                    break;
                default:
                    break;
            }
        } catch (Exception $e) {
            // TODO log exception
        }

        return response()->json([
            'type' => 'success',
            'inquiry_id' => $id,
            'rating' => 0
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rateDown($id)
    {
        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            return redirect()->back()->withErrors(['msg' => 'Could not find inquiry ' . $id]);
        }
        $this->authorize('edit-inquiry');

        $inquiry->rating = -1;
        $inquiry->save();

        try {
            switch ($inquiry->job->recruiting_type_code) {
                case 'active':
                    Mail::to($inquiry->user)->send(new InquiryRated($inquiry, 'active-down'));
                    break;
                case 'passive':
                    Mail::to($inquiry->user)->send(new InquiryRated($inquiry, 'passive-down'));
                    break;
                default:
                    break;
            }
        } catch (Exception $e) {
            // TODO log exception
        }

        return response()->json([
            'type' => 'success',
            'inquiry_id' => $id,
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
        $this->authorize('create-inquiry-note');

        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            return abort(404);
        }

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
