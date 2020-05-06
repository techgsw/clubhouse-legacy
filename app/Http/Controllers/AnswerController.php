<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Traits\ReCaptchaTrait;
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
    use ReCaptchaTrait;

    protected $context;

    // TODO: prefixes instead of this url searching stuff?
    public function __construct(Request $request)
    {
        if ($request->is('same-here/*')) {
            $this->context = 'same-here';
        } else if ($request->is('sales-vault/*')) {
            $this->context = 'sales-vault';
        }
    }
    /**
     * Get a validator for the reCAPTCHA on answer create
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [];
        $messages = [];

        if ($this->context == 'same-here') {
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
        }

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

        if ($question->context == 'same-here') {
            //TODO: use something else in this field for anonymous questions??
            $user_id = 1;
        } else {
            if (!Auth::user()) {
                abort(403);
            }
            $user_id = Auth::user()->id;
        }

        $answer = Answer::create([
            'user_id' => $user_id,
            'question_id' => $id,
            'answer' => request('answer'),
            'approved' => true
        ]);

        try {
            Mail::to('clubhouse@sportsbusiness.solutions')->send(
                new InternalAlert(
                    'emails.internal.answer',
                    array(
                        'answer' => $answer,
                        'question' => $question,
                        'context' => $question->context
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
        $this->authorize('edit-answer', $answer);

        $answer = Answer::find($id);
        $answer->answer = request('answer');
        $answer->edited_at = $now;
        $answer->save();

        return redirect()->action('QuestionController@show', [$answer->question]);
    }
}
