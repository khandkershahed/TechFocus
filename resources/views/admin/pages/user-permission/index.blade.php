@extends('admin.master')

@section('title', 'User Permissions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>User Permissions Management</h2>
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
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Direct Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->id === auth('admin')->id())
                                        <span class="badge bg-info">You</span>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($user->permissions as $permission)
                                        <span class="badge bg-success">{{ $permission->name }}</span>
                                    @endforeach
                                    @if($user->permissions->count() === 0)
                                        <span class="text-muted">No direct permissions</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <!-- Assign Permissions -->
                                        <a href="{{ route('admin.user-permission.create', $user->id) }}" 
                                           class="btn btn-sm btn-info" title="Assign Permissions">
                                            <i class="fas fa-key"></i> Permissions
                                        </a>
                                        
                                        <!-- View/Remove Permissions -->
                                        <a href="{{ route('admin.user-permission.edit', $user->id) }}" 
                                           class="btn btn-sm btn-warning" title="Manage Permissions">
                                            <i class="fas fa-cog"></i> Manage
                                        </a>
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