@extends('admin.master')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Movement Edit Requests</h5>
                <span class="badge bg-warning">{{ $requests->count() }} Pending</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Staff</th>
                            <th>Date</th>
                            <th>Country</th>
                            <th>Requested By</th>
                            <th>Requested At</th>
                            <th>Reason</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $record)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $record->admin->name ?? 'N/A' }}</td>
                            <td>{{ $record->date->format('d/m/Y') }}</td>
                            <td>{{ $record->country->name ?? 'N/A' }}</td>
                            <td>{{ $record->editRequester->name ?? 'N/A' }}</td>
                            <td>{{ $record->edit_requested_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <small>{{ Str::limit($record->edit_request_reason, 50) }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#approveModal{{ $record->id }}">
                                        <i class="bi bi-check"></i> Approve
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#rejectModal{{ $record->id }}">
                                        <i class="bi bi-x"></i> Reject
                                    </button>
                                    <a href="{{ route('admin.movement.show', $record->id) }}" 
                                       class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Approve Modal -->
                        <div class="modal fade" id="approveModal{{ $record->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.movement.approve-edit', $record->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Approve Edit Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to approve this edit request?</p>
                                            <div class="mb-3">
                                                <p><strong>Record Owner:</strong> {{ $record->admin->name }}</p>
                                                <p><strong>Requested By:</strong> {{ $record->editRequester->name }}</p>
                                                <p><strong>Date:</strong> {{ $record->date->format('d/m/Y') }}</p>
                                                <p><strong>Requested At:</strong> {{ $record->edit_requested_at->format('d/m/Y H:i') }}</p>
                                                @if($record->edit_request_reason)
                                                <p><strong>Reason:</strong> {{ $record->edit_request_reason }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Approve</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal{{ $record->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.movement.reject-edit', $record->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reject Edit Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="edit_rejection_reason{{ $record->id }}" class="form-label">Rejection Reason</label>
                                                <textarea class="form-control" id="edit_rejection_reason{{ $record->id }}" 
                                                          name="edit_rejection_reason" rows="3" required 
                                                          placeholder="Please provide a reason for rejecting this edit request..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                                <p class="mt-3">No pending edit requests</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- In your form view (create/edit.blade.php) -->
<script>
// Show manual edit popup
function showManualEditPopup() {
    // Prevent form submission
    event.preventDefault();
    event.stopPropagation();
    
    // Clear previous reason
    document.getElementById('editReasonInput').value = '';
    
    // Show the popup
    document.getElementById("popupBox").classList.remove("d-none");
    
    return false;
}

// Hide popup
function hidePopup() {
    document.getElementById("popupBox").classList.add("d-none");
}

// Submit manual edit request
function submitManualEditRequest() {
    const reason = document.getElementById('editReasonInput').value;
    
    if (!reason.trim()) {
        alert('Please provide a reason for the edit request');
        return;
    }
    
    // Set the hidden fields
    document.getElementById('requestManualEdit').value = '1';
    document.getElementById('editReason').value = reason;
    
    // Hide the popup
    hidePopup();
    
    // Submit the form
    document.getElementById('movementForm').submit();
}

// Override form submission for edit requests
document.getElementById('movementForm').addEventListener('submit', function(e) {
    const requestEdit = document.getElementById('requestManualEdit').value;
    
    // If it's an edit request, we don't need to validate other fields
    if (requestEdit === '1') {
        return true; // Allow form submission
    }
    
    // Otherwise, validate as normal
    // You can add your normal validation here if needed
});

// Calculate duration
function calculateDuration() {
    const startTime = document.getElementById('start_time').value;
    const endTime = document.getElementById('end_time').value;
    const durationField = document.getElementById('duration');
    const durationDisplay = document.getElementById('duration_display');
    
    if (startTime && endTime) {
        const start = new Date('1970-01-01T' + startTime + ':00');
        const end = new Date('1970-01-01T' + endTime + ':00');
        
        if (end < start) {
            end.setDate(end.getDate() + 1);
        }
        
        const diffMs = end - start;
        const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
        const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
        
        const durationString = 
            diffHours.toString().padStart(2, '0') + ':' + 
            diffMinutes.toString().padStart(2, '0') + ':00';
        
        if (durationField) durationField.value = durationString;
        if (durationDisplay) durationDisplay.value = `${diffHours}h ${diffMinutes}m`;
    }
}

// Set current time for Start/Finish buttons
function setCurrentTime(fieldId) {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const timeString = `${hours}:${minutes}`;
    
    document.getElementById(fieldId).value = timeString;
    calculateDuration();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateDuration();
    
    // Apply readonly styling
    document.querySelectorAll('select[disabled], input[readonly], textarea[readonly]')
        .forEach(el => {
            el.classList.add('readonly-field');
        });
});
</script>
@endsection