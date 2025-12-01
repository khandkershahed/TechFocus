@extends('principal.layouts.app')

@section('title', 'My Products - Principal Dashboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">My Products</h1>
            <p class="text-muted mb-0">Manage your product submissions</p>
        </div>
        <a href="{{ route('principal.products.create') }}" 
           class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Product
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle bg-primary bg-opacity-10 text-primary me-3">
                            <i class="fas fa-cube fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Products</h6>
                            <h3 class="mb-0">{{ $products->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle bg-success bg-opacity-10 text-success me-3">
                            <i class="fas fa-check fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Approved</h6>
                            <h3 class="mb-0">{{ $products->where('submission_status', 'approved')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle bg-warning bg-opacity-10 text-warning me-3">
                            <i class="fas fa-clock fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Pending</h6>
                            <h3 class="mb-0">{{ $products->where('submission_status', 'pending')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle bg-danger bg-opacity-10 text-danger me-3">
                            <i class="fas fa-times fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Rejected</h6>
                            <h3 class="mb-0">{{ $products->where('submission_status', 'rejected')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card shadow border-0">
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Product Details</th>
                            <th class="border-0">Status & Pricing</th>
                            <th class="border-0">Product Info</th>
                            <th class="border-0">Submission Details</th>
                            <th class="border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <!-- Product Details Column -->
                            <td class="align-middle">
                                <div class="d-flex align-items-start">
                                    @if($product->thumbnail)
                                        <div class="flex-shrink-0 me-3">
                                            <img class="rounded" 
                                                 src="{{ asset('storage/' . $product->thumbnail) }}" 
                                                 alt="{{ $product->name }}"
                                                 style="width: 64px; height: 64px; object-fit: cover;">
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 me-3 bg-light rounded d-flex align-items-center justify-content-center"
                                             style="width: 64px; height: 64px;">
                                            <i class="fas fa-cube text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <h6 class="mb-0 me-2">{{ $product->name }}</h6>
                                            @if($product->featured)
                                                <span class="badge bg-purple">
                                                    <i class="fas fa-star me-1"></i>Featured
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($product->short_desc)
                                            <p class="text-muted small mb-2">{{ Str::limit($product->short_desc, 80) }}</p>
                                        @endif
                                        
                                        <div class="d-flex flex-wrap gap-1">
                                            @if($product->sku_code)
                                                <span class="badge bg-light text-dark border">
                                                    <i class="fas fa-barcode me-1"></i>SKU: {{ $product->sku_code }}
                                                </span>
                                            @endif
                                            @if($product->product_code)
                                                <span class="badge bg-light text-dark border">
                                                    <i class="fas fa-hashtag me-1"></i>Code: {{ $product->product_code }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Status & Pricing Column -->
                            <td class="align-middle">
                                <div class="mb-2">
                                    <span class="badge 
                                        @if($product->submission_status == 'approved') bg-success
                                        @elseif($product->submission_status == 'pending') bg-warning text-dark
                                        @elseif($product->submission_status == 'rejected') bg-danger
                                        @else bg-secondary @endif">
                                        {{ ucfirst($product->submission_status) }}
                                    </span>
                                </div>

                                <!-- Product Status -->
                                @if($product->product_status)
                                <div class="small mb-2">
                                    <span class="text-muted">Product Status:</span>
                                    <span class="fw-medium">{{ ucfirst($product->product_status) }}</span>
                                </div>
                                @endif

                                <!-- Pricing -->
                                <div class="mb-2">
                                    @if($product->price)
                                        <div class="fw-bold text-dark">
                                            ${{ number_format($product->price, 2) }}
                                        </div>
                                    @endif
                                    
                                    @if($product->price_status)
                                        <div class="small text-muted">
                                            <span class="fw-medium">Price Type:</span> 
                                            <span class="text-capitalize">{{ str_replace('_', ' ', $product->price_status) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Rejection Reason -->
                                @if($product->submission_status == 'rejected' && $product->rejection_reason)
                                <div class="mt-2 p-2 bg-danger bg-opacity-10 rounded border border-danger border-opacity-25">
                                    <div class="small fw-medium text-danger mb-1">Rejection Reason:</div>
                                    <div class="small text-danger">{{ $product->rejection_reason }}</div>
                                </div>
                                @endif
                            </td>

                            <!-- Product Info Column -->
                            <td class="align-middle">
                                <div class="small">
                                    <!-- Product Type -->
                                    @if($product->product_type)
                                    <div class="mb-1">
                                        <span class="text-muted">Type:</span>
                                        <span class="fw-medium text-capitalize">{{ $product->product_type }}</span>
                                    </div>
                                    @endif

                                    <!-- Brand -->
                                    @if($product->brand)
                                    <div class="mb-1">
                                        <span class="text-muted">Brand:</span>
                                        <span class="fw-medium">{{ $product->brand->title }}</span>
                                    </div>
                                    @endif

                                    <!-- Category -->
                                    @if($product->category)
                                    <div class="mb-1">
                                        <span class="text-muted">Category:</span>
                                        <span class="fw-medium">{{ $product->category->name }}</span>
                                    </div>
                                    @endif

                                    <!-- Overview Preview -->
                                    @if($product->overview)
                                    <div class="mt-2">
                                        <div class="text-muted small mb-1">Overview:</div>
                                        <div class="text-muted small text-truncate" style="max-width: 200px;">
                                            {{ Str::limit($product->overview, 100) }}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Submission Details Column -->
                            <td class="align-middle">
                                <div class="small">
                                    <!-- Dates -->
                                    <div class="mb-2">
                                        <div class="text-muted">Submitted:</div>
                                        <div class="fw-medium">
                                            {{ $product->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-muted">
                                            {{ $product->created_at->format('h:i A') }}
                                        </div>
                                    </div>

                                    <!-- Last Updated -->
                                    @if($product->updated_at != $product->created_at)
                                    <div class="mb-2">
                                        <div class="text-muted">Last Updated:</div>
                                        <div class="text-muted">
                                            {{ $product->updated_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Email Verification -->
                                    @if($product->email_verified_at)
                                    <div class="d-flex align-items-center text-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        <span>Email Verified</span>
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Actions Column -->
                            <td class="align-middle">
                                <div class="d-flex flex-column gap-2">
                                    <!-- View Details Button -->
                                    <button onclick="showSimpleProductDetails({{ $product }})"
                                            class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>View Details
                                    </button>

                                    <!-- Edit Button -->
                                    <a href="{{ route('principal.products.edit', $product->id) }}" 
                                       class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('principal.products.destroy', $product->id) }}" method="POST" class="w-100">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger w-100"
                                                onclick="return confirm('Are you sure you want to delete this product?')">
                                            <i class="fas fa-trash me-1"></i>Delete
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
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-cube fa-4x text-light"></i>
                </div>
                <h4 class="text-muted mb-3">No products yet</h4>
                <p class="text-muted mb-4">Start by adding your first product.</p>
                <a href="{{ route('principal.products.create') }}" 
                   class="btn btn-primary">
                    Add Your First Product
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Product Details Modal -->
<div class="modal fade" id="productDetailsModal" tabindex="-1" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productDetailsModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div id="productDetailsContent" class="max-h-400 overflow-auto">
                    <!-- Content will be loaded via JavaScript -->
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a id="editProductLink" href="#" class="btn btn-primary">Edit Product</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.max-h-400 {
    max-height: 400px;
}
</style>
@endpush

@push('scripts')
<script>
function showSimpleProductDetails(product) {
    const modalContent = `
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-bold">Product Name</label>
                    <p class="text-dark">${product.name}</p>
                </div>
                ${product.sku_code ? `
                <div class="mb-3">
                    <label class="form-label fw-bold">SKU Code</label>
                    <p class="text-dark">${product.sku_code}</p>
                </div>
                ` : ''}
                ${product.price ? `
                <div class="mb-3">
                    <label class="form-label fw-bold">Price</label>
                    <h4 class="text-success">$${parseFloat(product.price).toFixed(2)}</h4>
                </div>
                ` : ''}
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <br>
                    <span class="badge ${
                        product.submission_status === 'approved' ? 'bg-success' :
                        product.submission_status === 'pending' ? 'bg-warning text-dark' :
                        'bg-danger'
                    }">
                        ${product.submission_status}
                    </span>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Product Type</label>
                    <p class="text-dark text-capitalize">${product.product_type}</p>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('productDetailsContent').innerHTML = modalContent;
    document.getElementById('editProductLink').href = `/principal/products/${product.id}/edit`;
    
    const modal = new bootstrap.Modal(document.getElementById('productDetailsModal'));
    modal.show();
}

// Make the function globally available
window.closeProductDetails = function() {
    const modalElement = document.getElementById('productDetailsModal');
    const modal = bootstrap.Modal.getInstance(modalElement);
    if (modal) {
        modal.hide();
    }
}
</script>
@endpush