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
    public function index()
    {
        // TODO general admin resource? admin-job-show resource?
        $this->authorize('create-job');

        $jobs = Job::orderBy('id', 'desc')->paginate(10);

        return view('admin/job', [
            'jobs' => $jobs
        ]);
    }
}
