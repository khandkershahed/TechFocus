@extends('admin.master')

@section('title', 'Monthly Attendance Summary')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-calendar-alt me-2"></i>Monthly Attendance Summary
        </h1>
        <div>
            <a href="{{ route('admin.attendance.dashboard') }}" class="btn btn-info me-2">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <button class="btn btn-success" onclick="exportMonthlySummary()">
                <i class="fas fa-file-export me-2"></i>Export Report
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filters
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attendance.monthly-summary') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Year</label>
                        <select name="year" class="form-control">
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ $year == $yr ? 'selected' : '' }}>
                                    {{ $yr }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Month</label>
                        <select name="month" class="form-control">
                            @foreach($months as $key => $monthName)
                                <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>
                                    {{ $monthName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Department</label>
                        <select name="department" class="form-control">
                            <option value="">All Departments</option>
                            @php
                                $depts = \App\Models\Admin::distinct()->pluck('department');
                            @endphp
                            @foreach($depts as $dept)
                                @if($dept)
                                    <option value="{{ $dept }}" {{ $department == $dept ? 'selected' : '' }}>
                                        {{ $dept }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Staff ID</label>
                        <input type="text" name="staff_id" value="{{ $staffId }}" 
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
                                                {{ $stat->department }}
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

    <!-- Monthly Summary Table -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Staff Attendance Summary - {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}
            </h6>
            <span class="badge bg-primary">{{ $summary->total() }} staff members</span>
        </div>
        <div class="card-body">
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
                        @foreach($summary as $index => $record)
                        <tr>
                            <td>#{{ ($summary->currentPage() - 1) * $summary->perPage() + $index + 1 }}</td>
                            <td>
                                <strong>{{ $record->staff_name }}</strong><br>
                                <small class="text-muted">ID: {{ $record->staff_id }}</small>
                            </td>
                            <td>{{ $record->department ?? 'N/A' }}</td>
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
                                <a href="{{ route('admin.attendance.staff-detail', ['staff' => $record->staff_id, 'year' => $year, 'month' => $month]) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Details
                                </a>
                                <a href="{{ route('admin.attendance.export-staff-report', ['staff' => $record->staff_id, 'year' => $year, 'month' => $month]) }}" 
                                   class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> PDF
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            {{ $summary->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportMonthlySummary() {
    const year = document.querySelector('[name="year"]').value;
    const month = document.querySelector('[name="month"]').value;
    const department = document.querySelector('[name="department"]').value;
    
    let url = `/admin/attendance/export-monthly-summary?year=${year}&month=${month}`;
    if (department) {
        url += `&department=${department}`;
    }
    
    window.location.href = url;
}
</script>
@endpush