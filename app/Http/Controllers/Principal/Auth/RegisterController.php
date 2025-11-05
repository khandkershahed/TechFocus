<?php

namespace App\Http\Controllers\Principal\Auth;

use App\Http\Controllers\Controller;
use App\Models\Principal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    // Show registration form
    public function show()
    {
        return view('principal.auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:principals,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Create Principal
        $principal = Principal::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Store email in session for verification resend
        $request->session()->put('principal_email', $principal->email);

        // Fire email verification
        event(new Registered($principal));
// dd($principal);
        // Redirect to email verification notice WITH SweetAlert
        return view('principal.auth.verify-email')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Registration Successful!',
                'text' => 'Please check your email for verification link.',
                'timer' => 5000
            ]);
    }
}