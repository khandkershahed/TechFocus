<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display the Partner Dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user || $user->user_type !== 'partner') {
            abort(403, 'Unauthorized access. This area is for partners only.');
        }

        // Example stats (replace with actual queries)
        $totalRfqs = 10;
        $pendingQuotations = 5;
        $approvedDeals = 3;

        return view('frontend.partner.dashboard', compact(
            'user', 'totalRfqs', 'pendingQuotations', 'approvedDeals'
        ));
    }

    /**
     * Update partner profile information, including photo and all optional fields.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate request
        $request->validate([
            'name'                  => 'required|string|max:255',
            'username'              => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email'                 => 'required|email|unique:users,email,' . $user->id,
            'phone'                 => 'nullable|string|max:20',
            'company'               => 'nullable|string|max:255',
            'city'                  => 'nullable|string|max:255',
           
            'profile_image'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            // All other optional fields
            'address'               => 'nullable|string',
            'postal'                => 'nullable|string',
            'status'                => 'nullable|in:active,inactive,suspended,disabled',
            'support_tier'          => 'nullable|string',
            'support_tier_description'=> 'nullable|string',
            'company_phone_number'  => 'nullable|string',
            'company_logo'          => 'nullable|string',
            'company_url'           => 'nullable|string',
            'company_established_date'=> 'nullable|date',
            'company_address'       => 'nullable|string',
            'vat_number'            => 'nullable|string',
            'tax_number'            => 'nullable|string',
            'trade_license_number'  => 'nullable|string',
            'tin_number'            => 'nullable|string',
            'tin'                   => 'nullable|string',
            'bin_certificate'       => 'nullable|string',
            'trade_license'         => 'nullable|string',
            'audit_paper'           => 'nullable|string',
            'industry_id_percentage'=> 'nullable|string',
            'product'               => 'nullable|string',
            'solution'              => 'nullable|string',
            'working_country'       => 'nullable|string',
            'yearly_revenue'        => 'nullable|string',
            'contact_person_name'   => 'nullable|string',
            'contact_person_email'  => 'nullable|email',
            'contact_person_phone'  => 'nullable|string',
            'contact_person_address'=> 'nullable|string',
            'contact_person_designation'=> 'nullable|string',
            'tier'                  => 'nullable|string',
            'comments'              => 'nullable|string',
            'country_id'            => 'nullable|integer|exists:countries,id',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_image')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('profile_image')->store('partner_photos', 'public');
        }

        // Update fields (map form input to DB)
        $user->name                  = $request->name;
        $user->username              = $request->username;
        $user->email                 = $request->email;
        $user->phone                 = $request->phone;
        $user->company_name          = $request->company;
        $user->city                  = $request->city;
       

        $user->address               = $request->address;
        $user->postal                = $request->postal;
        $user->status                = $request->status;
        $user->support_tier          = $request->support_tier;
        $user->support_tier_description = $request->support_tier_description;

        $user->company_phone_number  = $request->company_phone_number;
        $user->company_logo          = $request->company_logo;
        $user->company_url           = $request->company_url;
        $user->company_established_date = $request->company_established_date;
        $user->company_address       = $request->company_address;

        $user->vat_number            = $request->vat_number;
        $user->tax_number            = $request->tax_number;
        $user->trade_license_number  = $request->trade_license_number;
        $user->tin_number            = $request->tin_number;
        $user->tin                   = $request->tin;
        $user->bin_certificate       = $request->bin_certificate;
        $user->trade_license         = $request->trade_license;
        $user->audit_paper           = $request->audit_paper;

        $user->industry_id_percentage = $request->industry_id_percentage;
        $user->product               = $request->product;
        $user->solution              = $request->solution;
        $user->working_country       = $request->working_country;
        $user->yearly_revenue        = $request->yearly_revenue;

        $user->contact_person_name   = $request->contact_person_name;
        $user->contact_person_email  = $request->contact_person_email;
        $user->contact_person_phone  = $request->contact_person_phone;
        $user->contact_person_address= $request->contact_person_address;
        $user->contact_person_designation = $request->contact_person_designation;

        $user->tier                  = $request->tier;
        $user->comments              = $request->comments;
        $user->country_id            = $request->country_id;

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Logout the partner user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('partner.login')->with('success', 'You have been logged out successfully.');
    }
}
