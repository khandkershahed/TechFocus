<?php

namespace App\Http\Controllers\Principal\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Principal;

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

        // Check if principal exists
        $principal = Principal::where('email', $request->email)->first();

        if ($principal) {
            // Check status before attempting login
            if ($principal->status !== 'active') {
                // Return with SweetAlert data but without validation errors
                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->with('swal', [
                        'icon' => 'warning',
                        'title' => 'Account Not Active',
                        'text' => $this->getStatusMessage($principal->status)
                    ]);
            }

            // Check email verification
            if (!$principal->hasVerifiedEmail()) {
                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->with('swal', [
                        'icon' => 'info',
                        'title' => 'Email Verification Required',
                        'text' => 'Please verify your email first. Check your inbox for verification link.'
                    ]);
            }
        }

        if (Auth::guard('principal')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('principal.dashboard'))
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Login Successful!',
                    'text' => 'Welcome back to your dashboard.',
                    'timer' => 3000
                ]);
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('swal', [
                'icon' => 'error',
                'title' => 'Login Failed',
                'text' => 'Invalid email or password.'
            ]);
    }

    /**
     * Get appropriate message based on status
     */
    private function getStatusMessage($status)
    {
        switch ($status) {
            case 'inactive':
                return 'Your account status is inactive. Wait for admin active status approval.';
            case 'suspended':
                return 'Your account has been suspended. Please contact administrator.';
            case 'disabled':
                return 'Your account has been disabled.';
            default:
                return 'Your account is not active. Please contact support.';
        }
    }

    // // Handle logout
    // public function logout(Request $request)
    // {
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     Auth::guard('principal')->logout();

    //     return redirect()->route('principal.login')->with('swal', [
    //         'icon' => 'success',
    //         'title' => 'Logged Out',
    //         'text' => 'You have been successfully logged out.',
    //         'timer' => 3000
    //     ]);
    // }
    // Handle logout - Simple Technique
public function logout(Request $request)
{
    // Get the principal before logging out (if needed for any operations)
    $principal = Auth::guard('principal')->user();
    
    // Update last seen before logout (optional)
    if ($principal) {
        $principal->update(['last_seen' => now()]);
    }
    
    // Simple logout process
    Auth::guard('principal')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirect with success message
    return redirect()->route('principal.login')->with('swal', [
        'icon' => 'success',
        'title' => 'Logged Out Successfully',
        'text' => 'You have been logged out of your account.',
        'timer' => 3000
    ]);
}
}