<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Show Client Dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        return view('frontend.pages.client.dashboard', compact('user'));
    }

    /**
     * Show Client Profile Page
     */
    public function profile()
    {
        $this->authorizeClient();
        $user = Auth::user();
        return view('frontend.pages.client.profile', compact('user'));
    }

    /**
     * Update Client Profile
     */
    public function updateProfile(Request $request)
    {
        $this->authorizeClient();
        $user = Auth::user();

        $request->validate([
            'name'                     => 'required|string|max:255',
            'username'                 => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'first_name'               => 'nullable|string|max:255',
            'last_name'                => 'nullable|string|max:255',
            'email'                    => 'required|email|unique:users,email,' . $user->id,
            'phone'                    => 'nullable|string|max:20',
            'company_name'             => 'nullable|string|max:255',
            'company_phone_number'     => 'nullable|string|max:50',
            'company_url'              => 'nullable|url|max:255',
            'company_established_date' => 'nullable|date',
            'company_address'          => 'nullable|string',
            'city'                     => 'nullable|string|max:100',
            'postal'                   => 'nullable|string|max:20',
            'status'                   => 'nullable|in:active,inactive,suspended,disabled',
            'vat_number'               => 'nullable|string|max:100',
            'tax_number'               => 'nullable|string|max:100',
            'trade_license_number'     => 'nullable|string|max:100',
            'tin_number'               => 'nullable|string|max:100',
            'industry_id_percentage'   => 'nullable|string',
            'product'                  => 'nullable|string',
            'solution'                 => 'nullable|string',
            'working_country'          => 'nullable|string',
            'yearly_revenue'           => 'nullable|string',
            'contact_person_name'      => 'nullable|string|max:255',
            'contact_person_email'     => 'nullable|email|max:255',
            'contact_person_phone'     => 'nullable|string|max:50',
            'contact_person_designation'=> 'nullable|string|max:255',
            'comments'                 => 'nullable|string',
            'profile_image'            => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('profile_image')->store('client_photos', 'public');
        }

        // Update all fields
        $user->name                     = $request->name;
        $user->username                 = $request->username;
       
        $user->email                    = $request->email;
        $user->phone                    = $request->phone;
        $user->company_name             = $request->company_name;
        $user->company_phone_number     = $request->company_phone_number;
        $user->company_url              = $request->company_url;
        $user->company_established_date = $request->company_established_date;
        $user->company_address          = $request->company_address;
        $user->city                     = $request->city;
        $user->postal                   = $request->postal;
        $user->status                   = $request->status;
        $user->vat_number               = $request->vat_number;
        $user->tax_number               = $request->tax_number;
        $user->trade_license_number     = $request->trade_license_number;
        $user->tin_number               = $request->tin_number;
        $user->industry_id_percentage   = $request->industry_id_percentage;
        $user->product                  = $request->product;
        $user->solution                 = $request->solution;
        $user->working_country          = $request->working_country;
        $user->yearly_revenue           = $request->yearly_revenue;
        $user->contact_person_name      = $request->contact_person_name;
        $user->contact_person_email     = $request->contact_person_email;
        $user->contact_person_phone     = $request->contact_person_phone;
        $user->contact_person_designation = $request->contact_person_designation;
        $user->comments                 = $request->comments;

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Logout the client
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Check if authenticated user is a client
     */
    private function authorizeClient()
    {
        if (!Auth::check() || Auth::user()->user_type !== 'client') {
            abort(403, 'Unauthorized access.');
        }
    }
}
