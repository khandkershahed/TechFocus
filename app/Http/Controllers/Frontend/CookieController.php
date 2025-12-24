<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CookiePolicy;
use App\Models\CookieConsent;
use App\Models\PageBanner; // Add this import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    /**
     * Get active cookie policy
     */
    private function getActivePolicy()
    {
        return CookiePolicy::active()->first();
    }

    /**
     * Get banners for cookie pages
     */
    private function getCookieBanners()
    {
        // Try to get banners for cookies page
        $banners = PageBanner::where('page_name', 'cookies')
            ->where('status', 'active')
            ->get();

        // If no cookies banners, try policy banners as fallback
        if ($banners->isEmpty()) {
            $banners = PageBanner::where('page_name', 'policy')
                ->where('status', 'active')
                ->get();
        }

        // If still no banners, get any active banner
        if ($banners->isEmpty()) {
            $banners = PageBanner::where('status', 'active')->get();
        }

        return $banners;
    }

    /**
     * Show cookie policy page with banners
     */
    public function showPolicy()
    {
        $policy = $this->getActivePolicy();
        $banners = $this->getCookieBanners();

        if (!$policy) {
            // If no active policy, show a default message
            return view('cookie-policy', [
                'policy' => (object)[
                    'title' => 'Cookie Policy',
                    'content' => '<p>No active cookie policy found. Please contact the administrator.</p>',
                    'updated_at' => now()
                ],
                'banners' => $banners
            ]);
        }

        return view('cookie-policy', compact('policy', 'banners'));
    }

    /**
     * Show cookie management page with banners
     */
    public function manage(Request $request)
    {
        $policy = $this->getActivePolicy();
        $banners = $this->getCookieBanners();
        
        if (!$policy) {
            abort(404, 'No active cookie policy found.');
        }

        $ipAddress = $request->ip();
        
        // Get user's current preferences
        $currentConsent = CookieConsent::where('ip_address', $ipAddress)
            ->where('accepted', true)
            ->latest()
            ->first();
        
        $preferences = $currentConsent ? $currentConsent->preferences : [
            'necessary' => true,
            'analytics' => false,
            'marketing' => false
        ];

        return view('cookies.manage', compact('policy', 'banners', 'preferences'));
    }

    /**
     * Save cookie preferences from management page
     */
    public function savePreferences(Request $request)
    {
        $request->validate([
            'analytics' => 'sometimes|boolean',
            'marketing' => 'sometimes|boolean'
        ]);

        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');
        
        $preferences = [
            'necessary' => true, // Always required
            'analytics' => $request->input('analytics', false),
            'marketing' => $request->input('marketing', false)
        ];

        // Determine if any optional cookies are accepted
        $accepted = $preferences['analytics'] || $preferences['marketing'];

        // Save to database
        $consent = CookieConsent::create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'consent_token' => CookieConsent::generateToken(),
            'preferences' => $preferences,
            'accepted' => $accepted,
            'consented_at' => now()
        ]);

        // Set cookies
        $response = redirect()->route('manage.cookies')
            ->with('success', 'Your cookie preferences have been saved successfully.');

        // Set consent cookie
        $response->cookie('cookie_consent_accepted', $consent->consent_token, 525600);

        // Set or remove category cookies
        if ($preferences['analytics']) {
            $response->cookie('cookie_analytics', 'true', 525600);
        } else {
            $response->cookie(Cookie::forget('cookie_analytics'));
        }
        
        if ($preferences['marketing']) {
            $response->cookie('cookie_marketing', 'true', 525600);
        } else {
            $response->cookie(Cookie::forget('cookie_marketing'));
        }

        return $response;
    }

    /**
     * Check if user needs to see cookie banner
     */
    public function checkConsent(Request $request)
    {
        $ipAddress = $request->ip();
        
        // Check database for existing consent
        $hasDatabaseConsent = CookieConsent::where('ip_address', $ipAddress)
            ->where('accepted', true)
            ->exists();
        
        // Check browser cookie
        $hasCookieConsent = $request->cookie('cookie_consent_accepted');
        
        // Only show banner if no consent exists
        $showBanner = !$hasDatabaseConsent && !$hasCookieConsent;
        
        return response()->json([
            'show_banner' => $showBanner,
            'has_consent' => $hasDatabaseConsent || $hasCookieConsent,
            'ip_address' => $ipAddress
        ]);
    }

    /**
     * Handle cookie consent submission
     */
    public function storeConsent(Request $request)
    {
        $request->validate([
            'accepted' => 'required|boolean',
            'preferences' => 'nullable|array',
            'preferences.necessary' => 'required|boolean',
            'preferences.analytics' => 'sometimes|boolean',
            'preferences.marketing' => 'sometimes|boolean'
        ]);

        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        // Store consent in database
        $consent = CookieConsent::create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'consent_token' => CookieConsent::generateToken(),
            'preferences' => $request->preferences,
            'accepted' => $request->accepted,
            'consented_at' => now()
        ]);

        // Set browser cookie (expires in 1 year)
        if ($request->accepted) {
            $cookie = Cookie::make(
                'cookie_consent_accepted',
                $consent->consent_token,
                525600 // 1 year in minutes
            );
            
            // Also set category-specific cookies if needed
            if (isset($request->preferences['analytics']) && $request->preferences['analytics']) {
                Cookie::queue('cookie_analytics', 'true', 525600);
            }
            
            if (isset($request->preferences['marketing']) && $request->preferences['marketing']) {
                Cookie::queue('cookie_marketing', 'true', 525600);
            }
        } else {
            // If rejected, set a cookie to remember the rejection
            $cookie = Cookie::make(
                'cookie_consent_accepted',
                'rejected',
                525600
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Cookie preferences saved successfully.',
            'consent_id' => $consent->id,
            'accepted' => $request->accepted
        ])->withCookie($cookie);
    }

    /**
     * Get current consent status from database
     */
    public function getStatus(Request $request)
    {
        try {
            $ipAddress = $request->ip();
            
            // Check database for existing consent
            $consent = CookieConsent::where('ip_address', $ipAddress)
                ->where('accepted', true)
                ->latest()
                ->first();
            
            $hasConsent = !empty($consent);
            $preferences = $hasConsent ? $consent->preferences : null;
            
            return response()->json([
                'has_consent' => $hasConsent,
                'preferences' => $preferences,
                'consent_id' => $hasConsent ? $consent->id : null,
                'consented_at' => $hasConsent ? $consent->consented_at : null,
                'ip_address' => $ipAddress
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error checking cookie status: ' . $e->getMessage());
            
            return response()->json([
                'has_consent' => false,
                'preferences' => null,
                'error' => 'Failed to check consent status'
            ], 500);
        }
    }
}