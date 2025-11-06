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
        return view('principal.products.create');
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
    public function edit($id)
    {
        $principalId = Auth::guard('principal')->id();
        $product = Product::findOrFail($id);

        if ($product->principal_id !== $principalId) {
            abort(403, 'Unauthorized action.');
        }

        return view('principal.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        $principalId = Auth::guard('principal')->id();
        $product = Product::findOrFail($id);

        if ($product->principal_id !== $principalId) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validated();
        $data['submission_status'] = 'pending'; // Reset to pending when updated
        $data['product_status'] = 'sourcing'; // Use product_status instead of status
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
        if ($data['name'] !== $product->name) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
        }

        $product->update($data);

        return redirect()->route('principal.products.index')
            ->with('success', 'Product updated successfully! Waiting for admin approval.');
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
}