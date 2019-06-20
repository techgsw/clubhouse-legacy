<?php

namespace App\Http\Controllers;

use App\Job;
use App\Mentor;
use App\Post;
use App\Product;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Parsedown;
use \Exception;

class ClubhouseController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::where('post_type_code', 'blog')->orderby('id', 'DESC')->limit(3)->get();

        $mentors = Mentor::with('contact')
            ->where('active', true)
            ->limit(20)
            ->get();

        $webinars = Product::where('active', true)->with('options')->whereHas('tags', function ($query) {
            $query->where('name', 'Webinar');
        })->limit(2)->get();

        $jobs = Job::orderBy('featured', 'desc')
            ->orderBy('rank', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();


        return view('clubhouse/index', [
            'posts' => $posts,
            'mentors' => $mentors,
            'webinars' => $webinars,
            'jobs' => $jobs
        ]);
    }

    public function jobOptions(Request $request)
    {
        $job_featured = Product::with('tags')->whereHas('tags', function ($query) {
            $query->where('name', 'Job Featured');
        })->first();

        $job_platinum = Product::with('tags')->whereHas('tags', function ($query) {
            $query->where('name', 'Job Platinum');
        })->first();

        return view('clubhouse/job-options', [
            'job_featured' => $job_featured,
            'job_platinum' => $job_platinum,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Job Posting Options' => '/job-options'
            ],
        ]);
    }

    public function membershipOptions(Request $request)
    {
        $product = Product::with('tags')->whereHas('tags', function ($query) {
            $query->where('name', 'Membership');
        })->first();

        return view('clubhouse/membership-options', [
            'product' => $product,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Membership Options' => '/membership-options'
            ],
        ]);
    }

    public function proMembership(Request $request)
    {
        $product = Product::with('tags')->whereHas('tags', function ($query) {
            $query->where('name', 'Membership');
        })->first();

        return view('clubhouse/pro-membership', [
            'product' => $product,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Pro Membership' => '/pro-membership'
            ],
        ]);
    }

    public function resources(Request $request)
    {
        return view('clubhouse/resources', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Resources' => '/resources'
            ],
        ]);
    }
}
