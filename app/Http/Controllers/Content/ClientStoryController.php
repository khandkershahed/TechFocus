<?php

namespace App\Http\Controllers\Content;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\NewsTrend;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientStoryController extends Controller
{
    public function index()
    {
        return view('admin.pages.story.index', [
            'contents' => NewsTrend::byType('client_stories')->with('addedBy')->latest('id')->get(['title','author','added_by','type','id']),
        ]);
    }

    public function create()
    {
        $data = [
            'brands'     => DB::table('brands')->select('id', 'title')->orderBy('id', 'desc')->get(),
            'categories' => Category::with('children.children.children.children.children.children')->latest('id')->get(),
            'industries' => DB::table('industries')->select('id', 'name')->orderBy('id', 'desc')->get(),
            'solutions'  => DB::table('solution_details')->select('id', 'name')->orderBy('id', 'desc')->get(),
        ];
        return view('admin.pages.story.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'badge' => 'required|string|max:255',
            'featured' => 'required|in:0,1',
            'type' => 'required|string',
            'address' => 'required|string',
            'header' => 'required|string',
            'footer' => 'required|string',
            'short_des' => 'required|string',
            'long_des' => 'required|string',
            'thumbnail_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'source_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'source_link' => 'nullable|url',
            'additional_button_name' => 'nullable|string|max:255',
            'additional_url' => 'nullable|url',
            'brand_id' => 'nullable|array',
            'brand_id.*' => 'exists:brands,id',
            'category_id' => 'nullable|array',
            'category_id.*' => 'exists:categories,id',
            'industry_id' => 'nullable|array',
            'industry_id.*' => 'exists:industries,id',
            'solution_id' => 'nullable|array',
            'solution_id.*' => 'exists:solution_details,id',
            'tags' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Handle file uploads
            $thumbnailImage = $this->uploadImage($request->file('thumbnail_image'));
            $bannerImage = $this->uploadImage($request->file('banner_image'));
            $sourceImage = $this->uploadImage($request->file('source_image'));

            // Create the client story
            $clientStory = NewsTrend::create([
                'title' => $request->title,
                'author' => $request->author,
                'badge' => $request->badge,
                'featured' => $request->featured,
                'type' => $request->type,
                'address' => $request->address,
                'header' => $request->header,
                'footer' => $request->footer,
                'short_des' => $request->short_des,
                'long_des' => $request->long_des,
                'thumbnail_image' => $thumbnailImage,
                'banner_image' => $bannerImage,
                'source_image' => $sourceImage,
                'source_link' => $request->source_link,
                'additional_button_name' => $request->additional_button_name,
                'additional_url' => $request->additional_url,
                'brand_id' => $request->brand_id ? json_encode($request->brand_id) : null,
                'category_id' => $request->category_id ? json_encode($request->category_id) : null,
                'industry_id' => $request->industry_id ? json_encode($request->industry_id) : null,
                'solution_id' => $request->solution_id ? json_encode($request->solution_id) : null,
                'tags' => $request->tags,
                'added_by' => Auth::id(), // This sets the user who created the story
                'slug' => Str::slug($request->title) . '-' . time(),
            ]);

            DB::commit();

            return redirect()->route('admin.story.index')
                ->with('success', 'Client story created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error creating client story: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $data = [
            'content'    => NewsTrend::findOrFail($id),
            'brands'     => DB::table('brands')->select('id', 'title')->orderBy('id', 'desc')->get(),
            'categories' => Category::with('children.children.children.children.children.children')->latest('id')->get(),
            'industries' => DB::table('industries')->select('id', 'name')->orderBy('id', 'desc')->get(),
            'solutions'  => DB::table('solution_details')->select('id', 'name')->orderBy('id', 'desc')->get(),
        ];
        return view('admin.pages.story.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'badge' => 'required|string|max:255',
            'featured' => 'required|in:0,1',
            'type' => 'required|string',
            'address' => 'required|string',
            'header' => 'required|string',
            'footer' => 'required|string',
            'short_des' => 'required|string',
            'long_des' => 'required|string',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'source_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'source_link' => 'nullable|url',
            'additional_button_name' => 'nullable|string|max:255',
            'additional_url' => 'nullable|url',
            'brand_id' => 'nullable|array',
            'brand_id.*' => 'exists:brands,id',
            'category_id' => 'nullable|array',
            'category_id.*' => 'exists:categories,id',
            'industry_id' => 'nullable|array',
            'industry_id.*' => 'exists:industries,id',
            'solution_id' => 'nullable|array',
            'solution_id.*' => 'exists:solution_details,id',
            'tags' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $clientStory = NewsTrend::findOrFail($id);

            // Handle file uploads
            $thumbnailImage = $clientStory->thumbnail_image;
            $bannerImage = $clientStory->banner_image;
            $sourceImage = $clientStory->source_image;

            if ($request->hasFile('thumbnail_image')) {
                $thumbnailImage = $this->uploadImage($request->file('thumbnail_image'));
                $this->deleteImage($clientStory->thumbnail_image);
            }

            if ($request->hasFile('banner_image')) {
                $bannerImage = $this->uploadImage($request->file('banner_image'));
                $this->deleteImage($clientStory->banner_image);
            }

            if ($request->hasFile('source_image')) {
                $sourceImage = $this->uploadImage($request->file('source_image'));
                $this->deleteImage($clientStory->source_image);
            }

            // Update the client story
            $clientStory->update([
                'title' => $request->title,
                'author' => $request->author,
                'badge' => $request->badge,
                'featured' => $request->featured,
                'type' => $request->type,
                'address' => $request->address,
                'header' => $request->header,
                'footer' => $request->footer,
                'short_des' => $request->short_des,
                'long_des' => $request->long_des,
                'thumbnail_image' => $thumbnailImage,
                'banner_image' => $bannerImage,
                'source_image' => $sourceImage,
                'source_link' => $request->source_link,
                'additional_button_name' => $request->additional_button_name,
                'additional_url' => $request->additional_url,
                'brand_id' => $request->brand_id ? json_encode($request->brand_id) : null,
                'category_id' => $request->category_id ? json_encode($request->category_id) : null,
                'industry_id' => $request->industry_id ? json_encode($request->industry_id) : null,
                'solution_id' => $request->solution_id ? json_encode($request->solution_id) : null,
                'tags' => $request->tags,
            ]);

            DB::commit();

            return redirect()->route('admin.story.index')
                ->with('success', 'Client story updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating client story: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $clientStory = NewsTrend::findOrFail($id);
            
            // Delete images
            $this->deleteImage($clientStory->thumbnail_image);
            $this->deleteImage($clientStory->banner_image);
            $this->deleteImage($clientStory->source_image);
            
            $clientStory->delete();

            return redirect()->route('admin.story.index')
                ->with('success', 'Client story deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting client story: ' . $e->getMessage());
        }
    }

    /**
     * Upload image to storage
     */
    private function uploadImage($file)
    {
        if ($file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('content', $filename, 'public');
            return $filename;
        }
        return null;
    }

    /**
     * Delete image from storage
     */
    private function deleteImage($filename)
    {
        if ($filename && file_exists(public_path('storage/content/' . $filename))) {
            unlink(public_path('storage/content/' . $filename));
        }
    }
}