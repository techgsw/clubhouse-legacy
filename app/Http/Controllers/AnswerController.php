<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\User;
use App\Http\Requests\StoreAnswer;
use App\Mail\AnswerSubmitted;
use App\Mail\BobAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class AnswerController extends Controller
{
    /**
     * @param  StoreAnswer  $request
     * @return Response
     */
    public function store(StoreAnswer $request, $id)
    {
        $question = Question::find($id);
        if (!$question) {
            return redirect()->back()->withErrors(['msg' => 'Could not find question ' . $id]);
        }

        $answer = Answer::create([
            'user_id' => Auth::user()->id,
            'question_id' => $id,
            'answer' => request('answer'),
            'approved' => true
        ]);

        try {
            Mail::to($question->user)->send(new AnswerSubmitted($answer, $question, $question->user));

            Mail::to('bob@sportsbusiness.solutions')->send(
                new BobAlert(
                    'emails.bob.answer',
                    array(
                        'user' => Auth::user(),
                        'answer' => $answer,
                        'question' => $question
                    )
                )
            );
        } catch (Exception $e) {
            // TODO log exception
        }

        return redirect()->action('QuestionController@show', [$question]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $this->authorize('approve-answer');

        $answer = Answer::find($id);
        if (!$answer) {
            return redirect()->back()->withErrors(['msg' => 'Could not find answer ' . $id]);
        }
        $answer->approved = true;
        $answer->save();

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disapprove($id)
    {
        $this->authorize('approve-answer');

        $answer = Answer::find($id);
        if (!$answer) {
            return redirect()->back()->withErrors(['msg' => 'Could not find answer ' . $id]);
        }
        $answer->approved = false;
        $answer->save();

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $answer = Answer::find($id);
        $this->authorize('edit-answer', $answer);

        return view('answer/edit', [
            'answer' => $answer
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $now = new \DateTime('NOW');

        $answer = Answer::find($id);
        $answer->answer = request('answer');
        $answer->edited_at = $now;
        $answer->save();

        return redirect()->action('QuestionController@show', [$answer->question]);
    }
}
