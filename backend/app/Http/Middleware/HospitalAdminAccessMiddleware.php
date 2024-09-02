<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalAdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

    // Log or return the role to see what it is
    if ($user) {
        \Log::info('User Role: ' . $user->role); // This will log the role to the Laravel log file
        if ($user->role === 'hospital-admin') {
            return $next($request);
        }
    }

    return response()->json(['message' => 'Unauthorized.'], 403);
    }
}
