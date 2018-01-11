<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\Mail\InternalAlert;
use App\Mail\UserRegistered;
use App\Address;
use App\Message;
use App\Profile;
use App\User;
use App\Http\Controllers\Controller;
use App\Traits\ReCaptchaTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;
    use ReCaptchaTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['recaptcha'] = $this->recaptchaCheck($data);

        $rules = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:user',
            'password' => 'required|min:6|confirmed',
            'g-recaptcha-response' => 'required',
            'recaptcha' => 'required|min:1'
        ];

        $messages = [
            'g-recaptcha-response.required' => 'Please check the reCAPTCHA box to verify you are a human!',
            'recaptcha.required' => 'Please check the reCAPTCHA box to verify you are a human!',
            'recaptcha.min' => 'Please check the reCAPTCHA box to verify you are a human!',
            'unique' => 'That :attribute has already been taken.',
            'required' => 'Sorry, :attribute is a required field.',
            'password.min.string' => 'Passwords must be at least 6 characters long',
            'min' => 'Sorry, :attribute must be at least 6 characters long',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $address = Address::create([
            'user_id' => $user->id
        ]);

        $profile = Profile::create([
            'user_id' => $user->id
        ]);

        // TODO can we script this?
        // No reason to block here if we can avoid it
        // Mailchimp signup
        $api_key = env("MAILCHIMP_API_KEY");
        $list_id = env("MAILCHIMP_LIST_ID");
        $url = "https://us9.api.mailchimp.com/3.0/lists/{$list_id}/members";
        $fields = array(
            "email_address" => $data['email'],
            "email_type" => "html",
            "status" => "subscribed",
            "merge_fields" => [
                "FNAME" => $data['first_name'],
                "LNAME" => $data['last_name'],
            ]
        );
        $json = json_encode($fields);
        // cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: apikey {$api_key}"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $response = curl_exec($ch);

        try {
            Mail::to($user)->send(new UserRegistered($user));
            Mail::to('bob@sportsbusiness.solutions')->send(
                new InternalAlert('emails.internal.registration', array('user' => $user))
            );
        } catch (Exception $e) {
            // TODO log exception
        }

        return $user;
    }
}
