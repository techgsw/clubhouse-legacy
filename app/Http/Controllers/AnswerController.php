<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\User;
use App\Http\Requests\StoreAnswer;
use App\Mail\AnswerSubmitted;
use App\Mail\InternalAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mail;

class AnswerController extends Controller
{
    /**
     * Get a validator for the reCAPTCHA on answer create
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['recaptcha'] = $this->recaptchaCheck($data);

        $rules = [
            'g-recaptcha-response' => 'required',
            'recaptcha' => 'required|min:1'
        ];

        $messages = [
            'g-recaptcha-response.required' => 'Please check the reCAPTCHA box to verify you are a human!',
            'recaptcha.required' => 'Please check the reCAPTCHA box to verify you are a human!',
            'recaptcha.min' => 'Please check the reCAPTCHA box to verify you are a human!',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * @param  StoreAnswer  $request
     * @return Response
     */
    public function store(StoreAnswer $request, $id)
    {
        $this->validator($request->all())->validate();

        $question = Question::find($id);
        if (!$question) {
            return redirect()->back()->withErrors(['msg' => 'Could not find question ' . $id]);
        }

        //TODO: we don't need to record user_id, could record IP address in the future
        $answer = Answer::create([
            'user_id' => 1,
            'question_id' => $id,
            'answer' => request('answer'),
            'approved' => null
        ]);

        try {
            Mail::to('clubhouse@sportsbusiness.solutions')->send(
                new InternalAlert(
                    'emails.internal.answer',
                    array(
                        'answer' => $answer,
                        'question' => $question
                    )
                )
            );
        } catch (Exception $e) {
            Log::error($e);
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
