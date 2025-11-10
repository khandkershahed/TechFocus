<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Principal;
use App\Models\PrincipalContact;
use Illuminate\Http\Request;

class PrincipalContactController extends Controller
{
    /**
     * Store a newly created contact for a principal.
     */
    public function store(Request $request, Principal $principal)
    {
        $request->validate([
            'contact_name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_e164' => 'nullable|string|max:50',
            'whatsapp_e164' => 'nullable|string|max:50',
            'wechat_id' => 'nullable|string|max:100',
            'preferred_channel' => 'nullable|string|max:50',
            'is_primary' => 'nullable|boolean',
        ]);

        $principal->contacts()->create($request->all());

        return back()->with('success', 'Contact added successfully!');
    }

    /**
     * Update an existing contact.
     */
    public function update(Request $request, PrincipalContact $contact)
    {
        $request->validate([
            'contact_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_e164' => 'nullable|string|max:50',
            'preferred_channel' => 'nullable|string|max:50',
        ]);

        $contact->update($request->all());

        return back()->with('success', 'Contact updated successfully!');
    }

    /**
     * Remove a contact.
     */
    public function destroy(PrincipalContact $contact)
    {
        $contact->delete();

        return back()->with('success', 'Contact deleted successfully!');
    }
}
