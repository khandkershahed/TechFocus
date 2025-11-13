<?php
namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrincipalLink;

class PrincipalLinkController extends Controller
{
    // Show form to create a new link
    public function create()
    {
        return view('principal.links.create');
    }

    // Store the shared link
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'url'   => 'required|url|max:255',
        ]);

        auth('principal')->user()->links()->create([
            'label' => $request->label,
            'url' => $request->url,
        ]);

        return redirect()->route('principal.dashboard')->with('success', 'Link shared successfully!');
    }
}
