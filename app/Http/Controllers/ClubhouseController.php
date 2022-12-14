<?php

namespace App\Http\Controllers;

use App\ContactOrganization;
use App\Job;
use App\Mentor;
use App\Organization;
use App\Post;
use App\Product;
use App\Message;
use App\ProductOption;
use App\Question;
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
        $posts = Post::search($request)->where('post_type_code', 'blog')->orderby('id', 'DESC')->limit(3)->get();

        $mentors = Mentor::with('contact')
            ->where('active', true)
            ->inRandomOrder()
            ->limit(20)
            ->get();

        $webinars = Product::where('active', true)->with('options')->whereHas('tags', function ($query) {
            $query->where('name', 'Webinar');
        })->limit(2)->get();

        $jobs = Job::where('job_status_id', JOB_STATUS_ID['open'])
            ->orderBy('featured', 'desc')
            ->inRandomOrder()
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

    public function proMembership(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/register');
        }

        $user = Auth::user();

        $monthly_membership_option = ProductOption::whereHas('product', function ($query) {
            $query->where('name', 'Clubhouse Pro Membership');
        })->where('name', 'Clubhouse Pro Membership')->first();

        $annual_membership_option = ProductOption::whereHas('product', function ($query) {
            $query->where('name', 'Clubhouse Pro Membership');
        })->where('name', 'Clubhouse Pro Membership Annual')->first();

        return view('clubhouse/pro-membership', [
            'monthly_membership_option' => $monthly_membership_option,
            'annual_membership_option' => $annual_membership_option,
            'user' => $user,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Pro Membership' => '/pro-membership'
            ],
        ]);
    }

    public function applyForProMembership(Request $request)
    {
        $user = Auth::user();

        try {
            if ($request->title || $request->organization) {
                if ($request->title) {
                    $user->contact->title = $request->title;
                }
                if ($request->organization) {
                    $user->contact->organization = $request->organization;
                    $user->contact->save();
                    $organization = Organization::where('name', $request->organization)->first();
                    if (!is_null($organization)) {
                        ContactOrganization::create([
                            'contact_id' => $user->contact->id,
                            'organization_id' => $organization->id
                        ]);
                    }
                }
                $user->contact->save();
            }
            $years_worked = null;
            $planned_services = array();
            foreach ($request->all() as $key => $parameter) {
                if (strpos($key, 'services-') !== false) {
                    $planned_services [] = substr($key, 9);
                } else if (strpos($key, 'years-worked-') !== false) {
                    $years_worked = substr($key, 13);
                }
            }

            if (!is_null($years_worked) || !empty($planned_services)) {
                if (!is_null($years_worked)) {
                    $user->profile->works_in_sports_years_range = $years_worked;
                }
                if (!empty($planned_services)) {
                    $user->profile->planned_services = $planned_services;
                }
                $user->profile->save();
            }
        } catch (Exception $e) {
            // don't hinder the user if we have issues collecting data
            Log::error($e);
        }

        if ($request->buy_monthly) {
            return redirect()->to($request->buy_monthly);
        } else if ($request->buy_annually) {
            return redirect()->to($request->buy_annually);
        }
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

    public function salesVault(Request $request)
    {
        $newest_training_videos = Product::whereHas('tags', function ($query) {
            $query->where('name', 'Training Video');
        })->orderBy('created_at', 'DESC')->limit(3)->get();

        $training_video_books= ProductOption::whereHas('product.tags', function($query) {
            $query->where('name', 'Training Video');
        })->distinct()->get(['name']);

        $questions = Question::where('context', 'sales-vault')
            ->orderBy('created_at', 'DESC')
            ->paginate(2);

        return view('clubhouse/sales-vault', [
            'training_video_books' => $training_video_books,
            'newest_training_videos' => $newest_training_videos,
            'questions' => $questions,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Training' => '/training'
            ],
        ]);
    }
}
