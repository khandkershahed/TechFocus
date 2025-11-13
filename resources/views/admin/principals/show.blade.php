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
