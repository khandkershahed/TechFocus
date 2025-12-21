<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductRequestController extends Controller
{
    /**
     * Show the product request form
     */
    public function showRequestForm()
    {
        return view('frontend.pages.product-request');
    }

    /**
     * Handle product request submission
     */
    public function submitRequest(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'product_description' => 'required|string|min:10',
            'quantity' => 'required|integer|min:1',
            'delivery_time' => 'nullable|string|in:urgent,standard,flexible,not_sure',
            'additional_info' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // For now, we'll just return success message
            return redirect()->route('product.request.form')
                ->with('success', 'Your product request has been submitted successfully! Our sales team will contact you within 24 hours.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong. Please try again later.')
                ->withInput();
        }
    }
}