<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
                $request->session()->put('redirect_url', '/job-options');
            } else if ($request->query('type') == 'pro') {
                $request->session()->put('redirect_url', '/pro-membership');
            }
        }

        return $next($request);
    }
}
