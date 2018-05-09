<?php

namespace App\Http\Controllers;

use App\Image;
use App\Inquiry;
use App\Job;
use App\Message;
use App\Providers\ImageServiceProvider;
use App\Http\Requests\StoreJob;
use App\Http\Requests\UpdateJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use \Exception;

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

        $searching =
            request('job_type') && request('job_type') != 'all' ||
            request('league') && request('league') != 'all' ||
            request('state') && request('state') != 'all' ||
            request('organization');

        return view('job/index', [
            'breadcrumb' => [
                'Home' => '/',
                'Job Board' => Auth::user() && Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/job'
            ],
            'jobs' => $jobs,
            'searching' => $searching
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
                'Job Board' => Auth::user() && Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/job',
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
        if (!$image_file = request()->file('image_url')) {
            $request->session()->flash('message', new Message(
                "You must upload an image.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        try {
            $document = request()->file('document');
            if ($document) {
                $document = $document->store('document', 'public');
            } else {
                $request->session()->flash('message', new Message(
                    "You must upload a document.",
                    "danger",
                    $code = null,
                    $icon = "error"
                ));
                return back()->withInput();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', new Message(
                "Sorry, the document you tried to upload failed.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        try {
            $job = DB::transaction(function () use ($image_file, $document, $request) {
                $rank = 0;
                if (request('featured')) {
                    $rank = 1;
                    $last_job = Job::whereNotNull('rank')->orderBy('rank', 'desc')->first();
                    if ($last_job) {
                        $rank = $last_job->rank+1;
                    }
                }


                $job = Job::create([
                    'user_id' => Auth::user()->id,
                    'title' => request('title'),
                    'description' => request('description'),
                    'organization' => request('organization'),
                    'league' => request('league'),
                    'job_type' => request('job_type'),
                    'city' => request('city'),
                    'state' => request('state'),
                    'country' => request('country'),
                    'rank' => $rank,
                    'featured' => request('featured') ? true : false,
                    'document' => $document ?: null,
                ]);

                $image = ImageServiceProvider::saveFileAsImage(
                    $image_file,
                    $filename = preg_replace('/\s/', '-', str_replace("/", "", $job->organization)).'-SportsBusinessSolutions',
                    $directory = 'job/'.$job->id
                );

                $job->image_id = $image->id;
                $job->save();

                return $job;
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', new Message(
                "Sorry, failed to save the job. Please try again.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        return redirect()->action('JobController@show', [$job]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $job = Job::find($id);
        if (!$job) {
            return abort(404);
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

        return view('job/show', [
            'job' => $job,
            'inquiries' => $inquiries,
            'profile_complete' => $profile_complete,
            'breadcrumb' => [
                'Home' => '/',
                'Job Board' => Auth::user() && Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/job',
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

        return view('job/edit', [
            'job' => $job,
            'breadcrumb' => [
                'Home' => '/',
                'Job Board' => Auth::user() && Auth::user()->can('view-admin-jobs') ? '/admin/job' : '/job',
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

        try {
            $job = DB::transaction(function () use ($job) {
                $job->title = request('title');
                $job->featured = request('featured') ? true : false;
                if (!$job->featured) {
                    $job->rank = 0;
                }
                $job->description = request('description');
                $job->organization = request('organization');
                $job->league = request('league');
                $job->job_type = request('job_type');
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

                if ($image_file = request()->file('image_url')) {
                    if ($job->image) {
                        $image = ImageServiceProvider::saveFileAsImage(
                            $image_file,
                            $filename = preg_replace('/\s/', '-', str_replace("/", "", $job->organization)).'-SportsBusinessSolutions',
                            $directory = 'job/'.$job->id,
                            $options = ['update' => $job->image]
                        );
                    } else {
                        $image = ImageServiceProvider::saveFileAsImage(
                            $image_file,
                            $filename = preg_replace('/\s/', '-', str_replace("/", "", $job->organization)).'-SportsBusinessSolutions',
                            $directory = 'job/'.$job->id
                        );
                        $job->image_id = $image->id;
                        $job->save();
                    }
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

        return redirect()->action('JobController@show', [$job]);
    }
}
