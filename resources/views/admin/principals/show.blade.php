@extends('admin.master')

@section('title', 'Principal Details')

@section('content')
<div class="container-fluid">
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
                        <p><strong>Website:</strong> <a href="{{ $principal->website_url }}" target="_blank">{{ $principal->website_url ?? 'N/A' }}</a></p>
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
                            <p><strong>Entity Type:</strong> {{ $principal->entity_type ?? 'N/A' }}</p>
                            <p><strong>Website:</strong> {{ $principal->website_url ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Created At:</strong> {{ $principal->created_at->format('M d, Y h:i A') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $principal->status == 'active' ? 'success' : ($principal->status == 'inactive' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($principal->status) }}
                                </span>
                            </p>
                            <p><strong>Last Seen:</strong> 
                                {{ $principal->last_seen ? \Carbon\Carbon::parse($principal->last_seen)->diffForHumans() : 'Never' }}
                            </p>
                        </div>
                    </div>

                    <!-- Update Status -->
                    <form action="{{ route('admin.principals.update-status', $principal->id) }}" method="POST" class="d-flex gap-2 mt-3">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-select" style="width:auto;">
                            <option value="active" {{ $principal->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $principal->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ $principal->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacts Section -->
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Contacts</h4>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addContactModal">
                    <i class="fas fa-plus"></i> Add Contact
                </button>
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
                            <th>Actions</th>
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
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editContactModal{{ $contact->id }}">Edit</button>
                                    <form action="{{ route('admin.principals.contacts.destroy', $contact->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this contact?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">No contacts found.</td></tr>
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
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                    <i class="fas fa-plus"></i> Add Address
                </button>
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
                            <th>Actions</th>
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
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editAddressModal{{ $address->id }}">Edit</button>
                                    <form action="{{ route('admin.principals.addresses.destroy', ['principal' => $principal->id, 'address' => $address->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this address?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">No addresses found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
                            <td>{{ $brand->name }}</td>
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
                        <th>Actions</th>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
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
                            <td>{{ $product->brand->name ?? '—' }}</td>
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
</div>

@endsection
