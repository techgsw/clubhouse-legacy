<?php

namespace App\Http\Controllers;

use App\Job;
use App\Mentor;
use App\Post;
use App\Product;
use App\Message;
use App\ProductOption;
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
            ->orderBy(\DB::raw('RAND()'))
            ->limit(20)
            ->get();

        $webinars = Product::where('active', true)->with('options')->whereHas('tags', function ($query) {
            $query->where('name', 'Webinar');
        })->limit(2)->get();

        $jobs = Job::where('job_status_id', JOB_STATUS_ID['open'])
            ->orderBy('featured', 'desc')
            ->orderBy(\DB::raw('RAND()'))
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
        $job_premium = Product::find(PRODUCT_ID['premium_job']);
        $job_platinum = Product::find(PRODUCT_ID['platinum_job']);

        if (!is_null($request->job_id)) {
            $job = Job::where('id',$request->job_id)->first();
            if ($request->option_type == 'upgrade_options') {
                return view('clubhouse/job-options-upgrade', [
                    'job' => $job,
                    'job_platinum' => $job_platinum,
                    'job_premium' => $job_premium
                ]);
            } elseif ($request->option_type == 'extend_options') {
                $job_extension = ProductOption::find(PRODUCT_OPTION_ID['job_extension']);
                return view('clubhouse/job-options-extend', [
                    'job' => $job,
                    'job_extension' => $job_extension,
                    'job_type_id' => $job->job_type_id
                ]);
            }
        }

        return view('clubhouse/job-options', [
            'job_premium' => $job_premium,
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
        if (Auth::guest()) {
            return redirect('/register?type=pro');
        }

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
