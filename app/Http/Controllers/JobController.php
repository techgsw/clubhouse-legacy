<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJob;
use App\Http\Requests\UpdateJob;
use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class JobController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-job-board');

        // TODO Paginate
        $jobs = Job::open();

        return view('job/index', [
            'breadcrumb' => ['Home' => '/', 'Job Board' => '/job'],
            'jobs' => $jobs
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-job');

        return view('job/create', [
            'breadcrumb' => ['Home' => '/', 'Job Board' => '/job', 'Post a job' => '/job/create']
        ]);
    }

    /**
     * @param  StoreJob  $request
     * @return Response
     */
    public function store(StoreJob $request)
    {
        $image = request()->file('image_url');

        $job = Job::create([
            'user_id' => Auth::user()->id,
            'title' => request('title'),
            'description' => request('description'),
            'organization' => request('organization'),
            'city' => request('city'),
            'state' => request('state'),
            'image_url' => $image->store('job', 'public'),
        ]);

        return redirect()->action('JobController@show', [$job]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view-job');

        $job = Job::find($id);
        if (!$job) {
            return abort(404);
        }

        $answers = $job->answers;

        return view('job/show', [
            'job' => $job,
            'breadcrumb' => ['Home' => '/', 'Job Board' => '/job', "$job->title with $job->organization" => "/job/{$job->id}"]
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

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = Job::find($id);
        $this->authorize('edit-job', $job);

        return view('job/edit', [
            'job' => $job,
            'breadcrumb' => ['Home' => '/', 'Job Board' => '/job', "Edit" => "/job/{$job->id}/edit"]
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
        $job->title = request('title');
        $job->description = request('description');
        $job->organization = request('organization');
        $job->city = request('city');
        $job->state = request('state');
        if (request('image_url')) {
            $image = request()->file('image_url');
            $job->image_url = $image->store('job', 'public');
        }
        $job->edited_at = new \DateTime('NOW');
        $job->save();

        return redirect()->action('JobController@show', [$job]);
    }
}
