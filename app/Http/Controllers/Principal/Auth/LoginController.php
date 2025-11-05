<?php

namespace App\Http\Controllers\Principal\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login form
    public function show()
    {
        return view('principal.auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('principal')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Check email verification
            if (!Auth::guard('principal')->user()->hasVerifiedEmail()) {
                Auth::guard('principal')->logout();
                return redirect()->route('principal.login')
                    ->with('error', 'Please verify your email first.');
            }

            return redirect()->intended(route('principal.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::guard('principal')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('principal.login')->with('success', 'Logged out successfully.');
    }
}
