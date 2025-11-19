<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Admin\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\NewsTrend;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Repositories\Interfaces\BrandRepositoryInterface;

class BrandController extends Controller
{
    private $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.brand.index', [
            'brands' => $this->brandRepository->allApprovedBrands(), // Only approved brands
        ]);
    }

    /**
     * Display pending brands for approval.
     */
    public function pending()
    {
        return view('admin.pages.brand.pending', [
            'pendingBrands' => $this->brandRepository->pendingBrands(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $mainFile = $request->file('image');
        $logoFile = $request->file('logo');

        $filePath_image = storage_path('app/public/brand/image/');
        $filePath_logo = storage_path('app/public/brand/logo/');

        if (!empty($mainFile)) {
            $globalFunImage = customUpload($mainFile, $filePath_image);
        } else {
            $globalFunImage = ['status' => 0];
        }
        if (!empty($logoFile)) {
            $globalFunLogo = customUpload($logoFile, $filePath_logo);
        } else {
            $globalFunLogo = ['status' => 0];
        }

        $data = [
            'country_id'   => $request->country_id,
            'title'         => $request->title,
            'description'  => $request->description,
            'image'        => $globalFunImage['status'] == 1 ? $globalFunImage['file_name'] : null,
            'logo'         => $globalFunLogo['status'] == 1 ? $globalFunLogo['file_name'] : null,
            'website_url'  => $request->website_url,
            'category'     => $request->category,
        ];
        $this->brandRepository->storeBrand($data);
        return redirect()->back()->with('success', 'Data has been saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, $id)
    {
        $brand =  $this->brandRepository->findBrand($id);

        $mainFile = $request->file('image');
        $logoFile = $request->file('logo');
        $filePath_image = storage_path('app/public/brand/image/');
        $filePath_logo = storage_path('app/public/brand/logo/');

        if (!empty($mainFile)) {
            $globalFunImage = customUpload($mainFile, $filePath_image);
            $paths = [
                storage_path("app/public/brand/image/{$brand->image}"),
            ];
            foreach ($paths as $path) {
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
        } else {
            $globalFunImage = ['status' => 0];
        }

        if (!empty($logoFile)) {
            $globalFunLogo = customUpload($logoFile, $filePath_logo);
            $paths = [
                storage_path("app/public/brand/logo/{$brand->logo}"),
            ];
            foreach ($paths as $path) {
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
        } else {
            $globalFunLogo = ['status' => 0];
        }

        $data = [
            'country_id'   => $request->country_id,
            'title'         => $request->title,
            'description'  => $request->description,
            'image'        => $globalFunImage['status'] == 1 ? $globalFunImage['file_name'] : $brand->image,
            'logo'         => $globalFunLogo['status'] == 1 ? $globalFunLogo['file_name'] : $brand->logo,
            'website_url'  => $request->website_url,
            'category'     => $request->category,
        ];

        $this->brandRepository->updateBrand($data, $id);

        return redirect()->route('admin.brand.index')->with('message', 'Data updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand =  $this->brandRepository->findBrand($id);

        $paths = [
            storage_path("app/public/brand/image/{$brand->image}"),
            storage_path("app/public/brand/logo/{$brand->logo}"),
        ];

        foreach ($paths as $path) {
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $this->brandRepository->destroyBrand($id);
    }

    /**
     * Brand overview page
     */
    public function brandOverview($slug)
    {
        $brand = Brand::with('brandPage')->where('slug', $slug)->firstOrFail();
        return view('frontend.pages.brandPage.overview', compact('brand'));
    }

    /**
     * Content details page
     */
    public function contentDetails($id)
    {
        $newsTrend = NewsTrend::with('brand.brandPage')->findOrFail($id);
        $brand = $newsTrend->brand;
        return view('frontend.pages.brandPage.content_details', compact('newsTrend', 'brand'));
    }

    /**
     * Approve a brand - FIXED to redirect to pending page
     */
    // public function approve($id)
    // {
    //     $user = Auth::guard('admin')->user();

    //     // Normalize roles (support JSON or string)
    //     $roles = [];
    //     if (isset($user->role)) {
    //         if (is_string($user->role)) {
    //             $decoded = json_decode($user->role, true);
    //             $roles = is_array($decoded) ? $decoded : [$user->role];
    //         } elseif (is_array($user->role)) {
    //             $roles = $user->role;
    //         }
    //     }
    //     $roles = array_map('strtolower', $roles);

    //     if (!in_array('admin', $roles) && !in_array('super admin', $roles) && !$user->can_review_brands) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     $brand = Brand::findOrFail($id);
    //     $brand->status = 'approved';
    //     $brand->rejection_reason = null;
    //     $brand->save();

    //     // Redirect to pending brands page instead of back
    //     return redirect()->route('admin.brands.pending')->with('success', 'Brand approved successfully.');
    // }

    public function approve($id)
{
    try {
        $brand = Brand::findOrFail($id);
        
        // Update brand status
        $brand->update([
            'status' => 'approved',
            'approved_by' => auth('admin')->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.brands.pending')
            ->with('success', 'Brand "' . $brand->title . '" has been approved successfully.');

    } catch (\Exception $e) {
        \Log::error('Brand approval failed: ' . $e->getMessage());
        
        return redirect()->route('admin.brands.pending')
            ->with('error', 'Failed to approve brand. Please try again.');
    }
}

    /**
     * Reject a brand - ADDED MISSING METHOD
     */
    public function reject(Request $request, $id)
    {
        $user = Auth::guard('admin')->user();

        // Only SuperAdmin can reject brands
        $roles = [];
        if (isset($user->role)) {
            if (is_string($user->role)) {
                $decoded = json_decode($user->role, true);
                $roles = is_array($decoded) ? $decoded : [$user->role];
            } elseif (is_array($user->role)) {
                $roles = $user->role;
            }
        }
        $roles = array_map('strtolower', $roles);

        if (!in_array('super admin', $roles)) {
            abort(403, 'Only SuperAdmin can reject brands.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $brand = Brand::findOrFail($id);
        $brand->status = 'rejected';
        $brand->rejection_reason = $request->rejection_reason;
        $brand->save();
dd("**");
        // Redirect to pending brands page
        return redirect()->route('admin.brands.pending')->with('success', 'Brand rejected successfully.');
    }
}