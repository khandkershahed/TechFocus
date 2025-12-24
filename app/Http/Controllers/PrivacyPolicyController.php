<?php

namespace App\Http\Controllers;

use App\Models\PageBanner;
use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Models\PrivacySection;

class PrivacyPolicyController extends Controller
{
    // Display privacy policy on frontend
       public function index()
    {
        $policy = PrivacyPolicy::where('is_active', true)
            ->with(['sections' => function($query) {
                $query->orderBy('order', 'asc');
            }])
            ->first();

        if (!$policy) {
            // Fallback to default content as an object
            $policy = new \stdClass();
            $policy->title = 'Privacy Policy';
            $policy->content = '<p>No privacy policy available. Please contact the administrator.</p>';
            $policy->sections = collect([]); // Empty collection
        }

        // Get banners for privacy policy page from PageBanner model - EXACTLY LIKE SiteController
        $banners = PageBanner::where('page_name', 'policy')
            ->where('status', 'active')
            ->get();

        return view('privacy-policy.index', compact('policy', 'banners'));
    }
    // Admin Panel Methods

    public function adminIndex()
    {
        $policies = PrivacyPolicy::withCount('sections')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.privacy-policy.index', compact('policies'));
    }

    public function create()
    {
        return view('admin.privacy-policy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'version' => 'nullable|string',
            'effective_date' => 'nullable|date',
        ]);

        // Clean HTML content
        $content = $this->cleanPolicyContent($request->content);

        // Deactivate all other policies
        if ($request->has('is_active') && $request->is_active) {
            PrivacyPolicy::where('is_active', true)->update(['is_active' => false]);
        }

        $policy = PrivacyPolicy::create([
            'title' => $request->title,
            'content' => $content,
            'version' => $request->version,
            'is_active' => $request->has('is_active'),
            'effective_date' => $request->effective_date,
        ]);

        // Create sections if provided
        if ($request->has('sections')) {
            foreach ($request->sections as $index => $section) {
                if (!empty($section['title']) && !empty($section['content'])) {
                    PrivacySection::create([
                        'policy_id' => $policy->id,
                        'section_title' => $section['title'],
                        'section_number' => $section['number'] ?? null,
                        'section_content' => $this->cleanPolicyContent($section['content']),
                        'order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.privacy-policy.index')
            ->with('success', 'Privacy Policy created successfully.');
    }

    public function edit(PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->load('sections');
        return view('admin.privacy-policy.edit', compact('privacyPolicy'));
    }

    public function update(Request $request, PrivacyPolicy $privacyPolicy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'version' => 'nullable|string',
            'effective_date' => 'nullable|date',
        ]);

        // Clean HTML content
        $content = $this->cleanPolicyContent($request->content);

        // Deactivate all other policies if activating this one
        if ($request->has('is_active') && $request->is_active) {
            PrivacyPolicy::where('id', '!=', $privacyPolicy->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $privacyPolicy->update([
            'title' => $request->title,
            'content' => $content,
            'version' => $request->version,
            'is_active' => $request->has('is_active'),
            'effective_date' => $request->effective_date,
        ]);

        // Update sections
        if ($request->has('sections')) {
            // Remove existing sections
            $privacyPolicy->sections()->delete();
            
            // Create new sections
            foreach ($request->sections as $index => $section) {
                if (!empty($section['title']) && !empty($section['content'])) {
                    PrivacySection::create([
                        'policy_id' => $privacyPolicy->id,
                        'section_title' => $section['title'],
                        'section_number' => $section['number'] ?? null,
                        'section_content' => $this->cleanPolicyContent($section['content']),
                        'order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.privacy-policy.index')
            ->with('success', 'Privacy Policy updated successfully.');
    }

    public function destroy(PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->delete();
        
        return redirect()->route('admin.privacy-policy.index')
            ->with('success', 'Privacy Policy deleted successfully.');
    }

    /**
     * Clean HTML content by removing empty paragraphs and unnecessary whitespace
     */
    private function cleanPolicyContent($content)
    {
        if (empty($content)) {
            return $content;
        }

        // Remove empty paragraphs with &nbsp;
        $content = preg_replace('/<p>\s*&nbsp;\s*<\/p>/i', '', $content);
        
        // Remove completely empty paragraphs
        $content = preg_replace('/<p>\s*<\/p>/i', '', $content);
        
        // Remove multiple line breaks
        $content = preg_replace('/\n{3,}/', "\n\n", $content);
        
        // Remove trailing/leading spaces in paragraphs
        $content = preg_replace('/<p>\s*/', '<p>', $content);
        $content = preg_replace('/\s*<\/p>/', '</p>', $content);
        
        // Replace multiple spaces with single space
        $content = preg_replace('/\s{2,}/', ' ', $content);
        
        // Trim the content
        $content = trim($content);
        
        return $content;
    }
}