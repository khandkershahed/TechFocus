<?php

namespace App\Repositories;

use App\Models\Admin\Brand;
use App\Repositories\Interfaces\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    /**
     * Get all approved brands (admin created + approved principal brands)
     * Only brands with principal_id need approval
     */
    public function allApprovedBrands()
    {
        return Brand::where(function($query) {
            $query->whereNull('principal_id') // Admin created brands - auto approved
                  ->orWhere('status', 'approved'); // Principal brands that are approved
        })
        ->with(['principal', 'country'])
        ->latest('id')
        ->get();
    }

    /**
     * Get pending brands from principals only
     * Only brands with principal_id need approval
     */
    public function pendingBrands()
    {
        return Brand::where('status', 'pending')
                    ->whereNotNull('principal_id') // Only brands from principals need approval
                    ->with(['principal', 'country'])
                    ->latest()
                    ->get();
    }

    /**
     * Get all brands (for admin management - includes all statuses)
     */
    public function allBrand()
    {
        return Brand::with(['principal', 'country'])->latest('id')->get();
    }

    /**
     * Get brands by specific principal
     */
    public function getPrincipalBrands($principalId)
    {
        return Brand::where('principal_id', $principalId)
                    ->with('country')
                    ->latest()
                    ->get();
    }

    public function storeBrand(array $data)
    {
        return Brand::create($data);
    }

    public function findBrand(int $id)
    {
        return Brand::findOrFail($id);
    }

    public function updateBrand(array $data, int $id)
    {
        return Brand::findOrFail($id)->update($data);
    }

    public function destroyBrand(int $id)
    {
        return Brand::destroy($id);
    }

    public function approveBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->update([
            'status' => 'approved',
            'approved_at' => now(),
            'rejection_reason' => null
        ]);
        return $brand;
    }

    public function rejectBrand($id, $reason = null)
    {
        $brand = Brand::findOrFail($id);
        $brand->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'approved_at' => null
        ]);
        return $brand;
    }
}