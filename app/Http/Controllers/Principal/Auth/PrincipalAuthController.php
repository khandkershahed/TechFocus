<?php

namespace App\Http\Controllers\Principal\Auth;

use App\Http\Controllers\Controller;
use App\Models\Principal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PrincipalAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('principal.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('principal')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->route('principal.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid login credentials']);
    }

    public function showRegisterForm()
    {
        return view('principal.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:principals,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $principal = Principal::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('principal')->login($principal);

        return redirect()->route('principal.verification.notice');
    }

    public function logout()
    {
        Auth::guard('principal')->logout();

        return redirect()->route('principal.login');
    }
}
