@extends('admin.master')

@section('title', 'Pending Principal Brands - Admin Panel')

@section('content')
<div class="container-fluid">
    <!-- Check if user has permission to review brands -->
    @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('review brands'))
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between mb-8">
            <div>
                <h1 class="fw-bolder text-dark mb-2">Pending Principal Brands</h1>
                <p class="text-muted fw-semibold fs-6">
                    Manage brand submissions from principals – approve or reject them after review.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.brand.index') }}" class="btn btn-light-primary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back to All Brands
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
                <strong>SuperAdmin Access:</strong> You can grant brand review permissions to other admins from the 
                <a href="{{ route('admin.permissions.index') }}" class="alert-link">Permissions Management</a> page.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Permission Restrictions Alert for Brand Reviewers -->
        @if(!auth('admin')->user()->hasRole('SuperAdmin') && auth('admin')->user()->can('review brands'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-exclamation-triangle me-2"></i>
                <strong>Brand Reviewer Access:</strong> You can approve brands but only SuperAdmin can reject them.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Card -->
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Principal Brands Waiting for Approval</h2>
                    <div class="text-muted">
                        <i class="fa-solid fa-user-shield me-1"></i>
                        Access: {{ auth('admin')->user()->hasRole('SuperAdmin') ? 'SuperAdmin' : 'Brand Reviewer' }}
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

                @if ($pendingBrands->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-row-bordered align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bold text-muted bg-light">
                                    <th>Brand</th>
                                    <th>Submitted By</th>
                                    <th>Category</th>
                                    <th>Website</th>
                                    <th>Submitted Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingBrands as $brand)
                                    <tr>
                                        <!-- Brand Info -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($brand->logo)
                                                    <div class="symbol symbol-50px me-3">
                                                        <img src="{{ asset('storage/brand/logo/' . $brand->logo) }}" 
                                                             alt="{{ $brand->title }}" class="rounded-circle">
                                                    </div>
                                                @else
                                                    <div class="symbol symbol-50px me-3 bg-light-primary rounded-circle">
                                                        <span class="symbol-label text-primary fw-bold fs-6">
                                                            {{ strtoupper(substr($brand->title, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="fw-bold text-dark mb-1 d-block">{{ $brand->title }}</span>
                                                    <span class="text-muted fs-7">{{ Str::limit($brand->description ?? 'No description', 50) }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Principal Info -->
                                        <td>
                                            @if ($brand->principal)
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold text-dark">{{ $brand->principal->name }}</span>
                                                    <span class="text-muted fs-7">{{ $brand->principal->email }}</span>
                                                    <span class="text-muted fs-7">{{ $brand->principal->company_name ?? 'No company' }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">Principal not found</span>
                                            @endif
                                        </td>

                                        <!-- Category -->
                                        <td>
                                            <span class="badge badge-light-info fs-7">{{ $brand->category ?? 'N/A' }}</span>
                                        </td>

                                        <!-- Website -->
                                        <td>
                                            @if ($brand->website_url)
                                                <a href="{{ $brand->website_url }}" target="_blank" class="text-primary text-hover-primary fs-7">
                                                    {{ Str::limit($brand->website_url, 30) }}
                                                </a>
                                            @else
                                                <span class="text-muted">No website</span>
                                            @endif
                                        </td>

                                        <!-- Date -->
                                        <td>
                                            <span class="text-muted fs-7">{{ $brand->created_at->format('M d, Y') }}</span><br>
                                            <span class="text-muted fs-8">{{ $brand->created_at->format('h:i A') }}</span>
                                        </td>

                                        <!-- Actions -->
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <!-- View Button -->
                                                <button type="button" class="btn btn-sm btn-icon btn-light-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#brandModal{{ $brand->id }}"
                                                        title="View Brand Details">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>

                                                <!-- Approve Button (Available to both SuperAdmin and Brand Reviewers) -->
                                                <form action="{{ route('admin.brands.approve', $brand->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                            onclick="return confirm('Approve this brand submitted by {{ $brand->principal->name ?? 'principal' }}?')"
                                                            title="Approve Brand">
                                                        <i class="fa-solid fa-check me-1"></i>Approve
                                                    </button>
                                                </form>

                                                <!-- Reject Button (Only for SuperAdmin) -->
                                                @if(auth('admin')->user()->hasRole('SuperAdmin'))
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal{{ $brand->id }}"
                                                            title="Reject Brand">
                                                        <i class="fa-solid fa-times me-1"></i>Reject
                                                    </button>
                                                @else
                                                    <!-- Disabled Reject Button for Brand Reviewers -->
                                                    <button type="button" class="btn btn-sm btn-danger" disabled
                                                            title="Only SuperAdmin can reject brands">
                                                        <i class="fa-solid fa-times me-1"></i>Reject
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- View Brand Modal -->
                                    <div class="modal fade" id="brandModal{{ $brand->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Brand Details - {{ $brand->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4 text-center">
                                                            @if($brand->logo)
                                                                <img src="{{ asset('storage/brand/logo/' . $brand->logo) }}" 
                                                                     class="img-fluid rounded mb-3" style="max-height: 150px;">
                                                            @endif
                                                            @if($brand->image)
                                                                <img src="{{ asset('storage/brand/image/' . $brand->image) }}" 
                                                                     class="img-fluid rounded" style="max-height: 150px;">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h4>{{ $brand->title }}</h4>
                                                            <p class="text-muted">{{ $brand->description ?? 'No description provided' }}</p>
                                                            <div class="row mt-3">
                                                                <div class="col-6">
                                                                    <strong>Category:</strong><br>
                                                                    <span class="badge badge-light-info">{{ $brand->category ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-6">
                                                                    <strong>Website:</strong><br>
                                                                    @if($brand->website_url)
                                                                        <a href="{{ $brand->website_url }}" target="_blank" class="text-primary">Visit Website</a>
                                                                    @else
                                                                        <span class="text-muted">No website</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @if($brand->principal)
                                                                <div class="mt-3 p-3 bg-light rounded">
                                                                    <h6>Submitted by:</h6>
                                                                    <p class="mb-1"><strong>Name:</strong> {{ $brand->principal->name }}</p>
                                                                    <p class="mb-1"><strong>Email:</strong> {{ $brand->principal->email }}</p>
                                                                    <p class="mb-1"><strong>Company:</strong> {{ $brand->principal->company_name ?? 'N/A' }}</p>
                                                                    <p class="mb-0"><strong>Phone:</strong> {{ $brand->principal->phone ?? 'N/A' }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Modal (Only for SuperAdmin) -->
                                    @if(auth('admin')->user()->hasRole('SuperAdmin'))
                                        <div class="modal fade" id="rejectModal{{ $brand->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.brands.reject', $brand->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Reject Brand Submission</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>You are rejecting <strong>{{ $brand->title }}</strong> submitted by <strong>{{ $brand->principal->name ?? 'Principal' }}</strong>.</p>
                                                            <p class="text-warning"><strong>Note:</strong> The principal will be notified.</p>
                                                            <div class="form-group mt-3">
                                                                <label class="form-label">Reason for Rejection *</label>
                                                                <textarea name="rejection_reason" class="form-control" rows="4" required></textarea>
                                                                <div class="form-text">This reason will be visible to the principal.</div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Reject Brand</button>
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
                @else
                    <!-- Empty State -->
                    <div class="text-center py-10">
                        <i class="fa-solid fa-clipboard-check text-primary mb-4" style="font-size: 4rem;"></i>
                        <h3 class="text-dark mb-4">No Pending Principal Brands</h3>
                        <p class="text-muted fs-6 mb-6">All brand submissions have been reviewed.</p>
                        <a href="{{ route('admin.brand.index') }}" class="btn btn-primary">
                            <i class="fa-solid fa-list me-2"></i>View All Brands
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Access Denied Message -->
        <div class="alert alert-danger text-center">
            <h4><i class="fa-solid fa-ban"></i> Access Denied</h4>
            <p class="mb-0">You do not have permission to access the brand review system.</p>
            <p class="mb-0">Only SuperAdmin and users with brand review permissions can access this page.</p>
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
        document.querySelectorAll('[id^="rejectModal"]').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function () {
                const textarea = this.querySelector('textarea[name="rejection_reason"]');
                if (textarea) textarea.focus();
            });
        });
    });
</script>
@endpush