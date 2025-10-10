<?php

namespace App\Http\Controllers\Rfq;

use App\Models\Rfq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RfqController extends Controller
{
    /**
     * Show the RFQ form
     */
    public function create()
    {
        return view('frontend.pages.rfq.rfq'); 
    }

    /**
     * Store the RFQ request
     */
    public function store(Request $request)
    {
        Log::info('RFQ Store Method Called');
        Log::info('All Request Data:', $request->all());
        Log::info('Contacts Data:', $request->contacts ?? []);

        // Custom validation rules for array fields
        $validationRules = [
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
            
            // Products from repeater - make sure contacts exists and is array
            'contacts' => 'required|array|min:1',
        ];

        // Add dynamic rules for each contact in the array
        if ($request->has('contacts') && is_array($request->contacts)) {
            foreach ($request->contacts as $index => $contact) {
                $validationRules["contacts.{$index}.product_name"] = 'required|string|max:255';
                $validationRules["contacts.{$index}.qty"] = 'required|numeric|min:1';

                // Optional fields
                $validationRules["contacts.{$index}.sku_no"] = 'nullable|string|max:255';
                $validationRules["contacts.{$index}.model_no"] = 'nullable|string|max:255';
                $validationRules["contacts.{$index}.brand_name"] = 'nullable|string|max:255';
                $validationRules["contacts.{$index}.additional_qty"] = 'nullable|numeric|min:0';
                $validationRules["contacts.{$index}.additional_product_name"] = 'nullable|string|max:255';
                $validationRules["contacts.{$index}.product_des"] = 'nullable|string';
                $validationRules["contacts.{$index}.additional_info"] = 'nullable|string';
                $validationRules["contacts.{$index}.image"] = 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240';
            }
        }

        $validator = Validator::make($request->all(), $validationRules, [
            'contacts.required' => 'At least one product is required.',
            'contacts.*.product_name.required' => 'Product name is required for all items.',
            'contacts.*.qty.required' => 'Quantity is required for all items.',
            'contacts.*.qty.numeric' => 'Quantity must be a number.',
            'contacts.*.qty.min' => 'Quantity must be at least 1.',
            'contacts.*.sl.required' => 'SL is required for all items.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            Log::error('RFQ Validation Failed:');
            Log::error('Validation Errors:', $validator->errors()->toArray());
            Log::error('Submitted Data:', $request->all());
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors below.'.$validator->errors());
        }

        Log::info('RFQ Form Data Validated Successfully');

        try {
            // Generate unique codes
            $rfq_code = 'RFQ-' . strtoupper(uniqid());
            $deal_code = 'DEAL-' . strtoupper(uniqid());

            Log::info('Generated RFQ Code: ' . $rfq_code);
            Log::info('Generated Deal Code: ' . $deal_code);

            // Prepare products data from repeater
            $products = [];
            $uploadedFiles = [];

            foreach ($request->contacts as $index => $contact) {
                Log::info("Processing product {$index}:", $contact);

                $productData = [
                    'sl' => $contact['sl'] ?? 'N/A',
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
                if (isset($contact['image']) && $request->hasFile("contacts.{$index}.image")) {
                    try {
                        $file = $request->file("contacts.{$index}.image");
                        if ($file && $file->isValid()) {
                            $fileName = time() . '_' . $index . '_' . preg_replace('/[^A-Za-z0-9\.]/', '', $file->getClientOriginalName());
                            $filePath = $file->storeAs('rfq_files', $fileName, 'public');
                            $productData['image_path'] = $filePath;
                            $uploadedFiles[] = $filePath;
                            Log::info("File uploaded successfully: {$filePath}");
                        }
                    } catch (\Exception $fileException) {
                        Log::error("File upload failed for product {$index}: " . $fileException->getMessage());
                    }
                }

                $products[] = $productData;
                Log::info("Product {$index} processed successfully");
            }

            Log::info('Processed products:', $products);
            Log::info('Uploaded files:', $uploadedFiles);

            // Prepare RFQ data
            $rfqData = [
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

            Log::info('Final RFQ Data to be saved:', $rfqData);

            // Check fillable fields
            $fillableFields = (new Rfq())->getFillable();
            $missingFillable = array_diff(array_keys($rfqData), $fillableFields);
            
            if (!empty($missingFillable)) {
                Log::warning('Missing fillable fields in Rfq model:', $missingFillable);
                // Remove non-fillable fields
                foreach ($missingFillable as $field) {
                    unset($rfqData[$field]);
                }
            }

            // Create the RFQ
            Log::info('Creating RFQ record...');
            $rfq = Rfq::create($rfqData);

            Log::info('RFQ created successfully with ID: ' . $rfq->id);
            Log::info('RFQ Code: ' . $rfq_code);
            Log::info('Deal Code: ' . $deal_code);

            return redirect()->back()
                ->with('success', 'RFQ submitted successfully! Your RFQ code: ' . $rfq_code . ' and Deal code: ' . $deal_code);

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