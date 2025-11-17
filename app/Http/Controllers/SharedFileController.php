<?php

namespace App\Http\Controllers;

use App\Models\ShareToken;
use Illuminate\Http\Request;
use App\Models\PrincipalLink;

use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Storage;

class SharedFileController extends Controller
{
    
//     public function generateShare(Request $request)
// {
//     $request->validate([
//         'link_id' => 'required|exists:principal_links,id',
//         'expiry' => 'required|in:7,30,custom',
//         'custom_expiry_date' => 'required_if:expiry,custom|date|after:today',
//         'mask_fields' => 'boolean',
//         'watermark' => 'boolean',
//         'disable_copy_print' => 'boolean',
//         'allow_downloads' => 'boolean',
//     ]);

//     $link = PrincipalLink::where('id', $request->link_id)
//         ->where('principal_id', auth('principal')->id())
//         ->firstOrFail();

//     // Calculate expiry
//     if ($request->expiry === 'custom') {
//         $expiresAt = \Carbon\Carbon::parse($request->custom_expiry_date);
//     } else {
//         $expiresAt = now()->addDays($request->expiry);
//     }

//     // Create share token
//     $shareToken = ShareToken::create([
//         'principal_link_id' => $link->id,
//         'principal_id' => auth('principal')->id(),
//         'expires_at' => $expiresAt,
//         'settings' => [
//             'mask_fields' => $request->boolean('mask_fields'),
//             'watermark' => $request->boolean('watermark'),
//             'disable_copy_print' => $request->boolean('disable_copy_print'),
//             'allow_downloads' => $request->boolean('allow_downloads'),
//         ]
//     ]);

//     $shareUrl = route('shared.link.view', $shareToken->token);

//     return response()->json([
//         'success' => true,
//         'share_url' => $shareUrl,
//     ]);
// }


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


  public function download($token, $filename)
    {
        $shareToken = ShareToken::with('principalLink')
            ->where('token', $token)
            ->firstOrFail();

        if ($shareToken->isExpired()) {
            abort(410, 'This shared link has expired.');
        }

        $settings = $shareToken->settings ?? [];
        if (!($settings['allow_downloads'] ?? false)) {
            abort(403, 'Downloads are not allowed for this shared link.');
        }

        // Find the file in the principal link
        $filePath = null;
        foreach ($shareToken->principalLink->file ?? [] as $fileArray) {
            foreach ($fileArray as $file) {
                if (basename($file) === $filename) {
                    $filePath = $file;
                    break 2;
                }
            }
        }

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($filePath, $filename);
    } 
}
