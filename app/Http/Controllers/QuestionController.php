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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $questions = Question::search($request)
            ->where('context', $this->context)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $breadcrumb = ['Clubhouse' => '/'];
        if ($this->context == 'same_here') {
            $breadcrumb['#SameHere'] = '/same-here';
            $breadcrumb['Mental Health Discussion Board'] = '/same-here/discussion';
        } else if ($this->context == 'sales_vault') {
            $breadcrumb['Sports Sales Vault'] = '/sales-vault';
            $breadcrumb['Sports Sales Discussion Board'] = '/sales-vault/discussions';
        }

        if ($search = request('search')) {
            $breadcrumb["Searching \"{$search}\""] = "/question?search={$search}";
        }

        return view('question/index', [
            'context' => $this->context,
            'breadcrumb' => $breadcrumb,
            'questions' => $questions
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->context == 'sales_vault' && !Auth::user()) {
            return abort(403);
        }

        $breadcrumb = ['Clubhouse' => '/'];
        if ($this->context == 'same-here') {
            $breadcrumb = [
                'Clubhouse' => '/',
                '#SameHere' => '/same-here',
                'Mental Health Discussion Board' => '/same-here/discussion',
                'Ask a question' => '/same-here/discussion/create'
            ];
        } else if ($this->context == 'sales-vault') {
            $breadcrumb = [
                'Clubhouse' => '/',
                'Sports Sales Vault' => '/sales-vault',
                'Sports Sales Discussion Board' => '/sales-vault/discussion',
                'Ask a question' => '/sales-vault/discussion/create'
            ];
        }

        return view('question/create', [
            'context' => $this->context,
            'breadcrumb' => $breadcrumb
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
     * @param  StoreQuestion  $request
     * @return Response
     */
    public function store(StoreQuestion $request)
    {
        $this->validator($request->all())->validate();

        if ($this->context == 'same-here') {
            //TODO: use something else in this field for anonymous questions??
            $user_id = 1;
        } else {
            if (!Auth::user()) {
                abort(403);
            }
            $user_id = Auth::user()->id;
        }

        $question = Question::create([
            'user_id' => $user_id,
            'title' => request('title'),
            'body' => request('body'),
            'approved' => true,
            'context' => $this->context
        ]);

        // TODO Global constant
        $bob = User::find(1);

        try {
            Mail::to('clubhouse@sportsbusiness.solutions')->send(
                new InternalAlert(
                    'emails.internal.question-submitted',
                    array(
                        'question' => $question,
                        'user' => null,
                        'context' => $this->context
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

        $breadcrumb = ['Clubhouse' => '/'];
        if ($this->context == 'same-here') {
            $breadcrumb = [
                'Clubhouse' => '/',
                '#SameHere' => '/same-here',
                'Mental Health Discussion Board' => '/same-here/discussion',
                "{$question->title}" => "/same-here/discussion/{$question->id}"
            ];
        } else if ($this->context == 'sales-vault') {
            $breadcrumb = [
                'Clubhouse' => '/',
                'Sports Sales Vault' => '/sales-vault',
                'Sports Sales Discussion Board' => '/sales-vault/discussion',
                "{$question->title}" => "/sales-vault/discussion/{$question->id}"
            ];
        }

        return view('question/show', [
            'question' => $question,
            'answers' => $answers,
            'context' => $this->context,
            'breadcrumb' => $breadcrumb
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
