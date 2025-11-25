<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInstalled
{
    public function handle(Request $request, Closure $next): Response
    {
        // Always allow install routes to pass through
        if ($request->is('install') || $request->is('install/*')) {
            return $next($request);
        }

        $isInstalled = file_exists(storage_path('installed'));

        // If not installed, redirect to installer
        if (!$isInstalled) {
            return redirect('/install');
        }

        return $next($request);
    }
}
