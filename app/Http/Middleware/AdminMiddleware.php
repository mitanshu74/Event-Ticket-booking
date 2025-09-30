<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->guard('admin')->user();

        // Role 1 (Admin) has full access
        if ($user->role == 1) {
            return $next($request);
        }

        // Role 2 (SubAdmin) has limited access
        if ($user->role == 2) {

            $allowedRoutes = [
                'admin/home',
                'admin/profile',
                'admin/profile/update',
                'admin/logout',
                'admin/booking',
            ];

            $currentUri = $request->path(); // Get current URI

            // Allow booking routes
            if (str_starts_with($currentUri, 'admin/booking')) {
                return $next($request);
            }

            // Allow only specific routes
            if (in_array($currentUri, $allowedRoutes)) {
                return $next($request);
            }

            // Deny access for all other routes
            return redirect()->route('admin.home')->with('error', 'Access Denied!');
        }

        // Default: deny access
        return redirect()->route('admin.login')->with('error', 'Access Denied!');
    }
}
