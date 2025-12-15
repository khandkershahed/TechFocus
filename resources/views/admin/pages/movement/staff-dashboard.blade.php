@extends('admin.master')

@section('content')

{{-- ================== EXTRA UI STYLES ================== --}}
<style>
    .dashboard-card {
        border-radius: 14px;
        transition: all 0.25s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    }

    .dashboard-title {
        font-size: 12px;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #6c757d;
    }

    .dashboard-value {
        font-size: 26px;
        font-weight: 700;
    }

    .table thead th {
        white-space: nowrap;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #eef2ff !important;
    }

    .modal-content {
        border-radius: 16px;
    }

    .btn {
        border-radius: 8px;
    }
</style>

<div class="py-4 container-fluid">

    {{-- ================== HEADER ================== --}}
    <div class="p-4 mb-4 rounded d-flex justify-content-between align-items-center bg-primary">
        <h2 class="mb-1 text-white fw-bold text-uppercase">
            Sales Movement Dashboard
        </h2>
        <p class="mb-0 text-white small">
            Overview of visits, performance, cost & sales activity
        </p>
    </div>

    {{-- ================== STATS CARDS ================== --}}
    <div class="mb-4 row g-4">

        {{-- Card 1 --}}
        <div class="col-md-3">
            <div class="border-0 shadow-sm card dashboard-card h-100">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="dashboard-title">Total Days</div>
                        <div class="dashboard-value">{{ $totalDays }}</div>
                    </div>
                    <hr>
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="dashboard-title">Companies</div>
                        <div class="dashboard-value">{{ $totalCompanies }}</div>
                    </div>
                    <hr>
                    <div class="mb-3 d-flex justify-content-between">
                        <div class="dashboard-title">Visits</div>
                        <div class="dashboard-value">{{ $totalVisits }}</div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div class="dashboard-title">Areas</div>
                        <div class="dashboard-value">{{ $totalAreas }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="col-md-3">
            <div class="border-0 shadow-sm card dashboard-card h-100">
                <div class="card-body">
                    <div class="mb-3 align-items-center d-flex justify-content-between">
                        <div class="dashboard-title">Highest Value</div>
                        <div class="dashboard-value text-success">
                            Tk {{ number_format($highestValue ?? 0) }}
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3 align-items-center d-flex justify-content-between">
                        <div class="dashboard-title">Lowest Value</div>
                        <div class="dashboard-value text-danger">
                            Tk {{ number_format($lowestValue ?? 0) }}
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3 align-items-center d-flex justify-content-between">
                        <div class="dashboard-title">Frequent Visits</div>
                        <div class="dashboard-value">0</div>
                    </div>
                    <hr>
                    <div class="mb-3 align-items-center d-flex justify-content-between">
                        <div class="dashboard-title">Companies</div>
                        <div class="small fw-semibold">
                            {{ $companies->implode(', ') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="col-md-3">
            <div class="border-0 shadow-sm card dashboard-card h-100">
                <div class="card-body">
                    <div class="mb-3 align-items-center d-flex justify-content-between">
                        <div class="dashboard-title">Working Value</div>
                        <div class="dashboard-value">Tk 0</div>
                    </div>
                    <hr>
                    <div class="mb-3 align-items-center d-flex justify-content-between">
                        <div class="dashboard-title">Closed Value</div>
                        <div class="dashboard-value">Tk 0</div>
                    </div>
                    <hr>
                    <div class="mb-3 align-items-center d-flex justify-content-between">
                        <div class="dashboard-title">Lost Value</div>
                        <div class="dashboard-value">Tk 0</div>
                    </div>
                    <hr>
                    <div class="mb-3 align-items-center d-flex justify-content-between">
                        <div class="dashboard-title">Transport Cost</div>
                        <div class="dashboard-value text-warning">
                            Tk {{ number_format($transportCost) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="col-md-3">
            <div class="text-white border-0 shadow-sm card dashboard-card h-100"
                style="background:linear-gradient(135deg,#0d6efd,#6610f2)">
                <div class="card-body">
                    @php
                    $achievedPercent = $salesTarget > 0
                    ? ($records->sum('value') / $salesTarget) * 100 : 0;

                    $costRatio = $records->sum('value') > 0
                    ? ($records->sum('cost') / $records->sum('value')) * 100 : 0;
                    @endphp

                    <div class="mb-3 align-items-center d-flex justify-content-between">
                        <div class="dashboard-title text-light">Sales Target</div>
                        <div class="dashboard-value">
                            Tk {{ number_format($salesTarget) }}
                        </div>
                    </div>
                    <hr style="border-color:rgba(255,255,255,.3)">
                    <div class="mb-3 align-items-center d-flex justify-content-between">
                        <div class="dashboard-title text-light">Achieved</div>
                        <div class="dashboard-value">
                            {{ number_format($achievedPercent,2) }}%
                        </div>
                    </div>
                    <hr style="border-color:rgba(255,255,255,.3)">
                    <div class="mb-3 align-items-center d-flex justify-content-between">
                        <div class="dashboard-title text-light">Cost Ratio</div>
                        <div class="dashboard-value">
                            {{ number_format($costRatio,2) }}%
                        </div>
                    </div>
                    <hr style="border-color:rgba(255,255,255,.3)">
                    <div class="mb-3 align-items-center d-flex justify-content-between">
                        <div class="dashboard-title text-light">Others Cost</div>
                        <div class="dashboard-value">
                            {{ number_format($costRatio,2) }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ================== TABLE HEADER ================== --}}
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Movement Records</h5>
        <button class="px-4 btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#addMovementModal">
            <i class="bi bi-plus-circle me-1"></i> Add Movement
        </button>
    </div>

    {{-- ================== TABLE ================== --}}
    <div class="p-2 bg-white rounded shadow-sm table-responsive">
        <table class="table mb-0 align-middle table-bordered table-hover" style="min-width:1200px">
            <thead style="background:linear-gradient(135deg,#0d6efd,#6610f2);color:white">
                <tr>
                    @foreach(['Status','Date','Start','Finish','Duration','Area','Transport','Cost','Type','Company','Contact','Number','Value','Status','Purpose'] as $h)
                    <th class="text-center small fw-semibold">{{ $h }}</th>
                    @endforeach
                    <th class="text-center small fw-semibold">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr class="clickable-row"
                    data-href="{{ route('admin.movement.show',$record->id) }}">
                    <td class="text-center">{{ ucfirst($record->status) }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($record->date)->format('d-M-Y') }}</td>
                    <td class="text-center">{{ date('h:i A', strtotime($record->start_time)) }}</td>
                    <td class="text-center">{{ date('h:i A', strtotime($record->end_time)) }}</td>
                    <td class="text-center">{{ $record->duration }}</td>
                    <td class="text-center">{{ $record->area }}</td>
                    <td class="text-center">{{ $record->transport }}</td>
                    <td class="text-end">Tk {{ number_format($record->cost) }}</td>
                    <td class="text-center">{{ $record->meeting_type }}</td>
                    <td>{{ $record->company }}</td>
                    <td>{{ $record->contact_person }}</td>
                    <td class="text-center">{{ $record->contact_number }}</td>
                    <td class="text-end">Tk {{ number_format($record->value) }}</td>
                    <td class="text-center">{{ $record->status }}</td>
                    <td>{{ $record->purpose }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.movement.show',$record->id) }}"
                            class="btn btn-sm btn-outline-primary">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-end">
        {{ $records->links() }}
    </div>

    <!-- Add Movement Modal -->
    <div class="modal fade" id="addMovementModal" tabindex="-1" aria-labelledby="addMovementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="py-3 modal-header" style="background:linear-gradient(135deg,#0d6efd,#6610f2); color:white !important">
                    <h5 class="text-white modal-title" id="addMovementModalLabel">Add Movement Record</h5>
                    <button type="button" class="text-white btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Include the form content here -->
                    <form action="{{ route('admin.movement.store') }}" method="POST" id="movementForm">
                        @csrf

                        <div class="row">
                            <!-- Movement Details -->
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Movement Date *</label>
                                <input type="date" class="rounded form-control" name="date"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Status *</label>
                                <select class="form-select" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <label class="form-label">Start Time</label>
                                <div class="mb-3 input-group">
                                    <button class="btn btn-secondary" type="button" id="button-addon1" onclick="setCurrentTime('start_time')">Start</button>
                                    <input type="datetime" class="rounded form-control" id="start_time" name="start_time" aria-describedby="button-addon1">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label class="form-label">End Time</label>
                                <div class="mb-3 input-group">
                                    <button class="btn btn-secondary" type="button" id="button-addon2" onclick="setCurrentTime('end_time')">Finish</button>
                                    <input type="datetime" class="rounded form-control" id="end_time" name="end_time" aria-describedby="button-addon2">
                                </div>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label class="form-label">Duration</label>
                                <input type="text" class="rounded form-control" id="duration_display" readonly>
                                <input type="hidden" name="duration" id="duration">
                            </div>

                            <!-- Meeting Type -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Movement Type</label>
                                <select class="form-select" name="meeting_type" data-control="select2">
                                    <option value="">Select Type</option>
                                    <option value="follow-up">Follow-up Call</option>
                                    <option value="meeting">Meeting</option>
                                    <option value="presentation">Presentation</option>
                                    <option value="negotiation">Negotiation</option>
                                    <option value="site-visit">Site Visit</option>
                                </select>
                            </div>

                            <!-- Company Section with Modal -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Company *</label>
                                <div class="input-group">
                                    <input type="text" class="rounded form-control" name="company" id="companyInput" readonly required>
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#companyDetailsModal">
                                        + Company Details
                                    </button>
                                </div>
                            </div>

                            <!-- Hidden fields for company details -->
                            <input type="hidden" name="contact_person" id="contactPersonField">
                            <input type="hidden" name="contact_number" id="contactNumberField">
                            <input type="hidden" name="area" id="areaField">
                            <input type="hidden" name="location" id="locationField">



                            <div class="mb-3 col-md-3">
                                <label class="form-label">Transport</label>
                                <select class="form-select" name="transport">
                                    <option value="">Select Transport</option>
                                    <option value="car">Car</option>
                                    <option value="train">Train</option>
                                    <option value="bus">Bus</option>
                                    <option value="flight">Flight</option>
                                    <option value="taxi">Taxi</option>
                                    <option value="walking">Walking</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Cost (Tk)</label>
                                <input type="number" class="rounded form-control" name="cost" step="0.01" min="0">
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Value (Tk)</label>
                                <input type="number" class="rounded form-control" name="value" step="0.01" min="0">
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Value Status</label>
                                <select class="form-select" name="value_status">
                                    <option value="">Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="negotiating">Negotiating</option>
                                    <option value="closed">Closed</option>
                                    <option value="lost">Lost</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Purpose / Work Summary *</label>
                                <textarea class="rounded form-control" name="purpose" rows="3" required></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Additional Comments</label>
                                <textarea class="rounded form-control" name="comments" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="border-0 modal-footer">
                    <button type="button" class="px-5 py-3 rounded-0 btn btn-primary" onclick="saveMovement()">Save</button>
                    <button type="button" class="px-5 py-3 rounded-0 btn btn-success" onclick="saveAndAddAnother()">Save & Add Another</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Company Details Modal -->
    <div class="modal fade" id="companyDetailsModal" tabindex="-1" aria-labelledby="companyDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="companyDetailsModalLabel">Company Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> -->
                <div class="py-3 modal-header" style="background:linear-gradient(135deg,#0d6efd,#6610f2); color:white !important">
                    <h5 class="text-white modal-title" id="addMovementModalLabel">Company Details</h5>
                    <button type="button" class="text-white btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Company Name *</label>
                            <input type="text" class="rounded form-control" id="companyName" placeholder="Enter company name" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Contact Person *</label>
                            <input type="text" class="rounded form-control" id="contactPerson" placeholder="Enter contact person name" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Contact Number *</label>
                            <input type="text" class="rounded form-control" id="contactNumber" placeholder="Enter contact number" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Area *</label>
                            <input type="text" class="rounded form-control" id="area" placeholder="Enter area" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label class="form-label">Location *</label>
                            <select class="rounded form-control" id="location">
                                <option value="">Select Location</option>
                                <option value="Office">Office</option>
                                <option value="Client">Client</option>
                                <option value="Site">Site</option>
                                <option value="Vendor">Vendor</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="border-0 modal-footer">
                    <button type="button" class="px-5 py-3 rounded-0 btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="px-5 py-3 rounded-0 btn btn-success" onclick="saveCompanyDetails()">Save Company Details</button>
                </div>
            </div>
        </div>
    </div>
    <!-- JS for clickable rows and form functionality -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Clickable rows
            const rows = document.querySelectorAll(".clickable-row");
            rows.forEach(row => {
                row.style.cursor = "pointer";
                row.addEventListener("mouseover", () => row.style.backgroundColor = '#e9ecef');
                row.addEventListener("mouseout", () => {
                    const index = Array.from(row.parentNode.children).indexOf(row);
                    row.style.backgroundColor = index % 2 === 0 ? '#f8f9fa' : '#ffffff';
                });
                row.addEventListener("click", function(e) {
                    if (e.target.tagName.toLowerCase() !== 'a' && !e.target.closest('a')) {
                        window.location.href = this.dataset.href;
                    }
                });
            });

            // Time change listeners for duration calculation
            document.getElementById('start_time')?.addEventListener('change', calculateDuration);
            document.getElementById('end_time')?.addEventListener('change', calculateDuration);

            // Company modal validation
            document.getElementById('companyDetailsModal').addEventListener('shown.bs.modal', function() {
                document.getElementById('companyName').focus();
            });
        });

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
            const startTime = document.getElementById('start_time')?.value;
            const endTime = document.getElementById('end_time')?.value;
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

        // Save company details
        function saveCompanyDetails() {
            const companyName = document.getElementById('companyName').value;
            const contactPerson = document.getElementById('contactPerson').value;
            const contactNumber = document.getElementById('contactNumber').value;
            const area = document.getElementById('area').value;
            const location = document.getElementById('location').value;

            // Validate all fields
            if (!companyName || !contactPerson || !contactNumber || !area || !location) {
                alert('Please fill all required company details');
                return;
            }

            // Set values in the main form
            document.getElementById('companyInput').value = companyName;
            document.getElementById('contactPersonField').value = contactPerson;
            document.getElementById('contactNumberField').value = contactNumber;
            document.getElementById('areaField').value = area;
            document.getElementById('locationField').value = location;

            // Close company modal
            const companyModal = bootstrap.Modal.getInstance(document.getElementById('companyDetailsModal'));
            companyModal.hide();

            // Show success message
            showCompanySummary(companyName, contactPerson, contactNumber, area, location);
        }

        // Show company summary
        function showCompanySummary(companyName, contactPerson, contactNumber, area, location) {
            // Remove existing summary if any
            const existingSummary = document.getElementById('companySummary');
            if (existingSummary) {
                existingSummary.remove();
            }

            // Create summary element
            const summaryDiv = document.createElement('div');
            summaryDiv.id = 'companySummary';
            summaryDiv.className = 'alert alert-info mt-2';
            summaryDiv.innerHTML = `
                <div class="row">
                    <div class="col-md-3"><strong>Company:</strong> ${companyName}</div>
                    <div class="col-md-3"><strong>Contact:</strong> ${contactPerson}</div>
                    <div class="col-md-2"><strong>Phone:</strong> ${contactNumber}</div>
                    <div class="col-md-2"><strong>Area:</strong> ${area}</div>
                    <div class="col-md-2"><strong>Location:</strong> ${location}</div>
                </div>
                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="editCompanyDetails()">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
            `;

            // Insert after company input
            const companyInput = document.getElementById('companyInput');
            companyInput.parentNode.parentNode.appendChild(summaryDiv);
        }

        // Edit company details
        function editCompanyDetails() {
            // Populate modal with existing values
            document.getElementById('companyName').value = document.getElementById('companyInput').value;
            document.getElementById('contactPerson').value = document.getElementById('contactPersonField').value;
            document.getElementById('contactNumber').value = document.getElementById('contactNumberField').value;
            document.getElementById('area').value = document.getElementById('areaField').value;
            document.getElementById('location').value = document.getElementById('locationField').value;

            // Show modal
            const companyModal = new bootstrap.Modal(document.getElementById('companyDetailsModal'));
            companyModal.show();
        }

        // Save movement
        function saveMovement() {
            // Validate company is filled
            if (!document.getElementById('companyInput').value) {
                alert('Please add company details before saving');
                const companyModal = new bootstrap.Modal(document.getElementById('companyDetailsModal'));
                companyModal.show();
                return;
            }

            document.getElementById('movementForm').submit();
        }

        // Save and add another
        function saveAndAddAnother() {
            // Validate company is filled
            if (!document.getElementById('companyInput').value) {
                alert('Please add company details before saving');
                const companyModal = new bootstrap.Modal(document.getElementById('companyDetailsModal'));
                companyModal.show();
                return;
            }

            document.getElementById('movementForm').submit();
        }

        // Handle modal form submission success
        @if(session('success'))
        @if(session('modal_success'))
        // If this was a modal submission, close the modal and refresh the page
        var modal = bootstrap.Modal.getInstance(document.getElementById('addMovementModal'));
        if (modal) {
            modal.hide();
        }
        setTimeout(() => {
            window.location.reload();
        }, 100);
        @endif
        @endif
    </script>

</div>
@endsection