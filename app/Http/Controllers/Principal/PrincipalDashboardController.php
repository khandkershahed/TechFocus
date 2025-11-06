<?php

namespace App\Http\Controllers\Principal;
use App\Models\Admin\Brand;
use App\Models\Admin\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\BrandRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class PrincipalDashboardController extends Controller
{ 
    public function index()
    {
        $principalId = Auth::guard('principal')->id();
        
        $brands = Brand::where('principal_id', $principalId)->latest()->get();
        $products = Product::where('principal_id', $principalId)->latest()->get();
        
        $stats = [
            // Brand stats
            'total_brands' => $brands->count(),
            'approved_brands' => $brands->where('status', 'approved')->count(),
            'pending_brands' => $brands->where('status', 'pending')->count(),
            'rejected_brands' => $brands->where('status', 'rejected')->count(),
            
            // Product stats - using submission_status column
            'total_products' => $products->count(),
            'approved_products' => $products->where('submission_status', 'approved')->count(),
            'pending_products' => $products->where('submission_status', 'pending')->count(),
            'rejected_products' => $products->where('submission_status', 'rejected')->count(),
        ];

        return view('principal.dashboard', compact('stats', 'brands', 'products'));
    }
}
