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
        // Example types (customizable)
        $types = ['Social', 'Marketing', 'Internal', 'Other'];
        return view('principal.links.create', compact('types'));
    }

    // Store the shared link
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|array',         // multiple labels
            'label.*' => 'required|string|max:255',
            'url'   => 'required|array',         // multiple URLs
            'url.*' => 'required|url|max:255',
            'type'  => 'nullable|array',         // multiple types
            'type.*'=> 'string|max:50',
        ]);

        auth('principal')->user()->links()->create([
            'label' => $request->label,   // stored as JSON
            'url'   => $request->url,     // stored as JSON
            'type'  => $request->type,    // stored as JSON
        ]);

        return redirect()->route('principal.dashboard')->with('success', 'Link shared successfully!');
    }
}
