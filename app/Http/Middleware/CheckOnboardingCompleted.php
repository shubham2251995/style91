<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOnboardingCompleted
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip if user is not authenticated
        if (!$user) {
            return $next($request);
        }

        // Skip if already on onboarding page
        if ($request->routeIs('onboarding')) {
            return $next($request);
        }

        // CRITICAL FIX: Skip onboarding for admin users
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Skip if accessing admin routes (using route name prefix)
        if ($request->routeIs('admin.*') || $request->routeIs('admin.login')) {
            return $next($request);
        }

        // Skip API routes
        if ($request->is('api/*')) {
            return $next($request);
        }

        // Redirect to onboarding if not completed
        if ($user->needsOnboarding()) {
            return redirect()->route('onboarding');
        }

        return $next($request);
    }
}
