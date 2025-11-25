<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        \Illuminate\Support\Facades\Log::info('AdminMiddleware: Checking access', [
            'url' => $request->url(),
            'auth_check' => auth()->check(),
            'user_id' => auth()->id(),
            'role' => auth()->check() ? auth()->user()->role : 'N/A',
        ]);

        if (!auth()->check() || auth()->user()->role !== 'admin') {
            \Illuminate\Support\Facades\Log::warning('AdminMiddleware: Access denied', [
                'reason' => !auth()->check() ? 'Not logged in' : 'Role mismatch',
            ]);
            return redirect()->route('admin.login')->with('error', 'You must be an admin to access this area.');
        }

        return $next($request);
    }
}
