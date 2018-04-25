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
use App\Http\Controllers\Controller;
use App\Providers\EmailServiceProvider;
use App\Traits\ReCaptchaTrait;
use Illuminate\Support\Facades\DB;
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
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return $user;
    }
}
