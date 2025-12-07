<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($record) ? 'Edit' : 'Create' }} Movement Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background: #f6f7fb;
            font-family: Inter, sans-serif;
        }

        .form-card {
            background: #fff;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0px 4px 18px rgba(0,0,0,0.06);
        }

        .section-title {
            font-size: 22px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .form-control, .form-select {
            background: #f9fafb;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            font-size: 14px;
            padding: 10px 12px;
        }

        .form-control:focus, .form-select:focus {
            background: #fff;
            border-color: #6366f1;
            box-shadow: 0 0 0 .2rem rgba(99,102,241,0.15);
        }

        .btn-start {
            background: #e0e7ff;
            border: 1px solid #c7d2fe;
            color: #4338ca;
            font-weight: 600;
            padding: 8px 22px;
            border-radius: 10px;
        }

        .btn-finish {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            font-weight: 600;
            padding: 8px 22px;
            border-radius: 10px;
        }

        .btn-purple {
            background: #6d28d9;
            border: none;
            padding: 10px 26px;
            border-radius: 12px;
            font-weight: 600;
            color: #fff;
            font-size: 15px;
        }

        .btn-outline-purple {
            background: transparent;
            border: 1px solid #6d28d9;
            color: #6d28d9;
            padding: 10px 26px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
        }

        .btn-manual-edit {
            background: #f3e8ff;
            border: 1px solid #ddd6fe;
            color: #7c3aed;
            font-weight: 600;
            padding: 10px 16px;
            border-radius: 10px;
            font-size: 14px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-manual-edit:hover {
            background: #ede9fe;
        }

        .popup-card {
            position: absolute;
            top: 70px;
            right: 15px;
            width: 310px;
            background: #fff;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.1);
            z-index: 100;
        }

        .popup-title {
            font-weight: 700;
            font-size: 15px;
            color: #334155;
        }

        .popup-icon {
            font-size: 32px;
            color: #64748b;
        }

        .mini-label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }

        .time-input-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .request-edit-section {
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }

        .country-field {
            flex: 1;
        }

        .edit-btn-field {
            width: auto;
        }

        /* Status badge styles */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>
<div class="container mt-4">

    <div class="form-card position-relative">

        <h3 class="section-title">{{ isset($record) ? 'Edit Movement Record' : 'Movement Entry' }}</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('pending_approval'))
            <div class="alert alert-warning">
                <i class="bi bi-clock-history me-2"></i>
                {{ session('pending_approval') }}
            </div>
        @endif

        {{-- <!-- Display approval status if editing -->
        @if(isset($record) && $record->approval_status != 'approved')
            <div class="alert alert-{{ $record->approval_status == 'pending' ? 'warning' : ($record->approval_status == 'approved' ? 'success' : 'danger') }} mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        @if($record->approval_status == 'pending')
                            <i class="bi bi-hourglass-split me-2"></i>
                            <strong>Awaiting Super Admin Approval</strong>
                            <p class="mb-0 mt-1">Your edit request was submitted on {{ $record->edit_requested_at->format('M d, Y H:i') }}.</p>
                        @elseif($record->approval_status == 'approved')
                            <i class="bi bi-check-circle me-2"></i>
                            <strong>Approved by Super Admin</strong>
                            <p class="mb-0 mt-1">Your changes were approved on {{ $record->approved_at->format('M d, Y H:i') ?? 'N/A' }}</p>
                        @else
                            <i class="bi bi-x-circle me-2"></i>
                            <strong>Rejected by Super Admin</strong>
                            <p class="mb-0 mt-1">Your edit request was rejected on {{ $record->updated_at->format('M d, Y H:i') }}</p>
                            @if($record->rejection_reason)
                                <p class="mb-0 mt-1"><strong>Reason:</strong> {{ $record->rejection_reason }}</p>
                            @endif
                        @endif
                    </div>
                    <span class="status-badge status-{{ $record->approval_status }}">
                        @if($record->approval_status == 'pending')
                            <i class="bi bi-clock"></i> Pending
                        @elseif($record->approval_status == 'approved')
                            <i class="bi bi-check"></i> Approved
                        @else
                            <i class="bi bi-x"></i> Rejected
                        @endif
                    </span>
                </div>
            </div>
        @endif --}}

        <!-- Popup Card -->
        <div class="popup-card d-none" id="popupBox">
            <div class="popup-title mb-2">
                <i class="bi bi-exclamation-circle-fill text-primary"></i>
                Request Manual Edit
            </div>

            <div class="d-flex align-items-start gap-3 mb-2">
                <i class="bi bi-person-circle popup-icon"></i>
                <div>
                    <div class="fw-semibold">Admin Approval</div>
                    <small class="text-muted">Required</small>
                </div>
            </div>

            <p class="text-muted small">Do you want to request permission?</p>

            <div class="d-flex gap-2 mt-3">
                <button type="button" class="btn btn-purple w-100" onclick="submitManualEditRequest()">Send Request</button>
                <button type="button" class="btn btn-outline-secondary w-100" onclick="hidePopup()">Cancel</button>
            </div>
        </div>

        <!-- FORM -->
        <form action="{{ isset($record) ? route('admin.movement.update', $record->id) : route('admin.movement.store') }}" method="POST" id="movementForm">
            @csrf
            @if(isset($record))
                @method('PUT')
            @endif

            <!-- Hidden field for manual edit request -->
            <input type="hidden" name="request_manual_edit" id="requestManualEdit" value="0">
            <input type="hidden" name="edit_reason" id="editReason" value="">

            <div class="row">

                <!-- Admin Information -->
                <div class="col-md-3 mb-3">
                    <label class="mini-label">Staff *</label>
                    <input type="text" class="form-control" value="{{ $currentAdmin->name }}" readonly>
                    <input type="hidden" name="admin_id" value="{{ $currentAdmin->id }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="mini-label">Employee ID</label>
                    <input type="text" class="form-control" value="{{ $currentAdmin->employee_id ?? 'N/A' }}" readonly>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="mini-label">Designation</label>
                    <input type="text" class="form-control" value="{{ $currentAdmin->designation ?? 'N/A' }}" readonly>
                </div>

                <!-- Country/Territory Dropdown with Manual Edit Button -->
                <div class="col-md-3 mb-3">
                    <div class="request-edit-section">
                        <div class="country-field">
                            <label class="mini-label">Country / Territory</label>
                            @php
                                $countries = \App\Models\Country::all();
                                $isEditMode = isset($record);
                                $isPendingApproval = $isEditMode && $record->approval_status == 'pending';
                            @endphp
                            <select class="form-select" name="country_id" id="countrySelect" 
                                    {{ $isPendingApproval ? 'disabled' : '' }}>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" 
                                        {{ old('country_id', $record->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Manual Edit Button - Only show in edit mode -->
                        @if(isset($record))
                            <div class="edit-btn-field">
                                <label class="mini-label">&nbsp;</label>
                                <button type="button" class="btn-manual-edit w-100" 
                                        onclick="showManualEditPopup()"
                                        {{ $isPendingApproval ? 'disabled' : '' }}>
                                    <i class="bi bi-pencil-square"></i>
                                    Request Edit
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Movement Details -->
                <div class="col-md-3 mb-3">
                    <label class="mini-label">Movement Date *</label>
                    <input type="date" class="form-control" name="date" 
                           value="{{ old('date', isset($record) ? $record->date->format('Y-m-d') : date('Y-m-d')) }}" 
                           {{ $isPendingApproval ?? false ? 'readonly' : '' }} required>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="mini-label">Status *</label>
                    <select class="form-select" name="status" 
                            {{ $isPendingApproval ?? false ? 'disabled' : '' }} required>
                        <option value="">Select Status</option>
                        <option value="pending" {{ old('status', $record->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ old('status', $record->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $record->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Time Management -->
                <div class="col-md-3 mb-3">
                    <label class="mini-label">Time</label>
                    <div class="time-input-group">
                        <button type="button" class="btn-start" 
                                onclick="setCurrentTime('start_time')"
                                {{ $isPendingApproval ?? false ? 'disabled' : '' }}>
                            Start
                        </button>
                        <button type="button" class="btn-finish"
                                onclick="setCurrentTime('end_time')"
                                {{ $isPendingApproval ?? false ? 'disabled' : '' }}>
                            Finish
                        </button>
                    </div>
                </div>

                <!-- Time Inputs -->
                <div class="col-md-3 mb-3">
                    <label class="mini-label">Start Time</label>
                    <input type="time" class="form-control" id="start_time" name="start_time" 
                           value="{{ old('start_time', $record->start_time ?? '') }}"
                           {{ $isPendingApproval ?? false ? 'readonly' : '' }}>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="mini-label">End Time</label>
                    <input type="time" class="form-control" id="end_time" name="end_time" 
                           value="{{ old('end_time', $record->end_time ?? '') }}"
                           {{ $isPendingApproval ?? false ? 'readonly' : '' }}>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="mini-label">Duration</label>
                    <input type="text" class="form-control" id="duration_display" readonly>
                    <input type="hidden" name="duration" id="duration" value="{{ old('duration', $record->duration ?? '') }}">
                </div>

                <!-- Meeting Type -->
                <div class="col-md-4 mb-3">
                    <label class="mini-label">Meeting Type *</label>
                    <select class="form-select" name="meeting_type"
                            {{ $isPendingApproval ?? false ? 'disabled' : '' }}>
                        <option value="">Select Type</option>
                        <option value="follow-up" {{ old('meeting_type', $record->meeting_type ?? '') == 'follow-up' ? 'selected' : '' }}>Follow-up Call</option>
                        <option value="meeting" {{ old('meeting_type', $record->meeting_type ?? '') == 'meeting' ? 'selected' : '' }}>Meeting</option>
                        <option value="presentation" {{ old('meeting_type', $record->meeting_type ?? '') == 'presentation' ? 'selected' : '' }}>Presentation</option>
                        <option value="negotiation" {{ old('meeting_type', $record->meeting_type ?? '') == 'negotiation' ? 'selected' : '' }}>Negotiation</option>
                        <option value="site-visit" {{ old('meeting_type', $record->meeting_type ?? '') == 'site-visit' ? 'selected' : '' }}>Site Visit</option>
                    </select>
                </div>

                <div class="col-md-8 mb-3">
                    <label class="mini-label">Company</label>
                    <input type="text" class="form-control" name="company" 
                           value="{{ old('company', $record->company ?? '') }}"
                           {{ $isPendingApproval ?? false ? 'readonly' : '' }}>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="mini-label">Contact Person</label>
                    <input type="text" class="form-control" name="contact_person" 
                           value="{{ old('contact_person', $record->contact_person ?? '') }}"
                           {{ $isPendingApproval ?? false ? 'readonly' : '' }}>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="mini-label">Contact Number</label>
                    <input type="text" class="form-control" name="contact_number" 
                           value="{{ old('contact_number', $record->contact_number ?? '') }}"
                           {{ $isPendingApproval ?? false ? 'readonly' : '' }}>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="mini-label">Purpose / Work Summary *</label>
                    <textarea class="form-control" name="purpose" rows="3"
                              {{ $isPendingApproval ?? false ? 'readonly' : '' }}>{{ old('purpose', $record->purpose ?? '') }}</textarea>
                </div>

                <!-- Location Section -->
                <div class="col-md-3 mb-3">
                    <label class="mini-label">Area / Location</label>
                    <input type="text" class="form-control" name="area" 
                           value="{{ old('area', $record->area ?? '') }}"
                           {{ $isPendingApproval ?? false ? 'readonly' : '' }}>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="mini-label">Transport</label>
                    <select class="form-select" name="transport"
                            {{ $isPendingApproval ?? false ? 'disabled' : '' }}>
                        <option value="">Select Transport</option>
                        <option value="car" {{ old('transport', $record->transport ?? '') == 'car' ? 'selected' : '' }}>Car</option>
                        <option value="train" {{ old('transport', $record->transport ?? '') == 'train' ? 'selected' : '' }}>Train</option>
                        <option value="bus" {{ old('transport', $record->transport ?? '') == 'bus' ? 'selected' : '' }}>Bus</option>
                        <option value="flight" {{ old('transport', $record->transport ?? '') == 'flight' ? 'selected' : '' }}>Flight</option>
                        <option value="taxi" {{ old('transport', $record->transport ?? '') == 'taxi' ? 'selected' : '' }}>Taxi</option>
                        <option value="walking" {{ old('transport', $record->transport ?? '') == 'walking' ? 'selected' : '' }}>Walking</option>
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label class="mini-label">Cost ($)</label>
                    <input type="number" class="form-control" name="cost" step="0.01" 
                           value="{{ old('cost', $record->cost ?? '') }}"
                           {{ $isPendingApproval ?? false ? 'readonly' : '' }}>
                </div>

                <div class="col-md-2 mb-3">
                    <label class="mini-label">Value ($)</label>
                    <input type="number" class="form-control" name="value" step="0.01" 
                           value="{{ old('value', $record->value ?? '') }}"
                           {{ $isPendingApproval ?? false ? 'readonly' : '' }}>
                </div>

                <div class="col-md-2 mb-3">
                    <label class="mini-label">Value Status</label>
                    <select class="form-select" name="value_status"
                            {{ $isPendingApproval ?? false ? 'disabled' : '' }}>
                        <option value="">Select Status</option>
                        <option value="pending" {{ old('value_status', $record->value_status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="negotiating" {{ old('value_status', $record->value_status ?? '') == 'negotiating' ? 'selected' : '' }}>Negotiating</option>
                        <option value="closed" {{ old('value_status', $record->value_status ?? '') == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="lost" {{ old('value_status', $record->value_status ?? '') == 'lost' ? 'selected' : '' }}>Lost</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="mini-label">Additional Comments</label>
                    <textarea class="form-control" name="comments" rows="3"
                              {{ $isPendingApproval ?? false ? 'readonly' : '' }}>{{ old('comments', $record->comments ?? '') }}</textarea>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="col-12 d-flex gap-2 mt-3">
                    @if(isset($record))
                        <!-- For edit mode -->
                        @if($isPendingApproval ?? false)
                            <button type="button" class="btn btn-warning px-4" disabled>
                                <i class="bi bi-clock me-2"></i>Pending Approval
                            </button>
                        @else
                            <button type="submit" class="btn btn-purple px-4" id="submitBtn">
                                Update Record
                            </button>
                        @endif
                    @else
                        <!-- For create mode: Normal save button -->
                        <button type="submit" class="btn btn-purple px-4">
                            Save
                        </button>
                        <button type="button" class="btn btn-outline-purple px-4" onclick="saveAndAddAnother()">
                            Save & Add Another
                        </button>
                    @endif
                    <a href="{{ route('admin.movement.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    // Set current time for Start/Finish buttons
    function setCurrentTime(fieldId) {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const timeString = `${hours}:${minutes}`;
        
        document.getElementById(fieldId).value = timeString;
        calculateDuration();
    }

    // Calculate duration between start and end times
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
            
            durationField.value = durationString;
            durationDisplay.value = `${diffHours}h ${diffMinutes}m`;
        }
    }

    // Show manual edit popup
    function showManualEditPopup() {
        document.getElementById("popupBox").classList.remove("d-none");
    }

    // Hide popup
    function hidePopup() {
        document.getElementById("popupBox").classList.add("d-none");
    }

    // Submit manual edit request
    function submitManualEditRequest() {
        // Set the flag to indicate manual edit is requested
        document.getElementById('requestManualEdit').value = '1';
        
        // You can add a reason here if needed
        document.getElementById('editReason').value = 'Manual edit requested by user';
        
        // Hide the popup
        hidePopup();
        
        // Submit the form
        document.getElementById('movementForm').submit();
    }

    // Auto-calculate duration when time inputs change
    document.getElementById('start_time').addEventListener('change', calculateDuration);
    document.getElementById('end_time').addEventListener('change', calculateDuration);

    // Calculate duration on page load if times exist
    document.addEventListener('DOMContentLoaded', function() {
        calculateDuration();
        
        // Make disabled fields look disabled
        document.querySelectorAll('select[disabled], input[readonly], textarea[readonly]')
            .forEach(el => {
                el.style.backgroundColor = '#f1f5f9';
                el.style.cursor = 'not-allowed';
            });
    });

    // Save and add another function
    function saveAndAddAnother() {
        // For new records, no approval needed
        document.getElementById('movementForm').submit();
    }
</script>
</body>
</html>