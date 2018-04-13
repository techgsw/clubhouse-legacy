<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Job;
use App\Post;
use App\Question;
use App\Answer;
use App\User;
use App\Note;
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
        $post_count = Post::where('post_type_code', 'blog')->count();
        $session_count = Post::where('post_type_code', 'session')->count();
        $total_note_count = Note::all()->count();
        $one_month_ago = (new \DateTime('now'))->sub(new \DateInterval('P30D'))->format('Y-m-d');
        $month_note_count = Note::where('created_at', '>', $one_month_ago)->count();

        return view('admin.index', [
            'contact_count' => $contact_count,
            'user_count' => $user_count,
            'question_count' => $question_count,
            'answer_count' => $question_count,
            'job_count' => $job_count,
            'post_count' => $post_count,
            'session_count' => $session_count,
            'total_note_count' => $total_note_count,
            'month_note_count' => $month_note_count
        ]);
    }
}
