@extends('admin.master')

@section('title', 'Staff Attendance Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user me-2"></i>Attendance Details: {{ $staffMember->name }}
        </h1>
        <div>
            <a href="{{ route('admin.attendance.index') }}?view=monthly&monthly_year={{ $year }}&monthly_month={{ $month }}" 
               class="btn btn-info me-2">
                <i class="fas fa-arrow-left me-2"></i>Back to Summary
            </a>
            {{-- <a href="{{ route('admin.attendance.export-staff-report', ['staff' => $staffMember->id, 'year' => $year, 'month' => $month]) }}" 
               class="btn btn-success">
                <i class="fas fa-download me-2"></i>Export PDF
            </a> --}}
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Select Period
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attendance.staff-detail', $staffMember->id) }}" method="GET">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Year</label>
                        <select name="year" class="form-control">
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ $year == $yr ? 'selected' : '' }}>
                                    {{ $yr }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Month</label>
                        <select name="month" class="form-control">
                            @foreach($months as $key => $monthName)
                                <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>
                                    {{ $monthName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>View Report
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Meetings
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalMeetings }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Present
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $presentCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Late
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $lateCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-left-{{ $attendancePercentage >= 80 ? 'success' : ($attendancePercentage >= 60 ? 'warning' : 'danger') }} shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">
                                Attendance %
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $attendancePercentage }}%
                            </div>
                            <div class="mt-2 text-xs">
                                <span class="text-muted">{{ $presentCount + $lateCount }}/{{ $totalMeetings }} attended</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Information -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-id-card me-2"></i>Staff Information
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Name:</strong> {{ $staffMember->name }}</p>
                    <p><strong>Staff ID:</strong> {{ $staffMember->id }}</p>
                </div>
                <div class="col-md-4">
                    @php
    $departments = is_string($staffMember->department) ? json_decode($staffMember->department, true) : $staffMember->department;
@endphp

<p><strong>Department:</strong> {{ implode(', ', $departments) }}</p>

             <p><strong>Position:</strong> {{ $staffMember->designation ?? 'N/A' }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Email:</strong> {{ $staffMember->email ?? 'N/A' }}</p>
                    <p><strong>Phone:</strong> {{ $staffMember->phone ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Attendance Records - {{ \Carbon\Carbon::create()->month((int) $month)->format('F') }} {{ $year }}
            </h6>
            <span class="badge bg-primary">{{ $attendances->count() }} records</span>
        </div>
        <div class="card-body">
            @if($attendances->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Meeting</th>
                            <th>Status</th>
                            <th>Join Time</th>
                            <th>Leave Time</th>
                            <th>Notes</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($attendance->meeting)
                                    {{ $attendance->meeting->title }}
                                    <br>
                                    <small class="text-muted">{{ $attendance->meeting->date->format('h:i A') }}</small>
                                @else
                                    <span class="text-danger">Meeting Deleted</span>
                                @endif
                            </td>
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
                            <td>{{ $attendance->notes ?? '-' }}</td>
                            <td class="text-center">
                                @if($attendance->requires_approval)
                                    @if($attendance->is_approved)
                                        <span class="badge bg-success" title="Approved">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    @else
                                        <span class="badge bg-warning" title="Pending">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
@endsection