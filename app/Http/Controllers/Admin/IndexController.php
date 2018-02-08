<?php

namespace App\Http\Controllers\Admin;

use App\Job;
use App\Post;
use App\Question;
use App\Answer;
use App\User;
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

        $user_count = User::all()->count();
        $question_count = Question::all()->count();
        $answer_count = Answer::all()->count();
        $job_count = Job::all()->count();
        $post_count = Post::all()->count();

        return view('admin.index', [
            'user_count' => $user_count,
            'question_count' => $question_count,
            'answer_count' => $question_count,
            'job_count' => $job_count,
            'post_count' => $post_count,
        ]);
    }

    public function allAdminUsers()
    {
        $this->authorize('view-admin-dashboard');
        
    }
}
