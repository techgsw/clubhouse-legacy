<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        if (!preg_match('/register/', $request->getRequestUri())
            && !preg_match('/login/', $request->getRequestUri())
            && (preg_match('/career-service/', $request->headers->get('referer'))
                || preg_match('/webinar/', $request->headers->get('referer')))
        ) {
            return redirect('/register');
        }

        if (Auth::user()) {
            if (preg_match('/register/', $request->getRequestUri())) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
