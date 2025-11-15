<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Principal;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PrincipalLink;

class PrincipalController extends Controller
{
    /**
     * Display a listing of principals with search, filters, sort, and pagination.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $filters = $request->only([
            'entity_type', 'country', 'relationship_status', 'brand', 'authorization_type', 'has_ndas', 'owner'
        ]);
        $sort = $request->input('sort', 'recently_updated'); // default sort

        $principals = Principal::withCount(['brands', 'products'])
            ->with('country')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('company_name', 'like', "%{$search}%")
                      ->orWhereHas('country', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                      ->orWhereHas('brands', fn($q3) => $q3->where('name', 'like', "%{$search}%"))
                      ->orWhereHas('products', fn($q4) => $q4->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($filters['entity_type'] ?? null, fn($q, $val) => $q->where('entity_type', $val))
            ->when($filters['country'] ?? null, fn($q, $val) => $q->where('country_id', $val))
            ->when($filters['relationship_status'] ?? null, fn($q, $val) => $q->where('relationship_status', $val))
            ->when($filters['brand'] ?? null, fn($q, $val) => $q->whereHas('brands', fn($q2) => $q2->where('id', $val)))
            ->when($filters['authorization_type'] ?? null, fn($q, $val) => $q->where('authorization_type', $val))
            ->when($filters['has_ndas'] ?? null, fn($q, $val) => $q->where('has_ndas', $val))
            ->when($filters['owner'] ?? null, fn($q, $val) => $q->where('owner', 'like', "%{$val}%"))
            ->when($sort, function ($query, $sort) {
                match ($sort) {
                    'name' => $query->orderBy('name'),
                    'country' => $query->join('countries', 'principals.country_id', '=', 'countries.id')
                                      ->orderBy('countries.name')->select('principals.*'),
                    'last_activity' => $query->orderBy('last_seen', 'desc'),
                    default => $query->latest('updated_at'), // recently_updated
                };
            })
            ->paginate(20)
            ->withQueryString();

        return view('admin.principals.index', compact('principals', 'search', 'filters', 'sort'));
    }

    /**
     * Show principal details with brands, products, contacts, addresses, and country.
     */
    // public function show(Principal $principal): View
    // {
    //     $principal->load('country', 'brands', 'products', 'contacts', 'addresses');
    //     return view('admin.principals.show', compact('principal'));
    // }
    public function show(Principal $principal): View
    {
        $principal->load('country', 'brands', 'products', 'contacts', 'addresses');
        
        // Load principal links with pagination
        $links = PrincipalLink::where('principal_id', $principal->id)
            ->latest()
            ->paginate(10);
            
        return view('admin.principals.show', compact('principal', 'links'));
    }
    /**
     * Update principal status.
     */
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

        // Optional: force logout if status changes from active
        if ($oldStatus === 'active' && $newStatus !== 'active') {
            // Add logic to logout the principal if needed
        }

        return back()->with('success', 'Principal status updated successfully.');
    }

    /**
     * Get principals statistics for admin dashboard.
     */
    public function getStats()
    {
        $totalPrincipals = Principal::count();
        $activePrincipals = Principal::where('status', 'active')->count();
        $verifiedPrincipals = Principal::whereNotNull('email_verified_at')->count();
        $onlinePrincipals = Principal::where('last_seen', '>=', now()->subMinutes(5))->count();

        $totalBrands = Brand::count();
        $totalProducts = Product::count();

        return [
            'total' => $totalPrincipals,
            'active' => $activePrincipals,
            'verified' => $verifiedPrincipals,
            'online' => $onlinePrincipals,
            'total_brands' => $totalBrands,
            'total_products' => $totalProducts
        ];
    }

    /**
     * Remove the specified principal.
     */
    public function destroy(Principal $principal)
    {
        if ($principal->id === 1) {
            return back()->with('error', 'Cannot delete this principal.');
        }

        $principal->brands()->delete();
        $principal->products()->delete();
        $principal->delete();

        return redirect()->route('admin.principals.index')
            ->with('success', 'Principal deleted successfully.');
    }
}
