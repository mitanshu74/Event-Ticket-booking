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

        if (!$user) {
            return redirect()->route('admin.login')->with('error', 'Access Denied!');
        }
        if ($user->role == 1) {
            // dd($user);
            return $next($request);
        } elseif ($user->role == 2) {
            if (
                $request->routeIs('admin.deshboard') ||
                $request->routeIs('admin.profile') ||
                $request->routeIs('admin.update') ||
                $request->routeIs('admin.logout') ||
                str_starts_with($request->path(), 'admin/booking')
            ) {
                return $next($request);
            }
        }
        // dd($user);
        return redirect()->route('admin.login')->with('error', 'Access Denied!');
    }
}
