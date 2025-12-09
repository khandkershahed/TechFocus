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

/* Responsive adjustments */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn-group-sm .btn {
        padding: 0.2rem 0.4rem;
        font-size: 0.8rem;
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
                                <a href="{{ route('admin.staff-meetings.show', $meeting) }}" 
                                   class="btn btn-outline-info" 
                                   title="View Details"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="{{ route('admin.staff-meetings.edit', $meeting) }}" 
                                   class="btn btn-outline-warning" 
                                   title="Edit Meeting"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if($meeting->status === 'scheduled')
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
                            </div>
                        </td>
                        
                        <!-- HR Actions Column -->
                        <td>
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
});

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