<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\PageBanner;
use App\Models\Admin\Product;
use App\Models\Admin\Brand;
use App\Models\Admin\Category;
use App\Models\Admin\Industry;
use App\Models\Admin\AboutPage;
use App\Models\Admin\NewsTrend;
use App\Models\Admin\Catalog;
use App\Models\Admin\SolutionDetail;
use App\Models\Admin\SubSubCategory;
use App\Models\Admin\ClientStory;
use App\Models\Admin\TechGlossy;

class SiteController extends Controller
{
    /**
     * Home Page
     */
    public function homePage()
    {
        $banners = PageBanner::where('page_name', 'home')->get();
// dd($banner);
        $data = [
            'banners'        => $banners,
            'categories'    => Category::with('children.children.children.children.children.children.children.children.children.children')
                                ->where('is_parent', '1')
                                ->get(['id', 'parent_id', 'name', 'slug']),
            'products'      => Product::with('brand')
                                ->where('status', 'active')
                                ->inRandomOrder()
                                ->limit(5)
                                ->get(),
            'news_trends'   => NewsTrend::where('type', 'trends')->limit(4)->get(),
            'solutions'     => SolutionDetail::latest()->limit(4)->get(),
        ];

        return view('frontend.pages.home.index', $data);
    }

    /**
     * All Catalog Page
     */
    // public function allCatalog()
    // {
    //     $banners = PageBanner::where('page_name', 'catalog')->get();

    //     $categories = Category::with([
    //         'children.children.children.children',
    //         'catalogs.attachments'
    //     ])
    //     ->where('is_parent', 1)
    //     ->get(['id', 'parent_id', 'name', 'slug']);

    //     $allCatalogs = Catalog::with('attachments')->get();

    //     return view('frontend.pages.catalog.allCatalog', compact('categories', 'allCatalogs', 'banners'));
    // }

    /**
 * All Catalog Page - SAFE VERSION
 */
public function allCatalog()
{
    $banners = PageBanner::where('page_name', 'catalog')->get();

    // Get all unique catalog categories (brand, product, industry, solution, company)
    $catalogCategories = Catalog::distinct()->pluck('category');
    
    // Get all catalogs for the "All" tab with relationships
    $allCatalogs = Catalog::with(['attachments'])
        ->latest()
        ->get();

    // Get catalogs grouped by category
    $catalogsByCategory = [];
    foreach ($catalogCategories as $category) {
        $catalogsByCategory[$category] = Catalog::with(['attachments'])
            ->where('category', $category)
            ->latest()
            ->get();
    }

    return view('frontend.pages.catalog.allCatalog', compact(
        'catalogCategories',
        'allCatalogs',
        'catalogsByCategory',
        'banners'
    ));
}

    /**
     * Catalog Details Page
     */
public function catalogDetails($slug)
{
    try {
        $catalog = Catalog::with(['attachments', 'brands', 'products', 'industries', 'companies'])
            ->where('slug', $slug)
            ->first();

        if (!$catalog) {
            abort(404, 'Catalog not found');
        }

        $banners = PageBanner::where('page_name', 'catalog')->get();

        return view('frontend.pages.catalog.details', compact('catalog', 'banners'));
        
    } catch (\Exception $e) {
        abort(404, 'Catalog not found');
    }
}

    /**
     * Get Company Catalogs by Letter (AJAX)
     */
    public function getCompanyCatalogs($letter)
    {
        if ($letter === '0-9') {
            // Get companies starting with numbers
            $companies = Company::where('name', 'REGEXP', '^[0-9]')
                ->where('status', true)
                ->pluck('id');
        } else {
            // Get companies starting with specific letter
            $companies = Company::where('name', 'LIKE', $letter . '%')
                ->where('status', true)
                ->pluck('id');
        }

        $catalogs = Catalog::with(['companies'])
            ->whereHas('companies', function($query) use ($companies) {
                $query->whereIn('companies.id', $companies);
            })
            ->where('status', true)
            ->get()
            ->map(function($catalog) {
                return [
                    'id' => $catalog->id,
                    'name' => $catalog->name,
                    'slug' => $catalog->slug,
                    'thumbnail' => $catalog->thumbnail,
                    'page_number' => $catalog->page_number,
                    'category' => $catalog->category,
                ];
            });

        return response()->json([
            'catalogs' => $catalogs
        ]);
    }



    /**
     * RFQ Page
     */
      public function rfq()
    {
        $banners = PageBanner::where('page_name', 'rfq')->get();
        return view('frontend.pages.rfq.rfq', compact('banners'));
    }

    /**
     * Contact Page
     */
      public function contact()
    {
        $banners = PageBanner::where('page_name', 'contact')->get();
        return view('frontend.pages.crm.contact', compact('banners'));
    }



    /**
     * Other Pages (Unchanged)
     */
    public function solutionDetails($slug)
    {
        $data = [
            'solution' => SolutionDetail::where('slug', $slug)->first(),
        ];
        return view('frontend.pages.solution.solution_details', $data);
    }

    public function category($slug)
    {
        $data = [
            'category' => Category::with('children')->where('slug', $slug)->first(),
        ];
        return view('frontend.pages.category.category', $data);
    }

    public function filterProducts($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            Session::flash('warning', 'Category not found.');
            return redirect()->back();
        }

        $products = $category->products()->get();

        if ($products->isEmpty()) {
            Session::flash('warning', 'No Products Found for this Category');
            return redirect()->back();
        }

        $data = [
            'category' => $category,
            'products' => $products,
            'brands'   => Brand::latest()->get(),
        ];

