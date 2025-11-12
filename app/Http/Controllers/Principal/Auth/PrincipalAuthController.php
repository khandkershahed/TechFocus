<?php

namespace App\Http\Controllers\Principal\Auth;

use App\Http\Controllers\Controller;
use App\Models\Principal;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
     * Handle login
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
     * Show registration form
     */
    public function showRegisterForm()
    {
        $countries = Country::orderBy('name')->get();
        return view('principal.auth.register', compact('countries'));
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        try {
            // Validate multi-step registration fields
            $request->validate([
                'legal_name' => 'required|string|max:255',
                'trading_name' => 'nullable|string|max:255',
                'entity_type' => 'nullable|string|max:255',
                'website_url' => 'nullable|url|max:255',
                'hq_city' => 'nullable|string|max:255',
                'country_iso' => 'nullable|string|max:10',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:principals,email',
                'password' => 'required|confirmed|min:6',

                'contacts.*.contact_name' => 'required|string|max:255',
                'contacts.*.email' => 'nullable|email',
                'contacts.*.phone_e164' => 'nullable|string|max:20',

                'addresses.*.line1' => 'required|string|max:255',
                'addresses.*.country_iso' => 'nullable|string|max:10',
                'addresses.*.city' => 'nullable|string|max:255',
                'addresses.*.state' => 'nullable|string|max:255',
                'addresses.*.postal' => 'nullable|string|max:20',
            ]);

            // Create principal
            $principal = Principal::create([
                'legal_name' => $request->legal_name,
                'trading_name' => $request->trading_name,
                'entity_type' => $request->entity_type,
                'website_url' => $request->website_url,
                'hq_city' => $request->hq_city,
                'country_iso' => $request->country_iso,
                'name' => $request->name,
                'email' => $request->email,
                'slug' => Str::slug($request->name . '-' . uniqid()),
                'password' => Hash::make($request->password),
                'status' => 'inactive', // waiting for admin approval
                'created_by' => 0,
                'updated_by' => 0,
            ]);

            // Save contacts
            if ($request->has('contacts')) {
                foreach ($request->contacts as $contactData) {
                    $principal->contacts()->create([
                        'contact_name' => $contactData['contact_name'] ?? null,
                        'job_title' => $contactData['job_title'] ?? null,
                        'email' => $contactData['email'] ?? null,
                        'phone_e164' => $contactData['phone_e164'] ?? null,
                        'whatsapp_e164' => $contactData['whatsapp_e164'] ?? null,
                        'wechat_id' => $contactData['wechat_id'] ?? null,
                        'preferred_channel' => $contactData['preferred_channel'] ?? null,
                        'is_primary' => $contactData['is_primary'] ?? 0,
                    ]);
                }
            }

            // Save addresses
            if ($request->has('addresses')) {
                foreach ($request->addresses as $addressData) {
                    $principal->addresses()->create([
                        'type' => $addressData['type'] ?? 'HQ',
                        'line1' => $addressData['line1'] ?? null,
                        'line2' => $addressData['line2'] ?? null,
                        'country_iso' => $addressData['country_iso'] ?? null,
                        'city' => $addressData['city'] ?? null,
                        'state' => $addressData['state'] ?? null,
                        'postal' => $addressData['postal'] ?? null,
                    ]);
                }
            }

            // Optional notes
            if ($request->filled('message')) {
                $principal->notes = $request->message;
                $principal->save();
            }

            // Optional newsletter subscription
            if ($request->filled('newsletter')) {
                // Newsletter::subscribe($request->email);
            }

            // Send email verification
            if ($principal instanceof \Illuminate\Contracts\Auth\MustVerifyEmail) {
                $principal->sendEmailVerificationNotification();
            }

            return redirect()->route('principal.login')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => 'Registration Successful!',
                    'text' => 'Please check your email to verify your account. After verification, wait for admin approval.',
                    'timer' => 5000,
                ]);

        } catch (\Exception $e) {
            Log::error('Principal Registration Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);

            return redirect()->back()->withInput()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Registration Failed!',
                    'text' => $e->getMessage(),
                    'timer' => 8000,
                ]);
        }
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
