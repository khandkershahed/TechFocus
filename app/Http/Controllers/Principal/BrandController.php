<?php

namespace App\Http\Controllers\Principal;

use App\Models\Admin\Brand;
use App\Models\Admin\Category;
use App\Models\Country;
use Illuminate\Support\Str;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
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
        $principalId = Auth::guard('principal')->id();
        
        return view('principal.brands.index', [
            'brands' => $this->brandRepository->getPrincipalBrands($principalId),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get categories with their children for nested dropdown
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();

        // Get countries for dropdown
        $countries = Country::all();

        return view('principal.brands.create', compact('categories', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $principalId = Auth::guard('principal')->id();

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

        // Get category name from the category ID
        $categoryName = null;
        if ($request->category) {
            $category = Category::find($request->category);
            $categoryName = $category ? $category->name : null;
        }

        $data = [
            'principal_id' => $principalId,
            'country_id'   => $request->country_id,
            'title'        => $request->title,
            'description'  => $request->description,
            'image'        => $globalFunImage['status'] == 1 ? $globalFunImage['file_name'] : null,
            'logo'         => $globalFunLogo['status'] == 1 ? $globalFunLogo['file_name'] : null,
            'website_url'  => $request->website_url,
            'category'     => $categoryName, // Use 'category' column instead of 'category_id'
            'status'       => 'pending',
            'slug'         => Str::slug($request->title),
            'created_by'   => $principalId,
            'updated_by'   => $principalId,
        ];

        $this->brandRepository->storeBrand($data);

        return redirect()->route('principal.brands.index')
            ->with('success', 'Brand submitted successfully! Waiting for admin approval.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $principalId = Auth::guard('principal')->id();
        $brand = $this->brandRepository->findBrand($id);

        // Check if brand belongs to this principal
        if ($brand->principal_id !== $principalId) {
            abort(403, 'Unauthorized action.');
        }

        // Get categories with their children for nested dropdown
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();

        // Get countries for dropdown
        $countries = Country::all();

        return view('principal.brands.edit', compact('brand', 'categories', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, $id)
    {
        $principalId = Auth::guard('principal')->id();
        $brand = $this->brandRepository->findBrand($id);

        // Check if brand belongs to this principal
        if ($brand->principal_id !== $principalId) {
            abort(403, 'Unauthorized action.');
        }

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

        // Get category name from the category ID
        $categoryName = $brand->category; // Keep existing category if not changed
        if ($request->category && $request->category != $brand->category) {
            $category = Category::find($request->category);
            $categoryName = $category ? $category->name : $brand->category;
        }

        $data = [
            'country_id'   => $request->country_id,
            'title'        => $request->title,
            'description'  => $request->description,
            'image'        => $globalFunImage['status'] == 1 ? $globalFunImage['file_name'] : $brand->image,
            'logo'         => $globalFunLogo['status'] == 1 ? $globalFunLogo['file_name'] : $brand->logo,
            'website_url'  => $request->website_url,
            'category'     => $categoryName, // Use 'category' column instead of 'category_id'
            'status'       => 'pending', // Reset to pending when updated
            'slug'         => Str::slug($request->title),
            'updated_by'   => $principalId,
        ];

        $this->brandRepository->updateBrand($data, $id);

        return redirect()->route('principal.brands.index')
            ->with('success', 'Brand updated successfully! Waiting for admin approval.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $principalId = Auth::guard('principal')->id();
        $brand = $this->brandRepository->findBrand($id);

        // Check if brand belongs to this principal
        if ($brand->principal_id !== $principalId) {
            abort(403, 'Unauthorized action.');
        }

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

        return redirect()->route('principal.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}