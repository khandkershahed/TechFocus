<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Principal;
use App\Models\PrincipalAddress;
use Illuminate\Http\Request;

class PrincipalAddressController extends Controller
{
    /**
     * Store a new address for a principal.
     */
    public function store(Request $request, Principal $principal)
    {
        $request->validate([
            'type' => 'required|in:HQ,Billing,Shipping,Other',
            'line1' => 'required|string|max:255',
            'line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal' => 'nullable|string|max:50',
            'country_iso' => 'nullable|string|size:2',
        ]);

        $principal->addresses()->create($request->all());

        return back()->with('success', 'Address added successfully!');
    }

    /**
     * Update an existing address.
     */
    public function update(Request $request, PrincipalAddress $address)
    {
        $request->validate([
            'type' => 'required|in:HQ,Billing,Shipping,Other',
            'line1' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal' => 'nullable|string|max:50',
            'country_iso' => 'nullable|string|size:2',
        ]);

        $address->update($request->all());

        return back()->with('success', 'Address updated successfully!');
    }

    /**
     * Delete an address.
     */
    public function destroy(PrincipalAddress $address)
    {
        $address->delete();

        return back()->with('success', 'Address deleted successfully!');
    }
}
