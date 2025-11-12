<?php

namespace App\Http\Controllers\Principal;

use App\Models\Admin\Product;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $principalId = Auth::guard('principal')->id();
        
        return view('principal.products.index', [
            'products' => Product::where('principal_id', $principalId)->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $brands = \App\Models\Admin\Brand::all();
        $categories = \App\Models\Admin\Category::all();
        return view('principal.products.create', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $principalId = Auth::guard('principal')->id();

        $data = $request->validated();
        $data['principal_id'] = $principalId;
        $data['submission_status'] = 'pending';
        $data['product_status'] = 'sourcing'; // Use product_status instead of status
        $data['created_by'] = $principalId;
        $data['updated_by'] = $principalId;
        $data['brand_id'] = $request->brand_id;
        $data['category_id'] = $request->category_id;


        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->storeAs('public/products/thumbnails', $thumbnailName);
            $data['thumbnail'] = 'products/thumbnails/' . $thumbnailName;
        }

        // Generate slug from name
        $data['slug'] = \Illuminate\Support\Str::slug($data['name']);

        Product::create($data);

        return redirect()->route('principal.products.index')
            ->with('success', 'Product submitted successfully! Waiting for admin approval.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
    //     $principalId = Auth::guard('principal')->id();
    //     $product = Product::findOrFail($id);

    //     if ($product->principal_id !== $principalId) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     return view('principal.products.edit', compact('product'));
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(ProductRequest $request, $id)
    // {
    //     $principalId = Auth::guard('principal')->id();
    //     $product = Product::findOrFail($id);

    //     if ($product->principal_id !== $principalId) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     $data = $request->validated();
    //     $data['submission_status'] = 'pending'; // Reset to pending when updated
    //     $data['product_status'] = 'sourcing'; // Use product_status instead of status
    //     $data['updated_by'] = $principalId;

    //     // Handle thumbnail upload
    //     if ($request->hasFile('thumbnail')) {
    //         // Delete old thumbnail if exists
    //         if ($product->thumbnail) {
    //             \Illuminate\Support\Facades\Storage::delete('public/' . $product->thumbnail);
    //         }
            
    //         $thumbnail = $request->file('thumbnail');
    //         $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
    //         $thumbnail->storeAs('public/products/thumbnails', $thumbnailName);
    //         $data['thumbnail'] = 'products/thumbnails/' . $thumbnailName;
    //     }

    //     // Generate slug from name if name changed
    //     if ($data['name'] !== $product->name) {
    //         $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
    //     }

    //     $product->update($data);

    //     return redirect()->route('principal.products.index')
    //         ->with('success', 'Product updated successfully! Waiting for admin approval.');
    // }
// public function update(ProductRequest $request, $id)
// {
//     $principalId = Auth::guard('principal')->id();
//     $product = Product::findOrFail($id);

//     // Check ownership
//     if ($product->principal_id !== $principalId) {
//         return response()->json(['error' => 'Unauthorized'], 403);
//     }

//     $data = $request->validated();

//     // Update only fields from request
//     foreach ($data as $key => $value) {
//         $product->$key = $value;
//     }

//     // Reset status when updating
//     $product->submission_status = 'pending';
//     $product->product_status = 'sourcing';
//     $product->updated_by = $principalId;

//     // Thumbnail update
//     if ($request->hasFile('thumbnail')) {
//         if ($product->thumbnail) {
//             \Illuminate\Support\Facades\Storage::delete('public/' . $product->thumbnail);
//         }

//         $thumbnail = $request->file('thumbnail');
//         $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
//         $thumbnail->storeAs('public/products/thumbnails', $thumbnailName);
//         $product->thumbnail = 'products/thumbnails/' . $thumbnailName;
//     }

//     // Update slug only if name changed
//     if ($request->has('name') && $request->name !== $product->getOriginal('name')) {
//         $product->slug = \Illuminate\Support\Str::slug($request->name);
//     }

//     $product->save();
//      return redirect()->route('principal.products.index');

// }
/**
 * Show the form for editing the specified resource.
 */
/**
 * Show the form for editing the specified resource.
 */
public function edit($id)
{
    $principalId = Auth::guard('principal')->id();
    $product = Product::findOrFail($id);

    if ($product->principal_id !== $principalId) {
        abort(403, 'Unauthorized action.');
    }

    $brands = \App\Models\Admin\Brand::all();
    $categories = \App\Models\Admin\Category::all();

    return view('principal.products.edit', compact('product', 'brands', 'categories'));
}


public function update(ProductRequest $request, $id)
{
    $principalId = Auth::guard('principal')->id();
    $product = Product::findOrFail($id);

    // Check ownership
    if ($product->principal_id !== $principalId) {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        abort(403, 'Unauthorized action.');
    }

    try {
        // Get validated data
        $data = $request->validated();
        
        // Reset status when updating
        $data['submission_status'] = 'pending';
        $data['product_status'] = 'sourcing';
        $data['updated_by'] = $principalId;

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($product->thumbnail) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $product->thumbnail);
            }
            
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->storeAs('public/products/thumbnails', $thumbnailName);
            $data['thumbnail'] = 'products/thumbnails/' . $thumbnailName;
        }

        // Generate slug from name if name changed
        if (isset($data['name']) && $data['name'] !== $product->name) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        // Update the product
        $product->update($data);

        // Return JSON response for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully! Waiting for admin approval.',
                'redirect_url' => route('principal.products.index')
            ]);
        }

        return redirect()->route('principal.products.index')
            ->with('success', 'Product updated successfully! Waiting for admin approval.');

    } catch (\Exception $e) {
        \Log::error('Product update error: ' . $e->getMessage());

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating product: ' . $e->getMessage()
            ], 500);
        }

        return back()->with('error', 'Error updating product: ' . $e->getMessage());
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $principalId = Auth::guard('principal')->id();
        $product = Product::findOrFail($id);

        if ($product->principal_id !== $principalId) {
            abort(403, 'Unauthorized action.');
        }

        // Delete thumbnail if exists
        if ($product->thumbnail) {
            \Illuminate\Support\Facades\Storage::delete('public/' . $product->thumbnail);
        }

        $product->delete();

        return redirect()->route('principal.products.index')
            ->with('success', 'Product deleted successfully.');
    }



    /**
 * Show product details for AJAX request
 */
    public function showDetails($id)
    {
        try {
            $principalId = Auth::guard('principal')->id();
            $product = Product::with(['brand', 'category'])->findOrFail($id);

            // Check ownership
            if ($product->principal_id !== $principalId) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Unauthorized access to this product'
                ], 403);
            }

            $html = view('principal.products.partials.details-modal', compact('product'))->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);

        } catch (\Exception $e) {
            \Log::error('Product details error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error loading product details: ' . $e->getMessage()
            ], 500);
        }
    }
}