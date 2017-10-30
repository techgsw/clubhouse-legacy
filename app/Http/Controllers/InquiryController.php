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

        if (request('use_profile_resume')) {
            $resume = Auth::user()->profile->resume_url;

            if (!$resume) {
                // TODO Need to do multiples
                $request->session()->flash('message', new Message(
                    "Please upload a resume to your profile.",
                    "danger"
                ));
                return back()->withInput();
            }
        } else if (request('resume')) {
            $resume = request()->file('resume')->store('resume', 'public');
            if (!$resume) {
                // TODO Need to do multiples
                $request->session()->flash('message', new Message(
                    "Please attach a resume.",
                    "danger"
                ));
                return back()->withInput();
            }
        } else {
            // TODO Need to do multiples
            $request->session()->flash('message', new Message(
                "It looks like you forgot to upload a resume.",
                "error"
            ));
            return back()->withInput();
        }


        $inquiry = Inquiry::create([
            'user_id' => Auth::user()->id,
            'job_id' => $id,
            'name' => request('name'),
            'email' => request('email'),
            'phone' => request('phone'),
            'resume' => $resume,
        ]);

        Mail::to(Auth::user())->send(new InquirySubmitted($job, Auth::user()));

        // TODO Global constant
        $bob = User::find(1);

        try {
            Mail::to($bob)->send(new BobAlert('emails.bob.inquiry-submitted', array(
                'job' => $job,
                'user' => Auth::user()
            )));
        } catch (Exception $e) {
            // TODO log exception
        }

        // TODO Need to do multiples
        $request->session()->flash('message', new Message(
            "Thank you! We've received your résumé and you are being considered for the position.",
            "success"
        ));

        return redirect()->action('JobController@show', [$job]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rateUp($id)
    {
        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            return redirect()->back()->withErrors(['msg' => 'Could not find inquiry ' . $id]);
        }
        $this->authorize('edit-inquiry');

        $inquiry->rating = 1;
        $inquiry->save();

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rateMaybe($id)
    {
        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            return redirect()->back()->withErrors(['msg' => 'Could not find inquiry ' . $id]);
        }
        $this->authorize('edit-inquiry');

        $inquiry->rating = 0;
        $inquiry->save();

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rateDown($id)
    {
        $inquiry = Inquiry::find($id);
        if (!$inquiry) {
            return redirect()->back()->withErrors(['msg' => 'Could not find inquiry ' . $id]);
        }
        $this->authorize('edit-inquiry');

        $inquiry->rating = -1;
        $inquiry->save();

        return back();
    }
}
