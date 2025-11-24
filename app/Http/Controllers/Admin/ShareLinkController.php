<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Principal;
use App\Models\Admin\ShareLink;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ShareLinkController extends Controller
{
    public function __construct()
    {
        // Only users with 'share principals' permission can access
        // $this->middleware('permission:share principals');
    }

    public function create($principalId)
    {
        $principal = Principal::findOrFail($principalId);
        
        return view('admin.principals.share-link.create', compact('principal'));
    }

    public function store(Request $request, $principalId)
    {
        $principal = Principal::findOrFail($principalId);

        $request->validate([
            'allowed_fields' => 'required|array',
            'allowed_fields.*' => 'string',
            'masked_fields' => 'sometimes|array',
            'expires_at' => 'required|date|after:now',
            'max_views' => 'nullable|integer|min:1',
            'allow_download' => 'boolean',
            'disable_copy' => 'boolean',
        ]);

        // Use the correct guard for admin authentication
        $userId = Auth::guard('admin')->id();

        if (!$userId) {
            return redirect()->back()
                ->with('error', 'You must be logged in as an admin to create share links.')
                ->withInput();
        }

        $shareLink = ShareLink::create([
            'principal_id' => $principal->id,
            'token' => ShareLink::generateToken(),
            'allowed_fields' => $request->allowed_fields,
            'masked_fields' => $request->masked_fields ?? [],
            'expires_at' => Carbon::parse($request->expires_at),
            'max_views' => $request->max_views,
            'allow_download' => $request->boolean('allow_download', false),
            'disable_copy' => $request->boolean('disable_copy', true),
            'created_by' => $userId, // Use the authenticated admin user ID
        ]);

        $shareableUrl = route('guest.share-links.show', $shareLink->token);

        return redirect()->route('admin.principals.show', $principal->id)
            ->with('success', 'Share link created successfully!')
            ->with('shareable_url', $shareableUrl);
    }

    public function index($principalId)
    {
        $principal = Principal::findOrFail($principalId);
        $shareLinks = $principal->shareLinks()->latest()->get();

        return view('admin.principals.share-link.index', compact('principal', 'shareLinks'));
    }

    public function destroy($principalId, $shareLinkId)
    {
        $shareLink = ShareLink::where('principal_id', $principalId)->findOrFail($shareLinkId);
        $shareLink->delete();

        return redirect()->back()->with('success', 'Share link deleted successfully.');
    }

      public function show($token)
    {
        $shareLink = ShareLink::where('token', $token)->firstOrFail();

        // Check if share link is valid
        if (!$shareLink->isValid()) {
            abort(404, 'This share link has expired or reached its view limit.');
        }

        // Increment view count
        $shareLink->incrementViews();

        $principalData = $shareLink->getMaskedPrincipalData();
        $shareLinkData = $shareLink->only(['allow_download', 'disable_copy']);

        return view('guest.share-links.show', [
            'principal' => (object) $principalData,
            'shareLink' => (object) $shareLinkData,
            'token' => $token
        ]);
    }

        public function copyLink($principalId, $shareLinkId)
    {
        $shareLink = ShareLink::where('principal_id', $principalId)->findOrFail($shareLinkId);
        $shareableUrl = route('guest.share-links.show', $shareLink->token);

        return response()->json([
            'success' => true,
            'url' => $shareableUrl,
            'message' => 'Link copied to clipboard!'
        ]);
    }



}