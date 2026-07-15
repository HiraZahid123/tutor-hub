<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTutorProfileIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'tutor') {
            // Check if this user has completed the tutor registration application
            $hasRegistration = \App\Models\TutorRegistration::where('user_id', $user->id)->exists();

            if (!$hasRegistration) {
                // If they are trying to access any route other than the registration pages or logout, redirect.
                if (!$request->routeIs('register-tutor') && !$request->routeIs('register-tutor.store') && !$request->routeIs('logout')) {
                    return redirect()->route('register-tutor')->with('warning', 'Please complete your tutor registration first.');
                }
            }
        }

        return $next($request);
    }
}
