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
                                    <!-- Search Section -->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <span class="svg-icon svg-icon-2 svg-icon-gray-700 position-absolute top-50 translate-middle-y ms-4">
                                            <!-- Search icon SVG -->
                                        </span>
                                        <input type="text" data-kt-filter="search"
                                            class="form-control form-control-sm form-control-solid w-150px ps-14 rounded-0"
                                            placeholder="Search" style="border: 1px solid #eee;" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 text-lg-center text-sm-center">
                                    <div class="card-title table_title">
                                        <h2>Leave Applications</h2>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 text-lg-end text-sm-center">
                                    <!-- Leave Application Button -->
                                    <a href="{{ route('leave-applications.create') }}"
                                        class="btn btn-sm btn-light-primary rounded-0 me-3">
                                        Leave Application
                                    </a>
                                    <!-- Add New Button -->
                                    <a href="{{ route('leave-applications.create') }}" 
                                    class="btn btn-sm btn-light-success rounded-0">
                                        Add New
                                    </a>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover align-middle rounded-0 table-row-bordered border fs-6 g-5 border"
                            id="kt_datatable_example">
                            <thead class="table_header_bg">
                                <tr class="text-center text-gray-900 fw-bolder fs-7 text-uppercase">
                                    <th width="5%" class="text-center">Sl:</th>
                                    <th width="30%">Applicant name</th>
                                    <th width="15%">Type Of Leave</th>
                                    <th width="15%">Designation</th>
                                    <th width="20%">Status</th>
                                    <th width="15%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="fw-bold text-gray-600 text-center">
                                @if ($leaveApplications->count() > 0)
                                    @foreach ($leaveApplications as $leaveApplication)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $leaveApplication->name }}</td>
                                            <td>{{ $leaveApplication->type_of_leave }}</td>
                                            <td>
                                                @if(!empty($leaveApplication->designation))
                                                    {{ $leaveApplication->designation }}
                                                @else
                                                    <span class="text-muted">Not set</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $leaveApplication->application_status == 'approved' ? 'success' : ($leaveApplication->application_status == 'rejected' ? 'danger' : 'warning') }}">
                                                    {{ $leaveApplication->application_status == 'approved' ? 'Approved' : ($leaveApplication->application_status == 'rejected' ? 'Rejected' : 'Pending') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <!-- Edit Button -->
                                                <a href="javascript:void(0);" class="text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#leaveEditModal-{{ $leaveApplication->id }}">
                                                    <i class="fa-solid fa-pen-to-square me-2 p-1 rounded-circle text-white"
                                                        style="color: #247297 !important;"></i>
                                                </a>
                                                <!-- Delete Button -->
                                                <a href="javascript:void(0);" class="text-danger delete-leave" 
                                                    data-id="{{ $leaveApplication->id }}"
                                                    data-url="{{ route('leave-applications.destroy', $leaveApplication->id) }}">
                                                    <i class="fa-solid fa-trash p-1 rounded-circle text-white"
                                                        style="color: #247297 !important;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">No leave applications found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modals --}}
    @foreach ($leaveApplications as $leaveApplication)
        <div class="modal fade" id="leaveEditModal-{{ $leaveApplication->id }}" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
            aria-labelledby="leaveEditLabel-{{ $leaveApplication->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-0">
                    <div class="modal-header rounded-0 text-white bg-secondary">
                        <h5 class="modal-title text-uppercase" id="leaveEditLabel-{{ $leaveApplication->id }}">Edit Leave Application</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('leave-applications.update', $leaveApplication->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body rounded-0">
                            <div class="container">
                                <!-- Personal Information Section -->
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <div class="section-header bg-light-primary p-2 rounded">
                                            <h6 class="mb-0 text-primary">
                                                <i class="fa-solid fa-user me-2"></i>Personal Information
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0 required">Applicant Name</label>
                                        <input type="text" name="name" value="{{ $leaveApplication->name }}"
                                            class="form-control form-control-sm" placeholder="Enter Applicant Name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0 required">Designation</label>
                                        <input type="text" name="designation" value="{{ $leaveApplication->designation }}"
                                            class="form-control form-control-sm" placeholder="Enter Designation" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0 required">Company</label>
                                        <input type="text" name="company" value="{{ $leaveApplication->company }}"
                                            class="form-control form-control-sm" placeholder="Enter Company Name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0 required">Type Of Leave</label>
                                        <select class="form-select form-select-sm" name="type_of_leave" required>
                                            <option value="Casual Leave" {{ $leaveApplication->type_of_leave == 'Casual Leave' ? 'selected' : '' }}>Casual Leave</option>
                                            <option value="Earned Leave" {{ $leaveApplication->type_of_leave == 'Earned Leave' ? 'selected' : '' }}>Earned Leave</option>
                                            <option value="Medical Leave" {{ $leaveApplication->type_of_leave == 'Medical Leave' ? 'selected' : '' }}>Medical Leave</option>
                                            <option value="Maternity Leave" {{ $leaveApplication->type_of_leave == 'Maternity Leave' ? 'selected' : '' }}>Maternity Leave</option>
                                            <option value="Emergency Leave" {{ $leaveApplication->type_of_leave == 'Emergency Leave' ? 'selected' : '' }}>Emergency Leave</option>
                                            <option value="Study Leave" {{ $leaveApplication->type_of_leave == 'Study Leave' ? 'selected' : '' }}>Study Leave</option>
                                            <option value="Other" {{ $leaveApplication->type_of_leave == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Leave Details Section -->
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <div class="section-header bg-light-primary p-2 rounded">
                                            <h6 class="mb-0 text-primary">
                                                <i class="fa-solid fa-calendar-days me-2"></i>Leave Details
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label mb-0 required">Leave Start Date</label>
                                        <input type="date" name="leave_start_date" value="{{ $leaveApplication->leave_start_date }}"
                                            class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label mb-0 required">Leave End Date</label>
                                        <input type="date" name="leave_end_date" value="{{ $leaveApplication->leave_end_date }}"
                                            class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label mb-0 required">Total Days</label>
                                        <input type="number" name="total_days" value="{{ $leaveApplication->total_days }}"
                                            class="form-control form-control-sm" min="1" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0 required">Reporting On</label>
                                        <input type="date" name="reporting_on" value="{{ $leaveApplication->reporting_on }}"
                                            class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0 required">Job Status</label>
                                        <select class="form-select form-select-sm" name="job_status" required>
                                            <option value="Active" {{ $leaveApplication->job_status == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="On Leave" {{ $leaveApplication->job_status == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                                            <option value="Probation" {{ $leaveApplication->job_status == 'Probation' ? 'selected' : '' }}>Probation</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Leave Explanation -->
                                <div class="row mb-3">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label mb-0 required">Leave Explanation</label>
                                        <textarea class="form-control form-control-sm" name="leave_explanation" 
                                                  rows="3" placeholder="Please provide reason for leave..." required>{{ $leaveApplication->leave_explanation }}</textarea>
                                    </div>
                                </div>

                                <!-- Contact & Additional Information -->
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <div class="section-header bg-light-primary p-2 rounded">
                                            <h6 class="mb-0 text-primary">
                                                <i class="fa-solid fa-address-card me-2"></i>Contact & Additional Information
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0 required">Substitute During Leave</label>
                                        <input type="text" name="substitute_during_leave" value="{{ $leaveApplication->substitute_during_leave }}"
                                            class="form-control form-control-sm" placeholder="Enter substitute name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0">Leave Address</label>
                                        <input type="text" name="leave_address" value="{{ $leaveApplication->leave_address }}"
                                            class="form-control form-control-sm" placeholder="Enter address during leave">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0">Leave Contact Number</label>
                                        <input type="text" name="leave_contact_no" value="{{ $leaveApplication->leave_contact_no }}"
                                            class="form-control form-control-sm" placeholder="Enter contact number during leave">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0">Include Open Saturday</label>
                                        <input type="text" name="included_open_saturday" value="{{ $leaveApplication->included_open_saturday }}"
                                            class="form-control form-control-sm" placeholder="Enter details if any">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label mb-0">Is Between Holidays?</label>
                                        <div class="d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_between_holidays" 
                                                       value="yes" id="between_holidays_yes_{{ $leaveApplication->id }}" 
                                                       {{ $leaveApplication->is_between_holidays == 'yes' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="between_holidays_yes_{{ $leaveApplication->id }}">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_between_holidays" 
                                                       value="no" id="between_holidays_no_{{ $leaveApplication->id }}" 
                                                       {{ $leaveApplication->is_between_holidays == 'no' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="between_holidays_no_{{ $leaveApplication->id }}">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Leave Balance Information -->
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <div class="section-header bg-light-primary p-2 rounded">
                                            <h6 class="mb-0 text-primary">
                                                <i class="fa-solid fa-calculator me-2"></i>Leave Balance Information
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Leave Position</th>
                                                        <th>Leave Due As On</th>
                                                        <th>Leave Availed</th>
                                                        <th>Balance Due</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm border-0 bg-transparent" 
                                                                   value="Earned Leave" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm" 
                                                                   name="earned_leave_due_as_on" value="{{ $leaveApplication->earned_leave_due_as_on ?? 0 }}" 
                                                                   min="0" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm" 
                                                                   name="earned_leave_availed" value="{{ $leaveApplication->earned_leave_availed ?? 0 }}" 
                                                                   min="0" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm" 
                                                                   name="earned_balance_due" value="{{ $leaveApplication->earned_balance_due ?? 0 }}" 
                                                                   min="0" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm border-0 bg-transparent" 
                                                                   value="Casual Leave" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm" 
                                                                   name="casual_leave_due_as_on" value="{{ $leaveApplication->casual_leave_due_as_on ?? 0 }}" 
                                                                   min="0" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm" 
                                                                   name="casual_leave_availed" value="{{ $leaveApplication->casual_leave_availed ?? 0 }}" 
                                                                   min="0" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm" 
                                                                   name="casual_balance_due" value="{{ $leaveApplication->casual_balance_due ?? 0 }}" 
                                                                   min="0" readonly>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm border-0 bg-transparent" 
                                                                   value="Medical Leave" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm" 
                                                                   name="medical_leave_due_as_on" value="{{ $leaveApplication->medical_leave_due_as_on ?? 0 }}" 
                                                                   min="0" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm" 
                                                                   name="medical_leave_availed" value="{{ $leaveApplication->medical_leave_availed ?? 0 }}" 
                                                                   min="0" required>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm" 
                                                                   name="medical_balance_due" value="{{ $leaveApplication->medical_balance_due ?? 0 }}" 
                                                                   min="0" readonly>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Application Status -->
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <div class="section-header bg-light-primary p-2 rounded">
                                            <h6 class="mb-0 text-primary">
                                                <i class="fa-solid fa-tasks me-2"></i>Application Status
                                            </h6>
                                        </div>
                                    </div>
                                </div>

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

                                <!-- Hidden fields -->
                                <input type="hidden" name="country_id" value="{{ $leaveApplication->country_id ?? 1 }}">
                                <input type="hidden" name="employee_id" value="{{ $leaveApplication->employee_id ?? 1 }}">
                                <input type="hidden" name="company_id" value="{{ $leaveApplication->company_id ?? 1 }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">Update Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('styles')
<style>
    .required::after {
        content: " *";
        color: #dc3545;
    }
    .section-header {
        border-left: 4px solid #247297;
        background-color: #f8f9fa !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: #247297;
        box-shadow: 0 0 0 0.2rem rgba(36, 114, 151, 0.25);
    }
    .table th {
        background-color: #2472974f !important;
        color: #174a62 !important;
        font-weight: 600;
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

        // Calculate leave balances automatically
        function calculateBalances(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            // Earned Leave Balance
            const earnedDue = parseInt(modal.querySelector('input[name="earned_leave_due_as_on"]').value) || 0;
            const earnedAvailed = parseInt(modal.querySelector('input[name="earned_leave_availed"]').value) || 0;
            const earnedBalance = Math.max(0, earnedDue - earnedAvailed);
            modal.querySelector('input[name="earned_balance_due"]').value = earnedBalance;

            // Casual Leave Balance
            const casualDue = parseInt(modal.querySelector('input[name="casual_leave_due_as_on"]').value) || 0;
            const casualAvailed = parseInt(modal.querySelector('input[name="casual_leave_availed"]').value) || 0;
            const casualBalance = Math.max(0, casualDue - casualAvailed);
            modal.querySelector('input[name="casual_balance_due"]').value = casualBalance;

            // Medical Leave Balance
            const medicalDue = parseInt(modal.querySelector('input[name="medical_leave_due_as_on"]').value) || 0;
            const medicalAvailed = parseInt(modal.querySelector('input[name="medical_leave_availed"]').value) || 0;
            const medicalBalance = Math.max(0, medicalDue - medicalAvailed);
            modal.querySelector('input[name="medical_balance_due"]').value = medicalBalance;
        }

        // Attach event listeners to all leave calculation inputs in each modal
        document.querySelectorAll('[id^="leaveEditModal-"]').forEach(modal => {
            const balanceInputs = modal.querySelectorAll('input[name$="_due_as_on"], input[name$="_availed"]');
            balanceInputs.forEach(input => {
                input.addEventListener('input', function() {
                    // Ensure only integer values
                    this.value = this.value.replace(/[^0-9]/g, '');
                    calculateBalances(modal.id);
                });
            });

            // Initialize calculations when modal opens
            modal.addEventListener('shown.bs.modal', function() {
                calculateBalances(modal.id);
            });
        });

        // Date validation
        document.querySelectorAll('input[name="leave_end_date"]').forEach(input => {
            input.addEventListener('change', function() {
                const startDate = this.closest('form').querySelector('input[name="leave_start_date"]').value;
                const endDate = this.value;
                
                if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
                    alert('End date must be after start date!');
                    this.value = '';
                }
            });
        });

        document.querySelectorAll('input[name="reporting_on"]').forEach(input => {
            input.addEventListener('change', function() {
                const endDate = this.closest('form').querySelector('input[name="leave_end_date"]').value;
                const reportingDate = this.value;
                
                if (endDate && reportingDate && new Date(reportingDate) <= new Date(endDate)) {
                    alert('Reporting date must be after leave end date!');
                    this.value = '';
                }
            });
        });
    });
</script>
@endpush