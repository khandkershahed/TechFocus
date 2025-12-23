@extends('admin.master')

@section('title', 'Attendance Records')

@section('content')
<style>
    .card {
        border-radius: 16px;
    }

    .table thead th {
        background: #f1f5f9;
        font-weight: 600;
    }

    .nav-pills .nav-link {
        border-radius: 12px;
        font-weight: 500;
    }

    .nav-pills .nav-link.active {
        background: #2563eb;
    }
</style>

<div class="py-4 container-fluid h-100">

    <!-- PAGE HEADER -->
    <div class="p-4 mb-4 bg-white rounded-4 d-flex justify-content-between align-items-center sticky-top"
        style="top:70px; z-index: 5;">
        <div>
            <h2 class="mb-1 fw-bold">Attendance Records</h2>
            <small class="text-muted">Monitor, analyze and manage staff attendance</small>
        </div>
        <div class="gap-2 d-flex">
            <a href="{{ route('admin.attendance.dashboard') }}" class="px-4 py-4 btn btn-outline-secondary rounded-pill">
                <i class="fas fa-chart-line me-1"></i> Dashboard
            </a>
            <a href="{{ route('admin.attendance.create') }}" class="px-4 py-4 btn btn-primary rounded-pill">
                <i class="fas fa-plus me-1"></i> Add Record
            </a>
        </div>
    </div>

    <!-- TABS -->
    <ul class="gap-2 p-2 mb-4 bg-white nav nav-pills rounded-4">
        <li class="nav-item">
            <button class="nav-link {{ $summaryView === 'records' ? 'active' : '' }}"
                data-bs-toggle="tab" data-bs-target="#records">
                <i class="fas fa-list me-1"></i> Records
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link {{ $summaryView === 'monthly' ? 'active' : '' }}"
                data-bs-toggle="tab" data-bs-target="#monthly">
                <i class="fas fa-calendar-alt me-1"></i> Monthly Summary
            </button>
        </li>
    </ul>

    <div class="tab-content">

        <!-- ================= RECORDS TAB ================= -->
        <div class="tab-pane fade {{ $summaryView === 'records' ? 'show active' : '' }}" id="records">

            <div class="border-0 card rounded-4">
                <div class="py-4 bg-transparent card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">
                        Attendance Records
                        <span class="badge bg-primary rounded-pill">{{ $attendances->total() }}</span>
                    </h5>
                    <button class="btn btn-sm btn-outline-success rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#bulkUpdateModal">
                        <i class="fas fa-edit me-1"></i> Bulk Update
                    </button>
                </div>

                <div class="p-0 card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle table-hover">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Staff</th>
                                    <th>Department</th>
                                    <th>Meeting</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Join Time</th>
                                    <th class="text-end pe-5">Actions</th>
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
                                            : (json_decode($attendance->department, true)
                                                ? implode(', ', json_decode($attendance->department, true))
                                                : 'N/A') }}
                                    </td>

                                    <td>
                                        @if($attendance->meeting)
                                        <strong>{{ Str::limit($attendance->meeting->title, 25) }}</strong><br>
                                        <small class="text-muted">
                                            {{ $attendance->meeting->date->format('M d, Y') }}
                                        </small>
                                        @else
                                        <span class="text-danger">Deleted</span>
                                        @endif
                                    </td>

                                    <td>{{ $attendance->created_at->format('M d, Y') }}</td>

                                    <td>
                                        <span class="badge rounded-pill bg-{{ $attendance->getAttendanceStatusColor() }}">
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $attendance->join_time
                                            ? $attendance->join_time->format('h:i A')
                                            : 'N/A' }}
                                    </td>

                                    <td class="text-end">
                                        <div class="gap-1 d-flex justify-content-end">
                                            <a href="{{ route('admin.attendance.show', $attendance) }}"
                                                class="px-2 btn btn-sm btn-light rounded-circle">
                                                <i class="text-center fas fa-eye text-primary ps-1"></i>
                                            </a>
                                            <a href="{{ route('admin.attendance.edit', $attendance) }}"
                                                class="px-2 btn btn-sm btn-light rounded-circle">
                                                <i class="fas fa-pen text-warning ps-1"></i>
                                            </a>
                                            <form method="POST"
                                                action="{{ route('admin.attendance.destroy', $attendance) }}">
                                                @csrf @method('DELETE')
                                                <button class="px-2 btn btn-sm btn-light rounded-circle"
                                                    onclick="return confirm('Delete this record?')">
                                                    <i class="fas fa-trash text-danger ps-1"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="py-5 text-center">
                                        <i class="mb-3 fas fa-folder-open fa-3x text-muted"></i>
                                        <p class="text-muted">No attendance records found</p>
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

                @if($attendances->hasPages())
                <div class="bg-white border-0 card-footer">
                    {{ $attendances->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- ================= MONTHLY TAB ================= -->
        <div class="tab-pane fade {{ $summaryView === 'monthly' ? 'show active' : '' }}" id="monthly">

            <div class="mb-4 border-0 card rounded-4">
                <div class="bg-transparent card-header border-bottom">
                    <h5 class="mb-0 fw-semibold">Monthly Attendance Summary</h5>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.attendance.index') }}" class="row g-3">
                        <input type="hidden" name="view" value="monthly">

                        <div class="col-md-3">
                            <label class="form-label">Year</label>
                            <select name="monthly_year" class="form-select">
                                @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ $year == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Month</label>
                            <select name="monthly_month" class="form-select">
                                @foreach($monthList as $key => $month)
                                <option value="{{ $key }}" {{ $monthNum == $key ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Department</label>
                            <select name="monthly_department" class="form-select">
                                <option value="">All</option>
                                @foreach(\App\Models\Admin::distinct()->pluck('department') as $dept)
                                @if($dept)
                                <option value="{{ $dept }}" {{ $monthlyDepartment == $dept ? 'selected' : '' }}>
                                    {{ $dept }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Staff ID</label>
                            <input type="text" name="monthly_staff_id"
                                value="{{ $monthlyStaffId }}"
                                class="form-control" placeholder="Optional">
                        </div>

                        <div class="col-12">
                            <button class="px-4 btn btn-primary rounded-pill">
                                <i class="fas fa-search me-1"></i> Generate Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- YOU CAN KEEP YOUR MONTHLY TABLE & STATS BELOW --}}
        </div>

    </div>
</div>

@endsection