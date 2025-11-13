@extends('admin.master')

@section('title', 'Edit Role')

@section('content')
    <h1>Edit Role</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="role_name" class="form-label">Role Name:</label>
            <input type="text" id="role_name" name="role_name" class="form-control" value="{{ $role->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Permissions:</label>
            <div class="mb-2">
                <input type="checkbox" id="selectAll"> <strong>Select All Permissions</strong>
            </div>
            @foreach ($permissions as $permission)
                <div class="form-check">
                    <input type="checkbox" class="form-check-input permissionCheckbox" 
                           id="permission_{{ $permission->id }}" 
                           name="permissions[]" value="{{ $permission->id }}"
                           {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                        {{ $permission->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success">Update Role</button>
    </form>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#selectAll').click(function() {
            $('.permissionCheckbox').prop('checked', this.checked);
        });

        $('.permissionCheckbox').change(function() {
            if ($('.permissionCheckbox:checked').length == $('.permissionCheckbox').length) {
                $('#selectAll').prop('checked', true);
            } else {
                $('#selectAll').prop('checked', false);
            }
        });

        // Initialize Select All checkbox on page load
        if ($('.permissionCheckbox:checked').length == $('.permissionCheckbox').length) {
            $('#selectAll').prop('checked', true);
        }
    });
</script>
@endpush
