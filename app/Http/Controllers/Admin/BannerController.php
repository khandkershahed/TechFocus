<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Brand;
use Illuminate\Support\Str;
use App\Models\Admin\Banner;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\Industry;
use App\Models\Admin\NewsTrend;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Admin\SolutionDetail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.banner.index', [
            'banners' => Banner::get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.banner.create', [
            'brands'     => Brand::get(['id', 'title']),
            'categories' => Category::get(['id', 'name']),
            'products'   => Product::get(['id', 'name']),
            'solutions'  => SolutionDetail::get(['id', 'name']),
            'industries' => Industry::get(['id', 'name']),
            'contents'   => NewsTrend::get(['id', 'title']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {
        DB::beginTransaction();

        try {
            $files = [
                'banner_one_image'   => $request->file('banner_one_image'),
                'banner_two_image'   => $request->file('banner_two_image'),
                'banner_three_image' => $request->file('banner_three_image'),
                'meta_image'         => $request->file('meta_image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (! empty($file)) {
                    $filePath            = 'banner/' . $key;
                    $uploadedFiles[$key] = fileUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // Create the Offer model instance
            Banner::create([
                'category'           => $request->category,
                'brand_id'           => $request->brand_id,
                'category_id'        => $request->category_id,
                'product_id'         => $request->product_id,
                'solution_id'        => $request->solution_id,
                'industry_id'        => $request->industry_id,
                'content_id'         => $request->content_id,
                'page_name'          => $request->page_name,
                'page_title'         => $request->page_title,
                'banner_one_name'    => $request->banner_one_name,
                'banner_two_name'    => $request->banner_two_name,
                'banner_three_name'  => $request->banner_three_name,
                'banner_one_slug'    => Str::slug($request->banner_one_name),
                'banner_two_slug'    => Str::slug($request->banner_two_name),
                'banner_three_slug'  => Str::slug($request->banner_three_name),
                'banner_one_image'   => $uploadedFiles['banner_one_image']['status'] == 1 ? $uploadedFiles['banner_one_image']['file_path'] :  null,
                'banner_two_image'   => $uploadedFiles['banner_two_image']['status'] == 1 ? $uploadedFiles['banner_two_image']['file_path'] : null,
                'banner_three_image' => $uploadedFiles['banner_three_image']['status'] == 1 ? $uploadedFiles['banner_three_image']['file_path'] : null,
                'meta_image'         => $uploadedFiles['meta_image']['status'] == 1 ? $uploadedFiles['meta_image']['file_path'] : null,
                'banner_one_link'    => $request->banner_one_link,
                'banner_two_link'    => $request->banner_two_link,
                'banner_three_link'  => $request->banner_three_link,
                'meta_title'         => $request->meta_title,
                'meta_description'   => $request->meta_description,
                'meta_tags'          => $request->meta_tags,
                'status'             => $request->status,
            ]);

            DB::commit();
            return redirect()->route('admin.banner.index')->with('success', 'Data created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'An error occurred while creating the Offer: ' . $e->getMessage());
        }
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
        return view('admin.pages.banner.edit', [
            'banner'     => Banner::find($id),
            'brands'     => Brand::get(['id', 'title']),
            'categories' => Category::get(['id', 'name']),
            'products'   => Product::get(['id', 'name']),
            'solutions'  => SolutionDetail::get(['id', 'name']),
            'industries' => Industry::get(['id', 'name']),
            'contents'   => NewsTrend::get(['id', 'title']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $banner = Banner::findOrFail($id);

            $files = [
                'banner_one_image'   => $request->file('banner_one_image'),
                'banner_two_image'   => $request->file('banner_two_image'),
                'banner_three_image' => $request->file('banner_three_image'),
                'meta_image'         => $request->file('meta_image'),
            ];

            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (! empty($file)) {
                    $filePath = 'banner/' . $key;

                    // Delete old file if exists
                    if ($banner->$key) {
                        Storage::delete($banner->$key);
                    }

                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            $banner->update([
                'category'           => $request->category,
                'brand_id'           => $request->brand_id,
                'category_id'        => $request->category_id,
                'product_id'         => $request->product_id,
                'solution_id'        => $request->solution_id,
                'industry_id'        => $request->industry_id,
                'content_id'         => $request->content_id,
                'page_name'          => $request->page_name,
                'page_title'         => $request->page_title,
                'banner_one_name'    => $request->banner_one_name,
                'banner_two_name'    => $request->banner_two_name,
                'banner_three_name'  => $request->banner_three_name,
                'banner_one_slug'    => Str::slug($request->banner_one_name),
                'banner_two_slug'    => Str::slug($request->banner_two_name),
                'banner_three_slug'  => Str::slug($request->banner_three_name),
                'banner_one_image'   => $uploadedFiles['banner_one_image']['status'] == 1 ? $uploadedFiles['banner_one_image']['file_path'] :  $banner->banner_one_image,
                'banner_two_image'   => $uploadedFiles['banner_two_image']['status'] == 1 ? $uploadedFiles['banner_two_image']['file_path'] : $banner->banner_two_image,
                'banner_three_image' => $uploadedFiles['banner_three_image']['status'] == 1 ? $uploadedFiles['banner_three_image']['file_path'] : $banner->banner_three_image,
                'meta_image'         => $uploadedFiles['meta_image']['status'] == 1 ? $uploadedFiles['meta_image']['file_path'] : $banner->meta_image,
                'banner_one_link'    => $request->banner_one_link,
                'banner_two_link'    => $request->banner_two_link,
                'banner_three_link'  => $request->banner_three_link,
                'meta_title'         => $request->meta_title,
                'meta_description'   => $request->meta_description,
                'meta_tags'          => $request->meta_tags,
                'status'             => $request->status,
            ]);

            DB::commit();
            return redirect()->route('admin.banner.index')->with('success', 'Data updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'An error occurred while updating the Offer: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $files = [
            'image'    => $banner->image,
        ];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $oldFile = $banner->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $banner->delete();
    }
}
