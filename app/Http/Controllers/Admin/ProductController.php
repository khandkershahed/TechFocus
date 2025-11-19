<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Admin\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\Industry;
use App\Models\Admin\ProductImage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\IndustryProduct;
use App\Models\Admin\SolutionProduct;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Support\Facades\Notification;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['products'] = Product::with('productSas')->where('product_status', 'product')->latest('id', 'desc')
            ->get(['id', 'slug', 'thumbnail', 'price', 'name', 'stock', 'action_status', 'price_status', 'added_by']);
        return view('admin.pages.product.completed_products', $data);
    }
    
    public function savedProducts()
    {
        $data['saved_products'] = Product::with('productSas')->where('product_status', 'sourcing')->where('action_status', 'save')->latest('id', 'desc')
            ->get(['id', 'slug', 'thumbnail', 'price', 'discount', 'name', 'stock', 'source_one_price', 'source_two_price', 'action_status', 'price_status', 'added_by']);
        return view('admin.pages.product.saved_products', $data);
    }
    
    public function sourcedProducts()
    {
        $data['products'] = Product::with('productSas')->where('product_status', 'sourcing')->where('action_status', '!=', 'save')->select('id', 'name', 'slug', 'thumbnail', 'price_status', 'action_status', 'added_by')->get();
        return view('admin.pages.product.sourced_products', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'products'   => DB::table('products')->select('id', 'name')->get(),
            'brands'     => DB::table('brands')->select('id', 'title')->orderBy('id', 'desc')->get(),
            'currencys'  => DB::table('currencies')->select('id', 'name')->orderBy('id', 'desc')->get(),
            'colors'     => DB::table('product_colors')->select('id', 'color_code', 'name')->orderBy('id', 'desc')->get(),
            'categories' => Category::with('children.children.children.children.children.children')->latest('id')->get(),
            'industries' => DB::table('industries')->select('id', 'name')->orderBy('id', 'desc')->get(),
            'solutions'  => DB::table('solution_details')->select('id', 'name')->orderBy('id', 'desc')->get(),
        ];
        return view('admin.pages.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
// public function store(ProductRequest $request)
// {
//     // Add debug logging
//     \Log::info('Product store method called');
//     \Log::info('Request data:', $request->all());
    
//     $validator = Validator::make(
//         $request->all(),
//         [
//             'name'       => 'required|unique:products,name|max:200',
//             'thumbnail'  => 'required|image|mimes:png,jpg,jpeg|max:5000',
//             'mf_code'    => 'nullable|unique:products,mf_code',
//             'color_id'   => 'nullable|array',
//             'color_id.*' => 'nullable|exists:product_colors,id',
//             'category_id' => 'nullable|array',
//             'category_id.*' => 'nullable|exists:categories,id',
//             'parent_id' => 'nullable|array',
//             'parent_id.*' => 'nullable|exists:products,id',
//             'child_id' => 'nullable|array',
//             'child_id.*' => 'nullable|exists:products,id',
//         ],
//         [
//             'thumbnail.max'   => 'The image field must be smaller than 5 MB.',
//             'thumbnail.image' => 'The file must be an image.',
//             'thumbnail.mimes' => 'The :attribute must be a file of type: PNG, JPEG, JPG.',
//             'required'        => 'The :attribute field is required.',
//             'unique'          => 'The :attribute already exists in the database.',
//         ]
//     );

//     if ($validator->fails()) {
//         \Log::error('Validation failed:', $validator->errors()->toArray());
//         return redirect()->back()->withErrors($validator)->withInput();
//     }
    
//     DB::beginTransaction();

//     try {
//         \Log::info('Starting product creation...');
        
//         $thumbnail = $request->file('thumbnail');
//         $thumbnailName = Str::random(20) . '.' . $thumbnail->getClientOriginalExtension();
//         $thumbnailPath = $thumbnail->storeAs('upload/Products/thumbnail', $thumbnailName, 'public');
//         $save_url = asset('storage/' . $thumbnailPath);

//         \Log::info('Thumbnail saved:', ['url' => $save_url]);

//         $productData = [
//             'name'                      => $request->name,
//             'sku_code'                  => $request->sku_code,
//             'mf_code'                   => $request->mf_code ?? null,
//             'product_code'              => $request->product_code ?? null,
//             'tags'                      => $request->tags ?? null,
//             'price_status'              => $request->price_status,
//             'sas_price'                 => $request->sas_price ?? null,
//             'short_desc'                => $request->short_desc ?? null,
//             'overview'                  => $request->overview ?? null,
//             'specification'             => $request->specification ?? null,
//             'accessories'               => $request->accessories ?? null,
//             'warranty'                  => $request->warranty ?? null,
//             'thumbnail'                 => $save_url,
//             'stock'                     => $request->stock,
//             'currency_id'               => $request->currency_id ?? null,
//             'qty'                       => $request->qty ?? 0,
//             'rfq'                       => ($request->price_status == 'rfq') ? '1' : '0',
//             'deal'                      => $request->deal ?? null,
//             'refurbished'               => $request->refurbished ?? 0,
//             'product_type'              => $request->product_type,
//             'category_id'               => $request->has('category_id') ? json_encode($request->category_id) : null,
//             'color_id'                  => $request->has('color_id') ? json_encode($request->color_id) : null,
//             'parent_id'                 => $request->has('parent_id') ? json_encode($request->parent_id) : null,
//             'child_id'                  => $request->has('child_id') ? json_encode($request->child_id) : null,
//             'brand_id'                  => $request->brand_id,
//             'source_one_name'           => $request->source_one_name ?? null,
//             'source_one_link'           => $request->source_one_link ?? null,
//             'source_one_price'          => $request->source_one_price ?? null,
//             'source_one_estimate_time'  => $request->source_one_estimate_time ?? null,
//             'source_one_principal_time' => $request->source_one_principal_time ?? null,
//             'source_one_shipping_time'  => $request->source_one_shipping_time ?? null,
//             'source_one_location'       => $request->source_one_location ?? null,
//             'source_one_country'        => $request->source_one_country ?? null,
//             'source_two_name'           => $request->source_two_name ?? null,
//             'source_two_link'           => $request->source_two_link ?? null,
//             'source_two_price'          => $request->source_two_price ?? null,
//             'source_two_estimate_time'  => $request->source_two_estimate_time ?? null,
//             'source_two_principal_time' => $request->source_two_principal_time ?? null,
//             'source_two_shipping_time'  => $request->source_two_shipping_time ?? null,
//             'source_two_location'       => $request->source_two_location ?? null,
//             'source_two_country'        => $request->source_two_country ?? null,
//             'competitor_one_name'       => $request->competitor_one_name ?? null,
//             'competitor_one_price'      => $request->competitor_one_price ?? null,
//             'competitor_two_name'       => $request->competitor_two_name ?? null,
//             'competitor_two_price'      => $request->competitor_two_price ?? null,
//             'competitor_one_link'       => $request->competitor_one_link ?? null,
//             'competitor_two_link'       => $request->competitor_two_link ?? null,
//             'source_one_approval'       => ($request->source_one_price > $request->source_two_price) ? '0' : '1',
//             'source_two_approval'       => ($request->source_one_price > $request->source_two_price) ? '1' : '0',
//             'notification_days'         => $request->notification_days,
//             'create_date'               => Carbon::now(),
//             'solid_source'              => $request->solid_source ?? 'no',
//             'direct_principal'          => $request->direct_principal ?? 'no',
//             'agreement'                 => $request->agreement ?? 'no',
//             'source_type'               => $request->source_type ?? null,
//             'source_contact'            => $request->source_contact ?? null,
//             'added_by'                  => Auth::guard('admin')->user()->name,
//             'action_status'             => ($request->action == 'save') ? 'save' : 'listed',
//             'product_status'            => 'sourcing',
//             'created_at'                => Carbon::now(),
//         ];

//         \Log::info('Product data prepared:', $productData);

//         $product = Product::create($productData);
//         \Log::info('Product created with ID:', ['id' => $product->id]);

//         // Multiple Image Upload
//         if ($request->hasFile('multi_img')) {
//             \Log::info('Processing multiple images...');
//             foreach ($request->file('multi_img') as $img) {
//                 $makeName = Str::random(20) . '.' . $img->getClientOriginalExtension();
//                 $multiPath = $img->storeAs('upload/Products/multi-image', $makeName, 'public');

//                 ProductImage::create([
//                     'product_id' => $product->id,
//                     'photo'      => asset('storage/' . $multiPath),
//                 ]);
//             }
//         }

//         // Attach industries
//         if (!empty($request->industry_id)) {
//             \Log::info('Attaching industries...');
//             foreach ($request->industry_id as $industry) {
//                 IndustryProduct::create([
//                     'product_id' => $product->id,
//                     'industry_id' => $industry,
//                 ]);
//             }
//         }

//         // Attach solutions
//         if (!empty($request->solution_id)) {
//             \Log::info('Attaching solutions...');
//             foreach ($request->solution_id as $solution) {
//                 SolutionProduct::create([
//                     'product_id' => $product->id,
//                     'solution_id' => $solution,
//                 ]);
//             }
//         }

//         DB::commit();
//         \Log::info('Product stored successfully!');
//         Session::flash('success', 'Data has been inserted successfully!');
//         return redirect()->back();
        
//     } catch (\Exception $e) {
//         DB::rollback();
//         \Log::error('Error storing product:', [
//             'message' => $e->getMessage(),
//             'file' => $e->getFile(),
//             'line' => $e->getLine(),
//             'trace' => $e->getTraceAsString()
//         ]);
//         return redirect()->back()->withInput()->with('error', $e->getMessage());
//     }
// }
public function store(ProductRequest $request)
{
    \Log::info('Product store method called');
    \Log::info('Request data:', $request->all());
    
    $validator = Validator::make(
        $request->all(),
        [
            'name'       => 'required|unique:products,name|max:200',
            'thumbnail'  => 'required|image|mimes:png,jpg,jpeg|max:5000',
            'mf_code'    => 'nullable|unique:products,mf_code',
            'color_id'   => 'nullable|array',
            'color_id.*' => 'nullable|exists:product_colors,id',
            'category_id' => 'nullable|array',
            'category_id.*' => 'nullable|exists:categories,id',
            'parent_id' => 'nullable|array',
            'parent_id.*' => 'nullable|exists:products,id',
            'child_id' => 'nullable|array',
            'child_id.*' => 'nullable|exists:products,id',
        ],
        [
            'thumbnail.max'   => 'The image field must be smaller than 5 MB.',
            'thumbnail.image' => 'The file must be an image.',
            'thumbnail.mimes' => 'The :attribute must be a file of type: PNG, JPEG, JPG.',
            'required'        => 'The :attribute field is required.',
            'unique'          => 'The :attribute already exists in the database.',
        ]
    );

    if ($validator->fails()) {
        \Log::error('Validation failed:', $validator->errors()->toArray());
        return redirect()->back()->withErrors($validator)->withInput();
    }
    
    DB::beginTransaction();

    try {
        \Log::info('Starting product creation...');
        
        // Handle thumbnail upload
        $thumbnail = $request->file('thumbnail');
        $thumbnailName = Str::random(20) . '.' . $thumbnail->getClientOriginalExtension();
        $thumbnailPath = $thumbnail->storeAs('upload/Products/thumbnail', $thumbnailName, 'public');
        $save_url = asset('storage/' . $thumbnailPath);

        \Log::info('Thumbnail saved:', ['url' => $save_url]);

        // Handle checkbox values
        $refurbished = $request->has('is_refurbished') && $request->is_refurbished == '1' ? '1' : '0';
        $dealValue = $request->has('is_deal') && $request->is_deal == '1' ? $request->deal : null;
        
        // Handle RFQ value - must be string for ENUM
        $rfqValue = '0'; // Default to '0'
        if ($request->price_status == 'rfq') {
            $rfqValue = '1';
        }
        
        \Log::info('RFQ calculation:', [
            'price_status' => $request->price_status,
            'rfq_value' => $rfqValue,
            'type' => gettype($rfqValue)
        ]);

        // Handle source approval - must be strings for ENUM columns
        $sourceOnePrice = $request->source_one_price ? floatval($request->source_one_price) : null;
        $sourceTwoPrice = $request->source_two_price ? floatval($request->source_two_price) : null;
        
        $sourceOneApproval = '1'; // Default to approved - must be string
        $sourceTwoApproval = '0'; // Default to not approved - must be string
        
        if ($sourceOnePrice !== null && $sourceTwoPrice !== null) {
            $sourceOneApproval = ($sourceOnePrice <= $sourceTwoPrice) ? '1' : '0';
            $sourceTwoApproval = ($sourceOnePrice > $sourceTwoPrice) ? '1' : '0';
        }

        // Prepare all data with proper ENUM values as strings
        $productData = [
            'name'                      => $request->name,
            'sku_code'                  => $request->sku_code,
            'mf_code'                   => $request->mf_code ?? null,
            'product_code'              => $request->product_code ?? null,
            'tags'                      => $request->tags ?? null,
            'price_status'              => $request->price_status,
            'sas_price'                 => $request->sas_price ? floatval($request->sas_price) : null,
            'short_desc'                => $request->short_desc ?? null,
            'overview'                  => $request->overview ?? null,
            'specification'             => $request->specification ?? null,
            'accessories'               => $request->accessories ?? null,
            'warranty'                  => $request->warranty ?? null,
            'thumbnail'                 => $save_url,
            'stock'                     => $request->stock,
            'currency_id'               => $request->currency_id ? intval($request->currency_id) : null,
            'qty'                       => intval($request->qty ?? 0),
            'rfq'                       => $rfqValue, // This must be string '0' or '1' for ENUM
            'deal'                      => $dealValue,
            'refurbished'               => $refurbished, // This must be string '0' or '1' for ENUM
            'product_type'              => $request->product_type,
            'category_id'               => $request->has('category_id') && !empty($request->category_id) ? json_encode($request->category_id) : null,
            'color_id'                  => $request->has('color_id') && !empty($request->color_id) ? json_encode($request->color_id) : null,
            'parent_id'                 => $request->has('parent_id') && !empty($request->parent_id) ? json_encode($request->parent_id) : null,
            'child_id'                  => $request->has('child_id') && !empty($request->child_id) ? json_encode($request->child_id) : null,
            'brand_id'                  => intval($request->brand_id),
            'source_one_name'           => $request->source_one_name ?? null,
            'source_one_link'           => $request->source_one_link ?? null,
            'source_one_price'          => $sourceOnePrice,
            'source_one_estimate_time'  => $request->source_one_estimate_time ?? null,
            'source_one_principal_time' => $request->source_one_principal_time ?? null,
            'source_one_shipping_time'  => $request->source_one_shipping_time ?? null,
            'source_one_location'       => $request->source_one_location ?? null,
            'source_one_country'        => $request->source_one_country ?? null,
            'source_two_name'           => $request->source_two_name ?? null,
            'source_two_link'           => $request->source_two_link ?? null,
            'source_two_price'          => $sourceTwoPrice,
            'source_two_estimate_time'  => $request->source_two_estimate_time ?? null,
            'source_two_principal_time' => $request->source_two_principal_time ?? null,
            'source_two_shipping_time'  => $request->source_two_shipping_time ?? null,
            'source_two_location'       => $request->source_two_location ?? null,
            'source_two_country'        => $request->source_two_country ?? null,
            'competitor_one_name'       => $request->competitor_one_name ?? null,
            'competitor_one_price'      => $request->competitor_one_price ? floatval($request->competitor_one_price) : null,
            'competitor_two_name'       => $request->competitor_two_name ?? null,
            'competitor_two_price'      => $request->competitor_two_price ? floatval($request->competitor_two_price) : null,
            'competitor_one_link'       => $request->competitor_one_link ?? null,
            'competitor_two_link'       => $request->competitor_two_link ?? null,
            'source_one_approval'       => $sourceOneApproval, // Must be string '0' or '1'
            'source_two_approval'       => $sourceTwoApproval, // Must be string '0' or '1'
            'notification_days'         => intval($request->notification_days),
            'create_date'               => Carbon::now(),
            'solid_source'              => $request->solid_source ?? 'no',
            'direct_principal'          => $request->direct_principal ?? 'no',
            'agreement'                 => $request->agreement ?? 'no',
            'source_type'               => $request->source_type ?? null,
            'source_contact'            => $request->source_contact ?? null,
            'added_by'                  => Auth::guard('admin')->user()->name,
            'action_status'             => ($request->action == 'save') ? 'save' : 'listed',
            'product_status'            => 'sourcing',
            'created_at'                => Carbon::now(),
            'slug'                      => Str::slug($request->name),
            'created_by'                => Auth::guard('admin')->id(),
            'updated_by'                => Auth::guard('admin')->id(),
            'updated_at'                => Carbon::now(),
        ];

        \Log::info('Final product data prepared:', [
            'rfq' => $productData['rfq'],
            'rfq_type' => gettype($productData['rfq']),
            'refurbished' => $productData['refurbished'],
            'refurbished_type' => gettype($productData['refurbished']),
            'source_one_approval' => $productData['source_one_approval'],
            'source_one_approval_type' => gettype($productData['source_one_approval']),
            'source_two_approval' => $productData['source_two_approval'],
            'source_two_approval_type' => gettype($productData['source_two_approval'])
        ]);

        $product = Product::create($productData);
        \Log::info('Product created with ID:', ['id' => $product->id]);

        // Multiple Image Upload
        if ($request->hasFile('multi_img')) {
            \Log::info('Processing multiple images...');
            foreach ($request->file('multi_img') as $img) {
                $makeName = Str::random(20) . '.' . $img->getClientOriginalExtension();
                $multiPath = $img->storeAs('upload/Products/multi-image', $makeName, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'photo'      => asset('storage/' . $multiPath),
                ]);
            }
        }

        // Attach industries
        if (!empty($request->industry_id)) {
            \Log::info('Attaching industries...');
            foreach ($request->industry_id as $industry) {
                IndustryProduct::create([
                    'product_id' => $product->id,
                    'industry_id' => intval($industry),
                ]);
            }
        }

        // Attach solutions
        if (!empty($request->solution_id)) {
            \Log::info('Attaching solutions...');
            foreach ($request->solution_id as $solution) {
                SolutionProduct::create([
                    'product_id' => $product->id,
                    'solution_id' => intval($solution),
                ]);
            }
        }

        DB::commit();
        \Log::info('Product stored successfully!');
        Session::flash('success', 'Data has been inserted successfully!');
        
        // Redirect based on action
        if ($request->action == 'save') {
            return redirect()->route('admin.products.index');
        } else {
            return redirect()->route('admin.products.create');
        }
        
    } catch (\Exception $e) {
        DB::rollback();
        \Log::error('Error storing product:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
        $errorMessage = 'Error storing product: ' . $e->getMessage();
        return redirect()->back()->withInput()->with('error', $errorMessage);
    }
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('multiImages', 'industries', 'solutions')->findOrFail($id);

        $data = [
            'product'            => $product,
            'selectedSolutions'  => $product->solutions->pluck('id')->toArray(),
            'selectedIndustries' => $product->industries->pluck('id')->toArray(),
            'products'           => DB::table('products')->select('id', 'name')->get(),
            'brands'             => DB::table('brands')->select('id', 'title')->orderBy('id', 'desc')->get(),
            'currencys'          => DB::table('currencies')->select('id', 'name')->orderBy('id', 'desc')->get(),
            'colors'             => DB::table('product_colors')->select('id', 'color_code', 'name')->orderBy('id', 'desc')->get(),
            'categories'         => Category::with('children.children.children.children.children.children')->latest('id')->get(),
            'industrys'          => DB::table('industries')->select('id', 'name')->orderBy('id', 'desc')->get(),
            'solutions'          => DB::table('solution_details')->select('id', 'name')->orderBy('id', 'desc')->get(),
        ];

        return view('admin.pages.product.edit', $data);
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
        $product = Product::findOrFail($id);
        $thumbnail = $request->file('thumbnail');
        if (!empty($thumbnail)) {
            $thumbnailName = Str::random(20) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnailPath = $thumbnail->storeAs('upload/Products/thumbnail', $thumbnailName, 'public');
            $save_url = asset('storage/' . $thumbnailPath);
        } else {
            $save_url = $product->thumbnail;
        }

        $product->update([
            'name'                      => $request->name,
            'sku_code'                  => $request->sku_code,
            'mf_code'                   => $request->mf_code,
            'product_code'              => $request->product_code,
            'tags'                      => $request->tags,
            'price_status'              => $request->price_status,
            'sas_price'                 => $request->sas_price,
            'short_desc'                => $request->short_desc,
            'overview'                  => $request->overview,
            'specification'             => $request->specification,
            'accessories'               => $request->accessories,
            'warranty'                  => $request->warranty,
            'thumbnail'                 => $save_url,
            'stock'                     => $request->stock,
            'currency_id'               => $request->currency_id,
            'qty'                       => $request->qty,
            'rfq'                       => ($request->price_status == 'rfq') ? '1' : '0',
            'deal'                      => $request->deal,
            'refurbished'               => $request->refurbished,
            'product_type'              => $request->product_type,
            'category_id'               => $request->input('category_id'),
            'color_id'                  => $request->input('color_id'),
            'parent_id'                 => $request->input('parent_id'),
            'child_id'                  => $request->input('child_id'),
            'brand_id'                  => $request->brand_id,
            'source_one_name'           => $request->source_one_name,
            'source_one_link'           => $request->source_one_link,
            'source_one_price'          => $request->source_one_price,
            'source_one_estimate_time'  => $request->source_one_estimate_time,
            'source_one_principal_time' => $request->source_one_principal_time,
            'source_one_shipping_time'  => $request->source_one_shipping_time,
            'source_one_location'       => $request->source_one_location,
            'source_one_country'        => $request->source_one_country,
            'source_two_name'           => $request->source_two_name,
            'source_two_link'           => $request->source_two_link,
            'source_two_price'          => $request->source_two_price,
            'source_two_estimate_time'  => $request->source_two_estimate_time,
            'source_two_principal_time' => $request->source_two_principal_time,
            'source_two_shipping_time'  => $request->source_two_shipping_time,
            'source_two_location'       => $request->source_two_location,
            'source_two_country'        => $request->source_two_country,
            'competitor_one_name'       => $request->competitor_one_name,
            'competitor_one_price'      => $request->competitor_one_price,
            'competitor_two_name'       => $request->competitor_two_name,
            'competitor_two_price'      => $request->competitor_two_price,
            'competitor_one_link'       => $request->competitor_one_link,
            'competitor_two_link'       => $request->competitor_two_link,
            'source_one_approval'       => ($request->source_one_price > $request->source_two_price) ? '0' : '1',
            'source_two_approval'       => ($request->source_one_price > $request->source_two_price) ? '1' : '0',
            'notification_days'         => $request->notification_days,
            'solid_source'              => $request->solid_source,
            'direct_principal'          => $request->direct_principal,
            'agreement'                 => $request->agreement,
            'source_type'               => $request->source_type,
            'source_contact'            => $request->source_contact,
            'added_by'                  => Auth::guard('admin')->user()->name,
            'updated_at'                => Carbon::now(),
        ]);

        // Multiple Image Upload From it
        $images = $request->file('multi_img');
        if (!empty($images)) {
            foreach ($images as $img) {
                $makeName = Str::random(20) . '.' . $img->getClientOriginalExtension();
                $multiPath = $img->storeAs('upload/Products/multi-image', $makeName, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'photo' => asset('storage/' . $multiPath),
                ]);
            }
        }

        if (!empty($request->industry_id)) {
            $industry_destroys = IndustryProduct::where('product_id', $id)->get();

            foreach ($industry_destroys as $industry_destroy) {
                IndustryProduct::find($industry_destroy->id)->delete();
            }

            $industrys = $request->industry_id;
            foreach ($industrys as $industry) {
                IndustryProduct::insert([
                    'product_id' => $id,
                    'industry_id' => $industry,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
        
        if (!empty($request->solution_id)) {
            $solution_destroys = SolutionProduct::where('product_id', $id)->get();

            foreach ($solution_destroys as $solution_destroy) {
                SolutionProduct::find($solution_destroy->id)->delete();
            }
            $solutions = $request->solution_id;
            foreach ($solutions as $solution) {
                SolutionProduct::insert([
                    'product_id' => $id,
                    'solution_id' => $solution,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
        
        Session::flash('success', 'Data has been updated successfully!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::with('productIndustries', 'productSolutions', 'multiImages')->findOrFail($id);
        //unlink($product->thumbnail);
        if (File::exists($product->thumbnail)) {
            File::delete($product->thumbnail);
        }
        $product->delete();

        $imges = $product->multiImages;
        foreach ($imges as $img) {
            //unlink($img->photo_name);
            if (File::exists($img->photo_name)) {
                File::delete($img->photo_name);
            }
            $img->delete();
        }
    }
    
    public function deleteImage(Request $request)
    {
        $image = ProductImage::find($request->id);

        if ($image) {
            // Remove physical file if it exists
            if (file_exists(public_path($image->photo))) {
                unlink(public_path($image->photo));
            }

            // Remove database record
            $image->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * Display pending products for approval.
     */
    public function pending()
    {
        return view('admin.pages.product.pending', [
            'pendingProducts' => Product::where('submission_status', 'pending')->with('principal')->latest()->get(),
        ]);
    }

    /**
     * Approve a product.
     */
    public function approve($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update([
                'submission_status' => 'approved',
                'approved_at' => now(),
                'rejection_reason' => null,
                'product_status' => 'product' // Set to active product status when approved
            ]);
            
            return redirect()->route('admin.products.pending')
                ->with('success', 'Product approved successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.pending')
                ->with('error', 'Error approving product: ' . $e->getMessage());
        }
    }

    /**
     * Reject a product.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        try {
            $product = Product::findOrFail($id);
            $product->update([
                'submission_status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'approved_at' => null,
                'product_status' => 'sourcing' // Keep as sourcing when rejected
            ]);
            
            return redirect()->route('admin.products.pending')
                ->with('success', 'Product rejected successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.products.pending')
                ->with('error', 'Error rejecting product: ' . $e->getMessage());
        }
    }
}