@extends('admin.master')

@section('title', 'Add Attendance Record')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus me-2"></i>Add Attendance Record
        </h1>
        <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Attendance Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.attendance.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Meeting Selection -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meeting *</label>
                                <select name="meeting_id" class="form-control @error('meeting_id') is-invalid @enderror" required>
                                    <option value="">Select Meeting</option>
                                    @foreach($meetings as $meeting)
                                        <option value="{{ $meeting->id }}" {{ old('meeting_id') == $meeting->id ? 'selected' : '' }}>
                                            {{ $meeting->title }} - {{ $meeting->date->format('M d, Y') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('meeting_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Staff Selection -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Staff Member *</label>
                                <select name="staff_id" class="form-control @error('staff_id') is-invalid @enderror" required>
                                    <option value="">Select Staff</option>
                                    @php
                                        $staffList = \App\Models\Admin::active()->get();
                                    @endphp
                                    @foreach($staffList as $staff)
                                        <option value="{{ $staff->id }}" {{ old('staff_id') == $staff->id ? 'selected' : '' }}>
                                            {{ $staff->name }} ({{ $staff->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('staff_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Status Selection -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">Select Status</option>
                                    <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                                    <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>Late</option>
                                    <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                    <option value="work_from_field" {{ old('status') == 'work_from_field' ? 'selected' : '' }}>Work From Field</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Join Time -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Join Time</label>
                                <div class="input-group">
                                    <input type="datetime-local" name="join_time" 
                                           value="{{ old('join_time', now()->format('Y-m-d\TH:i')) }}" 
                                           class="form-control @error('join_time') is-invalid @enderror">
                                    <button type="button" class="btn btn-outline-secondary" onclick="setCurrentTime('join_time')">
                                        <i class="fas fa-clock"></i>
                                    </button>
                                </div>
                                @error('join_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty for current time</small>
                            </div>
                            
                            <!-- Leave Time -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Leave Time (Optional)</label>
                                <div class="input-group">
                                    <input type="datetime-local" name="leave_time" 
                                           value="{{ old('leave_time') }}" 
                                           class="form-control @error('leave_time') is-invalid @enderror">
                                    <button type="button" class="btn btn-outline-secondary" onclick="setCurrentTime('leave_time')">
                                        <i class="fas fa-clock"></i>
                                    </button>
                                </div>
                                @error('leave_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Department -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department</label>
                                <input type="text" name="department" 
                                       value="{{ old('department') }}" 
                                       class="form-control @error('department') is-invalid @enderror"
                                       placeholder="Enter department">
                                @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Manual Time Adjustment -->
                            <div class="col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="manual_time" value="1" 
                                           class="form-check-input @error('manual_time') is-invalid @enderror"
                                           id="manual_time">
                                    <label class="form-check-label" for="manual_time">
                                        Requires Supervisor Approval
                                    </label>
                                </div>
                                <small class="text-muted">Check if time was manually adjusted</small>
                            </div>
                            
                            <!-- Notes -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Notes (Optional)</label>
                                <textarea name="notes" rows="3" 
                                          class="form-control @error('notes') is-invalid @enderror"
                                          placeholder="Additional notes or comments">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- QR Code Option -->
                            {{-- <div class="col-12 mb-3">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white py-2">
                                        <h6 class="mb-0">
                                            <i class="fas fa-qrcode me-2"></i>QR Code Attendance
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-2">Alternatively, you can mark attendance via QR code:</p>
                                        <div class="d-flex">
                                            <select id="qrMeetingSelect" class="form-control me-2">
                                                <option value="">Select Meeting for QR</option>
                                                @foreach($meetings as $meeting)
                                                    @if($meeting->attendance_qr_code)
                                                        <option value="{{ $meeting->id }}">{{ $meeting->title }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-warning" onclick="showQRCode()">
                                                <i class="fas fa-qrcode me-2"></i>Show QR Code
                                            </button>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>--}}
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-redo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <!-- QR Code Modal -->
<div class="modal fade" id="qrModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan QR Code for Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qrCodeDisplay"></div>
                <p class="mt-3 text-muted">Scan this QR code with staff device to mark attendance</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadQR()">
                    <i class="fas fa-download me-2"></i>Download QR
                </button>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@push('scripts')
<script>
    function setCurrentTime(fieldId) {
        const now = new Date();
        const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
        document.querySelector(`[name="${fieldId}"]`).value = localDateTime;
    }
    
    function showQRCode() {
        const meetingId = document.getElementById('qrMeetingSelect').value;
        if (!meetingId) {
            alert('Please select a meeting first');
            return;
        }
        
        // Fetch QR code URL
        fetch(`/admin/staff-meetings/${meetingId}/get-qr-url`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('qrCodeDisplay').innerHTML = `
                        <img src="${data.qr_code_url}" alt="QR Code" class="img-fluid" style="max-width: 300px;">
                    `;
                    const modal = new bootstrap.Modal(document.getElementById('qrModal'));
                    modal.show();
                } else {
                    alert('QR code not available for this meeting');
                }
            })
            .catch(error => {
                alert('Error loading QR code');
            });
    }
    
    function downloadQR() {
        const img = document.querySelector('#qrCodeDisplay img');
        if (img) {
            const link = document.createElement('a');
            link.href = img.src;
            link.download = 'meeting_attendance_qr.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
    
    // Auto-fill department when staff is selected
    document.querySelector('[name="staff_id"]').addEventListener('change', function() {
        const staffId = this.value;
        if (staffId) {
            fetch(`/api/staff/${staffId}/department`)
                .then(response => response.json())
                .then(data => {
                    if (data.department) {
                        document.querySelector('[name="department"]').value = data.department;
                    }
                });
        }
    });
</script>
@endpush