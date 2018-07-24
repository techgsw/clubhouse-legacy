<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Email;
use App\Image;
use App\Job;
use App\Mentor;
use App\Post;
use App\Product;
use App\Question;
use App\Answer;
use App\User;
use App\Note;
use App\Organization;
use App\Providers\EmailServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $follow_up_count = Contact::where('follow_up_user_id', Auth::user()->id)->count();
        $post_count = Post::all()->count();
        $today = (new \DateTime('now'))->format('Y-m-d 00:00:00');
        if (Auth::user()->id == 1) {
            $today_follow_up_count = Contact::where(\DB::raw('DATE(follow_up_date)'),'=',$today)->count();
            $overdue_follow_up_count = Contact::where(\DB::raw('DATE(follow_up_date)'),'<' ,$today)->count();
            $upcoming_follow_up_count = Contact::where(\DB::raw('DATE(follow_up_date)'),'>' ,$today)->count();
        } else {
            $today_follow_up_count = Contact::where('follow_up_user_id',Auth::user()->id)->where(\DB::raw('DATE(follow_up_date)'),'=',$today)->count();
            $overdue_follow_up_count = Contact::where('follow_up_user_id',Auth::user()->id)->where(\DB::raw('DATE(follow_up_date)'),'<' ,$today)->count();
            $upcoming_follow_up_count = Contact::where('follow_up_user_id',Auth::user()->id)->where(\DB::raw('DATE(follow_up_date)'),'>' ,$today)->count();
        }
        $image_count = Image::all()->count();
        $email_count = Email::all()->count();
        $organization_count = Organization::all()->count();
        $mentor_count = Mentor::where('active', true)->count();
        $product_count = Product::all()->count();

        return view('admin.index', [
            'contact_count' => $contact_count,
            'user_count' => $user_count,
            'question_count' => $question_count,
            'answer_count' => $question_count,
            'job_count' => $job_count,
            'post_count' => $post_count,
            'session_count' => $session_count,
            'total_note_count' => $total_note_count,
            'month_note_count' => $month_note_count,
            'follow_up_count' => $follow_up_count,
            'today_follow_up_count' => $today_follow_up_count,
            'overdue_follow_up_count' => $overdue_follow_up_count,
            'upcoming_follow_up_count' => $upcoming_follow_up_count,
            'image_count' => $image_count,
            'email_count' => $email_count,
            'organization_count' => $organization_count,
            'mentor_count' => $mentor_count,
            'product_count' => $product_count,
        ]);
    }
}
