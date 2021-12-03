<?php

namespace App\Http\Controllers;

use Mail;
use App\Image;
use App\User;
use App\Inquiry;
use App\ContactJob;
use App\Job;
use App\Pipeline;
use App\Product;
use App\ProductOption;
use App\JobPipeline;
use App\League;
use App\Message;
use App\Organization;
use App\OrganizationType;
use App\TagType;
use App\Transaction;
use App\Mail\NewJobOwnerNotification;
use App\Providers\EmailServiceProvider;
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

        if (!$request->session()->get('job_seed')) {
            $request->session()->put('job_seed', rand());
        }

        $jobs = Job::filter($request)
            ->orderBy('featured', 'desc')
            ->inRandomOrder($request->session()->get('job_seed'))
            ->paginate(15);

        $featured_jobs = Job::where('job_status_id', '=', JOB_STATUS_ID['open'])->where('featured', '=', 1)->get()->all();
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

        $disciplines = TagType::where('type', 'job')->get();

        $searching =
            request('job_discipline') && request('job_discipline') != 'all' ||
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
            'disciplines' => $disciplines,
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
            ->orderBy('job.rank', 'desc')
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

        if (count($user->contact->organizations) > 0) {

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
            $available_premium_jobs = JobServiceProvider::getAvailablePaidJobs($user, PRODUCT_OPTION_ID['premium_job']);
            $available_platinum_jobs = JobServiceProvider::getAvailablePaidJobs($user, PRODUCT_OPTION_ID['platinum_job']);

            $job_premium = Product::find(PRODUCT_ID['premium_job']);

            $job_platinum = Product::find(PRODUCT_ID['platinum_job']);

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

        $job_owner = $user;
        if ($request->owner_email && $user->roles->contains('administrator')) {
            $job_owner = User::where('email', $request->owner_email)->first();
            if (!$job_owner) {
                $request->session()->flash('message', new Message(
                    "User " . $request->owner_email . " cannot be found. Make sure this is the email they use to log in.",
                    "danger",
                    $code = null,
                    $icon = "error"
                ));
                return back()->withInput();
            }
        }

        if (!$user->roles->contains('administrator')) {
            $recruiting_type_code = 'passive';
            $available_premium_jobs = JobServiceProvider::getAvailablePaidJobs($user, PRODUCT_OPTION_ID['premium_job']);
            $available_platinum_jobs = JobServiceProvider::getAvailablePaidJobs($user, PRODUCT_OPTION_ID['platinum_job']);

            if (count($available_platinum_jobs) && request('job-tier') == 'platinum') {
                $job_type_id = 4;
                $featured = true;
            } elseif (count($available_premium_jobs) && request('job-tier') == 'premium') {
                $job_type_id = 3;
                $featured = true;
            } else {
                $job_type_id = 2;
                $featured = false;
            }
        } else {
            $recruiting_type_code = $request->recruiting_type_code;
            $job_type_id = request('job_type') ? JOB_TYPE_ID[request('job_type')] : 1;
            $featured = request('featured') ? true : false;
        }

        if (empty(json_decode(request('job_tags_json')))) {
            $request->session()->flash('message', new Message(
                "Please include at least one Job Discipline",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        try {
            $organization_address = $organization->addresses()->first();
            if (is_null($organization_address)) {
                throw new SBSException('The organization you selected does not have an address. Please contact clubhouse@sportsbusiness.solutions to get this resolved.');
            } elseif (is_null($organization_address->city) || is_null($organization_address->state) || is_null($organization_address->country)) {
                throw new SBSException('This organization does not have a valid city, state or country. Please contact clubhouse@sportsbusiness.solutions to get this resolved.');
            }

            $job = new Job([
                'user_id' => $job_owner->id,
                'job_create_user_id' => $user->id,
                'title' => request('title'),
                'description' => request('description'),
                'organization_id' => $organization->id,
                'job_type' => request('job_type'),
                'league' => (!is_null($organization->leagues()->first())) ? $organization->leagues()->first()->abbreviation : null,
                'recruiting_type_code' => $recruiting_type_code,
                'job_type_id' => $job_type_id,
                'city' => $organization->addresses()->first()->city,
                'state' => $organization->addresses()->first()->state,
                'country' => $organization->addresses()->first()->country,
                'featured' => $featured,
                'document' => $document ?: null,
                'external_job_link' => request('external_job_link'),
            ]);

            $job = DB::transaction(function () use ($job, $document, $alt_image, $user, $organization) {
                if (is_null($user->contact->organization) && !$user->roles->contains('administrator')) {
                    $user->contact->organizations()->attach($organization->id);
                    $user->contact->organization = $organization->name;
                    $user->contact->save();
                }

                $job = JobServiceProvider::store($job, $document, $alt_image, json_decode(request('job_tags_json')), $user->roles->contains('administrator'));

                if (!$user->roles->contains('administrator')) {
                    try {
                        EmailServiceProvider::sendUserJobPostNotificationEmail($user, $job);
                    } catch (\Throwable $e) {
                        Log::error($e->getMessage());
                    }
                }

                return $job;
            });

        } catch (SBSException $e) {
            Log::error($e);
            $request->session()->flash('message', new Message(
                $e->getMessage(),
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        } catch (\Exception $e) {
            Log::error($e);
            $request->session()->flash('message', new Message(
                "Sorry, failed to save the job. Please try again.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        } catch (\Throwable $e) {
            Log::error($e);
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
        if ($request->id == 'self' && Auth::user()) {
            $user = Auth::user();
        } else {
            $user = User::where('id', '=', $request->id)->first();
        }

        $pipeline = Pipeline::orderBy('id', 'asc')->get();
        $job_pipeline = JobPipeline::orderBy('pipeline_id', 'asc')->get();

        if (Auth::user()->cannot('view-admin-jobs') && Auth::user()->id != $user->id) {
            return response('Forbidden.', 403);
        } elseif (Auth::user()->can('view-admin-jobs') && Auth::user()->id == $user->id) {
            $jobs = array();
        } else {
            $jobs = Job::where('user_id', '=', $user->id)->orderBy('id', 'desc')->get();
        }

        $job_platinum_upgrade = ProductOption::find(PRODUCT_OPTION_ID['platinum_job_upgrade_premium']);

        $breadcrumb = array(
            'Home' => '/',
            'Contacts' => "/admin/contact",
            'Job Postings' => "/user/{$user->id}/job-postings"
        );

        if (!Gate::allows('view-admin-dashboard')) {
            // Only admins should have contact search added to the breadcrumb
            unset($breadcrumb['Contacts']);
        }

        $job_extension = ProductOption::find(PRODUCT_OPTION_ID['job_extension']);

        return view('user/job-postings', [
            'breadcrumb' => $breadcrumb,
            'user' => $user,
            'jobs' => $jobs,
            'pipeline' => $pipeline,
            'job_pipeline' => $job_pipeline,
            'job_platinum_upgrade' => $job_platinum_upgrade,
            'job_extension_url' => $job_extension->getURL(false, 'checkout'),
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

        if (in_array($job->job_type_id, array(1, 3, 4)) && Gate::allows('edit-job', $job)) {
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

        $pd = new Parsedown;

        $breadcrumb = array( 
            'Clubhouse' => '/',
            'My Postings' => (!is_null($user) ? $user->can('view-admin-jobs') ? '/admin/job' : '/user/'.$user->id.'/job-postings/' : ''),
            'Sports Industry Job Board' => '/job',
            "$job->title with $job->organization_name" => "/job/{$job->id}"
        );

        if ($user) {
            $profile_complete = $user->profile->isComplete();
            if ($user->id != $job->user_id && $user->cannot('view-admin-jobs')) {
                unset($breadcrumb['My Postings']);
            }
        } else {
            unset($breadcrumb['My Postings']);
        }

        return view('job/show', [
            'description' => $pd->text($job->description),
            'job' => $job,
            'contact_applications' => $contact_applications,
            'inquiries' => $inquiries,
            'profile_complete' => $profile_complete,
            'pipeline' => $pipeline,
            'job_pipeline' => $job_pipeline,
            'redirect_from_signup' => request('redirect_from_signup'),
            'breadcrumb' => $breadcrumb
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

        if ($job->job_status_id == JOB_STATUS_ID['expired']) {
            return redirect()->back()->withErrors(['msg' => 'This job has expired and cannot be opened.']);
        }

        $this->authorize('close-job', $job);

        $job->job_status_id = JOB_STATUS_ID['open'];
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

        if ($job->job_status_id == JOB_STATUS_ID['expired']) {
            return redirect()->back()->withErrors(['msg' => 'This job has already expired.']);
        }

        $this->authorize('close-job', $job);

        $job->job_status_id = JOB_STATUS_ID['closed'];
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

        if ($job->job_status_id == JOB_STATUS_ID['expired']) {
            return redirect()->back()->withErrors(['msg' => 'This job has expired and cannot be edited.']);
        }

        $this->authorize('edit-job', $job);

        $reuse_organization_fields =
            $job->organization_name == $job->organization->name &&
            $job->image_id == $job->organization->image_id;

        $tags = [];
        foreach ($job->tags as $tag) {
            $tags[] = $tag->name;
        }
        $job_tags_json = json_encode($tags);

        $pd = new Parsedown;
        return view('job/edit', [
            'job' => $job,
            'leagues' => League::all(),
            'reuse_organization_fields' => $reuse_organization_fields,
            'description' => $pd->text($job->description),
            'job_tags_json' => $job_tags_json,
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
        $this->authorize('edit-job', $job);

        if ($job->job_status_id == JOB_STATUS_ID['expired']) {
            return redirect()->back()->withErrors(['msg' => 'This job has expired and cannot be edited.']);
        }

        $job_owner = User::where('email', $request->owner_email)->first();
        if (!$job_owner) {
            $request->session()->flash('message', new Message(
                "User " . $request->owner_email . " cannot be found. Make sure this is the email they use to log in.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        if ($job_owner->id != $job->user_id) {
            try {
                Mail::to($job_owner)->send(new NewJobOwnerNotification($job, $job_owner));
            } catch (\Throwable $t) {
                Log::error($t);
            }
        }
        
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
            $job = DB::transaction(function () use ($job, $job_owner, $organization, $request) {
                $job->organization_id = $organization->id;
                $job->user_id = $job_owner->id;

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
                    $new_featured_status = request('featured') ? true : false;
                    if ($job->featured != $new_featured_status) {
                        // Stayed the same
                        $rank = 1;
                        $last_job = Job::whereNotNull('rank')->where('featured', $job->featured)->orderBy('rank', 'desc')->first();
                        if ($last_job) {
                            $rank = $last_job->rank+1;
                        }
                        $job->rank = $rank;
                    }
                    $job->featured = $new_featured_status;
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

                if ($request->user()->can('view-admin-jobs') && request('job_type') && isset(JOB_TYPE_ID[request('job_type')])) {
                    $job->job_type_id = JOB_TYPE_ID[request('job_type')]; 
                }

                if (request('document')) {
                    $doc = request()->file('document');
                    $job->document = $doc->store('document', 'public');
                }

                $job->external_job_link = request('external_job_link');

                $job->edited_at = new \DateTime('NOW');
                $job->save();

                $job_tags = json_decode(request('job_tags_json'));
                if ($job_tags) {
                    $job->tags()->sync($job_tags);
                }

                return $job;
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', new Message(
                "Sorry, failed to save job. Please try again.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return redirect()->back();
        }

        if (!Auth::user()->can('edit-job', $job)) {
            // A non-admin user has switched ownership to someone else
            $request->session()->flash('message', new Message(
                "Job updated. User ".$job->user->email." is now the job owner.",
                "success",
                $code = null,
                $icon = "check_circle"
            ));
            return redirect($job->getUrL());
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
