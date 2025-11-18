@extends('admin.master')

@section('title', 'Assign Permissions to User')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Assign Permissions to: {{ $user->name }}</h2>
        <a href="{{ route('admin.user-permission.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.user-permission.store', $user->id) }}" method="POST">
        @csrf
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Available Permissions</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="selectAll">
                        <label class="form-check-label" for="selectAll">
                            <strong>Select All Permissions</strong>
                        </label>
                    </div>
                </div>
                
                <div class="row">
                    @foreach($permissions as $permission)
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <!-- Hidden field for unchecked state -->
                                <input type="hidden" name="permissions[{{ $permission->id }}]" value="0">
                                <!-- Actual checkbox -->
                                <input type="checkbox" class="form-check-input permissionCheckbox" 
                                       id="permission_{{ $permission->id }}"
                                       name="permissions[{{ $permission->id }}]" value="1"
                                       {{ $user->hasDirectPermission($permission->name) ? 'checked' : '' }}>
                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Assign Permissions
            </button>
            <a href="{{ route('admin.user-permission.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.permissionCheckbox');
        
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Update select all when individual checkboxes change
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAll.checked = false;
                } else {
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    selectAll.checked = allChecked;
                }
            });
        });
    });
</script>
@endpush