<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DynamicCategoryRequest;
use App\Repositories\Interfaces\DynamicCategoryRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DynamicCategoryController extends Controller
{
    public function __construct(
        private DynamicCategoryRepositoryInterface $dynamicCategoryRepository
    ) {}

    /**
     * Display a listing of dynamic categories.
     */
    public function index(): View
    {
        $dynamicCategories = $this->dynamicCategoryRepository->allDynamicCategory();
        return view('admin.pages.dynamicCategory.index', compact('dynamicCategories'));
    }

    /**
     * Store a newly created dynamic category.
     */
    public function store(DynamicCategoryRequest $request): RedirectResponse
    {
        $this->dynamicCategoryRepository->storeDynamicCategory(
            $request->only('parent_id', 'name', 'type', 'status')
        );

        return redirect()->back()->with('success', 'Dynamic category has been saved successfully!');
    }

    /**
     * Update an existing dynamic category.
     */
    public function update(DynamicCategoryRequest $request, int $id): RedirectResponse
    {
        $this->dynamicCategoryRepository->updateDynamicCategory(
            $request->only('parent_id', 'name', 'type', 'status'),
            $id
        );

        return redirect()->back()->with('success', 'Dynamic category has been updated successfully!');
    }

    /**
     * Remove the specified dynamic category.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->dynamicCategoryRepository->destroyDynamicCategory($id);

        return redirect()->back()->with('success', 'Dynamic category has been deleted successfully!');
    }
}
