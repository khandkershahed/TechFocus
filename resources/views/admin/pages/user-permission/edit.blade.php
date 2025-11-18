@extends('admin.master')

@section('title', 'Manage User Permissions')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Permissions for: {{ $user->name }}</h2>
        <div>
            <a href="{{ route('admin.user-permission.create', $user->id) }}" class="btn btn-info">
                <i class="fas fa-plus"></i> Add More Permissions
            </a>
            <a href="{{ route('admin.user-permission.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Current Direct Permissions</h5>
        </div>
        <div class="card-body">
            @if($permissions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Permission Name</th>
                                <th>Guard</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->guard_name }}</td>
                                    <td>
                                        <form action="{{ route('admin.user-permission.destroy', ['userId' => $user->id, 'permissionId' => $permission->id]) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Are you sure you want to remove this permission?')">
                                                <i class="fas fa-trash"></i> Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <p class="mb-0">This user has no direct permissions assigned.</p>
                </div>
                <a href="{{ route('admin.user-permission.create', $user->id) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Assign Permissions
                </a>
            @endif
        </div>
    </div>
</div>
@endsection