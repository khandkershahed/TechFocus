<?php

namespace App\Http\Controllers\Admin;

use App\Models\Principal;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PrincipalController extends Controller
{
    /**
     * Display a listing of the principals.
     */
    public function index(): View
    {
        $principals = Principal::latest()
            ->with('country')
            ->get();

        return view('admin.principals.index', compact('principals'));
    }

    /**
     * Show the principal details.
     */
    public function show(Principal $principal): View
    {
        $principal->load('country');
        
        return view('admin.principals.show', compact('principal'));
    }

    /**
     * Update principal status.
     */
    // public function updateStatus(Request $request, Principal $principal)
    // {
    //     $request->validate([
    //         'status' => 'required|in:active,inactive,suspended,disabled'
    //     ]);

    //     $principal->update([
    //         'status' => $request->status,
    //         'updated_by' => auth()->id()
    //     ]);

    //     return back()->with('success', 'Principal status updated successfully.');
    // }

    /**
     * Get principals statistics for dashboard.
     */
    public function getStats()
    {
        $totalPrincipals = Principal::count();
        $activePrincipals = Principal::where('status', 'active')->count();
        $verifiedPrincipals = Principal::whereNotNull('email_verified_at')->count();
        $onlinePrincipals = Principal::where('last_seen', '>=', now()->subMinutes(5))->count();

        return [
            'total' => $totalPrincipals,
            'active' => $activePrincipals,
            'verified' => $verifiedPrincipals,
            'online' => $onlinePrincipals
        ];
    }
    public function updateStatus(Request $request, Principal $principal)
{
    $request->validate([
        'status' => 'required|in:active,inactive,suspended,disabled'
    ]);

    $oldStatus = $principal->status;
    $newStatus = $request->status;

    $principal->update([
        'status' => $newStatus,
        'updated_by' => auth()->id()
    ]);

    // If status changed from active to inactive, log out the principal
    if ($oldStatus === 'active' && $newStatus !== 'active') {
        // You can add logic here to force logout the principal
        // This would require a broadcast/system to notify the principal
    }

    return back()->with('success', 'Principal status updated successfully.');
}
}