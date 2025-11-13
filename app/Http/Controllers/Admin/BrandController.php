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
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return view('admin.pages.brand.index', [
    //         'brands' =>  $this->brandRepository->allBrand(),
    //     ]);
    // }
// In Admin\BrandController
public function index()
{
    return view('admin.pages.brand.index', [
        'brands' => $this->brandRepository->allApprovedBrands(), // Only approved brands
    ]);
}

public function pending()
{
    return view('admin.pages.brand.pending', [
        'pendingBrands' => $this->brandRepository->pendingBrands(),
    ]);
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

        // session()->flash('success', 'Data has been saved successfully!');
        return redirect()->route('admin.brand.index')->with('message', 'Data updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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


    // public function overview($slug)
    // {
    //     $brand = Brand::where('slug', $slug)
    //         ->with('brandPage.rowFour', 'brandPage.rowFive', 'brandPage.rowSeven', 'brandPage.rowEight')
    //         ->firstOrFail();

    //     return view('frontend.pages.brandPage.overview', compact('brand'));
    // }
    //  public function products($slug)
    // {
    //     $brand = Brand::where('slug', $slug)->with('brandPage')->firstOrFail();
    //     return view('frontend.pages.brandPage.products', compact('brand'));
    // }
    public function brandOverview($slug)
{
    $brand = Brand::with('brandPage')->where('slug', $slug)->firstOrFail();
    return view('frontend.pages.brandPage.overview', compact('brand'));
}

public function contentDetails($id)
{
    // Load the news trend by ID (or slug)
    $newsTrend = NewsTrend::with('brand.brandPage')->findOrFail($id);

    // Get the related brand for the page header
    $brand = $newsTrend->brand;

    // Pass both to the view
    return view('frontend.pages.brandPage.content_details', compact('newsTrend', 'brand'));
}
/**
 * Display pending brands for approval.
 */
/**
 * Display pending brands from principals for approval.
 */
// public function pending()
// {
//     return view('admin.pages.brand.pending', [
//         'pendingBrands' => $this->brandRepository->pendingBrands(),
//     ]);
// }
/**
 * Approve a brand.
 */
// public function approve($id)
// {
//     try {
//         $this->brandRepository->approveBrand($id);
//         return redirect()->route('admin.brands.pending')
//             ->with('success', 'Brand approved successfully!');
//     } catch (\Exception $e) {
//         return redirect()->route('admin.brands.pending')
//             ->with('error', 'Error approving brand: ' . $e->getMessage());
//     }
// }

// /**
//  * Reject a brand.
//  */
// public function reject(Request $request, $id)
// {
//     $request->validate([
//         'rejection_reason' => 'required|string|max:500'
//     ]);

//     try {
//         $this->brandRepository->rejectBrand($id, $request->rejection_reason);
//         return redirect()->route('admin.brands.pending')
//             ->with('success', 'Brand rejected successfully!');
//     } catch (\Exception $e) {
//         return redirect()->route('admin.brands.pending')
//             ->with('error', 'Error rejecting brand: ' . $e->getMessage());
//     }
// }

public function approve($id)
{
    $user = Auth::guard('admin')->user();

    // Normalize roles (support JSON or string)
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

    if (!in_array('admin', $roles) && !in_array('super admin', $roles) && !$user->can_review_brands) {
        abort(403, 'Unauthorized action.');
    }

    $brand = Brand::findOrFail($id);
    $brand->status = 'approved';
    $brand->rejection_reason = null;
    $brand->save();

    return redirect()->back()->with('success', 'Brand approved successfully.');
}



}
