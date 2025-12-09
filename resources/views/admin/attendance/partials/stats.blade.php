<!-- Stats Row -->
<div class="row mb-4">
    <!-- Total Staff Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card total h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Staff
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStaff }}</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            <span>All active staff members</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Present Today Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card present h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Present Today
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $presentToday }}</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            @php
                                $presentPercentage = $totalStaff > 0 ? round(($presentToday / $totalStaff) * 100, 1) : 0;
                            @endphp
                            <span class="text-success mr-2">
                                <i class="fas fa-arrow-up"></i> {{ $presentPercentage }}%
                            </span>
                            <span>Attendance rate</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Late Today Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card late h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Late Today
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lateToday }}</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            @php
                                $latePercentage = $totalStaff > 0 ? round(($lateToday / $totalStaff) * 100, 1) : 0;
                            @endphp
                            <span class="text-warning mr-2">
                                <i class="fas fa-clock"></i> {{ $latePercentage }}%
                            </span>
                            <span>Late arrival rate</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Absent Today Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card absent h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Absent Today
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $absentToday }}</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            @php
                                $absentPercentage = $totalStaff > 0 ? round(($absentToday / $totalStaff) * 100, 1) : 0;
                            @endphp
                            <span class="text-danger mr-2">
                                <i class="fas fa-user-slash"></i> {{ $absentPercentage }}%
                            </span>
                            <span>Absentee rate</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-times fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body py-3">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border-end">
                            <h4 class="text-primary mb-1">{{ count($meetingStats) }}</h4> <!-- FIXED HERE -->
                            <small class="text-muted">Meetings Today</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            @php
                                // Convert array to collection for avg() method
                                $avgAttendance = count($meetingStats) > 0 
                                    ? collect($meetingStats)->avg('percentage') 
                                    : 0;
                            @endphp
                            <h4 class="text-success mb-1">{{ round($avgAttendance, 1) }}%</h4>
                            <small class="text-muted">Avg. Attendance</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            @php
                                $pendingApprovals = \App\Models\StaffMeetingAttendance::where('requires_approval', true)
                                    ->where('is_approved', false)
                                    ->count();
                            @endphp
                            <h4 class="text-warning mb-1">{{ $pendingApprovals }}</h4>
                            <small class="text-muted">Pending Approvals</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div>
                            @php
                                $onLeave = \App\Models\StaffMeetingAttendance::whereDate('created_at', $date)
                                    ->where('status', 'on_leave')
                                    ->count();
                            @endphp
                            <h4 class="text-info mb-1">{{ $onLeave }}</h4>
                            <small class="text-muted">On Leave Today</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>