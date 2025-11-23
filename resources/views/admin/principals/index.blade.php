@extends('admin.master')

@section('title', 'Principals List - Admin Panel')

@section('content')
<div class="container-fluid">
    <!-- Check if user has permission to view principals -->
    @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('view principals') || auth('admin')->user()->can('manage principals'))
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between mb-8">
            <div>
                <h1 class="fw-bolder text-dark mb-2">Principals Management</h1>
                <p class="text-muted fw-semibold fs-6">
                    Manage all principals in the system - view details, update status, and monitor activity.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light-primary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back to Dashboard
                </a>
                @if(auth('admin')->user()->hasRole('SuperAdmin'))
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-success">
                        <i class="fa-solid fa-key me-2"></i>Manage Permissions
                    </a>
                @endif
            </div>
        </div>

        <!-- Permission Info Alert for SuperAdmin -->
        @if(auth('admin')->user()->hasRole('SuperAdmin'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-info-circle me-2"></i>
                <strong>SuperAdmin Access:</strong> You can grant principal management permissions to other admins from the 
                <a href="{{ route('admin.permissions.index') }}" class="alert-link">Permissions Management</a> page.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Permission Restrictions Alert for Different User Types -->
        @if(!auth('admin')->user()->hasRole('SuperAdmin'))
            @if(auth('admin')->user()->can('view principals') && !auth('admin')->user()->can('manage principals'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-eye me-2"></i>
                    <strong>View Only Access:</strong> You can only view principals. You cannot edit, delete, or manage their status.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif(auth('admin')->user()->can('manage principals'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-exclamation-triangle me-2"></i>
                    <strong>Principal Manager Access:</strong> You can view and manage principals but only SuperAdmin can delete them.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endif

        <!-- Statistics Cards -->
        <div class="row mb-6">
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

        <!-- Principals List Card -->
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Principals List</h2>
                    <div class="text-muted">
                        <i class="fa-solid fa-user-shield me-1"></i>
                        Access: 
                        @if(auth('admin')->user()->hasRole('SuperAdmin'))
                            SuperAdmin
                        @elseif(auth('admin')->user()->can('manage principals'))
                            Principal Manager
                        @else
                            View Only
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <!-- Success & Error Alerts -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Search and Filters -->
                <form method="GET" action="{{ route('admin.principals.index') }}" class="mb-6">
                    <div class="row g-4 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Search Principals</label>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" 
                                   placeholder="Search by name, email, company, website, links...">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Entity Type</label>
                            <select name="entity_type" class="form-select">
                                <option value="">All Types</option>
                                @php
                                    $entityTypes = ['Manufacturer', 'Distributor', 'Supplier', 'Other'];
                                @endphp
                                @foreach($entityTypes as $type)
                                    <option value="{{ $type }}" {{ request('entity_type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Country</label>
                            <select name="country" class="form-select">
                                <option value="">All Countries</option>
                                @foreach(\App\Models\Country::all() as $country)
                                    <option value="{{ $country->id }}" {{ request('country') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Sort By</label>
                            <select name="sort" class="form-select">
                                <option value="recently_updated" {{ request('sort') == 'recently_updated' ? 'selected' : '' }}>Recently Updated</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="country" {{ request('sort') == 'country' ? 'selected' : '' }}>Country</option>
                                <option value="website" {{ request('sort') == 'website' ? 'selected' : '' }}>Website</option>
                                <option value="last_activity" {{ request('sort') == 'last_activity' ? 'selected' : '' }}>Last Activity</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-primary me-2" type="submit">
                                <i class="fas fa-search me-2"></i> Search
                            </button>
                            <a href="{{ route('admin.principals.index') }}" class="btn btn-light">Reset</a>
                        </div>
                    </div>

                    <!-- Advanced Filters -->
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="form-label">Relationship Status</label>
                            <select name="relationship_status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('relationship_status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('relationship_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="pending" {{ request('relationship_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>

                        {{-- <div class="col-md-3">
                            <label class="form-label">Brand</label>
                            <select name="brand" class="form-select">
                                <option value="">All Brands</option>
                                @foreach(\App\Models\Brand::all() as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                            <div class="col-md-3">
                                <label class="form-label">Brand</label>
                                {{-- @php
                                    $brands = \App\Models\Admin\Brand::get();
                                    @endphp --}}
                                    {{-- @dd($brands) --}}
                                <select id="brand" name="brand" class="form-select" data-control="select2"> 
                                    <option value="">All Brands</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        {{-- <div class="col-md-3">
                            <label class="form-label">Authorization Type</label>
                            <select name="authorization_type" class="form-select">
                                <option value="">All Types</option>
                                <option value="direct" {{ request('authorization_type') == 'direct' ? 'selected' : '' }}>Direct</option>
                                <option value="distributor" {{ request('authorization_type') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                                <option value="reseller" {{ request('authorization_type') == 'reseller' ? 'selected' : '' }}>Reseller</option>
                            </select>
                        </div> --}}

                        {{-- <div class="col-md-3">
                            <label class="form-label">NDA Status</label>
                            <select name="has_ndas" class="form-select">
                                <option value="">All</option>
                                <option value="1" {{ request('has_ndas') == '1' ? 'selected' : '' }}>Has NDA</option>
                                <option value="0" {{ request('has_ndas') == '0' ? 'selected' : '' }}>No NDA</option>
                            </select>
                        </div>
                    </div> --}}
                </form>

                @if ($principals->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-row-bordered align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bold text-muted bg-light">
                                    <th>Principal</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Website</th>
                                    <th>Status</th>
                                    <th>Email Verified</th>
                                    <th>Last Seen</th>
                                    <th>Registration Date</th>
                                    @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('manage principals'))
                                        <th class="text-end">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($principals as $principal)
                                <tr>
                                    <!-- Principal Info -->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-50px me-3">
                                                @if($principal->photo)
                                                    <img src="{{ asset('storage/' . $principal->photo) }}" 
                                                         alt="{{ $principal->legal_name}}" class="rounded-circle">
                                                @else
                                                    <div class="symbol symbol-50px bg-light-primary rounded-circle">
                                                        <span class="symbol-label text-primary fw-bold fs-6">
                                                            {{ strtoupper(substr($principal->legal_name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark mb-1 d-block">{{ $principal->legal_name }}</span>
                                                <span class="text-muted fs-7">ID: {{ $principal->id ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td>
                                        <span class="text-dark fw-semibold d-block">{{ $principal->email }}</span>
                                    </td>

                                    <!-- Company -->
                                    <td>
                                        <span class="text-muted">{{ $principal->name ?? 'N/A' }}</span>
                                    </td>

                                    <!-- Website -->
                                    <td>
                                        @if($principal->website_url)
                                            <a href="{{ $principal->website_url }}" target="_blank" class="text-primary text-decoration-underline" 
                                               title="Visit website">
                                                {{ Str::limit($principal->website_url, 30) }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <span class="badge badge-light-{{ $principal->status == 'active' ? 'success' : ($principal->status == 'inactive' ? 'warning' : 'danger') }} fs-7">
                                            {{ ucfirst($principal->status) }}
                                        </span>
                                    </td>

                                    <!-- Email Verified -->
                                    <td>
                                        @if($principal->email_verified_at)
                                            <span class="badge badge-light-success fs-7">Verified</span>
                                        @else
                                            <span class="badge badge-light-warning fs-7">Pending</span>
                                        @endif
                                    </td>

                                    <!-- Last Seen -->
                                    <td>
                                        @if($principal->last_seen && \Carbon\Carbon::parse($principal->last_seen)->diffInMinutes() < 5)
                                            <span class="badge badge-light-success fs-7">
                                                <i class="fas fa-circle me-1"></i> Online
                                            </span>
                                        @elseif($principal->last_seen)
                                            <span class="text-muted fs-7" title="{{ $principal->last_seen }}">
                                                {{ \Carbon\Carbon::parse($principal->last_seen)->diffForHumans() }}
                                            </span>
                                        @else
                                            <span class="text-muted fs-7">Never</span>
                                        @endif
                                    </td>

                                    <!-- Registration Date -->
                                    <td>
                                        <span class="text-muted fs-7">{{ $principal->created_at->format('M d, Y') }}</span>
                                    </td>

                                    <!-- Actions Column - Only show for users with management permissions -->
                                    @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('manage principals'))
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <!-- View Button -->
                                                <a href="{{ route('admin.principals.show', $principal->id) }}" 
                                                   class="btn btn-sm btn-icon btn-light-primary" 
                                                   title="View Principal Details">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                <!-- Status Management Dropdown (Available to both SuperAdmin and Principal Managers) -->
                                                @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('manage principals'))
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-light-primary dropdown-toggle" 
                                                                type="button" 
                                                                data-bs-toggle="dropdown"
                                                                title="Manage Status">
                                                            <i class="fa-solid fa-sliders"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <form action="{{ route('admin.principals.update-status', $principal->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="active">
                                                                    <button type="submit" class="dropdown-item text-success">
                                                                        <i class="fa-solid fa-check me-2"></i>Mark Active
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('admin.principals.update-status', $principal->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="inactive">
                                                                    <button type="submit" class="dropdown-item text-warning">
                                                                        <i class="fa-solid fa-pause me-2"></i>Mark Inactive
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('admin.principals.update-status', $principal->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="suspended">
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fa-solid fa-ban me-2"></i>Suspend
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif

                                                <!-- Delete Button (Only for SuperAdmin) -->
                                                @if(auth('admin')->user()->hasRole('SuperAdmin'))
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $principal->id }}"
                                                            title="Delete Principal">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                @else
                                                    <!-- Disabled Delete Button for Principal Managers -->
                                                    <button type="button" class="btn btn-sm btn-danger" disabled
                                                            title="Only SuperAdmin can delete principals">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>

                                <!-- Delete Modal (Only for SuperAdmin) -->
                                @if(auth('admin')->user()->hasRole('SuperAdmin'))
                                    <div class="modal fade" id="deleteModal{{ $principal->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.principals.destroy', $principal->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete Principal</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>You are about to delete principal <strong>{{ $principal->name }}</strong>.</p>
                                                        <p class="text-danger"><strong>Warning:</strong> This action cannot be undone. All associated data will be permanently removed.</p>
                                                        <div class="form-group mt-3">
                                                            <label class="form-label">Confirm Principal Name *</label>
                                                            <input type="text" name="confirm_name" class="form-control" 
                                                                   placeholder="Type '{{ $principal->name }}' to confirm" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete Principal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($principals->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-6">
                            <div class="text-muted">
                                Showing {{ $principals->firstItem() }} to {{ $principals->lastItem() }} of {{ $principals->total() }} entries
                            </div>
                            <div>
                                {{ $principals->links() }}
                            </div>
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="text-center py-10">
                        <i class="fa-solid fa-users text-primary mb-4" style="font-size: 4rem;"></i>
                        <h3 class="text-dark mb-4">No Principals Found</h3>
                        <p class="text-muted fs-6 mb-6">No principals match your search criteria.</p>
                        <a href="{{ route('admin.principals.index') }}" class="btn btn-primary">
                            <i class="fa-solid fa-refresh me-2"></i>Reset Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Access Denied Message -->
        <div class="alert alert-danger text-center">
            <h4><i class="fa-solid fa-ban"></i> Access Denied</h4>
            <p class="mb-0">You do not have permission to access the principals management system.</p>
            <p class="mb-0">Only SuperAdmin and users with principal view permissions can access this page.</p>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mt-3">
                <i class="fa-solid fa-tachometer-alt"></i> Go to Dashboard
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Focus on confirmation input when delete modal opens
        document.querySelectorAll('[id^="deleteModal"]').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function () {
                const input = this.querySelector('input[name="confirm_name"]');
                if (input) input.focus();
            });
        });

        // Confirm deletion with principal name
        document.querySelectorAll('form[action*="destroy"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const principalName = this.closest('.modal-content').querySelector('strong').textContent;
                const confirmInput = this.querySelector('input[name="confirm_name"]');
                
                if (confirmInput.value !== principalName) {
                    e.preventDefault();
                    alert('Please type the principal name exactly as shown to confirm deletion.');
                    confirmInput.focus();
                }
            });
        });
    });
</script>
@endpush