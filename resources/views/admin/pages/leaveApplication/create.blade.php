@extends('admin.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h4 class="mb-0">Create New Leave Application</h4>
                            </div>
                            <div class="col-lg-6 text-end">
                                <a href="{{ route('leave-applications.index') }}" class="btn btn-light-secondary rounded-0">
                                    <i class="fa-solid fa-arrow-left me-2"></i>Back to List
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('leave-applications.store') }}" class="needs-validation" 
                              novalidate enctype="multipart/form-data" id="leaveApplicationForm">
                            @csrf

                            <!-- Personal Information Section -->
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <div class="section-header bg-light-primary p-3 rounded">
                                        <h5 class="mb-0 text-primary">
                                            <i class="fa-solid fa-user me-2"></i>Personal Information
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="name" class="form-label required">Applicant Name</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" 
                                           name="name" id="name" value="{{ old('name') }}" 
                                           placeholder="Enter full name" required>
                                    <div class="invalid-feedback">Please provide applicant name.</div>
                                    @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="designation" class="form-label required">Designation</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" 
                                           name="designation" id="designation" value="{{ old('designation') }}" 
                                           placeholder="Enter designation" required>
                                    <div class="invalid-feedback">Please provide designation.</div>
                                    @error('designation')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="company" class="form-label required">Company</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" 
                                           name="company" id="company" value="{{ old('company', 'NGEN IT') }}" 
                                           placeholder="Enter company name" required>
                                    <div class="invalid-feedback">Please provide company name.</div>
                                    @error('company')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Leave Details Section -->
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <div class="section-header bg-light-primary p-3 rounded mt-4">
                                        <h5 class="mb-0 text-primary">
                                            <i class="fa-solid fa-calendar-days me-2"></i>Leave Details
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="type_of_leave" class="form-label required">Type of Leave</label>
                                    <select class="form-select form-select-sm rounded-0" name="type_of_leave" 
                                            id="type_of_leave" required>
                                        <option value="">Select Leave Type</option>
                                        <option value="Casual Leave" {{ old('type_of_leave') == 'Casual Leave' ? 'selected' : '' }}>Casual Leave</option>
                                        <option value="Earned Leave" {{ old('type_of_leave') == 'Earned Leave' ? 'selected' : '' }}>Earned Leave</option>
                                        <option value="Medical Leave" {{ old('type_of_leave') == 'Medical Leave' ? 'selected' : '' }}>Medical Leave</option>
                                        <option value="Maternity Leave" {{ old('type_of_leave') == 'Maternity Leave' ? 'selected' : '' }}>Maternity Leave</option>
                                        <option value="Emergency Leave" {{ old('type_of_leave') == 'Emergency Leave' ? 'selected' : '' }}>Emergency Leave</option>
                                        <option value="Study Leave" {{ old('type_of_leave') == 'Study Leave' ? 'selected' : '' }}>Study Leave</option>
                                        <option value="Other" {{ old('type_of_leave') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <div class="invalid-feedback">Please select leave type.</div>
                                    @error('type_of_leave')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="leave_start_date" class="form-label required">Leave Start Date</label>
                                    <input type="date" class="form-control form-control-sm rounded-0" 
                                           name="leave_start_date" id="leave_start_date" 
                                           value="{{ old('leave_start_date') }}" required>
                                    <div class="invalid-feedback">Please select start date.</div>
                                    @error('leave_start_date')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="leave_end_date" class="form-label required">Leave End Date</label>
                                    <input type="date" class="form-control form-control-sm rounded-0" 
                                           name="leave_end_date" id="leave_end_date" 
                                           value="{{ old('leave_end_date') }}" required>
                                    <div class="invalid-feedback">Please select end date.</div>
                                    @error('leave_end_date')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="total_days" class="form-label required">Total Days</label>
                                    <input type="number" class="form-control form-control-sm rounded-0" 
                                           name="total_days" id="total_days" value="{{ old('total_days', 1) }}" 
                                           placeholder="Calculate automatically" min="1" required>
                                    <div class="invalid-feedback">Please calculate total days.</div>
                                    @error('total_days')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="reporting_on" class="form-label required">Reporting On</label>
                                    <input type="date" class="form-control form-control-sm rounded-0" 
                                           name="reporting_on" id="reporting_on" 
                                           value="{{ old('reporting_on') }}" required>
                                    <div class="invalid-feedback">Please select reporting date.</div>
                                    @error('reporting_on')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="job_status" class="form-label required">Job Status</label>
                                    <select class="form-select form-select-sm rounded-0" name="job_status" required>
                                        <option value="">Select Status</option>
                                        <option value="Active" {{ old('job_status') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="On Leave" {{ old('job_status') == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                                        <option value="Probation" {{ old('job_status') == 'Probation' ? 'selected' : '' }}>Probation</option>
                                    </select>
                                    <div class="invalid-feedback">Please select job status.</div>
                                    @error('job_status')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Leave Explanation -->
                            <div class="row mb-4">
                                <div class="col-md-12 mb-3">
                                    <label for="leave_explanation" class="form-label required">Leave Explanation</label>
                                    <textarea class="form-control form-control-sm rounded-0" name="leave_explanation" 
                                              id="leave_explanation" rows="3" placeholder="Please provide reason for leave..." 
                                              required>{{ old('leave_explanation') }}</textarea>
                                    <div class="invalid-feedback">Please provide leave explanation.</div>
                                    @error('leave_explanation')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact & Additional Information -->
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <div class="section-header bg-light-primary p-3 rounded">
                                        <h5 class="mb-0 text-primary">
                                            <i class="fa-solid fa-address-card me-2"></i>Contact & Additional Information
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="substitute_during_leave" class="form-label required">Substitute During Leave</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" 
                                           name="substitute_during_leave" id="substitute_during_leave" 
                                           value="{{ old('substitute_during_leave') }}" 
                                           placeholder="Enter substitute name" required>
                                    <div class="invalid-feedback">Please provide substitute name.</div>
                                    @error('substitute_during_leave')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="leave_address" class="form-label">Leave Address</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" 
                                           name="leave_address" id="leave_address" 
                                           value="{{ old('leave_address') }}" 
                                           placeholder="Enter address during leave">
                                    @error('leave_address')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="leave_contact_no" class="form-label">Leave Contact Number</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" 
                                           name="leave_contact_no" id="leave_contact_no" 
                                           value="{{ old('leave_contact_no') }}" 
                                           placeholder="Enter contact number during leave">
                                    @error('leave_contact_no')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Is Between Holidays?</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_between_holidays" 
                                                   id="between_holidays_yes" value="yes" {{ old('is_between_holidays') == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="between_holidays_yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_between_holidays" 
                                                   id="between_holidays_no" value="no" {{ old('is_between_holidays', 'no') == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="between_holidays_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    @error('is_between_holidays')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="included_open_saturday" class="form-label">Include Open Saturday</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" 
                                           name="included_open_saturday" id="included_open_saturday" 
                                           value="{{ old('included_open_saturday') }}" 
                                           placeholder="Enter details if any">
                                    @error('included_open_saturday')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Leave Balance Information -->
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <div class="section-header bg-light-primary p-3 rounded">
                                        <h5 class="mb-0 text-primary">
                                            <i class="fa-solid fa-calculator me-2"></i>Leave Balance Information
                                        </h5>
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
                                                        <input type="number" class="form-control form-control-sm rounded-0" 
                                                               name="earned_leave_due_as_on" value="{{ old('earned_leave_due_as_on', 0) }}" 
                                                               min="0" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm rounded-0" 
                                                               name="earned_leave_availed" value="{{ old('earned_leave_availed', 0) }}" 
                                                               min="0" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm rounded-0" 
                                                               name="earned_balance_due" value="{{ old('earned_balance_due', 0) }}" 
                                                               min="0" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm border-0 bg-transparent" 
                                                               value="Casual Leave" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm rounded-0" 
                                                               name="casual_leave_due_as_on" value="{{ old('casual_leave_due_as_on', 0) }}" 
                                                               min="0" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm rounded-0" 
                                                               name="casual_leave_availed" value="{{ old('casual_leave_availed', 0) }}" 
                                                               min="0" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm rounded-0" 
                                                               name="casual_balance_due" value="{{ old('casual_balance_due', 0) }}" 
                                                               min="0" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm border-0 bg-transparent" 
                                                               value="Medical Leave" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm rounded-0" 
                                                               name="medical_leave_due_as_on" value="{{ old('medical_leave_due_as_on', 0) }}" 
                                                               min="0" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm rounded-0" 
                                                               name="medical_leave_availed" value="{{ old('medical_leave_availed', 0) }}" 
                                                               min="0" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm rounded-0" 
                                                               name="medical_balance_due" value="{{ old('medical_balance_due', 0) }}" 
                                                               min="0" readonly>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Signature Section -->
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <div class="section-header bg-light-primary p-3 rounded">
                                        <h5 class="mb-0 text-primary">
                                            <i class="fa-solid fa-signature me-2"></i>Signatures
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="applicant_signature" class="form-label required">Applicant Signature</label>
                                    <input type="file" class="form-control form-control-sm rounded-0" 
                                           name="applicant_signature" id="applicant_signature" 
                                           accept="image/jpeg,image/png,image/jpg" required>
                                    <small class="form-text text-muted">Upload your signature (JPG, PNG, JPEG only)</small>
                                    <div class="invalid-feedback">Please upload applicant signature.</div>
                                    @error('applicant_signature')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="substitute_signature" class="form-label">Substitute Signature (Optional)</label>
                                    <input type="file" class="form-control form-control-sm rounded-0" 
                                           name="substitute_signature" id="substitute_signature" 
                                           accept="image/jpeg,image/png,image/jpg,.pdf">
                                    <small class="form-text text-muted">Upload substitute signature (JPG, PNG, JPEG, PDF)</small>
                                    @error('substitute_signature')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Approval Signatures -->
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <div class="section-header bg-light-primary p-3 rounded">
                                        <h5 class="mb-0 text-primary">
                                            <i class="fa-solid fa-stamp me-2"></i>Approval Signatures (Optional)
                                        </h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="checked_by" class="form-label">Checked By (HR & Admin)</label>
                                    <input type="file" class="form-control form-control-sm rounded-0" 
                                           name="checked_by" id="checked_by" 
                                           accept="image/jpeg,image/png,image/jpg,.pdf">
                                    <small class="form-text text-muted">JPG, PNG, JPEG, PDF</small>
                                    @error('checked_by')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="recommended_by" class="form-label">Recommended By (CEO & Head)</label>
                                    <input type="file" class="form-control form-control-sm rounded-0" 
                                           name="recommended_by" id="recommended_by" 
                                           accept="image/jpeg,image/png,image/jpg,.pdf">
                                    <small class="form-text text-muted">JPG, PNG, JPEG, PDF</small>
                                    @error('recommended_by')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="reviewed_by" class="form-label">Reviewed By (OD)</label>
                                    <input type="file" class="form-control form-control-sm rounded-0" 
                                           name="reviewed_by" id="reviewed_by" 
                                           accept="image/jpeg,image/png,image/jpg,.pdf">
                                    <small class="form-text text-muted">JPG, PNG, JPEG, PDF</small>
                                    @error('reviewed_by')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="approved_by" class="form-label">Approved By (MD)</label>
                                    <input type="file" class="form-control form-control-sm rounded-0" 
                                           name="approved_by" id="approved_by" 
                                           accept="image/jpeg,image/png,image/jpg,.pdf">
                                    <small class="form-text text-muted">JPG, PNG, JPEG, PDF</small>
                                    @error('approved_by')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Additional Notes -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="note" class="form-label">Additional Notes</label>
                                    <textarea class="form-control form-control-sm rounded-0" name="note" 
                                              id="note" rows="2" placeholder="Any additional notes or comments...">{{ old('note') }}</textarea>
                                    @error('note')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Hidden fields for required database columns -->
                            <input type="hidden" name="country_id" value="1">
                            <input type="hidden" name="employee_id" value="1">
                            <input type="hidden" name="company_id" value="1">
                            <input type="hidden" name="application_status" value="pending">

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="reset" class="btn btn-light-secondary rounded-0" id="resetBtn">
                                            <i class="fa-solid fa-rotate-right me-2"></i>Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary rounded-0">
                                            <i class="fa-solid fa-paper-plane me-2"></i>Submit Application
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .required::after {
        content: " *";
        color: #dc3545;
    }
    .section-header {
        border-left: 4px solid #247297;
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
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('leaveApplicationForm');
        const startDateInput = document.getElementById('leave_start_date');
        const endDateInput = document.getElementById('leave_end_date');
        const totalDaysInput = document.getElementById('total_days');
        const reportingInput = document.getElementById('reporting_on');
        const resetBtn = document.getElementById('resetBtn');
        const applicantSignatureInput = document.getElementById('applicant_signature');

        // Set minimum dates to today
        const today = new Date().toISOString().split('T')[0];
        startDateInput.min = today;
        endDateInput.min = today;
        reportingInput.min = today;

        // Calculate total days function
        function calculateTotalDays() {
            if (startDateInput.value && endDateInput.value) {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);
                
                // Calculate difference in days
                const timeDiff = endDate.getTime() - startDate.getTime();
                const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // +1 to include both start and end dates
                
                if (dayDiff > 0) {
                    totalDaysInput.value = dayDiff;
                    
                    // Auto-set reporting date to day after end date
                    const reportingDate = new Date(endDate);
                    reportingDate.setDate(reportingDate.getDate() + 1);
                    reportingInput.valueAsDate = reportingDate;
                } else {
                    totalDaysInput.value = 1;
                    alert('End date must be after start date!');
                    endDateInput.value = '';
                }
            } else {
                totalDaysInput.value = 1; // Default value
            }
        }

        // Calculate leave balances automatically - INTEGER VALUES
        function calculateBalances() {
            // Earned Leave Balance
            const earnedDue = parseInt(document.querySelector('input[name="earned_leave_due_as_on"]').value) || 0;
            const earnedAvailed = parseInt(document.querySelector('input[name="earned_leave_availed"]').value) || 0;
            const earnedBalance = Math.max(0, earnedDue - earnedAvailed);
            document.querySelector('input[name="earned_balance_due"]').value = earnedBalance;

            // Casual Leave Balance
            const casualDue = parseInt(document.querySelector('input[name="casual_leave_due_as_on"]').value) || 0;
            const casualAvailed = parseInt(document.querySelector('input[name="casual_leave_availed"]').value) || 0;
            const casualBalance = Math.max(0, casualDue - casualAvailed);
            document.querySelector('input[name="casual_balance_due"]').value = casualBalance;

            // Medical Leave Balance
            const medicalDue = parseInt(document.querySelector('input[name="medical_leave_due_as_on"]').value) || 0;
            const medicalAvailed = parseInt(document.querySelector('input[name="medical_leave_availed"]').value) || 0;
            const medicalBalance = Math.max(0, medicalDue - medicalAvailed);
            document.querySelector('input[name="medical_balance_due"]').value = medicalBalance;
        }

        // Initialize with default value
        totalDaysInput.value = 1;

        // Event listeners for date changes
        startDateInput.addEventListener('change', function() {
            if (startDateInput.value && endDateInput.value) {
                calculateTotalDays();
            }
            // Update end date min to be at least start date
            if (startDateInput.value) {
                endDateInput.min = startDateInput.value;
            }
        });

        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && endDateInput.value) {
                calculateTotalDays();
            }
        });

        // Attach event listeners to all leave calculation inputs
        const balanceInputs = document.querySelectorAll('input[name$="_due_as_on"], input[name$="_availed"]');
        balanceInputs.forEach(input => {
            input.addEventListener('input', function() {
                // Ensure only integer values
                this.value = this.value.replace(/[^0-9]/g, '');
                calculateBalances();
            });
        });

        // File validation for applicant signature
        applicantSignatureInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!validTypes.includes(file.type)) {
                    alert('Please upload only JPG, JPEG, or PNG files for applicant signature.');
                    this.value = '';
                    return;
                }
                
                if (file.size > maxSize) {
                    alert('File size must be less than 2MB.');
                    this.value = '';
                    return;
                }
            }
        });

        // Reset button handler
        resetBtn.addEventListener('click', function() {
            // Reset total days to default
            totalDaysInput.value = 1;
            
            // Reset min dates
            startDateInput.min = today;
            endDateInput.min = today;
            reportingInput.min = today;
            
            // Clear file inputs
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.value = '';
            });
            
            // Reset leave balance fields to 0
            document.querySelectorAll('input[name$="_due_as_on"], input[name$="_availed"]').forEach(input => {
                input.value = '0';
            });
            calculateBalances();
        });

        // Form validation
        form.addEventListener('submit', function(event) {
            // Ensure total_days has a value
            if (!totalDaysInput.value || totalDaysInput.value < 1) {
                totalDaysInput.value = 1;
            }

            // Validate applicant signature
            if (!applicantSignatureInput.files || !applicantSignatureInput.files[0]) {
                event.preventDefault();
                event.stopPropagation();
                alert('Please upload applicant signature.');
                applicantSignatureInput.focus();
                return;
            }

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        // Client-side validation for dates
        reportingInput.addEventListener('change', function() {
            if (endDateInput.value && reportingInput.value) {
                const endDate = new Date(endDateInput.value);
                const reportingDate = new Date(reportingInput.value);
                
                if (reportingDate <= endDate) {
                    alert('Reporting date must be after leave end date!');
                    reportingInput.value = '';
                    
                    // Auto-set to day after end date
                    if (endDateInput.value) {
                        const autoReportingDate = new Date(endDate);
                        autoReportingDate.setDate(autoReportingDate.getDate() + 1);
                        reportingInput.valueAsDate = autoReportingDate;
                    }
                }
            }
        });

        // Initialize calculations
        calculateBalances();
    });
</script>
@endpush