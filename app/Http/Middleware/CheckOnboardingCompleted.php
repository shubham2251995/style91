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

        // Skip if accessing API or admin routes
        if ($request->is('api/*') || $request->is('admin/*')) {
            return $next($request);
        }

        // Redirect to onboarding if not completed
        if ($user->needsOnboarding()) {
            return redirect()->route('onboarding');
        }

        return $next($request);
    }
}
