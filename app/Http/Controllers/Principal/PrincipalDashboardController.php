<?php
namespace App\Http\Controllers\Principal;

use App\Models\Admin\Brand;
use Illuminate\Support\Facades\Storage;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PrincipalDashboardController extends Controller
{ 
    public function index()
    {
        $principalId = Auth::guard('principal')->id();
        $principal = auth('principal')->user();

        // Eager load related tables
        $principal->load(['contacts', 'addresses', 'links']);

        $brands = Brand::where('principal_id', $principalId)->latest()->get();
        $products = Product::where('principal_id', $principalId)->latest()->get();

        $stats = [
            // Brand stats
            'total_brands' => $brands->count(),
            'approved_brands' => $brands->where('status', 'approved')->count(),
            'pending_brands' => $brands->where('status', 'pending')->count(),
            'rejected_brands' => $brands->where('status', 'rejected')->count(),

            // Product stats
            'total_products' => $products->count(),
            'approved_products' => $products->where('submission_status', 'approved')->count(),
            'pending_products' => $products->where('submission_status', 'pending')->count(),
            'rejected_products' => $products->where('submission_status', 'rejected')->count(),
        ];

        // Transform links so each label/url pair is an object
        $principal->links->transform(function($link) {
            // Decode JSON if stored as JSON
            $link->label = is_string($link->label) ? json_decode($link->label, true) : $link->label;
            $link->url   = is_string($link->url) ? json_decode($link->url, true) : $link->url;
            $link->type  = is_string($link->type) ? json_decode($link->type, true) : $link->type;
            return $link;
        });

        // return view('principal.dashboard', compact('stats', 'brands', 'products', 'principal'));
        // Get recent activities for the timeline
    $activities = Activity::where('principal_id', $principal->id)
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get();

    // Calculate last activity dynamically
    $lastActivity = Activity::where('principal_id', $principal->id)
        ->orderBy('created_at', 'desc')
        ->first();

    return view('principal.dashboard', compact(
        'stats', 
        'brands', 
        'products', 
        'principal', 
        'activities',
        'lastActivity'
    ));
    }

public function storeNote(Request $request)
{
    $request->validate([
        'note' => 'required|string|max:2000',
        'type' => 'required|string|in:note,important,task',
        'pin' => 'nullable|boolean',
        'attachments' => 'nullable|array',
        'attachments.*.file' => 'nullable|file|max:10240', // 10MB
        'attachments.*.url' => 'nullable|url',
        'attachments.*.name' => 'nullable|string|max:255',
    ]);

    $principal = Auth::guard('principal')->user();

    try {
        $metadata = [
            'is_note' => true,
            'created_via' => 'dashboard'
        ];

        // Handle attachments
        $attachmentsData = [];
        if ($request->has('attachments')) {
            foreach ($request->attachments as $attachment) {
                if (isset($attachment['file']) && $attachment['file']->isValid()) {
                    // Store file
                    $path = $attachment['file']->store('activities/attachments', 'public');
                    $attachmentsData[] = [
                        'type' => 'file',
                        'name' => $attachment['name'] ?? $attachment['file']->getClientOriginalName(),
                        'url' => Storage::url($path),
                        'size' => $attachment['file']->getSize(),
                    ];
                } elseif (isset($attachment['url'])) {
                    // Store link
                    $attachmentsData[] = [
                        'type' => 'link',
                        'name' => $attachment['name'] ?? 'Link',
                        'url' => $attachment['url'],
                    ];
                }
            }
            
            if (!empty($attachmentsData)) {
                $metadata['attachments'] = $attachmentsData;
            }
        }

        // Create activity record
        $activity = Activity::create([
            'principal_id' => $principal->id,
            'type' => $request->type,
            'description' => $request->note,
            'rich_content' => $request->note,
            'created_by_id' => $principal->id,
            'created_by_type' => 'App\Models\Principal',
            'pinned' => $request->boolean('pin', false),
            'metadata' => $metadata
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note added successfully!',
            'activity' => $activity
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to save note: ' . $e->getMessage()
        ], 500);
    }
}
public function updateNote(Request $request, Activity $activity)
{
    $principal = Auth::guard('principal')->user();
    
    // Debug: Log the incoming request data
    \Log::info('Update Note Request Data:', [
        'all_data' => $request->all(),
        'note' => $request->note,
        'type' => $request->type,
        'pin' => $request->pin,
        'activity_id' => $activity->id,
        'principal_id' => $principal->id
    ]);

    // Check if the activity belongs to the principal
    if ($activity->principal_id !== $principal->id) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access to note.'
        ], 403);
    }

    // Debug: Check if fields are present
    if (!$request->has('note')) {
        \Log::error('Note field is missing in request');
    }
    if (!$request->has('type')) {
        \Log::error('Type field is missing in request');
    }

    $request->validate([
        'note' => 'required|string|max:2000',
        'type' => 'required|string|in:note,important,task',
        'pin' => 'nullable|boolean',
    ]);

    try {
        $activity->update([
            'type' => $request->type,
            'description' => $request->note,
            'rich_content' => $request->note,
            'pinned' => $request->boolean('pin', false),
            'metadata' => array_merge($activity->metadata ?? [], [
                'last_edited_at' => now()->toISOString(),
                'edited_via' => 'dashboard'
            ])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note updated successfully!',
            'activity' => $activity
        ]);

    } catch (\Exception $e) {
        \Log::error('Update Note Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to update note: ' . $e->getMessage()
        ], 500);
    }
}

public function deleteNote(Activity $activity)
{
    $principal = Auth::guard('principal')->user();
    
    // Check if the activity belongs to the principal
    if ($activity->principal_id !== $principal->id) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access to note.'
        ], 403);
    }

    try {
        $activity->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete note: ' . $e->getMessage()
        ], 500);
    }
}

public function togglePin(Activity $activity)
{
    $principal = Auth::guard('principal')->user();
    
    // Check if the activity belongs to the principal
    if ($activity->principal_id !== $principal->id) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access to note.'
        ], 403);
    }

    try {
        $activity->update([
            'pinned' => !$activity->pinned
        ]);

        return response()->json([
            'success' => true,
            'message' => $activity->pinned ? 'Note pinned!' : 'Note unpinned!',
            'activity' => $activity
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to update note: ' . $e->getMessage()
        ], 500);
    }
}

public function getActivities()
{
    $principal = Auth::guard('principal')->user();
    
    $activities = Activity::where('principal_id', $principal->id)
        ->orderBy('pinned', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($activities);
}

public function getNote($activityId)
{
    try {
        $principal = Auth::guard('principal')->user();
        
        // Find the activity
        $activity = Activity::find($activityId);
        
        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found.'
            ], 404);
        }
        
        // Check if the activity belongs to the principal
        if ($activity->principal_id !== $principal->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to note.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'activity' => $activity
        ]);

    } catch (\Exception $e) {
        \Log::error('Error fetching note: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error fetching note: ' . $e->getMessage()
        ], 500);
    }
}
}

