<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('web')->user();
        $route = $request->route() ? $request->route()->getName() : '';

        // user is logged in and trying to visit login or register
        if ($user && ($route == 'user.login' || $route == 'user.register')) {
            return redirect()->route('user.home');
        }

        // user is not logged in
        if (!$user) {
            return redirect()->route('user.login')->with('login_first', 'First login then book tickets');
        }

        return $next($request);
    }
}
