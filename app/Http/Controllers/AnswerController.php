<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswer;
use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'answer' => request('answer')
        ]);

        return redirect()->action('QuestionController@show', [$question]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $answer = Answer::find($id);
        if (!$answer) {
            return redirect()->back()->withErrors(['msg' => 'Could not find answer ' . $id]);
        }
        $answer->approved = true;
        $answer->save();

        return redirect()->action('QuestionController@show', [$answer->question]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disapprove($id)
    {
        $answer = Answer::find($id);
        if (!$answer) {
            return redirect()->back()->withErrors(['msg' => 'Could not find answer ' . $id]);
        }
        $answer->approved = false;
        $answer->save();

        return redirect()->action('QuestionController@show', [$answer->question]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $answer = Answer::find($id);

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

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO
    }
}
