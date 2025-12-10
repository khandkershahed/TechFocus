@extends('admin.master')

@section('title', 'Edit Meeting')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit me-2"></i>Edit Meeting
        </h1>
        <div>
            <a href="{{ route('admin.staff-meetings.show', $staffMeeting) }}" class="btn btn-info me-2">
                <i class="fas fa-eye me-2"></i>View
            </a>
            <a href="{{ route('admin.staff-meetings.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Meeting Details</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.staff-meetings.update', $staffMeeting) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Meeting Title -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Meeting Title *</label>
                                <input type="text" name="title" 
                                       value="{{ old('title', $staffMeeting->title) }}" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Date -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date *</label>
                                <input type="date" name="date" 
                                       value="{{ old('date', $staffMeeting->date->format('Y-m-d')) }}" 
                                       class="form-control @error('date') is-invalid @enderror" 
                                       required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Time -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Start Time *</label>
                                <input type="time" name="start_time" 
                                       value="{{ old('start_time', $staffMeeting->form_start_time ?? $staffMeeting->start_time->format('H:i')) }}" 
                                       class="form-control @error('start_time') is-invalid @enderror" 
                                       required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label class="form-label">End Time *</label>
                                <input type="time" name="end_time" 
                                       value="{{ old('end_time', $staffMeeting->form_end_time ?? $staffMeeting->end_time->format('H:i')) }}" 
                                       class="form-control @error('end_time') is-invalid @enderror" 
                                       required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Category -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Category *</label>
                                <select name="category" class="form-control @error('category') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $key => $value)
                                        <option value="{{ $key }}" {{ old('category', $staffMeeting->category) == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Department -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Department</label>
                                <select name="department" class="form-control @error('department') is-invalid @enderror">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept }}" {{ old('department', $staffMeeting->department) == $dept ? 'selected' : '' }}>
                                            {{ $dept }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                         <!-- Meeting Type -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Meeting Type *</label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="">Select Type</option>
                                    <option value="office" {{ old('type', $staffMeeting->type) == 'office' ? 'selected' : '' }}>Office</option>
                                    <option value="out_of_office" {{ old('type', $staffMeeting->type) == 'out_of_office' ? 'selected' : '' }}>Out of Office</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Platform -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Platform *</label>
                                        <select name="platform" class="form-control @error('platform') is-invalid @enderror" required id="platformSelect">
                                            <option value="">Select Platform</option>
                                            @foreach($platforms as $key => $value)
                                                <option value="{{ $key }}" {{ old('platform', $staffMeeting->platform) == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('platform')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Online Platform (if platform is online) -->
                                    <div class="col-md-6 mb-3 online-platform-field" style="{{ old('platform', $staffMeeting->platform) == 'online' ? '' : 'display: none;' }}">
                                        <label class="form-label">Online Platform <span class="text-danger">*</span></label>
                                        <select name="online_platform" 
                                                class="form-control @error('online_platform') is-invalid @enderror"
                                                id="onlinePlatformSelect">
                                            <option value="">Select Online Platform</option>
                                            <option value="zoom" {{ old('online_platform', $staffMeeting->online_platform) == 'zoom' ? 'selected' : '' }}>Zoom</option>
                                            <option value="google_meet" {{ old('online_platform', $staffMeeting->online_platform) == 'google_meet' ? 'selected' : '' }}>Google Meet</option>
                                            <option value="teams" {{ old('online_platform', $staffMeeting->online_platform) == 'teams' ? 'selected' : '' }}>Microsoft Teams</option>
                                        </select>
                                        @error('online_platform')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                                                
                            <!-- Organizer -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Organizer *</label>
                                <select name="organizer_id" class="form-control @error('organizer_id') is-invalid @enderror" required>
                                    <option value="">Select Organizer</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ old('organizer_id', $staffMeeting->organizer_id) == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('organizer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Meeting Owner -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Meeting Owner</label>
                                <select name="admin_id" class="form-control @error('admin_id') is-invalid @enderror">
                                    <option value="">Select Meeting Owner</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ old('admin_id', $staffMeeting->admin_id) == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('admin_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Leader -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Meeting Leader</label>
                                <select name="leader_id" class="form-control @error('leader_id') is-invalid @enderror">
                                    <option value="">Select Leader</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id }}" {{ old('leader_id', $staffMeeting->leader_id) == $admin->id ? 'selected' : '' }}>
                                            {{ $admin->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('leader_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Participants -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Participants</label>
                                <select name="participants[]" class="form-control select2-multiple @error('participants') is-invalid @enderror" multiple>
                                    @foreach($admins as $admin)
                                        @php
                                            $selected = false;
                                            if ($staffMeeting->participants) {
                                                $participantIds = json_decode($staffMeeting->participants, true);
                                                if (is_array($participantIds)) {
                                                    $selected = in_array($admin->id, $participantIds);
                                                }
                                            }
                                        @endphp
                                        <option value="{{ $admin->id }}" {{ $selected ? 'selected' : '' }}>
                                            {{ $admin->name }} ({{ $admin->department ?? 'No Department' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('participants')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Hold Ctrl/Cmd to select multiple participants</small>
                            </div>
                            
                            <!-- Agenda -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Agenda</label>
                                <textarea name="agenda" rows="5" 
                                          class="form-control @error('agenda') is-invalid @enderror">{{ old('agenda', $staffMeeting->agenda) }}</textarea>
                                @error('agenda')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Notes -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" rows="3" 
                                          class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $staffMeeting->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Attachments -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Additional Attachments</label>
                                <input type="file" name="attachments[]" 
                                       class="form-control @error('attachments') is-invalid @enderror" 
                                       multiple>
                                @error('attachments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">You can upload multiple files (max 5MB each)</small>
                                
                              <!-- Existing Attachments -->
@php
    $existingAttachments = [];
    if ($staffMeeting->attachments) {
        if (is_string($staffMeeting->attachments)) {
            $existingAttachments = json_decode($staffMeeting->attachments, true) ?: [];
        } elseif (is_array($staffMeeting->attachments)) {
            $existingAttachments = $staffMeeting->attachments;
        }
    }
@endphp

@if(count($existingAttachments) > 0)
    <div class="mt-3">
        <h6 class="mb-2">Current Attachments:</h6>
        <ul class="list-group">
            @foreach($existingAttachments as $attachment)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-file me-2 text-primary"></i>
                        {{ $attachment['name'] }}
                    </div>
                    <a href="{{ Storage::url($attachment['path']) }}" 
                       target="_blank" 
                       class="btn btn-sm btn-info">
                        <i class="fas fa-download"></i>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif

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
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-danger" 
                                    onclick="if(confirm('Are you sure you want to delete this meeting?')) { document.getElementById('deleteForm').submit(); }">
                                <i class="fas fa-trash me-2"></i>Delete Meeting
                            </button>
                            <div>
                                <button type="reset" class="btn btn-secondary me-2">
                                    <i class="fas fa-redo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Meeting
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Delete Form -->
                    <form id="deleteForm" action="{{ route('admin.staff-meetings.destroy', $staffMeeting) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--multiple {
        min-height: 38px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for participants
        $('.select2-multiple').select2({
            placeholder: "Select participants",
            allowClear: true
        });
        
        // Show/hide online platform field based on platform selection
        $('[name="platform"]').change(function() {
            if ($(this).val() === 'online') {
                $('#onlinePlatformField').show();
            } else {
                $('#onlinePlatformField').hide();
            }
        });
    });
</script>
@endpush