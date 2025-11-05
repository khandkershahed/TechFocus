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
     * Show the email verification notice.
     */
    public function notice(Request $request)
    {
        $principal = Auth::guard('principal')->user();

        if ($principal && $principal->hasVerifiedEmail()) {
            return redirect()->route('principal.dashboard');
        }

        return view('principal.auth.verify-email');
    }

    /**
     * Handle the email verification.
     */
    public function verify(Request $request, $id, $hash)
    {
        // Find the principal
        $principal = Principal::find($id);
        
        if (!$principal) {
            return redirect()->route('principal.login')->with('error', 'Invalid verification link.');
        }

        // Check if already verified
        if ($principal->hasVerifiedEmail()) {
            Auth::guard('principal')->login($principal);
            return redirect()->route('principal.dashboard')->with('success', 'Email already verified!');
        }

        // Verify the hash and signature
        if (!hash_equals(sha1($principal->getEmailForVerification()), $hash)) {
            return redirect()->route('principal.login')->with('error', 'Invalid verification link.');
        }

        if (!$request->hasValidSignature()) {
            return redirect()->route('principal.verification.notice')->with('error', 'Verification link has expired.');
        }

        // Mark as verified
        $principal->markEmailAsVerified();
        event(new Verified($principal));

        // Login the principal
        Auth::guard('principal')->login($principal);

        return redirect()->route('principal.dashboard')->with('success', 'Email verified successfully!');
    }

    /**
     * Resend the email verification notification.
     */
    public function send(Request $request)
    {
        $principal = Auth::guard('principal')->user();
        
        if (!$principal) {
            $email = $request->session()->get('principal_email');
            if ($email) {
                $principal = Principal::where('email', $email)->first();
            }
        }

        if (!$principal) {
            return back()->with('error', 'Please log in to resend verification email.');
        }

        if ($principal->hasVerifiedEmail()) {
            return redirect()->route('principal.dashboard');
        }

        $principal->sendEmailVerificationNotification();
        $request->session()->put('principal_email', $principal->email);

        return back()->with('message', 'Verification link sent!');
    }
}