        return view('frontend.pages.shop.filterProducts', $data);
    }

    public function faq()
    {
        return view('frontend.pages.others.faq');
    }

    public function terms()
    {
        return view('frontend.pages.others.terms');
    }

    public function about()
    {
        $aboutPage = AboutPage::whereStatus('active')->first();

        if (!empty($aboutPage)) {
            $brandIds = $aboutPage ? json_decode($aboutPage->brand_id, true) : [];
            $brands = $brandIds ? Brand::whereIn('id', $brandIds)->get() : collect();

            return view('frontend.pages.about.about', [
                'aboutPage' => $aboutPage,
                'brands' => $brands,
            ]);
        } else {
            Session::flash('warning', 'The Page is now in Construction Mode. Please Try again later.');
            return redirect()->back();
        }
    }

    public function subscription()
    {
        return view('frontend.pages.others.subscription');
    }

    public function brandList()
    {
        $paginationSettings = ['*'];

        $data = [
            'top_brands' => Brand::byCategory('Top')->latest('id')->paginate(18, $paginationSettings, 'top_brands'),
            'featured_brands' => Brand::byCategory('Featured')->latest('id')->paginate(18, $paginationSettings, 'featured_brands'),
            'others' => Brand::with('brandPage')->select('id', 'slug', 'title')->get(),
        ];

        return view('frontend.pages.brand.brand_list', $data);
    }

    public function service()
    {
        return view('frontend.pages.service.service');
    }

    public function sourcingGuide()
    {
        return view('frontend.pages.guide.sourcing_guide');
    }

    public function buyingGuide()
    {
        return view('frontend.pages.guide.buying_guide');
    }

    public function exhibit()
    {
        return view('frontend.pages.others.exhibit');
    }

    public function manufacturerAccount()
    {
        return view('frontend.pages.manufacturer.account');
    }

    /**
     * Search functions remain unchanged
     */
    public function globalSearch(Request $request)
    {
        try {
            $query = $request->get('term', '');

            $data['products'] = Product::join('brands', 'products.brand_id', '=', 'brands.id')
                ->where('products.name', 'LIKE', '%' . $query . '%')
                ->where('products.product_status', 'product')
                ->where('brands.status', 'active')
                ->limit(10)
                ->get(['products.id', 'products.name', 'products.slug', 'products.thumbnail', 'products.price', 'products.discount', 'products.sku_code', 'products.rfq', 'products.qty', 'products.stock']);

            $data['solutions'] = SolutionDetail::where('name', 'LIKE', '%' . $query . '%')->limit(5)->get(['id', 'name', 'slug']);
            $data['industries'] = Industry::where('name', 'LIKE', '%' . $query . '%')->limit(5)->get(['id', 'name', 'slug']);
            $data['blogs'] = NewsTrend::where('title', 'LIKE', '%' . $query . '%')->limit(5)->get(['id', 'title']);
            $data['categorys'] = Category::where('title', 'LIKE', '%' . $query . '%')->limit(2)->get(['id', 'title', 'slug']);
            $data['subcategorys'] = Category::where('title', 'LIKE', '%' . $query . '%')->limit(2)->get(['id', 'title', 'slug']);
            $data['subsubcategorys'] = SubSubCategory::where('title', 'LIKE', '%' . $query . '%')->limit(1)->get(['id', 'title', 'slug']);
            $data['brands'] = Brand::where('title', 'LIKE', '%' . $query . '%')->where('status', 'active')->limit(5)->get(['id', 'title', 'slug']);
            $data['storys'] = ClientStory::where('title', 'LIKE', '%' . $query . '%')->limit(5)->get(['id', 'title', 'slug']);
            $data['tech_glossys'] = TechGlossy::where('title', 'LIKE', '%' . $query . '%')->limit(5)->get(['id', 'title']);

            return response()->json(view('frontend.partials.search', $data)->render());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Global search error: ' . $e->getMessage()], 500);
        }
    }

    public function ProductSearch(Request $request)
    {
        $searchTerm = $request->input('q');

        $products = Product::with('brand')
            ->where('name', 'LIKE', '%' . $searchTerm . '%')
            ->where('status', 'active')
            ->paginate(12);

        $categories = Category::with('children.children.children.children.children.children.children.children.children.children')
            ->where('is_parent', '1')
            ->get(['id', 'parent_id', 'name', 'slug']);

        $solutions = SolutionDetail::latest()->limit(4)->get();
        $news_trends = NewsTrend::where('type', 'trends')->limit(4)->get();

        return view('frontend.pages.search.index', compact('products', 'searchTerm', 'categories', 'solutions', 'news_trends'));
    }

    public function show($slug)
    {
        $product = Product::with('brand')->where('slug', $slug)->first();

        if (!$product) {
            abort(404, 'Product not found');
        }

        $categories = Category::with('children')->where('is_parent', 1)->get();
        $solutions = SolutionDetail::latest()->limit(4)->get();
        $news_trends = NewsTrend::where('type', 'trends')->limit(4)->get();

        return view('frontend.pages.product.show', compact('product', 'categories', 'solutions', 'news_trends'));
    }

    public function newsDetails($slug)
    {
        $news = NewsTrend::where('slug', $slug)->firstOrFail();

        $categories = Category::with('children')->where('is_parent', 1)->get();
        $solutions = SolutionDetail::latest()->limit(4)->get();
        $news_trends = NewsTrend::where('type', 'trends')->limit(4)->get();

        return view('frontend.pages.news.details', compact('news', 'categories', 'solutions', 'news_trends'));
    }
    


public function showBySlugOrId($slugOrId)
{
    $catalog = Catalog::where('slug', $slugOrId)->first();

    if (!$catalog && is_numeric($slugOrId)) {
        $catalog = Catalog::find($slugOrId);
    }

    if (!$catalog) {
        abort(404, 'Catalog not found');
    }

    return view('frontend.pages.catalog.details', compact('catalog'));
}

}
