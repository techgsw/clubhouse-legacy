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
        return view('contact-us', array('interest' => $request->interest));
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
        Mail::to($to)->send(new Contact($request));

        return redirect()->action('ContactUsController@thanks');
    }

    public function thanks()
    {
        return view('contact-us.thanks');
    }
}
