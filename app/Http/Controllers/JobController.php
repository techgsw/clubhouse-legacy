<?php

namespace App\Http\Controllers;

use App\Image;
use App\User;
use App\Inquiry;
use App\ContactJob;
use App\Job;
use App\Pipeline;
use App\Product;
use App\JobPipeline;
use App\League;
use App\Message;
use App\Organization;
use App\OrganizationType;
use App\Transaction;
use App\Providers\ImageServiceProvider;
use App\Providers\OrganizationServiceProvider;
use App\Providers\JobServiceProvider;
use App\Http\Requests\StoreJob;
use App\Http\Requests\UpdateJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Parsedown;
use \Exception;
use App\Exceptions\SBSException;

class JobController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Overwrite admin-only filters
        // (Enforcing in Job::filter)
        $request->merge([
            'status' => 'open',     // only open jobs
            'new-inquiries' => ''   // don't allow new-inquiries
        ]);

        $jobs = Job::filter($request)
            ->orderBy('featured', 'desc')
            ->orderBy('rank', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $featured_jobs = Job::where('open', '=', 1)->where('featured', '=', 1)->get()->all();
        $featured_jobs_count = count($featured_jobs);
        $random_featured_jobs = array();

        if ($featured_jobs_count > 0) {
            for ($i = 0; $i < 3 && $i < $featured_jobs_count; $i++) {
                $rand = rand(0, (count($featured_jobs) -1));
                $random_featured_jobs[] = $featured_jobs[$rand];
                unset($featured_jobs[$rand]);
                $featured_jobs = array_values($featured_jobs);
            }
        }

        $searching =
            request('job_type') && request('job_type') != 'all' ||
            request('league') && request('league') != 'all' ||
            request('state') && request('state') != 'all' ||
            request('organization');

        $pipeline = Pipeline::orderBy('id', 'asc')->get();
        
        return view('job/index', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Sports Industry Job Board' => Auth::user() && Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/job'
            ],
            'jobs' => $jobs,
            'featured_jobs' => $random_featured_jobs,
            'searching' => $searching,
            'pipeline' => $pipeline,
            'leagues' => League::all()
        ]);
    }

    public function register(Request $request)
    {
        return view('job/register',
        [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Sports Industry Job Board' => Auth::user() && Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/job'
            ],
        ]);
    }

    public function assignContact(Request $request)
    {
        $this->authorize('create-job');

        $request->merge([
            'status' => 'open',     // only open jobs
            'new-inquiries' => ''   // don't allow new-inquiries
        ]);

        $jobs = Job::filter($request)
            ->select('job.*', 'cj.job_id', 'cj.admin_user_id', 'cj.created_at', 'ua.first_name', 'ua.last_name')
            ->leftJoin('contact_job as cj', function($join) use ($request) {
                $join->on('job.id', '=', 'cj.job_id')
                    ->where('cj.contact_id', '=', $request['contact_id']);
            })
            ->leftJoin('user as ua', 'cj.admin_user_id', 'ua.id')
            ->orderBy('job.featured', 'desc')
            ->orderBy('job.rank', 'asc')
            ->orderBy('job.created_at', 'desc')
            ->get();

        return view('job/assign-contact', [
            'contact_id' => $request['contact_id'],
            'jobs' => $jobs,
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create-job');

        $user = Auth::User();

        if (count($user->contact->organizations) == 1) {

            $organization = $user->contact->organizations;

            if (count($organization[0]->leagues) > 0){
                $league = $organization[0]->leagues[0];
            } else {
                $league = null;
            }
        } else {
            $organization = null;
            $league = null;
        }

        if ($user->roles->contains('administrator')) {
            return view('job/create', [
                'organization' => $organization[0] ?: null,
                'organizations' => OrganizationServiceProvider::all(),
                'organization_types' => OrganizationType::orderBy('name')->get(),
                'league' => $league,
                'leagues' => League::orderBy('abbreviation')->get(),
                'available_premium_job_count' => 0,
                'available_platinum_job_count' => 0,
                'job_premium' => null,
                'job_platinum' => null,
                'breadcrumb' => [
                    'Clubouse' => '/',
                    'Sports Industry Job Board' => Auth::user() && Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/job',
                    'Post a job' => '/job/create'
                ]
            ]);
        } else {
            $available_premium_jobs = JobServiceProvider::getAvailablePaidJobs($user, 'Premium Job');
            $available_platinum_jobs = JobServiceProvider::getAvailablePaidJobs($user, 'Platinum Job');

            $job_premium = Product::with('tags')->whereHas('tags', function ($query) {
                $query->where('name', 'Job Premium');
            })->first();

            $job_platinum = Product::with('tags')->whereHas('tags', function ($query) {
                $query->where('name', 'Job Platinum');
            })->first();

            return view('job/create', [
                'organization' => $organization[0] ?: null,
                'organizations' => OrganizationServiceProvider::all(),
                'organization_types' => OrganizationType::orderBy('name')->get(),
                'league' => $league,
                'leagues' => League::orderBy('abbreviation')->get(),
                'available_premium_job_count' => count($available_premium_jobs),
                'available_platinum_job_count' => count($available_platinum_jobs),
                'job_premium' => $job_premium,
                'job_platinum' => $job_platinum,
                'breadcrumb' => [
                    'Home' => '/',
                    'Account' => "/user/{$user->id}/account",
                    'Job Postings' => "/user/{$user->id}/job-postings",
                    'Post a job' => '/job/create'
                ]
            ]);
        }
    }

    /**
     * @param  StoreJob  $request
     * @return Response
     */
    public function store(StoreJob $request)
    {
        $user = Auth::user();
        $document = request()->file('document');
        $alt_image = request()->file('alt_image_url');

        $organization = Organization::find($request->organization_id);

        if (!$user->roles->contains('administrator')) {
            $available_premium_jobs = JobServiceProvider::getAvailablePaidJobs($user, 'Premium Job');

            $available_platinum_jobs = JobServiceProvider::getAvailablePaidJobs($user, 'Platinum Job');

            if (count($available_platinum_jobs) && request('job-tier') == 'platinum') {
                $job_type_id = 4;
            } elseif (count($available_premium_jobs) && request('job-tier') == 'premium') {
                $job_type_id = 3;
            } else {
                $job_type_id = 2;
            }
        } else {
            $job_type_id = 1;

            $organizations = $user->contact->organizations;

            if (count($organizations) >= 1) {
                $valid_organization = false;
                foreach ($organizations as $user_organization) {
                    if ($ogranization->id == $user_organization) {
                        $valid_organization = true;
                    }
                }

                if (!$valid_organization) {
                    $request->session()->flash('message', new Message(
                        "Invalid organization selection.",
                        "danger",
                        $code = null,
                        $icon = "error"
                    ));
                    return back()->withInput();
                }
            }
        }

        $job = new Job([
            'user_id' => $user->id,
            'title' => request('title'),
            'description' => request('description'),
            'organization_id' => $organization->id,
            'job_type' => request('job_type'),
            'league' => $organization->leagues()->first()->abbreviation,
            'recruiting_type_code' => 'passive',
            'job_type_id' => $job_type_id,
            'city' => $organization->addresses()->first()->city,
            'state' => $organization->addresses()->first()->state,
            'country' => $organization->addresses()->first()->country,
            'featured' => request('featured') ? true : false,
            'document' => $document ?: null,
        ]);


        try {
            $job = DB::transaction(function () use ($job, $document, $alt_image, $user, $organization) {
                return JobServiceProvider::store($job, $document, $alt_image);
            });
        } catch (SBSException $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', new Message(
                $e->getMessage(),
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', new Message(
                "Sorry, failed to save the job. Please try again.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', new Message(
                "Sorry, failed to save the job. Please try again.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        if ($user->roles->contains('administrator')) {
            return redirect('/admin/job');
        } else {
            return redirect('/user/'.$user->id.'/job-postings');
        }
    }

    public function showPostings(Request $request)
    {
        $user = User::where('id', '=', $request->id)->first();

        $pipeline = Pipeline::orderBy('id', 'asc')->get();
        $job_pipeline = JobPipeline::orderBy('pipeline_id', 'asc')->get();

        if (Auth::user()->can('view-admin-jobs')) {
            $jobs = array();
        } else {
            $jobs = Job::where('user_id', '=', $user->id)->orderBy('id', 'desc')->get();
        }

        $job_platinum_upgrade = Product::with('tags')->whereHas('tags', function ($query) {
            $query->where('name', 'Job Platinum Upgrade');
        })->first();

        return view('user/job-postings', [
            'breadcrumb' => [
                'Home' => '/',
                'Job Postings' => "/user/{$user->id}/job-postings"
            ],
            'user' => $user,
            'jobs' => $jobs,
            'pipeline' => $pipeline,
            'job_pipeline' => $job_pipeline,
            'job_platinum_upgrade' => $job_platinum_upgrade,
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $job = Job::find($id);

        $pipeline = Pipeline::orderBy('id', 'asc')->get();

        $job_pipeline = JobPipeline::orderBy('pipeline_id', 'asc')->get();

        if (!$job) {
            return abort(404);
        }

        if (in_array($job->job_type_id, array(3, 4)) && Gate::allows('edit-job', $job)) {
            $contact_applications = ContactJob::filter($id, $request)
                ->paginate(10);
        } else {
            $contact_applications = [];
        }

        if (Gate::allows('edit-job', $job)) {
            $inquiries = Inquiry::filter($id, $request)
                ->paginate(10);
        } elseif (Auth::check()) {
            $inquiries = Inquiry::where('job_id', $id)
                ->where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $inquiries = [];
        }

        $profile_complete = false;
        $user = Auth::user();
        if ($user) {
            $profile_complete = $user->hasCompleteProfile();
        }

        $pd = new Parsedown;
        return view('job/show', [
            'description' => $pd->text($job->description),
            'job' => $job,
            'contact_applications' => $contact_applications,
            'inquiries' => $inquiries,
            'profile_complete' => $profile_complete,
            'pipeline' => $pipeline,
            'job_pipeline' => $job_pipeline,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'My Postings' => Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/user/'.Auth::user()->id.'/job-postings/',
                'Sports Industry Job Board' => '/job',
                "$job->title with $job->organization_name" => "/job/{$job->id}"
            ]
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function open($id)
    {
        // TODO check to see if the job has expired. can it be re-opened?
        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }

        $this->authorize('close-job', $job);

        $job->open = true;
        $job->edited_at = new \DateTime('NOW');
        $job->save();

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function close($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }

        $this->authorize('close-job', $job);

        $job->open = false;
        $job->edited_at = new \DateTime('NOW');
        $job->save();

        $job = Job::unfeature($id);

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }
        $this->authorize('edit-job', $job);

        $reuse_organization_fields =
            $job->organization_name == $job->organization->name &&
            $job->image_id == $job->organization->image_id;

        $pd = new Parsedown;
        return view('job/edit', [
            'job' => $job,
            'leagues' => League::all(),
            'reuse_organization_fields' => $reuse_organization_fields,
            'description' => $pd->text($job->description),
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Job Postings' => Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/user/'.Auth::user()->id.'/job-postings/',
                'Sports Industry Job Board' => '/job',
                "{$job->organization_name} - {$job->title}" => "/job/{$job->id}",
                "Edit" => "/job/{$job->id}/edit"
            ]
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJob $request, $id)
    {
        $job = Job::find($id);
        
        $organization = Organization::find($request->organization_id);
        if (!$organization) {
            $request->session()->flash('message', new Message(
                "Failed to find organization " . $request->organization_id,
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        if (request('reuse_organization_fields') && !$job->organization->image) {
            $request->session()->flash('message', new Message(
                "The selected organization does not have an image to use. Please upload one.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return redirect()->back();
        }

        try {
            $job = DB::transaction(function () use ($job, $organization, $request) {
                $job->organization_id = $organization->id;

                if (request('reuse_organization_fields')) {
                    // Already confirmed the org has an image
                    $organization_name = $organization->name;
                    $job->image_id = $organization->image_id;
                    $job->save();
                } else {
                    $organization_name = request('organization_name') ?: $organization->name;
                    if ($image_file = request()->file('image_url')) {
                        if ($job->image) {
                            $image = ImageServiceProvider::saveFileAsImage(
                                $image_file,
                                $filename = preg_replace('/\s/', '-', str_replace("/", "", $job->organization_name)).'-SportsBusinessSolutions',
                                $directory = 'job/'.$job->id
                            );
                        } else {
                            $image = ImageServiceProvider::saveFileAsImage(
                                $image_file,
                                $filename = preg_replace('/\s/', '-', str_replace("/", "", $job->organization_name)).'-SportsBusinessSolutions',
                                $directory = 'job/'.$job->id
                            );
                        }
                        $job->image_id = $image->id;
                        $job->save();
                    }
                }

                $job->title = request('title');
                if ($request->user()->can('edit-job-featured-status', $job)) {
                    $job->featured = request('featured') ? true : false;
                    if (!$job->featured) {
                        $job->rank = 0;
                    }
                }
                $job->description = request('description');
                $job->organization_name = $organization_name;
                $job->league = request('league');
                $job->job_type = request('job_type');
                if ($request->user()->can('edit-job-recruiting-type', $job)) {
                    $job->recruiting_type_code = request('recruiting_type_code');
                }
                $job->city = request('city');
                $job->state = request('state');
                $job->country = request('country');
                if ($request->user()->can('edit-job-featured-status', $job)) {
                    // Set rank if newly featured
                    if ($job->featured && $job->rank == 0) {
                        $rank = 1;
                        $last_job = Job::whereNotNull('rank')->orderBy('rank', 'desc')->first();
                        if ($last_job) {
                            $rank = $last_job->rank+1;
                        }
                        $job->rank = $rank;
                    }
                }

                if (request('document')) {
                    $doc = request()->file('document');
                    $job->document = $doc->store('document', 'public');
                }

                $job->edited_at = new \DateTime('NOW');
                $job->save();

                return $job;
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', new Message(
                "Sorry, the failed to save job. Please try again.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return redirect()->back();
        }

        $request->session()->flash('message', new Message(
            "Job updated",
            "success",
            $code = null,
            $icon = "check_circle"
        ));
        return redirect()->back();
    }

}
