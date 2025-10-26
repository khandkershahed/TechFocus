<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PartnerRegisterController extends Controller
{
    /**
     * Show the partner registration form
     */
    public function create()
    {
        return view('frontend.pages.client.auth.register'); // your partner register view
    }

    /**
     * Handle partner registration request
     */
    public function store(Request $request)
    {
        // Validate form input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
        ]);

        // Create partner user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'password' => Hash::make($request->password),
            'user_type' => 'partner', // automatically set as partner
            'status' => 'inactive', // optional: default status
        ]);

        // Redirect to partner login page
        return redirect()->route('partner.login')->with('success', 'Partner registered successfully! Please login.');
    }
}
