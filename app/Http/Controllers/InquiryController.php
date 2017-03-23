<?php

namespace App\Http\Controllers;

use App\Inquiry;
use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $id)
    {
        $this->authenticate('create-inquiry');

        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }

        $inquiry = Inquiry::create([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ]);

        return redirect()->action('JobController@show', [$job]);
    }
}
