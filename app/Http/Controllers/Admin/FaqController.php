<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FaqRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\FaqRepositoryInterface;
use App\Repositories\Interfaces\DynamicCategoryRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqController extends Controller
{
    private FaqRepositoryInterface $faqRepository;
    private DynamicCategoryRepositoryInterface $dynamicCategoryRepository;

    public function __construct(
        FaqRepositoryInterface $faqRepository,
        DynamicCategoryRepositoryInterface $dynamicCategoryRepository
    ) {
        $this->faqRepository = $faqRepository;
        $this->dynamicCategoryRepository = $dynamicCategoryRepository;
    }

    /**
     * Display a listing of FAQs.
     */
    public function index(): View
    {
        $faqs = $this->faqRepository->allFaq();
        $dynamicCategories = $this->dynamicCategoryRepository->allDynamicActiveCategory('faqs');

        if ($dynamicCategories->isEmpty()) {
            Log::warning('No active dynamic categories found for FAQs.');
        }

        return view('admin.pages.faq.index', compact('faqs', 'dynamicCategories'));
    }

    /**
     * Store a newly created FAQ.
     */
    public function store(FaqRequest $request): RedirectResponse
    {
        $data = $request->only([
            'dynamic_category_id',
            'question',
            'answer',
            'order',
            'is_published',
        ]);

        $this->faqRepository->storeFaq($data);

        return redirect()->back()->with('success', 'FAQ created successfully!');
    }

    /**
     * Update the specified FAQ.
     */
    public function update(FaqRequest $request, int $id): RedirectResponse
    {
        $data = $request->only([
            'dynamic_category_id',
            'question',
            'answer',
            'order',
            'is_published',
        ]);

        $this->faqRepository->updateFaq($data, $id);

        return redirect()->back()->with('success', 'FAQ updated successfully!');
    }

    /**
     * Remove the specified FAQ.
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->faqRepository->destroyFaq($id);

        return redirect()->back()->with('success', 'FAQ deleted successfully!');
    }

   

}
