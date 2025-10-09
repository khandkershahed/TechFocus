<?php

namespace App\Http\Controllers\Rfq;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Container\Attributes\Log;
use App\Models\Rfq; // Updated namespace

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
    // Validate the incoming request
    $validated = $request->validate([
        'conceptTermId' => 'required|string',
        'info' => 'required|string|min:300',
        'quantity' => 'required|numeric|min:1',
        'budget' => 'required|string',
        'delivery_city' => 'required|string',
        'decision_period' => 'required|numeric|min:1',
        'email' => 'required|email',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'company_name' => 'required|string',
        'phone' => 'required|string',
        'city' => 'required|string',
    ]);

    // Generate unique codes
    $rfq_code = 'RFQ-' . strtoupper(uniqid());
    $deal_code = 'DEAL-' . strtoupper(uniqid());

    \Log::info('RFQ Form Data Received:', $request->all());

    try {
        // Store the RFQ using your actual table structure
        $rfqData = [
            'rfq_code' => $rfq_code,
            'deal_code' => $deal_code,
            'user_id' => Auth::id(),
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'city' => $request->city,
            'delivery_location' => $request->delivery_city,
            'budget' => $request->budget,
            'qty' => $request->quantity,
            'message' => $request->info,
            'rfq_type' => 'rfq', // Fixed typo: was 'rfa_type'
            'client_type' => Auth::id() ? 'client' : 'anonymous',
            'create_date' => now(),
            'project_status' => 'pending',
        ];

        \Log::info('Attempting to create RFQ with data:', $rfqData);

        $rfq = Rfq::create($rfqData);

        \Log::info('RFQ created successfully with ID: ' . $rfq->id);

        return redirect()->back()->with('success', 'RFQ submitted successfully! Your RFQ code: ' . $rfq_code);

    } catch (\Exception $e) { // Fixed: removed extra parenthesis
        \Log::error('RFQ Store Error: ' . $e->getMessage()); // Fixed: proper concatenation
        \Log::error('Error Trace: ' . $e->getTraceAsString()); // Fixed: proper concatenation
        \Log::error('Request Data: ', $request->all());

        return redirect()->back()->with('error', 'Error submitting RFQ. Please try again. Error: ' . $e->getMessage()); // Fixed: proper concatenation
    }
}
}