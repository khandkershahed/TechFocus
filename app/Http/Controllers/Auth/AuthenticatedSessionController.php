<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form based on user_type query parameter.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
{
    // Get user_type from query string, default to 'client'
    $userType = $request->query('type', 'client');

    // Ensure user_type is either 'client' or 'partner'
    if (!in_array($userType, ['client', 'partner'])) {
        $userType = 'client';
    }

    // Load the appropriate view based on user_type
    if ($userType === 'partner') {
        return view('frontend.Auth.partner-login', compact('userType'));
    } else {
        return view('frontend.pages.client.auth.login', compact('userType'));
    }
}


    /**
     * Handle login request for client and partner.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
                public function store(Request $request)
                {
                    $request->validate([
                        'email'     => 'required|email',
                        'password'  => 'required|string',
                        'user_type' => 'required|in:client,partner',
                    ]);

                    $user = \App\Models\User::where('email', $request->email)
                                ->where('user_type', $request->user_type)
                                ->first();

                    if (!$user) {
                        return back()->withErrors([
                            'login_error' => 'No account found with this email and user type.'
                        ])->onlyInput('email');
                    }

                    if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
                        return back()->withErrors([
                            'login_error' => 'Incorrect password.'
                        ])->onlyInput('email');
                    }

                    // Login the user
                    Auth::login($user);
                    $request->session()->regenerate();

                    return $user->user_type === 'partner'
                        ? redirect()->route('partner.dashboard')
                        : redirect()->route('client.dashboard');
                }


    /**
     * Logout user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
