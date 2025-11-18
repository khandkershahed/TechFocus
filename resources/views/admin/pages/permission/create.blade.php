@extends('admin.master')

@section('title', 'Create New Permission')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Create New Permission</h2>
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

    <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf
        
        <div class="card">
            <div class="card-body">
                <h5>Select Permissions to Create</h5>
                
                <!-- Select All Checkbox -->
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="selectAll">
                        <label class="form-check-label" for="selectAll">
                            <strong>Select All Permissions</strong>
                        </label>
                    </div>
                </div>

                <!-- Permission Checkboxes -->
                <div class="border p-3 rounded">
                    <div class="row">
                        {{-- @php
                            $defaultPermissions = [
                                'view principals',
                                'create principals',
                                'edit principals', 
                                'delete principals',
                                'manage users',
                                'manage roles',
                                'share principals',
                                'manage settings',
                                'review brands'
                            ];
                        @endphp --}}
   @php
    $defaultPermissions = [
        // Principal Management Permissions
        'view principals',
        'create principals', 
        'edit principals',
        'delete principals',
        'manage principals', // General management permission
        'share principals',
        
        // User & Role Management
        'manage users',
        'manage roles',
        
        // Brand Management Permissions
        'review brands', // For approving/rejecting brand submissions
        // 'view brands',
        'create brands',
        'edit brands',
        'delete brands',
        
        // Product Management Permissions
        'review products', // For approving/rejecting product submissions
        // 'view products',
        'create products',
        'edit products',
        'delete products',
        
        // System Permissions
        'manage settings',
        'view dashboard',
        'export data',
        'import data',
        
        // Content Management
        'manage content',
        'manage categories',
        'manage notifications'
    ];
@endphp

                        @foreach($defaultPermissions as $permission)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input permission-checkbox" 
                                           name="permissions[]" value="{{ $permission }}"
                                           id="permission_{{ Str::slug($permission) }}">
                                    <label class="form-check-label" for="permission_{{ Str::slug($permission) }}">
                                        {{ $permission }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Selected Permissions
            </button>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        // Select All functionality
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