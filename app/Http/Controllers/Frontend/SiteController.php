<?php

namespace App\Http\Controllers\Frontend;

use Log;
use App\Models\PageBanner;
use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use App\Models\Admin\Catalog;
use App\Models\Admin\Company;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\HomePage;
use App\Models\Admin\Industry;
use App\Models\Admin\AboutPage;
use App\Models\Admin\NewsTrend;
use App\Models\Admin\TechGlossy;
use App\Models\Admin\ClientStory;
use App\Http\Controllers\Controller;
use App\Models\Admin\SolutionDetail;
use App\Models\Admin\SubSubCategory;
use App\Models\Admin\DynamicCategory;
use Illuminate\Support\Facades\Session;
use App\Repositories\Interfaces\FaqRepositoryInterface;
use App\Repositories\Interfaces\TermsAndPolicyRepositoryInterface;
use App\Repositories\Interfaces\DynamicCategoryRepositoryInterface;


class SiteController extends Controller
{
    /**
     * Home Page
     */
    //     public function homePage()
    //     {
    //         $banners = PageBanner::where('page_name', 'home')->get();
    // // dd($banner);
    //         $data = [
    //             'banners'        => $banners,
    //             'categories'    => Category::with('children.children.children.children.children.children.children.children.children.children')
    //                                 ->where('is_parent', '1')
    //                                 ->get(['id', 'parent_id', 'name', 'slug']),
    //             'products'      => Product::with('brand')
    //                                 ->where('status', 'active')
    //                                 ->inRandomOrder()
    //                                 ->limit(5)
    //                                 ->get(),
    //             'news_trends'   => NewsTrend::where('type', 'trends')->limit(4)->get(),
    //             'solutions'     => SolutionDetail::latest()->limit(4)->get(),
    //         ];

    //         return view('frontend.pages.home.index', $data);
    //     }


    public function homePage()
    {
        $banners = PageBanner::where('page_name', 'home')->get();

        // Get dynamic homepage data
        $homePage = HomePage::with(['country'])->first();

        // Get featured products for section two if homepage data exists
        $featuredProducts = collect();
        if ($homePage && $homePage->section_two_products) {
            $featuredProducts = Product::whereIn('id', $homePage->section_two_products)->get();
        }

        // Get news trends for section four if homepage data exists
        $sectionFourNews = collect();
        if ($homePage && $homePage->section_four_contents) {
            $sectionFourNews = NewsTrend::whereIn('id', $homePage->section_four_contents)->get();
        }

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
            // Add dynamic homepage data
            'homePage' => $homePage,
            'featuredProducts' => $featuredProducts,
            'sectionFourNews' => $sectionFourNews,
        ];

