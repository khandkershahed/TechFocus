<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended($this->redirectTo($user));
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended($this->redirectTo($user));
    }

    /**
     * Determine where to redirect users after verification based on user_type.
     */
    protected function redirectTo($user)
    {
        if ($user->user_type === 'partner') {
            return route('partner.dashboard') . '?verified=1';
        }

        if ($user->user_type === 'client') {
            return route('client.dashboard') . '?verified=1';
        }

        return RouteServiceProvider::HOME . '?verified=1';
    }
}
