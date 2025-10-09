<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerLoginController extends Controller
{
    public function showLoginForm()
{
    return view('frontend.Auth.partner-login'); // match folder structure
}


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Add user_type = 'partner' to ensure only partners log in here
        $credentials['user_type'] = 'partner';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('partner.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or you are not a partner.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
