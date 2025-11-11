@extends('admin.master')

@section('title', 'Principals List')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Principals Management</h4>
                
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Principals</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Total Principals</p>
                            <h4 class="mb-2">{{ $principals->count() }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-users font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Active Principals</p>
                            <h4 class="mb-2">{{ $principals->where('status', 'active')->count() }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-success rounded-3">
                                <i class="fas fa-user-check font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Verified Email</p>
                            <h4 class="mb-2">{{ $principals->whereNotNull('email_verified_at')->count() }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-info rounded-3">
                                <i class="fas fa-envelope font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Currently Online</p>
                            <h4 class="mb-2">{{ $principals->where('last_seen', '>=', \Carbon\Carbon::now()->subMinutes(5))->count() }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-warning rounded-3">
                                <i class="fas fa-circle font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Principals List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title">Principals List</h4>
                        
                        <div class="d-flex gap-2">
                            <input type="text" id="searchPrincipals" class="form-control" placeholder="Search principals..." style="width: 250px;">
                            <button class="btn btn-primary" onclick="refreshTable()">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-centered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Principal</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Status</th>
                                    <th>Email Verified</th>
                                    <th>Last Seen</th>
                                    <th>Registration Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($principals as $principal)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                @if($principal->photo)
                                                    <img src="{{ asset('storage/' . $principal->photo) }}" alt="{{ $principal->name }}" class="img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="avatar-title bg-soft-primary text-primary rounded-circle font-size-16">
                                                        {{ substr($principal->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h5 class="font-size-14 mb-1">
                                                    <a href="{{ route('admin.principals.show', $principal->id) }}" class="text-dark">
                                                        {{ $principal->name }}
                                                    </a>
                                                </h5>
                                                <p class="text-muted mb-0">ID: {{ $principal->code ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $principal->email }}</td>
                                    <td>{{ $principal->company_name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $principal->status == 'active' ? 'success' : ($principal->status == 'inactive' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($principal->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($principal->email_verified_at)
                                            <span class="badge bg-success">Verified</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($principal->last_seen && \Carbon\Carbon::parse($principal->last_seen)->diffInMinutes() < 5)
                                            <span class="badge bg-success">
                                                <i class="fas fa-circle me-1"></i> Online
                                            </span>
                                        @elseif($principal->last_seen)
                                            <span class="text-muted" title="{{ $principal->last_seen }}">
                                                {{ \Carbon\Carbon::parse($principal->last_seen)->diffForHumans() }}
                                            </span>
                                        @else
                                            <span class="text-muted">Never</span>
                                        @endif
                                    </td>
                                    <td>{{ $principal->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.principals.show', $principal->id) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form action="{{ route('admin.principals.update-status', $principal->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="active">
                                                            <button type="submit" class="dropdown-item">Mark Active</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.principals.update-status', $principal->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="inactive">
                                                            <button type="submit" class="dropdown-item">Mark Inactive</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.principals.update-status', $principal->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="suspended">
                                                            <button type="submit" class="dropdown-item text-warning">Suspend</button>
                                                        </form>
                                                    </li>

                                                    <li>
                                                        <form action="{{ route('admin.principals.destroy', $principal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this principal?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                        </form>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-users fa-2x mb-2"></i>
                                            <p>No principals found.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function refreshTable() {
    location.reload();
}

// Simple search functionality
document.getElementById('searchPrincipals').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endpush