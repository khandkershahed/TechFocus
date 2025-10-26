<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

use App\Http\Requests\CategoryRequest;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data = [
            'categories' => $this->categoryRepository->allCategory(),
       ];
        return view('admin.pages.category.index', $data);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
                $mainFile = $request->file('image');
                $logoFile = $request->file('logo');

                $imageFilePath = storage_path('app/public/category/image/');
                $logoFilePath  = storage_path('app/public/category/logo/');

                // Handle main image upload
                if (!empty($mainFile)) {
                    $globalFunImage = customUpload($mainFile, $imageFilePath);
                } else {
                    $globalFunImage = [
                        'status' => 1,
                        'file_name' => 'backend/images/no-image-available.png'
                    ];
                }

                // Handle logo upload
                if (!empty($logoFile)) {
                    $globalFunLogo = customUpload($logoFile, $logoFilePath);
                } else {
                    $globalFunLogo = [
                        'status' => 1,
                        'file_name' => 'backend/images/no-image-available.png'
                    ];
                }

                $data = [
                    'country_id'  => $request->country_id,
                    'parent_id'   => $request->parent_id,
                    'name'        => $request->name,
                    'slug'        => Str::slug($request->name),
                    'is_parent'   => $request->is_parent ?? '0',
                    'image'       => $globalFunImage['file_name'],
                    'logo'        => $globalFunLogo['file_name'],
                    'description' => $request->description,
                ];

                $this->categoryRepository->storeCategory($data);

               

                return redirect()->back()->with('success', 'Category Added Successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
            $mainFile = $request->file('image');
            $logoFile = $request->file('logo');

            $imageFilePath = storage_path('app/public/category/image/');
            $logoFilePath  = storage_path('app/public/category/logo/');

            // Handle main image
            if (!empty($mainFile)) {
                $globalFunImage = customUpload($mainFile, $imageFilePath);
            } else {
                // Set default image filename
                $globalFunImage = [
                    'status' => 1,
                     'file_name' => 'backend/images/no-image-available.png' // default image
                ];
            }

            // Handle logo
            if (!empty($logoFile)) {
                $globalFunLogo = customUpload($logoFile, $logoFilePath);
            } else {
                // Set default logo filename
                $globalFunLogo = [
                    'status' => 1,
                     'file_name' => 'backend/images/no-image-available.png' //  default logo
                ];
            }

            // Save to DB (example)
            $category = Category::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id ?? null,
                'description' => $request->description ?? null,
                'image' => $globalFunImage['file_name'],
                'logo' => $globalFunLogo['file_name'],
                'is_parent' => $request->is_parent ?? 0,
            ]);

        $data = [
            'country_id'  => $request->country_id,
            'parent_id'   => $request->parent_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'is_parent'   => $request->is_parent ?? '0',
            'image'        => $globalFunImage['status'] == 1 ? $globalFunImage['file_name'] : $category->image,
            'logo'         => $globalFunLogo['status'] == 1 ? $globalFunLogo['file_name'] : $category->logo,
            'description' => $request->description,
        ];

        $this->categoryRepository->updateCategory($data, $id);

        return redirect()->back()->with('success', 'Category has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category =  $this->categoryRepository->findCategory($id);

        $paths = [
            storage_path("app/public/category/image/{$category->image}"),
            storage_path("app/public/category/image/{$category->image}"),

            storage_path("app/public/category/logo/{$category->logo}"),
            storage_path("app/public/category/logo/{$category->logo}"),
        ];

        foreach ($paths as $path) {
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $this->categoryRepository->destroyCategory($id);
    }


}
