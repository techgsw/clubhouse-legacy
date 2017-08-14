<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestion;
use App\Http\Requests\UpdateQuestion;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $questions = Question::search($request)->paginate(10);

        $breadcrumb = [
            'Home' => '/',
            'Q&A' => '/question',
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
        $this->authorize('create-question');

        return view('question/create', [
            'breadcrumb' => [
                'Home' => '/',
                'Q&A' => '/question',
                'Ask a question' => '/question/create'
            ]
        ]);
    }

    /**
     * @param  StoreQuestion  $request
     * @return Response
     */
    public function store(StoreQuestion $request)
    {
        $question = Question::create([
            'user_id' => Auth::user()->id,
            'title' => request('title'),
            'body' => request('body')
        ]);

        return redirect()->action('QuestionController@show', [$question]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return abort(404);
        }

        $answers = $question->answers;

        return view('question/show', [
            'question' => $question,
            'answers' => $answers,
            'breadcrumb' => [
                'Home' => '/',
                'Q&A' => '/question',
                "{$question->title}" => "/question/{$question->id}"
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
                'Home' => '/',
                'Q&A' => '/question',
                "Edit" => "/question/{$question->id}/edit"
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
