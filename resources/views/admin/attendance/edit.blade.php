@extends('admin.master')

@section('title', 'Edit Attendance Record')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit me-2"></i>Edit Attendance Record
        </h1>
        <div>
            <a href="{{ route('admin.attendance.show', $attendance) }}" class="btn btn-info me-2">
                <i class="fas fa-eye me-2"></i>View
            </a>
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Edit Record for {{ $attendance->staff_name }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.attendance.update', $attendance) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Display Info (Readonly) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Staff</label>
                                <input type="text" class="form-control" value="{{ $attendance->staff_name }}" readonly>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meeting</label>
                                <input type="text" class="form-control" value="{{ $attendance->meeting->title ?? 'N/A' }}" readonly>
                            </div>
                            
                            <!-- Status Selection -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="present" {{ old('status', $attendance->status) == 'present' ? 'selected' : '' }}>Present</option>
                                    <option value="late" {{ old('status', $attendance->status) == 'late' ? 'selected' : '' }}>Late</option>
                                    <option value="absent" {{ old('status', $attendance->status) == 'absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="on_leave" {{ old('status', $attendance->status) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                    <option value="work_from_field" {{ old('status', $attendance->status) == 'work_from_field' ? 'selected' : '' }}>Work From Field</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Join Time -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Join Time</label>
                                <input type="datetime-local" name="join_time" 
                                       value="{{ old('join_time', $attendance->join_time ? $attendance->join_time->format('Y-m-d\TH:i') : '') }}" 
                                       class="form-control @error('join_time') is-invalid @enderror">
                                @error('join_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Leave Time -->
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Leave Time (Optional)</label>
                                <input type="datetime-local" name="leave_time" 
                                       value="{{ old('leave_time', $attendance->leave_time ? $attendance->leave_time->format('Y-m-d\TH:i') : '') }}" 
                                       class="form-control @error('leave_time') is-invalid @enderror">
                                @error('leave_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Department -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department</label>
                                <input type="text" name="department" 
                                       value="{{ old('department', $attendance->department) }}" 
                                       class="form-control @error('department') is-invalid @enderror">
                                @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                           <!-- Approval Settings -->
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check mt-4">
                                            <input type="checkbox" name="requires_approval" value="1" 
                                                class="form-check-input @error('requires_approval') is-invalid @enderror"
                                                id="requires_approval" {{ old('requires_approval', $attendance->requires_approval) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="requires_approval">
                                                Requires Approval
                                            </label>
                                        </div>
                                        
                                        @auth
                                            @if(auth()->user()->hasRole(['hr', 'management']))
                                            <div class="form-check mt-2">
                                                <input type="checkbox" name="is_approved" value="1" 
                                                    class="form-check-input @error('is_approved') is-invalid @enderror"
                                                    id="is_approved" {{ old('is_approved', $attendance->is_approved) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_approved">
                                                    Mark as Approved
                                                </label>
                                            </div>
                                            @endif
                                        @endauth
                                    </div>
                            
                            <!-- Notes -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Notes (Optional)</label>
                                <textarea name="notes" rows="3" 
                                          class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $attendance->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Original Record Info -->
                            <div class="col-12 mb-3">
                                <div class="card border-secondary">
                                    <div class="card-header bg-secondary text-white py-2">
                                        <h6 class="mb-0">
                                            <i class="fas fa-info-circle me-2"></i>Original Record Information
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <small class="text-muted">Recorded On:</small>
                                                <p>{{ $attendance->created_at->format('M d, Y h:i A') }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <small class="text-muted">Device IP:</small>
                                                <p>{{ $attendance->device_ip ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <small class="text-muted">Last Updated:</small>
                                                <p>{{ $attendance->updated_at->format('M d, Y h:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-danger" 
                                    onclick="if(confirm('Delete this record?')) { document.getElementById('deleteForm').submit(); }">
                                <i class="fas fa-trash me-2"></i>Delete
                            </button>
                            <div>
                                <button type="reset" class="btn btn-secondary me-2">
                                    <i class="fas fa-redo me-2"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Record
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Delete Form -->
                    <form id="deleteForm" action="{{ route('admin.attendance.destroy', $attendance) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection