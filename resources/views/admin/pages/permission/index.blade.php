@extends('admin.master')

@section('title', 'Permissions Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Permissions Management</h2>
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add New Permission
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
                            <th>Permission Name</th>
                            <th>Guard</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td>
                                    <strong>{{ $permission->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $permission->guard_name }}</span>
                                </td>
                                <td>{{ $permission->created_at ? $permission->created_at->format('M d, Y') : 'N/A' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <!-- Edit Permission -->
                                        <a href="{{ route('admin.permissions.edit', $permission->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit Permission">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Delete Permission -->
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this permission?')"
                                                    title="Delete Permission">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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