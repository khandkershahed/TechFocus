@extends('admin.master')

@section('title', $staff->name . ' - Attendance Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user me-2"></i>{{ $staff->name }} - Attendance Details
        </h1>
        <div>
            <a href="{{ route('admin.attendance.monthly-summary', ['year' => $year, 'month' => $month]) }}" 
               class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Back to Summary
            </a>
            <a href="{{ route('admin.attendance.export-staff-report', ['staff' => $staff->id, 'year' => $year, 'month' => $month]) }}" 
               class="btn btn-success">
                <i class="fas fa-download me-2"></i>Export PDF
            </a>
        </div>
    </div>

    <!-- Staff Info Card -->
    <div class="row mb-4">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-id-card me-2"></i>Staff Information
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-4x text-primary"></i>
                    </div>
                    <h4>{{ $staff->name }}</h4>
                    <p class="text-muted">{{ $staff->email }}</p>
                    <p><strong>Department:</strong> {{ $staff->department ?? 'N/A' }}</p>
                    <p><strong>Employee ID:</strong> {{ $staff->id }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Attendance Overview - {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border rounded p-3 mb-3">
                                <h2 class="text-primary">{{ $totalMeetings }}</h2>
                                <p class="mb-0 text-muted">Total Meetings</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3 mb-3 bg-success text-white">
                                <h2>{{ $presentCount }}</h2>
                                <p class="mb-0">Present</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3 mb-3 bg-warning text-white">
                                <h2>{{ $lateCount }}</h2>
                                <p class="mb-0">Late</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border rounded p-3 mb-3 bg-danger text-white">
                                <h2>{{ $absentCount }}</h2>
                                <p class="mb-0">Absent</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3">
                        <div class="d-inline-block">
                            <h3 class="mb-0">{{ $attendancePercentage }}%</h3>
                            <p class="text-muted">Attendance Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Breakdown -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar me-2"></i>Monthly Breakdown
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Total Meetings</th>
                                    <th>Present</th>
                                    <th>Late</th>
                                    <th>Absent</th>
                                    <th>Attendance %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlyData as $data)
                                <tr>
                                    <td>{{ $data->year }}</td>
                                    <td>{{ \Carbon\Carbon::create()->month($data->month)->format('F') }}</td>
                                    <td class="text-center">{{ $data->total_meetings }}</td>
                                    <td class="text-center text-success">{{ $data->present }}</td>
                                    <td class="text-center text-warning">{{ $data->late }}</td>
                                    <td class="text-center text-danger">{{ $data->absent }}</td>
                                    <td class="text-center">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar {{ $data->percentage >= 80 ? 'bg-success' : ($data->percentage >= 60 ? 'bg-warning' : 'bg-danger') }}" 
                                                 role="progressbar" 
                                                 style="width: {{ min($data->percentage, 100) }}%">
                                                {{ $data->percentage }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Month Details -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Meeting Details - {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
            </h6>
            <span class="badge bg-primary">{{ $currentMonthDetails->count() }} meetings</span>
        </div>
        <div class="card-body">
            @if($currentMonthDetails->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Meeting</th>
                            <th>Status</th>
                            <th>Join Time</th>
                            <th>Leave Time</th>
                            <th>Duration</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($currentMonthDetails as $attendance)
                        <tr>
                            <td>{{ $attendance->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($attendance->meeting)
                                    <a href="{{ route('admin.staff-meetings.show', $attendance->meeting) }}">
                                        {{ $attendance->meeting->title }}
                                    </a>
                                @else
                                    <span class="text-muted">Meeting Deleted</span>
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
                            <td>
                                @if($attendance->join_time && $attendance->leave_time)
                                    {{ $attendance->durationInMinutes() }} mins
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($attendance->requires_approval)
                                    @if($attendance->is_approved)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Approved
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock me-1"></i>Pending
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
            <div class="text-center py-4">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <p class="text-muted">No attendance records found for this month</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection