<?php

namespace App\Http\Controllers\Rfq;

use App\Models\Rfq;
use App\Models\Admin\Product;
use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RfqController extends Controller
{
    /**
     * Show the RFQ form with pre-filled product data if available
     */
    public function create(Request $request)
    {
        Log::info('RFQ Create Method Called');
        Log::info('Request Parameters:', $request->all());
        
        $prefilledProducts = [];
        $source = $request->get('source', 'direct');
        
        // Check if we have product info from URL parameters (from "Get Quote" button)
        if ($request->has('product_id') || $request->has('product_name')) {
            $productId = $request->get('product_id');
            $productName = $request->get('product_name');
            $productSku = $request->get('product_sku');
            $productBrand = $request->get('product_brand');
            
            Log::info('Product parameters found:', [
                'product_id' => $productId,
                'product_name' => $productName,
                'product_sku' => $productSku,
                'product_brand' => $productBrand,
                'source' => $source
            ]);
            
            $productData = $this->getProductData($productId, $productName, $productSku, $productBrand);
            
            if (!empty($productData)) {
                $prefilledProducts[] = $productData;
                Log::info('Prefilled product data prepared:', $productData);
            }
        }
        
        // Check if we should also include cart items
        $includeCartItems = $request->get('include_cart', false);
        if ($includeCartItems && Auth::check()) {
            $cartProducts = $this->getCartProducts();
            if (!empty($cartProducts)) {
                $prefilledProducts = array_merge($prefilledProducts, $cartProducts);
                Log::info('Cart products added to RFQ:', $cartProducts);
            }
        }
        
        Log::info('Final prefilled products:', $prefilledProducts);
        
        return view('frontend.pages.rfq.rfq', compact('prefilledProducts')); 
    }

    /**
     * Get product data from database or parameters
     */
    private function getProductData($productId = null, $productName = null, $productSku = null, $productBrand = null)
    {
        $productData = [];
        
        // If we have a product ID, try to fetch from database
        if ($productId) {
            try {
                $product = Product::with('brand')->find($productId);
                if ($product) {
                    Log::info('Product found in database:', [
                        'id' => $product->id,
                        'name' => $product->name,
                        'sku' => $product->sku_code,
                        'brand' => $product->brand->name ?? 'N/A',
                        'model' => $product->mf_code,
                        'description' => $product->short_desc
                    ]);
                    
                    $productData = [
                        'sl' => 1,
                        'product_name' => $product->name,
                        'qty' => 1,
                        'sku_no' => $product->sku_code ?? $productSku,
                        'brand_name' => $product->brand->name ?? $productBrand,
                        'model_no' => $product->mf_code ?? null,
                        'additional_product_name' => $product->name,
                        'product_des' => $this->cleanProductDescription($product->short_desc ?? $product->overview ?? ''),
                        'product_id' => $product->id,
                        'thumbnail' => $product->thumbnail,
                        'source' => 'database'
                    ];
                    
                    return $productData;
                }
            } catch (\Exception $e) {
                Log::error('Error fetching product from database: ' . $e->getMessage());
            }
        }
        
        // If no product found in DB but we have product name from URL, use that
        if ($productName) {
            Log::info('Using product data from URL parameters');
            $productData = [
                'sl' => 1,
                'product_name' => $productName,
                'qty' => 1,
                'sku_no' => $productSku,
                'brand_name' => $productBrand,
                'model_no' => null,
                'additional_product_name' => $productName,
                'product_des' => '',
                'product_id' => $productId,
                'thumbnail' => null,
                'source' => 'url_parameters'
            ];
        }
        
        return $productData;
    }

    /**
     * Clean product description by removing HTML tags and limiting length
     */
    private function cleanProductDescription($description)
    {
        if (empty($description)) {
            return '';
        }
        
        // Remove HTML tags
        $cleanDescription = strip_tags($description);
        
        // Limit length to prevent issues
        if (strlen($cleanDescription) > 500) {
            $cleanDescription = substr($cleanDescription, 0, 500) . '...';
        }
        
        // Escape any special characters for JavaScript
        $cleanDescription = addslashes($cleanDescription);
        
        return $cleanDescription;
    }

    /**
     * Get cart products for authenticated users
     */
    private function getCartProducts()
    {
        // This is a placeholder - implement based on your cart system
        // You might use session, database, or other storage for cart
        $cartProducts = [];
        
        // Example implementation (adjust based on your cart system):
        /*
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->get();
            foreach ($cartItems as $index => $item) {
                $cartProducts[] = [
                    'sl' => $index + 1,
                    'product_name' => $item->product->name,
                    'qty' => $item->quantity,
                    'sku_no' => $item->product->sku_code,
                    'brand_name' => $item->product->brand->name,
                    'model_no' => $item->product->mf_code,
                    'additional_product_name' => $item->product->name,
                    'product_des' => $this->cleanProductDescription($item->product->short_desc),
                    'product_id' => $item->product_id,
                    'thumbnail' => $item->product->thumbnail,
                    'source' => 'cart'
                ];
            }
        }
        */
        
        return $cartProducts;
    }

    /**
     * Store the RFQ request
     */
    public function store(Request $request)
    {
        Log::info('RFQ Store Method Called');
        Log::info('All Request Data:', $request->all());
        Log::info('Contacts Data:', $request->contacts ?? []);

        // Enhanced validation with better error messages
        $validationRules = $this->getValidationRules();
        $customMessages = $this->getValidationMessages();

        $validator = Validator::make($request->all(), $validationRules, $customMessages);

        // Check if validation fails
        if ($validator->fails()) {
            Log::error('RFQ Validation Failed:');
            Log::error('Validation Errors:', $validator->errors()->toArray());
            Log::error('Submitted Data:', $request->all());
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors below.');
        }

        Log::info('RFQ Form Data Validated Successfully');

        try {
            // Generate unique codes
            $rfq_code = 'RFQ-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
            $deal_code = 'DEAL-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

            Log::info('Generated RFQ Code: ' . $rfq_code);
            Log::info('Generated Deal Code: ' . $deal_code);

            // Process products and files
            $processedData = $this->processProductsAndFiles($request);
            $products = $processedData['products'];
            $uploadedFiles = $processedData['files'];

            Log::info('Processed products:', $products);
            Log::info('Uploaded files:', $uploadedFiles);

            // Prepare RFQ data
            $rfqData = $this->prepareRfqData($request, $rfq_code, $deal_code, $products, $uploadedFiles);

            Log::info('Final RFQ Data to be saved:', $rfqData);

            // Validate fillable fields
            $rfqData = $this->validateFillableFields($rfqData);

            // Create the RFQ
            Log::info('Creating RFQ record...');
            $rfq = Rfq::create($rfqData);

            Log::info('RFQ created successfully with ID: ' . $rfq->id);
            Log::info('RFQ Code: ' . $rfq_code);
            Log::info('Deal Code: ' . $deal_code);

            // Clear cart if items were added from cart
            $this->clearCartIfNeeded($request);

            return redirect()->back()
                ->with('success', 'RFQ submitted successfully! Your RFQ code: ' . $rfq_code . ' and Deal code: ' . $deal_code)
                ->with('rfq_code', $rfq_code)
                ->with('deal_code', $deal_code);

        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('RFQ Database Query Error: ' . $e->getMessage());
            Log::error('SQL Error: ' . $e->getSql());
            Log::error('Bindings: ' . json_encode($e->getBindings()));

            $errorMessage = 'Database error occurred while submitting RFQ. Please try again.';
            if (app()->environment('local')) {
                $errorMessage .= ' Error: ' . $e->getMessage();
            }

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();

        } catch (\Exception $e) {
            Log::error('RFQ Store General Error: ' . $e->getMessage());
            Log::error('Error Trace: ' . $e->getTraceAsString());

            $errorMessage = 'Error submitting RFQ. Please try again.';
            if (app()->environment('local')) {
                $errorMessage .= ' Error: ' . $e->getMessage();
            }

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
    }

    /**
     * Get validation rules for RFQ form
     */
    private function getValidationRules()
    {
        return [
            // Company Information
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'required|string|max:20',
            'is_reseller' => 'sometimes|boolean',
            
            // Shipping Details
            'shipping_company_name' => 'nullable|string|max:255',
            'shipping_name' => 'nullable|string|max:255',
            'shipping_designation' => 'nullable|string|max:255',
            'shipping_email' => 'nullable|email',
            'shipping_phone' => 'nullable|string|max:20',
            'shipping_address' => 'nullable|string',
            'shipping_country' => 'nullable|string',
            'shipping_city' => 'nullable|string',
            'shipping_zip_code' => 'nullable|string|max:20',
            'is_contact_address' => 'sometimes|boolean',
            
            // End User Information
            'end_user_company_name' => 'nullable|string|max:255',
            'end_user_name' => 'nullable|string|max:255',
            'end_user_designation' => 'nullable|string|max:255',
            'end_user_email' => 'nullable|email',
            'end_user_phone' => 'nullable|string|max:20',
            'end_user_address' => 'nullable|string',
            'end_user_country' => 'nullable|string',
            'end_user_city' => 'nullable|string',
            'end_user_zip_code' => 'nullable|string|max:20',
            'end_user_is_contact_address' => 'sometimes|boolean',
            
            // Additional Details
            'project_name' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'project_status' => 'nullable|string',
            'approximate_delivery_time' => 'nullable|string',
            'project_brief' => 'nullable|string',
            
            // Products from repeater
            'contacts' => 'required|array|min:1',
            'contacts.*.product_name' => 'required|string|max:255',
            'contacts.*.qty' => 'required|numeric|min:1',
            'contacts.*.sku_no' => 'nullable|string|max:255',
            'contacts.*.model_no' => 'nullable|string|max:255',
            'contacts.*.brand_name' => 'nullable|string|max:255',
            'contacts.*.additional_qty' => 'nullable|numeric|min:0',
            'contacts.*.additional_product_name' => 'nullable|string|max:255',
            'contacts.*.product_des' => 'nullable|string',
            'contacts.*.additional_info' => 'nullable|string',
            'contacts.*.image' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ];
    }

    /**
     * Get validation messages
     */
    private function getValidationMessages()
    {
        return [
            'contacts.required' => 'At least one product is required.',
            'contacts.*.product_name.required' => 'Product name is required for all items.',
            'contacts.*.qty.required' => 'Quantity is required for all items.',
            'contacts.*.qty.numeric' => 'Quantity must be a number.',
            'contacts.*.qty.min' => 'Quantity must be at least 1.',
            'company_name.required' => 'Company name is required.',
            'name.required' => 'Contact name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Phone number is required.',
        ];
    }

    /**
     * Process products and handle file uploads
     */
    private function processProductsAndFiles(Request $request)
    {
        $products = [];
        $uploadedFiles = [];

        foreach ($request->contacts as $index => $contact) {
            Log::info("Processing product {$index}:", $contact);

            $productData = [
                'sl' => $contact['sl'] ?? $index + 1,
                'product_name' => $contact['product_name'] ?? 'Unknown Product',
                'quantity' => $contact['qty'] ?? 1,
                'sku_no' => $contact['sku_no'] ?? null,
                'model_no' => $contact['model_no'] ?? null,
                'brand_name' => $contact['brand_name'] ?? null,
                'additional_qty' => $contact['additional_qty'] ?? null,
                'additional_product_name' => $contact['additional_product_name'] ?? null,
                'product_description' => $contact['product_des'] ?? null,
                'additional_info' => $contact['additional_info'] ?? null,
                'image_path' => null,
            ];

            // Handle file upload for this product
            $filePath = $this->handleFileUpload($request, $index, $contact);
            if ($filePath) {
                $productData['image_path'] = $filePath;
                $uploadedFiles[] = $filePath;
            }

            $products[] = $productData;
            Log::info("Product {$index} processed successfully");
        }

        return [
            'products' => $products,
            'files' => $uploadedFiles
        ];
    }

    /**
     * Handle file upload for a product
     */
    private function handleFileUpload(Request $request, $index, $contact)
    {
        if (isset($contact['image']) && $request->hasFile("contacts.{$index}.image")) {
            try {
                $file = $request->file("contacts.{$index}.image");
                if ($file && $file->isValid()) {
                    $fileName = time() . '_' . $index . '_' . preg_replace('/[^A-Za-z0-9\.]/', '', $file->getClientOriginalName());
                    $filePath = $file->storeAs('rfq_files', $fileName, 'public');
                    Log::info("File uploaded successfully: {$filePath}");
                    return $filePath;
                }
            } catch (\Exception $fileException) {
                Log::error("File upload failed for product {$index}: " . $fileException->getMessage());
            }
        }
        return null;
    }

    /**
     * Prepare RFQ data for storage
     */
    private function prepareRfqData(Request $request, $rfq_code, $deal_code, $products, $uploadedFiles)
    {
        return [
            'rfq_code' => $rfq_code,
            'deal_code' => $deal_code,
            'user_id' => Auth::id(),
            
            // Company Information
            'company_name' => $request->company_name,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'designation' => $request->designation,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'is_reseller' => $request->boolean('is_reseller'),
            
            // Shipping Details
            'shipping_company_name' => $request->shipping_company_name,
            'shipping_name' => $request->shipping_name,
            'shipping_designation' => $request->shipping_designation,
            'shipping_email' => $request->shipping_email,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_country' => $request->shipping_country,
            'shipping_city' => $request->shipping_city,
            'shipping_zip_code' => $request->shipping_zip_code,
            'is_contact_address' => $request->boolean('is_contact_address'),
            
            // End User Information
            'end_user_company_name' => $request->end_user_company_name,
            'end_user_name' => $request->end_user_name,
            'end_user_designation' => $request->end_user_designation,
            'end_user_email' => $request->end_user_email,
            'end_user_phone' => $request->end_user_phone,
            'end_user_address' => $request->end_user_address,
            'end_user_country' => $request->end_user_country,
            'end_user_city' => $request->end_user_city,
            'end_user_zip_code' => $request->end_user_zip_code,
            'end_user_is_contact_address' => $request->boolean('end_user_is_contact_address'),
            
            // Additional Details
            'project_name' => $request->project_name,
            'budget' => $request->budget,
            'project_status' => $request->project_status ?? 'pending',
            'approximate_delivery_time' => $request->approximate_delivery_time,
            'message' => $request->project_brief,
            
            // Products and Files
            'products_data' => json_encode($products),
            'uploaded_files' => json_encode($uploadedFiles),
            
            // System fields
            'rfq_type' => 'rfq',
            'client_type' => Auth::id() ? 'client' : 'anonymous',
            'create_date' => now(),
        ];
    }

    /**
     * Validate and filter fillable fields
     */
    private function validateFillableFields($rfqData)
    {
        $fillableFields = (new Rfq())->getFillable();
        $missingFillable = array_diff(array_keys($rfqData), $fillableFields);
        
        if (!empty($missingFillable)) {
            Log::warning('Removing non-fillable fields from RFQ data:', $missingFillable);
            foreach ($missingFillable as $field) {
                unset($rfqData[$field]);
            }
        }
        
        return $rfqData;
    }

    /**
     * Clear cart after successful RFQ submission if needed
     */
    private function clearCartIfNeeded(Request $request)
    {
        // Implement cart clearing logic based on your cart system
        // Example:
        /*
        if ($request->has('clear_cart') && $request->boolean('clear_cart')) {
            Cart::where('user_id', Auth::id())->delete();
            Log::info('Cart cleared after RFQ submission');
        }
        */
    }

    /**
     * Quick test method to check validation issues
     */
    public function testValidation(Request $request)
    {
        Log::info('Test Validation - Request Data:', $request->all());
        
        $validator = Validator::make($request->all(), [
            'contacts' => 'required|array|min:1',
            'contacts.*.product_name' => 'required|string',
            'contacts.*.qty' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'request_data' => $request->all()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Validation passed'
        ]);
    }
}