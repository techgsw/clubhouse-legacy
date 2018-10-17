<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\RoleUser;
use App\Providers\StripeServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
        // TODO Check membership status
        $stripe_user = StripeServiceProvider::getCustomer($user);
        if ($stripe_user->delinquent || $stripe_user->subscriptions->total_count < 1) {
            // Remove clubhouse role from user
            $role = RoleUser::where(array(array('role_code', 'clubhouse'), array('user_id', $user->id)))->first();
            $role->delete();
        }
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
}
