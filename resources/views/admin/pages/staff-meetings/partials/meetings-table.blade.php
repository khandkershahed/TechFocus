<style>
/* Table styling */
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
}

.meeting-card:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

/* Status badges */
.badge {
    padding: 6px 12px;
    font-size: 0.85em;
    font-weight: 500;
}

/* Button group */
.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}

.btn-group-sm .btn:not(:last-child) {
    margin-right: 2px;
}

/* Hover effects */
.btn-outline-info:hover { background-color: #0dcaf0; color: white; }
.btn-outline-warning:hover { background-color: #ffc107; color: black; }
.btn-outline-success:hover { background-color: #198754; color: white; }
.btn-outline-danger:hover { background-color: #dc3545; color: white; }

/* Present Button Styles */
.present-btn {
    min-width: 100px;
    white-space: nowrap;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn-group-sm .btn {
        padding: 0.2rem 0.4rem;
        font-size: 0.8rem;
    }
    
    .present-btn {
        min-width: 80px;
        font-size: 0.75rem;
    }
}
</style>

@if($meetings->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Meeting Title</th>
                    <th>Dept</th>
                    <th>Organizer</th>
                    <th>Participants</th>
                    <th>Status</th>
                    <th>Actions</th>
                    <th>HR Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($meetings as $meeting)
                    <tr class="meeting-card meeting-{{ $meeting->status }}">
                        <!-- Date Column -->
                        <td>
                            <strong>{{ $meeting->date->format('M d, Y') }}</strong><br>
                            <small class="text-muted">{{ $meeting->date->format('l') }}</small>
                        </td>
                        
                        <!-- Time Column -->
                        <td>
                            <div class="fw-bold">{{ $meeting->start_time->format('h:i A') }}</div>
                            <div class="text-muted small">to {{ $meeting->end_time->format('h:i A') }}</div>
                            @if($meeting->duration)
                                <div class="text-muted small">
                                    <i class="fas fa-clock"></i> 
                                    @php
                                        $start = \Carbon\Carbon::parse($meeting->start_time);
                                        $end = \Carbon\Carbon::parse($meeting->end_time);
                                        $duration = $start->diff($end);
                                    @endphp
                                    {{ $duration->h }}h {{ $duration->i }}m
                                </div>
                            @endif
                        </td>
                        
                        <!-- Meeting Title Column -->
                        <td>
                            <div class="fw-bold">{{ $meeting->title }}</div>
                            <div class="text-muted small">
                                <i class="fas fa-clipboard-list"></i> 
                                {{ $meeting->agenda ? \Illuminate\Support\Str::limit($meeting->agenda, 60) : 'No agenda' }}
                            </div>
                            <div class="mt-1">
                                <span class="badge bg-secondary">
                                    <i class="fas fa-tag"></i> 
                                    {{ ucfirst(str_replace('_', ' ', $meeting->category)) }}
                                </span>
                                @if($meeting->type)
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-users"></i> {{ ucfirst($meeting->type) }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Department Column -->
                        <td>
                            <span class="badge bg-primary">
                                <i class="fas fa-building"></i> {{ $meeting->department ?? 'General' }}
                            </span>
                        </td>
                        
                        <!-- Organizer Column -->
                        <td>
                            @if($meeting->organizer)
                                <div class="fw-bold">{{ $meeting->organizer->name }}</div>
                                <div class="text-muted small">
                                    <i class="fas fa-envelope"></i> {{ $meeting->organizer->email ?? 'N/A' }}
                                </div>
                            @else
                                <span class="text-muted">Not assigned</span>
                            @endif
                        </td>
                        
                        <!-- Participants Column -->
                        <td>
                            @php
                                $participantsArray = json_decode($meeting->participants, true) ?? [];
                                $participantsCount = is_array($participantsArray) ? count($participantsArray) : 0;
                            @endphp
                            
                            @if($participantsCount > 0)
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-info me-2">
                                        <i class="fas fa-user-friends"></i> {{ $participantsCount }}
                                    </span>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="popover" 
                                            data-bs-html="true"
                                            data-bs-title="Participants"
                                            data-bs-content="
                                                @if($participantsCount > 0)
                                                    @php
                                                        $participantIds = $participantsArray;
                                                        $participantNames = \App\Models\Admin::whereIn('id', $participantIds)
                                                            ->pluck('name')
                                                            ->toArray();
                                                    @endphp
                                                    <ul class='list-unstyled mb-0'>
                                                        @foreach($participantNames as $name)
                                                            <li><i class='fas fa-user me-2'></i>{{ $name }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    No participants
                                                @endif
                                            ">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                </div>
                            @else
                                <span class="text-muted">No participants</span>
                            @endif
                        </td>
                        
                        <!-- Status Column -->
                        <td>
                            @php
                                $statusColors = [
                                    'scheduled' => ['bg' => 'success', 'icon' => 'clock'],
                                    'completed' => ['bg' => 'info', 'icon' => 'check-circle'],
                                    'cancelled' => ['bg' => 'danger', 'icon' => 'times-circle'],
                                    'rescheduled' => ['bg' => 'warning', 'icon' => 'calendar-alt']
                                ];
                                $statusConfig = $statusColors[$meeting->status] ?? ['bg' => 'secondary', 'icon' => 'question-circle'];
                            @endphp
                            
                            <span class="badge bg-{{ $statusConfig['bg'] }} d-flex align-items-center" style="width: fit-content;">
                                <i class="fas fa-{{ $statusConfig['icon'] }} me-1"></i>
                                {{ ucfirst($meeting->status) }}
                            </span>
                        </td>
                        
                        <!-- Actions Column -->
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                        <!-- View Button - HR only -->
                                            @if(auth()->user()->department == 'hr')
                                                <a href="{{ route('admin.staff-meetings.show', $meeting) }}" 
                                                class="btn btn-outline-info" 
                                                title="View Details"
                                                data-bs-toggle="tooltip">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            
                                            <!-- Edit Button - HR only -->
                                            @if(auth()->user()->department == 'hr')
                                                <a href="{{ route('admin.staff-meetings.edit', $meeting) }}" 
                                                class="btn btn-outline-warning" 
                                                title="Edit Meeting"
                                                data-bs-toggle="tooltip">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                
                             <!-- I AM PRESENT Button - Regular Actions -->
                                    @if($meeting->status === 'scheduled' && $meeting->date->isToday())
                                    <button class="btn btn-primary btn-sm mark-present-btn" 
                                            data-meeting-id="{{ $meeting->id }}"
                                            data-meeting-title="{{ $meeting->title }}"
                                            title="Mark yourself as present for this meeting"
                                            data-bs-toggle="tooltip">
                                        P
                                    </button>
                                    @endif
                              <!-- Mark as Completed - HR only -->
        @if(auth()->user()->department == 'hr' && $meeting->status === 'scheduled')
            <form action="{{ route('admin.staff-meetings.update-status', $meeting) }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('Mark this meeting as completed?')">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="completed">
                <button type="submit" 
                        class="btn btn-outline-success" 
                        title="Mark as Completed"
                        data-bs-toggle="tooltip">
                    <i class="fas fa-check"></i>
                </button>
            </form>
        @endif
        
        <!-- Delete Button - HR only -->
        @if(auth()->user()->department == 'hr')
            <form action="{{ route('admin.staff-meetings.destroy', $meeting) }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('Are you sure you want to delete this meeting?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="btn btn-outline-danger" 
                        title="Delete Meeting"
                        data-bs-toggle="tooltip">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        @endif
                            </div>
                        </td>
                        
                      <!-- HR Actions Column -->
<td>
    @if(auth()->user()->department == 'hr' || auth()->user()->hasRole('hr'))
        <div class="btn-group btn-group-sm">
            <!-- Send Reminders -->
            @if($meeting->canSendReminder())
                <button type="button" class="btn btn-outline-info" 
                        onclick="sendReminder('email', {{ $meeting->id }})"
                        title="Send Email Reminder">
                    <i class="fas fa-envelope"></i>
                </button>
                <button type="button" class="btn btn-outline-success" 
                        onclick="sendReminder('whatsapp', {{ $meeting->id }})"
                        title="Send WhatsApp Reminder">
                    <i class="fab fa-whatsapp"></i>
                </button>
            @endif
            
            <!-- Generate Links -->
            @if($meeting->platform == 'online' && !$meeting->meeting_link)
                <button type="button" class="btn btn-outline-primary"
                        onclick="generateMeetingLink({{ $meeting->id }})"
                        title="Generate Meeting Link">
                    <i class="fas fa-link"></i>
                </button>
            @endif
            
            <!-- Attendance QR -->
            <button type="button" class="btn btn-outline-warning"
                    onclick="generateQRCode({{ $meeting->id }})"
                    title="Generate Attendance QR Code">
                <i class="fas fa-qrcode"></i>
            </button>
            
            <!-- Upload Minutes -->
            @if($meeting->status == 'completed' && !$meeting->meeting_minutes)
                <a href="{{ route('admin.staff-meetings.show', $meeting) }}#minutes" 
                   class="btn btn-outline-secondary"
                   title="Upload Minutes">
                    <i class="fas fa-file-alt"></i>
                </a>
            @endif
        </div>
    @else
        <!-- Show nothing or alternative content for non-HR users -->
        {{-- <span class="text-muted">HR Actions</span> --}}
    @endif
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
        <p class="text-muted">No meetings match your filters</p>
        <button id="clear-all-filters" class="btn btn-primary">
            <i class="fas fa-times me-1"></i> Clear Filters
        </button>
    </div>
@endif

<!-- Mark Present Modal -->
<div class="modal fade" id="markPresentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-check me-2"></i>Mark Attendance
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-check-circle fa-4x text-primary mb-3"></i>
                    <h4 id="meetingTitleDisplay"></h4>
                    <p class="text-muted">Are you sure you want to mark yourself as present for this meeting?</p>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Your attendance request will be sent to the admin for approval.
                </div>
                
                <div class="form-check mt-3">
                    <input type="checkbox" class="form-check-input" id="confirmAttendance">
                    <label class="form-check-label" for="confirmAttendance">
                        I confirm that I will attend this meeting
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmPresentBtn" disabled>
                    <i class="fas fa-check-circle me-2"></i>Yes, I Am Present
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Initialize tooltips
$(document).ready(function() {
    // Tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Popovers for participants
    $('[data-bs-toggle="popover"]').popover({
        trigger: 'hover',
        placement: 'left',
        container: 'body'
    });
    
    // Handle clear filters button
    $('#clear-all-filters').click(function() {
        $('.filter-input').val('');
        loadMeetings();
    });
    
    // Initialize Mark Present functionality
    initMarkPresent();
});

// Mark Present functionality
function initMarkPresent() {
    // Store current meeting ID
    let currentMeetingId = null;
    
    // Event delegation for dynamically loaded buttons
    $(document).on('click', '.mark-present-btn', function(e) {
        e.preventDefault();
        currentMeetingId = $(this).data('meeting-id');
        const meetingTitle = $(this).data('meeting-title');
        
        // Update modal content
        $('#meetingTitleDisplay').text(meetingTitle);
        $('#confirmAttendance').prop('checked', false);
        $('#confirmPresentBtn').prop('disabled', true);
        
        // Show modal
        $('#markPresentModal').modal('show');
    });
    
    // Enable/disable confirm button based on checkbox
    $('#confirmAttendance').on('change', function() {
        $('#confirmPresentBtn').prop('disabled', !$(this).is(':checked'));
    });
    
    // Handle confirm button click
    $('#confirmPresentBtn').click(function() {
        if (!currentMeetingId) return;
        
        // Get current admin ID
        const adminId = @json(auth('admin')->id());
        if (!adminId) {
            showNotification('error', 'You must be logged in to mark attendance.', {
                title: 'Authentication Required'
            });
            return;
        }
        
        // Disable button and show loading
        const btn = $(this);
        const originalText = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Submitting...');
        btn.prop('disabled', true);
        
        // Submit attendance request
        submitAttendanceRequest(currentMeetingId, adminId, btn, originalText);
    });
    
    // Function to submit attendance request
    function submitAttendanceRequest(meetingId, staffId, btn, originalText) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        if (!csrfToken) {
            showNotification('error', 'Security token not found. Please refresh the page.', {
                title: 'Security Error'
            });
            btn.html(originalText);
            btn.prop('disabled', false);
            return;
        }
        
        $.ajax({
            url: '{{ route("admin.attendance.submit-request") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                meeting_id: meetingId,
                staff_id: staffId
            },
            success: function(response) {
                console.log('Attendance submission response:', response);
                
                if (response.success) {
                    // Show success message
                    showNotification('success', response.message, {
                        title: 'Success!',
                        duration: 5000
                    });
                    
                    // Close modal
                    $('#markPresentModal').modal('hide');
                    
                    // Update button to show success state
                    const meetingBtns = $(`.mark-present-btn[data-meeting-id="${meetingId}"]`);
                    meetingBtns.each(function() {
                        $(this).html('<i class="fas fa-check"></i> Requested');
                        $(this).removeClass('btn-primary').addClass('btn-success');
                        $(this).prop('disabled', true);
                        $(this).attr('title', 'Attendance request submitted');
                    });
                } else {
                    // Handle different error types
                    handleAttendanceError(response, meetingId);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                let errorMessage = 'Network error. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 422) {
                    errorMessage = 'Validation error. Please check your input.';
                } else if (xhr.status === 401) {
                    errorMessage = 'You must be logged in to mark attendance.';
                }
                
                showNotification('error', errorMessage, {
                    title: 'Submission Failed'
                });
            },
            complete: function() {
                // Reset confirm button
                btn.html(originalText);
                btn.prop('disabled', false);
            }
        });
    }
    
    // Function to handle different attendance error types
    function handleAttendanceError(result, meetingId) {
        console.log('Attendance error:', result);
        
        switch(result.type) {
            case 'already_approved':
                showNotification('info', 'Your attendance for this meeting has already been approved.', {
                    title: 'Already Approved',
                    icon: 'fas fa-check-circle'
                });
                updateButtonToApproved(meetingId);
                break;
                
            case 'pending_exists':
                showNotification('warning', 'You already have a pending request for this meeting.', {
                    title: 'Request Pending',
                    icon: 'fas fa-clock'
                });
                updateButtonToPending(meetingId);
                break;
                
            case 'rejected_exists':
                showNotification('error', 'Your previous request was rejected. Please contact admin.', {
                    title: 'Request Rejected',
                    icon: 'fas fa-times-circle'
                });
                updateButtonToRejected(meetingId);
                break;
                
            case 'attendance_exists':
                showNotification('info', 'Attendance already recorded for this meeting.', {
                    title: 'Already Recorded',
                    icon: 'fas fa-clipboard-check'
                });
                updateButtonToRecorded(meetingId);
                break;
                
            default:
                showNotification('error', result.message || 'Failed to submit attendance request.', {
                    title: 'Error',
                    icon: 'fas fa-exclamation-triangle'
                });
        }
    }
    
    // Helper functions to update button states
    function updateButtonToApproved(meetingId) {
        const meetingBtns = $(`.mark-present-btn[data-meeting-id="${meetingId}"]`);
        meetingBtns.each(function() {
            $(this).html('<i class="fas fa-check-double"></i> Approved');
            $(this).removeClass('btn-primary').addClass('btn-success');
            $(this).prop('disabled', true);
            $(this).attr('title', 'Attendance approved');
        });
    }
    
    function updateButtonToPending(meetingId) {
        const meetingBtns = $(`.mark-present-btn[data-meeting-id="${meetingId}"]`);
        meetingBtns.each(function() {
            $(this).html('<i class="fas fa-clock"></i> Pending');
            $(this).removeClass('btn-primary').addClass('btn-warning');
            $(this).prop('disabled', true);
            $(this).attr('title', 'Request pending approval');
        });
    }
    
    function updateButtonToRejected(meetingId) {
        const meetingBtns = $(`.mark-present-btn[data-meeting-id="${meetingId}"]`);
        meetingBtns.each(function() {
            $(this).html('<i class="fas fa-times"></i> Rejected');
            $(this).removeClass('btn-primary').addClass('btn-danger');
            $(this).prop('disabled', true);
            $(this).attr('title', 'Request rejected');
        });
    }
    
    function updateButtonToRecorded(meetingId) {
        const meetingBtns = $(`.mark-present-btn[data-meeting-id="${meetingId}"]`);
        meetingBtns.each(function() {
            $(this).html('<i class="fas fa-clipboard-check"></i> Recorded');
            $(this).removeClass('btn-primary').addClass('btn-info');
            $(this).prop('disabled', true);
            $(this).attr('title', 'Attendance already recorded');
        });
    }
    
    // Function to show notifications
    function showNotification(type, message, options = {}) {
        const title = options.title || type.charAt(0).toUpperCase() + type.slice(1);
        const icon = options.icon || 
            (type === 'success' ? 'fas fa-check-circle' : 
             type === 'warning' ? 'fas fa-exclamation-triangle' : 
             type === 'info' ? 'fas fa-info-circle' :
             'fas fa-times-circle');
        const duration = options.duration || 3000;
        
        // Remove any existing notifications
        $('.attendance-notification').remove();
        
        // Create notification
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'warning' ? 'alert-warning' :
                          type === 'info' ? 'alert-info' : 'alert-danger';
        
        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show attendance-notification position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <div class="d-flex align-items-center">
                    <i class="${icon} fa-lg me-3"></i>
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold">${title}</h6>
                        <p class="mb-0 small">${message}</p>
                    </div>
                    <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
                </div>
            </div>
        `);
        
        $('body').append(notification);
        
        // Auto remove after duration
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, duration);
    }
}

// Handle pagination clicks
$(document).on('click', '.pagination a', function(e) {
    e.preventDefault();
    
    // Get page number from URL
    const url = $(this).attr('href');
    const page = new URL(url).searchParams.get('page');
    
    // Update page in filters and reload
    $('input[name="page"]').val(page);
    loadMeetings();
});

function sendReminder(type, meetingId) {
    if (confirm('Send ' + type + ' reminder to all participants?')) {
        const url = type === 'email' 
            ? `/admin/staff-meetings/${meetingId}/send-email-reminder`
            : `/admin/staff-meetings/${meetingId}/send-whatsapp-reminder`;
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        if (!csrfToken) {
            alert('Security token not found. Please refresh the page.');
            return;
        }
        
        // Show loading state
        const button = event.target;
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        console.log('Sending request to:', url);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status, response.statusText);
            
            // Reset button
            button.innerHTML = originalHtml;
            button.disabled = false;
            
            if (!response.ok) {
                // Try to get error message from response
                return response.json().then(errorData => {
                    console.error('Error response:', errorData);
                    throw new Error(errorData.message || `HTTP error! Status: ${response.status}`);
                }).catch(() => {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Success response:', data);
            if (data.success) {
                alert(data.message || 'Reminder sent successfully!');
                // Refresh the page to update timestamps
                setTimeout(() => location.reload(), 1500);
            } else {
                alert('Error: ' + (data.message || 'Failed to send reminder.'));
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Error sending reminder: ' + error.message + '\n\nCheck browser console for details.');
        });
    }
}

function generateMeetingLink(meetingId) {
    if (confirm('Generate meeting link for this online meeting?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        if (!csrfToken) {
            alert('Security token not found. Please refresh the page.');
            return;
        }
        
        // Show loading state
        const button = event.target;
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        console.log('Generating link for meeting:', meetingId);
        
        fetch(`/admin/staff-meetings/${meetingId}/generate-link`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status, response.statusText);
            
            // Reset button
            button.innerHTML = originalHtml;
            button.disabled = false;
            
            if (!response.ok) {
                return response.json().then(errorData => {
                    console.error('Error response:', errorData);
                    throw new Error(errorData.message || `HTTP error! Status: ${response.status}`);
                }).catch(() => {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Success response:', data);
            if (data.success) {
                alert(data.message + '\n\nLink: ' + (data.link || 'No link generated'));
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Error generating link: ' + error.message + '\n\nCheck browser console for details.');
        });
    }
}

function generateQRCode(meetingId) {
    if (confirm('Generate attendance QR code for this meeting?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        if (!csrfToken) {
            alert('Security token not found. Please refresh the page.');
            return;
        }
        
        // Show loading state
        const button = event.target;
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        console.log('Generating QR code for meeting:', meetingId);
        
        fetch(`/admin/staff-meetings/${meetingId}/generate-qr`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status, response.statusText);
            
            // Reset button
            button.innerHTML = originalHtml;
            button.disabled = false;
            
            if (!response.ok) {
                return response.json().then(errorData => {
                    console.error('Error response:', errorData);
                    throw new Error(errorData.message || `HTTP error! Status: ${response.status}`);
                }).catch(() => {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Success response:', data);
            if (data.success) {
                alert(data.message || 'QR code generated successfully!');
                if (data.qr_code_url) {
                    // Open QR code in new tab
                    window.open(data.qr_code_url, '_blank');
                }
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Error generating QR code: ' + error.message + '\n\nCheck browser console for details.');
        });
    }
}
</script>
@endpush