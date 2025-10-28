<?php

namespace App\Http\Controllers\Content;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\NewsTrend;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.blog.index', [
            'blogs' => NewsTrend::byType('blogs')->with('addedBy')->latest('id')->get(['title','author','added_by','type','id']),
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
        return view('admin.pages.blog.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            // Add other validation rules as needed
        ]);

        try {
            // Handle multiple values - convert arrays to JSON strings
            $brandIds = $request->brand_id ? json_encode($request->brand_id) : null;
            $categoryIds = $request->category_id ? json_encode($request->category_id) : null;
            $industryIds = $request->industry_id ? json_encode($request->industry_id) : null;
            $solutionIds = $request->solution_id ? json_encode($request->solution_id) : null;

            $blog = NewsTrend::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'author' => $request->author,
                'type' => 'blogs',
                'brand_id' => $brandIds,
                'category_id' => $categoryIds,
                'industry_id' => $industryIds,
                'solution_id' => $solutionIds,
                'added_by' => Auth::id(),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
                // Add other fields as needed
            ]);

            return redirect()->route('blogs.index')->with('success', 'Blog created successfully!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating blog: ' . $e->getMessage())->withInput();
        }
    }

   
    public function edit($id)
    {
        $blog = NewsTrend::findOrFail($id);
        
        // Decode JSON strings back to arrays for form population
        $blog->brand_id = $blog->brand_id ? json_decode($blog->brand_id, true) : [];
        $blog->category_id = $blog->category_id ? json_decode($blog->category_id, true) : [];
        $blog->industry_id = $blog->industry_id ? json_decode($blog->industry_id, true) : [];
        $blog->solution_id = $blog->solution_id ? json_decode($blog->solution_id, true) : [];

        $data = [
            'content'    => $blog,
            'brands'     => DB::table('brands')->select('id', 'title')->orderBy('id', 'desc')->get(),
            'categories' => Category::with('children.children.children.children.children.children')->latest('id')->get(),
            'industries' => DB::table('industries')->select('id', 'name')->orderBy('id', 'desc')->get(),
            'solutions'  => DB::table('solution_details')->select('id', 'name')->orderBy('id', 'desc')->get(),
        ];
        return view('admin.pages.blog.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            // Add other validation rules as needed
        ]);

        try {
            $blog = NewsTrend::findOrFail($id);

            // Handle multiple values - convert arrays to JSON strings
            $brandIds = $request->brand_id ? json_encode($request->brand_id) : null;
            $categoryIds = $request->category_id ? json_encode($request->category_id) : null;
            $industryIds = $request->industry_id ? json_encode($request->industry_id) : null;
            $solutionIds = $request->solution_id ? json_encode($request->solution_id) : null;

            $blog->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'author' => $request->author,
                'brand_id' => $brandIds,
                'category_id' => $categoryIds,
                'industry_id' => $industryIds,
                'solution_id' => $solutionIds,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
                // Update other fields as needed
            ]);

            return redirect()->route('blogs.index')->with('success', 'Blog updated successfully!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating blog: ' . $e->getMessage())->withInput();
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
        try {
            $blog = NewsTrend::findOrFail($id);
            $blog->delete();

            return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting blog: ' . $e->getMessage());
        }
    }
}