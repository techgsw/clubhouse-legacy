<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Job;
use App\Pipeline;
use App\JobPipeline;
use App\User;
use App\League;
use App\Message;
use App\Organization;
use App\OrganizationType;
use App\Http\Requests\StoreJob;
use App\Providers\OrganizationServiceProvider;
use App\Providers\JobServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Exceptions\SBSException;

class JobController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('create-job');

        // Defaults
        if (!request('status')) {
            $request->merge(['status' => 'open']);
        }
        
        $pipeline = Pipeline::orderBy('id', 'asc')->get();

        $job_pipeline = JobPipeline::orderBy('pipeline_id', 'asc')->get();

        $jobs = Job::filter($request);
        if (request('new-inquiries')) {
            // Order new inquiries requests by most recent inquiry
            // Done in filter function
        } else {
            // Default: order like front-end
            $jobs = $jobs->orderBy('featured', 'desc')
                ->orderBy('rank', 'asc')
                ->orderBy('job.created_at', 'desc');
        }
        $count = $jobs->count();
        $jobs = $jobs->paginate(15);

        $searching =
            request('job_type') && request('job_type') != 'all' ||
            request('league') && request('league') != 'all' ||
            request('state') && request('state') != 'all' ||
            request('status') && request('status') != 'all' ||
            request('organization') ||
            request('new-inquiries');

        return view('admin/job', [
            'jobs' => $jobs,
            'count' => $count,
            'pipeline' => $pipeline,
            'job_pipeline' => $job_pipeline,
            'searching' => $searching
        ]);
    }

    /**
     * @param  StoreJob  $request
     * @return Response
     */
    public function store(StoreJob $request)
    {
        $document = request()->file('document');
        $alt_image = request()->file('alt_image_url');
        $job = new Job([
            'user_id' => Auth::user()->id,
            'title' => request('title'),
            'description' => request('description'),
            'organization_id' => $request->organization_id,
            'job_type' => request('job_type'),
            'recruiting_type_code' => Auth::user()->roles->contains('administrator') ? $request->recruiting_type_code : 'passive',
            'city' => request('city'),
            'state' => request('state'),
            'league' => request('league'),
            'country' => request('country'),
            'featured' => request('featured') ? true : false,
            'document' => $document ?: null,
        ]);

        try {
            $job = DB::transaction(function () use ($job, $document, $alt_image) {
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
                "Sorry, failed to save the job. Please try again." . $e->getMessage(),
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', new Message(
                "Sorry, failed to save the job. Please try again." . $e->getMessage(),
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        return redirect()->action('JobController@show', [$job]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create-job');
        $user = Auth::User();

        $organization = false;
        if ($organization_id = (int)$request->organization) {
            $organization = Organization::find($organization_id);
            $league = $organization->leagues[0];
        } else {
            $organization = $user->contact->organizations->first();
            $league = $organization->leagues->first();
        }

        return view('admin/job/create', [
            'organization' => $organization,
            'organizations' => OrganizationServiceProvider::all(),
            'organization_types' => OrganizationType::all(),
            'league' => $league,
            'leagues' => League::all(),
            'breadcrumb' => [
                'Clubouse' => '/',
                'Job Board' => Auth::user() && Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/job',
                'Post a job' => '/job/create'
            ]
        ]);
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
        $last_job = Job::whereNotNull('rank')
            ->where('featured', 1)
            ->where('open', 1)
            ->orderBy('rank', 'desc')
            ->first();
        if ($last_job) {
            $rank = $last_job->rank+1;
        }

        // Shift unfeatured neighbors with lower rank up one
        $neighbors = Job::where('featured', 0)
            ->where('open', 1)
            ->orderBy('rank', 'ASC')
            ->get();
        foreach ($neighbors as $i => $neighbor) {
            $neighbor->rank = $i+1;
            $neighbor->edited_at = new \DateTime('NOW');
            $neighbor->save();
        }


        $job->featured = 1;
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

        $neighbors = Job::where('id', '!=', $id)
            ->where('rank', $job->rank)
            ->where('featured', $job->featured)
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
        $neighbors = Job::where('id', '!=', $id)
            ->where('rank', '<', $rank)
            ->where('featured', $job->featured)
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

        $neighbors = Job::where('id', '!=', $id)
            ->where('rank', $job->rank)
            ->where('featured', $job->featured)
            ->get();
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


}
