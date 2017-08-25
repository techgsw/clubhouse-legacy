<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInquiry;
use App\Inquiry;
use App\Job;
use App\Message;
use App\User;
use App\Http\Requests\StoreJob;
use App\Mail\BobAlert;
use App\Mail\InquirySubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class InquiryController extends Controller
{
    /**
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreInquiry $request, $id)
    {
        $job = Job::find($id);
        if (!$job) {
            return redirect()->back()->withErrors(['msg' => 'Could not find job ' . $id]);
        }

        $resume = request()->file('resume');

        $inquiry = Inquiry::create([
            'user_id' => Auth::user()->id,
            'job_id' => $id,
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'resume' => $resume->store('resume', 'public'),
        ]);

        Mail::to(Auth::user())->send(new InquirySubmitted($job, Auth::user()));

        // TODO Global constant
        $bob = User::find(1);
        Mail::to($bob)->send(new BobAlert('emails.bob.inquiry-submitted', array(
            'job' => $job,
            'user' => Auth::user()
        )));

        // TODO Need to do multiples
        $request->session()->flash('message', new Message(
            "Thank you! We've received your résumé and you are being considered for the position.",
            "success"
        ));

        return redirect()->action('JobController@show', [$job]);
    }
}
