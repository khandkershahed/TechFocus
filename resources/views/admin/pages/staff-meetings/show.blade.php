@extends('admin.master')

@section('title', $staffMeeting->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- Meeting Header -->
            <div class="card mb-4 meeting-card meeting-{{ $staffMeeting->status }}">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $staffMeeting->title }}</h4>
                    <span class="badge bg-{{ $staffMeeting->status == 'scheduled' ? 'success' : ($staffMeeting->status == 'cancelled' ? 'danger' : ($staffMeeting->status == 'completed' ? 'info' : 'warning')) }}">
                        {{ ucfirst($staffMeeting->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-calendar me-2"></i>Date:</strong> {{ $staffMeeting->date->format('F d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-clock me-2"></i>Time:</strong> 
                                {{ $staffMeeting->start_time->format('h:i A') }} - {{ $staffMeeting->end_time->format('h:i A') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-tag me-2"></i>Category:</strong> 
                                <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $staffMeeting->category)) }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-building me-2"></i>Department:</strong> {{ $staffMeeting->department ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-map-marker-alt me-2"></i>Type:</strong> {{ ucfirst($staffMeeting->type) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-laptop me-2"></i>Platform:</strong> 
                                {{ ucfirst($staffMeeting->platform) }}
                                @if($staffMeeting->platform == 'online' && $staffMeeting->online_platform)
                                    ({{ ucfirst($staffMeeting->online_platform) }})
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <!-- Agenda -->
                    @if($staffMeeting->agenda)
                    <div class="mb-4">
                        <h5><i class="fas fa-file-alt me-2"></i>Agenda</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($staffMeeting->agenda)) !!}
                        </div>
                    </div>
                    @endif
                    
                    <!-- Notes -->
                    @if($staffMeeting->notes)
                    <div class="mb-4">
                        <h5><i class="fas fa-sticky-note me-2"></i>Notes</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($staffMeeting->notes)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- People Section -->
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6><i class="fas fa-user me-2"></i>Meeting Owner</h6>
                        </div>
                        <div class="card-body text-center">
                            @if($staffMeeting->admin)
                                <div class="mb-2">
                                    <i class="fas fa-user-circle fa-3x text-primary"></i>
                                </div>
                                <h6>{{ $staffMeeting->admin->name }}</h6>
                            @else
                                <p class="text-muted">Not assigned</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6><i class="fas fa-user-tie me-2"></i>Led By</h6>
                        </div>
                        <div class="card-body text-center">
                            @if($staffMeeting->leader)
                                <div class="mb-2">
                                    <i class="fas fa-user-tie fa-3x text-warning"></i>
                                </div>
                                <h6>{{ $staffMeeting->leader->name }}</h6>
                            @else
                                <p class="text-muted">Not assigned</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6><i class="fas fa-user-cog me-2"></i>Organizer</h6>
                        </div>
                        <div class="card-body text-center">
                            @if($staffMeeting->organizer)
                                <div class="mb-2">
                                    <i class="fas fa-user-cog fa-3x text-success"></i>
                                </div>
                                <h6>{{ $staffMeeting->organizer->name }}</h6>
                            @else
                                <p class="text-muted">Not assigned</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
          <!-- Participants Card -->
<div class="card mb-4">
    <div class="card-header">
        <h5><i class="fas fa-users me-2"></i>Participants</h5>
    </div>
    <div class="card-body">
        @php
            // Safely decode participants JSON
            $participantIds = json_decode($staffMeeting->participants, true);
            $participantCount = is_array($participantIds) ? count($participantIds) : 0;
        @endphp
        
        @if($participantCount > 0)
            <div class="list-group">
                @php
                    $participants = \App\Models\Admin::whereIn('id', $participantIds)->get();
                @endphp
                @foreach($participants as $participant)
                    <div class="list-group-item list-group-item-action d-flex align-items-center">
                        <i class="fas fa-user-circle fa-lg text-secondary me-3"></i>
                        <div>
                            <h6 class="mb-0">{{ $participant->name }}</h6>
                            <small class="text-muted">{{ $participant->email }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3 text-center">
                <span class="badge bg-primary">{{ $participantCount }} participants</span>
            </div>
        @else
            <p class="text-muted text-center">No participants added</p>
        @endif
    </div>
</div>
            <!-- Attachments Card -->
            @if($staffMeeting->attachments && count($staffMeeting->attachments) > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-paperclip me-2"></i>Attachments</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($staffMeeting->attachments as $attachment)
                            <a href="{{ asset('storage/' . $attachment['path']) }}" 
                               target="_blank" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file me-2 text-primary"></i>
                                    {{ $attachment['name'] }}
                                </div>
                                <span class="badge bg-light text-dark">{{ formatFileSize($attachment['size']) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Actions Card -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-cogs me-2"></i>Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.staff-meetings.edit', $staffMeeting) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Meeting
                        </a>
                        
                        <!-- Status Update Form -->
                        <form action="{{ route('admin.staff-meetings.update-status', $staffMeeting) }}" method="POST" class="d-grid">
                            @csrf
                            <div class="input-group mb-2">
                                <select name="status" class="form-select">
                                    <option value="scheduled" {{ $staffMeeting->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="rescheduled" {{ $staffMeeting->status == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                                    <option value="completed" {{ $staffMeeting->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $staffMeeting->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-outline-primary">Update</button>
                            </div>
                        </form>
                        
                        <form action="{{ route('admin.staff-meetings.destroy', $staffMeeting) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this meeting?')">
                                <i class="fas fa-trash me-2"></i>Delete Meeting
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.staff-meetings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Meeting Information -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle me-2"></i>Meeting Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Created:</strong> {{ $staffMeeting->created_at->format('M d, Y h:i A') }}</p>
                    <p><strong>Last Updated:</strong> {{ $staffMeeting->updated_at->format('M d, Y h:i A') }}</p>
                    <p><strong>Duration:</strong> {{ $staffMeeting->duration ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Helper function to format file size (you can add this to a global JS file)
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
</script>
@endpush
@endsection