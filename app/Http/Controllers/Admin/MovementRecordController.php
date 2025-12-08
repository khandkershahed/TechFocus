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
   
// public function index(Request $request)
// {
//     $query = MovementRecord::with('admin','department');

//     // Filter by staff
//     if ($request->staff) {
//         $query->where('admin_id', $request->staff);
//     }

//     // Filter by department
//     if ($request->department) {
//         $query->where('department', $request->department);
//     }

//     // Filter by movement type
//     if ($request->movement_type) {
//         $query->where('meeting_type', $request->movement_type);
//     }

//     // Filter by status
//     if ($request->status) {
//         $query->where('status', $request->status);
//     }

//     // Filter by date
//     if ($request->date) {
//         $query->whereDate('date', $request->date);
//     }
//     $records = MovementRecord::where('admin_id', auth('admin')->id())
//     ->with('department')
//     ->latest()
//     ->paginate(10);

//     $records = $query->latest()->paginate(10)->withQueryString();

//     // Summary calculations
//     $totalDays = $records->pluck('date')->unique()->count();
//     $totalCompanies = $records->pluck('company')->unique()->count();
//     $totalVisits = $records->where('meeting_type', '!=', null)->count();
//     $totalAreas = $records->pluck('area')->unique()->count();
//     $highestValue = $records->max('value');
//     $lowestValue = $records->min('value');
//     $transportCost = $records->sum('cost');
//     $salesTarget = 3000000; // dynamic later
//     $companies = $records->pluck('company')->unique();

//     // For filter dropdowns
//     $allStaff = Admin::all();
//     // $departments = MovementRecord::select('department')->distinct()->pluck('department');
//     $movementTypes = MovementRecord::select('meeting_type')->distinct()->pluck('meeting_type');
//     $statuses = MovementRecord::select('status')->distinct()->pluck('status');

//     return view('admin.pages.movement.index', compact(
//         'records',
//         'totalDays',
//         'totalCompanies',
//         'totalVisits',
//         'totalAreas',
//         'highestValue',
//         'lowestValue',
//         'transportCost',
//         'salesTarget',
//         'companies',
//         'allStaff',
//          'departments',
//         'movementTypes',
//         'statuses'
//     ));
// }
public function index(Request $request)
{
    // ==========================================
    // 🔐 Allow only HR department users
    // ==========================================
    $userDept = json_decode(auth()->user()->department, true) ?? [];

    if (!in_array('hr', $userDept)) {
        return redirect()->back()->with('error', 'Access Denied! Only HR Department can access this page.');
    }

    // ==========================================
    // 🔍 Main Query (with Admin relation)
    // ==========================================
    $query = MovementRecord::with('admin');

    // Filter by staff
    if ($request->staff) {
        $query->where('admin_id', $request->staff);
    }

    // Filter by department (JSON match)
    if ($request->department) {
        $query->whereHas('admin', function($q) use ($request){
            $q->whereJsonContains('department', $request->department);
        });
    }

    // Filter movement type
    if ($request->movement_type) {
        $query->where('meeting_type', $request->movement_type);
    }

    // Filter status
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // Filter by date
    if ($request->date) {
        $query->whereDate('date', $request->date);
    }

    // ==========================================
    // 📌 Execute Pagination
    // ==========================================
    $records = $query->latest()->paginate(10);

    // Summary Calculations
    $totalDays       = $records->pluck('date')->unique()->count();
    $totalCompanies  = $records->pluck('company')->unique()->count();
    $totalVisits     = $records->whereNotNull('meeting_type')->count();
    $totalAreas      = $records->pluck('area')->unique()->count();
    $highestValue    = $records->max('value');
    $lowestValue     = $records->min('value');
    $transportCost   = $records->sum('cost');
    $salesTarget     = 3000000;
    $companies       = $records->pluck('company')->unique();

    // ==========================================
    // Dropdown Data
    // ==========================================
    $allStaff = Admin::all();

    // Departments unique (JSON support)
    $departments = Admin::whereNotNull('department')
        ->get()
        ->pluck('department')
        ->map(fn($i) => is_array($i) ? $i : json_decode($i, true))
        ->flatten()
        ->unique()
        ->sort()
        ->values();

    $movementTypes = MovementRecord::select('meeting_type')->distinct()->pluck('meeting_type');
    $statuses      = MovementRecord::select('status')->distinct()->pluck('status');

    return view('admin.pages.movement.index', compact(
        'records','totalDays','totalCompanies','totalVisits','totalAreas',
        'highestValue','lowestValue','transportCost','salesTarget','companies',
        'allStaff','departments','movementTypes','statuses'
    ));
}


    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     // Get current logged-in admin
    //     $currentAdmin = auth('admin')->user();
    //     $currentAdmin = auth('admin')->user()->load('department');

    //     return view('admin.pages.movement.form', compact('currentAdmin'));
    // }
public function create()
{
    $currentAdmin = auth('admin')->user()->load('department');
    $departments = \App\Models\Admin\EmployeeDepartment::orderBy('name')->get();
    return view('admin.pages.movement.form', compact('currentAdmin', 'departments'));
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
            'employee_department_id' => 'nullable|exists:employee_departments,id',
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
        $validated['employee_department_id']
    = auth('admin')->user()->employee_department_id;

        MovementRecord::create($validated);

       return redirect()->route('admin.movement.index')
     ->with('success', 'Movement record created successfully.');
    }

    /**
     * Display the specified resource.
     */
public function show($id)
{
    $record = MovementRecord::where('id', $id)
        ->where('admin_id', auth('admin')->id())
        ->with('admin')
        ->firstOrFail();

    return view('admin.pages.movement.show', compact('record'));
}


    /**
     * Show the form for editing the specified resource.
     */
  public function edit($id)
{
    $record = MovementRecord::where('id', $id)
        ->where('admin_id', auth('admin')->id())
        ->firstOrFail();

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
            'employee_department_id' => 'nullable|exists:employee_departments,id',

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
  public function destroy($id)
{
    $movementRecord = MovementRecord::where('id', $id)
        ->where('admin_id', auth('admin')->id())
        ->firstOrFail();

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

public function staffDashboard()
{
    $records = MovementRecord::where('admin_id', auth('admin')->id())
        ->latest()
        ->paginate(10);

    // Calculate summary values dynamically
    $totalDays = $records->pluck('date')->unique()->count();
    $totalCompanies = $records->pluck('company')->unique()->count();
    $totalVisits = $records->where('meeting_type', '!=', null)->count();
    $totalAreas = $records->pluck('area')->unique()->count();
    $highestValue = $records->max('value');
    $lowestValue = $records->min('value');
    $transportCost = $records->sum('cost');
    $salesTarget = 3000000; // dynamic later
    $companies = $records->pluck('company')->unique();

    return view('admin.pages.movement.staff-dashboard', compact(
        'records',
        'totalDays',
        'totalCompanies',
        'totalVisits',
        'totalAreas',
        'highestValue',
        'lowestValue',
        'transportCost',
        'companies',
        'salesTarget'
    ));
}


}