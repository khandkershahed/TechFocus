<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Admin\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /** INDEX */
    public function index()
    {
        $categories = Category::with('parent')
            ->orderBy('name', 'ASC')
            ->paginate(10);

        // ✅ FIXED: Parent category list must be separate
        $parentCategories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        // ✅ FIXED: Full tree for recursive dropdown
        $treeCategories = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('admin.pages.category.index', compact('categories', 'parentCategories', 'treeCategories'));
    }

    /** STORE */
    public function store(CategoryRequest $request)
    {
        $data = $this->prepareData($request);
        $this->categoryRepository->storeCategory($data);

        return back()->with('success', 'Category Added Successfully');
    }

    /** EDIT (Loaded via Ajax) */
    // public function edit($id)
    // {
    //     $category = Category::with('parent')->findOrFail($id);

    //     // ✅ Only parent items except itself
    //     $parentCategories = Category::whereNull('parent_id')
    //         ->where('id', '!=', $id)
    //         ->get();

    //     return view('admin.pages.category.partial.edit_form', compact('category', 'parentCategories'));
    // }
public function edit($id)
{
    $category = Category::with('children')->findOrFail($id);

    $parentCategories = Category::whereNull('parent_id')
        ->where('id', '!=', $id)
        ->with('children')
        ->get();

    return view('admin.pages.category.partial.edit_form', compact('category', 'parentCategories'));
}


    /** UPDATE */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryRepository->findCategory($id);

        if (!$category) {
            return back()->with('error', 'Category not found.');
        }

        $data = $this->prepareData($request, $category);
        $this->categoryRepository->updateCategory($data, $id);

        return back()->with('success', 'Category Updated Successfully');
    }

    /** DELETE */
    public function destroy($id)
    {
        $category = $this->categoryRepository->findCategory($id);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $this->deleteFiles([
            storage_path("app/public/category/image/{$category->image}"),
            storage_path("app/public/category/logo/{$category->logo}")
        ]);

        $this->categoryRepository->destroyCategory($id);

        return response()->json(['success' => 'Category deleted successfully']);
    }

    /** PREPARE DATA */
    private function prepareData($request, $category = null): array
    {
        $imagePath = storage_path('app/public/category/image/');
        $logoPath  = storage_path('app/public/category/logo/');

        return [
            'country_id'  => $request->country_id,
            'parent_id'   => $request->parent_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'is_parent'   => $request->boolean('is_parent'),
            'image'       => $this->handleFileUpload($request, 'image', $imagePath, $category?->image),
            'logo'        => $this->handleFileUpload($request, 'logo', $logoPath, $category?->logo),
            'description' => $request->description,
        ];
    }

    /** UPLOAD HANDLER */
    private function handleFileUpload($request, string $field, string $path, ?string $oldFile = null): string
    {
        if ($request->hasFile($field)) {
            $upload = customUpload($request->file($field), $path);
            return $upload['file_name'] ?? $oldFile ?? 'backend/images/no-image-available.png';
        }

        return $oldFile ?? 'backend/images/no-image-available.png';
    }

    /** FILE DELETE */
    private function deleteFiles(array $paths): void
    {
        foreach ($paths as $path) {
            if (File::exists($path)) File::delete($path);
        }
    }
}
