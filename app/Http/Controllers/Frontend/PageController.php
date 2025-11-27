<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use App\Models\Admin\Catalog;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\BrandPage;
use App\Models\Admin\NewsTrend;
use Yoeunes\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Models\Admin\SolutionDetail;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function overview($slug)
    {
        $data = [
            'brand' => Brand::with('brandPage')->where('slug', $slug)->select('id', 'slug', 'title', 'logo')->firstOrFail(),
        ];
        if (!empty($data['brand']->brandPage)) {
            return view('frontend.pages.brandPage.overview', $data);
        } else {
            Session::flash('warning', 'No Details information found for this Brand');
            return redirect()->back()->with('warning', 'No Details information found for this Brand');
        }
    }

    public function brandProducts($slug, Request $request)
    {
        $data = [
            'brand' => Brand::with('brandPage', 'brandProducts', 'products')->where('slug', $slug)->select('id', 'slug', 'title', 'logo')->firstOrFail(),
        ];
        return view('frontend.pages.brandPage.products', $data);
    }

    public function productDetails($id, $slug, Request $request)
    {
        $data = [
            'product' => Product::with('multiImages')->where('slug', $slug)->first(),
            'brand' => Brand::with('brandPage')->where('slug', $id)->select('id', 'slug', 'title', 'logo')->first(),
        ];
        
        if (request()->has('rfq_redirect') && request('rfq_redirect') == 'success') {
            Session::flash('success', 'Product added to RFQ successfully!');
        }

        return view('frontend.pages.product.product_details', $data);
    }

    public function brandPdf($slug)
    {
        $brand = Brand::with('brandPage')
            ->where('slug', $slug)
            ->select('id', 'slug', 'title', 'logo')
            ->firstOrFail();

        // Enhanced query to handle different JSON formats
        $brandCatalogs = Catalog::with(['attachments'])
            ->where(function($query) use ($brand) {
                // Try multiple approaches to find catalogs for this brand
                
                // Approach 1: Search for string ID (e.g., "10")
                $query->whereJsonContains('brand_id', (string)$brand->id);
                
                // Approach 2: Search for numeric ID (e.g., 10)
                $query->orWhereJsonContains('brand_id', $brand->id);
                
                // Approach 3: Handle empty arrays or null
                $query->orWhere('brand_id', 'like', '%"' . $brand->id . '"%')
                      ->orWhere('brand_id', 'like', '%' . $brand->id . '%');
            })
            ->latest()
            ->get();

        // Debug logging
        \Log::info("=== CATALOG DEBUG INFO ===");
        \Log::info("Brand: {$brand->title} (ID: {$brand->id})");
        \Log::info("Total Catalogs Found: " . $brandCatalogs->count());
        
        foreach ($brandCatalogs as $catalog) {
            \Log::info("Catalog ID: {$catalog->id}, Name: {$catalog->name}, Brand IDs: {$catalog->brand_id}");
        }

        // Get unique categories
        $catalogCategories = $brandCatalogs->pluck('category')->unique()->filter();

        $data = [
            'brand' => $brand,
            'brandCatalogs' => $brandCatalogs,
            'catalogCategories' => $catalogCategories,
        ];

        return view('frontend.pages.brandPage.catalogs', $data);
    }

    public function pdfDetails($slug)
    {
        $data = [
            'brand' => Brand::with('brandPage')->where('slug', $slug)->select('id', 'slug', 'title', 'logo')->firstOrFail(),
        ];
        return view('frontend.pages.brandPage.pdf_details', $data);
    }

    public function content($slug)
    {
        $brand = Brand::with('brandPage')
            ->where('slug', $slug)
            ->select('id', 'slug', 'title', 'logo')
            ->firstOrFail();

        $trends = NewsTrend::whereJsonContains('brand_id', (string)$brand->id)->latest()->paginate(12);

        return view('frontend.pages.brandPage.contents', compact('brand', 'trends'));
    }

    public function contentDetails($slug)
    {
        $categories = Category::with('children')->where('is_parent', 1)->get();
        $solutions = SolutionDetail::latest()->limit(4)->get();
        $news_trends = NewsTrend::where('type', 'trends')->limit(4)->get();
        
        $data = [
            'newsTrend' => NewsTrend::where('slug', $slug)->first(),
            'categories' => $categories,
            'solutions' => $solutions,
            'news_trends' => $news_trends,
        ];
        
        return view('frontend.pages.brandPage.content_details', $data);
    }
}