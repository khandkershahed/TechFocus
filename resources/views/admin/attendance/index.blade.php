@extends('admin.master')

@section('title', 'Attendance Records')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-clipboard-list me-2"></i>Attendance Records
        </h1>
        <div>
            <a href="{{ route('admin.attendance.dashboard') }}" class="btn btn-info me-2">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Record
            </a>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filters
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attendance.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Meeting</label>
                        <select name="meeting_id" class="form-control">
                            <option value="">All Meetings</option>
                            @foreach($meetings as $meeting)
                                <option value="{{ $meeting->id }}" {{ request('meeting_id') == $meeting->id ? 'selected' : '' }}>
                                    {{ $meeting->title }} ({{ $meeting->date->format('M d') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Staff ID</label>
                        <input type="text" name="staff_id" value="{{ request('staff_id') }}" class="form-control" placeholder="Staff ID">
                    </div>
                    
                   <div class="col-md-2 mb-3">
                                    <label class="form-label">Department</label>
                                    <select name="department" class="form-control">
                                        <option value="">All Departments</option>

                                        @php
                                            $departments = \App\Models\Admin::pluck('department')
                                                ->filter()
                                                ->flatMap(function ($dept) {
                                                    return is_array($dept)
                                                        ? $dept
                                                        : json_decode($dept, true) ?? [];
                                                })
                                                ->unique()
                                                ->sort()
                                                ->values();
                                        @endphp

                                        @foreach($departments as $dept)
                                            <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>
                                                {{ ucfirst($dept) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                    
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                            <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                            <option value="work_from_field" {{ request('status') == 'work_from_field' ? 'selected' : '' }}>Work From Field</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Date Range</label>
                        <div class="input-group">
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control" placeholder="From">
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control" placeholder="To">
                        </div>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Approval</label>
                        <select name="requires_approval" class="form-control">
                            <option value="">All</option>
                            <option value="1" {{ request('requires_approval') == '1' ? 'selected' : '' }}>Requires Approval</option>
                            <option value="0" {{ request('requires_approval') == '0' ? 'selected' : '' }}>No Approval Needed</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Apply Filters
                            </button>
                            <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo me-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Attendance Records ({{ $attendances->total() }} records found)
            </h6>
            <div>
                <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#bulkUpdateModal">
                    <i class="fas fa-edit me-1"></i>Bulk Update
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="attendanceTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Staff</th>
                            <th>Department</th>
                            <th>Meeting</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Join Time</th>
                            <th>Leave Time</th>
                            <th>Notes</th>
                            <th>Approval</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $attendance->staff_name }}</strong><br>
                                <small class="text-muted">ID: {{ $attendance->staff_id }}</small>
                            </td>
                        <td>
                            {{ is_array($attendance->department) 
                                ? implode(', ', $attendance->department) 
                                : (json_decode($attendance->department, true) ? implode(', ', json_decode($attendance->department, true)) : 'N/A') 
                            }}
                        </td>
                            <td>
                                @if($attendance->meeting)
                                    <a href="{{ route('admin.staff-meetings.show', $attendance->meeting) }}">
                                        {{ Str::limit($attendance->meeting->title, 30) }}
                                    </a>
                                    <br>
                                    <small class="text-muted">{{ $attendance->meeting->date->format('M d, Y') }}</small>
                                @else
                                    <span class="text-danger">Meeting Deleted</span>
                                @endif
                            </td>
                            <td>{{ $attendance->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $attendance->getAttendanceStatusColor() }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td>
                                @if($attendance->join_time)
                                    {{ $attendance->join_time->format('h:i A') }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($attendance->leave_time)
                                    {{ $attendance->leave_time->format('h:i A') }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($attendance->notes)
                                    <button type="button" class="btn btn-sm btn-info" 
                                            data-bs-toggle="popover" 
                                            data-bs-content="{{ $attendance->notes }}"
                                            title="Notes">
                                        <i class="fas fa-sticky-note"></i>
                                    </button>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($attendance->requires_approval)
                                    @if($attendance->is_approved)
                                        <span class="badge bg-success" title="Approved by {{ $attendance->approver->name ?? 'N/A' }}">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    @else
                                        <span class="badge bg-warning" title="Pending Approval">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        @can('approve', $attendance)
                                        <br>
                                        <a href="{{ route('admin.attendance.approve', $attendance) }}" 
                                           class="btn btn-xs btn-success mt-1"
                                           onclick="return confirm('Approve this record?')">
                                            Approve
                                        </a>
                                        @endcan
                                    @endif
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.attendance.show', $attendance) }}" 
                                       class="btn btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.attendance.edit', $attendance) }}" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.attendance.destroy', $attendance) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Delete this record?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4">
                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No attendance records found</p>
                                <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Create First Record
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($attendances->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Showing {{ $attendances->firstItem() }} to {{ $attendances->lastItem() }} of {{ $attendances->total() }} entries
                </div>
                <div>
                    {{ $attendances->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Update Modal -->
<div class="modal fade" id="bulkUpdateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Update Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bulkUpdateForm" action="{{ route('admin.attendance.bulk.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Select records and choose new status for all selected.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Select Status</label>
                        <select name="bulk_status" class="form-control" required>
                            <option value="">-- Select Status --</option>
                            <option value="present">Present</option>
                            <option value="late">Late</option>
                            <option value="absent">Absent</option>
                            <option value="on_leave">On Leave</option>
                            <option value="work_from_field">Work From Field</option>
                        </select>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">Select</th>
                                    <th>Staff</th>
                                    <th>Meeting</th>
                                    <th>Current Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="attendances[{{ $loop->index }}][id]" 
                                               value="{{ $attendance->id }}" class="form-check-input">
                                    </td>
                                    <td>{{ $attendance->staff_name }}</td>
                                    <td>{{ $attendance->meeting->title ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $attendance->getAttendanceStatusColor() }}">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Selected</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize popovers
        $('[data-bs-toggle="popover"]').popover({
            trigger: 'hover',
            placement: 'top'
        });
        
        // Select all for bulk update
        $('#selectAll').click(function() {
            $('.attendance-checkbox').prop('checked', this.checked);
        });
        
        // Bulk update form submission
        $('#bulkUpdateForm').submit(function(e) {
            e.preventDefault();
            
            const selectedCount = $('input[name^="attendances"]:checked').length;
            if (selectedCount === 0) {
                alert('Please select at least one record to update.');
                return;
            }
            
            if (confirm(`Update ${selectedCount} record(s) with new status?`)) {
                this.submit();
            }
        });
    });
</script>
@endpush