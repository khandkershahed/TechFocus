<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Brand;
use App\Models\Admin\Product;
use App\Models\Principal;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PrincipalLink;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

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

        // Get countries for the filter dropdown
        $countries = Country::all();
        $brands = Brand::orderBy('title', 'ASC')->get();
        $totalBrands = $brands->count();
        $principals = Principal::withCount(['brands', 'products'])
            ->with('country')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    // Search in principal main fields
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('legal_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('company_name', 'like', "%{$search}%")
                      ->orWhere('website_url', 'like', "%{$search}%")
                      ->orWhere('hq_city', 'like', "%{$search}%")
                      ->orWhere('entity_type', 'like', "%{$search}%")
                      ->orWhere('relationship_status', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      ->orWhere('trading_name', 'like', "%{$search}%")
                      // Search in related models
                      ->orWhereHas('country', function ($q2) use ($search) {
                          $q2->where('name', 'like', "%{$search}%")
                           ;
                      })
                      ->orWhereHas('brands', function ($q3) use ($search) {
                          $q3->where('name', 'like', "%{$search}%")
                             ;
                      })
                    //   ->orWhereHas('products', function ($q4) use ($search) {
                    //       $q4->where('name', 'like', "%{$search}%")
                             
                    //          ->orWhere('sku', 'like', "%{$search}%");
                    //   })
                      ->orWhereHas('links', function ($q5) use ($search) {
                          $q5->where('url', 'like', "%{$search}%")
                             ->orWhere('type', 'like', "%{$search}%");
                      })
                      ->orWhereHas('contacts', function ($q6) use ($search) {
                          $q6->where('contact_name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('job_title', 'like', "%{$search}%")
                             ->orWhere('phone_e164', 'like', "%{$search}%");
                      });
                });
            })
            ->when($filters['entity_type'] ?? null, fn($q, $val) => $q->where('entity_type', $val))
            ->when($filters['country'] ?? null, fn($q, $val) => $q->where('country_id', $val))
            ->when($filters['relationship_status'] ?? null, fn($q, $val) => $q->where('relationship_status', $val))
            ->when($filters['brand'] ?? null, fn($q, $val) => $q->whereHas('brands', fn($q2) => $q2->where('id', $val)))
            ->when($filters['has_ndas'] ?? null, fn($q, $val) => $q->where('has_ndas', $val))
            ->when($sort, function ($query, $sort) {
                switch ($sort) {
                    case 'name':
                        return $query->orderBy('legal_name');
                    case 'country':
                        return $query->leftJoin('countries', 'principals.country_id', '=', 'countries.id')
                                   ->orderBy('countries.name')
                                   ->select('principals.*');
                    case 'last_activity':
                        return $query->orderBy('last_seen', 'desc');
                    case 'website':
                        return $query->orderBy('website_url');
                    case 'status':
                        return $query->orderBy('status');
                    case 'relationship_status':
                        return $query->orderBy('relationship_status');
                    default: // recently_updated
                        return $query->latest('updated_at');
                }
            })
            ->paginate(20)
            ->withQueryString();

        return view('admin.principals.index', compact('principals', 'search', 'filters', 'sort', 'countries','brands', 'totalBrands'));
    }

    /**
     * Show principal details with brands, products, contacts, addresses, and country.
     */
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
            'updated_by' => auth()->id(),
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
        $brands = Brand::orderBy('name', 'ASC')->get();
        $totalBrands = $brands->count();
        $totalProducts = Product::count();

        return [
            'total' => $totalPrincipals,
            'active' => $activePrincipals,
            'verified' => $verifiedPrincipals,
            'online' => $onlinePrincipals,
            'brands' => $brands,
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