<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CookiePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CookiePolicyController extends Controller
{
    /**
     * Display a listing of cookie policies
     */
    public function index()
    {
        $policies = CookiePolicy::latest()->paginate(10);
        return view('admin.cookie-policies.index', compact('policies'));
    }

    /**
     * Show the form for creating a new cookie policy
     */
    public function create()
    {
        return view('admin.cookie-policies.create');
    }

    /**
     * Store a newly created cookie policy
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'is_active' => 'sometimes|boolean'
        ], [
            'content.required' => 'The policy content is required.',
            'content.min' => 'The policy content must be at least 10 characters.'
        ]);

        $validated['created_by'] = Auth::id();
        
        // If activating, set published date
        if ($request->has('is_active') && $request->is_active) {
            $validated['published_at'] = now();
        } else {
            $validated['is_active'] = false;
        }

        CookiePolicy::create($validated);

        return redirect()->route('admin.cookie-policies.index')
                         ->with('success', 'Cookie policy created successfully!');
    }

    /**
     * Display the specified cookie policy
     */
    public function show(CookiePolicy $cookiePolicy)
    {
        return view('admin.cookie-policies.show', compact('cookiePolicy'));
    }

    /**
     * Show the form for editing the cookie policy
     */
    public function edit(CookiePolicy $cookiePolicy)
    {
        return view('admin.cookie-policies.edit', compact('cookiePolicy'));
    }

    /**
     * Update the cookie policy
     */
    public function update(Request $request, CookiePolicy $cookiePolicy)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'is_active' => 'sometimes|boolean'
        ]);

        $validated['updated_by'] = Auth::id();

        // If activating for the first time, set published date
        if (!$cookiePolicy->published_at && $request->has('is_active') && $request->is_active) {
            $validated['published_at'] = now();
        }
        
        // If deactivating, keep published_at but mark as inactive
        if ($cookiePolicy->is_active && $request->has('is_active') && !$request->is_active) {
            $validated['is_active'] = false;
        }

        $cookiePolicy->update($validated);

        return redirect()->route('admin.cookie-policies.index')
                         ->with('success', 'Cookie policy updated successfully!');
    }

    /**
     * Remove the cookie policy
     */
    public function destroy(CookiePolicy $cookiePolicy)
    {
        $cookiePolicy->delete();
        
        return redirect()->route('admin.cookie-policies.index')
                         ->with('success', 'Cookie policy deleted successfully!');
    }

    /**
     * Toggle active status via AJAX
     */
    public function toggleStatus(Request $request, CookiePolicy $cookiePolicy)
    {
        $cookiePolicy->update([
            'is_active' => !$cookiePolicy->is_active,
            'updated_by' => Auth::id(),
            'published_at' => !$cookiePolicy->is_active ? now() : $cookiePolicy->published_at
        ]);

        $status = $cookiePolicy->is_active ? 'activated' : 'deactivated';
        
        return response()->json([
            'success' => true,
            'message' => "Cookie policy {$status} successfully.",
            'is_active' => $cookiePolicy->is_active
        ]);
    }

    /**
     * Preview the cookie policy
     */
    public function preview(CookiePolicy $cookiePolicy)
    {
        return view('admin.cookie-policies.preview', compact('cookiePolicy'));
    }
}