<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Message;
use App\Traits\ReCaptchaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    use ReCaptchaTrait;

    public function index(Request $request)
    {
        return view('contact-us.form', array('interest' => $request->interest));
    }

    public function send(Request $request)
    {
        $recaptcha = $this->recaptchaCheck($request->all());

        if (!request('g-recaptcha-response') || $recaptcha < 1) {
            $request->session()->flash('message', new Message(
                "Please confirm you are a human.",
                "warning",
                $code = null,
                $icon = "warning"
            ));
            return back()->withInput();
        }

        $to = 'bob@sportsbusiness.solutions';
        $request->interested_in = null;
        if (request('about')) {
            switch (request('about')) {
                case "sales-training-consulting":
                    $request->interested_in = "Sales Training & Consulting";
                    break;
                case "recruiting":
                    $request->interested_in = "Recruiting";
                    break;
                case "clubhouse":
                    $request->interested_in = "theClubhouse®";
                    break;
                case "other":
                    $request->interested_in = null;
                    break;
            }
        }
        Mail::to($to)->send(new Contact($request));

        return redirect()->action('ContactUsController@thanks');
    }

    public function thanks()
    {
        return view('contact-us.thanks');
    }
}
