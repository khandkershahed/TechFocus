<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the Partner Dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ensure only partners can access this page
        $user = Auth::user();

        if (!$user || $user->user_type !== 'partner') {
            abort(403, 'Unauthorized access. This area is for partners only.');
        }

        return view('frontend.partner.dashboard', [
            'user' => $user,
        ]);
    }

    /**
     * Logout the partner user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('partner.login')->with('success', 'You have been logged out successfully.');
    }
}
