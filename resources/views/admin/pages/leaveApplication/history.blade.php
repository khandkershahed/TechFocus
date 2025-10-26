@extends('admin.master')
@section('content')
    <div class="container-fluid h-100">
        <div class="row">
            <div class="col-lg-12 card rounded-0 shadow-sm">
                <div class="card card-p-0 card-flush">
                    <div class="card-header align-items-center pt-2 pb-1 gap-2 gap-md-5">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 text-lg-start text-sm-center">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <span
                                            class="svg-icon svg-icon-2 svg-icon-gray-700 position-absolute top-50 translate-middle-y ms-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                                    rx="1" transform="rotate(45 17.0365 15.1223)"
                                                    fill="currentColor">
                                                </rect>
                                                <path
                                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <input type="text" data-kt-filter="search"
                                            class="form-control form-control-sm form-control-solid w-150px ps-14 rounded-0"
                                            placeholder="Search" style="border: 1px solid #eee;" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <div class="col-lg-4 col-sm-12 text-lg-center text-sm-center">
                                    <div class="card-title table_title">
                                        <h2>Leave Applications History</h2>
                                        <small class="text-muted">Total: {{ $leaveApplications->count() }} applications</small>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 text-lg-end text-sm-center">
                                    <a href="{{ route('leave-applications.index') }}"
                                        class="btn btn-sm btn-light-primary rounded-0 me-3">
                                        <i class="fa-solid fa-arrow-left me-1"></i>Back to Current
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($leaveApplications->count() > 0)
                            <table
                                class="table table-striped table-hover align-middle rounded-0 table-row-bordered border fs-6 g-5 border"
                                id="kt_datatable_example">
                                <thead class="table_header_bg">
                                    <tr class="text-center text-gray-900 fw-bolder fs-7 text-uppercase">
                                        <th width="5%" class="text-center">Sl:</th>
                                        <th width="20%">Applicant name</th>
                                        <th width="15%">Type Of Leave</th>
                                        <th width="15%">Designation</th>
                                        <th width="15%">Applied Date</th>
                                        <th width="15%">Status</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600 text-center">
                                    @foreach ($leaveApplications as $leaveApplication)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $leaveApplication->name }}</td>
                                            <td>{{ $leaveApplication->type_of_leave }}</td>
                                            <td>{{ $leaveApplication->designation }}</td>
                                            <td>{{ \Carbon\Carbon::parse($leaveApplication->created_at)->format('M d, Y') }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $leaveApplication->application_status == 'approved' ? 'success' : ($leaveApplication->application_status == 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ $leaveApplication->application_status == 'approved' ? 'Approved' : ($leaveApplication->application_status == 'rejected' ? 'Rejected' : 'Pending') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <!-- Details Button -->
                                                <a href="javascript:void(0);" class="text-info me-2" data-bs-toggle="modal"
                                                    data-bs-target="#leaveDetailsModal-{{ $leaveApplication->id }}"
                                                    title="View Details">
                                                    <i class="fa-solid fa-eye p-1 rounded-circle text-white"
                                                        style="color: #247297 !important;"></i>
                                                </a>
                                                <!-- Edit Button -->
                                                <a href="javascript:void(0);" class="text-primary me-2" data-bs-toggle="modal"
                                                    data-bs-target="#leaveEditModal-{{ $leaveApplication->id }}"
                                                    title="Edit">
                                                    <i class="fa-solid fa-pen-to-square p-1 rounded-circle text-white"
                                                        style="color: #247297 !important;"></i>
                                                </a>
                                                <!-- Delete Button -->
                                                <a href="javascript:void(0);" class="text-danger delete-leave" 
                                                    data-id="{{ $leaveApplication->id }}"
                                                    data-url="{{ route('leave-applications.destroy', $leaveApplication->id ) }}"
                                                    title="Delete">
                                                    <i class="fa-solid fa-trash p-1 rounded-circle text-white"
                                                        style="color: #247297 !important;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Simple Pagination Info -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted">
                                    Showing {{ $leaveApplications->count() }} of {{ $totalApplications ?? $leaveApplications->count() }} applications
                                </div>
                                @if($leaveApplications->count() >= 10)
                                    <div class="alert alert-info alert-dismissible fade show py-2" role="alert">
                                        <small>
                                            <i class="fa-solid fa-info-circle me-1"></i>
                                            Showing recent applications. Use search to find specific records.
                                        </small>
                                        <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fa-solid fa-inbox fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No Leave Applications Found</h4>
                                <p class="text-muted">There are no leave applications in history yet.</p>
                                <a href="{{ route('leave-applications.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-plus me-1"></i>Create First Application
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Details Modals --}}
    @foreach ($leaveApplications as $leaveApplication)
        <!-- Details Modal -->
        <div class="modal fade" id="leaveDetailsModal-{{ $leaveApplication->id }}" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
            aria-labelledby="leaveDetailsLabel-{{ $leaveApplication->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-0">
                    <div class="modal-header rounded-0 text-white bg-info">
                        <h5 class="modal-title text-uppercase" id="leaveDetailsLabel-{{ $leaveApplication->id }}">
                            <i class="fa-solid fa-eye me-2"></i>Leave Application Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body rounded-0">
                        <div class="container">
                            <!-- Personal Information -->
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="section-header bg-light-info p-2 rounded">
                                        <h6 class="mb-0 text-info">
                                            <i class="fa-solid fa-user me-2"></i>Personal Information
                                        </h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Applicant Name:</label>
                                    <p class="mb-0">{{ $leaveApplication->name }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Designation:</label>
                                    <p class="mb-0">{{ $leaveApplication->designation }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Company:</label>
                                    <p class="mb-0">{{ $leaveApplication->company }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Type Of Leave:</label>
                                    <p class="mb-0">{{ $leaveApplication->type_of_leave }}</p>
                                </div>
                            </div>

                            <!-- Leave Details -->
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="section-header bg-light-info p-2 rounded">
                                        <h6 class="mb-0 text-info">
                                            <i class="fa-solid fa-calendar-days me-2"></i>Leave Details
                                        </h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label class="form-label mb-0 fw-bold">Leave Start Date:</label>
                                    <p class="mb-0">{{ \Carbon\Carbon::parse($leaveApplication->leave_start_date)->format('M d, Y') }}</p>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label mb-0 fw-bold">Leave End Date:</label>
                                    <p class="mb-0">{{ \Carbon\Carbon::parse($leaveApplication->leave_end_date)->format('M d, Y') }}</p>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label mb-0 fw-bold">Total Days:</label>
                                    <p class="mb-0">{{ $leaveApplication->total_days }} days</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Reporting On:</label>
                                    <p class="mb-0">{{ \Carbon\Carbon::parse($leaveApplication->reporting_on)->format('M d, Y') }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Job Status:</label>
                                    <p class="mb-0">{{ $leaveApplication->job_status }}</p>
                                </div>
                            </div>

                            <!-- Leave Explanation -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label mb-0 fw-bold">Leave Explanation:</label>
                                    <div class="border p-3 rounded bg-light">
                                        {{ $leaveApplication->leave_explanation }}
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="section-header bg-light-info p-2 rounded">
                                        <h6 class="mb-0 text-info">
                                            <i class="fa-solid fa-address-card me-2"></i>Contact & Additional Information
                                        </h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Substitute During Leave:</label>
                                    <p class="mb-0">{{ $leaveApplication->substitute_during_leave }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Leave Address:</label>
                                    <p class="mb-0">{{ $leaveApplication->leave_address ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Leave Contact Number:</label>
                                    <p class="mb-0">{{ $leaveApplication->leave_contact_no ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Include Open Saturday:</label>
                                    <p class="mb-0">{{ $leaveApplication->included_open_saturday ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Is Between Holidays:</label>
                                    <p class="mb-0">{{ $leaveApplication->is_between_holidays == 'yes' ? 'Yes' : 'No' }}</p>
                                </div>
                            </div>

                            <!-- Application Status -->
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="section-header bg-light-info p-2 rounded">
                                        <h6 class="mb-0 text-info">
                                            <i class="fa-solid fa-tasks me-2"></i>Application Status
                                        </h6>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Application Status:</label>
                                    <p class="mb-0">
                                        <span class="badge bg-{{ $leaveApplication->application_status == 'approved' ? 'success' : ($leaveApplication->application_status == 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($leaveApplication->application_status) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mb-0 fw-bold">Applied Date:</label>
                                    <p class="mb-0">{{ \Carbon\Carbon::parse($leaveApplication->created_at)->format('M d, Y h:i A') }}</p>
                                </div>
                                @if($leaveApplication->note)
                                <div class="col-12 mb-2">
                                    <label class="form-label mb-0 fw-bold">Additional Notes:</label>
                                    <p class="mb-0">{{ $leaveApplication->note }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="leaveEditModal-{{ $leaveApplication->id }}" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
            aria-labelledby="leaveEditLabel-{{ $leaveApplication->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-0">
                    <div class="modal-header rounded-0 text-white bg-warning">
                        <h5 class="modal-title text-uppercase" id="leaveEditLabel-{{ $leaveApplication->id }}">
                            <i class="fa-solid fa-edit me-2"></i>Edit Leave Application
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('leave-applications.update', $leaveApplication->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body rounded-0">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0 required">Application Status</label>
                                        <select class="form-select form-select-sm" name="application_status" required>
                                            <option value="pending" {{ $leaveApplication->application_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $leaveApplication->application_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ $leaveApplication->application_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0">Additional Notes</label>
                                        <textarea class="form-control form-control-sm" name="note" 
                                                  rows="2" placeholder="Any additional notes...">{{ $leaveApplication->note }}</textarea>
                                    </div>
                                </div>
                                
                                <!-- Hidden fields to preserve other data -->
                                <input type="hidden" name="name" value="{{ $leaveApplication->name }}">
                                <input type="hidden" name="designation" value="{{ $leaveApplication->designation }}">
                                <input type="hidden" name="type_of_leave" value="{{ $leaveApplication->type_of_leave }}">
                                <input type="hidden" name="leave_start_date" value="{{ $leaveApplication->leave_start_date }}">
                                <input type="hidden" name="leave_end_date" value="{{ $leaveApplication->leave_end_date }}">
                                <input type="hidden" name="total_days" value="{{ $leaveApplication->total_days }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning btn-sm">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('styles')
<style>
    .table_header_bg {
        background-color: #2472974f !important;
    }
    .section-header {
        border-left: 4px solid;
        background-color: #f8f9fa !important;
    }
    .bg-light-info {
        background-color: #d1ecf1 !important;
    }
    .required::after {
        content: " *";
        color: #dc3545;
    }
</style>
@endpush

@push('scripts')
<script>
    // Delete functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Delete leave application
        document.querySelectorAll('.delete-leave').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const leaveId = this.getAttribute('data-id');
                const deleteUrl = this.getAttribute('data-url');
                
                if (confirm('Are you sure you want to delete this leave application?')) {
                    // Create form for DELETE request
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = deleteUrl;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });

        // Search functionality
        const searchInput = document.querySelector('input[data-kt-filter="search"]');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush