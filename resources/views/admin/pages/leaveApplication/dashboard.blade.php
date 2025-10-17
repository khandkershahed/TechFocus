@extends('admin.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 card rounded-0 shadow-sm">
                <div class="card card-flush">
                    <div class="card-header align-items-center gap-2 gap-md-5">
                        <div class="container-fluid">
                            <div class="row align-items-center py-3">
                                <div class="col-lg-4 col-sm-12 text-lg-start text-sm-center">
                                    <!-- Search Section -->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <span class="svg-icon svg-icon-2 svg-icon-gray-700 position-absolute top-50 translate-middle-y ms-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <input type="text" id="dashboardSearch" class="form-control form-control-sm form-control-solid w-150px ps-14 rounded-0" placeholder="Search..." style="border: 1px solid #eee;" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 text-lg-center text-sm-center">
                                    <div class="card-title table_title">
                                        <h2 class="mb-0">Leave Management Dashboard</h2>
                                        <small class="text-muted">Welcome, {{ Auth::user()->name ?? 'User' }}</small>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 text-lg-end text-sm-center">
                                    <a href="{{ route('leave-applications.create') }}" class="btn btn-sm btn-success rounded-0 me-2">
                                        <i class="fa-solid fa-plus me-1"></i>New Application
                                    </a>
                                    <a href="{{ route('leave-applications.index') }}" class="btn btn-sm btn-light-primary rounded-0">
                                        <i class="fa-solid fa-list me-1"></i>View All
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Statistics Cards -->
                        <div class="row mb-4">
                            <div class="col-xl-3 col-lg-6 mb-4">
                                <div class="card card-custom bg-primary bg-opacity-10 border-0 rounded-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="text-primary mb-1">Total Applications</h6>
                                                <h3 class="text-primary mb-0">{{ $totalApplications ?? 0 }}</h3>
                                                <small class="text-muted">All time</small>
                                            </div>
                                            <div class="bg-primary rounded-circle p-3">
                                                <i class="fa-solid fa-file-lines text-white fa-lg"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-lg-6 mb-4">
                                <div class="card card-custom bg-success bg-opacity-10 border-0 rounded-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="text-success mb-1">Approved</h6>
                                                <h3 class="text-success mb-0">{{ $approvedApplications ?? 0 }}</h3>
                                                <small class="text-muted">{{ $approvedPercentage ?? 0 }}% of total</small>
                                            </div>
                                            <div class="bg-success rounded-circle p-3">
                                                <i class="fa-solid fa-circle-check text-white fa-lg"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-lg-6 mb-4">
                                <div class="card card-custom bg-warning bg-opacity-10 border-0 rounded-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="text-warning mb-1">Pending</h6>
                                                <h3 class="text-warning mb-0">{{ $pendingApplications ?? 0 }}</h3>
                                                <small class="text-muted">{{ $pendingPercentage ?? 0 }}% of total</small>
                                            </div>
                                            <div class="bg-warning rounded-circle p-3">
                                                <i class="fa-solid fa-clock text-white fa-lg"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-lg-6 mb-4">
                                <div class="card card-custom bg-danger bg-opacity-10 border-0 rounded-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h6 class="text-danger mb-1">Rejected</h6>
                                                <h3 class="text-danger mb-0">{{ $rejectedApplications ?? 0 }}</h3>
                                                <small class="text-muted">{{ $rejectedPercentage ?? 0 }}% of total</small>
                                            </div>
                                            <div class="bg-danger rounded-circle p-3">
                                                <i class="fa-solid fa-circle-xmark text-white fa-lg"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="row">
                            <!-- Employee Status & Leave Balance -->
                            <div class="col-lg-4">
                                <!-- Employee Status Card -->
                                <div class="card info-cards p-1 rounded-0 main_color mb-3">
                                    <h6 class="text-center mb-0 p-0">
                                        <i class="fa-solid fa-user me-2"></i>Employee Status
                                    </h6>
                                </div>
                                <div class="info-details card px-3 py-3 rounded-0 mb-4">
                                    <p class="p-0 m-0 text-muted d-flex justify-content-between">
                                        <span><i class="fa-solid fa-briefcase me-2"></i>Job Status</span>
                                        <span class="text-danger fw-bold">{{ $user->getCategoryName() ?? 'Not set' }}</span>
                                    </p>
                                    <p class="p-0 m-0 text-muted d-flex justify-content-between mt-2">
                                        <span><i class="fa-solid fa-calendar-day me-2"></i>Next Evaluation</span>
                                        <span class="text-danger fw-bold">{{ Auth::user()->evaluation_date ? \Carbon\Carbon::parse(Auth::user()->evaluation_date)->format('M d, Y') : 'Not set' }}</span>
                                    </p>
                                    <p class="p-0 m-0 text-muted d-flex justify-content-between mt-2">
                                        <span><i class="fa-solid fa-id-card me-2"></i>Designation</span>
                                        <span class="text-danger fw-bold">{{ Auth::user()->designation ?? 'Not set' }}</span>
                                    </p>
                                    <p class="p-0 m-0 text-muted d-flex justify-content-between mt-2">
                                        <span><i class="fa-solid fa-calendar-plus me-2"></i>Joining Date</span>
                                        <span class="text-danger fw-bold">{{ Auth::user()->sign_date ? \Carbon\Carbon::parse(Auth::user()->sign_date)->format('M d, Y') : 'Not set' }}</span>
                                    </p>
                                    
                                    <!-- Employee Category Info -->
                                    @if($employeeCategory)
                                        <div class="mt-3 p-2 bg-light rounded">
                                            <small class="text-success">
                                                <i class="fa-solid fa-info-circle me-1"></i>
                                                Category: {{ $employeeCategory->name ?? 'N/A' }}
                                            </small>
                                        </div>
                                    @else
                                        <div class="mt-3 p-2 bg-warning rounded">
                                            <small class="text-dark">
                                                <i class="fa-solid fa-exclamation-triangle me-1"></i>
                                                Employee category not set. Using default leave values.
                                            </small>
                                        </div>
                                    @endif
                                </div>

                                <!-- Quick Actions -->
                                <div class="card info-cards p-1 rounded-0 main_color mb-3">
                                    <h6 class="text-center mb-0 p-0">
                                        <i class="fa-solid fa-bolt me-2"></i>Quick Actions
                                    </h6>
                                </div>
                                <div class="info-details card px-3 py-3 rounded-0">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <a href="{{ route('leave-applications.create') }}" class="btn btn-success btn-sm w-100 mb-2">
                                                <i class="fa-solid fa-plus me-1"></i>Apply Leave
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('leave-applications.history') }}" class="btn btn-primary btn-sm w-100 mb-2">
                                                <i class="fa-solid fa-history me-1"></i>History
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <button class="btn btn-info btn-sm w-100 mb-2" onclick="showLeavePolicy()">
                                                <i class="fa-solid fa-file-lines me-1"></i>Policy
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button class="btn btn-warning btn-sm w-100 mb-2" onclick="showLeaveBalance()">
                                                <i class="fa-solid fa-calculator me-1"></i>Balance
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Leave Balance Overview -->
                            <div class="col-lg-8">
                                <div class="card info-cards p-1 rounded-0 main_color mb-3">
                                    <h6 class="text-center mb-0 p-0">
                                        <i class="fa-solid fa-chart-pie me-2"></i>Leave Balance Overview
                                    </h6>
                                </div>
                                
                                <div class="row gx-2">
                                    <div class="col-lg-4 mb-3">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-header bg-success text-white text-center py-2">
                                                <h6 class="mb-0">Casual Leave</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                <div class="progress mb-3" style="height: 20px;">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                         style="width: {{ $casualLeavePercentage ?? 0 }}%" 
                                                         aria-valuenow="{{ $casualLeavePercentage ?? 0 }}" 
                                                         aria-valuemin="0" aria-valuemax="100">
                                                        {{ $casualLeavePercentage ?? 0 }}%
                                                    </div>
                                                </div>
                                                <p class="mb-1"><strong>Yearly:</strong> {{ $yearlyCasualLeave ?? '10' }}</p>
                                                <p class="mb-1"><strong>Availed:</strong> {{ $casualLeaveAvailed ?? '0' }}</p>
                                                <p class="mb-0"><strong>Due:</strong> {{ $casualLeaveDue ?? '10' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4 mb-3">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-header bg-primary text-white text-center py-2">
                                                <h6 class="mb-0">Earned Leave</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                <div class="progress mb-3" style="height: 20px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" 
                                                         style="width: {{ $earnedLeavePercentage ?? 0 }}%" 
                                                         aria-valuenow="{{ $earnedLeavePercentage ?? 0 }}" 
                                                         aria-valuemin="0" aria-valuemax="100">
                                                        {{ $earnedLeavePercentage ?? 0 }}%
                                                    </div>
                                                </div>
                                                <p class="mb-1"><strong>Yearly:</strong> {{ $yearlyEarnedLeave ?? '15' }}</p>
                                                <p class="mb-1"><strong>Availed:</strong> {{ $earnedLeaveAvailed ?? '0' }}</p>
                                                <p class="mb-0"><strong>Due:</strong> {{ $earnedLeaveDue ?? '15' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4 mb-3">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-header bg-info text-white text-center py-2">
                                                <h6 class="mb-0">Medical Leave</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                <div class="progress mb-3" style="height: 20px;">
                                                    <div class="progress-bar bg-info" role="progressbar" 
                                                         style="width: {{ $medicalLeavePercentage ?? 0 }}%" 
                                                         aria-valuenow="{{ $medicalLeavePercentage ?? 0 }}" 
                                                         aria-valuemin="0" aria-valuemax="100">
                                                        {{ $medicalLeavePercentage ?? 0 }}%
                                                    </div>
                                                </div>
                                                <p class="mb-1"><strong>Yearly:</strong> {{ $yearlyMedicalLeave ?? '14' }}</p>
                                                <p class="mb-1"><strong>Availed:</strong> {{ $medicalLeaveAvailed ?? '0' }}</p>
                                                <p class="mb-0"><strong>Due:</strong> {{ $medicalLeaveDue ?? '14' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Applications -->
                                <div class="card mt-4 border-0 shadow-sm">
                                    <div class="card-header bg-light py-3">
                                        <h6 class="mb-0">
                                            <i class="fa-solid fa-clock-rotate-left me-2"></i>Recent Applications
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @if($recentApplications && $recentApplications->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Type</th>
                                                            <th>Period</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($recentApplications as $application)
                                                            <tr>
                                                                <td>{{ \Carbon\Carbon::parse($application->created_at)->format('M d, Y') }}</td>
                                                                <td>{{ $application->type_of_leave }}</td>
                                                                <td>{{ $application->total_days }} days</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $application->application_status == 'approved' ? 'success' : ($application->application_status == 'rejected' ? 'danger' : 'warning') }}">
                                                                        {{ ucfirst($application->application_status) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#applicationDetails{{ $application->id }}">
                                                                        <i class="fa-solid fa-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted text-center mb-0">No recent applications found.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Policy Modal -->
    <div class="modal fade" id="leavePolicyModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Leave Policy</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6>Casual Leave</h6>
                            <ul class="list-unstyled">
                                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Maximum {{ $yearlyCasualLeave ?? 10 }} days per year</li>
                                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Minimum 1 day advance notice</li>
                                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Can be taken in half days</li>
                            </ul>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Earned Leave</h6>
                            <ul class="list-unstyled">
                                <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ $yearlyEarnedLeave ?? 15 }} days per year</li>
                                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Can be accumulated</li>
                                <li><i class="fa-solid fa-circle-check text-success me-2"></i>30 days notice for long leave</li>
                            </ul>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Medical Leave</h6>
                            <ul class="list-unstyled">
                                <li><i class="fa-solid fa-circle-check text-success me-2"></i>{{ $yearlyMedicalLeave ?? 14 }} days per year</li>
                                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Medical certificate required</li>
                                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Can be extended in special cases</li>
                            </ul>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Other Leaves</h6>
                            <ul class="list-unstyled">
                                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Maternity Leave: 120 days</li>
                                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Paternity Leave: 7 days</li>
                                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Emergency Leave: As needed</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Detail Modals -->
    @if($recentApplications && $recentApplications->count() > 0)
        @foreach($recentApplications as $application)
            <div class="modal fade" id="applicationDetails{{ $application->id }}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content rounded-0">
                        <div class="modal-header bg-secondary text-white">
                            <h5 class="modal-title">Application Details</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Applicant:</strong> {{ $application->name }}</p>
                                    <p><strong>Designation:</strong> {{ $application->designation }}</p>
                                    <p><strong>Leave Type:</strong> {{ $application->type_of_leave }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>From:</strong> {{ \Carbon\Carbon::parse($application->leave_start_date)->format('M d, Y') }}</p>
                                    <p><strong>To:</strong> {{ \Carbon\Carbon::parse($application->leave_end_date)->format('M d, Y') }}</p>
                                    <p><strong>Total Days:</strong> {{ $application->total_days }}</p>
                                </div>
                                <div class="col-12 mt-3">
                                    <p><strong>Reason:</strong></p>
                                    <p class="border p-2 rounded">{{ $application->leave_explanation }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection

@push('styles')
<style>
    .main_color {
        background-color: #2472974f !important;
        color: #174a62 !important;
    }
    .info-cards h6 {
        font-weight: 600;
    }
    .info-details {
        border: 1px solid #e0e0e0;
    }
    .progress {
        border-radius: 10px;
    }
    .progress-bar {
        border-radius: 10px;
        font-weight: 600;
    }
    .card-custom {
        transition: transform 0.2s ease-in-out;
    }
    .card-custom:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@push('scripts')
<script>
    function showLeavePolicy() {
        new bootstrap.Modal(document.getElementById('leavePolicyModal')).show();
    }

    function showLeaveBalance() {
        alert('Leave Balance Details:\n\n' +
              'Casual Leave: {{ $casualLeaveDue ?? 10 }} days remaining\n' +
              'Earned Leave: {{ $earnedLeaveDue ?? 15 }} days remaining\n' +
              'Medical Leave: {{ $medicalLeaveDue ?? 14 }} days remaining');
    }

    // Search functionality
    document.getElementById('dashboardSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        // Implement search functionality as needed
        console.log('Searching for:', searchTerm);
    });
</script>
@endpush