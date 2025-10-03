<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('admin')->user();
        $route = $request->route() ? $request->route()->getName() : '';

        // user is logged in and visiting login page → redirect to home
        if ($user && $route == 'admin.login') {
            return redirect()->route('admin.home');
        }

        // admin not login redirect to login page
        if (!$user) {
            return redirect()->route('admin.login')->with('error', 'Access Denied!');
        }

        // Role-based access
        if ($user->role == 1) {
            // Super Admin → full access
            return $next($request);
        } elseif ($user->role == 2) {
            // Sub Admin → only allow some pages
            if (
                $route == 'admin.home' ||
                $route == 'admin.profile' ||
                $route == 'admin.profile.update' ||
                $route == 'admin.logout' ||
                str_starts_with($request->path(), 'admin/booking')
            ) {
                return $next($request);
            }

            return redirect()->route('admin.home')->with('error', 'Access Denied!');
        }

        // Default block
        return redirect()->route('admin.login')->with('error', 'Access Denied!');
    }
}
