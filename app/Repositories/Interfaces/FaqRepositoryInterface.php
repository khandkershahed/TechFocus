<?php

namespace App\Repositories\Interfaces;

interface FaqRepositoryInterface
{
    /**
     * Get all FAQs (with their dynamic categories)
     *
     * @return \Illuminate\Support\Collection
     */
    public function allFaq();

    /**
     * Store a new FAQ
     *
     * @param array $data
     * @return mixed
     */
    public function storeFaq(array $data);

    /**
     * Find an FAQ by ID (with category)
     *
     * @param int $id
     * @return mixed
     */
    public function findFaq(int $id);

    /**
     * Update an existing FAQ
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function updateFaq(array $data, int $id);

    /**
     * Delete an FAQ by ID
     *
     * @param int $id
     * @return bool
     */
    public function destroyFaq(int $id);

    /**
     * Search FAQs by keyword (question or answer)
     *
     * @param string|null $query
     * @return \Illuminate\Support\Collection
     */
    public function searchFaq(?string $query);

    /**
     * Get FAQs by their dynamic category ID
     *
     * @param int $categoryId
     * @return \Illuminate\Support\Collection
     */
    public function getFaqByCategory(int $categoryId);
}
