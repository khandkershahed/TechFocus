<?php

namespace App\Http\Controllers\Principal;

use Log;
use Illuminate\Http\Request;
use App\Models\PrincipalLink;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
}
