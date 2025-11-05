<?php

namespace App\Http\Controllers\Principal\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EmailVerificationController extends Controller
{
    /**
     * Show the email verification notice.
     */
    public function notice(Request $request)
    {
        $principal = Auth::guard('principal')->user();

        // Redirect to login if not logged in
        if (!$principal) {
            return redirect()->route('principal.login')->with('error', 'Please login first.');
        }

        // Redirect to dashboard if already verified
        if ($principal->hasVerifiedEmail()) {
            return redirect()->route('principal.dashboard');
        }

        return view('principal.auth.verify-email');
    }

    /**
     * Handle the email verification.
     */
    public function verify($id, $hash)
    {
        $principal = Auth::guard('principal')->user();

        // Redirect to login if not logged in
        if (!$principal) {
            return redirect()->route('principal.login')->with('error', 'Please login first.');
        }

        // Validate ID
        if ((string) $principal->getKey() !== (string) $id) {
            abort(403, 'Invalid verification link.');
        }

        // Validate email hash
        if (! hash_equals(sha1($principal->getEmailForVerification()), $hash)) {
            abort(403, 'Invalid verification link.');
        }

        // Mark as verified if not already
        if ($principal instanceof MustVerifyEmail && ! $principal->hasVerifiedEmail()) {
            $principal->markEmailAsVerified();
            event(new Verified($principal));
        }

        return redirect()->route('principal.dashboard')->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     */
    public function send(Request $request)
    {
        $principal = Auth::guard('principal')->user();

        // Redirect to login if not logged in
        if (!$principal) {
            return redirect()->route('principal.login')->with('error', 'Please login first.');
        }

        // Redirect if already verified
        if ($principal->hasVerifiedEmail()) {
            return redirect()->route('principal.dashboard');
        }

        // Send verification email
        $principal->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent successfully!');
    }
}
