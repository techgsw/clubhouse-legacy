<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Job;
use App\Post;
use App\Question;
use App\Answer;
use App\User;
use App\Providers\EmailServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-admin-dashboard');

        $contact_count = Contact::all()->count();
        $user_count = User::all()->count();
        $question_count = Question::all()->count();
        $answer_count = Answer::all()->count();
        $job_count = Job::all()->count();
        $post_count = Post::all()->count();

        return view('admin.index', [
            'contact_count' => $contact_count,
            'user_count' => $user_count,
            'question_count' => $question_count,
            'answer_count' => $question_count,
            'job_count' => $job_count,
            'post_count' => $post_count,
        ]);
    }
}
