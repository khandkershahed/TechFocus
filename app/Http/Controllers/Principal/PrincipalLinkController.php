<?php

namespace App\Http\Controllers\Principal;

use Log;
use Illuminate\Http\Request;
use App\Models\PrincipalLink;
use App\Models\ShareToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
 use App\Mail\ShareLinkMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PrincipalLinkController extends Controller
{
    public function index()
    {
        $links = PrincipalLink::where('principal_id', auth('principal')->id())
            ->latest()
            ->paginate(10);

        return view('principal.links.index', compact('links'));
    }

    public function create()
    {
        $types = ['Social', 'Marketing', 'Internal', 'Other'];
        return view('principal.links.create', compact('types'));
    }

    public function store(Request $request)
    {
        // Debug: Check what's coming in the request
        \Log::info('Request data:', $request->all());
        \Log::info('Files:', $request->file() ?: []);

        // Validate the main structure
        $request->validate([
            'links' => 'required|array|min:1',
            'links.*.label' => 'required|string|max:255',
            'links.*.url' => 'required|url|max:255',
            'links.*.type' => 'nullable|string|max:50',
            'links.*.files' => 'nullable|array',
            'links.*.files.*' => 'file|max:2048', // 2MB max per file
        ]);

        $labels = [];
        $urls = [];
        $types = [];
        $files = [];

        foreach ($request->links as $index => $linkData) {
            // Store basic data
            $labels[$index] = $linkData['label'];
            $urls[$index] = $linkData['url'];
            $types[$index] = $linkData['type'] ?? 'Other';

            // Handle file uploads for this row
            $uploadedFiles = [];
            
            if (isset($linkData['files']) && is_array($linkData['files'])) {
                foreach ($linkData['files'] as $file) {
                    if ($file && $file->isValid()) {
                        try {
                            $path = $file->store('principal_files', 'public');
                            $uploadedFiles[] = $path;
                            \Log::info("File stored: " . $path);
                        } catch (\Exception $e) {
                            \Log::error("File upload failed: " . $e->getMessage());
                        }
                    }
                }
            }
            
            $files[$index] = $uploadedFiles;
        }

        \Log::info('Final data to store:', [
            'labels' => $labels,
            'urls' => $urls,
            'types' => $types,
            'files' => $files
        ]);

        // Store in database
        try {
            PrincipalLink::create([
                'principal_id' => auth('principal')->id(),
                'label' => $labels,
                'url' => $urls,
                'type' => $types,
                'file' => $files,
            ]);

            Log::info('Database record created successfully');

        } catch (\Exception $e) {
            \Log::error('Database error: ' . $e->getMessage());
            return back()->with('error', 'Failed to save links: ' . $e->getMessage());
        }

        return redirect()->route('principal.links.index')
                         ->with('success', 'Links shared successfully!');
    }

    public function edit($id)
    {
        $link = PrincipalLink::where('id', $id)
            ->where('principal_id', auth('principal')->id())
            ->firstOrFail();

        $types = ['Social', 'Marketing', 'Internal', 'Other'];

        return view('principal.links.edit', compact('link', 'types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'links' => 'required|array|min:1',
            'links.*.label' => 'required|string|max:255',
            'links.*.url' => 'required|url|max:255',
            'links.*.type' => 'nullable|string|max:50',
            'links.*.files' => 'nullable|array',
            'links.*.files.*' => 'file|max:2048',
        ]);

        $link = PrincipalLink::where('id', $id)
            ->where('principal_id', auth('principal')->id())
            ->firstOrFail();

        $labels = [];
        $urls = [];
        $types = [];
        $files = $link->file ?? [];

        foreach ($request->links as $index => $linkData) {
            $labels[$index] = $linkData['label'];
            $urls[$index] = $linkData['url'];
            $types[$index] = $linkData['type'] ?? 'Other';

            // Handle new file uploads
            if (isset($linkData['files']) && is_array($linkData['files'])) {
                $files[$index] = $files[$index] ?? [];
                foreach ($linkData['files'] as $file) {
                    if ($file && $file->isValid()) {
                        $path = $file->store('principal_files', 'public');
                        $files[$index][] = $path;
                    }
                }
            }
        }

        $link->update([
            'label' => $labels,
            'url' => $urls,
            'type' => $types,
            'file' => $files,
        ]);

        return redirect()->route('principal.links.index')
                         ->with('success', 'Links updated successfully!');
    }

    public function destroy($id)
    {
        $link = PrincipalLink::where('id', $id)
            ->where('principal_id', auth('principal')->id())
            ->firstOrFail();

        // Delete files
        if ($link->file) {
            foreach ($link->file as $rowFiles) {
                foreach ($rowFiles as $filepath) {
                    Storage::disk('public')->delete($filepath);
                }
            }
        }

        $link->delete();

        return redirect()->route('principal.links.index')
                         ->with('success', 'Link deleted successfully.');
    }

    // SHARE METHODS - ADD THESE
public function generateShare(Request $request)
{
    \Log::info('Generate Share Request:', $request->all());

    try {
        // Define base validation rules
        $rules = [
            'link_id' => 'required|exists:principal_links,id',
            'expiry' => 'required|in:7,30,custom',
            'mask_fields' => 'sometimes|boolean',
            'watermark' => 'sometimes|boolean',
            'disable_copy_print' => 'sometimes|boolean',
            'allow_downloads' => 'sometimes|boolean',
        ];

        // Add conditional rule for custom expiry date
        if ($request->expiry === 'custom') {
            $rules['custom_expiry_date'] = 'required|date|after:today';
        } else {
            $rules['custom_expiry_date'] = 'nullable|date'; // Make it optional but still validate if provided
        }

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $link = PrincipalLink::where('id', $request->link_id)
            ->where('principal_id', auth('principal')->id())
            ->firstOrFail();

        // Calculate expiry - FIX: Convert expiry to integer
        if ($request->expiry === 'custom') {
            $expiresAt = Carbon::parse($request->custom_expiry_date);
        } else {
            $expiresAt = now()->addDays((int) $request->expiry); // Convert string to integer
        }

        \Log::info('Expiry calculation:', [
            'expiry_type' => $request->expiry,
            'expires_at' => $expiresAt,
            'days' => $request->expiry
        ]);

        // Create share token
        $shareToken = ShareToken::create([
            'principal_link_id' => $link->id,
            'principal_id' => auth('principal')->id(),
            'expires_at' => $expiresAt,
            'settings' => [
                'mask_fields' => (bool) $request->mask_fields,
                'watermark' => (bool) $request->watermark,
                'disable_copy_print' => (bool) $request->disable_copy_print,
                'allow_downloads' => (bool) ($request->allow_downloads ?? false),
            ]
        ]);

        $shareUrl = route('shared.link.view', $shareToken->token);

        \Log::info('Share token created successfully:', [
            'token_id' => $shareToken->id,
            'share_url' => $shareUrl
        ]);

        return response()->json([
            'success' => true,
            'share_url' => $shareUrl,
            'message' => 'Share link created successfully!'
        ]);

    } catch (\Exception $e) {
        \Log::error('Exception in generateShare: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

    public function viewSharedLink($token)
    {
        $shareToken = ShareToken::with('principalLink')
            ->where('token', $token)
            ->firstOrFail();

        if ($shareToken->isExpired()) {
            abort(410, 'This shared link has expired.');
        }

        // Increment view count
        $shareToken->incrementViewCount();

        $settings = $shareToken->settings ?? [];

        return view('shared.link-view', [
            'link' => $shareToken->principalLink,
            'shareToken' => $shareToken,
            'settings' => $settings
        ]);
    }

    public function sharedLinks()
    {
        $shareTokens = ShareToken::with('principalLink')
            ->where('principal_id', auth('principal')->id())
            ->latest()
            ->paginate(10);

        return view('principal.links.shared', compact('shareTokens'));
    }

    public function revokeShare($tokenId)
    {
        $shareToken = ShareToken::where('id', $tokenId)
            ->where('principal_id', auth('principal')->id())
            ->firstOrFail();

        $shareToken->delete();

        return redirect()->route('principal.links.shared')
                         ->with('success', 'Share link revoked successfully.');
    }


public function sendShareEmail(Request $request)
{
    $request->validate([
        'emails' => 'required|array',
        'emails.*' => 'required|email',
        'share_url' => 'required|url',
        'expires_at' => 'required|date',
    ]);

    try {
        $expiresAt = Carbon::parse($request->expires_at);
        $senderName = auth('principal')->user()->name ?? 'Principal';

        foreach ($request->emails as $email) {
            Mail::to($email)->send(new ShareLinkMail(
                $request->share_url,
                $expiresAt,
                $senderName
            ));
        }

        return response()->json([
            'success' => true,
            'message' => 'Emails sent successfully!'
        ]);

    } catch (\Exception $e) {
        \Log::error('Error sending share emails: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to send emails: ' . $e->getMessage()
        ], 500);
    }
}
}