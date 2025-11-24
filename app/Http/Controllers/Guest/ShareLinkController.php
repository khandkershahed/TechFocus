<?php

namespace App\Http\Controllers;

use App\Models\Admin\ShareLink;
use Illuminate\Http\Request;

class ShareLinkController extends Controller
{
    public function show($token)
    {
        $shareLink = ShareLink::where('token', $token)->firstOrFail();

        if (!$shareLink->isValid()) {
            abort(404, 'This share link has expired or reached its view limit.');
        }

        // Increment view count
        $shareLink->incrementViews();

        $principalData = $shareLink->getMaskedPrincipalData();
        $shareLinkData = $shareLink->only(['allow_download', 'disable_copy']);

        return view('share-links.show', [
            'principal' => (object) $principalData,
            'shareLink' => (object) $shareLinkData,
            'token' => $token
        ]);
    }
}