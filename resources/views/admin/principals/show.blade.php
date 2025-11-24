@extends('admin.master')

@section('title', 'Principal Details')

@section('content')
<div class="container-fluid">
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

    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Principal Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.principals.index') }}">Principals</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Permission Alert for View Only Users -->
    @if(!auth('admin')->user()->hasRole('SuperAdmin') && !auth('admin')->user()->can('edit principals'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-eye me-2"></i>
            <strong>View Only Access:</strong> You can view principal details but cannot make any changes.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Profile + Info -->
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($principal->photo)
                        <img src="{{ asset('storage/' . $principal->photo) }}" alt="{{ $principal->legal_name }}" class="img-fluid rounded-circle" style="width:120px;height:120px;object-fit:cover;">
                    @else
                        <div class="avatar-title bg-soft-primary text-primary rounded-circle font-size-24" style="width:120px;height:120px;line-height:120px;">
                            {{ strtoupper(substr($principal->legal_name, 0, 1)) }}
                        </div>
                    @endif

                    <h4 class="mt-3">{{ $principal->legal_name }}</h4>
                    <p class="text-muted mb-1">{{ $principal->trading_name ?? '—' }}</p>
                    <p class="text-muted">{{ $principal->entity_type ?? 'N/A' }}</p>

                    <div class="mt-3">
                        <span class="badge bg-{{ $principal->relationship_status == 'Prospect' ? 'warning' : 'success' }}">
                            {{ ucfirst($principal->relationship_status) }}
                        </span>
                        @if($principal->email_verified_at)
                            <span class="badge bg-success">Verified</span>
                        @else
                            <span class="badge bg-danger">Unverified</span>
                        @endif
                    </div>

                    <hr class="my-4">

                    <h5>Contact Information</h5>
                    <div class="text-start">
                        <p><strong>Email:</strong> {{ $principal->email ?? 'N/A' }}</p>
                        <p><strong>Website:</strong> 
                            @if($principal->website_url)
                                <a href="{{ $principal->website_url }}" target="_blank">{{ $principal->website_url }}</a>
                            @else
                                N/A
                            @endif
                        </p>
                        <p><strong>HQ City:</strong> {{ $principal->hq_city ?? 'N/A' }}</p>
                        <p><strong>Country:</strong> {{ $principal->country->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Info -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Principal Information</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Legal Name:</strong> {{ $principal->legal_name }}</p>
                            <p><strong>Company Name:</strong> {{ $principal->company_name ?? 'N/A' }}</p>
                            <p><strong>Trading Name:</strong> {{ $principal->trading_name ?? 'N/A' }}</p>
                            <p><strong>Entity Type:</strong> {{ $principal->entity_type ?? 'N/A' }}</p>
                            <p><strong>Website:</strong> 
                                @if($principal->website_url)
                                    <a href="{{ $principal->website_url }}" target="_blank">{{ $principal->website_url }}</a>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Created At:</strong> {{ $principal->created_at->format('M d, Y h:i A') }}</p>
                            <p><strong>Updated At:</strong> {{ $principal->updated_at->format('M d, Y h:i A') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $principal->status == 'active' ? 'success' : ($principal->status == 'inactive' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($principal->status) }}
                                </span>
                            </p>
                            <p><strong>Last Seen:</strong> 
                                {{ $principal->last_seen ? \Carbon\Carbon::parse($principal->last_seen)->diffForHumans() : 'Never' }}
                            </p>
                            <p><strong>Relationship Status:</strong> {{ ucfirst($principal->relationship_status) }}</p>
                        </div>
                    </div>

                    <!-- Update Status - Only for SuperAdmin and users with edit principals permission -->
                    @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
                        <form action="{{ route('admin.principals.update-status', $principal->id) }}" method="POST" class="d-flex gap-2 mt-3">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select" style="width:auto;">
                                <option value="active" {{ $principal->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $principal->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ $principal->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="disabled" {{ $principal->status == 'disabled' ? 'selected' : '' }}>Disabled</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Contacts Section -->
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Contacts</h4>
                <!-- Add Contact Button - Only for SuperAdmin and users with edit principals permission -->
                @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addContactModal">
                        <i class="fas fa-plus"></i> Add Contact
                    </button>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Job Title</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Preferred Channel</th>
                            <th>Primary?</th>
                            @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($principal->contacts as $index => $contact)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $contact->contact_name }}</td>
                                <td>{{ $contact->job_title ?? '—' }}</td>
                                <td>{{ $contact->email ?? '—' }}</td>
                                <td>{{ $contact->phone_e164 ?? '—' }}</td>
                                <td>{{ $contact->preferred_channel ?? '—' }}</td>
                                <td>
                                    @if($contact->is_primary)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editContactModal{{ $contact->id }}">Edit</button>
                                        <form action="{{ route('admin.principals.contacts.destroy', $contact->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this contact?')">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals') ? '8' : '7' }}" class="text-center">No contacts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Addresses Section -->
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Addresses</h4>
                <!-- Add Address Button - Only for SuperAdmin and users with edit principals permission -->
                @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                        <i class="fas fa-plus"></i> Add Address
                    </button>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Line 1</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Postal</th>
                            <th>Country</th>
                            @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($principal->addresses as $index => $address)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $address->type }}</td>
                                <td>{{ $address->line1 }}</td>
                                <td>{{ $address->city ?? '—' }}</td>
                                <td>{{ $address->state ?? '—' }}</td>
                                <td>{{ $address->postal ?? '—' }}</td>
                                <td>{{ $address->country_name ?? '—' }}</td>
                                @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $address->id }}">Edit</button>
                                        <form action="{{ route('admin.principals.addresses.destroy', ['principal' => $principal->id, 'address' => $address->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this address?')">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals') ? '8' : '7' }}" class="text-center">No addresses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Debug Section (remove after fixing) -->
{{-- @if($principal->brands->count() > 0)
<div class="alert alert-info">
    <h5>Debug Brands Data Structure:</h5>
    <pre>@json($principal->brands->first()->toArray(), JSON_PRETTY_PRINT)</pre>
    
    @if($principal->brands->first()->brand)
    <h6 class="mt-3">Related Brand Data:</h6>
    <pre>@json($principal->brands->first()->brand->toArray(), JSON_PRETTY_PRINT)</pre>
    @endif
</div>
@endif --}}

<!-- Brands Section -->
<div class="card mt-4">
    <div class="card-body">
        <h4 class="card-title mb-3">Brands</h4>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($principal->brands as $index => $brand)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <!-- Try different field names to see which one works -->
                                {{ $brand->title ?? $brand->name ?? $brand->tittle ?? 'N/A' }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $brand->status == 'approved' ? 'success' : ($brand->status == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($brand->status) }}
                                </span>
                            </td>
                            <td>{{ $brand->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No brands found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- Principal Links Section -->
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Shared Links</h4>
                <span class="badge bg-primary">{{ $links->total() }} Total</span>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Labels</th>
                            <th>URLs</th>
                            <th>Types</th>
                            <th>Files</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($links as $index => $link)
                            <tr>
                                <td>{{ $links->firstItem() + $index }}</td>
                                <td>
                                    @if(is_array($link->label))
                                        @foreach($link->label as $label)
                                            <span class="badge bg-info mb-1">{{ $label }}</span><br>
                                        @endforeach
                                    @else
                                        <span class="badge bg-info">{{ $link->label }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if(is_array($link->url))
                                        @foreach($link->url as $url)
                                            <a href="{{ $url }}" target="_blank" class="d-block text-truncate" style="max-width: 200px;" title="{{ $url }}">
                                                {{ Str::limit($url, 30) }}
                                            </a>
                                        @endforeach
                                    @else
                                        <a href="{{ $link->url }}" target="_blank" class="text-truncate d-block" style="max-width: 200px;" title="{{ $link->url }}">
                                            {{ Str::limit($link->url, 30) }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if(is_array($link->type))
                                        @foreach($link->type as $type)
                                            <span class="badge bg-secondary mb-1">{{ $type }}</span><br>
                                        @endforeach
                                    @else
                                        <span class="badge bg-secondary">{{ $link->type ?? 'N/A' }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if(is_array($link->file) && count($link->file) > 0)
                                        @php
                                            $fileCount = 0;
                                            foreach($link->file as $fileArray) {
                                                $fileCount += count($fileArray);
                                            }
                                        @endphp
                                        <span class="badge bg-success">{{ $fileCount }} files</span>
                                        <div class="mt-1">
                                            @foreach($link->file as $rowIndex => $fileArray)
                                                @foreach($fileArray as $filePath)
                                                    @if($filePath && Storage::disk('public')->exists($filePath))
                                                        <a href="{{ asset('storage/' . $filePath) }}" 
                                                           target="_blank" 
                                                           class="d-block text-truncate small text-decoration-none" 
                                                           style="max-width: 150px;"
                                                           title="{{ basename($filePath) }}">
                                                            📎 {{ Str::limit(basename($filePath), 20) }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted small" title="File not found">
                                                            ❌ {{ Str::limit(basename($filePath), 20) }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">No files</span>
                                    @endif
                                </td>
                                <td>{{ $link->created_at->format('M d, Y h:i A') }}</td>
                                <td>{{ $link->updated_at->format('M d, Y h:i A') }}</td>
                                @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- View Link -->
                                            <button type="button" 
                                                    class="btn btn-info" 
                                                    title="View Details"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#linkModal{{ $link->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            <!-- Delete Link -->
                                            <form action="{{ route('admin.principals.links.destroy', [$principal->id, $link->id]) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Delete this link entry?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Link Details Modal -->
                                        <div class="modal fade" id="linkModal{{ $link->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Link Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6>Labels:</h6>
                                                                @if(is_array($link->label))
                                                                    @foreach($link->label as $label)
                                                                        <span class="badge bg-info mb-1">{{ $label }}</span>
                                                                    @endforeach
                                                                @else
                                                                    <span class="badge bg-info">{{ $link->label }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>Types:</h6>
                                                                @if(is_array($link->type))
                                                                    @foreach($link->type as $type)
                                                                        <span class="badge bg-secondary mb-1">{{ $type }}</span>
                                                                    @endforeach
                                                                @else
                                                                    <span class="badge bg-secondary">{{ $link->type ?? 'N/A' }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mt-3">
                                                            <h6>URLs:</h6>
                                                            @if(is_array($link->url))
                                                                @foreach($link->url as $url)
                                                                    <a href="{{ $url }}" target="_blank" class="d-block mb-1">
                                                                        {{ $url }}
                                                                    </a>
                                                                @endforeach
                                                            @else
                                                                <a href="{{ $link->url }}" target="_blank" class="d-block">
                                                                    {{ $link->url }}
                                                                </a>
                                                            @endif
                                                        </div>

                                                        @if(is_array($link->file) && count($link->file) > 0)
                                                            <div class="mt-3">
                                                                <h6>Files:</h6>
                                                                @foreach($link->file as $rowIndex => $fileArray)
                                                                    @foreach($fileArray as $filePath)
                                                                        @if($filePath && Storage::disk('public')->exists($filePath))
                                                                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                                                                                <div>
                                                                                    <a href="{{ asset('storage/' . $filePath) }}" 
                                                                                       target="_blank" 
                                                                                       class="text-decoration-none">
                                                                                        📎 {{ basename($filePath) }}
                                                                                    </a>
                                                                                </div>
                                                                                <small class="text-muted">
                                                                                    {{ Storage::disk('public')->size($filePath) }} bytes
                                                                                </small>
                                                                            </div>
                                                                        @else
                                                                            <div class="text-muted mb-2">
                                                                                ❌ File not found: {{ basename($filePath) }}
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals') ? '8' : '7' }}" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-link fa-2x mb-2 d-block"></i>
                                        No links shared yet.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($links->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing {{ $links->firstItem() }} to {{ $links->lastItem() }} of {{ $links->total() }} entries
                    </div>
                    {{ $links->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- <!-- Products Section -->
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title mb-3">Products</h4>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($principal->products as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->brand->tittle ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-{{ $product->status == 'approved' ? 'success' : ($product->status == 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td>{{ $product->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
    <!-- Debug Section (remove after fixing) -->
{{-- @if($principal->products->count() > 0)
<div class="alert alert-info">
    <h5>Debug Product Brand Data:</h5>
    @if($principal->products->first()->brand)
    <pre>@json($principal->products->first()->brand->toArray(), JSON_PRETTY_PRINT)</pre>
    @else
    <p>No brand relationship found for this product.</p>
    @endif
</div>
@endif --}}


<!-- Share Links Section - Only for users with share principals permission -->
@if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('share principals'))
<div class="card mt-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title mb-0">Share Links</h4>
            <div>
                <a href="{{ route('admin.principals.share-links.index', $principal->id) }}" 
                   class="btn btn-sm btn-info me-2">
                    <i class="fas fa-list"></i> View All Links
                </a>
                <a href="{{ route('admin.principals.share-links.create', $principal->id) }}" 
                   class="btn btn-sm btn-success">
                    <i class="fas fa-share-alt"></i> Create Share Link
                </a>
            </div>
        </div>

        <!-- Display recent share links -->
        @php
            $recentShareLinks = $principal->shareLinks()->latest()->limit(3)->get();
        @endphp

        @if($recentShareLinks->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Token</th>
                            <th>Expires</th>
                            <th>Views</th>
                                 
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentShareLinks as $link)
                            <tr>
                                <td>
                                    <code class="text-truncate d-block" style="max-width: 150px;" 
                                          title="{{ $link->token }}">
                                        {{ Str::limit($link->token, 20) }}
                                    </code>
                                </td>
                                <td>{{ $link->expires_at->format('M d, Y h:i A') }}</td>
                                <td>{{ $link->view_count }} / {{ $link->max_views ?? '∞' }}</td>
                                {{-- <td>
                                    @if($link->isValid())
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Expired</span>
                                    @endif
                                </td> --}}
                                {{-- <td>
                                    <!-- FIXED: Updated route name -->
                                    <a href="{{ route('guest.share-links.show', $link->token) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-external-link-alt"></i> Open
                                    </a>
                                    <form action="{{ route('admin.principals.share-links.destroy', [$principal->id, $link->id]) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this share link?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td> --}}
                                <!-- In the share links section actions column -->
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <!-- Open Link -->
                                                    <a href="{{ route('guest.share-links.show', $link->token) }}" 
                                                    target="_blank" 
                                                    class="btn btn-primary" title="Open Link">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                    
                                                    <!-- Copy Link -->
                                                    <button class="btn btn-info copy-link-btn" 
                                                            title="Copy Share Link"
                                                            data-principal-id="{{ $principal->id }}"
                                                            data-share-link-id="{{ $link->id }}">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                    
                                                    <!-- Delete Link -->
                                                    <form action="{{ route('admin.principals.share-links.destroy', [$principal->id, $link->id]) }}" 
                                                        method="POST" 
                                                        class="d-inline"
                                                        onsubmit="return confirm('Delete this share link?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Delete">
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
        @else
            <div class="text-center py-4">
                <div class="text-muted">
                    <i class="fas fa-share-alt fa-2x mb-2 d-block"></i>
                    No share links created yet.
                </div>
                <a href="{{ route('admin.principals.share-links.create', $principal->id) }}" 
                   class="btn btn-primary mt-2">
                    Create Your First Share Link
                </a>
            </div>
        @endif
    </div>
</div>
@endif
<!-- Products Section -->
<div class="card mt-4">
    <div class="card-body">
        <h4 class="card-title mb-3">Products</h4>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($principal->products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if($product->brand)
                                    {{ $product->brand->name ?? $product->brand->title ?? $product->brand->brand_name ?? 'N/A' }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                 <span class="badge bg-{{ $brand->status == 'approved' ? 'success' : ($brand->status == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($brand->status) }}
                                </span>
                            </td>
                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- Add Contact Modal - Only show if user has permission -->
    @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
    <div class="modal fade" id="addContactModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.principals.contacts.store', $principal->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Contact Name *</label>
                            <input type="text" class="form-control" name="contact_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Job Title</label>
                            <input type="text" class="form-control" name="job_title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone_e164">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Preferred Channel</label>
                            <select class="form-select" name="preferred_channel">
                                <option value="">Select Channel</option>
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="whatsapp">WhatsApp</option>
                            </select>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="is_primary" value="1">
                            <label class="form-check-label">Primary Contact</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Contact</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Edit Contact Modals - Only show if user has permission -->
    @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
        @foreach($principal->contacts as $contact)
        <div class="modal fade" id="editContactModal{{ $contact->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.principals.contacts.update', $contact->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Contact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Contact Name *</label>
                                <input type="text" class="form-control" name="contact_name" value="{{ $contact->contact_name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Job Title</label>
                                <input type="text" class="form-control" name="job_title" value="{{ $contact->job_title }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $contact->email }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="phone_e164" value="{{ $contact->phone_e164 }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Preferred Channel</label>
                                <select class="form-select" name="preferred_channel">
                                    <option value="">Select Channel</option>
                                    <option value="email" {{ $contact->preferred_channel == 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="phone" {{ $contact->preferred_channel == 'phone' ? 'selected' : '' }}>Phone</option>
                                    <option value="whatsapp" {{ $contact->preferred_channel == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                </select>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" name="is_primary" value="1" {{ $contact->is_primary ? 'checked' : '' }}>
                                <label class="form-check-label">Primary Contact</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Contact</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endif

    <!-- Add Address Modal - Only show if user has permission -->
    @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.principals.addresses.store', $principal->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Address Type *</label>
                            <select class="form-select" name="type" required>
                                <option value="">Select Type</option>
                                <option value="HQ">Headquarters</option>
                                <option value="Branch">Branch</option>
                                <option value="Warehouse">Warehouse</option>
                                <option value="Billing">Billing</option>
                                <option value="Shipping">Shipping</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address Line 1 *</label>
                            <input type="text" class="form-control" name="line1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" name="line2">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="state">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" class="form-control" name="postal">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select class="form-select" name="country_id">
                                <option value="">Select Country</option>
                                @foreach(\App\Models\Country::all() as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Edit Address Modals - Only show if user has permission -->
    @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
        @foreach($principal->addresses as $address)
        <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.principals.addresses.update', ['principal' => $principal->id, 'address' => $address->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Address Type *</label>
                                <select class="form-select" name="type" required>
                                    <option value="HQ" {{ $address->type == 'HQ' ? 'selected' : '' }}>Headquarters</option>
                                    <option value="Branch" {{ $address->type == 'Branch' ? 'selected' : '' }}>Branch</option>
                                    <option value="Warehouse" {{ $address->type == 'Warehouse' ? 'selected' : '' }}>Warehouse</option>
                                    <option value="Billing" {{ $address->type == 'Billing' ? 'selected' : '' }}>Billing</option>
                                    <option value="Shipping" {{ $address->type == 'Shipping' ? 'selected' : '' }}>Shipping</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address Line 1 *</label>
                                <input type="text" class="form-control" name="line1" value="{{ $address->line1 }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address Line 2</label>
                                <input type="text" class="form-control" name="line2" value="{{ $address->line2 }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city" value="{{ $address->city }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">State</label>
                                <input type="text" class="form-control" name="state" value="{{ $address->state }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" class="form-control" name="postal" value="{{ $address->postal }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Country</label>
                                <select class="form-select" name="country_id">
                                    <option value="">Select Country</option>
                                    @foreach(\App\Models\Country::all() as $country)
                                        <option value="{{ $country->id }}" {{ $address->country_id == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Address</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copy link functionality
    document.querySelectorAll('.copy-link-btn').forEach(button => {
        button.addEventListener('click', function() {
            const principalId = this.getAttribute('data-principal-id');
            const shareLinkId = this.getAttribute('data-share-link-id');
            
            // Show loading state
            const originalHtml = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            this.disabled = true;
            
            // Make API call to get the shareable URL
            fetch(`/admin/principals/${principalId}/share-links/${shareLinkId}/copy`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Copy to clipboard
                        navigator.clipboard.writeText(data.url).then(() => {
                            // Show success state
                            this.innerHTML = '<i class="fas fa-check"></i>';
                            this.classList.remove('btn-info');
                            this.classList.add('btn-success');
                            
                            // Optional: Show toast notification
                            showToast(data.message, 'success');
                            
                            // Reset button after 2 seconds
                            setTimeout(() => {
                                this.innerHTML = originalHtml;
                                this.classList.remove('btn-success');
                                this.classList.add('btn-info');
                                this.disabled = false;
                            }, 2000);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.innerHTML = originalHtml;
                    this.disabled = false;
                    showToast('Failed to copy link', 'error');
                });
        });
    });
    
    // Simple toast notification function
    function showToast(message, type = 'info') {
        // You can use a proper toast library or create a simple one
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px;';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
});
</script>
@endpush