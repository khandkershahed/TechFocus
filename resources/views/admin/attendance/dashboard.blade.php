@extends('admin.master')

@section('title', 'Attendance Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt me-2"></i>Attendance Dashboard
        </h1>
        
        <div class="d-flex">
            <form action="{{ route('admin.attendance.dashboard') }}" method="GET" class="me-2">
                <div class="input-group">
                    <input type="date" name="date" value="{{ $date }}" class="form-control" onchange="this.form.submit()">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
            
         <button type="button" id="exportBtn" class="btn btn-success me-2" onclick="exportTableToCSV()">
    <i class="fas fa-file-export me-2"></i>Export
</button>
            
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-primary">
                <i class="fas fa-list me-2"></i>View All Records
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    @include('admin.attendance.partials.stats')

    <!-- Charts and Detailed Stats -->
    <div class="row">
        <!-- Meeting Attendance -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-check me-2"></i>Meeting Attendance
                    </h6>
                </div>
                <div class="card-body">
                    @if(count($meetingStats) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Meeting</th>
                                        <th>Date/Time</th>
                                        <th>Present</th>
                                        <th>Attendance %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($meetingStats as $stat)
                                    <tr>
                                        <td>
                                            <strong>{{ $stat['meeting']->title }}</strong><br>
                                            <small class="text-muted">{{ $stat['meeting']->category }}</small>
                                        </td>
                                        <td>
                                            {{ $stat['meeting']->date->format('M d') }}<br>
                                            <small>{{ $stat['meeting']->start_time->format('h:i A') }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success">{{ $stat['present'] }}/{{ $stat['total'] }}</span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar {{ $stat['percentage'] >= 80 ? 'bg-success' : ($stat['percentage'] >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                                     role="progressbar" 
                                                     style="width: {{ $stat['percentage'] }}%"
                                                     aria-valuenow="{{ $stat['percentage'] }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $stat['percentage'] }}%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No meetings scheduled for today</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Department Performance -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-building me-2"></i>Department Performance
                    </h6>
                </div>
                <div class="card-body">
                    @if(count($departmentStats) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Department</th>
                                        <th>Present</th>
                                        <th>Late</th>
                                        <th>Absent</th>
                                        <th>Attendance %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($departmentStats as $stat)
                                    <tr>
                                        <td>
                                          <strong>
    {{ collect(json_decode($stat->department, true))->join(', ') ?: 'N/A' }}
</strong><br>
                                            <small class="text-muted">Total: {{ $stat->total }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $stat->present }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ $stat->late }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">{{ $stat->absent }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 15px;">
                                                    <div class="progress-bar {{ $stat->percentage >= 80 ? 'bg-success' : ($stat->percentage >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                                         role="progressbar" 
                                                         style="width: {{ $stat->percentage }}%"
                                                         aria-valuenow="{{ $stat->percentage }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100"></div>
                                                </div>
                                                <span class="small">{{ $stat->percentage }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No attendance data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Attendance - This will be our data source for export -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-2"></i>Recent Attendance Records
                    </h6>
                    <a href="{{ route('admin.attendance.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Add Record
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="attendanceTable">
                            <thead>
                                <tr>
                                    <th>Staff</th>
                                    <th>Meeting</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                    <th>Department</th>
                                    {{-- <th>Approval</th> --}}
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAttendances as $attendance)
                                <tr>
                                    <td>
                                        <strong>{{ $attendance->staff_name }}</strong><br>
                                        <small class="text-muted">{{ $attendance->staff->email ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        {{ $attendance->meeting->title ?? 'N/A' }}<br>
                                        <small class="text-muted">{{ optional($attendance->meeting)->date?->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $attendance->getAttendanceStatusColor() }}">
                                            {{ ucfirst($attendance->status) }}
                                            @if($attendance->isLate())
                                            <i class="fas fa-clock ms-1"></i>
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if($attendance->join_time)
                                            {{ $attendance->join_time->format('h:i A') }}
                                            @if($attendance->leave_time)
                                                <br>
                                                <small class="text-muted">to {{ $attendance->leave_time->format('h:i A') }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                   <td>
                                        {{ collect(json_decode($attendance->department, true))->join(', ') ?: 'N/A' }}
                                    </td>
                                    {{-- <td>
                                        @if($attendance->requires_approval)
                                            @if($attendance->is_approved)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Approved
                                                </span>
                                                <br>
                                                <small class="text-muted">
                                                    by {{ $attendance->approver->name ?? 'N/A' }}
                                                </small>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i>Pending
                                                </span>
                                                @can('approve', $attendance)
                                                <br>
                                                <a href="{{ route('admin.attendance.approve', $attendance) }}" 
                                                   class="btn btn-xs btn-success mt-1"
                                                   onclick="return confirm('Approve this attendance record?')">
                                                    Approve
                                                </a>
                                                @endcan
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">N/A</span>
                                        @endif
                                    </td> --}}
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
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No attendance records found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .stat-card {
        border-left: 4px solid;
        transition: all 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .stat-card.present { border-left-color: #28a745; }
    .stat-card.absent { border-left-color: #dc3545; }
    .stat-card.late { border-left-color: #ffc107; }
    .stat-card.total { border-left-color: #007bff; }
</style>
@endpush

@push('scripts')
<script>
function exportTableToCSV() {
    // Get the table
    const table = document.getElementById('attendanceTable');
    if (!table) {
        alert('No data to export!');
        return;
    }
    
    // Show loading state
    const exportBtn = document.getElementById('exportBtn');
    const originalHtml = exportBtn.innerHTML;
    exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Exporting...';
    exportBtn.disabled = true;
    
    // Get date for filename
    const dateInput = document.querySelector('input[name="date"]');
    const dateValue = dateInput ? dateInput.value : '{{ $date }}';
    const filename = 'attendance_' + dateValue + '.csv';
    
    // Build CSV content
    let csv = '';
    
    // Add headers (skip last column - Actions)
    const headers = [];
    table.querySelectorAll('th').forEach((th, index) => {
        // Skip the last column (Actions)
        if (index < table.querySelectorAll('th').length - 1) {
            headers.push('"' + th.innerText.replace(/"/g, '""') + '"');
        }
    });
    csv += headers.join(',') + '\n';
    
    // Add data rows (skip last column - Actions)
    table.querySelectorAll('tbody tr').forEach(row => {
        const rowData = [];
        row.querySelectorAll('td').forEach((td, index) => {
            // Skip the last column (Actions)
            if (index < row.querySelectorAll('td').length - 1) {
                const text = td.innerText
                    .replace(/(\r\n|\n|\r)/gm, ' ')  // Remove line breaks
                    .replace(/\s+/g, ' ')             // Replace multiple spaces with single space
                    .trim()                           // Trim whitespace
                    .replace(/"/g, '""');             // Escape double quotes
                rowData.push('"' + text + '"');
            }
        });
        csv += rowData.join(',') + '\n';
    });
    
    // Create and download CSV
    try {
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        
        link.href = url;
        link.download = filename;
        link.style.display = 'none';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Clean up
        setTimeout(() => {
            URL.revokeObjectURL(url);
            exportBtn.innerHTML = originalHtml;
            exportBtn.disabled = false;
        }, 1000);
        
    } catch (error) {
        console.error('Error:', error);
        alert('Error exporting data. Please try again.');
        exportBtn.innerHTML = originalHtml;
        exportBtn.disabled = false;
    }
}
</script>
@endpush