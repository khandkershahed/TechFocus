@extends('admin.master')

@section('title', 'Pending Principal Products - Admin Panel')

@section('content')
<div class="container-fluid">
    <!-- Check if user has permission to review products -->
    @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('review products'))
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between mb-8">
            <div>
                <h1 class="fw-bolder text-dark mb-2">Pending Principal Products</h1>
                <p class="text-muted fw-semibold fs-6">
                    Manage product submissions from principals – approve or reject them after review.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light-primary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back to All Products
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
                <strong>SuperAdmin Access:</strong> You can grant product review permissions to other admins from the 
                <a href="{{ route('admin.permissions.index') }}" class="alert-link">Permissions Management</a> page.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Permission Restrictions Alert for Product Reviewers -->
        @if(!auth('admin')->user()->hasRole('SuperAdmin') && auth('admin')->user()->can('review products'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-exclamation-triangle me-2"></i>
                <strong>Product Reviewer Access:</strong> You can approve products but only SuperAdmin can reject them.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Card -->
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Principal Products Waiting for Approval</h2>
                    <div class="text-muted">
                        <i class="fa-solid fa-user-shield me-1"></i>
                        Access: {{ auth('admin')->user()->hasRole('SuperAdmin') ? 'SuperAdmin' : 'Product Reviewer' }}
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

                @if ($pendingProducts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-row-bordered align-middle gs-0 gy-4">
                            <thead>
                                <tr class="fw-bold text-muted bg-light">
                                    <th>Product</th>
                                    <th>Submitted By</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Submitted Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingProducts as $product)
                                    <tr>
                                        <!-- Product Info -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($product->thumbnail)
                                                    <div class="symbol symbol-50px me-3">
                                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                                                             alt="{{ $product->name }}" class="rounded">
                                                    </div>
                                                @else
                                                    <div class="symbol symbol-50px me-3 bg-light-primary rounded">
                                                        <span class="symbol-label text-primary fw-bold fs-6">
                                                            {{ strtoupper(substr($product->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <span class="fw-bold text-dark mb-1 d-block">{{ $product->name }}</span>
                                                    <span class="text-muted fs-7">{{ Str::limit($product->short_desc ?? 'No description', 50) }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Principal Info -->
                                        <td>
                                            @if ($product->principal)
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold text-dark">{{ $product->principal->name }}</span>
                                                    <span class="text-muted fs-7">{{ $product->principal->email }}</span>
                                                    <span class="text-muted fs-7">{{ $product->principal->company_name ?? 'No company' }}</span>
                                                </div>
                                            @else
                                                <span class="text-muted">Principal not found</span>
                                            @endif
                                        </td>

                                        <!-- Brand -->
                                        <td>
                                            @if($product->brand)
                                                <div class="d-flex flex-column">
                                                    <span class="fw-semibold text-dark">{{ $product->brand->title }}</span>
                                                    @if($product->brand->logo)
                                                        <div class="mt-1">
                                                            <img src="{{ asset('storage/' . $product->brand->logo) }}" 
                                                                 alt="{{ $product->brand->title }}" 
                                                                 class="rounded" style="max-height: 30px; max-width: 80px;">
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">No brand</span>
                                            @endif
                                        </td>

                                        <!-- Category -->
                                        <td>
                                            @if($product->category)
                                                <span class="badge badge-light-info fs-7">{{ $product->category->name }}</span>
                                            @else
                                                <span class="text-muted">No category</span>
                                            @endif
                                        </td>

                                        <!-- Price -->
                                        <td>
                                            @if($product->price)
                                                <span class="fw-bold text-dark">${{ number_format($product->price, 2) }}</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>

                                        <!-- Product Type -->
                                        <td>
                                            <span class="badge badge-light-primary fs-7">{{ $product->product_type ?? 'N/A' }}</span>
                                        </td>

                                        <!-- Date -->
                                        <td>
                                            <span class="text-muted fs-7">{{ $product->created_at->format('M d, Y') }}</span><br>
                                            <span class="text-muted fs-8">{{ $product->created_at->format('h:i A') }}</span>
                                        </td>

                                        <!-- Actions -->
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <!-- View Button -->
                                                <button type="button" class="btn btn-sm btn-icon btn-light-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#productModal{{ $product->id }}"
                                                        title="View Product Details">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>

                                                <!-- Approve Button (Available to both SuperAdmin and Product Reviewers) -->
                                                <form action="{{ route('admin.products.approve', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                            onclick="return confirm('Approve this product submitted by {{ $product->principal->name ?? 'principal' }}?')"
                                                            title="Approve Product">
                                                        <i class="fa-solid fa-check me-1"></i>Approve
                                                    </button>
                                                </form>

                                                <!-- Reject Button (Only for SuperAdmin) -->
                                                @if(auth('admin')->user()->hasRole('SuperAdmin'))
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal{{ $product->id }}"
                                                            title="Reject Product">
                                                        <i class="fa-solid fa-times me-1"></i>Reject
                                                    </button>
                                                @else
                                                    <!-- Disabled Reject Button for Product Reviewers -->
                                                    <button type="button" class="btn btn-sm btn-danger" disabled
                                                            title="Only SuperAdmin can reject products">
                                                        <i class="fa-solid fa-times me-1"></i>Reject
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- View Product Modal -->
                                    <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Product Details - {{ $product->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4 text-center">
                                                            @if($product->thumbnail)
                                                                <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                                                                     alt="{{ $product->name }}" 
                                                                     class="img-fluid rounded mb-3" style="max-height: 200px;">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h4>{{ $product->name }}</h4>
                                                            <p class="text-muted">{{ $product->short_desc ?? 'No short description' }}</p>
                                                            
                                                            <div class="row mt-3">
                                                                <div class="col-6">
                                                                    <strong>Brand:</strong><br>
                                                                    @if($product->brand)
                                                                        <div class="d-flex align-items-center mt-1">
                                                                            @if($product->brand->logo)
                                                                                <img src="{{ asset('storage/' . $product->brand->logo) }}" 
                                                                                     alt="{{ $product->brand->title }}" 
                                                                                     class="rounded me-2" style="max-height: 30px; max-width: 80px;">
                                                                            @endif
                                                                            <span class="fw-semibold">{{ $product->brand->title }}</span>
                                                                        </div>
                                                                    @else
                                                                        <span class="text-muted">No brand</span>
                                                                    @endif
                                                                </div>
                                                                <div class="col-6">
                                                                    <strong>Category:</strong><br>
                                                                    @if($product->category)
                                                                        <span class="badge badge-light-info mt-1">{{ $product->category->name }}</span>
                                                                    @else
                                                                        <span class="text-muted">No category</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-6">
                                                                    <strong>Product Type:</strong><br>
                                                                    <span class="badge badge-light-info">{{ $product->product_type ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-6">
                                                                    <strong>Price Status:</strong><br>
                                                                    <span class="badge badge-light-primary">{{ $product->price_status ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>

                                                            @if($product->price)
                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <strong>Price:</strong><br>
                                                                    <span class="fw-bold text-dark">${{ number_format($product->price, 2) }}</span>
                                                                </div>
                                                            </div>
                                                            @endif

                                                            @if($product->sku_code || $product->product_code)
                                                            <div class="row mt-2">
                                                                @if($product->sku_code)
                                                                <div class="col-6">
                                                                    <strong>SKU Code:</strong><br>
                                                                    <span class="text-muted">{{ $product->sku_code }}</span>
                                                                </div>
                                                                @endif
                                                                @if($product->product_code)
                                                                <div class="col-6">
                                                                    <strong>Product Code:</strong><br>
                                                                    <span class="text-muted">{{ $product->product_code }}</span>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            @endif

                                                            @if($product->overview)
                                                            <div class="mt-3">
                                                                <strong>Overview:</strong>
                                                                <p class="text-muted mt-1">{{ $product->overview }}</p>
                                                            </div>
                                                            @endif

                                                            @if($product->principal)
                                                                <div class="mt-3 p-3 bg-light rounded">
                                                                    <h6>Submitted by:</h6>
                                                                    <p class="mb-1"><strong>Name:</strong> {{ $product->principal->name }}</p>
                                                                    <p class="mb-1"><strong>Email:</strong> {{ $product->principal->email }}</p>
                                                                    <p class="mb-0"><strong>Company:</strong> {{ $product->principal->company_name ?? 'N/A' }}</p>
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
                                        <div class="modal fade" id="rejectModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.products.reject', $product->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Reject Product Submission</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>You are rejecting <strong>{{ $product->name }}</strong> submitted by <strong>{{ $product->principal->name ?? 'Principal' }}</strong>.</p>
                                                            <p class="text-warning"><strong>Note:</strong> The principal will be notified.</p>
                                                            <div class="form-group mt-3">
                                                                <label class="form-label">Reason for Rejection *</label>
                                                                <textarea name="rejection_reason" class="form-control" rows="4" required></textarea>
                                                                <div class="form-text">This reason will be visible to the principal.</div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Reject Product</button>
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
                        <h3 class="text-dark mb-4">No Pending Principal Products</h3>
                        <p class="text-muted fs-6 mb-6">All product submissions have been reviewed.</p>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                            <i class="fa-solid fa-list me-2"></i>View All Products
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Access Denied Message -->
        <div class="alert alert-danger text-center">
            <h4><i class="fa-solid fa-ban"></i> Access Denied</h4>
            <p class="mb-0">You do not have permission to access the product review system.</p>
            <p class="mb-0">Only SuperAdmin and users with product review permissions can access this page.</p>
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