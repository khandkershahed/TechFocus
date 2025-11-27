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
   
    // public function brandPdf($slug)
    // {
    //     $data = [
    //         'brand' => Brand::with('brandPage')->where('slug', $slug)->select('id', 'slug', 'title', 'logo')->firstOrFail(),
    //     ];
    //     return view('frontend.pages.brandPage.catalogs', $data);
     
    // }
public function brandPdf($slug)
{
    $brand = Brand::with('brandPage')
        ->where('slug', $slug)
        ->select('id', 'slug', 'title', 'logo')
        ->firstOrFail();

    // Since your data stores brand IDs as strings in JSON arrays: ["10"]
    // We need to search for the brand ID as a string
    $brandCatalogs = Catalog::with(['attachments'])
        ->whereJsonContains('brand_id', (string)$brand->id)
        ->latest()
        ->get();

    \Log::info("Brand: {$brand->title} (ID: {$brand->id})");
    \Log::info("Catalogs found: " . $brandCatalogs->count());

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
        $trends = NewsTrend::whereJsonContains('brand_id', (string)$brand->id)->latest()->paginate(12);;
        // $trends = NewsTrend::forBrand($brand->id)
        //     ->orderByDesc('featured')    // featured first
        //     ->orderByDesc('created_at')  // newest first
        //     ->paginate(12);
        // dd($trends);
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
        ];
        return view('frontend.pages.brandPage.content_details', $data);
    }
}
