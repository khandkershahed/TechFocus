@extends('admin.master')

@section('title', 'Schedule New Meeting')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-calendar-plus me-2"></i>Schedule New Meeting</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.staff-meetings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-12 mb-4">
                                <h5 class="border-bottom pb-2"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Meeting Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category *</label>
                                <select class="form-control @error('category') is-invalid @enderror" 
                                        id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $key => $value)
                                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-control @error('department') is-invalid @enderror" 
                                        id="department" name="department">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept }}" {{ old('department') == $dept ? 'selected' : '' }}>
                                            {{ $dept }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Date and Time Section -->
                            <div class="col-md-12 mb-4 mt-2">
                                <h5 class="border-bottom pb-2"><i class="fas fa-clock me-2"></i>Date & Time</h5>
                            </div>

                            <!-- Meeting Date -->
                            <div class="col-md-4 mb-3">
                                <label for="date" class="form-label">Meeting Date *</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                       id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Start Time -->
                            <div class="col-md-4 mb-3">
                                <label for="start_time" class="form-label">Start Time *</label>
                                <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                       id="start_time" name="start_time" value="{{ old('start_time', '09:00') }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- End Time -->
                            <div class="col-md-4 mb-3">
                                <label for="end_time" class="form-label">End Time *</label>
                                <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                       id="end_time" name="end_time" value="{{ old('end_time', '10:00') }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                                                       
                            <!-- Location & Platform -->
                            <div class="col-md-12 mb-4 mt-2">
                                <h5 class="border-bottom pb-2"><i class="fas fa-map-marker-alt me-2"></i>Location & Platform</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Meeting Type *</label>
                                <select class="form-control @error('type') is-invalid @enderror" 
                                        id="type" name="type" required>
                                    <option value="office" {{ old('type') == 'office' ? 'selected' : '' }}>In Office</option>
                                    <option value="out_of_office" {{ old('type') == 'out_of_office' ? 'selected' : '' }}>Out of Office</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="platform" class="form-label">Platform *</label>
                                <select class="form-control @error('platform') is-invalid @enderror" 
                                        id="platform" name="platform" required>
                                    <option value="office" {{ old('platform') == 'office' ? 'selected' : '' }}>Office</option>
                                    <option value="online" {{ old('platform') == 'online' ? 'selected' : '' }}>Online</option>
                                    <option value="client_office" {{ old('platform') == 'client_office' ? 'selected' : '' }}>Client Office</option>
                                    <option value="training_center" {{ old('platform') == 'training_center' ? 'selected' : '' }}>Training Center</option>
                                </select>
                                @error('platform')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3" id="online-platform-container" style="display: none;">
                                <label for="online_platform" class="form-label">Online Platform *</label>
                                <select class="form-control @error('online_platform') is-invalid @enderror" 
                                        id="online_platform" name="online_platform">
                                    <option value="">Select Platform</option>
                                    <option value="zoom" {{ old('online_platform') == 'zoom' ? 'selected' : '' }}>Zoom</option>
                                    <option value="google_meet" {{ old('online_platform') == 'google_meet' ? 'selected' : '' }}>Google Meet</option>
                                    <option value="teams" {{ old('online_platform') == 'teams' ? 'selected' : '' }}>Microsoft Teams</option>
                                </select>
                                @error('online_platform')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- People Involved -->
                            <div class="col-md-12 mb-4 mt-2">
                                <h5 class="border-bottom pb-2"><i class="fas fa-users me-2"></i>People Involved</h5>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="admin_id" class="form-label">Meeting Owner</label>
                                <select class="form-control @error('admin_id') is-invalid @enderror" 
                                        id="admin_id" name="admin_id">
                                    <option value="">Select Owner</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ old('admin_id') == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('admin_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="lead_by" class="form-label">Led By</label>
                                <select class="form-control @error('lead_by') is-invalid @enderror" 
                                        id="lead_by" name="lead_by">
                                    <option value="">Select Leader</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ old('lead_by') == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lead_by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="organizer_id" class="form-label">Organizer *</label>
                                <select class="form-control @error('organizer_id') is-invalid @enderror" 
                                        id="organizer_id" name="organizer_id" required>
                                    <option value="">Select Organizer</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ old('organizer_id') == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('organizer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="participants" class="form-label">Participants</label>
                                <select class="form-control select2-multiple @error('participants') is-invalid @enderror" 
                                        id="participants" name="participants[]" multiple>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ in_array($admin->id, old('participants', [])) ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('participants')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Agenda & Notes -->
                            <div class="col-md-12 mb-4 mt-2">
                                <h5 class="border-bottom pb-2"><i class="fas fa-file-alt me-2"></i>Agenda & Notes</h5>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="agenda" class="form-label">Agenda</label>
                                <textarea class="form-control @error('agenda') is-invalid @enderror" 
                                          id="agenda" name="agenda" rows="3">{{ old('agenda') }}</textarea>
                                @error('agenda')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="notes" class="form-label">Notes (Internal)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Attachments -->
                            <div class="col-md-12 mb-4 mt-2">
                                <h5 class="border-bottom pb-2"><i class="fas fa-paperclip me-2"></i>Attachments</h5>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="attachments" class="form-label">Upload Files</label>
                                <input type="file" class="form-control @error('attachments') is-invalid @enderror" 
                                       id="attachments" name="attachments[]" multiple>
                                <small class="text-muted">You can upload multiple files (Max 10MB each)</small>
                                @error('attachments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Status -->
                            <div class="col-md-12 mb-4 mt-2">
                                <h5 class="border-bottom pb-2"><i class="fas fa-tasks me-2"></i>Status</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-control @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : 'selected' }}>Scheduled</option>
                                    <option value="rescheduled" {{ old('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Schedule Meeting
                            </button>
                            <a href="{{ route('admin.staff-meetings.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2 for multiple participants
        $('.select2-multiple').select2({
            placeholder: "Select participants",
            allowClear: true
        });
        
        // Show/hide online platform field
        $('#platform').change(function() {
            if ($(this).val() === 'online') {
                $('#online-platform-container').show();
                $('#online_platform').prop('required', true);
            } else {
                $('#online-platform-container').hide();
                $('#online_platform').prop('required', false);
            }
        });
        
        // Trigger change on page load
        $('#platform').trigger('change');
        
        // Set minimum date to today
        var today = new Date().toISOString().split('T')[0];
        $('#date').attr('min', today);
        
        // REMOVED the flatpickr initialization for time fields
        // These were causing issues because time fields don't need flatpickr
        
        // Validate end time is after start time (with date consideration)
        $('form').submit(function(e) {
            var date = $('#date').val();
            var startTime = $('#start_time').val();
            var endTime = $('#end_time').val();
            
            // Combine date and time for comparison
            var startDateTime = new Date(date + 'T' + startTime + ':00');
            var endDateTime = new Date(date + 'T' + endTime + ':00');
            
            if (endDateTime <= startDateTime) {
                alert('End time must be after start time');
                e.preventDefault();
                return false;
            }
            
            // Also validate that meeting date is not in the past
            var selectedDate = new Date(date);
            var today = new Date();
            today.setHours(0, 0, 0, 0); // Set to beginning of day
            
            if (selectedDate < today) {
                alert('Meeting date cannot be in the past');
                e.preventDefault();
                return false;
            }
            
            return true;
        });
    });
</script>
@endpush
@endsection