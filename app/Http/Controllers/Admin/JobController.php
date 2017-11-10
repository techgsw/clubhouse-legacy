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
        $jobs = Job::filter($request)->orderBy('created_at', 'desc');
        $count = $jobs->count();
        $jobs = $jobs->paginate(15);

        $searching =
            request('job_type') && request('job_type') != 'all' ||
            request('league') && request('league') != 'all' ||
            request('state') && request('state') != 'all' ||
            request('status') && request('status') != 'all' ||
            request('organization');

        return view('admin/job', [
            'jobs' => $jobs,
            'count' => $count,
            'searching' => $searching
        ]);
    }
}
