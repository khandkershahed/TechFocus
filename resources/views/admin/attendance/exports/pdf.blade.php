<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report - {{ date('Y-m-d') }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #333; margin-bottom: 5px; }
        .header p { color: #666; }
        .stats { margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px; }
        .stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; }
        .stat-card { text-align: center; padding: 15px; background: white; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-card h3 { margin: 0; color: #333; }
        .stat-card p { margin: 5px 0 0; color: #666; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #2c3e50; color: white; padding: 10px; text-align: left; }
        td { padding: 8px 10px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background: #f9f9f9; }
        .status-present { color: #28a745; }
        .status-late { color: #ffc107; }
        .status-absent { color: #dc3545; }
        .status-leave { color: #17a2b8; }
        .footer { margin-top: 30px; text-align: center; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Attendance Report</h1>
        <p>Generated on: {{ now()->format('F d, Y h:i A') }}</p>
        
        @if(!empty($filters))
        <p>
            Filters: 
            @if(!empty($filters['date_from']) && !empty($filters['date_to']))
                Date: {{ $filters['date_from'] }} to {{ $filters['date_to'] }}
            @endif
            @if(!empty($filters['department']))
                | Department: {{ $filters['department'] }}
            @endif
            @if(!empty($filters['status']))
                | Status: {{ ucfirst($filters['status']) }}
            @endif
        </p>
        @endif
    </div>

    <div class="stats">
        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ $stats['total'] }}</h3>
                <p>Total Records</p>
            </div>
            <div class="stat-card">
                <h3 class="status-present">{{ $stats['present'] }}</h3>
                <p>Present</p>
            </div>
            <div class="stat-card">
                <h3 class="status-late">{{ $stats['late'] }}</h3>
                <p>Late</p>
            </div>
            <div class="stat-card">
                <h3 class="status-absent">{{ $stats['absent'] }}</h3>
                <p>Absent</p>
            </div>
            <div class="stat-card">
                <h3>{{ $stats['present_percentage'] }}%</h3>
                <p>Attendance Rate</p>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Staff</th>
                <th>Department</th>
                <th>Meeting</th>
                <th>Date</th>
                <th>Status</th>
                <th>Join Time</th>
                <th>Leave Time</th>
                <th>Duration</th>
                <th>Approval</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $attendance->staff_name }}</td>
                <td>{{ $attendance->department ?? 'N/A' }}</td>
                <td>{{ $attendance->meeting->title ?? 'N/A' }}</td>
                <td>{{ $attendance->created_at->format('M d, Y') }}</td>
                <td class="status-{{ $attendance->status }}">
                    {{ ucfirst($attendance->status) }}
                </td>
                <td>
                    @if($attendance->join_time)
                        {{ $attendance->join_time->format('h:i A') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($attendance->leave_time)
                        {{ $attendance->leave_time->format('h:i A') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($attendance->join_time && $attendance->leave_time)
                        {{ $attendance->durationInMinutes() }} mins
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($attendance->requires_approval)
                        @if($attendance->is_approved)
                            <span style="color: #28a745;">✓ Approved</span>
                        @else
                            <span style="color: #ffc107;">⏳ Pending</span>
                        @endif
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Confidential - For HR & Management Use Only</p>
        <p>Page 1 of 1</p>
    </div>
</body>
</html>