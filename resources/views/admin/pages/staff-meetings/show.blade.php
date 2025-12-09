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
            
            <!-- HR Actions Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-tasks me-2"></i>HR Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <!-- Send Email Reminder -->
                        @if($staffMeeting->canSendReminder())
                        <button type="button" class="btn btn-outline-info" onclick="sendReminder('email', {{ $staffMeeting->id }})">
                            <i class="fas fa-envelope me-2"></i>Send Email Reminder
                        </button>
                        @endif
                        
                        <!-- Generate Meeting Link -->
                        @if($staffMeeting->platform == 'online' && !$staffMeeting->meeting_link)
                        <button type="button" class="btn btn-outline-primary" onclick="generateMeetingLink({{ $staffMeeting->id }})">
                            <i class="fas fa-link me-2"></i>Generate Meeting Link
                        </button>
                        @endif
                        
                        <!-- Generate QR Code -->
                        <button type="button" class="btn btn-outline-warning" onclick="generateQRCode({{ $staffMeeting->id }})">
                            <i class="fas fa-qrcode me-2"></i>Generate Attendance QR
                        </button>
                        
                        <!-- View QR Code -->
                        @if($staffMeeting->attendance_qr_code)
                       <a href="{{ asset('storage/' . str_replace('public/', '', $staffMeeting->attendance_qr_code)) }}" 
                                    target="_blank" 
                                    class="btn btn-outline-success">
                                        <i class="fas fa-eye me-2"></i>View QR Code
                                    </a>
                               @endif
                    </div>
                </div>
            </div>
            
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
                    @if($staffMeeting->meeting_link)
                    <p><strong>Meeting Link:</strong> 
                        <a href="{{ $staffMeeting->meeting_link }}" target="_blank">{{ $staffMeeting->meeting_link }}</a>
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Meeting Minutes Section -->
    @if($staffMeeting->status == 'completed')
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Meeting Minutes</h5>
                </div>
                <div class="card-body">
                    @if($staffMeeting->meeting_minutes)
                        <div class="mb-3">
                            <h6>Minutes Status: 
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger'
                                    ];
                                    $statusColor = $statusColors[$staffMeeting->minutes_status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusColor }}">
                                    {{ ucfirst($staffMeeting->minutes_status) }}
                                </span>
                            </h6>
                            <p><strong>Uploaded by:</strong> 
                                @if($staffMeeting->minutesUploader)
                                    {{ $staffMeeting->minutesUploader->name }}
                                @else
                                    N/A
                                @endif
                               on {{ $staffMeeting->minutes_uploaded_at ? $staffMeeting->minutes_uploaded_at->format('M d, Y h:i A') : 'N/A' }}</p>
                            
                            @if($staffMeeting->minutes_status == 'approved')
                                <p><strong>Approved by:</strong> 
                                    @if($staffMeeting->approver)
                                        {{ $staffMeeting->approver->name }}
                                    @else
                                        N/A
                                    @endif
                                   on {{ $staffMeeting->approved_at ? $staffMeeting->approved_at->format('M d, Y h:i A') : 'N/A' }}</p>
                                @if($staffMeeting->approval_notes)
                                    <p><strong>Approval Notes:</strong> {{ $staffMeeting->approval_notes }}</p>
                                @endif
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <h6>Minutes Content:</h6>
                            <div class="border p-3 bg-light">
                                {!! nl2br(e($staffMeeting->meeting_minutes)) !!}
                            </div>
                        </div>
                        
                        @if($staffMeeting->minutes_attachments && count($staffMeeting->minutes_attachments) > 0)
                            <div class="mb-3">
                                <h6>Attachments:</h6>
                                <ul class="list-group">
                                    @foreach($staffMeeting->minutes_attachments as $attachment)
                                        <li class="list-group-item">
                                            <a href="{{ Storage::url($attachment['path']) }}" target="_blank" class="text-decoration-none">
                                                <i class="fas fa-paperclip me-2"></i> {{ $attachment['name'] }}
                                                <span class="badge bg-light text-dark ms-2">{{ formatFileSize($attachment['size']) }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        @if(auth('admin')->user()->canApproveMinutes() && $staffMeeting->canApproveMinutes())
                            <div class="mt-4">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveMinutesModal">
                                    <i class="fas fa-check"></i> Approve Minutes
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectMinutesModal">
                                    <i class="fas fa-times"></i> Reject Minutes
                                </button>
                            </div>
                        @endif
                        
                    @else
                        @if(auth('admin')->user()->id == $staffMeeting->organizer_id || auth('admin')->user()->hasRole('hr'))
                            <form action="{{ route('admin.staff-meetings.upload-minutes', $staffMeeting) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Meeting Minutes *</label>
                                    <textarea name="meeting_minutes" class="form-control" rows="10" required></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Attachments</label>
                                    <input type="file" name="minutes_attachments[]" class="form-control" multiple>
                                    <small class="text-muted">You can upload multiple files (max 5MB each)</small>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i> Upload Minutes
                                </button>
                            </form>
                        @else
                            <p class="text-muted">Minutes not uploaded yet. Only organizer or HR can upload minutes.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Minutes Modal -->
    <div class="modal fade" id="approveMinutesModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Meeting Minutes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.staff-meetings.approve-minutes', $staffMeeting) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Approval Notes (Optional)</label>
                            <textarea name="approval_notes" class="form-control" rows="3"></textarea>
                        </div>
                        <p>Are you sure you want to approve these meeting minutes?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Approve Minutes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Minutes Modal -->
    <div class="modal fade" id="rejectMinutesModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Meeting Minutes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.staff-meetings.reject-minutes', $staffMeeting) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Rejection Reason *</label>
                            <textarea name="approval_notes" class="form-control" rows="3" required></textarea>
                            <small class="text-muted">Please provide a reason for rejection</small>
                        </div>
                        <p>Are you sure you want to reject these meeting minutes?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Minutes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- QR Code Modal (will be dynamically inserted) -->
<div id="qrCodeModalContainer"></div>

@push('scripts')
<script>
    // Helper function to format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Function to send reminder
    function sendReminder(type, meetingId) {
        if (confirm('Send ' + type + ' reminder to all participants?')) {
            const url = type === 'email' 
                ? `/admin/staff-meetings/${meetingId}/send-email-reminder`
                : `/admin/staff-meetings/${meetingId}/send-whatsapp-reminder`;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            if (!csrfToken) {
                alert('Security token not found. Please refresh the page.');
                return;
            }
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || 'Reminder sent successfully');
                location.reload();
            })
            .catch(error => {
                alert('Error sending reminder');
                console.error(error);
            });
        }
    }

    // Function to generate meeting link
    function generateMeetingLink(meetingId) {
        if (confirm('Generate meeting link for this online meeting?')) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            fetch(`/admin/staff-meetings/${meetingId}/generate-link`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                }
            })
            .then(response => response.json())
            .then(data => {
                alert('Meeting link generated: ' + data.link);
                location.reload();
            })
            .catch(error => {
                alert('Error generating link');
                console.error(error);
            });
        }
    }

    // Function to generate and show QR code
    function generateQRCode(meetingId) {
        if (confirm('Generate attendance QR code for this meeting?')) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            if (!csrfToken) {
                alert('Security token not found. Please refresh the page.');
                return;
            }
            
            // Show loading
            const button = event.target;
            const originalHtml = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating...';
            button.disabled = true;
            
            fetch(`/admin/staff-meetings/${meetingId}/generate-qr`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                button.innerHTML = originalHtml;
                button.disabled = false;
                
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show QR code in modal
                    showQRCodeModal(data.qr_code_url, data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error generating QR code: ' + error.message);
            });
        }
    }

    // Function to show QR code in modal
    function showQRCodeModal(qrCodeUrl, message) {
        // Create modal HTML
        const modalHtml = `
            <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="qrCodeModalLabel">Attendance QR Code</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <p class="text-success mb-3"><i class="fas fa-check-circle me-2"></i>${message}</p>
                            <div id="qrCodeContainer">
                                <img src="${qrCodeUrl}" alt="Attendance QR Code" class="img-fluid mb-3" style="max-width: 300px; max-height: 300px; border: 1px solid #dee2e6; padding: 10px;">
                                <p class="text-muted small">Scan this QR code to mark attendance</p>
                            </div>
                            <div class="mt-3">
                                <a href="${qrCodeUrl}" class="btn btn-primary btn-sm me-2" download="meeting_qr_code.png" target="_blank">
                                    <i class="fas fa-download me-1"></i> Download
                                </a>
                                <button type="button" class="btn btn-success btn-sm" onclick="copyQRCodeLink('${qrCodeUrl}')">
                                    <i class="fas fa-copy me-1"></i> Copy Link
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Remove existing modal if any
        const existingModal = document.getElementById('qrCodeModal');
        if (existingModal) {
            existingModal.remove();
        }
        
        // Add modal to container
        document.getElementById('qrCodeModalContainer').innerHTML = modalHtml;
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('qrCodeModal'));
        modal.show();
    }

    // Function to copy QR code link
    function copyQRCodeLink(url) {
        navigator.clipboard.writeText(url)
            .then(() => {
                // Show success message
                const copyBtn = event.target;
                const originalText = copyBtn.innerHTML;
                copyBtn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
                copyBtn.classList.remove('btn-success');
                copyBtn.classList.add('btn-info');
                
                setTimeout(() => {
                    copyBtn.innerHTML = originalText;
                    copyBtn.classList.remove('btn-info');
                    copyBtn.classList.add('btn-success');
                }, 2000);
            })
            .catch(err => {
                console.error('Failed to copy: ', err);
                alert('Failed to copy link to clipboard');
            });
    }
</script>
@endpush
@endsection