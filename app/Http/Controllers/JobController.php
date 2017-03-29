<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJob;
use App\Http\Requests\UpdateJob;
use App\Inquiry;
use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class JobController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jobs = Job::filter($request)->paginate(5);

        return view('job/index', [
            'breadcrumb' => [
                'Home' => '/',
                'Job Board' => '/job'
            ],
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
            'breadcrumb' => [
                'Home' => '/',
                'Job Board' => '/job',
                'Post a job' => '/job/create'
            ]
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
            'league' => request('league'),
            'job_type' => request('job_type'),
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
        $job = Job::find($id);
        if (!$job) {
            return abort(404);
        }

        $inquiries = Inquiry::where('job_id', $id)
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('job/show', [
            'job' => $job,
            'inquiries' => $inquiries,
            'breadcrumb' => [
                'Home' => '/',
                'Job Board' => '/job',
                "$job->title with $job->organization" => "/job/{$job->id}"
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
            'breadcrumb' => [
                'Home' => '/',
                'Job Board' => '/job',
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
        $job->title = request('title');
        $job->description = request('description');
        $job->organization = request('organization');
        $job->league = request('league');
        $job->job_type = request('job_type');
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
