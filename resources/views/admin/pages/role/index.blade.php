@extends('admin.master')

@section('title', 'Manage Roles')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Role Management</h2>
        <a href="{{ route('admin.role.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Role
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Role Name</th>
                            <th>Guard</th>
                            <th>Permissions Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>
                                    <strong>{{ $role->name }}</strong>
                                    @if($role->name == 'SuperAdmin')
                                        <span class="badge bg-danger">System Role</span>
                                    @endif
                                </td>
                                <td>{{ $role->guard_name }}</td>
                                <td>{{ $role->permissions->count() }}</td>
                                <td>
                                    <div class="btn-group">
                                        <!-- Edit Permissions -->
                                        <a href="{{ route('admin.role-permissions.show', $role->id) }}" 
                                           class="btn btn-sm btn-info" title="Manage Permissions">
                                            <i class="fas fa-key"></i>
                                        </a>
                                        
                                        <!-- Edit Role -->
                                        <a href="{{ route('admin.role.edit', $role->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit Role">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Delete Role (hide for SuperAdmin) -->
                                        @if($role->name != 'SuperAdmin')
                                            <form action="{{ route('admin.role.destroy', $role->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Are you sure? This will remove all permissions from this role.')"
                                                        title="Delete Role">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection