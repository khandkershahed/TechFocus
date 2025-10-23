<?php

namespace App\Repositories;

use App\Models\Admin\Faq;
use App\Repositories\Interfaces\FaqRepositoryInterface;

class FaqRepository implements FaqRepositoryInterface
{
    protected $model;

    public function __construct(Faq $model)
    {
        $this->model = $model;
    }

    /**
     * Get all FAQs with their dynamic category (eager loaded)
     */
    public function allFaq()
    {
        return $this->model
            ->with('dynamicCategory')
            ->orderBy('order', 'asc')
            ->latest('id')
            ->get();
    }

    /**
     * Store a new FAQ
     */
    public function storeFaq(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Find FAQ by ID with category
     */
    public function findFaq(int $id)
    {
        return $this->model
            ->with('dynamicCategory')
            ->findOrFail($id);
    }

    /**
     * Update an existing FAQ
     */
    public function updateFaq(array $data, int $id)
    {
        $faq = $this->model->findOrFail($id);
        $faq->update($data);
        return $faq;
    }

    /**
     * Delete FAQ by ID
     */
    public function destroyFaq(int $id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Search FAQs by question or answer (with category)
     */
    public function searchFaq($query)
    {
        return $this->model
            ->with('dynamicCategory')
            ->when($query, function ($q) use ($query) {
                $q->where('question', 'LIKE', "%{$query}%")
                  ->orWhere('answer', 'LIKE', "%{$query}%");
            })
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Get FAQs by dynamic category ID
     */
    public function getFaqByCategory($categoryId)
    {
        return $this->model
            ->with('dynamicCategory')
            ->where('dynamic_category_id', $categoryId)
            ->orderBy('order', 'asc')
            ->get();
    }
}
