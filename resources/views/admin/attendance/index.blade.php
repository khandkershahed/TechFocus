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

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4" id="attendanceTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $summaryView === 'records' ? 'active' : '' }}" 
                    id="records-tab" data-bs-toggle="tab" 
                    data-bs-target="#records" type="button" role="tab">
                <i class="fas fa-list me-1"></i> Attendance Records
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $summaryView === 'monthly' ? 'active' : '' }}" 
                    id="monthly-tab" data-bs-toggle="tab" 
                    data-bs-target="#monthly" type="button" role="tab">
                <i class="fas fa-chart-bar me-1"></i> Monthly Summary
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="attendanceTabsContent">
        
        <!-- Tab 1: Attendance Records -->
        <div class="tab-pane fade {{ $summaryView === 'records' ? 'show active' : '' }}" 
             id="records" role="tabpanel">

            <!-- Attendance Records Table -->
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
        
        <!-- Tab 2: Monthly Summary -->
        <div class="tab-pane fade {{ $summaryView === 'monthly' ? 'show active' : '' }}" 
             id="monthly" role="tabpanel">
            
            <!-- Filters for Monthly Summary -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-filter me-2"></i>Monthly Summary Filters
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.attendance.index') }}" method="GET">
                        <input type="hidden" name="view" value="monthly">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Year</label>
                                <select name="monthly_year" class="form-control">
                                    @foreach($years as $yr)
                                        <option value="{{ $yr }}" {{ $year == $yr ? 'selected' : '' }}>
                                            {{ $yr }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Month</label>
                                <select name="monthly_month" class="form-control">
                                    @foreach($monthList as $key => $monthName)
                                        <option value="{{ $key }}" {{ $monthNum == $key ? 'selected' : '' }}>
                                            {{ $monthName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Department</label>
                                <select name="monthly_department" class="form-control">
                                    <option value="">All Departments</option>
                                    @php
                                        $depts = \App\Models\Admin::distinct()->pluck('department');
                                    @endphp
                                    @foreach($depts as $dept)
                                        @if($dept)
                                            <option value="{{ $dept }}" {{ $monthlyDepartment == $dept ? 'selected' : '' }}>
                                                {{ $dept }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Staff ID</label>
                                <input type="text" name="monthly_staff_id" value="{{ $monthlyStaffId }}" 
                                       class="form-control" placeholder="Staff ID">
                            </div>
                            
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Generate Report
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Department Statistics -->
            @if($departmentStats && $departmentStats->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-building me-2"></i>Department Performance
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($departmentStats as $stat)
                                <div class="col-md-3 mb-3">
                                    <div class="card border-left-{{ $stat->percentage >= 80 ? 'success' : ($stat->percentage >= 60 ? 'warning' : 'danger') }} shadow h-100">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                   <div class="text-xs font-weight-bold text-uppercase mb-1">
                                                        {{ is_array(json_decode($stat->department)) 
                                                            ? implode(', ', json_decode($stat->department)) 
                                                            : $stat->department }}
                                                    </div>

                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        {{ $stat->percentage }}%
                                                    </div>
                                                    <div class="mt-2 text-xs">
                                                        <span class="text-muted">{{ $stat->attended }}/{{ $stat->total }} attended</span>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
           <!-- Top & Low Attendees Section -->
@if($summaryView === 'monthly' && ($topAttendees->count() > 0 || $lowAttendees->count() > 0))
<div class="row mb-4">
    <!-- Top Attendees -->
    @if($topAttendees->count() > 0)
    <div class="col-md-6">
        <div class="card shadow h-100">
            <div class="card-header bg-success text-white py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-trophy me-2"></i>Top Attendees (≥90%)
                </h6>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($topAttendees as $index => $attendee)
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <div>
                                <h6 class="mb-1">
                                    <i class="fas fa-user-circle me-2 text-success"></i>
                                    {{ $attendee->staff_name }}
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-building me-1"></i>
                                    {{ is_array(json_decode($attendee->department)) 
                                        ? implode(', ', json_decode($attendee->department)) 
                                        : $attendee->department }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success rounded-pill">
                                    {{ $attendee->attendance_percentage }}%
                                </span>
                                <div class="mt-1">
                                    <small class="text-muted">
                                        {{ $attendee->attended_count }}/{{ $attendee->total_meetings }} meetings
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Low Attendees with Warning -->
    @if($lowAttendees->count() > 0)
    <div class="col-md-6">
        <div class="card shadow h-100 border-danger">
            <div class="card-header bg-danger text-white py-3">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-exclamation-triangle me-2"></i>Low Attendees (<70%)
                    <span class="badge bg-light text-danger ms-2">{{ $lowAttendees->count() }}</span>
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    Staff with attendance below 70% may require attention
                </div>
                <div class="list-group">
                    @foreach($lowAttendees as $attendee)
                    <div class="list-group-item list-group-item-action border-start border-3 border-danger">
                        <div class="d-flex w-100 justify-content-between">
                            <div>
                                <h6 class="mb-1">
                                    <i class="fas fa-user-circle me-2 text-danger"></i>
                                    {{ $attendee->staff_name }}
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-building me-1"></i>
                                    {{ is_array(json_decode($attendee->department)) 
                                        ? implode(', ', json_decode($attendee->department)) 
                                        : $attendee->department }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-danger rounded-pill">
                                    {{ $attendee->attendance_percentage }}%
                                </span>
                                <div class="mt-1">
                                    <small class="text-danger">
                                        <i class="fas fa-times-circle me-1"></i>
                                        {{ $attendee->absent_count }} absences
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('admin.attendance.staff-detail', [
                                'staff' => $attendee->staff_id, 
                                'year' => $year, 
                                'month' => $monthNum
                            ]) }}" 
                               class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-chart-line me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endif

<!-- Repeated Absences Warning -->
@if($summaryView === 'monthly' && $repeatedAbsences->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow border-warning">
            <div class="card-header bg-warning text-dark py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-exclamation-triangle me-2"></i>Repeated Absences Warning
                        <span class="badge bg-danger ms-2">{{ $repeatedAbsences->count() }} staff</span>
                    </h6>
                    <button type="button" class="btn btn-sm btn-outline-dark" 
                            data-bs-toggle="modal" data-bs-target="#repeatedAbsencesModal">
                        <i class="fas fa-list me-1"></i>View All
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-danger">
                    <i class="fas fa-bell me-2"></i>
                    <strong>Warning:</strong> The following staff have 3 or more consecutive absences. 
                    Immediate attention is recommended.
                </div>
                
                <div class="row">
                    @foreach($repeatedAbsences->take(6) as $absence)
                    <div class="col-md-4 mb-3">
                        <div class="card border-danger h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-user-times"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $absence['staff_name'] }}</h6>
                                        <small class="text-muted">{{ $absence['department'] }}</small>
                                        <div class="mt-2">
                                            <span class="badge bg-danger">
                                                {{ $absence['consecutive_absences'] }} consecutive absences
                                            </span>
                                            <div class="mt-1">
                                                <small class="text-danger">
                                                    Last: {{ \Carbon\Carbon::parse($absence['last_absence_date'])->format('M d, Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('admin.attendance.staff-detail', [
                                        'staff' => $absence['staff_id'], 
                                        'year' => $year, 
                                        'month' => $monthNum
                                    ]) }}" 
                                       class="btn btn-sm btn-outline-danger w-100">
                                        <i class="fas fa-eye me-1"></i>Investigate
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Repeated Absences Modal -->
<div class="modal fade" id="repeatedAbsencesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Repeated Absences Report
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="table-warning">
                                <th>Staff</th>
                                <th>Department</th>
                                <th>Consecutive Absences</th>
                                <th>Last Absence</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($repeatedAbsences as $absence)
                            <tr>
                                <td>
                                    <strong>{{ $absence['staff_name'] }}</strong><br>
                                    <small class="text-muted">ID: {{ $absence['staff_id'] }}</small>
                                </td>
                                <td>{{ $absence['department'] }}</td>
                                <td>
                                    <span class="badge bg-danger rounded-pill">
                                        {{ $absence['consecutive_absences'] }} times
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($absence['last_absence_date'])->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.attendance.staff-detail', [
                                            'staff' => $absence['staff_id'], 
                                            'year' => $year, 
                                            'month' => $monthNum
                                        ]) }}" 
                                           class="btn btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-warning" 
                                                onclick="sendWarning('{{ $absence['staff_id'] }}', '{{ $absence['staff_name'] }}')">
                                            <i class="fas fa-bell"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="exportRepeatedAbsences()">
                    <i class="fas fa-download me-1"></i>Export Report
                </button>
            </div>
        </div>
    </div>
