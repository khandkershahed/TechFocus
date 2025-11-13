@extends('admin.master')

@section('title', 'Roles List')

@section('content')
    <h1>Roles</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create Role Link -->
    <a href="{{ route('admin.role.create') }}" class="btn btn-primary mb-3">Create New Role</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td class="d-flex gap-2">
                        <!-- Edit Role -->
                        <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <!-- View Permissions -->
                        <a href="{{ route('admin.role-permissions.show', $role->id) }}" class="btn btn-sm btn-info">Permissions</a>

                        <!-- Delete Role via Anchor Link with JS Confirm -->
                        <a href="{{ route('admin.role.destroy', $role->id) }}"
                           class="btn btn-sm btn-danger"
                           onclick="event.preventDefault(); 
                                    if(confirm('Are you sure you want to delete this role?')) {
                                        document.getElementById('delete-role-{{ $role->id }}').submit();
                                    }">
                            Delete
                        </a>

                        <!-- Hidden form for delete -->
                        <form id="delete-role-{{ $role->id }}" action="{{ route('admin.role.destroy', $role->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No roles found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
