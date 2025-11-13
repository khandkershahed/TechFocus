<?php

namespace App\Http\Controllers\Principal;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PrincipalProfileController extends Controller
{
 public function edit()
{
    $countries = Country::orderBy('name')->get();
    $principal = Auth::guard('principal')->user()->load(['contacts', 'addresses']);

    // Pass both principal and countries to the view
    return view('principal.profile.edit', compact('principal', 'countries'));
}

public function update(Request $request)
{
    $principal = Auth::guard('principal')->user();

    $validated = $request->validate([
        'legal_name' => 'required|string|max:255',
        'trading_name' => 'nullable|string|max:255',
        'entity_type' => 'nullable|string',
        'website_url' => 'nullable|url|max:255',
        'hq_city' => 'nullable|string|max:255',
        'country_iso' => 'nullable|string|size:2',
        'relationship_status' => 'nullable|string',
        'notes' => 'nullable|string',
    ]);

    $principal->update($validated);

    return redirect()->route('principal.dashboard')
                     ->with('alert', 'Profile updated successfully!');
}

}
