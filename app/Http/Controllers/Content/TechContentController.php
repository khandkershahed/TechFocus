<?php

namespace App\Http\Controllers\Content;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\NewsTrend;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class TechContentController extends Controller
{
    /**
     * Display all tech contents.
     */
    public function index()
    {
        $contents = NewsTrend::byType('tech_contents')
            ->with('addedBy:id,name')
            ->latest('id')
            ->get(['id', 'title', 'author', 'added_by', 'type', 'featured']);

        return view('admin.pages.techContent.index', compact('contents'));
    }

    /**
     * Show the create form.
     */
    public function create()
    {
        $brands     = DB::table('brands')->select('id', 'title')->latest('id')->get();
        $categories = Category::with('children.children.children.children.children.children')->latest('id')->get();
        $industries = DB::table('industries')->select('id', 'name')->latest('id')->get();
        $solutions  = DB::table('solution_details')->select('id', 'name')->latest('id')->get();

        return view('admin.pages.techContent.create', compact('brands', 'categories', 'industries', 'solutions'));
    }

    /**
     * Store a newly created tech content.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'type'      => 'required|string',
            'badge'     => 'nullable|string|max:255',
            'featured'  => 'required|in:0,1',
            'short_des' => 'nullable|string',
            'long_des'  => 'nullable|string',
            'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'source_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except(['thumbnail_image', 'banner_image', 'source_image']);
        $data['brand_id']    = json_encode($request->brand_id ?? []);
        $data['category_id'] = json_encode($request->category_id ?? []);
        $data['industry_id'] = json_encode($request->industry_id ?? []);
        $data['solution_id'] = json_encode($request->solution_id ?? []);
        $data['added_by']    = Auth::id();
        $data['type']        = 'tech_contents';

        // Handle image uploads
        if ($request->hasFile('thumbnail_image')) {
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('content', 'public');
        }
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('content', 'public');
        }
        if ($request->hasFile('source_image')) {
            $data['source_image'] = $request->file('source_image')->store('content', 'public');
        }

        NewsTrend::create($data);

        return redirect()->route('admin.tech-content.index')->with('success', 'Tech content created successfully.');
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $content    = NewsTrend::findOrFail($id);
        $brands     = DB::table('brands')->select('id', 'title')->latest('id')->get();
        $categories = Category::with('children.children.children.children.children.children')->latest('id')->get();
        $industries = DB::table('industries')->select('id', 'name')->latest('id')->get();
        $solutions  = DB::table('solution_details')->select('id', 'name')->latest('id')->get();

        return view('admin.pages.techContent.edit', compact('content', 'brands', 'categories', 'industries', 'solutions'));
    }

    /**
     * Update an existing tech content.
     */
    public function update(Request $request, $id)
    {
        $content = NewsTrend::findOrFail($id);

        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'type'      => 'required|string',
            'badge'     => 'nullable|string|max:255',
            'featured'  => 'required|in:0,1',
            'short_des' => 'nullable|string',
            'long_des'  => 'nullable|string',
            'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'source_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except(['thumbnail_image', 'banner_image', 'source_image']);
        $data['brand_id']    = json_encode($request->brand_id ?? []);
        $data['category_id'] = json_encode($request->category_id ?? []);
        $data['industry_id'] = json_encode($request->industry_id ?? []);
        $data['solution_id'] = json_encode($request->solution_id ?? []);
        $data['added_by']    = Auth::id();
        $data['type']        = 'tech_contents';

        // Handle new images and delete old ones
        if ($request->hasFile('thumbnail_image')) {
            if ($content->thumbnail_image && Storage::disk('public')->exists($content->thumbnail_image)) {
                Storage::disk('public')->delete($content->thumbnail_image);
            }
            $data['thumbnail_image'] = $request->file('thumbnail_image')->store('content', 'public');
        }

        if ($request->hasFile('banner_image')) {
            if ($content->banner_image && Storage::disk('public')->exists($content->banner_image)) {
                Storage::disk('public')->delete($content->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('content', 'public');
        }

        if ($request->hasFile('source_image')) {
            if ($content->source_image && Storage::disk('public')->exists($content->source_image)) {
                Storage::disk('public')->delete($content->source_image);
            }
            $data['source_image'] = $request->file('source_image')->store('content', 'public');
        }

        $content->update($data);

        return redirect()->route('admin.tech-content.index')->with('success', 'Tech content updated successfully.');
    }

    /**
     * Delete a tech content.
     */
    public function destroy($id)
    {
        $content = NewsTrend::findOrFail($id);

        // Delete associated images
        foreach (['thumbnail_image', 'banner_image', 'source_image'] as $field) {
            if ($content->$field && Storage::disk('public')->exists($content->$field)) {
                Storage::disk('public')->delete($content->$field);
            }
        }

        $content->delete();

        return redirect()->back()->with('success', 'Tech content deleted successfully.');
    }
}
