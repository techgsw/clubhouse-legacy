<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Message;
use App\User;
use App\RoleUser;
use App\Providers\StripeServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest', ['except' => ['logout', 'header']]);
    }

    protected function authenticated(Request $request, User $user)
    {
        if (!\Gate::allows('view-admin-dashboard')) {
            $stripe_user = StripeServiceProvider::getCustomer($user);
            if (!is_null($stripe_user)) {
                if ($stripe_user->delinquent) {
                    //TODO: need to test and confirm that updating the card settings removes delinquent status
                    Session::flash('message', new Message(
                        'Your last Clubhouse Pro invoice payment failed. Please update your card settings on your account page.',
                        "danger",
                        $code = null
                    ));
                } 
            }
            if ($user && $user->profile && !$user->profile->isComplete()) {
                Session::flash('message', new Message(
                    'Your profile is still not complete! Click here to fill it out.',
                    "warning",
                    $code = null,
                    $icon = 'error_outline',
                    $url = '/user/'.$user->id.'/edit-profile'
                ));
            }
        }

        $user->last_login_at = new \DateTime();
        $user->save();
    }

    public function showLoginForm()
    {
        if(!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }
        return view('auth.login');    
    }

    public function header()
    {
        return view('layouts.components.auth-header');
    }

    /**
     * Overrides the internal login error functionality to only display a message.
     * This way the Register modal doesn't display the same error
     *
     * @param Request $request
     * @return mixed
     */
    protected function sendFailedLoginResponse(Request $request) {
        $request->flash();
        Session::flash('message', new Message(
            "Sorry, your email or password is incorrect.",
            "danger",
            $code = null
        ));

        return redirect()->back();
    }
}
