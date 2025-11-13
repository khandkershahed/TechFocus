@extends('admin.master')

@section('title', 'Manage Role Permissions')

@section('content')
<div class="container">
    <h2 class="mb-4">Manage Permissions for Role: <strong>{{ $role->name }}</strong></h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form to Assign/Update Permissions -->
    <form action="{{ route('admin.role-permissions.assign', $role->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label><strong>Assign Permissions:</strong></label>
            <div class="d-flex flex-wrap gap-2">
                @foreach($permissions as $permission)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]"
                               value="{{ $permission->id }}"
                               id="permission_{{ $permission->id }}"
                               {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Permissions</button>
    </form>

    <!-- Optional: List Current Permissions with Remove Button -->
    <h3 class="mt-5">Current Permissions</h3>
    @if($role->permissions->count())
        <ul class="list-group">
            @foreach($role->permissions as $permission)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $permission->name }}
                    <form action="{{ route('admin.role-permissions.remove', ['role' => $role->id, 'permission' => $permission->id]) }}"
                          method="POST" onsubmit="return confirm('Are you sure you want to remove this permission?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>No permissions assigned yet.</p>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Optional: Select all / Deselect all functionality
    // You can implement this if needed
</script>
@endpush0
 