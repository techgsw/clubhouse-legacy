<?php

namespace App\Http\Controllers;

use App\Inquiry;
use App\Job;
use App\Message;
use App\Http\Requests\StoreJob;
use App\Http\Requests\UpdateJob;
use App\Providers\ImageServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        try {
            $image = request()->file('image_url');
            if ($image) {
                $job_image = $image->store('job', 'public');
            } else {
                $request->session()->flash('message', new Message(
                    "You must upload an image.",
                    "danger",
                    $code = null,
                    $icon = "error"
                ));
                return back()->withInput();
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', new Message(
                "Sorry, the image you tried to upload failed.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        try {
            $document = request()->file('document');
            if ($document) {
                $d = $document->store('document', 'public');
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

        $job = Job::create([
            'user_id' => Auth::user()->id,
            'title' => request('title'),
            'description' => request('description'),
            'organization' => request('organization'),
            'league' => request('league'),
            'job_type' => request('job_type'),
            'city' => request('city'),
            'state' => request('state'),
            'rank' => request('rank') ?: 0,
            'featured' => request('featured') ? true : false,
            'image_url' => $job_image,
            'document' => $d ?: null,
        ]);

        try {
            $image = request()->file('image_url');
            if ($image) {
                $storage_path = storage_path().'/app/public/job/'.$job->id.'/';
                $filename = preg_replace('/\s/', '-', $job->organization).'-Sports-Business-Solutions.'.strtolower($image->getClientOriginalExtension());

                $image_relative_path = $image->storeAs('job/'.$job->id, 'original-'.$filename, 'public');

                $large_image = new ImageServiceProvider(storage_path().'/app/public/'.$image_relative_path);
                $large_image->resize(1000, 1000);
                $large_image->save($storage_path.'/large-'.$filename);

                $medium_image= new ImageServiceProvider(storage_path().'/app/public/'.$image_relative_path);
                $medium_image->resize(500, 500);
                $medium_image->save($storage_path.'/medium-'.$filename);

                $small_image= new ImageServiceProvider(storage_path().'/app/public/'.$image_relative_path);
                $small_image->resize(250, 250);
                $small_image->save($storage_path.'/small-'.$filename);

                $width = $medium_image->getCurrentWidth();
                $height = $medium_image->getCurrentHeight();
                $dest_x = (1000-$width)/2;
                $dest_y = (520-$height)/2;

                $background_fill_image = imagecreatetruecolor(1000, 520);
                $white_color = imagecolorallocate($background_fill_image, 255, 255, 255);
                imagefill($background_fill_image, 0, 0, $white_color);
                imagecopy($background_fill_image, $medium_image->getNewImage(), $dest_x, $dest_y, 0, 0, $width, $height);
                imagejpeg($background_fill_image, $storage_path.'share-'.$filename, 100);

                $job_image = str_replace('original', 'medium', $image_relative_path);

                $job->image_url = $job_image;
                $job->save();

                Storage::delete($job_image);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            // TODO redirect with errors
            return redirect()->action('JobController@create');
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
        $rank = request('rank') ?: $job->rank;

        $job->title = request('title');
        $job->featured = request('featured') ? true : false;
        if (!$job->featured) {
            $job->rank = null;
        }
        $job->description = request('description');
        $job->organization = request('organization');
        $job->league = request('league');
        $job->job_type = request('job_type');
        $job->city = request('city');
        $job->state = request('state');
        $job->featured = request('featured') ? true : false;
        // Set rank if newly featured
        if ($job->featured && $rank == 0) {
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
        try {
            $image = request()->file('image_url');
            if ($image) {
                $storage_path = storage_path().'/app/public/job/'.$job->id.'/';
                $filename = preg_replace('/\s/', '-', $job->organization).'-Sports-Business-Solutions.'.strtolower($image->getClientOriginalExtension());

                $image_relative_path = $image->storeAs('job/'.$job->id, 'original-'.$filename, 'public');

                $large_image = new ImageServiceProvider(storage_path().'/app/public/'.$image_relative_path);
                $large_image->resize(1000, 1000);
                $large_image->save($storage_path.'/large-'.$filename);

                $medium_image= new ImageServiceProvider(storage_path().'/app/public/'.$image_relative_path);
                $medium_image->resize(500, 500);
                $medium_image->save($storage_path.'/medium-'.$filename);

                $small_image= new ImageServiceProvider(storage_path().'/app/public/'.$image_relative_path);
                $small_image->resize(250, 250);
                $small_image->save($storage_path.'/small-'.$filename);

                $width = $medium_image->getCurrentWidth();
                $height = $medium_image->getCurrentHeight();
                $dest_x = (1000-$width)/2;
                $dest_y = (520-$height)/2;

                $background_fill_image = imagecreatetruecolor(1000, 520);
                $white_color = imagecolorallocate($background_fill_image, 255, 255, 255);
                imagefill($background_fill_image, 0, 0, $white_color);
                imagecopy($background_fill_image, $medium_image->getNewImage(), $dest_x, $dest_y, 0, 0, $width, $height);
                imagejpeg($background_fill_image, $storage_path.'share-'.$filename, 100);

                $job_image = str_replace('original', 'medium', $image_relative_path);

                $job->image_url = $job_image;
                $job->save();

                Storage::delete($job_image);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            // TODO redirect with errors
            return redirect()->action('JobController@create');
        }
        $job->edited_at = new \DateTime('NOW');
        $job->save();

        return redirect()->action('JobController@show', [$job]);
    }
}
