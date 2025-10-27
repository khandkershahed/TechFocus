<?php

namespace App\Repositories;

use App\Models\Admin\DynamicCategory;
use App\Repositories\Interfaces\DynamicCategoryRepositoryInterface;

class DynamicCategoryRepository implements DynamicCategoryRepositoryInterface
{
    /**
     * Get all dynamic categories (newest first)
     */
    public function allDynamicCategory()
    {
        return DynamicCategory::orderByDesc('id')->get();
    }

    /**
     * Get all active dynamic categories (optionally filtered by type)
     */
    public function allDynamicActiveCategory($categoryType = null)
    {
        return DynamicCategory::query()
            ->when($categoryType, fn($q) => $q->where('type', $categoryType))
            ->where('status', 1) // ✅ use integer status for active rows
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Store a new dynamic category
     */
    public function storeDynamicCategory(array $data)
    {
        return DynamicCategory::create($data);
    }

    /**
     * Find a dynamic category by ID
     */
    public function findDynamicCategory(int $id)
    {
        return DynamicCategory::findOrFail($id);
    }

    /**
     * Update an existing dynamic category
     */
    public function updateDynamicCategory(array $data, int $id)
    {
        $category = DynamicCategory::findOrFail($id);
        $category->update($data);
        return $category;
    }

    /**
     * Delete a dynamic category by ID
     */
    public function destroyDynamicCategory(int $id)
    {
        return DynamicCategory::destroy($id);
    }

    public function getBySlug(string $slug)
{
    return DynamicCategory::where('slug', $slug)->first();
}

}
