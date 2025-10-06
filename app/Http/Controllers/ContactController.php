<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
  public function store(ContactRequest $request)
{
    try {
        $data = $request->validated();
        
        // Try to get IP, but don't fail if we can't
        try {
            $data['ip_address'] = $request->ip() ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        } catch (Exception $ipException) {
            $data['ip_address'] = 'unknown';
            Log::warning('Could not get client IP: ' . $ipException->getMessage());
        }
        
        $data['status'] = 'pending';

        // Generate unique code if not provided
        if (empty($data['code'])) {
            $data['code'] = uniqid('CONTACT_');
        }

        Contact::create($data);

        return redirect()->back()->with('success', 'Your message has been submitted successfully!');
    } catch (Exception $e) {
        Log::error('Contact form error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}
}
