<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserListController extends Controller
{
    // -------------------- Clients --------------------

    // List Clients
    public function clientsList()
    {
        $clients = User::where('user_type', 'client')->get();
        $clients = User::where('user_type', 'client')->paginate(10); // 10 per pag
        return view('frontend.pages.lists.clients', compact('clients'));
    }

    // Edit Client
    public function editClient($id)
    {
        $client = User::where('user_type', 'client')->findOrFail($id);
        return view('frontend.pages.lists.edit-client', compact('client'));
    }

    // Update Client
    public function updateClient(Request $request, $id)
    {
        $client = User::where('user_type', 'client')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive,suspended,disabled',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($client->photo && Storage::disk('public')->exists($client->photo)) {
                Storage::disk('public')->delete($client->photo);
            }
            $client->photo = $request->file('photo')->store('client_photos', 'public');
        }

        $client->update($request->only([
            'name', 'email', 'phone', 'company_name', 'status', 'photo'
        ]));

        return redirect()->route('clients.list')->with('success', 'Client updated successfully.');
    }

    // Delete Client
    public function deleteClient($id)
    {
        $client = User::where('user_type', 'client')->findOrFail($id);

        // Delete photo if exists
        if ($client->photo && Storage::disk('public')->exists($client->photo)) {
            Storage::disk('public')->delete($client->photo);
        }

        $client->delete();
        return back()->with('success', 'Client deleted successfully.');
    }

    // -------------------- Partners --------------------

    // List Partners
    public function partnersList()
    {
        $partners = User::where('user_type', 'partner')->get();
        $partners = User::where('user_type', 'partner')->paginate(10);

        return view('frontend.pages.lists.partners', compact('partners'));
    }

    // Edit Partner
    public function editPartner($id)
    {
        $partner = User::where('user_type', 'partner')->findOrFail($id);
        return view('frontend.pages.lists.edit-partner', compact('partner'));
    }

    // Update Partner
    public function updatePartner(Request $request, $id)
    {
        $partner = User::where('user_type', 'partner')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $partner->id,
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive,suspended,disabled',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($partner->photo && Storage::disk('public')->exists($partner->photo)) {
                Storage::disk('public')->delete($partner->photo);
            }
            $partner->photo = $request->file('photo')->store('partner_photos', 'public');
        }

        $partner->update($request->only([
            'name', 'email', 'phone', 'company_name', 'status', 'photo'
        ]));

        return redirect()->route('partners.list')->with('success', 'Partner updated successfully.');
    }

    // Delete Partner
    public function deletePartner($id)
    {
        $partner = User::where('user_type', 'partner')->findOrFail($id);

        // Delete photo if exists
        if ($partner->photo && Storage::disk('public')->exists($partner->photo)) {
            Storage::disk('public')->delete($partner->photo);
        }

        $partner->delete();
        return back()->with('success', 'Partner deleted successfully.');
    }
}
