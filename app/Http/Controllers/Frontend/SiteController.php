<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Admin\Brand;
use Illuminate\Support\Str;
use App\Models\Admin\Banner;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\Industry;
use App\Models\Admin\AboutPage;
use App\Models\Admin\NewsTrend;
use App\Http\Controllers\Controller;
use App\Models\Admin\SolutionDetail;
use Illuminate\Support\Facades\Session;

class SiteController extends Controller
{

    public function homePage()
    {
        $data = [
            'categories'    => Category::with('children.children.children.children.children.children.children.children.children.children')->where('is_parent', '1')->get(['id', 'parent_id', 'name', 'slug']),
            'products'      => Product::with('brand')->where('status', 'active')->inRandomOrder()->limit(5)->get(),
            // 'products'      => Product::with('brand')->where('product_status','product')->where('status','active')->inRandomOrder()->limit(5)->get(),
            'news_trends'   => NewsTrend::where('type', 'trends')->limit(4)->get(),
            'solutions'     => SolutionDetail::latest()->limit(4)->get(),
        ];
        return view('frontend.pages.home.index', $data);
    }
    public function solutionDetails($slug)
    {
        $data = [
            'solution'     => SolutionDetail::where('slug', $slug)->first(),
        ];
        return view('frontend.pages.solution.solution_details', $data);
    }
    public function category($slug)
    {
        $data = [
            'category'     => Category::with('children')->where('slug', $slug)->first(),
        ];
        return view('frontend.pages.category.category', $data);
    }
    public function filterProducts($slug)
    {
        $category = Category::where('slug', $slug)->first();

        // Check if category exists
        if (!$category) {
            Session::flash('warning', 'Category not found.');
            return redirect()->back();
        }

        // Get products associated with the category
        $products = $category->products()->get();

        // Check if there are products
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

    public function allCatalog()
    {
        $data = [
            'categories' => Category::with('children.children.children.children.children.children.children.children.children.children')->where('is_parent', '1')->get(['id', 'parent_id', 'name', 'slug']),
        ];
        return view('frontend.pages.catalog.allCatalog', $data);
    }

    public function rfq()
    {
        return view('frontend.pages.rfq.rfq');
    }
    public function contact()
    {
        $data = [
            'banner' => Banner::where('category','page')->where('page_name', 'contact_page')->first(),
        ];
        return view('frontend.pages.crm.contact',$data);
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

            $data['products'] = Product::join('brands', 'products.brand_id', '=', 'brands.id')
                ->where('products.name', 'LIKE', '%' . $query . '%')
                ->where('products.product_status', 'product')
                ->where('brands.status', 'active')
                ->limit(10)
                ->get(['products.id', 'products.name', 'products.slug', 'products.thumbnail', 'products.price', 'products.discount', 'products.sku_code', 'products.rfq', 'products.qty', 'products.stock']);

            $data['solutions'] = SolutionDetail::where('name', 'LIKE', '%' . $query . '%')
                // ->where('status', 'active')
                ->limit(5)
                ->get(['id', 'name', 'slug']);

            $data['industries'] = Industry::where('name', 'LIKE', '%' . $query . '%')
                ->limit(5)
                ->get(['id', 'name', 'slug']);

            $data['blogs'] = NewsTrend::where('title', 'LIKE', '%' . $query . '%')
                ->limit(5)
                ->get(['id', 'title']);

            $data['categorys'] = Category::where('title', 'LIKE', '%' . $query . '%')
                ->limit(2)
                ->get(['id', 'title', 'slug']);

            $data['subcategorys'] = SubCategory::where('title', 'LIKE', '%' . $query . '%')
                ->limit(2)
                ->get(['id', 'title', 'slug']);

            $data['subsubcategorys'] = SubSubCategory::where('title', 'LIKE', '%' . $query . '%')
                ->limit(1)
                ->get(['id', 'title', 'slug']);

            $data['brands'] = Brand::where('title', 'LIKE', '%' . $query . '%')
                ->where('status', 'active')
                ->limit(5)
                ->get(['id', 'title', 'slug']);

            $data['storys'] = ClientStory::where('title', 'LIKE', '%' . $query . '%')
                ->limit(5)
                ->get(['id', 'title', 'slug']);

            $data['tech_glossys'] = TechGlossy::where('title', 'LIKE', '%' . $query . '%')
                ->limit(5)
                ->get(['id', 'title']);

            return response()->json(view('frontend.partials.search', $data)->render());
        } catch (\Exception $e) {
            // Log the error for debugging
            return response()->json([
                'error' => 'Global search error: ' . $e->getMessage()
            ], 500);
        }
    }

    
}
