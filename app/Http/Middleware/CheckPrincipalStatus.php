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

        // Check if principal status is active
        if ($principal->status !== 'active') {
            Auth::guard('principal')->logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = $this->getStatusMessage($principal->status);
            return redirect()->route('principal.login')->with('error', $message);
        }

        return $next($request);
    }

    /**
     * Get appropriate message based on status
     */
    private function getStatusMessage($status)
    {
        switch ($status) {
            case 'inactive':
                return 'Your account is inactive. Please contact support.';
            case 'suspended':
                return 'Your account has been suspended. Please contact administrator.';
            case 'disabled':
                return 'Your account has been disabled.';
            default:
                return 'Your account is not active. Please contact support.';
        }
    }
}