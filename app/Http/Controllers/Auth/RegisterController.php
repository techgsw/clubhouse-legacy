<?php

namespace App\Http\Controllers\Auth;

use App\ProductOption;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Password;
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
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\RegistersUsers;
use Ramsey\Uuid\Uuid;

class RegisterController extends Controller
{
    use RegistersUsers;
    use ReCaptchaTrait;

    /**
     * Where to redirect users after registration.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return Session::pull('url.intended', url('/'));
    }

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
        if ($request->input('membership-selection-pro-annually')) {
            $redirect_url = ProductOption::whereHas('product', function ($query) {
                $query->where('name', 'Clubhouse Pro Membership');
            })->where('name', 'Clubhouse Pro Membership Annual')->first()->getURL(false, 'checkout');
        } else if ($request->input('membership-selection-pro-monthly') || $request->input('membership-selection-pro')) {
            $redirect_url = ProductOption::whereHas('product', function ($query) {
                $query->where('name', 'Clubhouse Pro Membership');
            })->where('name', 'Clubhouse Pro Membership')->first()->getURL(false, 'checkout');
        } else {
            $redirect_url = Session::get('url.intended', url('/'));
        }

        if ($redirect_url == '/job-options') {
            $message = "Thank you for joining theClubhouse community! Now, let’s help you post your open job. First, select the option below that works best for you.";
        } else {
            $message = "Thank you for becoming a member of theClubhouse!";
        }

        Session::flash('message', new Message(
            $message,
            "success",
            $code = null,
            $icon = "check_circle"
        ));

        return redirect($redirect_url);
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

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $possible_duplicate_users = User::where('first_name', $request->input('first_name'))
            ->where('last_name', $request->input('last_name'))
            // if the email matches we'll warn the user down below
            ->where('email', '!=', $request->input('email'))
            ->get();

        $possible_duplicate_contacts = Contact::whereNull('user_id')
            ->where('first_name', $request->input('first_name'))
            ->where('last_name', $request->input('last_name'))
            // if the email matches we'll automatically assign the contact to the user
            ->where('email', '!=', $request->input('email'))
            ->orderBy('created_at', 'desc')
            ->get();

        if (count($possible_duplicate_users) > 0 || count($possible_duplicate_contacts) > 0) {
            // If the new user's name matches other users or contacts, we need to let the new user know.
            // All form data will be cached with a tokenized key returned to the user so they don't have to redo the captcha.

            $register_token = Uuid::uuid4()->toString();

            if (!is_null($register_token)) {

                $view = null;

                if (count($possible_duplicate_users) > 0) {
                    $view = view('auth/is-this-you/user-match', [
                        'possible_duplicate_users' => $possible_duplicate_users,
                        'register_token' => $register_token
                    ]);
                } else if (count($possible_duplicate_contacts) > 0) {
                    $view = view('auth/is-this-you/contact-match', [
                        'possible_duplicate_contact' => $possible_duplicate_contacts->first(),
                        'register_token' => $register_token
                    ]);
                    $request->request->add(['possible_duplicate_contact' => $possible_duplicate_contacts->first()->id]);
                }

                Cache::remember('register_token_' . $register_token, 1200, function () use ($request) {
                    return $request->all();
                });

                if (!is_null($view)) {
                    return $view;
                } else {
                    Log::error('Error generating view for user '.$request->input('email').'. Proceeding with normal registration.');
                    // continue down with normal process
                }
            } else {
                Log::error('Token for user '.$request->input('email').' could not be generated. Proceeding with normal registration.');
                // continue down with normal process
            }
        }

        try {
            event(new Registered($user = $this->create($request->all())));
        } catch (\Exception $e) {
            return redirect("/login")->withErrors(array("We believe you already have an account with us. Please login and update your email address."));
        }

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath().'#register-modal');
    }

    /**
     * If the user reaches the "Is this you" page, then the "Complete registration" request hits this method.
     * This pulls their cached registration data if available and continues with the normal registration process
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function registerIsThisYou(Request $request, $type)
    {
        $cached_request_form = Cache::pull('register_token_'.$request->input('register_token'));

        if (is_null($cached_request_form)) {
            return redirect("/register")->withErrors(array("Sorry, your session has expired. Please register again."));
        }

        try {
            if ($type == 'user' || ($type == 'contact' && !($request->input('answer') == 'true'))) {
                event(new Registered($user = $this->create($cached_request_form)));
            } else if ($type == 'contact' && $request->input('answer') == 'true') {
                event(new Registered($user = $this->create($cached_request_form, Contact::find($cached_request_form['possible_duplicate_contact']))));
            } else {
                Log::warn('Is This You page returned unusual params. Type: '.$type.' , Answer: '.$request->input('answer').' . Continuing with registration.');
                event(new Registered($user = $this->create($cached_request_form)));
            }
        } catch (\Exception $e) {
            Log::error('Error registering user after Is This You page: '.$e->getMessage());
            return redirect("/register")->withErrors(array("Sorry, there was an issue registering your account. Please try again."));
        }

        $this->guard()->login($user);

        $request->request->add($cached_request_form);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @param  Contact $contact if the user identifies a matching contact, link this to the user
     * @return User
     */
    protected function create(array $data, $contact = null)
    {
        $user = DB::transaction(function() use($data, $contact) {
            $email = $data['email'];
            if (is_null($contact)) {
                $contact = Contact::where('email', '=', $email)->get();
                if (count($contact) > 0) {
                    $contact = $contact[0];
                    $contact->title = $data['title'];
                    $contact->save();
                } else {
                    $contact = Contact::create([
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'email' => $data['email'],
                        'title' => $data['title']
                    ]);
                }
            }

            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            $years_worked = null;
            $planned_services = array();
            foreach($data as $key=>$datum) {
                if (strpos($key, 'services-') !== false) {
                    $planned_services []= substr($key, 9);
                } else if (strpos($key, 'years-worked-') !== false) {
                    $years_worked = substr($key, 13);
                }
            }

            $profile = Profile::create([
                'user_id' => $user->id,
                'current_title' => $data['title'],
                'works_in_sports_years_range' => $years_worked,
                'planned_services' => empty($planned_services) ? null : $planned_services
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

            if (!is_null($contact->user_id)) {
                throw new \Exception('We have detected that you already have an account with us. Please log in and change your existing email.');
            }

            $contact->user_id = $user->id;
            $contact->do_not_contact = false;
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
            if (isset($data['newsletter'])) {
                $response = EmailServiceProvider::addToMailchimp($user);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
        }

        // TODO Use a Queue so as not to block
        // https://laravel.com/docs/5.5/queues
        try {
            Mail::to($user)->send(new UserRegistered($user));
            EmailServiceProvider::sendRegistrationNotificationEmail($user);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
        }

        return $user;
    }
}
