<?php

namespace App\Http\Controllers;

use App\Models\PageBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PageBannerController extends Controller
{
    /**
     * Display all banners
     */
    public function index()
    {
        $banners = PageBanner::latest()->get();
        return view('admin.page_banners.index', compact('banners'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.page_banners.create');
    }

    /**
     * Store new banner
     */
    // public function store(Request $request)
    // {
    //     try {
    //         // Custom validation
    //         $validator = Validator::make($request->all(), [
    //             'page_name' => 'required|string|max:191',
    //             'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    //             'title' => 'nullable|string|max:250',
    //             'badge' => 'nullable|string|max:200',
    //             'button_name' => 'nullable|string|max:200',
    //             'button_link' => 'nullable|url|max:500',
    //             'banner_link' => 'nullable|url|max:500',
    //             'status' => 'nullable|in:active,inactive',
    //         ]);

    //         if ($validator->fails()) {
    //             return redirect()->back()->withErrors($validator)->withInput();
    //         }

    //         // Handle image upload
    //         $imageName = null;
    //         if ($request->hasFile('image') && $request->file('image')->isValid()) {
    //             $imageName = time() . '_' . Str::slug($request->page_name) . '.' . $request->image->extension();
    //             $request->image->move(public_path('uploads/page_banners'), $imageName);
    //         }

    //         PageBanner::create([
    //             'page_name' => $request->page_name,
    //             'slug' => Str::slug($request->page_name),
    //             'image' => $imageName,
    //             'badge' => $request->badge,
    //             'title' => $request->title,
    //             'button_name' => $request->button_name,
    //             'button_link' => $request->button_link,
    //             'banner_link' => $request->banner_link,
    //             'status' => $request->status ?? 'active',
    //             'created_by' => Auth::guard('admin')->id(),
    //         ]);

    //         return redirect()->route('page_banners.index')->with('success', 'Banner created successfully.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withInput()->with('error', 'Error creating banner: ' . $e->getMessage());
    //     }
    // }

public function store(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'page_name' => 'required|string|max:191',
            'image' => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'nullable|string|max:250',
            'badge' => 'nullable|string|max:200',
            'button_name' => 'nullable|string|max:200',
            'button_link' => 'nullable|url|max:500',
            'banner_link' => 'nullable|url|max:500',
            'status' => 'nullable|in:active,inactive',
        ], [
            'image.required' => 'Please select an image file',
            'image.file' => 'The uploaded file is not valid',
            'image.mimes' => 'Only JPG, JPEG, PNG, and WebP files are allowed',
            'image.max' => 'File size should not exceed 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if file upload was successful
        if (!$request->hasFile('image')) {
            return redirect()->back()->with('error', 'No file was uploaded.')->withInput();
        }

        $uploadedFile = $request->file('image');
        
        if (!$uploadedFile->isValid()) {
            return redirect()->back()->with('error', 'File upload failed: ' . $uploadedFile->getErrorMessage())->withInput();
        }

        // Handle image upload
        $imageName = time() . '_' . Str::slug($request->page_name) . '.' . $uploadedFile->getClientOriginalExtension();
        $uploadedFile->move(public_path('uploads/page_banners'), $imageName);

        PageBanner::create([
            'page_name' => $request->page_name,
            'slug' => Str::slug($request->page_name),
            'image' => $imageName,
            'badge' => $request->badge,
            'title' => $request->title,
            'button_name' => $request->button_name,
            'button_link' => $request->button_link,
            'banner_link' => $request->banner_link,
            'status' => $request->status ?? 'active',
            'created_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('page_banners.index')->with('success', 'Banner created successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 'Error creating banner: ' . $e->getMessage());
    }
}



    /**
     * Edit existing banner
     */
    public function edit(PageBanner $pageBanner)
    {
        return view('admin.page_banners.edit', compact('pageBanner'));
    }

    /**
     * Update banner
     */
    public function update(Request $request, PageBanner $pageBanner)
    {
        try {
            $validator = Validator::make($request->all(), [
                'page_name' => 'required|string|max:191',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'title' => 'nullable|string|max:250',
                'badge' => 'nullable|string|max:200',
                'button_name' => 'nullable|string|max:200',
                'button_link' => 'nullable|url|max:500',
                'banner_link' => 'nullable|url|max:500',
                'status' => 'nullable|in:active,inactive',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imageName = time() . '_' . Str::slug($request->page_name) . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/page_banners'), $imageName);
                $pageBanner->image = $imageName;
            }

            $pageBanner->update([
                'page_name' => $request->page_name,
                'slug' => Str::slug($request->page_name),
                'badge' => $request->badge,
                'title' => $request->title,
                'button_name' => $request->button_name,
                'button_link' => $request->button_link,
                'banner_link' => $request->banner_link,
                'status' => $request->status ?? 'active',
                'updated_by' => Auth::guard('admin')->id(),
            ]);

            return redirect()->route('page_banners.index')->with('success', 'Banner updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error updating banner: ' . $e->getMessage());
        }
    }

    /**
     * Delete banner
     */
    public function destroy(PageBanner $pageBanner)
    {
        try {
            $pageBanner->delete();
            return redirect()->route('page_banners.index')->with('success', 'Banner deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting banner: ' . $e->getMessage());
        }
    }
}
