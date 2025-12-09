@extends('admin.master')

@section('title', 'Attendance Heatmap')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fire me-2"></i>Attendance Heatmap
        </h1>
        <div>
            <a href="{{ route('admin.attendance.dashboard') }}" class="btn btn-info me-2">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Heatmap Settings
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attendance.heatmap') }}" method="GET">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">View By</label>
                        <select name="date_range" class="form-control" onchange="this.form.submit()">
                            <option value="month" {{ $dateRange == 'month' ? 'selected' : '' }}>This Month</option>
                            <option value="week" {{ $dateRange == 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="quarter" {{ $dateRange == 'quarter' ? 'selected' : '' }}>This Quarter</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Or Select Meeting</label>
                        <select name="meeting_id" class="form-control" onchange="this.form.submit()">
                            <option value="">All Meetings</option>
                            @foreach($meetings as $mtg)
                                <option value="{{ $mtg->id }}" {{ $meetingId == $mtg->id ? 'selected' : '' }}>
                                    {{ $mtg->title }} ({{ $mtg->date->format('M d') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Heatmap Legend -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle me-2"></i>Color Legend
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-2">
                    <div class="d-flex align-items-center">
                        <div class="color-box" style="background-color: #28a745; width: 20px; height: 20px; margin-right: 10px;"></div>
                        <span>90-100% (Excellent)</span>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="d-flex align-items-center">
                        <div class="color-box" style="background-color: #20c997; width: 20px; height: 20px; margin-right: 10px;"></div>
                        <span>70-89% (Good)</span>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="d-flex align-items-center">
                        <div class="color-box" style="background-color: #ffc107; width: 20px; height: 20px; margin-right: 10px;"></div>
                        <span>50-69% (Average)</span>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="d-flex align-items-center">
                        <div class="color-box" style="background-color: #dc3545; width: 20px; height: 20px; margin-right: 10px;"></div>
                        <span>Below 50% (Poor)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Heatmap Display -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                @if($meeting)
                    <i class="fas fa-users me-2"></i>Heatmap for: {{ $meeting->title }}
                    <small class="text-muted">({{ $meeting->date->format('F d, Y') }})</small>
                @else
                    <i class="fas fa-calendar me-2"></i>Attendance Heatmap - {{ ucfirst($dateRange) }} View
                @endif
            </h6>
        </div>
        <div class="card-body">
            @if(empty($heatmapData))
                <div class="text-center py-5">
                    <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No data available</h4>
                    <p>Select a meeting or date range to view heatmap</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Staff Name</th>
                                <th>Department</th>
                                @if($meeting)
                                    <th class="text-center">Status</th>
                                    <th>Join Time</th>
                                @else
                                    <th class="text-center">Total Meetings</th>
                                    <th class="text-center">Attended</th>
                                    <th class="text-center">Late</th>
                                    <th class="text-center">Absent</th>
                                    <th class="text-center">Attendance Rate</th>
                                @endif
                                <th>Heat Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($heatmapData as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item['staff_name'] }}</strong><br>
                                    <small class="text-muted">ID: {{ $item['staff_id'] }}</small>
                                </td>
                                <td>{{ $item['department'] ?? 'N/A' }}</td>
                                
                                @if($meeting)
                                    <td class="text-center">
                                        <span class="badge" style="background-color: {{ $item['color'] }}; color: white;">
                                            {{ strtoupper($item['status']) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item['join_time'])
                                            {{ \Carbon\Carbon::parse($item['join_time'])->format('h:i A') }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                @else
                                    <td class="text-center">{{ $item['total_meetings'] }}</td>
                                    <td class="text-center text-success">{{ $item['attended'] }}</td>
                                    <td class="text-center text-warning">{{ $item['late'] }}</td>
                                    <td class="text-center text-danger">{{ $item['absent'] }}</td>
                                    <td class="text-center">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" 
                                                 role="progressbar" 
                                                 style="width: {{ $item['attendance_rate'] }}%; background-color: {{ $item['heat_color'] }}">
                                                {{ $item['attendance_rate'] }}%
                                            </div>
                                        </div>
                                    </td>
                                @endif
                                
                                <td>
                                    <div class="heat-cell" 
                                         style="background-color: {{ $meeting ? $item['color'] : $item['heat_color'] }};
                                                width: 100px; height: 30px; border-radius: 4px;">
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection