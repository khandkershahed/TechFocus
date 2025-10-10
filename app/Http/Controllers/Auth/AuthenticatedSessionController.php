<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Favorite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form based on user_type query parameter.
     */
    public function create(Request $request)
    {
        $userType = $request->query('type', 'client');
        if (!in_array($userType, ['client', 'partner'])) {
            $userType = 'client';
        }

        if ($userType === 'partner') {
            return view('frontend.Auth.partner-login', compact('userType'));
        }

        return view('frontend.pages.client.auth.login', compact('userType'));
    }

    /**
     * Handle login request for client and partner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|string',
            'user_type' => 'required|in:client,partner',
        ]);

        $user = User::where('email', $request->email)
                    ->where('user_type', $request->user_type)
                    ->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login_error' => 'Invalid email or password.'
            ])->onlyInput('email');
        }

        // Login the user
        Auth::login($user);
        $request->session()->regenerate();

        // ✅ Handle redirect and adding product to favorites
        $redirectTo = $request->input('redirect_to', null);
        $productId  = $request->input('product_id', null);

        if ($productId) {
            Favorite::firstOrCreate([
                'user_id'    => $user->id,
                'product_id' => $productId,
            ]);
        }

        // Redirect back to the page where user clicked favorite, or fallback to dashboard
        if ($redirectTo) {
            return redirect()->to($redirectTo)
                             ->with('success', 'Logged in successfully and product added to favorites!');
        }

        return $user->user_type === 'partner'
            ? redirect()->route('partner.dashboard')->with('success', 'Logged in successfully!')
            : redirect()->route('client.dashboard')->with('success', 'Logged in successfully!');
    }

    /**
     * Logout user
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
