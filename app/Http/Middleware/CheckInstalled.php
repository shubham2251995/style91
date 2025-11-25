<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInstalled
{
    public function handle(Request $request, Closure $next): Response
    {
        $isInstalled = file_exists(storage_path('installed'));

        // If not installed and trying to access anything other than install routes
        if (!$isInstalled && !$request->is('install*') && !$request->is('livewire/*')) {
            return redirect()->route('install');
        }

        // If installed and trying to access install routes
        if ($isInstalled && $request->is('install*')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
