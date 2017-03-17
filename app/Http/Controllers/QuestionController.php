<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Question;
use App\Http\Requests\StoreQuestion;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();

        return $questions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question/create', [
            'breadcrumb' => ['Home' => '/', 'Q&A' => '/question']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * TODO figure out how to use App\Http\Requests\StoreQuestion
     * Getting Exception "Class App\Http\Controllers\App\Http\Requests\StoreQuestion does not exist"
     *
     * @param  StoreQuestion  $request
     * @return Response
     */
    public function store(StoreQuestion $request)
    {
        /*
        // TODO remove this once FormRequest class is fixed
        $this->validate($request, [
            'question' => 'required'
        ]);
        */

        $question = Question::create([
            'user_id' => Auth::user()->id,
            'question' => request('question')
        ]);

        return redirect()->action('QuestionController@show', [$question]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return abort(404);
        }


        $answers = [];  // TODO

        return view('question/show', [
            'question' => $question,
            'answers' => $answers,
            'breadcrumb' => ['Home' => '/', 'Q&A' => '/question']
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);

        return view('question/edit', [
            'question' => $question
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::find($id);
        $question->question = request('question');
        $question->save();

        return redirect()->action('QuestionController@show', [$question]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO
    }
}
