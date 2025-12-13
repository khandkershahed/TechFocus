@extends('admin.master')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="bg-primary text-white rounded shadow p-3 text-center mb-4">
        <h2 class="h5 fw-bold text-uppercase">SALES - MOVEMENT STATISTICS</h2>
    </div>

    <div class="row g-4 mb-4">
        <!-- Card 1: #Days / Companies / Visits / Areas -->
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0"># of Days</h6>
                        <h3 class="fw-bold mb-0">{{ $totalDays }}</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0"># of Companies</h6>
                        <h3 class="fw-bold mb-0">{{ $totalCompanies }}</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0"># of Visits</h6>
                        <h3 class="fw-bold mb-0">{{ $totalVisits }}</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-uppercase text-muted mb-0"># of Areas</h6>
                        <h3 class="fw-bold mb-0">{{ $totalAreas }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Highest / Lowest / Companies / Frequent -->
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0">Highest Value & Company</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($highestValue ?? 0) }} Tk</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0">Lowest Value & Company</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($lowestValue ?? 0) }} Tk</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0">Frequent Visits</h6>
                        <h3 class="fw-bold mb-0">0</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-uppercase text-muted mb-0">Name Of those Companies</h6>
                        <h3 class="fw-bold mb-0">{{ $companies->implode(', ') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Working / Closed / Lost / Transport -->
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0">Working Value</h6>
                        <h3 class="fw-bold mb-0">Tk. 0</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0">Closed Value</h6>
                        <h3 class="fw-bold mb-0">Tk. 0</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-muted mb-0">Lost Value</h6>
                        <h3 class="fw-bold mb-0">Tk. 0</h3>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-uppercase text-muted mb-0">Transport Cost</h6>
                        <h3 class="fw-bold mb-0">Tk. {{ number_format($transportCost) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Sales Target / Achieved / Cost Ratio -->
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center" style="background: linear-gradient(135deg, #0d6efd, #6610f2); color:white;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-light mb-0">Sales Target</h6>
                        <h3 class="fw-bold mb-0">Tk. {{ number_format($salesTarget) }}</h3>
                    </div>

                    <hr class="my-2" style="border-color: rgba(255,255,255,0.3);">

                    @php
                        $achievedPercent = $salesTarget > 0 ? ($records->sum('value') / $salesTarget) * 100 : 0;
                        $costRatio = $records->sum('cost') > 0 && $records->sum('value') > 0 ? ($records->sum('cost') / $records->sum('value') * 100) : 0;
                    @endphp

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-uppercase text-light mb-0">Achieved %</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($achievedPercent, 2) }}%</h3>
                    </div>

                    <hr class="my-2" style="border-color: rgba(255,255,255,0.3);">

                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-uppercase text-light mb-0">Cost Ratio</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($costRatio, 2) }}%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Movement Button -->
    <div class="text-end mb-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMovementModal">
            + Add Movement
        </button>
    </div>

    <!-- Table -->
    <div class="table-responsive shadow rounded p-3 bg-light">
        <table class="table table-bordered table-hover mb-0 align-middle" style="border-color: #dee2e6; min-width: 1200px;">
            <thead style="background: linear-gradient(135deg, #0d6efd, #6610f2); color:white;">
                <tr>
                    @foreach(['Status','Date','Start','Finish','Duration','Area','Transport','Cost','Movementyy Type','Company','Contact','Number','Value','Status','Purpose'] as $header)
                        <th class="text-center small fw-bold">{{ $header }}</th>
                    @endforeach
                    <th class="text-center small fw-bold">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $index => $record)
                <tr class="clickable-row" data-href="{{ route('admin.movement.show', $record->id) }}" 
                    style="background-color: {{ $index % 2 === 0 ? '#f8f9fa' : '#ffffff' }};">
                    <td class="text-center">{{ ucfirst($record->status) }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($record->date)->format('d-M-Y') }}</td>
                    <td class="text-center">{{ date('h:i A', strtotime($record->start_time)) }}</td>
                    <td class="text-center">{{ date('h:i A', strtotime($record->end_time)) }}</td>
                    <td class="text-center">{{ $record->duration }}</td>
                    <td class="text-center">{{ $record->area }}</td>
                    <td class="text-center">{{ $record->transport }}</td>
                    <td class="text-end">Tk. {{ number_format($record->cost) }}</td>
                    <td class="text-center">{{ $record->meeting_type }}</td>
                    <td class="text-start">{{ $record->company }}</td>
                    <td class="text-start">{{ $record->contact_person }}</td>
                    <td class="text-center">{{ $record->contact_number }}</td>
                    <td class="text-end">Tk. {{ number_format($record->value) }}</td>
                    <td class="text-center">{{ $record->status }}</td>
                    <td class="text-start">{{ $record->purpose }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.movement.show', $record->id) }}" class="btn btn-sm btn-primary">View</a>
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
                <div class="modal-header">
                    <h5 class="modal-title" id="addMovementModalLabel">Add Movement Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Include the form content here -->
                    <form action="{{ route('admin.movement.store') }}" method="POST" id="movementForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Movement Details -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Movement Date *</label>
                                <input type="date" class="form-control" name="date" 
                                       value="{{ date('Y-m-d') }}" required>
                            </div> 

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status *</label>
                                <select class="form-select" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <!-- Time Management -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Time</label>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-primary" onclick="setCurrentTime('start_time')">
                                        Start
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" onclick="setCurrentTime('end_time')">
                                        Finish
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="start_time" name="start_time">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">End Time</label>
                                <input type="time" class="form-control" id="end_time" name="end_time">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Duration</label>
                                <input type="text" class="form-control" id="duration_display" readonly>
                                <input type="hidden" name="duration" id="duration">
                            </div>

                            <!-- Meeting Type -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Movement Type</label>
                                <select class="form-select" name="meeting_type">
                                    <option value="">Select Type</option>
                                    <option value="follow-up">Follow-up Call</option>
                                    <option value="meeting">Meeting</option>
                                    <option value="presentation">Presentation</option>
                                    <option value="negotiation">Negotiation</option>
                                    <option value="site-visit">Site Visit</option>
                                </select>
                            </div>

                            <!-- Company Section with Modal -->
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Company *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="company" id="companyInput" readonly required>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#companyDetailsModal">
                                        <i class="bi bi-building"></i> Add Company Details
                                    </button>
                                </div>
                                <small class="text-muted">Click the button to add company details</small>
                            </div>

                            <!-- Hidden fields for company details -->
                            <input type="hidden" name="contact_person" id="contactPersonField">
                            <input type="hidden" name="contact_number" id="contactNumberField">
                            <input type="hidden" name="area" id="areaField">
                            <input type="hidden" name="location" id="locationField">

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Purpose / Work Summary *</label>
                                <textarea class="form-control" name="purpose" rows="3" required></textarea>
                            </div>

                            <div class="col-md-3 mb-3">
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

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Cost (Tk)</label>
                                <input type="number" class="form-control" name="cost" step="0.01" min="0">
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Value (Tk)</label>
                                <input type="number" class="form-control" name="value" step="0.01" min="0">
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Value Status</label>
                                <select class="form-select" name="value_status">
                                    <option value="">Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="negotiating">Negotiating</option>
                                    <option value="closed">Closed</option>
                                    <option value="lost">Lost</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Additional Comments</label>
                                <textarea class="form-control" name="comments" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveMovement()">Save</button>
                    <button type="button" class="btn btn-outline-primary" onclick="saveAndAddAnother()">Save & Add Another</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Company Details Modal -->
    <div class="modal fade" id="companyDetailsModal" tabindex="-1" aria-labelledby="companyDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyDetailsModalLabel">Company Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Company Name *</label>
                            <input type="text" class="form-control" id="companyName" placeholder="Enter company name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Person *</label>
                            <input type="text" class="form-control" id="contactPerson" placeholder="Enter contact person name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Number *</label>
                            <input type="text" class="form-control" id="contactNumber" placeholder="Enter contact number" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Area *</label>
                            <input type="text" class="form-control" id="area" placeholder="Enter area" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location *</label>
                            <select class="form-control" id="location">
                                <option value="">Select Location</option>
                                <option value="Office">Office</option>
                                <option value="Client">Client</option>
                                <option value="Site">Site</option>
                                <option value="Vendor">Vendor</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveCompanyDetails()">Save Company Details</button>
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
                    if(e.target.tagName.toLowerCase() !== 'a' && !e.target.closest('a')) {
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
                
                if(durationField) durationField.value = durationString;
                if(durationDisplay) durationDisplay.value = `${diffHours}h ${diffMinutes}m`;
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
                if(modal) {
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