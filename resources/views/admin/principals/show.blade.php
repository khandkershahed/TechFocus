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

                            <!-- Edit Modal -->
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
                                                    <label>Name</label>
                                                    <input type="text" name="contact_name" class="form-control" value="{{ $contact->contact_name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control" value="{{ $contact->email }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Phone</label>
                                                    <input type="text" name="phone_e164" class="form-control" value="{{ $contact->phone_e164 }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Preferred Channel</label>
                                                    <input type="text" name="preferred_channel" class="form-control" value="{{ $contact->preferred_channel }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr><td colspan="8" class="text-center">No contacts found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Contact Modal -->
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
                            <label>Name</label>
                            <input type="text" name="contact_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone_e164" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Preferred Channel</label>
                            <input type="text" name="preferred_channel" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Contact</button>
                    </div>
                </form>
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
                                <td>{{ $address->country_iso ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">No addresses found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Address Modal -->
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
                            <label>Type</label>
                            <select name="type" class="form-select" required>
                                <option value="HQ">HQ</option>
                                <option value="Billing">Billing</option>
                                <option value="Shipping">Shipping</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Address Line 1</label>
                            <input type="text" name="line1" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>City</label>
                            <input type="text" name="city" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>State</label>
                            <input type="text" name="state" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Postal Code</label>
                            <input type="text" name="postal" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Country ISO</label>
                            <input type="text" name="country_iso" class="form-control" maxlength="2" placeholder="e.g., US">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
