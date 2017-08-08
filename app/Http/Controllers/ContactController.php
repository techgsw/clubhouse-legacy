<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        return view('contact.form', array('interest' => $request->interest));
    }

    public function send(Request $request)
    {
        $to = 'bob@sportsbusiness.solutions';
        $request->interested_in = null;
        if (request('about')) {
            switch (request('about')) {
                case "sales-training":
                    $request->interested_in = "sales training";
                    break;
                case "consulting":
                    $request->interested_in = "consulting";
                    break;
                case "recruiting":
                    $request->interested_in = "recruiting";
                    break;
                case "career-services":
                    $request->interested_in = "job-seeker career services";
                    break;
                case "coaching":
                    $request->interested_in = "industry professional coaching";
                    break;
                case "combine":
                    $request->interested_in = "Sports Sales Combine";
                    break;
                case "keynote":
                    $request->interested_in = "keynote speaker opportunities";
                    break;
                case "other":
                    $request->interested_in = null;
                    break;
            }
        }
        Mail::to($to)->send(new Contact($request));

        return redirect()->action('ContactController@thanks');
    }

    public function thanks()
    {
        return view('contact.thanks');
    }
}
