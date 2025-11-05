<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackPrincipalActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('principal')->check()) {
            Auth::guard('principal')->user()->update(['last_seen' => now()]);
        }

        return $next($request);
    }
}