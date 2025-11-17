<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ShareLink;

class ShareLinkAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->route('token');
        $shareLink = ShareLink::where('token', $token)->first();

        if (!$shareLink || $shareLink->isExpired()) {
            abort(404, 'Link not found or expired');
        }

        // Increment view count
        $shareLink->incrementViewCount();

        // Share link data to controller
        $request->attributes->set('share_link', $shareLink);

        return $next($request);
    }
}