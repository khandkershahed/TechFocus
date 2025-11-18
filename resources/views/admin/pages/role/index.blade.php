@extends('admin.master')

@section('title', 'Manage Roles')

@section('content')
<div class="container-fluid">
    <!-- Check if user is SuperAdmin -->
    @if(auth('admin')->user()->hasRole('SuperAdmin'))
        <!-- Dashboard Card -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>User Management</h4>
                            <p>Manage admin users and roles</p>
                        </div>
                        <div>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm mt-2">
                        Manage Users <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Role Management</h2>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Role
            </a>
        </div>

        <div class="mb-4">
            <a href="{{ route('admin.user-permission.index') }}" class="btn btn-info">
                <i class="fas fa-key"></i> Manage User Permissions
            </a>
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Add New Permission
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
                                            <a href="{{ route('admin.roles.edit', $role->id) }}" 
                                               class="btn btn-sm btn-warning" title="Edit Role">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <!-- Delete Role (hide for SuperAdmin) -->
                                            @if($role->name != 'SuperAdmin')
                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" 
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
    @else
        <!-- Access Denied Message for non-SuperAdmin users -->
        <div class="alert alert-danger text-center">
            <h4><i class="fas fa-ban"></i> Access Denied</h4>
            <p class="mb-0">You do not have permission to access the role management system.</p>
            <p class="mb-0">Only SuperAdmin users can manage roles and permissions.</p>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mt-3">
                <i class="fas fa-tachometer-alt"></i> Go to Dashboard
            </a>
        </div>
    @endif
</div>
@endsection