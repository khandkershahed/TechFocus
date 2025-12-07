<?php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\MovementRecord;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\EmployeeDepartment;


class MovementRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = MovementRecord::with('admin')->orderBy('date', 'desc')->paginate(10);
        return view('admin.pages.movement.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get current logged-in admin
        $currentAdmin = auth('admin')->user();
        return view('admin.pages.movement.form', compact('currentAdmin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'status' => 'nullable|string',
            'date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'duration' => 'nullable',
            'area' => 'nullable|string',
            'transport' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'meeting_type' => 'nullable|string',
            'company' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'value' => 'nullable|numeric|min:0',
            'value_status' => 'nullable|string',
            'purpose' => 'nullable|string',
            'comments' => 'nullable|string',
        ]);

        // Auto-calculate duration if start_time and end_time are provided
        if ($request->start_time && $request->end_time) {
            $start = \Carbon\Carbon::parse($request->start_time);
            $end = \Carbon\Carbon::parse($request->end_time);
            $validated['duration'] = $start->diff($end)->format('%H:%I:%S');
        }

        // Set admin_id from authenticated admin
        $validated['admin_id'] = auth('admin')->id();

        MovementRecord::create($validated);

       return redirect()->route('admin.movement.index')
     ->with('success', 'Movement record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = MovementRecord::with('admin')->findOrFail($id);
        return view('admin.pages.movement.show', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = MovementRecord::with('admin')->findOrFail($id);
        $currentAdmin = auth('admin')->user();
        return view('admin.pages.movement.form', compact('record', 'currentAdmin'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $movementRecord = MovementRecord::findOrFail($id);
        
    //     $validated = $request->validate([
    //         'status' => 'nullable|string',
    //         'date' => 'nullable|date',
    //         'start_time' => 'nullable',
    //         'end_time' => 'nullable',
    //         'duration' => 'nullable',
    //         'area' => 'nullable|string',
    //         'transport' => 'nullable|string',
    //         'cost' => 'nullable|numeric|min:0',
    //         'meeting_type' => 'nullable|string',
    //         'company' => 'nullable|string',
    //         'contact_person' => 'nullable|string',
    //         'contact_number' => 'nullable|string',
    //         'value' => 'nullable|numeric|min:0',
    //         'value_status' => 'nullable|string',
    //         'purpose' => 'nullable|string',
    //         'comments' => 'nullable|string',
    //     ]);

    //     // Auto-calculate duration if start_time and end_time are provided
    //     if ($request->start_time && $request->end_time) {
    //         $start = \Carbon\Carbon::parse($request->start_time);
    //         $end = \Carbon\Carbon::parse($request->end_time);
    //         $validated['duration'] = $start->diff($end)->format('%H:%I:%S');
    //     }

    //     $movementRecord->update($validated);

    //     return redirect()->route('admin.movement.index')
    //         ->with('success', 'Movement record updated successfully.');
    // }
 public function update(Request $request, $id)
    {
          $movement = MovementRecord::findOrFail($id);
    
    // If user is requesting edit permission
    if ($request->has('request_manual_edit') && $request->input('request_manual_edit') == '1') {
        $movement->update([
            'edit_status' => 'pending',
            'edit_requested_by' => Auth::guard('admin')->id(),
            'edit_requested_at' => now(),
            'edit_request_reason' => $request->input('edit_reason', 'User requested edit permission'),
        ]);
        
        return redirect()->back()
            ->with('success', 'Edit request submitted successfully!')
            ->with('pending_approval', 'Your edit request is pending admin approval.');
    }
        
        // Check if user can edit
        if (!$movement->can_edit) {
            return redirect()->back()
                ->with('error', 'You do not have permission to edit this record.');
        }
        
        // If user is updating the record (after approval)
        $validated = $request->validate([
            'country_id' => 'nullable|exists:countries,id',
            'date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'meeting_type' => 'nullable|in:follow-up,meeting,presentation,negotiation,site-visit',
            'company' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'purpose' => 'required|string',
            'area' => 'nullable|string|max:255',
            'transport' => 'nullable|in:car,train,bus,flight,taxi,walking',
            'cost' => 'nullable|numeric|min:0',
            'value' => 'nullable|numeric|min:0',
            'value_status' => 'nullable|in:pending,negotiating,closed,lost',
            'comments' => 'nullable|string',
        ]);
        
        // Calculate duration
        if ($request->start_time && $request->end_time) {
            $start = \Carbon\Carbon::parse($request->start_time);
            $end = \Carbon\Carbon::parse($request->end_time);
            $validated['duration'] = $start->diff($end)->format('%H:%I:%S');
        }
        
        $movement->update($validated);
        
        // Reset edit status if this was an approved edit
        if ($movement->edit_status == 'approved') {
            $movement->update([
                'edit_status' => null,
                'edit_requested_by' => null,
                'edit_requested_at' => null,
                'edit_approved_by' => null,
                'edit_approved_at' => null,
            ]);
        }
        
        return redirect()->route('admin.movement.index')
            ->with('success', 'Movement record updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movementRecord = MovementRecord::findOrFail($id);
        $movementRecord->delete();

        return redirect()->route('admin.movement.index')
            ->with('success', 'Movement record deleted successfully.');
    }



    // In MovementController.php
public function editRequests()
{
    $requests = MovementRecord::where('edit_status', 'pending')
        ->with(['admin', 'country', 'editRequester'])
        ->latest('edit_requested_at')
        ->get();
    
    return view('admin.pages.movement.edit-requests', compact('requests'));
}

public function approveEdit($id)
{
    $record = MovementRecord::findOrFail($id);
    
    $record->update([
        'edit_status' => 'approved',
        'edit_approved_by' => Auth::guard('admin')->id(),
        'edit_approved_at' => now(),
    ]);
    
    return redirect()->route('admin.movement.edit-requests')
        ->with('success', 'Edit request approved successfully!');
}

public function rejectEdit(Request $request, $id)
{
    $request->validate([
        'edit_rejection_reason' => 'required|string|max:500',
    ]);
    
    $record = MovementRecord::findOrFail($id);
    
    $record->update([
        'edit_status' => 'rejected',
        'edit_rejection_reason' => $request->input('edit_rejection_reason'),
    ]);
    
    return redirect()->route('admin.movement.edit-requests')
        ->with('success', 'Edit request rejected successfully!');
}
//   public function hrDashboard()
// {
//     $today = today()->toDateString();
    
//     $totalMovements = MovementRecord::whereDate('date', $today)->count();
    
//     $movements = MovementRecord::with(['admin', 'employeeDepartment'])
//         ->whereDate('date', $today)
//         ->orderBy('time_start', 'asc')
//         ->get();
    
//     // If you need to get all admins (users with admin role)
//     $admins = User::where('role', 'admin')->get();
    
//     // If you need all employee departments
//     $employeeDepartments = EmployeeDepartment::all();
    
//     return view('admin.pages.movement.hr-dashboard', compact(
//         'totalMovements', 
//         'movements', 
//         'admins',
//         'employeeDepartments'
//     ));
// }
  public function hrDashboard(Request $request)
    {
        // Get filter parameters with defaults
        $date = $request->input('date', today()->toDateString());
        $adminId = $request->input('admin_id');
        $departmentId = $request->input('employee_department_id');
        $movementType = $request->input('movement_type');
        $status = $request->input('status');
        
        // Start query
        $query = MovementRecord::with(['admin', 'employeeDepartment'])
            ->whereDate('date', $date);
        
        // Apply filters if provided
        if ($adminId) {
            $query->where('admin_id', $adminId);
        }
        
        if ($departmentId) {
            $query->where('employee_department_id', $departmentId);
        }
        
        if ($movementType) {
            $query->where('movement_type', $movementType);
        }
        
        if ($status) {
            $query->where('status', $status);
        }
        
        // Get total movements for stats
        $totalMovements = $query->count();
        
        // Get movements with pagination
        $movements = $query->orderBy('time_start', 'asc')
            ->paginate(15)
            ->appends($request->except('page'));
        
        // Get statistics for all movements on this date (without filters)
        $statsQuery = MovementRecord::whereDate('date', $date);
        $stats = [
            'completed' => $statsQuery->where('status', 'completed')->count(),
            'pending' => $statsQuery->where('status', 'pending')->count(),
            'cancelled' => $statsQuery->where('status', 'cancelled')->count(),
        ];
        
        // Get filter options
        $admins = User::where(function($q) {
                $q->where('role', 'admin')
                  ->orWhere('role', 'super_admin');
            })
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();
        
        $employeeDepartments = EmployeeDepartment::orderBy('name')->get();
        
        return view('admin.pages.movement.hr-dashboard', compact(
            'totalMovements', 
            'movements', 
            'admins',
            'employeeDepartments',
            'date',
            'adminId',
            'departmentId',
            'movementType',
            'status',
            'stats'
        ));
    }
}