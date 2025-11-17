@extends('admin.master')

@section('title', isset($role) ? 'Edit Role' : 'Create Role')

@section('content')
<div class="container-fluid">
    <h2>{{ isset($role) ? 'Edit Role' : 'Create New Role' }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($role) ? route('admin.role.update', $role->id) : route('admin.role.store') }}" method="POST">
        @csrf
        @if(isset($role)) @method('PUT') @endif

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Role Name *</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="{{ old('name', $role->name ?? '') }}" required>
                    <div class="form-text">Use descriptive names like "Content Manager", "Support Agent", etc.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Permissions</label>
                    <div class="border p-3 rounded">
                        <div class="mb-2">
                            <input type="checkbox" id="selectAll">
                            <label for="selectAll" class="form-label"><strong>Select All Permissions</strong></label>
                        </div>
                        
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input permission-checkbox" 
                                               name="permissions[]" value="{{ $permission->id }}"
                                               id="permission_{{ $permission->id }}"
                                               {{ isset($role) && $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                {{ isset($role) ? 'Update Role' : 'Create Role' }}
            </button>
            <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        
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