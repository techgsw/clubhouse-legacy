<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\Mail\UserRegistered;
use App\Address;
use App\AddressContact;
use App\AddressProfile;
use App\Contact;
use App\Message;
use App\Profile;
use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use App\Providers\EmailServiceProvider;
use App\Traits\ReCaptchaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
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
    protected $redirectTo = '/membership-options';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('redirect_router');
    }

    protected function registered(Request $request, $user)
    {
        if ($request->session()->get('redirect_url')) {
            $this->redirectTo = '/job-options';
            $message = "Thank you for joining theClubhouse community! Now, let’s help you post your open job. First, select the option below that works best for you.";
        } else {
            $message = "Thank you for becoming a member of theClubhouse! We’re very excited to have you. Start by choosing the membership option that works best for you below.";
        }
        Session::flash('message', new Message(
            $message,
            "success",
            $code = null,
            $icon = "check_circle"
        ));
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
            'terms' => 'required',
            'g-recaptcha-response' => 'required',
            'recaptcha' => 'required|min:1'
        ];

        $messages = [
            'g-recaptcha-response.required' => 'Please check the reCAPTCHA box to verify you are a human!',
            'recaptcha.required' => 'Please check the reCAPTCHA box to verify you are a human!',
            'recaptcha.min' => 'Please check the reCAPTCHA box to verify you are a human!',
            'unique' => 'That :attribute has already been taken.',
            'terms' => 'Sorry, you must agree to our terms of service.',
            'required' => 'Sorry, :attribute is a required field.',
            'password.min.string' => 'Passwords must be at least 6 characters long',
            'confirmed' => 'Sorry, it looks like your passwords do not match.',
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
        $user = DB::transaction(function() use($data) {
            $email = $data['email'];
            $contact = Contact::where('email', '=', $email)->get();
            if (count($contact) > 0) {
                $contact = $contact[0];
            } else {
                $contact = Contact::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email']
                ]);
            }

            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $profile = Profile::create([
                'user_id' => $user->id
            ]);

            $roles = Role::where('code', 'job_user')->get();
            $user->roles()->attach($roles);

            $address = Address::create([
                'name' => $data['first_name'] . " " . $data['last_name']
            ]);
            $address_profile = AddressProfile::create([
                'address_id' => $address->id,
                'profile_id' => $profile->id
            ]);

            $contact->user_id = $user->id;
            $contact->save();

            $address = Address::create([
                'name' => $data['first_name'] . " " . $data['last_name']
            ]);
            $address_contact = AddressContact::create([
                'address_id' => $address->id,
                'contact_id' => $contact->id
            ]);

            return $user;
        });

        // TODO Use a Queue so as not to block
        // https://laravel.com/docs/5.5/queues
        try {
            $response = EmailServiceProvider::addToMailchimp($user);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        // TODO Use a Queue so as not to block
        // https://laravel.com/docs/5.5/queues
        try {
            Mail::to($user)->send(new UserRegistered($user));
            EmailServiceProvider::sendRegistrationNotificationEmail($user);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return $user;
    }
}
