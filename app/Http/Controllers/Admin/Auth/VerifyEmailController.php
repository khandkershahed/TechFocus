<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated admin's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $admin = auth('admin')->user(); // ✅ use the admin guard

        if (!$admin) {
            abort(403, 'Unauthorized or no admin authenticated.');
        }

        if ($admin->hasVerifiedEmail()) {
            return redirect()->route('admin.dashboard', ['verified' => true]);
        }

        if ($admin->markEmailAsVerified()) {
            event(new Verified($admin));
        }

        return redirect()->route('admin.dashboard', ['verified' => true]);
    }
}
