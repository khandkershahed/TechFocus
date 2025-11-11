<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /** INDEX */
public function index(Request $request)
{
    $query = Category::with('parent');

    // ✅ Apply search filter
    if ($search = $request->input('search')) {
        $query->where('name', 'like', "%{$search}%");
    }

    $categories = $query->orderBy('name', 'ASC')->paginate(10);

    $parentCategories = Category::whereNull('parent_id')
        ->orderBy('name')
        ->get();

    $treeCategories = Category::with('children')
        ->whereNull('parent_id')
        ->orderBy('name')
        ->get();

    

    return view('admin.pages.category.index', compact('categories', 'parentCategories', 'treeCategories','search'));
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
    $category = $this->categoryRepository->findCategory($id);

    // Only parent categories except current one
    $parentCategories = Category::whereNull('parent_id')
        ->where('id', '!=', $id)
        ->get();


    return view('admin.pages.category.edit', compact('category', 'parentCategories'));
}

public function update(Request $request, $id)
{
    $category = $this->categoryRepository->findCategory($id);

    if (!$category) {
        return redirect()->route('admin.category.index')
                         ->with('error', 'Category not found.');
    }

    $data = [
        'name'        => $request->name,
        'slug'        => Str::slug($request->name),
        'is_parent'   => $request->has('is_parent') ? 1 : 0,
        'parent_id'   => $request->has('is_parent') ? null : $request->parent_id,
        'description' => $request->description,
        'country_id'  => $request->country_id,
    ];

    // Image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('category/image', 'public');
        $data['image'] = $imagePath;

        // delete old image
        if ($category->image && \Storage::disk('public')->exists($category->image)) {
            \Storage::disk('public')->delete($category->image);
        }
    } else {
        // retain old image
        $data['image'] = $category->image;
    }

    // Logo upload
    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('category/logo', 'public');
        $data['logo'] = $logoPath;

        // delete old logo
        if ($category->logo && \Storage::disk('public')->exists($category->logo)) {
            \Storage::disk('public')->delete($category->logo);
        }
    } else {
        $data['logo'] = $category->logo;
    }

    $this->categoryRepository->updateCategory($data, $id);

    // ✅ Redirect to category index page after update
    return redirect()->route('admin.category.index')
                     ->with('success', 'Category updated successfully.');
}

    /** DELETE */
public function destroy($id)
{
    $category = $this->categoryRepository->findCategory($id);

    if (!$category) {
        return redirect()->back()->with('error', 'Category not found.');
    }

    // Delete image/logo if exists
    $this->deleteFiles([
        storage_path("app/public/category/image/{$category->image}"),
        storage_path("app/public/category/logo/{$category->logo}")
    ]);

    $this->categoryRepository->destroyCategory($id);

    return redirect()->back()->with('success', 'Category deleted successfully.');
}



    /** PREPARE DATA */
  private function prepareData($request, $category = null): array
{
    $imagePath = storage_path('app/public/category/image/');
    $logoPath  = storage_path('app/public/category/logo/');

    return [
        'parent_id'   => $request->parent_id,
        'name'        => $request->name,
        'slug'        => Str::slug($request->name),
        'is_parent'   => $request->has('is_parent') ? 1 : 0, // ✅ Explicit 0/1
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
