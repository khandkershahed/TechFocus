<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Brand;
use Illuminate\Http\Request;
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
            // Toastr::error('No Details information found for this Brand.');
            return redirect()->back()->with('warning', 'No Details information found for this Brand');
        }
    }

    public function brandProducts($slug, Request $request)
    {
        $data = [
            'brand' => Brand::with('brandPage', 'brandProducts', 'products')->where('slug', $slug)->select('id', 'slug', 'title', 'logo')->firstOrFail(),
            // 'brandProducts' => Brand::with('brandProducts')->where('slug', $slug)->select('id', 'slug', 'title', 'logo')->firstOrFail(),
        ];
        return view('frontend.pages.brandPage.products', $data);



        // $data['brandpage'] = BrandPage::where('brand_id', $data['brand']->id)->first(['id', 'banner_image', 'brand_logo', 'header']);

        // if (!empty($data['brandpage'])) {

        //     $productIds = Product::where('brand_id', $data['brand']->id)
        //         ->where('product_status', '=', 'product')
        //         ->distinct()
        //         ->pluck('id');
        //     // $productIds = $data['products']->pluck('id')->all(); // Extracting product IDs
        //     $data['products'] = Product::whereIn('id', $productIds)
        //         ->select('id', 'brand_id', 'rfq', 'slug', 'name', 'thumbnail', 'price', 'discount', 'price_status', 'cat_id', 'sku_code', 'mf_code', 'product_code')
        //         ->paginate(10);
        //     // dd($data['products']);
        //     $industryIds = MultiIndustry::whereIn('product_id', $productIds)
        //         ->pluck('industry_id')
        //         ->unique();

        //     $data['industries'] = Industry::whereIn('id', $industryIds)->get();
        //     foreach ($data['industries'] as $industry) {
        //         // Fetch product IDs for the current industry
        //         $productIdsForIndustry = MultiIndustry::where('industry_id', $industry->id)
        //             ->whereIn('product_id', $productIds)
        //             ->pluck('product_id')
        //             ->toArray();

        //         // Filter products collection for the current industry
        //         $productsForIndustry = $data['products']->whereIn('id', $productIdsForIndustry)->all();

        //         // Assign the products to the industry
        //         $industry->products = $productsForIndustry;
        //     }

        //     $solutionIds = MultiSolution::whereIn('product_id', $productIds)
        //         ->pluck('solution_id')
        //         ->unique();

        //     $data['solutions'] = SolutionDetail::whereIn('id', $solutionIds)->get();
        //     foreach ($data['solutions'] as $solution) {
        //         // Fetch product IDs for the current industry
        //         $productIdsForSolution = MultiSolution::where('solution_id', $solution->id)
        //             ->whereIn('product_id', $productIds)
        //             ->pluck('product_id')
        //             ->toArray();

        //         // Filter products collection for the current industry
        //         $productsForSolution = $data['products']->whereIn('id', $productIdsForSolution)->all();

        //         // Assign the products to the industry
        //         $solution->products = $productsForSolution;
        //     }

        //     $data['related_search'] = [
        //         'categories' =>  Category::inRandomOrder()->limit(2)->get(),
        //         'brands' =>  Brand::inRandomOrder()->limit(4)->get(),
        //         'solutions' =>  SolutionDetail::inRandomOrder()->limit(4)->get('id', 'slug', 'name'),
        //         'industries' =>  Industry::inRandomOrder()->limit(4)->get('id', 'slug', 'title'),
        //     ];
        //     // dd($data['related_search']['categories']);

        //     if ($request->ajax()) {
        //         return view('frontend.pages.kukapages.partial.product_pagination', $data);
        //     }

        //     // dd($data['industry_ids']);
        //     return view('frontend.pages.kukapages.products', $data);
        // } else {
        //     Toastr::error('No Details information found for this Brand.');
        //     return redirect()->back();
        // }
    }
    public function productDetails($id, $slug, Request $request)
    {
        $data = [
            'product' => Product::with('multiImages')->where('slug', $slug)->first(),
            'brand' => Brand::with('brandPage')->where('slug', $id)->select('id', 'slug', 'title', 'logo')->first(),
        ];
        // Check if this is a redirect from RFQ process
        if (request()->has('rfq_redirect') && request('rfq_redirect') == 'success') {
            Session::flash('success', 'Product added to RFQ successfully!');
            // Toastr::success('Product added to RFQ successfully!');
        }
        // dd($data);

        return view('frontend.pages.product.product_details', $data);
    }
    // public function productDetails($id, $slug)
    // {
    //     $data = [
    //         'product' => Product::with('multiImages')->where('slug', $slug)->firstOrFail(),
    //         'brand' => Brand::with('brandPage')->where('slug', $id)->select('id', 'slug', 'title', 'logo')->firstOrFail(),
    //     ];
    //     return view('frontend.pages.product.product_details',$data);
    //     // $data['sproduct'] = Product::where('slug', $id)->where('product_status', 'product')->first();
    //     // if (!empty($data['sproduct']->cat_id)) {
    //     //     $data['products'] = Product::where('cat_id', $data['sproduct']->cat_id)
    //     //         ->where('product_status', 'product')
    //     //         ->select('id', 'rfq', 'slug', 'name', 'thumbnail', 'price', 'discount', 'sku_code', 'mf_code', 'product_code', 'cat_id', 'brand_id')
    //     //         ->limit(12)
    //     //         ->distinct()
    //     //         ->get();
    //     // } else {
    //     //     $data['products'] = Product::inRandomOrder()->where('product_status', 'product')->limit(12)->get();
    //     // }

    //     // $data['brand'] = Brand::where('id', $data['sproduct']->brand_id)->select('id', 'slug', 'title', 'image')->first();
    //     // $data['brandpage'] = BrandPage::where('brand_id', $data['brand']->id)->first(['id', 'banner_image', 'brand_logo', 'header']);
    //     // $data['related_search'] = [
    //     //     'categories' =>  Category::where('id', '!=', $data['sproduct']->cat_id)->inRandomOrder()->limit(2)->get(),
    //     //     'brands' =>  Brand::where('id', '!=', $data['sproduct']->brand_id)->inRandomOrder()->limit(20)->get(),
    //     //     'solutions' =>  SolutionDetail::inRandomOrder()->limit(4)->get('id', 'slug', 'name'),
    //     //     'industries' =>  Industry::inRandomOrder()->limit(4)->get('id', 'slug', 'title'),
    //     // ];
    //     // $data['brand_products'] = Product::where('brand_id', $data['sproduct']->brand_id)->where('id', '!=', $data['sproduct']->id)->inRandomOrder()->where('product_status', 'product')->limit(20)->get();

    //     // $data['documents'] = DocumentPdf::where('product_id', $data['sproduct']->id)->get();

    //     // if (!empty($data['brandpage'])) {
    //     //     return view('frontend.pages.kukapages.product_details', $data);
    //     // } else {
    //     //     return view('frontend.pages.product.product_details', $data);
    //     // }
    // }

    public function brandPdf($slug)
    {
        $data = [
            'brand' => Brand::with('brandPage')->where('slug', $slug)->select('id', 'slug', 'title', 'logo')->firstOrFail(),
        ];
        return view('frontend.pages.brandPage.catalogs', $data);
        // $data['brand'] = Brand::where('slug', $id)->select('id', 'slug', 'title', 'image')->firstOrFail();
        // $data['brandpage'] = BrandPage::where('brand_id', $data['brand']->id)->firstOrFail(['id', 'banner_image', 'brand_logo', 'header']);

        // $brandId = $data['brand']->id;
        // $data['brand_documents'] = DocumentPdf::where('brand_id', $brandId)->get();
        // $data['product_documents'] = DocumentPdf::join('products', 'document_pdfs.product_id', '=', 'products.id')
        //     ->where('products.brand_id', '=', $brandId)
        //     ->select('document_pdfs.id', 'document_pdfs.title', 'document_pdfs.document')
        //     ->distinct()
        //     ->paginate(18);
        // $mergedData = $data['brand_documents']->concat($data['product_documents']);
        // // Convert the merged data to an array
        // $data['documents'] = $mergedData->toArray();

        // $data['related_search'] = [
        //     'categories' =>  Category::inRandomOrder()->limit(2)->get(),
        //     'brands' =>  Brand::inRandomOrder()->limit(4)->get(),
        //     'solutions' =>  SolutionDetail::inRandomOrder()->limit(4)->get('id', 'slug', 'name'),
        //     'industries' =>  Industry::inRandomOrder()->limit(4)->get('id', 'slug', 'title'),
        // ];
        // return view('frontend.pages.kukapages.catalogs', $data);
    }

    public function pdfDetails($slug)
    {
        $data = [
            'brand' => Brand::with('brandPage')->where('slug', $slug)->select('id', 'slug', 'title', 'logo')->firstOrFail(),
        ];
        return view('frontend.pages.brandPage.pdf_details', $data);
        // $data['brand'] = Brand::where('slug', $id)->select('id', 'slug', 'title', 'image')->firstOrFail();
        // $data['brandpage'] = BrandPage::where('brand_id', $data['brand']->id)->firstOrFail(['id', 'banner_image', 'brand_logo', 'header']);

        // $brandId = $data['brand']->id;
        // $data['brand_documents'] = DocumentPdf::where('brand_id', $brandId)->get();
        // $data['product_documents'] = DocumentPdf::join('products', 'document_pdfs.product_id', '=', 'products.id')
        //     ->where('products.brand_id', '=', $brandId)
        //     ->select('document_pdfs.id', 'document_pdfs.title', 'document_pdfs.document')
        //     ->distinct()
        //     ->paginate(18);
        // $mergedData = $data['brand_documents']->concat($data['product_documents']);
        // // Convert the merged data to an array
        // $data['documents'] = $mergedData->toArray();

        // $data['related_search'] = [
        //     'categories' =>  Category::inRandomOrder()->limit(2)->get(),
        //     'brands' =>  Brand::inRandomOrder()->limit(4)->get(),
        //     'solutions' =>  SolutionDetail::inRandomOrder()->limit(4)->get('id', 'slug', 'name'),
        //     'industries' =>  Industry::inRandomOrder()->limit(4)->get('id', 'slug', 'title'),
        // ];
        // return view('frontend.pages.kukapages.catalogs', $data);
    }

    public function content($slug)
    {
        $brand = Brand::with('brandPage')
            ->where('slug', $slug)
            ->select('id', 'slug', 'title', 'logo')
            ->firstOrFail();

        // Fetch trends for this brand
        $trends = NewsTrend::forBrand($brand->id)
            ->orderByDesc('featured')    // featured first
            ->orderByDesc('created_at')  // newest first
            ->paginate(12);

        // Pass both brand and trends to view
        return view('frontend.pages.brandPage.contents', compact('brand', 'trends'));
        // $data['brand'] = Brand::where('slug', $id)->select('id', 'slug', 'title', 'image')->first();
        // $data['brandpage'] = BrandPage::where('brand_id', $data['brand']->id)->first(['id', 'banner_image', 'brand_logo', 'header']);
        // $id = json_encode($data['brand']->id);
        // $data['techglossys'] = TechGlossy::whereJsonContains('brand_id', $id)->get();
        // $data['blogs'] = Blog::whereJsonContains('brand_id', $id)->get();
        // $data['clientStories'] = ClientStory::whereJsonContains('brand_id', $id)->get();

        // $mergedData = $data['blogs']->concat($data['clientStories']);

        // $data['contents'] = $mergedData->toArray();


        // $data['related_search'] = [
        //     'categories' =>  Category::inRandomOrder()->limit(2)->get(),
        //     'brands' =>  Brand::inRandomOrder()->limit(4)->get(),
        //     'solutions' =>  SolutionDetail::inRandomOrder()->limit(4)->get('id', 'slug', 'name'),
        //     'industries' =>  Industry::inRandomOrder()->limit(4)->get('id', 'slug', 'title'),
        // ];
        // return view('frontend.pages.kukapages.contents', $data);
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
            'brand' => Brand::with('brandPage')->where('slug', $slug)->select('id', 'slug', 'title', 'logo')->firstOrFail(),
        ];
        return view('frontend.pages.brandPage.content_details', $data);
    }
}
