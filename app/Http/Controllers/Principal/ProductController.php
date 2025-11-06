<?php

namespace App\Http\Controllers\Principal;

use App\Models\Admin\Product;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $principalId = Auth::guard('principal')->id();
        
        return view('principal.products.index', [
            'products' => $this->productRepository->getPrincipalProducts($principalId),
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

        // Add your existing product creation logic here
        $data = $request->validated();
        $data['principal_id'] = $principalId;
        $data['submission_status'] = 'pending'; // Set as pending for admin approval
        $data['status'] = 'inactive'; // Set as inactive until approved

        // Handle file uploads and other logic from your existing ProductController
        // ...

        $this->productRepository->storeProduct($data);

        return redirect()->route('principal.products.index')
            ->with('success', 'Product submitted successfully! Waiting for admin approval.');
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
        $principalId = Auth::guard('principal')->id();
        $product = $this->productRepository->findProduct($id);

        // Check if product belongs to this principal
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
        $product = $this->productRepository->findProduct($id);

        // Check if product belongs to this principal
        if ($product->principal_id !== $principalId) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validated();
        $data['submission_status'] = 'pending'; // Reset to pending when updated
        $data['status'] = 'inactive'; // Set as inactive until approved again

        // Handle file uploads and other logic from your existing ProductController
        // ...

        $this->productRepository->updateProduct($data, $id);

        return redirect()->route('principal.products.index')
            ->with('success', 'Product updated successfully! Waiting for admin approval.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $principalId = Auth::guard('principal')->id();
        $product = $this->productRepository->findProduct($id);

        // Check if product belongs to this principal
        if ($product->principal_id !== $principalId) {
            abort(403, 'Unauthorized action.');
        }

        $this->productRepository->destroyProduct($id);

        return redirect()->route('principal.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}