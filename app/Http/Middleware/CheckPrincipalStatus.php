<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPrincipalStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $principal = Auth::guard('principal')->user();

        if (!$principal) {
            return redirect()->route('principal.login');
        }

        // Check if email verified
        if (!$principal->hasVerifiedEmail()) {
            return redirect()->route('principal.verification.notice');
        }

        // Check if admin approved the account
        if ($principal->status !== 'active') {
            Auth::guard('principal')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('principal.login')
                ->with('error', 'Email verified. Waiting for admin approval.');
        }

        return $next($request);
    }
}