        return view('frontend.pages.home.index', $data);
    }

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
            ->whereHas('companies', function ($query) use ($companies) {
                $query->whereIn('companies.id', $companies);
            })
            ->where('status', true)
            ->get()
            ->map(function ($catalog) {
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
            Session::flash('error', 'Category not found.');
            return redirect()->back();
        }

        $categoryId = (string) $category->id;

        $products = Product::whereJsonContains('category_id', [$categoryId])
            ->orWhereRaw('JSON_UNQUOTE(category_id) LIKE ?', ['%"' . $categoryId . '"%'])
            ->paginate(16);

        //    dd($products);

        // if ($products->isEmpty()) {
        //     Session::flash('warning', 'No Products Found for this Category');
        //     return redirect()->back();
        // }

        $data = [
            'category' => $category,
            'products' => $products,
            'brands'   => Brand::latest()->get(),
        ];

        return view('frontend.pages.shop.filterProducts', $data);
    }
    private $termsAndPolicyRepository;
    private $faqRepository;
    private $dynamicCategoryRepository;

    public function __construct(
        TermsAndPolicyRepositoryInterface $termsAndPolicyRepository,
        FaqRepositoryInterface $faqRepository, 
        DynamicCategoryRepositoryInterface $dynamicCategoryRepository
    ) {
        $this->termsAndPolicyRepository = $termsAndPolicyRepository;
        $this->faqRepository = $faqRepository;
        $this->dynamicCategoryRepository = $dynamicCategoryRepository;
    }

    public function terms()
    {
        // Get active terms and policies, you might want to filter by company or other criteria
        $termsAndPolicies = $this->termsAndPolicyRepository->getActiveTermsAndPolicies();
        
        return view('frontend.pages.others.terms', compact('termsAndPolicies'));
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


    public function globalSearch(Request $request)
    {
        try {
            $query = $request->get('term', '');

            // Fetch products with brand
            $products = Product::with('brand')
                ->where('name', 'LIKE', '%' . $query . '%')
                ->where('product_status', 'product')
                ->limit(20) // You can paginate if needed
                ->get();

            // Collect category IDs from products (assuming category_id is array/json)
            $allCategoryIds = [];
            foreach ($products as $product) {
                if (is_array($product->category_id)) {
                    $allCategoryIds = array_merge($allCategoryIds, $product->category_id);
                } elseif (is_string($product->category_id)) {
                    $decoded = json_decode($product->category_id, true);
                    if (is_array($decoded)) {
                        $allCategoryIds = array_merge($allCategoryIds, $decoded);
                    }
                }
            }
            $allCategoryIds = array_unique($allCategoryIds);

            // Get only relevant categories
            $categories = Category::whereIn('id', $allCategoryIds)->get();

            $solutions = SolutionDetail::where('name', 'LIKE', '%' . $query . '%')->limit(5)->get();
            $news_trends = NewsTrend::where('type', 'trends')->limit(4)->get();

            // Pass all data to Blade
            return view('frontend.pages.search.index', compact(
                'products',
                'query',       
                'categories',
                'solutions',
                'news_trends'
            ));
        } catch (\Exception $e) {
            // Handle error
            return redirect()->back()->with('error', 'Search error: ' . $e->getMessage());
        }
    }

    public function ProductSearch(Request $request)
    {
        $searchTerm = $request->input('q');

        // Get products with brand and solutions
        $products = Product::with(['brand', 'solutions'])
            ->where('name', 'LIKE', '%' . $searchTerm . '%')
            ->where('status', 'active')
            ->paginate(12);

        // Collect dynamic categories

        $allCategoryIds = [];
        foreach ($products as $product) {
            if (is_array($product->category_id)) {
                $allCategoryIds = array_merge($allCategoryIds, $product->category_id);
            } elseif (is_string($product->category_id)) {
                $decoded = json_decode($product->category_id, true);
                if (is_array($decoded)) {
                    $allCategoryIds = array_merge($allCategoryIds, $decoded);
                }
            }
        }
        $categories = Category::whereIn('id', array_unique($allCategoryIds))
            ->get(['id', 'name', 'slug']);

        // Collect dynamic solutions

        $solutions = collect();
        foreach ($products as $product) {
            $solutions = $solutions->merge($product->solutions);
        }
        $solutions = $solutions->unique('id');

        // Collect dynamic news & trends by product IDs

        $productIds = $products->pluck('id')->toArray();
        $news_trends = NewsTrend::where('type', 'trends')
            ->whereIn('product_id', $productIds) 
            ->get();




            // Return to search view

        return view('frontend.pages.search.index', compact(
            'products',
            'searchTerm',
            'categories',
            'solutions',
            'news_trends'
        ));
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



    //addign search option brand 
    public function searchBrands(Request $request)
    { 
        $search = $request->input('search', '');
        try {
            // If search is empty, return all brands
            if (empty($search)) {
                // \Log::info('Loading ALL brands');
                $top_brands = Brand::byCategory('Top')->latest()->paginate(18, ['*'], 'top_page');
                $featured_brands = Brand::byCategory('Featured')->latest()->paginate(18, ['*'], 'featured_page');
            } else {
                // \Log::info('Searching brands with term: "' . $search . '"');
                $top_brands = Brand::where('title', 'like', "%{$search}%")
                    ->byCategory('Top')
                    ->latest()
                    ->paginate(18, ['*'], 'top_page');

                $featured_brands = Brand::where('title', 'like', "%{$search}%")
                    ->byCategory('Featured')
                    ->latest()
                    ->paginate(18, ['*'], 'featured_page');
            }
            // Return the partial view
            return view('frontend.pages.brand.partials.brand_list_content', compact('top_brands', 'featured_brands'));
        } catch (\Exception $e) {
            
            // Return error response
            return response('<div class="text-center alert alert-danger">Error: ' . $e->getMessage() . '</div>');
        }
    }

    // All FAQs
    public function faq()
    {
        return view('frontend.pages.others.faq', [
            'faqs' => $this->faqRepository->allFaq(),
            'categories' => $this->dynamicCategoryRepository->allDynamicActiveCategory('faqs'),
        ]);
    }

    // Search FAQs
    public function faqSearch(Request $request)
    {
        $query = $request->get('q');

        $faqs = $this->faqRepository->searchFaq($query);
        $categories = $this->dynamicCategoryRepository->allDynamicActiveCategory('faqs');

        return view('frontend.pages.others.faq', [
            'faqs' => $faqs,
            'categories' => $categories,
            'searchQuery' => $query,
        ]);
    }

    // Filter by category
    public function faqByCategory($slug)
    {
        $category = \App\Models\Admin\DynamicCategory::where('slug', $slug)->firstOrFail();

        // now faqs() relationship works
        $faqs = $category->faqs()->orderBy('order')->get();

        $categories = $this->dynamicCategoryRepository->allDynamicActiveCategory('faqs');

        return view('frontend.pages.others.faq', compact('category', 'faqs', 'categories'));
    }

    public function solutionTest()
    {
        return view('frontend.pages.test.solutionTest');
    }
}


