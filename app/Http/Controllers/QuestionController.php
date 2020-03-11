<?php

namespace App\Http\Controllers;

use App\Question;
use App\Traits\ReCaptchaTrait;
use App\User;
use App\Http\Requests\StoreQuestion;
use App\Http\Requests\UpdateQuestion;
use App\Mail\InternalAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mail;

/**
 * This class is being leveraged to display the "Mental Health Discussion Board" on the #SameHere page
 *
 * Class QuestionController
 * @package App\Http\Controllers
 */
class QuestionController extends Controller
{
    use ReCaptchaTrait;

    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $questions = Question::search($request)
            // TODO: There are some older questions from when this was a general Q&A board
            //  we should confirm that we don't care about any of these before removing them
            ->where('created_at', '>=', new \DateTime('2020-03-11 00:00:00'))

            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $breadcrumb = [
            'Clubhouse' => '/',
            '#SameHere' => '/same-here',
            'Mental Health Discussion Board' => '/same-here/discussion'
        ];
        if ($search = request('search')) {
            $breadcrumb["Searching \"{$search}\""] = "/question?search={$search}";
        }

        return view('question/index', [
            'breadcrumb' => $breadcrumb,
            'questions' => $questions
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question/create', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                '#SameHere' => '/same-here',
                'Mental Health Discussion Board' => '/same-here/discussion',
                'Ask a question' => '/same-here/discussion/create'
            ]
        ]);
    }

    /**
     * Get a validator for the reCAPTCHA on question create
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
     * @param  StoreQuestion  $request
     * @return Response
     */
    public function store(StoreQuestion $request)
    {
        $this->validator($request->all())->validate();

        //TODO: we don't need to record user_id, could record IP address in the future
        $question = Question::create([
            'user_id' => 1,
            'title' => request('title'),
            'body' => request('body')
        ]);

        // TODO Global constant
        $bob = User::find(1);

        try {
            Mail::to('clubhouse@sportsbusiness.solutions')->send(
                new InternalAlert(
                    'emails.internal.question-submitted',
                    array(
                        'question' => $question,
                        'user' => null
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
    public function show($id)
    {
        $question = Question::find($id);
        if (!$question ||
            (!(Auth::user() && Auth::user()->can('approve-question')) && (!is_null($question->approved) && $question->approved == false))
        ) {
            return abort(404);
        }

        $answers = $question->answers;

        return view('question/show', [
            'question' => $question,
            'answers' => $answers,
            'breadcrumb' => [
                'Clubhouse' => '/',
                '#SameHere' => '/same-here',
                'Mental Health Discussion Board' => '/same-here/discussion',
                "{$question->title}" => "/same-here/discussion/{$question->id}"
            ]
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $this->authorize('approve-question');

        $question = Question::find($id);
        if (!$question) {
            return redirect()->back()->withErrors(['msg' => 'Could not find question ' . $id]);
        }
        $question->approved = true;
        $question->save();

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disapprove($id)
    {
        $this->authorize('approve-question');

        $question = Question::find($id);
        if (!$question) {
            return redirect()->back()->withErrors(['msg' => 'Could not find question ' . $id]);
        }
        $question->approved = false;
        $question->save();

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        $this->authorize('edit-question', $question);

        return view('question/edit', [
            'question' => $question,
            'breadcrumb' => [
                'Clubhouse' => '/',
                '#SameHere' => '/same-here',
                'Mental Health Discussion Board' => '/same-here/discussion',
                "Edit" => "/same-here/discussion/{$question->id}/edit"
            ]
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestion $request, $id)
    {
        $now = new \DateTime('NOW');

        $question = Question::find($id);
        $this->authorize('edit-question', $question);

        $question->title = request('title');
        $question->body = request('body');
        $question->edited_at = $now;
        $question->save();

        return redirect()->action('QuestionController@show', [$question]);
    }
}
