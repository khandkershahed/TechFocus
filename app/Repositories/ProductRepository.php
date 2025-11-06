<?php

namespace App\Repositories;

use App\Models\Admin\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function allProduct()
    {
        return Product::with('principal')->latest('id')->get();
    }

    public function allApprovedProducts()
    {
        return Product::approved()->latest()->get();
    }

    public function pendingProducts()
    {
        return Product::pending()->with('principal')->latest()->get();
    }

    public function getPrincipalProducts($principalId)
    {
        return Product::where('principal_id', $principalId)->latest()->get();
    }

    public function storeProduct(array $data)
    {
        return Product::create($data);
    }

    public function findProduct(int $id)
    {
        return Product::findOrFail($id);
    }

    public function updateProduct(array $data, int $id)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function destroyProduct(int $id)
    {
        $product = Product::findOrFail($id);
        return $product->delete();
    }

    public function approveProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'submission_status' => 'approved',
            'approved_at' => now(),
            'rejection_reason' => null,
            'status' => 'active' // Also set product status to active
        ]);
        return $product;
    }

    public function rejectProduct($id, $reason = null)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'submission_status' => 'rejected',
            'rejection_reason' => $reason,
            'approved_at' => null,
            'status' => 'inactive' // Set product status to inactive when rejected
        ]);
        return $product;
    }
}