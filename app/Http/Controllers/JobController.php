<?php

namespace App\Http\Controllers;

use App\Image;
use App\User;
use App\Inquiry;
use App\ContactJob;
use App\Job;
use App\Pipeline;
use App\JobPipeline;
use App\League;
use App\Message;
use App\Organization;
use App\OrganizationType;
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
                'organization_types' => OrganizationType::all(),
                'league' => $league,
                'leagues' => League::all(),
                'breadcrumb' => [
                    'Clubouse' => '/',
                    'Sports Industry Job Board' => Auth::user() && Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/job',
                    'Post a job' => '/job/create'
                ]
            ]);
        } else {
            return view('job/create', [
                'organization' => $organization[0] ?: null,
                'organizations' => OrganizationServiceProvider::all(),
                'organization_types' => OrganizationType::all(),
                'league' => $league,
                'leagues' => League::all(),
                'breadcrumb' => [
                    'Home' => '/',
                    'Account' => "/user/{$user->id}/account",
                    'Job Listings' => "/user/{$user->id}/job-postings",
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

        if ($user->can('create-platinum-user-job')) {
            $job_type_id = 4;
        } elseif ($user->can('create-featured-user-job')) {
            $job_type_id = 3;
        } else {
            $job_type_id = 2;
        }

        $job = new Job([
            'user_id' => $user->id,
            'title' => request('title'),
            'description' => request('description'),
            'organization_id' => $request->organization_id,
            'job_type' => request('job_type'),
            'league' => request('league'),
            'recruiting_type_code' => 'passive',
            'job_type_id' => $job_type_id,
            'city' => request('city'),
            'state' => request('state'),
            'country' => request('country'),
            'featured' => request('featured') ? true : false,
            'document' => $document ?: null,
        ]);

        $organization = Organization::find($request->organization_id);

        try {
            $job = DB::transaction(function () use ($job, $document, $alt_image, $user, $organization) {
                if (is_null($user->contact->organization) && !$user->roles->contains('administrator')) {
                    $user->contact->organizations()->attach($organization->id);
                    $user->contact->organization = $organization->name;
                    $user->contact->save();
                }
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
        //probably something to differeniate
        // return redirect()->action ('JobController@show', [$job]);

        return redirect('/user/'.$user->id.'/job-postings');
    }

    public function showPostings(Request $request)
    {
        $user = User::where('id', '=', $request->id)->first();

        $pipeline = Pipeline::orderBy('id', 'asc')->get();
        $job_pipeline = JobPipeline::orderBy('pipeline_id', 'asc')->get();
        $jobs = Job::where('user_id', '=', $user->id)->get();

        return view('admin/job-postings', [
            'breadcrumb' => [
                'Home' => '/',
                'Account' => "/user/{$user->id}/account"
            ],
            'user' => $user,
            'jobs' => $jobs,
            'pipeline' => $pipeline,
            'job_pipeline' => $job_pipeline,
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

        if (Gate::allows('view-admin-jobs')) {
            $contact_applications = ContactJob::filter($id, $request)
                ->paginate(10);
        } else {
            $contact_applications = [];
        }

        if (Gate::allows('view-admin-jobs')) {
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
                'Sports Industry Job Board' => Auth::user() && Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/job',
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
        $this->authorize('close-job');

        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }
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
        $this->authorize('close-job');

        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }
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
    public function feature($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }
        $this->authorize('edit-job', $job);

        // Insert at last rank, i.e. one greater than the highest current
        $rank = 1;
        $last_job = Job::whereNotNull('rank')->orderBy('rank', 'desc')->first();
        if ($last_job) {
            $rank = $last_job->rank+1;
        }

        $job->featured = true;
        $job->rank = $rank;
        $job->edited_at = new \DateTime('NOW');
        $job->save();

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unfeature($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }
        $this->authorize('edit-job', $job);

        $job = Job::unfeature($id);

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rankUp($id)
    {  
        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }
        $this->authorize('edit-job', $job);

        if ($job->rank <= 1) {
            return back();
        }

        $job->rank--;
        $job->edited_at = new \DateTime('NOW');
        $job->save();

        $neighbors = Job::where('id', '!=', $id)->where('rank', $job->rank)->get();
        if (!$neighbors) {
            return back();
        }
        foreach ($neighbors as $neighbor) {
            $neighbor->rank = $neighbor->rank+1;
            $neighbor->edited_at = new \DateTime('NOW');
            $neighbor->save();
        }

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rankTop($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }
        $this->authorize('edit-job', $job);

        $rank = $job->rank;
        if ($rank <= 1) {
            return back();
        }

        $job->rank = 1;
        $job->edited_at = new \DateTime('NOW');
        $job->save();

        // All jobs previously ranked higher
        $neighbors = Job::where('featured', 1)
            ->where('id', '!=', $id)
            ->where('rank', '<', $rank)
            ->get();
        if (!$neighbors) {
            return back();
        }
        foreach ($neighbors as $neighbor) {
            $neighbor->rank = $neighbor->rank+1;
            $neighbor->edited_at = new \DateTime('NOW');
            $neighbor->save();
        }

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rankDown($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }
        $this->authorize('edit-job', $job);

        // Don't allow the last job to be ranked down
        $last_job = Job::whereNotNull('rank')->orderBy('rank', 'desc')->first();
        if ($last_job && $last_job->id == $id) {
            return back();
        }

        $job->rank++;
        $job->edited_at = new \DateTime('NOW');
        $job->save();

        $neighbors = Job::where('id', '!=', $id)->where('rank', $job->rank)->get();
        if (!$neighbors) {
            return back();
        }
        foreach ($neighbors as $neighbor) {
            $neighbor->rank = $neighbor->rank-1;
            $neighbor->edited_at = new \DateTime('NOW');
            $neighbor->save();
        }

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
                'Sports Industry Job Board' => Auth::user() && Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/job',
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
                $job->featured = request('featured') ? true : false;
                if (!$job->featured) {
                    $job->rank = 0;
                }
                $job->description = request('description');
                $job->organization_name = $organization_name;
                $job->league = request('league');
                $job->job_type = request('job_type');
                $job->recruiting_type_code = request('recruiting_type_code');
                $job->city = request('city');
                $job->state = request('state');
                $job->country = request('country');
                $job->featured = request('featured') ? true : false;
                // Set rank if newly featured
                if ($job->featured && $job->rank == 0) {
                    $rank = 1;
                    $last_job = Job::whereNotNull('rank')->orderBy('rank', 'desc')->first();
                    if ($last_job) {
                        $rank = $last_job->rank+1;
                    }
                    $job->rank = $rank;
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
