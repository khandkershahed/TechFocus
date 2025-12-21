<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use App\Models\Admin\Catalog;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\NewsTrend;
use App\Http\Controllers\Controller;
use App\Models\Admin\SolutionDetail;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    /**
     * Reusable Related Brands Method
     */
    private function relatedBrands($brandId)
    {
        return Brand::where('id', '!=', $brandId)
            ->select('id', 'slug', 'title')
            ->limit(10)
            ->get();
    }

    /**
     * Brand Overview
     */
    public function overview($slug)
    {
        $brand = Brand::with('brandPage')
            ->where('slug', $slug)
            ->select('id', 'slug', 'title', 'logo')
            ->firstOrFail();

        if (!$brand->brandPage) {
            Session::flash('warning', 'No Details information found for this Brand');
            return redirect()->back();
        }

        $relatedBrands = $this->relatedBrands($brand->id);

        return view('frontend.pages.brandPage.overview', compact(
            'brand',
            'relatedBrands'
        ));
    }

    /**
     * Brand Products
     */
    public function brandProducts($slug, Request $request)
    {
        $brand = Brand::with('brandPage', 'brandProducts', 'products')
            ->where('slug', $slug)
            ->select('id', 'slug', 'title', 'logo')
            ->firstOrFail();

        $relatedBrands = $this->relatedBrands($brand->id);

        return view('frontend.pages.brandPage.products', compact(
            'brand',
            'relatedBrands'
        ));
    }

    /**
     * Product Details
     */
    public function productDetails($id, $slug, Request $request)
    {
        $product = Product::with('multiImages')
            ->where('slug', $slug)
            ->first();

        $brand = Brand::with('brandPage')
            ->where('slug', $id)
            ->select('id', 'slug', 'title', 'logo')
            ->first();

        if (request()->has('rfq_redirect') && request('rfq_redirect') == 'success') {
            Session::flash('success', 'Product added to RFQ successfully!');
        }

        return view('frontend.pages.product.product_details', compact(
            'product',
            'brand'
        ));
    }

    /**
     * Brand PDF List
     */
    public function brandPdf($slug)
    {
        $brand = Brand::with('brandPage')
            ->where('slug', $slug)
            ->select('id', 'slug', 'title', 'logo')
            ->firstOrFail();

        $brandCatalogs = Catalog::with('attachments')
            ->where(function ($query) use ($brand) {
                $query->whereJsonContains('brand_id', (string) $brand->id)
                      ->orWhereJsonContains('brand_id', $brand->id)
                      ->orWhere('brand_id', 'like', '%"' . $brand->id . '"%')
                      ->orWhere('brand_id', 'like', '%' . $brand->id . '%');
            })
            ->latest()
            ->get();

        $catalogCategories = $brandCatalogs->pluck('category')->unique()->filter();
        $relatedBrands = $this->relatedBrands($brand->id);

        return view('frontend.pages.brandPage.catalogs', compact(
            'brand',
            'brandCatalogs',
            'catalogCategories',
            'relatedBrands'
        ));
    }

    /**
     * Brand PDF Details
     */
    public function pdfDetails($slug)
    {
        $brand = Brand::with('brandPage')
            ->where('slug', $slug)
            ->select('id', 'slug', 'title', 'logo')
            ->firstOrFail();

        $relatedBrands = $this->relatedBrands($brand->id);

        return view('frontend.pages.brandPage.pdf_details', compact(
            'brand',
            'relatedBrands'
        ));
    }

    /**
     * Brand Content List
     */
    public function content($slug)
    {
        $brand = Brand::with('brandPage')
            ->where('slug', $slug)
            ->select('id', 'slug', 'title', 'logo')
            ->firstOrFail();

        $trends = NewsTrend::whereJsonContains('brand_id', (string) $brand->id)
            ->latest()
            ->paginate(12);

        $relatedBrands = $this->relatedBrands($brand->id);

        return view('frontend.pages.brandPage.contents', compact(
            'brand',
            'trends',
            'relatedBrands'
        ));
    }

    /**
     * Content Details
     */
    public function contentDetails($slug)
    {
        $categories = Category::with('children')
            ->where('is_parent', 1)
            ->get();

        $solutions = SolutionDetail::latest()->limit(4)->get();

        $news_trends = NewsTrend::where('type', 'trends')->limit(4)->get();

        $newsTrend = NewsTrend::where('slug', $slug)->first();

        return view('frontend.pages.brandPage.content_details', compact(
            'newsTrend',
            'categories',
            'solutions',
            'news_trends'
        ));
    }
}
