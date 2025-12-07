<?php

namespace App\Http\Controllers\Principal;

use App\Models\Country;
use App\Models\Principal;
use Illuminate\Http\Request;
use App\Models\PrincipalAddress;
use App\Models\PrincipalContact;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PrincipalProfileController extends Controller
{
    public function edit()
    {
        $countries = Country::orderBy('name')->get();
        $principal = Auth::guard('principal')->user()->load(['contacts', 'addresses']);

        return view('principal.profile.edit', compact('principal', 'countries'));
    }

    public function update(Request $request)
    {
        $principal = Auth::guard('principal')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'legal_name' => 'required|string|max:255',
            'trading_name' => 'nullable|string|max:255',
            'entity_type' => 'nullable|string',
            'website_url' => 'nullable|url|max:255',
            'hq_city' => 'nullable|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
            'relationship_status' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $principal->update($validated);

        return redirect()->route('principal.profile.edit')
                         ->with('alert', 'Profile updated successfully!');
    }

    public function updateContacts(Request $request)
    {
        $principal = Auth::guard('principal')->user();
        
        $validated = $request->validate([
            'contacts' => 'required|array',
            'contacts.*.id' => 'nullable|exists:principal_contacts,id',
            'contacts.*.contact_name' => 'required|string|max:255',
            'contacts.*.job_title' => 'nullable|string|max:255',
            'contacts.*.email' => 'nullable|email|max:255',
            'contacts.*.phone_e164' => 'nullable|string|max:20',
            'contacts.*.whatsapp_e164' => 'nullable|string|max:20',
            'contacts.*.wechat_id' => 'nullable|string|max:255',
            'contacts.*.preferred_channel' => 'nullable|string|max:50',
            'contacts.*.is_primary' => 'nullable|boolean',
        ]);

        foreach ($validated['contacts'] as $contactData) {
            if (isset($contactData['id'])) {
                // Update existing contact
                $contact = PrincipalContact::where('id', $contactData['id'])
                    ->where('principal_id', $principal->id)
                    ->first();
                
                if ($contact) {
                    $contact->update($contactData);
                }
            } else {
                // Create new contact
                $principal->contacts()->create($contactData);
            }
        }

        return redirect()->route('principal.profile.edit')
                         ->with('alert', 'Contacts updated successfully!');
    }

    public function updateAddresses(Request $request)
    {
        $principal = Auth::guard('principal')->user();
        
        $validated = $request->validate([
            'addresses' => 'required|array',
            'addresses.*.id' => 'nullable|exists:principal_addresses,id',
            'addresses.*.type' => 'nullable|string|max:50',
            'addresses.*.country_id' => 'nullable|exists:countries,id',
            'addresses.*.line1' => 'required|string|max:255',
            'addresses.*.line2' => 'nullable|string|max:255',
            'addresses.*.city' => 'nullable|string|max:255',
            'addresses.*.state' => 'nullable|string|max:255',
            'addresses.*.postal' => 'nullable|string|max:50',
        ]);

        foreach ($validated['addresses'] as $addressData) {
            if (isset($addressData['id'])) {
                // Update existing address
                $address = PrincipalAddress::where('id', $addressData['id'])
                    ->where('principal_id', $principal->id)
                    ->first();
                
                if ($address) {
                    $address->update($addressData);
                }
            } else {
                // Create new address
                $principal->addresses()->create($addressData);
            }
        }

        return redirect()->route('principal.profile.edit')
                         ->with('alert', 'Addresses updated successfully!');
    }
}