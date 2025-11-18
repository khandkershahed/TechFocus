@extends('admin.master')

@section('title', 'Edit Permission')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Permission</h2>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Permissions
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

    <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="card">
            <div class="card-body">
                <h5>Edit Permission</h5>
                
                <!-- Single Permission Edit -->
                <div class="mb-4">
                    <div class="mb-3">
                        <label for="name" class="form-label">Permission Name *</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name', $permission->name) }}" required>
                    </div>
                </div>

                <hr>

                <!-- Quick Permission Templates -->
                <div class="mb-3">
                    <h6>Quick Select Templates</h6>
                    
                    <!-- Select All Checkbox -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                            <label class="form-check-label" for="selectAll">
                                <strong>Select All Template Permissions</strong>
                            </label>
                        </div>
                    </div>

                    <!-- Permission Checkboxes (for reference/quick fill) -->
                    <div class="border p-3 rounded">
                        <div class="row">
                            @php
                                $defaultPermissions = [
                                    'view principals',
                                    'create principals',
                                    'edit principals', 
                                    'delete principals',
                                    'manage users',
                                    'manage roles',
                                    'share principals',
                                    'manage settings'
                                ];
                            @endphp

                            @foreach($defaultPermissions as $templatePermission)
                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input permission-template" 
                                               value="{{ $templatePermission }}"
                                               id="template_{{ Str::slug($templatePermission) }}"
                                               {{ $permission->name === $templatePermission ? 'checked' : '' }}>
                                        <label class="form-check-label" for="template_{{ Str::slug($templatePermission) }}">
                                            {{ $templatePermission }}
                                            @if($permission->name === $templatePermission)
                                                <span class="badge bg-success">Current</span>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-text mt-2">
                        Check a template permission to quickly fill the name field above.
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Permission
            </button>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
            
            <!-- Delete Button -->
            <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Are you sure you want to delete this permission?')">
                    <i class="fas fa-trash"></i> Delete Permission
                </button>
            </form>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const templateCheckboxes = document.querySelectorAll('.permission-template');
        const nameInput = document.getElementById('name');

        // Select All functionality for templates
        selectAll.addEventListener('change', function() {
            templateCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            
            // If selecting all, fill with first permission name
            if (this.checked && templateCheckboxes.length > 0) {
                nameInput.value = templateCheckboxes[0].value;
            }
        });

        // Template checkbox click - fill the name input
        templateCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    nameInput.value = this.value;
                    
                    // Uncheck other template checkboxes (single selection)
                    templateCheckboxes.forEach(otherCheckbox => {
                        if (otherCheckbox !== this) {
                            otherCheckbox.checked = false;
                        }
                    });
                    
                    // Uncheck select all if it was checked
                    selectAll.checked = false;
                }
            });
        });

        // Update select all when individual template checkboxes change
        templateCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAll.checked = false;
                } else {
                    const allChecked = Array.from(templateCheckboxes).every(cb => cb.checked);
                    selectAll.checked = allChecked;
                }
            });
        });

        // Auto-check the template that matches current permission name
        const currentPermission = "{{ $permission->name }}";
        templateCheckboxes.forEach(checkbox => {
            if (checkbox.value === currentPermission) {
                checkbox.checked = true;
            }
        });
    });
</script>
@endpush