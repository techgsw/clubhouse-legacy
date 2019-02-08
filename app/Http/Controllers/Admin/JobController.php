<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Job;
use Illuminate\Http\Request;

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
            'searching' => $searching
        ]);
    }
}
