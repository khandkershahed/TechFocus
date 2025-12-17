@extends('admin.master')
@section('title', 'Mark Attendance')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-check me-2"></i>Mark Attendance
        </h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
        </a>
    </div>

    <!-- CHECK IF ADMIN IS LOGGED IN -->
    @if(!auth('admin')->check())
    <div class="alert alert-danger">
        <h4><i class="fas fa-exclamation-triangle me-2"></i>Admin Authentication Required</h4>
        <p>You need to be logged in as an admin to mark attendance.</p>
        <a href="{{ route('admin.login') }}" class="btn btn-primary">
            <i class="fas fa-sign-in-alt me-2"></i>Admin Login
        </a>
    </div>
    @else
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <!-- Debug Info (Remove after testing) -->
            {{-- <div class="alert alert-info mb-3">
                <h6><i class="fas fa-info-circle me-2"></i>Debug Information</h6>
                <p class="mb-1">Admin ID: <strong>{{ auth('admin')->id() }}</strong></p>
                <p class="mb-1">Admin Name: <strong>{{ auth('admin')->user()->name ?? 'Unknown' }}</strong></p>
                <p class="mb-1">Admin Email: <strong>{{ auth('admin')->user()->email ?? 'Unknown' }}</strong></p>
                <p class="mb-1">Department: <strong>{{ auth('admin')->user()->department ?? 'Not set' }}</strong></p>
            </div> --}}

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Submit Attendance Request</h6>
                    <small class="text-muted">Logged in as: {{ auth('admin')->user()->name }} (Admin ID: {{ auth('admin')->id() }})</small>
                </div>
                <div class="card-body text-center">
                    <!-- Simple Meeting Selection -->
                    <div class="mb-4">
                        <label class="form-label">Select Meeting *</label>
                        <select id="meetingSelect" class="form-control form-control-lg" required>
                            <option value="">Choose Meeting</option>
                            @foreach($meetings as $meeting)
                                <option value="{{ $meeting->id }}">
                                    {{ $meeting->title }} - {{ $meeting->date->format('M d, Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            
                    <!-- Single Present Button -->
                    <div class="mt-5">
                     <button id="presentButton" class="btn btn-primary btn-sm w-100"
                                    style="height: 55px; font-size: 1rem;">
                                <i class="fas fa-check-circle fa-lg me-2"></i>
                                <span>I AM PRESENT</span>
                     </button>
                    </div>
                    
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Your attendance request will be sent for approval.
                    </div>
                </div>
            </div>

            {{-- <!-- Pending Requests Section -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">My Pending Requests</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Meeting</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Requested</th>
                            </tr>
                        </thead>
                        <tbody id="pendingRequestsList">
                            <!-- Will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Check if CSRF token exists
function getCsrfToken() {
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    if (!metaTag) {
        console.error('❌ CSRF token meta tag not found!');
        return '';
    }
    return metaTag.getAttribute('content');
}

// Submit attendance request
async function submitAttendanceRequest() {
    console.log('🔄 submitAttendanceRequest() called');
    
    const meetingId = document.getElementById('meetingSelect').value;
    console.log('Selected meeting ID:', meetingId);
    
    if (!meetingId) {
        alert('⚠️ Please select a meeting first.');
        return;
    }
    
    // Get admin ID from PHP (fix the syntax)
    const adminId = @json(auth('admin')->id());
    console.log('Admin ID:', adminId);
    
    if (!adminId) {
        alert('❌ Admin not authenticated. Please login again.');
        return;
    }
    
    const btn = document.getElementById('presentButton');
    const originalHTML = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
    
    try {
        const csrfToken = getCsrfToken();
        console.log('CSRF Token:', csrfToken);
        
        const response = await fetch('{{ route("admin.attendance.submit-request") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ 
                meeting_id: meetingId,
                staff_id: adminId  // Use admin ID as staff_id
            })
        });
        
        console.log('📥 Response status:', response.status);
        
        // Handle non-JSON responses
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Non-JSON response:', text);
            throw new Error('Server returned non-JSON response');
        }
        
        const result = await response.json();
        console.log('Response data:', result);
        
        if (result.success) {
            alert('✅ ' + result.message);
            loadPendingRequests();
        } else {
            alert('❌ ' + result.message);
        }
    } catch (error) {
        console.error('🚨 Fetch error:', error);
        alert('⚠️ Error: ' + error.message);
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalHTML;
    }
}

// Load pending requests
async function loadPendingRequests() {
    try {
        console.log('📥 Loading pending requests...');
        const response = await fetch('{{ route("admin.attendance.my-requests") }}', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Server returned non-JSON response');
        }
        
        const requests = await response.json();
        console.log('Pending requests loaded:', requests);
        
        const tbody = document.getElementById('pendingRequestsList');
        if (!tbody) {
            console.error('Table body not found');
            return;
        }
        
        tbody.innerHTML = '';
        
        if (!requests || requests.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center">No pending requests</td></tr>';
            return;
        }
        
        requests.forEach(request => {
            const row = document.createElement('tr');
            
            // Safe date handling
            let meetingDate = 'N/A';
            if (request.meeting && request.meeting.date) {
                try {
                    meetingDate = new Date(request.meeting.date).toLocaleDateString();
                } catch (e) {
                    meetingDate = request.meeting.date;
                }
            }
            
            let requestDate = 'N/A';
            if (request.created_at) {
                try {
                    requestDate = new Date(request.created_at).toLocaleString();
                } catch (e) {
                    requestDate = request.created_at;
                }
            }
            
            row.innerHTML = `
                <td>${request.meeting?.title || 'Meeting'}</td>
                <td>${meetingDate}</td>
                <td><span class="badge bg-warning">${request.status || 'pending'}</span></td>
                <td>${requestDate}</td>
            `;
            tbody.appendChild(row);
        });
    } catch (error) {
        console.error('Error loading requests:', error);
        const tbody = document.getElementById('pendingRequestsList');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Error loading requests</td></tr>';
        }
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 DOM fully loaded - initializing attendance system');
    
    // Check if admin is logged in
    const isLoggedIn = @json(auth('admin')->check());
    console.log('Admin logged in:', isLoggedIn);
    
    if (isLoggedIn) {
        // Attach click event to button
        const presentButton = document.getElementById('presentButton');
        if (presentButton) {
            presentButton.addEventListener('click', submitAttendanceRequest);
            console.log('✅ Button event listener attached');
        } else {
            console.error('❌ Button element not found');
        }
        
        // Load pending requests
        loadPendingRequests();
    }
});

// Make functions globally available
window.submitAttendanceRequest = submitAttendanceRequest;
window.loadPendingRequests = loadPendingRequests;
</script>
@endpush