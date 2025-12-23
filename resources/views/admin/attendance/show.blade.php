@extends('admin.master')
@section('title', 'Attendance Record Details')

@section('content')
<style>
    .stat-card {
        transition: all 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
    }
</style>
<div class="mb-5 h-100 container-fluid">

    <!-- Header -->
    <div class="flex-wrap p-4 mb-4 bg-white rounded-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1 h3 fw-bold">
                <i class="fas fa-eye text-primary me-2"></i>
                Attendance Record Details
            </h1>
            <small class="text-muted">Complete attendance overview & system data</small>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('admin.attendance.edit', $attendance) }}" class="px-4 btn btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.attendance.index') }}" class="px-4 btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="border-0 card rounded-4">
        <div class="py-5 bg-white card-header border-bottom rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold text-primary">Attendance Overview</h5>
            <span class="badge rounded-pill px-3 py-2 bg-{{ $attendance->getAttendanceStatusColor() }}">
                {{ ucfirst($attendance->status) }}
            </span>
        </div>

        <div class="p-4 card-body">

            <!-- Staff + Meeting -->
            <div class="mb-4 row g-4">
                <div class="col-lg-6">
                    <div class="border-0 shadow-sm h-100 card rounded-4">
                        <div class="card-body">
                            <h6 class="mb-3 fw-bold text-primary">
                                <i class="fas fa-user me-2"></i>Staff Information
                            </h6>
                            <ul class="list-group list-group-flush small">
                                <li class="px-0 list-group-item"><strong>Name:</strong> {{ $attendance->staff_name }}</li>
                                <li class="px-0 list-group-item"><strong>ID:</strong> {{ $attendance->staff_id }}</li>
                                <li class="px-0 list-group-item"><strong>Department:</strong> {{ $attendance->department ?? 'N/A' }}</li>
                                <li class="px-0 list-group-item"><strong>Email:</strong> {{ $attendance->staff->email ?? 'N/A' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="border-0 shadow-sm h-100 card rounded-4">
                        <div class="card-body">
                            <h6 class="mb-3 fw-bold text-info">
                                <i class="fas fa-calendar-alt me-2"></i>Meeting Information
                            </h6>
                            <ul class="list-group list-group-flush small">
                                <li class="px-0 list-group-item">
                                    <strong>Meeting:</strong>
                                    @if($attendance->meeting)
                                    <a href="{{ route('admin.staff-meetings.show', $attendance->meeting) }}" class="text-decoration-none">
                                        {{ $attendance->meeting->title }}
                                    </a>
                                    @else
                                    <span class="text-danger">Deleted</span>
                                    @endif
                                </li>
                                <li class="px-0 list-group-item">
                                    <strong>Date:</strong> {{ $attendance->meeting->date->format('M d, Y') ?? 'N/A' }}
                                </li>
                                <li class="px-0 list-group-item">
                                    <strong>Time:</strong>
                                    @if($attendance->meeting)
                                    {{ $attendance->meeting->start_time->format('h:i A') }} -
                                    {{ $attendance->meeting->end_time->format('h:i A') }}
                                    @endif
                                </li>
                                <li class="px-0 list-group-item">
                                    <strong>Type:</strong> {{ $attendance->meeting->type ?? 'N/A' }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPI Stats -->
            <div class="mb-4 text-center row g-3">
                @php
                $stats = [
                ['Join Time', optional($attendance->join_time)->format('h:i A'), 'clock', 'primary'],
                ['Leave Time', optional($attendance->leave_time)->format('h:i A'), 'sign-out-alt', 'secondary'],
                ['Duration', ($attendance->join_time && $attendance->leave_time) ? $attendance->durationInMinutes().' mins' : 'N/A', 'hourglass-half', 'success'],
                ['Late', $attendance->isLate() ? 'Yes' : 'No', 'exclamation-circle', $attendance->isLate() ? 'danger' : 'success'],
                ];
                @endphp

                @foreach($stats as $stat)
                <div class="col-md-3 col-6">
                    <div class="border-0 shadow-sm card rounded-4 stat-card">
                        <div class="py-4 card-body">
                            <i class="fas fa-{{ $stat[2] }} fs-3 text-{{ $stat[3] }} mb-2"></i>
                            <div class="small text-muted">{{ $stat[0] }}</div>
                            <div class="fw-bold fs-6">{{ $stat[1] }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Bottom Dashboard -->
            <div class="row g-4">

                <!-- Notes -->
                <div class="col-lg-4">
                    <div class="border-0 shadow-sm card rounded-4 h-100">
                        <div class="card-body">
                            <h6 class="mb-2 fw-bold text-warning">
                                <i class="fas fa-sticky-note me-2"></i>Notes
                            </h6>
                            <p class="mb-0 text-muted">
                                {{ $attendance->notes ?? 'No notes provided.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Approval -->
                <div class="col-lg-4">
                    <div class="border-0 shadow-sm card rounded-4 h-100">
                        <div class="card-body">
                            <h6 class="mb-3 fw-bold text-success">
                                <i class="fas fa-check-circle me-2"></i>Approval Status
                            </h6>
                            <p class="mb-1"><strong>Requires:</strong> {{ $attendance->requires_approval ? 'Yes' : 'No' }}</p>
                            <p class="mb-1">
                                <strong>Status:</strong>
                                @if($attendance->is_approved)
                                <span class="badge bg-success">Approved</span>
                                @elseif($attendance->requires_approval)
                                <span class="badge bg-warning">Pending</span>
                                @else
                                <span class="badge bg-secondary">N/A</span>
                                @endif
                            </p>
                            <p class="mb-0"><strong>Approved By:</strong> {{ $attendance->approver->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- System -->
                <div class="col-lg-4">
                    <div class="border-0 shadow-sm card rounded-4 h-100">
                        <div class="card-body">
                            <h6 class="mb-3 fw-bold">System Information</h6>
                            <ul class="mb-0 list-unstyled small text-muted">
                                <li><strong>ID:</strong> <code>{{ $attendance->id }}</code></li>
                                <li><strong>Created:</strong> {{ $attendance->created_at->format('M d, Y h:i A') }}</li>
                                <li><strong>Updated:</strong> {{ $attendance->updated_at->format('M d, Y h:i A') }}</li>
                                <li><strong>IP:</strong> {{ $attendance->device_ip ?? 'N/A' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection