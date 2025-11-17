<?php

namespace App\Http\Controllers;

use App\Models\Principal;
use App\Models\ShareLink;
use Illuminate\Http\Request;

class ShareLinkController extends Controller
{
    public function create(Principal $principal)
    {
        $this->authorize('update', $principal);
        
        return view('share-links.create', compact('principal'));
    }

    public function store(Request $request, Principal $principal)
    {
        $this->authorize('update', $principal);

        $validated = $request->validate([
            'expires_at' => 'nullable|date|after:now',
            'masked_fields' => 'array',
            'masked_fields.*' => 'string',
            'allow_copy' => 'boolean',
        ]);

        $shareLink = ShareLink::create([
            'principal_id' => $principal->id,
            'token' => ShareLink::generateToken(),
            'expires_at' => $validated['expires_at'] ?? null,
            'masked_fields' => $validated['masked_fields'] ?? [],
            'allow_copy' => $validated['allow_copy'] ?? false,
        ]);

        return redirect()->route('admin.principals.links.index', $principal)
            ->with('success', 'Share link created successfully.')
            ->with('share_url', route('share.links.show', $shareLink->token));
    }

    public function show($token, Request $request)
    {
        $shareLink = $request->attributes->get('share_link');
        $principal = $shareLink->principal;

        // Apply field masking
        $principal = $this->maskSensitiveFields($principal, $shareLink->masked_fields);

        return view('share-links.show', compact('principal', 'shareLink'));
    }

    public function destroy(Principal $principal, ShareLink $link)
    {
        $this->authorize('update', $principal);
        
        $link->delete();

        return redirect()->back()->with('success', 'Share link deleted successfully.');
    }

    private function maskSensitiveFields($principal, $maskedFields)
    {
        if (empty($maskedFields)) {
            return $principal;
        }

        foreach ($maskedFields as $field) {
            if (isset($principal->$field)) {
                $principal->$field = $this->maskValue($principal->$field);
            }
        }

        return $principal;
    }

    private function maskValue($value)
    {
        if (is_string($value)) {
            $length = strlen($value);
            if ($length <= 2) {
                return str_repeat('*', $length);
            }
            
            $visible = max(1, floor($length * 0.3)); // Show 30% of the value
            return substr($value, 0, $visible) . str_repeat('*', $length - $visible);
        }

        return '***';
    }
}