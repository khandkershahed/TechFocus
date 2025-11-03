<?php

namespace App\Http\Controllers\Rfq;

use App\Models\Rfq;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Rfq\RfqProduct;
use App\Notifications\RfqCreate;
use App\Mail\RFQConfirmationMail;
use App\Mail\RfqNotificationMail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RFQNotificationAdminMail;
use Illuminate\Support\Facades\Schema;
use App\Mail\RFQNotificationClientMail;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class RfqController extends Controller
{


    private function getRfqRecipients(): array
    {
        
        $admin = Admin::whereIn('role', ['admin', 'sales','logistics'])
                     ->where('status', 'active')
                     ->pluck('email')
                      ->filter(fn($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
                     ->toArray();

        // Fallback emails
        return $admin ?: [
           ' site2.ngenit@gmail.com',
             'techfcousltd@gmail.com',
             'dev2.ngenit@gmail.com',
             'dev1.ngenit@gmail.com',
             'dev3.ngenit@gmail.com',
             'site3.ngenit@gmail.com ',

        ];
    }

    /**
     * Send RFQ notification emails
     */
    private function sendRfqEmails(Rfq $rfq): bool
    {
        $recipients = $this->getRfqRecipients();
        $subject = 'New RFQ Submitted - ' . $rfq->rfq_code;

        $sentCount = 0;

        Log::info("Sending RFQ emails to: " . implode(', ', $recipients));

        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient)->send(new RfqNotificationMail($rfq, $subject));
                Log::info("RFQ email sent to: {$recipient}");
                $sentCount++;
            } catch (\Exception $e) {
                Log::error("Failed to send RFQ email to {$recipient}: " . $e->getMessage());
            }
        }

        Log::info("RFQ email summary: {$sentCount} of " . count($recipients) . " sent");
        return $sentCount > 0;
    }




    /**
     * Show the RFQ form with pre-filled product data from session
     */
    public function create(Request $request)
    {
        Log::info('RFQ Create Method Called');
        Log::info('Request Parameters:', $request->all());
        
        // Get RFQ items from session
        $rfqItems = $this->getRfqItemsFromSession();
        
        // If no items in session but there are direct parameters, create a temporary item
        if (empty($rfqItems) && $request->has('product_id')) {
            $product = Product::with('brand')->find($request->product_id);
            
            if ($product) {
                $rfqItems = [
                    $product->id => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'sku_code' => $product->sku_code,
                        'product_code' => $product->product_code,
                        'mf_code' => $product->mf_code,
                        'brand' => $product->brand->name ?? 'N/A',
                        'thumbnail' => $product->thumbnail,
                        'quantity' => 1,
                        'added_at' => now()->timestamp
                    ]
                ];
                
                // Store in session for consistency
                session()->put('rfq_items', $rfqItems);
                Log::info('Product added to RFQ session from URL parameters:', $rfqItems);
            }
        }
        
        Log::info('Final RFQ items for display:', $rfqItems);
        
        return view('frontend.pages.rfq.rfq', [
            'rfqItems' => $rfqItems,
            'source' => $request->get('source', 'direct')
        ]);
    }

    /**
     * Get RFQ items from session
     */
    private function getRfqItemsFromSession()
    {
        $rfqItems = Session::get('rfq_items', []);
        Log::info('RFQ items from session:', $rfqItems);
        return $rfqItems;
    }

    /**
     * Store the RFQ request - Updated to match rfqCreate structure
     */
    public function store(Request $request)
    {
        Log::info('=== RFQ STORE METHOD START ===');
        Log::info('Full Request Data:', $request->all());

        // Check if it's an AJAX request
        $isAjax = $request->ajax() || $request->wantsJson();

        try {
            // Validate the request using simplified validation like rfqCreate
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email:rfc,dns',
                    'phone' => 'required|string|max:20',
                    'company_name' => 'required|string|max:255',
                    'country' => 'required|string|max:255',
                    'address' => 'required|string',
                    'city' => 'required|string|max:255',
                    'zip_code' => 'required|string|max:20',
                    'designation' => 'required|string|max:255',
                    'products' => 'required|array|min:1',
                    'products.*.product_name' => 'required|string|max:255',
                    'products.*.qty' => 'required|integer|min:1',
                    'products.*.image' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:5120',
                ],
                [
                    'required' => 'The :attribute field is required.',
                    'email' => 'The :attribute must be a valid email address.',
                    'products.*.product_name.required' => 'Each product must have a name.',
                    'products.*.qty.required' => 'Each product must have a quantity.',
                    'products.*.qty.integer' => 'Quantity must be a number.',
                    'products.*.qty.min' => 'Quantity must be at least 1.',
                    'products.*.image.mimes' => 'The image must be a file of type: jpeg, png, jpg, pdf, doc, docx.',
                    'products.*.image.max' => 'The image must not be larger than 5MB.',
                ]
            );

            if ($validator->fails()) {
                Log::error('RFQ Validation Failed:', $validator->errors()->toArray());
                
                if ($isAjax) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please fix the validation errors below.',
                        'errors' => $validator->errors()->toArray()
                    ], 422);
                }
                
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Please fix the validation errors below.');
            }

            Log::info('✅ Validation passed successfully');

           
            // Generate RFQ Code like rfqCreate method
            $today = now()->format('ymd');
            $lastCode = Rfq::where('rfq_code', 'like', "$today-%")->latest('id')->first();
            if ($lastCode) {
                $parts = explode('-', $lastCode->rfq_code);
                $lastNumber = isset($parts[1]) ? (int)$parts[1] : 0;
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            $rfq_code = $today . '-' . $newNumber;
            $deal_code = 'DEAL-' . $today . '-' . $newNumber;

            Log::info('Generated codes:', ['rfq_code' => $rfq_code, 'deal_code' => $deal_code]);

            // Check for existing client
            $client_type = 'anonymous';
            $client = User::where('email', trim($request->email))->first();
            
            if ($client) {
                if ($client->user_type === 'job_seeker') {
                    // Don't delete the user, just treat as anonymous
                    $client_type = 'anonymous';
                } elseif (in_array(trim(strtolower($client->user_type)), ['client', 'partner'])) {
                    $client_type = $client->user_type;
                }
            }

            // Prepare RFQ data like rfqCreate method
            $rfqData = [
                'rfq_code' => $rfq_code,
                'deal_code' => $deal_code,
                'user_id' => Auth::id(),
                'client_id' => $request->client_id ?? $client->id ?? null,
                'client_type' => $client_type,
                
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
                'is_reseller' => $request->is_reseller,
                
                // Shipping Details
                'shipping_company_name' => ($request->is_contact_address == '1') ? $request->company_name : ($request->shipping_company_name ?? null),
                'shipping_name' => ($request->is_contact_address == '1') ? $request->name : ($request->shipping_name ?? null),
                'shipping_designation' => ($request->is_contact_address == '1') ? $request->designation : ($request->shipping_designation ?? null),
                'shipping_email' => ($request->is_contact_address == '1') ? $request->email : ($request->shipping_email ?? null),
                'shipping_phone' => ($request->is_contact_address == '1') ? $request->phone : ($request->shipping_phone ?? null),
                'shipping_address' => ($request->is_contact_address == '1') ? $request->address : ($request->shipping_address ?? null),
                'shipping_country' => ($request->is_contact_address == '1') ? $request->country : ($request->shipping_country ?? null),
                'shipping_city' => ($request->is_contact_address == '1') ? $request->city : ($request->shipping_city ?? null),
                'shipping_zip_code' => ($request->is_contact_address == '1') ? $request->zip_code : ($request->shipping_zip_code ?? null),
                
                // End User Information
                'end_user_company_name' => ($request->end_user_is_contact_address == '1') ? $request->company_name : ($request->end_user_company_name ?? null),
                'end_user_name' => ($request->end_user_is_contact_address == '1') ? $request->name : ($request->end_user_name ?? null),
                'end_user_designation' => ($request->end_user_is_contact_address == '1') ? $request->designation : ($request->end_user_designation ?? null),
                'end_user_email' => ($request->end_user_is_contact_address == '1') ? $request->email : ($request->end_user_email ?? null),
                'end_user_phone' => ($request->end_user_is_contact_address == '1') ? $request->phone : ($request->end_user_phone ?? null),
                'end_user_address' => ($request->end_user_is_contact_address == '1') ? $request->address : ($request->end_user_address ?? null),
                'end_user_country' => ($request->end_user_is_contact_address == '1') ? $request->country : ($request->end_user_country ?? null),
                'end_user_city' => ($request->end_user_is_contact_address == '1') ? $request->city : ($request->end_user_city ?? null),
                'end_user_zip_code' => ($request->end_user_is_contact_address == '1') ? $request->zip_code : ($request->end_user_zip_code ?? null),
                
                // Additional Details
                'project_name' => $request->project_name ?? null,
                'budget' => $request->budget ?? null,
                'project_status' => $request->project_status ?? 'pending',
                'approximate_delivery_time' => $request->approximate_delivery_time ?? null,
                'message' => $request->project_brief ?? null,
                
                // System fields
                'rfq_type' => 'rfq',
                'create_date' => now(),
                'status' => 'rfq_created',
                'deal_type' => 'new',
            ];

            // Set main product_id if available from first product
            if (!empty($request->products) && isset($request->products[0]['product_id'])) {
                $rfqData['product_id'] = $request->products[0]['product_id'];
                Log::info('Main product_id set to: ' . $rfqData['product_id']);
            }

            // Add optional checkbox fields
            $rfqData['is_contact_address'] = $request->boolean('is_contact_address') ?? false;
            $rfqData['end_user_is_contact_address'] = $request->boolean('end_user_is_contact_address') ?? false;

            Log::info('Final RFQ Data to be saved:', [
                'rfq_code' => $rfqData['rfq_code'],
                'products_count' => count($request->products ?? [])
            ]);

            // Create the RFQ
            try {
                $rfq = Rfq::create($rfqData);
                Log::info('✅ RFQ created successfully with ID: ' . $rfq->id);

                // Process RFQ Products like rfqCreate method
                $this->processRfqProducts($rfq->id, $request->products);

            } catch (\Illuminate\Database\QueryException $dbException) {
                Log::error('❌ Database Error Creating RFQ:', [
                    'message' => $dbException->getMessage(),
                    'error_code' => $dbException->getCode()
                ]);
                
                throw new \Exception('Database error: ' . $dbException->getMessage());
            }
 // -------------------------------
        // Send RFQ Notification Emails
        // -------------------------------


            // Send Emails
        $this->sendRfqEmails($rfq);

        // try {
        //     $mailSent = $this->sendRfqEmails($rfq);

        //     if ($mailSent) {
        //         Log::info(' RFQ notification emails sent successfully.');
        //     } else {
        //         Log::warning(' RFQ notification emails failed to send.');
        //     }
        // } catch (\Exception $mailEx) {
        //     Log::error(' Error sending RFQ emails: ' . $mailEx->getMessage());

        // }


            Log::info('✅ RFQ session cleared');

            Log::info('=== RFQ STORE METHOD COMPLETED SUCCESSFULLY ===');

            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'RFQ submitted successfully! Your RFQ code: ' . $rfq_code,
                    'rfq_code' => $rfq_code,
                    'deal_code' => $deal_code,
                    'redirect_url' => route('rfq', $rfq_code)
                ]);
            }

            return redirect()->route('rfq', $rfq_code)
                ->with('success', 'RFQ submitted successfully! Your RFQ code: ' . $rfq_code);

        } catch (\Exception $e) {
            Log::error('RFQ Store Critical Error: ' . $e->getMessage());
            
            $errorMessage = 'Error submitting RFQ: ' . $e->getMessage();
            
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
    }

    /**
     * Process RFQ Products like rfqCreate method - FIXED BUGS
     */
    private function processRfqProducts($rfqId, $products)
    {
        Log::info('Processing RFQ products for RFQ ID: ' . $rfqId);
        Log::info('Products data received:', ['products' => $products]);
        
        if (empty($products) || !is_array($products)) {
            Log::warning('Products data is empty or not an array:', ['products' => $products]);
            return;
        }

        foreach ($products as $index => $productItem) {
            $productName = $productItem['product_name'] ?? null;
            $qty = $productItem['qty'] ?? null;

            if (!$productName || !$qty) {
                Log::warning('Skipping product - missing product name or quantity:', ['product' => $productItem]);
                continue;
            }

            $imagePath = null;

            // Handle file upload if image is present - FIXED: use $productItem instead of $products
            if (isset($productItem['image']) && $productItem['image'] instanceof \Illuminate\Http\UploadedFile) {
                try {
                    $filePath = 'rfq_products/image';
                    $uploadedFile = Helper::imageUpload($productItem['image'], $filePath);
                    
                    if ($uploadedFile['status'] === 1) {
                        $imagePath = $uploadedFile['file_path'];
                        Log::info("File uploaded successfully: {$imagePath}");
                    } else {
                        Log::error("File upload failed: " . ($uploadedFile['error_message'] ?? 'Unknown error'));
                        // Continue without image if upload fails
                    }
                } catch (\Exception $e) {
                    Log::error("File upload exception for product {$index}: " . $e->getMessage());
                }
            }

            $productData = [
                'rfq_id' => $rfqId,
                'product_id' => $productItem['product_id'] ?? null,
                'product_name' => $productName,
                'qty' => (int) $qty,
                'sku_no' => $productItem['sku_no'] ?? null,
                'model_no' => $productItem['model_no'] ?? null,
                'brand_name' => $productItem['brand_name'] ?? null,
                'additional_qty' => isset($productItem['additional_qty']) ? (int) $productItem['additional_qty'] : null,
                'additional_product_name' => $productItem['additional_product_name'] ?? null,
                'product_des' => $productItem['product_des'] ?? null,
                'additional_info' => $productItem['additional_info'] ?? null,
                'image' => $imagePath,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Create RFQ Product
            try {
                RfqProduct::create($productData);
                Log::info('RFQ Product created:', ['product_name' => $productName, 'qty' => $qty]);
            } catch (\Exception $e) {
                Log::error('Failed to create RFQ product: ' . $e->getMessage());
                // Continue with other products even if one fails
            }
        }

        Log::info('Completed processing RFQ products for RFQ ID: ' . $rfqId);
    }

    
    public function removeFromRfqSession(Request $request)
    {
        try {
            $productId = $request->product_id ?? $request->input('product_id');
            
            if (!$productId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product ID is required'
                ], 400);
            }

            $rfqItems = Session::get('rfq_items', []);
            
            if (isset($rfqItems[$productId])) {
                unset($rfqItems[$productId]);
                Session::put('rfq_items', $rfqItems);
                
                Log::info('Product removed from RFQ session:', ['product_id' => $productId]);

                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from RFQ',
                    'rfq_count' => count($rfqItems)
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Product not found in RFQ'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Remove from RFQ session error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove product from RFQ'
            ], 500);
        }
    }

    /**
     * Clear all RFQ session items
     */
    public function clearRfqSession()
    {
        try {
            Session::forget('rfq_items');
            Log::info('RFQ session cleared');

            return response()->json([
                'success' => true,
                'message' => 'RFQ items cleared successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Clear RFQ session error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear RFQ items'
            ], 500);
        }
    }

    /**
     * Success page for RFQ - FIXED to match your route
     */
    public function success($rfq_code)
    {
        $rfq = Rfq::where('rfq_code', $rfq_code)->first();
        
        if (!$rfq) {
            return redirect()->route('rfq.create')->with('error', 'RFQ not found.');
        }
        
        // Check if the success view exists, otherwise use a basic success message
        if (view()->exists('frontend.pages.rfq.success')) {
            return view('frontend.pages.rfq.rfq', compact('rfq'));
        } else {
            // Fallback view
            return view('frontend.pages.rfq.rfq', compact('rfq'))
                ->with('success', 'RFQ submitted successfully! Your RFQ code: ' . $rfq_code);
        }
    }

    /**
     * Debug method to check form submission
     */
    public function debugFormSubmit(Request $request)
    {
        Log::info('=== FORM SUBMISSION DEBUG ===');
        Log::info('All request data:', $request->all());
        
        return response()->json([
            'success' => true,
            'received_data' => $request->all(),
            'has_products' => $request->has('products'),
            'products_count' => count($request->products ?? []),
            'products_data' => $request->products ?? 'NO PRODUCTS'
        ]);
    }

    /**
     * Test database connection and check for missing columns
     */
    public function checkDatabase()
    {
        try {
            // Check if products_data column exists
            $rfq = new Rfq();
            $columns = Schema::getColumnListing($rfq->getTable());
            
            $hasProductsData = in_array('products_data', $columns);
            
            return response()->json([
                'success' => true,
                'has_products_data_column' => $hasProductsData,
                'all_columns' => $columns,
                'message' => $hasProductsData ? 
                    'products_data column exists' : 
                    'MISSING: products_data column - run migration'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test email functionality
     */
public function testEmail()
{
    $message = null;
    $success = false;

    try {
        $rfq = Rfq::latest()->first();
        if ($rfq) {
            $this->sendRfqEmails($rfq);
            $message = 'Test email sent successfully.';
            $success = true;
        } else {
            $message = 'No RFQ found for testing.';
        }
    } catch (\Exception $e) {
        $message = $e->getMessage();
    }

    // Return Blade view with message
    return view('test-email', compact('message', 'success'));
}

    /**
     * Test validation functionality
     */
    public function testValidation()
    {
        try {
            $testData = [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '1234567890',
                'company_name' => 'Test Company',
                'country' => 'Test Country',
                'address' => 'Test Address',
                'city' => 'Test City',
                'zip_code' => '12345',
                'designation' => 'Test Designation',
                'products' => [
                    [
                        'product_name' => 'Test Product',
                        'qty' => 1
                    ]
                ]
            ];

            $validator = Validator::make($testData, [
                'name' => 'required|string|max:255',
                'email' => 'required|email:rfc,dns',
                'phone' => 'required|string|max:20',
                'company_name' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'address' => 'required|string',
                'city' => 'required|string|max:255',
                'zip_code' => 'required|string|max:20',
                'designation' => 'required|string|max:255',
                'products' => 'required|array|min:1',
                'products.*.product_name' => 'required|string|max:255',
                'products.*.qty' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->toArray()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Validation passed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation test error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Handle image upload for RFQ
     */
    public function uploadImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:5120',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }

            $file = $request->file('image');
            $filePath = 'rfq_products/temp';
            $uploadedFile = Helper::imageUpload($file, $filePath);

            if ($uploadedFile['status'] === 1) {
                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully',
                    'file_path' => $uploadedFile['file_path'],
                    'file_name' => $uploadedFile['file_name']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'File upload failed: ' . ($uploadedFile['error_message'] ?? 'Unknown error')
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Image upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Image upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}