<?php

namespace App\Http\Controllers\Rfq;

use Storage;
use App\Models\Rfq;
use App\Models\User;
use App\Models\Admin\Brand;
use App\Models\Admin\Product;
use Illuminate\Http\Request; 
use App\Models\Admin\Category;
use App\Models\Rfq\RfqProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\RfqProductRequest;

class RfqProductController extends Controller
{
   
public function index(Request $request)
{
    $totalRfq = Rfq::count();

    $thisMonthCount = Rfq::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();

    $lastMonthCount = Rfq::whereMonth('created_at', now()->subMonth()->month)
        ->whereYear('created_at', now()->subMonth()->year)
        ->count();

    // Growth percentage
    if ($lastMonthCount > 0) {
        $growth = (($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100;
    } else {
        $growth = $thisMonthCount > 0 ? 100 : 0;
    }

    // Update these to include null status as pending
    $pendingCount = Rfq::where(function($query) {
        $query->where('status', 'pending')
              ->orWhereNull('status');
    })->count();
    
    $quotedCount  = Rfq::where('status', 'quoted')->count();
    $lostCount    = Rfq::where('status', 'lost')->count();

    $rfqByCountry = Rfq::select(
        DB::raw('COALESCE(country, "Unknown") as country'),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('country')
    ->orderByDesc('total')
    ->get();

    // Filter section 
    // Countries from RFQs
    $countries = Rfq::whereNotNull('country')
        ->distinct()
        ->orderBy('country')
        ->pluck('country');

    // Salesmen (adjust model if needed)
    $salesmen = User::whereIn('id', function ($q) {
            $q->select('user_id')->from('rfqs')->whereNotNull('user_id');
        })
        ->orderBy('name')
        ->pluck('name');

    // Companies from RFQs
    $companies = Rfq::whereNotNull('company_name')
        ->distinct()
        ->orderBy('company_name')
        ->pluck('company_name');

    // Years from RFQ created_at
    $years = Rfq::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderByDesc('year')
        ->pluck('year');

    // Months (fixed list, but auto-select current month)
    $months = [
        1  => 'January',
        2  => 'February',
        3  => 'March',
        4  => 'April',
        5  => 'May',
        6  => 'June',
        7  => 'July',
        8  => 'August',
        9  => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    $currentYear  = now()->year;
    $currentMonth = now()->month;

    // Get filter parameters from request
    $country = $request->get('country');
    $salesman = $request->get('salesman');
    $company = $request->get('company');
    $search = $request->get('search');
    $status = $request->get('status', 'pending'); // Default to pending tab
    $product = $request->get('product');

    // Base query for RFQs
    $rfqQuery = Rfq::query();

    // Apply filters if provided
    if ($country) {
        $rfqQuery->where('country', $country);
    }

    if ($salesman) {
        // Assuming salesman is stored in user relationship
        // First, get user ID from name
        $salesmanUser = User::where('name', $salesman)->first();
        if ($salesmanUser) {
            $rfqQuery->where('user_id', $salesmanUser->id);
        }
    }

    if ($company) {
        $rfqQuery->where('company_name', $company);
    }

    if ($search) {
        $rfqQuery->where(function($q) use ($search) {
            $q->where('rfq_code', 'like', "%{$search}%")
              ->orWhere('deal_code', 'like', "%{$search}%")
              ->orWhere('company_name', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    if ($product) {
        $rfqQuery->whereHas('rfqProducts', function($q) use ($product) {
            $q->whereHas('product', function($q2) use ($product) {
                $q2->where('name', 'like', "%{$product}%");
            })->orWhere('additional_product_name', 'like', "%{$product}%");
        });
    }
    
    // Apply year and month filters
    if ($request->filled('year')) {
        $rfqQuery->whereYear('created_at', $request->get('year'));
        
        if ($request->filled('month')) {
            $rfqQuery->whereMonth('created_at', $request->get('month'));
        }
    }
    
    // Get ALL RFQs for the "All" view
    $allRfqs = (clone $rfqQuery)->with([
            'rfqProducts' => function($query) {
                $query->with('product');
            },
            'user'
        ])
        ->orderBy('created_at', 'desc')
        ->get();
    
    // GET RFQs based on status with filters applied
    $pendingRfqs = (clone $rfqQuery)->with([
            'rfqProducts' => function($query) {
                $query->with('product');
            },
            'user'
        ])
        ->where(function($query) {
            $query->where('status', 'pending')
                  ->orWhereNull('status');
        })
        ->orderBy('created_at', 'desc')
        ->get();

    // Also get quoted and lost RFQs for their respective tabs
    $quotedRfqs = (clone $rfqQuery)->with(['rfqProducts', 'user'])
        ->where('status', 'quoted')
        ->orderBy('created_at', 'desc')
        ->get();

    $lostRfqs = (clone $rfqQuery)->with(['rfqProducts', 'user'])
        ->where('status', 'lost')
        ->orderBy('created_at', 'desc')
        ->get();

    // Determine which RFQs to display based on status parameter
    $displayRfqs = $allRfqs; // Default to all
    $activeTab = 'all'; // Default active tab
    
    if ($status === 'pending') {
        $displayRfqs = $pendingRfqs;
        $activeTab = 'pending';
    } elseif ($status === 'quoted') {
        $displayRfqs = $quotedRfqs;
        $activeTab = 'quoted';
    } elseif ($status === 'lost') {
        $displayRfqs = $lostRfqs;
        $activeTab = 'failed'; // Note: tab ID is 'failed' but status is 'lost'
    }

    // Get products for filter dropdown
    $products = Product::orderBy('name')->pluck('name');
        
    return view('admin.pages.rfqProduct.index', [
        // Dashboard counts (unfiltered - for dashboard display)
        'totalRfq'      => $totalRfq,
        'thisMonthRfq'  => $thisMonthCount,
        'lastMonthRfq'  => $lastMonthCount,
        'growthPercent' => round($growth, 1),
        'todayDate'     => now()->format('d M, Y'),
        
        // Archive 
        'years'        => $years,
        'months'       => $months,
        'currentYear'  => $currentYear,
        'currentMonth' => $currentMonth,
        
        // Status counts (filtered)
        'pendingCount'  => $pendingRfqs->count(),
        'quotedCount'   => $quotedRfqs->count(),
        'lostCount'     => $lostRfqs->count(),
        
        // Filter options
        'countries' => $countries,
        'salesmen'  => $salesmen,
        'companies' => $companies,
        'products'  => $products,
        
        // RFQ by country (filtered - update this too)
        'rfqByCountry'  => $rfqByCountry,
        
        // RFQ Lists
        'allRfqs'     => $allRfqs,
        'pendingRfqs' => $pendingRfqs,
        'quotedRfqs'  => $quotedRfqs,
        'lostRfqs'    => $lostRfqs,
        'displayRfqs' => $displayRfqs, // RFQs to display based on active tab
        
        // Active tab
        'activeTab' => $activeTab,
        'currentStatus' => $status,
        
        // Original variables (keep if needed elsewhere)
        'rfqProducts'   => RfqProduct::with(['rfq', 'product'])->paginate(10),
        'rfqs'          => Rfq::all(),
        'brands'        => Brand::all(),
        
        // Current filter values (for UI)
        'currentCountry' => $country,
        'currentSalesman' => $salesman,
        'currentCompany' => $company,
        'currentSearch' => $search,
        'currentProduct' => $product,
        'currentYearFilter' => $request->get('year', ''),
        'currentMonthFilter' => $request->get('month', ''),
    ]);
}

public function filter(Request $request)
{
    $status = $request->get('status', 'pending');
    
    $query = Rfq::query();
    
    // Apply filters
    if ($country = $request->get('country')) {
        $query->where('country', $country);
    }
    
    if ($salesman = $request->get('salesman')) {
        $salesmanUser = User::where('name', $salesman)->first();
        if ($salesmanUser) {
            $query->where('user_id', $salesmanUser->id);
        }
    }
    
    if ($company = $request->get('company')) {
        $query->where('company_name', $company);
    }
    
    if ($search = $request->get('search')) {
        $query->where(function($q) use ($search) {
            $q->where('rfq_code', 'like', "%{$search}%")
              ->orWhere('deal_code', 'like', "%{$search}%")
              ->orWhere('company_name', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }
    
    if ($product = $request->get('product')) {
        $query->whereHas('rfqProducts', function($q) use ($product) {
            $q->whereHas('product', function($q2) use ($product) {
                $q2->where('name', 'like', "%{$product}%");
            })->orWhere('additional_product_name', 'like', "%{$product}%");
        });
    }
    
    // Apply year and month filters
    if ($year = $request->get('year')) {
        $query->whereYear('created_at', $year);
        
        if ($month = $request->get('month')) {
            $query->whereMonth('created_at', $month);
        }
    }
    
    // Get RFQs based on status
    if ($status === 'pending') {
        $rfqs = $query->with(['rfqProducts.product', 'user'])
            ->where(function($q) {
                $q->where('status', 'pending')
                  ->orWhereNull('status');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    } else {
        $rfqs = $query->with(['rfqProducts.product', 'user'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    // Get counts for all statuses (using the same filters)
    $baseQuery = clone $query;
    $pendingCount = (clone $baseQuery)->where(function($q) {
        $q->where('status', 'pending')->orWhereNull('status');
    })->count();
    
    $quotedCount = (clone $baseQuery)->where('status', 'quoted')->count();
    
    $lostCount = (clone $baseQuery)->where('status', 'lost')->count();
    
    // Return JSON response
    $html = view('admin.pages.rfqProduct.partials.rfq-list', [
        'rfqs' => $rfqs,
        'status' => $status
    ])->render();
    
    return response()->json([
        'success' => true,
        'html' => $html,
        'pendingCount' => $pendingCount,
        'quotedCount' => $quotedCount,
        'lostCount' => $lostCount
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.rfqProduct.create', [
            'rfqs'     => Rfq::all(),
            'products' => Product::all(),
            'brands'   => Brand::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RfqProductRequest $request)
    {
        // Calculate prices
        $unitPrice = $request->unit_price;
        $quantity = $request->qty;
        $discount = $request->discount ?? 0;
        $tax = $request->tax ?? 0;
        $vat = $request->vat ?? 0;

        // Calculate totals
        $subTotal = $unitPrice * $quantity;
        $discountAmount = ($subTotal * $discount) / 100;
        $totalAfterDiscount = $subTotal - $discountAmount;
        $taxAmount = ($totalAfterDiscount * $tax) / 100;
        $vatAmount = ($totalAfterDiscount * $vat) / 100;
        $grandTotal = $totalAfterDiscount + $taxAmount + $vatAmount;

        RfqProduct::create([
            'rfq_id'         => $request->rfq_id,
            'product_id'     => $request->product_id,
            'qty'            => $quantity,
            'unit_price'     => $unitPrice,
            'discount'       => $discount,
            'discount_price' => $discountAmount,
            'total_price'    => $subTotal,
            'sub_total'      => $subTotal,
            'tax'            => $tax,
            'tax_price'      => $taxAmount,
            'vat'            => $vat,
            'vat_price'      => $vatAmount,
            'grand_total'    => $grandTotal,
            'product_des'    => $request->product_des,
            'sku_no'         => $request->sku_no,
            'model_no'       => $request->model_no,
            'brand_name'     => $request->brand_name,
        ]);

        return redirect()->route('rfqProducts.index')->with('success', 'RFQ Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rfqProduct = RfqProduct::with(['rfq', 'product'])->findOrFail($id);
        return view('admin.pages.rfqProduct.show', compact('rfqProduct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rfqProduct = RfqProduct::with(['rfq', 'product'])->findOrFail($id);
        
        return view('admin.pages.rfqProduct.edit', [
            'rfqProduct' => $rfqProduct,
            'rfqs'       => Rfq::all(),
            'products'   => Product::all(),
            'brands'     => Brand::all(),
        ]);
    }

/**
 * Update RFQ status.
 */
public function updateStatus(Request $request, $id)
{
    try {
        $request->validate([
            'status' => 'required|in:pending,assigned,quoted,closed,lost',
            'status_notes' => 'nullable|string|max:500',
            'follow_up_date' => 'nullable|date'
        ]);
        
        $rfq = Rfq::findOrFail($id);
        
        $oldStatus = $rfq->status;
        $newStatus = $request->status;
        
        $updateData = [
            'status' => $newStatus,
            'status_notes' => $request->status_notes,
            'follow_up_date' => $request->follow_up_date
        ];
        
        // Add timestamps based on status
        if ($newStatus === 'assigned' && $oldStatus !== 'assigned') {
            $updateData['assigned_at'] = now();
        }
        
        if ($newStatus === 'quoted' && $oldStatus !== 'quoted') {
            $updateData['quoted_at'] = now();
        }
        
        if ($newStatus === 'closed' && $oldStatus !== 'closed') {
            $updateData['closed_at'] = now();
        }
        
        if ($newStatus === 'lost' && $oldStatus !== 'lost') {
            $updateData['lost_at'] = now();
        }
        
        $rfq->update($updateData);
        
        // Log the status change
        Log::info('RFQ status updated', [
            'rfq_id' => $id,
            'rfq_code' => $rfq->rfq_code,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'updated_by' => auth()->id() ?? 'system'
        ]);
        
        // Always redirect back with success message
        return redirect()->back()->with('success', 'Status updated successfully!');
        
    } catch (\Exception $e) {
        Log::error('Failed to update RFQ status', [
            'rfq_id' => $id,
            'error' => $e->getMessage()
        ]);
        
        return redirect()->back()->with('error', 'Failed to update status: ' . $e->getMessage());
    }
}

/**
 * Calculate progress percentage based on status.
 */
private function calculateProgress($status)
{
    $progressMap = [
        'pending' => 20,
        'assigned' => 50,
        'quoted' => 80,
        'closed' => 100,
        'lost' => 100
    ];
    
    return $progressMap[$status] ?? 20;
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rfqProduct = RfqProduct::findOrFail($id);

        // Calculate prices
        $unitPrice = $request->unit_price ?? $rfqProduct->unit_price;
        $quantity = $request->qty ?? $rfqProduct->qty;
        $discount = $request->discount ?? $rfqProduct->discount ?? 0;
        $tax = $request->tax ?? $rfqProduct->tax ?? 0;
        $vat = $request->vat ?? $rfqProduct->vat ?? 0;

        // Calculate totals
        $subTotal = $unitPrice * $quantity;
        $discountAmount = ($subTotal * $discount) / 100;
        $totalAfterDiscount = $subTotal - $discountAmount;
        $taxAmount = ($totalAfterDiscount * $tax) / 100;
        $vatAmount = ($totalAfterDiscount * $vat) / 100;
        $grandTotal = $totalAfterDiscount + $taxAmount + $vatAmount;

        $updateData = [
            'rfq_id'         => $request->rfq_id ?? $rfqProduct->rfq_id,
            'product_id'     => $request->product_id ?? $rfqProduct->product_id,
            'qty'            => $quantity,
            'unit_price'     => $unitPrice,
            'discount'       => $discount,
            'discount_price' => $discountAmount,
            'total_price'    => $subTotal,
            'sub_total'      => $subTotal,
            'tax'            => $tax,
            'tax_price'      => $taxAmount,
            'vat'            => $vat,
            'vat_price'      => $vatAmount,
            'grand_total'    => $grandTotal,
            'sku_no'         => $request->sku_no ?? $rfqProduct->sku_no,
            'model_no'       => $request->model_no ?? $rfqProduct->model_no,
            'brand_name'     => $request->brand_name ?? $rfqProduct->brand_name,
            'additional_product_name' => $request->additional_product_name ?? $rfqProduct->additional_product_name,
            'additional_qty' => $request->additional_qty ?? $rfqProduct->additional_qty,
            'product_des'    => $request->product_des ?? $rfqProduct->product_des,
            'additional_info' => $request->additional_info ?? $rfqProduct->additional_info,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($rfqProduct->image) {
                \Storage::disk('public')->delete($rfqProduct->image);
            }
            $path = $request->file('image')->store('rfq_products', 'public');
            $updateData['image'] = $path;
        }

        $rfqProduct->update($updateData);

        return redirect()->route('rfqProducts.index')->with('success', 'RFQ Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rfqProduct = RfqProduct::findOrFail($id);
        
        // Delete image if exists
        if ($rfqProduct->image) {
            Storage::disk('public')->delete($rfqProduct->image);
        }
        
        $rfqProduct->delete();
        
        return redirect()->route('rfqProducts.index')->with('success', 'RFQ Product deleted successfully.');
    }

public function getRfqDetails($id)
{
    $rfq = Rfq::with(['rfqProducts.product', 'user'])->findOrFail($id);
    
    // Calculate progress based on status
    $progress = 0;
    if ($rfq->status === 'pending') {
        $progress = 20;
    } elseif ($rfq->status === 'assigned') {
        $progress = 50;
    } elseif ($rfq->status === 'quoted') {
        $progress = 80;
    } elseif ($rfq->status === 'closed') {
        $progress = 100;
    }
    
    // Return the details view for a single RFQ
    return view('admin.pages.rfqProduct.partials.rfq-list', compact('rfq', 'progress'));
}
}