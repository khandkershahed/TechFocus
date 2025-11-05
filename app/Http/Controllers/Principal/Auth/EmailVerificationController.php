<?php

namespace App\Http\Controllers\Principal\Auth;

use App\Http\Controllers\Controller;
use App\Models\Principal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;

class EmailVerificationController extends Controller
{
    /**
     * Show verification notice
     */
    public function notice(Request $request)
    {
        // Get the logged-in principal
        $principal = Auth::guard('principal')->user();

        if (!$principal) {
            return redirect()->route('principal.login')
                ->with('error', 'Please login first.');
        }

        if ($principal->hasVerifiedEmail()) {
            return redirect()->route('principal.dashboard');
        }

        return view('principal.auth.verify-email');
    }

    /**
     * Email verification WITHOUT requiring principal login
     */
public function verify($id, $hash)
{
    $principal = Principal::findOrFail($id);

    if (! hash_equals(sha1($principal->getEmailForVerification()), $hash)) {
        abort(403, 'Invalid verification link.');
    }

    if (!$principal->hasVerifiedEmail()) {
        $principal->markEmailAsVerified();
        event(new Verified($principal));
    }

    Auth::guard('principal')->login($principal);

    return redirect()->route('principal.dashboard')->with('verified', true);
}



    /**
     * Resend verification email
     */
    public function send(Request $request)
    {
        // Get the logged-in principal
        $principal = Auth::guard('principal')->user();

        if (!$principal) {
            return redirect()->route('principal.login')
                ->with('error', 'Please login first.');
        }

        if ($principal->hasVerifiedEmail()) {
            return redirect()->route('principal.dashboard');
        }

        $principal->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent successfully!');
    }
}
