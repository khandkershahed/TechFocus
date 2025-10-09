<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class PartnerLoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        // Pass redirect info if coming from add-to-favorites
        $redirectTo = $request->query('redirect_to');
        $productId  = $request->query('product_id');

        return view('frontend.Auth.partner-login', compact('redirectTo', 'productId'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['user_type'] = 'partner';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check if redirect info is present (from add-to-favorites)
            $redirectTo = $request->input('redirect_to');
            $productId  = $request->input('product_id');

            if ($productId) {
                // Add the clicked product to favorites
                Favorite::firstOrCreate([
                    'user_id'    => Auth::id(),
                    'product_id' => $productId,
                ]);
            }

            // Redirect to original product page or dashboard
            if ($redirectTo) {
                return redirect()->to($redirectTo)
                    ->with('success', 'Logged in successfully and product added to favorites!');
            }

            return redirect()->route('partner.dashboard')
                ->with('success', 'Logged in successfully!');
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

        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
