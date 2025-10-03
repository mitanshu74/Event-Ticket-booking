<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // Check if user is logged in for the given guard
        if (Auth::guard($guard)->check()) {
            // Redirect admin to /admin/home, others to /user/home
            return $guard === 'admin' ? redirect('/admin/home') : redirect('/user/home');
        }

        return $next($request);
    }
}
