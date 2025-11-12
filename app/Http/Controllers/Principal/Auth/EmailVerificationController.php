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
            return redirect()->route('principal.login')
                ->with('message', 'Email already verified. Waiting for admin approval.');
        }

        return view('principal.auth.verify-email');
    }

    /**
     * Handle the email verification.
     */
    public function verify(Request $request, $id, $hash)
    {
        $principal = Principal::find($id);

        if (!$principal) {
            return redirect()->route('principal.login')
                ->with('error', 'Invalid verification link.');
        }

        if ($principal->hasVerifiedEmail()) {
            return redirect()->route('principal.login')
                ->with('message', 'Email already verified. Waiting for admin approval.');
        }

        if (!hash_equals(sha1($principal->getEmailForVerification()), $hash)) {
            return redirect()->route('principal.login')
                ->with('error', 'Invalid verification link.');
        }

        if (!$request->hasValidSignature()) {
            return redirect()->route('principal.login')
                ->with('error', 'Verification link has expired.');
        }

        // Mark email as verified
        $principal->markEmailAsVerified();
        event(new Verified($principal));

        // Redirect to login with waiting message
        return redirect()->route('principal.login')
            ->with('message', 'Email verified successfully. Please wait for admin approval.');
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
            return redirect()->route('principal.login')
                ->with('message', 'Email already verified. Waiting for admin approval.');
        }

        $principal->sendEmailVerificationNotification();
        $request->session()->put('principal_email', $principal->email);

        return back()->with('message', 'Verification link sent!');
    }
}
