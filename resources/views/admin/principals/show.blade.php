@extends('admin.master')

@section('title', 'Principal Details')

@section('content')
<div class="container-fluid">
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

    <div class="row">
        <div class="col-xl-4">
            <!-- Profile Card -->
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        @if($principal->photo)
                            <img src="{{ asset('storage/' . $principal->photo) }}" alt="{{ $principal->name }}" class="img-fluid rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="avatar-title bg-soft-primary text-primary rounded-circle font-size-24" style="width: 120px; height: 120px; line-height: 120px;">
                                {{ substr($principal->name, 0, 1) }}
                            </div>
                        @endif
                        
                        <h4 class="mt-3 mb-1">{{ $principal->name }}</h4>
                        <p class="text-muted">{{ $principal->company_name ?? 'No Company' }}</p>
                        
                        <div class="mt-3">
                            <span class="badge bg-{{ $principal->status == 'active' ? 'success' : ($principal->status == 'inactive' ? 'warning' : 'danger') }} me-1">
                                {{ ucfirst($principal->status) }}
                            </span>
                            
                            @if($principal->email_verified_at)
                                <span class="badge bg-success me-1">Verified</span>
                            @else
                                <span class="badge bg-warning me-1">Unverified</span>
                            @endif
                            
                            @if($principal->last_seen && \Carbon\Carbon::parse($principal->last_seen)->diffInMinutes() < 5)
                                <span class="badge bg-success">
                                    <i class="fas fa-circle me-1"></i> Online
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mt-3">
                        <h5 class="font-size-16">Contact Information</h5>
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Email :</th>
                                        <td>{{ $principal->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Phone :</th>
                                        <td>{{ $principal->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Address :</th>
                                        <td>{{ $principal->address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Country :</th>
                                        <td>{{ $principal->country->name ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <!-- Details Card -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Principal Information</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Company Name</label>
                                <p class="form-control-plaintext">{{ $principal->company_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Client Type</label>
                                <p class="form-control-plaintext">{{ $principal->client_type ? ucfirst($principal->client_type) : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Registration Date</label>
                                <p class="form-control-plaintext">{{ $principal->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Seen</label>
                                <p class="form-control-plaintext">
                                    @if($principal->last_seen)
                                        {{ \Carbon\Carbon::parse($principal->last_seen)->format('M d, Y h:i A') }}
                                        <small class="text-muted">({{ \Carbon\Carbon::parse($principal->last_seen)->diffForHumans() }})</small>
                                    @else
                                        Never
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email Verified</label>
                                <p class="form-control-plaintext">
                                    @if($principal->email_verified_at)
                                        {{ $principal->email_verified_at->format('M d, Y h:i A') }}
                                    @else
                                        <span class="text-danger">Not Verified</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Support Tier</label>
                                <p class="form-control-plaintext">{{ $principal->support_tier ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($principal->about)
                    <div class="mb-3">
                        <label class="form-label">About</label>
                        <p class="form-control-plaintext">{{ $principal->about }}</p>
                    </div>
                    @endif

                    <!-- Status Update Form -->
                    <div class="mt-4">
                        <h5 class="font-size-16">Update Status</h5>
                        <form action="{{ route('admin.principals.update-status', $principal->id) }}" method="POST" class="d-flex gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select" style="width: auto;">
                                <option value="active" {{ $principal->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $principal->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ $principal->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="disabled" {{ $principal->status == 'disabled' ? 'selected' : '' }}>Disabled</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection