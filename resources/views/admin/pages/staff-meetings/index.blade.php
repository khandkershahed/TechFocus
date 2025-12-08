@extends('admin.master')

@section('title', 'Staff Meetings')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Meetings</h6>
                            <h2>{{ $stats['total'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-calendar fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Scheduled</h6>
                            <h2>{{ $stats['scheduled'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-clock fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Upcoming</h6>
                            <h2>{{ $stats['upcoming'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Cancelled</h6>
                            <h2>{{ $stats['cancelled'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-calendar-times fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-users me-2"></i>Staff Meetings</h1>
        <a href="{{ route('admin.staff-meetings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Schedule New Meeting
        </a>
    </div>

    <!-- Filter Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.staff-meetings.index') }}">All</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'scheduled' ? 'active' : '' }}" 
               href="{{ route('admin.staff-meetings.filter.status', 'scheduled') }}">Scheduled</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'upcoming' ? 'active' : '' }}" 
               href="{{ route('admin.staff-meetings.upcoming') }}">Upcoming</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" 
               href="{{ route('admin.staff-meetings.filter.status', 'completed') }}">Completed</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}" 
               href="{{ route('admin.staff-meetings.filter.status', 'cancelled') }}">Cancelled</a>
        </li>
    </ul>

    <!-- Meetings Table -->
    <div class="card">
        <div class="card-body">
            @if(isset($meetings) && $meetings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date & Time</th>
                                <th>Category</th>
                                <th>Organizer</th>
                                <th>Participants</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meetings as $meeting)
                                <tr class="meeting-card meeting-{{ $meeting->status }}">
                                    <td>
                                        <strong>{{ $meeting->title }}</strong><br>
                                        <small class="text-muted">{{ $meeting->agenda ? \Illuminate\Support\Str::limit($meeting->agenda, 50) : 'No agenda' }}</small>
                                    </td>
                                    <td>
                                        <strong>Date:</strong> {{ $meeting->date->format('M d, Y') }}<br>
                                        <strong>Time:</strong> {{ $meeting->start_time->format('h:i A') }} - {{ $meeting->end_time->format('h:i A') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ ucfirst(str_replace('_', ' ', $meeting->category)) }}
                                        </span><br>
                                        <small>{{ $meeting->department }}</small>
                                    </td>
                                    <td>
                                        @if($meeting->organizer)
                                            {{ $meeting->organizer->name }}
                                        @else
                                            <span class="text-muted">Not assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                            @php
                                                // Decode the JSON string to array
                                                $participantsArray = json_decode($meeting->participants, true) ?? [];
                                                $participantsCount = is_array($participantsArray) ? count($participantsArray) : 0;
                                            @endphp
                                            
                                            @if($participantsCount > 0)
                                                <span class="badge bg-secondary">{{ $participantsCount }} participants</span>
                                            @else
                                                <span class="text-muted">No participants</span>
                                            @endif
                                        </td>
                                    <td>
                                        <span class="badge status-badge bg-{{ $meeting->status == 'scheduled' ? 'success' : ($meeting->status == 'cancelled' ? 'danger' : ($meeting->status == 'completed' ? 'info' : 'warning')) }}">
                                            {{ ucfirst($meeting->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.staff-meetings.show', $meeting) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.staff-meetings.edit', $meeting) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.staff-meetings.destroy', $meeting) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $meetings->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                    <h4>No meetings found</h4>
                    <p class="text-muted">Schedule your first meeting to get started</p>
                    <a href="{{ route('admin.staff-meetings.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Schedule Meeting
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
</script>
@endpush
@endsection