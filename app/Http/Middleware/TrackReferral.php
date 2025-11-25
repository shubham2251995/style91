<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cookie;

class TrackReferral
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('ref')) {
            $code = $request->query('ref');
            // Store referral code in cookie for 30 days (43200 minutes)
            Cookie::queue('referral_code', $code, 43200);
        }

        return $next($request);
    }
}