</div> 
            <!-- Monthly Summary Table -->
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table me-2"></i>Staff Attendance Summary - {{ \Carbon\Carbon::create()->month((int) $monthNum)->format('F') }} {{ $year }}
                    </h6>
                    @if($monthlyData)
                        <span class="badge bg-primary">{{ $monthlyData->total() }} staff members</span>
                    @endif
                </div>
                <div class="card-body">
                    @if($monthlyData && $monthlyData->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Rank</th>
                                    <th>Staff Name</th>
                                    <th>Department</th>
                                    <th>Total Meetings</th>
                                    <th>Present</th>
                                    <th>Late</th>
                                    <th>Absent</th>
                                    <th>Attendance %</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlyData as $index => $record)
                                <tr>
                                    <td>#{{ ($monthlyData->currentPage() - 1) * $monthlyData->perPage() + $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $record->staff_name }}</strong><br>
                                        <small class="text-muted">ID: {{ $record->staff_id }}</small>
                                    </td>
                                    <td>{{ is_array(json_decode($record->department)) ? implode(', ', json_decode($record->department)) : $record->department }}</td>

                                    <td class="text-center">{{ $record->total_meetings }}</td>
                                    <td class="text-center text-success">{{ $record->present_count }}</td>
                                    <td class="text-center text-warning">{{ $record->late_count }}</td>
                                    <td class="text-center text-danger">{{ $record->absent_count }}</td>
                                    <td class="text-center">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar {{ $record->attendance_percentage >= 80 ? 'bg-success' : ($record->attendance_percentage >= 60 ? 'bg-warning' : 'bg-danger') }}" 
                                                 role="progressbar" 
                                                 style="width: {{ min($record->attendance_percentage, 100) }}%">
                                                {{ $record->attendance_percentage }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($record->attendance_percentage >= 90)
                                            <span class="badge bg-success">Excellent</span>
                                        @elseif($record->attendance_percentage >= 80)
                                            <span class="badge bg-info">Good</span>
                                        @elseif($record->attendance_percentage >= 70)
                                            <span class="badge bg-warning">Average</span>
                                        @elseif($record->attendance_percentage >= 60)
                                            <span class="badge bg-warning">Needs Improvement</span>
                                        @else
                                            <span class="badge bg-danger">Poor</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.attendance.staff-detail', ['staff' => $record->staff_id, 'year' => $year, 'month' => $monthNum]) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Details
                                        </a>
                                        {{-- <a href="{{ route('admin.attendance.export-staff-report', ['staff' => $record->staff_id, 'year' => $year, 'month' => $monthNum]) }}" 
                                           class="btn btn-sm btn-success">
                                            <i class="fas fa-download"></i> PDF
                                        </a> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    {{ $monthlyData->links() }}
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No attendance records found</h4>
                        <p class="text-muted">No attendance data available for the selected period.</p>
                    </div>
                    @endif
                </div>
            </div>
            
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
        
        // Tab handling - preserve tab state on page refresh
        const activeTab = localStorage.getItem('activeAttendanceTab');
        if (activeTab) {
            const tabTrigger = document.querySelector(`[data-bs-target="${activeTab}"]`);
            if (tabTrigger) {
                new bootstrap.Tab(tabTrigger).show();
            }
        }
        
        // Store active tab
        $('#attendanceTabs button').on('click', function() {
            const target = $(this).data('bs-target');
            localStorage.setItem('activeAttendanceTab', target);
        });
    });
    
    function exportMonthlySummary() {
        const year = document.querySelector('[name="monthly_year"]').value;
        const month = document.querySelector('[name="monthly_month"]').value;
        const department = document.querySelector('[name="monthly_department"]').value;
        
        let url = `/admin/attendance/export-monthly-summary?year=${year}&month=${month}`;
        if (department) {
            url += `&department=${department}`;
        }
        
        window.location.href = url;
    }


    function sendWarning(staffId, staffName) {
    if (confirm(`Send warning notification to ${staffName}?`)) {
        // You can implement AJAX call to send notification
        fetch(`/admin/attendance/send-warning/${staffId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Warning notification sent successfully.');
            } else {
                alert('Failed to send notification.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    }
}

function exportRepeatedAbsences() {
    const year = document.querySelector('[name="monthly_year"]').value;
    const month = document.querySelector('[name="monthly_month"]').value;
    const department = document.querySelector('[name="monthly_department"]').value;
    
    let url = `/admin/attendance/export-repeated-absences?year=${year}&month=${month}`;
    if (department) {
        url += `&department=${department}`;
    }
    
    window.location.href = url;
}

// Add warning flag to staff rows in monthly table
document.addEventListener('DOMContentLoaded', function() {
    // Add warning icons to low attendance staff in monthly table
    document.querySelectorAll('#monthlyTable tr').forEach(row => {
        const percentageCell = row.querySelector('.attendance-percentage');
        if (percentageCell) {
            const percentage = parseFloat(percentageCell.textContent.replace('%', ''));
            if (percentage < 70) {
                const staffNameCell = row.querySelector('td:nth-child(2)');
                if (staffNameCell) {
                    const warningIcon = document.createElement('span');
                    warningIcon.className = 'badge bg-danger ms-2';
                    warningIcon.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Low';
                    staffNameCell.appendChild(warningIcon);
                }
            }
        }
    });
});
</script>
@endpush