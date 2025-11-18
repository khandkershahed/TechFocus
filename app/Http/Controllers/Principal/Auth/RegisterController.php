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
        // Validate principal basics + contacts + addresses
        $request->validate([
            'legal_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'trading_name' => 'nullable|string|max:255',
            'entity_type' => 'nullable|in:Manufacturer,Distributor,Supplier,Other',
            'website_url' => 'nullable|url|max:255',
            'hq_city' => 'nullable|string|max:255',
            'country_iso' => 'nullable|string|size:2',
            'email' => 'required|email|unique:principals,email',
            'password' => 'required|confirmed|min:6',

            'contacts.*.contact_name' => 'required|string|max:255',
            'contacts.*.email' => 'nullable|email',
            'contacts.*.phone_e164' => 'nullable|string',
            'addresses.*.line1' => 'required|string|max:255',
            'addresses.*.type' => 'required|in:HQ,Billing,Shipping,Other',
        ]);

        // Create Principal
        $principal = Principal::create([
            'name' => $request->legal_name,
            'legal_name' => $request->legal_name,
            'company_name'=>$request->company_name,
            'trading_name' => $request->trading_name,
            'entity_type' => $request->entity_type,
            'website_url' => $request->website_url,
            'hq_city' => $request->hq_city,
            'country_iso' => $request->country_iso,
            'relationship_status' => 'Prospect',
            'notes' => null,
            'email' => $request->email,  
            'password' => Hash::make($request->password),
        ]);

        // Save contacts
        if ($request->has('contacts')) {
            foreach ($request->contacts as $contact) {
                $principal->contacts()->create([
                    'contact_name' => $contact['contact_name'],
                    'job_title' => $contact['job_title'] ?? null,
                    'email' => $contact['email'] ?? null,
                    'phone_e164' => $contact['phone_e164'] ?? null,
                    'whatsapp_e164' => $contact['whatsapp_e164'] ?? null,
                    'wechat_id' => $contact['wechat_id'] ?? null,
                    'preferred_channel' => $contact['preferred_channel'] ?? null,
                    'is_primary' => isset($contact['is_primary']),
                ]);
            }
        }

        // Save addresses
        if ($request->has('addresses')) {
            foreach ($request->addresses as $address) {
                $principal->addresses()->create($address);
            }
        }

        // Store email in session for verification resend
        $request->session()->put('principal_email', $principal->email);

        // Fire email verification
        event(new Registered($principal));

        // Redirect to email verification notice WITH SweetAlert
        return view('principal.auth.verify-email')->with('swal', [
            'icon' => 'success',
            'title' => 'Registration Successful!',
            'text' => 'Please check your email for verification link.',
            'timer' => 5000
        ]);
    }
}
