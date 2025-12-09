@extends('admin.master')

@section('title', 'Attendance Record Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-eye me-2"></i>Attendance Record Details
        </h1>
        <div>
            <a href="{{ route('admin.attendance.edit', $attendance) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Attendance Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Attendance Information</h6>
                    <span class="badge bg-{{ $attendance->getAttendanceStatusColor() }} fs-6">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Staff Info -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-primary h-100">
                                <div class="card-header bg-primary text-white py-2">
                                    <h6 class="mb-0">
                                        <i class="fas fa-user me-2"></i>Staff Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="40%">Name:</th>
                                            <td>{{ $attendance->staff_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Staff ID:</th>
                                            <td>{{ $attendance->staff_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Department:</th>
                                            <td>{{ $attendance->department ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>{{ $attendance->staff->email ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Meeting Info -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-info h-100">
                                <div class="card-header bg-info text-white py-2">
                                    <h6 class="mb-0">
                                        <i class="fas fa-calendar me-2"></i>Meeting Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="40%">Meeting:</th>
                                            <td>
                                                @if($attendance->meeting)
                                                    <a href="{{ route('admin.staff-meetings.show', $attendance->meeting) }}">
                                                        {{ $attendance->meeting->title }}
                                                    </a>
                                                @else
                                                    <span class="text-danger">Meeting Deleted</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Date:</th>
                                            <td>{{ $attendance->meeting->date->format('M d, Y') ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Time:</th>
                                            <td>
                                                @if($attendance->meeting)
                                                    {{ $attendance->meeting->start_time->format('h:i A') }} - 
                                                    {{ $attendance->meeting->end_time->format('h:i A') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Type:</th>
                                            <td>{{ $attendance->meeting->type ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Attendance Details -->
                        <div class="col-12 mb-4">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white py-2">
                                    <h6 class="mb-0">
                                        <i class="fas fa-clock me-2"></i>Attendance Details
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-3">
                                            <div class="p-3 border rounded">
                                                <small class="text-muted">Join Time</small>
                                                <h5 class="mt-2">
                                                    @if($attendance->join_time)
                                                        {{ $attendance->join_time->format('h:i A') }}
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-3 border rounded">
                                                <small class="text-muted">Leave Time</small>
                                                <h5 class="mt-2">
                                                    @if($attendance->leave_time)
                                                        {{ $attendance->leave_time->format('h:i A') }}
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-3 border rounded">
                                                <small class="text-muted">Duration</small>
                                                <h5 class="mt-2">
                                                    @if($attendance->join_time && $attendance->leave_time)
                                                        {{ $attendance->durationInMinutes() }} mins
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-3 border rounded">
                                                <small class="text-muted">Late Arrival</small>
                                                <h5 class="mt-2">
                                                    @if($attendance->isLate())
                                                        <span class="text-danger">Yes</span>
                                                    @else
                                                        <span class="text-success">No</span>
                                                    @endif
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Notes -->
                        @if($attendance->notes)
                        <div class="col-12 mb-4">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white py-2">
                                    <h6 class="mb-0">
                                        <i class="fas fa-sticky-note me-2"></i>Notes
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $attendance->notes }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Approval Information -->
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white py-2">
                                    <h6 class="mb-0">
                                        <i class="fas fa-check-circle me-2"></i>Approval Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted">Requires Approval:</small>
                                            <p>
                                                @if($attendance->requires_approval)
                                                    <span class="badge bg-warning">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Approval Status:</small>
                                            <p>
                                                @if($attendance->is_approved)
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($attendance->requires_approval)
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-secondary">N/A</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Approved By:</small>
                                            <p>
                                                @if($attendance->approver)
                                                    {{ $attendance->approver->name }}
                                                    <br>
                                                    <small class="text-muted">
                                                        on {{ $attendance->approved_at->format('M d, Y h:i A') }}
                                                    </small>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- System Information -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">System Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <small class="text-muted">Record ID:</small>
                            <p><code>{{ $attendance->id }}</code></p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Created At:</small>
                            <p>{{ $attendance->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Updated At:</small>
                            <p>{{ $attendance->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Device IP:</small>
                            <p>{{ $attendance->device_ip ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection