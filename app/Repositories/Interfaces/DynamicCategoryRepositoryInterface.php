<?php

namespace App\Repositories\Interfaces;

interface DynamicCategoryRepositoryInterface
{
    /**
     * Get all dynamic categories (regardless of status)
     */
    public function allDynamicCategory();

    /**
     * Get all active dynamic categories, optionally filtered by type
     *
     * @param string|null $categoryType
     * @return \Illuminate\Support\Collection
     */
    public function allDynamicActiveCategory(?string $categoryType = null);

    /**
     * Store a new dynamic category
     *
     * @param array $data
     * @return mixed
     */
    public function storeDynamicCategory(array $data);

    /**
     * Find a dynamic category by its ID
     *
     * @param int $id
     * @return mixed
     */
    public function findDynamicCategory(int $id);
    public function getBySlug(string $slug);

    /**
     * Update a dynamic category by its ID
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function updateDynamicCategory(array $data, int $id);

    /**
     * Delete a dynamic category by its ID
     *
     * @param int $id
     * @return bool
     */
    public function destroyDynamicCategory(int $id);
}
