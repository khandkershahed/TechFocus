<?php

namespace App\Http\Controllers\Principal\Auth;

use App\Http\Controllers\Controller;
use App\Models\Principal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Country;

class PrincipalAuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('principal.auth.login');
    }

    /**
     * Handle login with AJAX
     */
  public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::guard('principal')->attempt($request->only('email', 'password'))) {
        $principal = Auth::guard('principal')->user();

        // Check email verification
        if (!$principal->hasVerifiedEmail()) {
            Auth::guard('principal')->logout();
            return redirect()->route('principal.verification.notice')
                             ->with('swal', [
                                 'icon' => 'warning',
                                 'title' => 'Email Not Verified',
                                 'text' => 'Please verify your email before logging in.'
                             ]);
        }

        // Check admin approval
        if ($principal->status !== 'active') {
            Auth::guard('principal')->logout();
            return redirect()->route('principal.login')
                             ->with('swal', [
                                 'icon' => 'info',
                                 'title' => 'Admin Approval Pending',
                                 'text' => 'Your email is verified but you need admin approval to login.'
                             ]);
        }

        // Success login
        return redirect()->route('principal.dashboard')
                         ->with('swal', [
                             'icon' => 'success',
                             'title' => 'Welcome!',
                             'text' => 'Login successful.'
                         ]);
    }

    return redirect()->back()
                     ->withInput($request->only('email'))
                     ->with('swal', [
                         'icon' => 'error',
                         'title' => 'Login Failed',
                         'text' => 'Invalid login credentials.'
                     ]);
}


    /**
     * Show register form
     */
   public function showRegisterForm()
{
    // Fetch all countries ordered by name
    $countries = Country::orderBy('name')->get();

    // Pass countries to the register view
    return view('principal.auth.register', compact('countries'));
}

    /**
     * Handle registration
     */
public function register(Request $request)
{
    $request->validate([
        'legal_name' => 'required|string|max:255',
        'name'       => 'required|string|max:255',
        'email'      => 'required|email|unique:principals,email',
        'password'   => 'required|confirmed|min:6',
    ]);

    // Create principal with default status 'inactive' (waiting for admin approval)
    $principal = Principal::create([
        'legal_name' => $request->legal_name,
        'name'       => $request->name,
        'email'      => $request->email,
        'slug'       => Str::slug($request->name . '-' . uniqid()),
        'password'   => Hash::make($request->password),
        'status'     => 'inactive', // waiting for admin approval
        'created_by' => 0,
        'updated_by' => 0,
    ]);

    // Send email verification
    if ($principal instanceof \Illuminate\Contracts\Auth\MustVerifyEmail) {
        $principal->sendEmailVerificationNotification();
    }
// Redirect to principal login or verification notice
return redirect()->route('principal.login') // <- principal login page
                 ->with([
                     'swal' => [
                         'icon'  => 'success',
                         'title' => 'Registration Successful!',
                         'text'  => 'Please check your email to verify your account. After verification, wait for admin approval.',
                         'timer' => 5000,
                     ]
                 ]);

}


    /**
     * Logout
     */
    public function logout()
    {
        Auth::guard('principal')->logout();
        return redirect()->route('principal.login');
    }
}
