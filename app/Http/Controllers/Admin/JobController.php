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
        $jobs = Job::orderBy('id', 'desc')->paginate(5);

        return view('admin/job', [
            'jobs' => $jobs
        ]);
    }
}
