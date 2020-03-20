<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RedirectRouter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (preg_match('/register/', $request->getRequestURI())) {
            if ($request->query('type') == 'employer'
                && preg_match('/'.addcslashes(env('CLUBHOUSE_URL'), '/').'\/job/', $request->headers->get('referer'))
            ) {
                session(['url.intended' => '/job-options']);
            } else if ($request->query('type') == 'pro') {
                session(['url.intended' => '/pro-membership']);
            } else if (!session()->has('url.intended')) {
                session(['url.intended' => url()->previous()]);
            }
        }

        return $next($request);
    }
}
