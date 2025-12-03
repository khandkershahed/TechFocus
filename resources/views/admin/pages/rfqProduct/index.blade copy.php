@extends('admin.master')

@section('title', 'RFQ Products')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">RFQ Products</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">RFQ Products</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('rfqProducts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Product
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Total Products
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $rfqProducts->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                Active RFQs
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $rfqs->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search products by name, SKU, brand, or RFQ code..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="brandFilter">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="rfqFilter">
                        <option value="">All RFQs</option>
                        @foreach($rfqs as $rfq)
                            <option value="{{ $rfq->rfq_code }}">{{ $rfq->rfq_code }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">RFQ Product List</h5>
                </div>
                <div class="col-auto">
                    <button class="btn btn-sm btn-outline-secondary" onclick="resetFilters()">
                        <i class="fas fa-refresh me-1"></i>Reset
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="productsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>RFQ Code</th>
                            <th>Product</th>
                            <th>Brand</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        @forelse($rfqProducts as $item)
                            <tr class="align-middle product-row" 
                                data-product-name="{{ strtolower($item->product->name ?? '') }}"
                                data-sku="{{ strtolower($item->sku_no ?? '') }}"
                                data-brand="{{ strtolower($item->brand_name ?? '') }}"
                                data-rfq="{{ $item->rfq->rfq_code ?? '' }}">
                                <td class="ps-4 fw-semibold">#{{ $item->id }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $item->rfq->rfq_code ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->image)
                                            <img src="{{ asset('storage/'.$item->image) }}" 
                                                 class="rounded me-3" width="40" height="40" alt="Product">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-box text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold product-name">{{ $item->product->name ?? 'N/A' }}</div>
                                            <small class="text-muted sku">{{ $item->sku_no ?? 'No SKU' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-outline-secondary brand">{{ $item->brand_name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $item->qty }}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold">${{ number_format($item->unit_price, 2) }}</span>
                                </td>
                                <td>
                                    @if($item->discount > 0)
                                        <span class="badge bg-success">{{ $item->discount }}%</span>
                                    @else
                                        <span class="text-muted">None</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">${{ number_format($item->grand_total, 2) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <!-- View Details Button -->
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailsModal{{ $item->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal{{ $item->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        @if (Auth::guard('admin')->user()->role == 'admin')
                                        <!-- Delete Button -->
                                        <form action="{{ route('rfqProducts.destroy', $item->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Details Modal -->
                            <div class="modal fade" id="detailsModal{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Product Details - #{{ $item->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">Product Name</label>
                                                    <p>{{ $item->product->name ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">RFQ Code</label>
                                                    <p>{{ $item->rfq->rfq_code ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">SKU No</label>
                                                    <p>{{ $item->sku_no ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">Model No</label>
                                                    <p>{{ $item->model_no ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">Brand</label>
                                                    <p>{{ $item->brand_name ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">Quantity</label>
                                                    <p>{{ $item->qty }}</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">Unit Price</label>
                                                    <p>${{ number_format($item->unit_price, 2) }}</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">Discount</label>
                                                    <p>{{ $item->discount }}%</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">Tax</label>
                                                    <p>{{ $item->tax }}%</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">VAT</label>
                                                    <p>{{ $item->vat }}%</p>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Product Description</label>
                                                    <p>{{ $item->product_des ?? 'No description available' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <form action="{{ route('rfqProducts.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit RFQ Product - #{{ $item->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <!-- Product Information -->
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Product</label>
                                                        <select name="product_id" class="form-select" required>
                                                            <option value="">Select Product</option>
                                                            @foreach($products as $product)
                                                                <option value="{{ $product->id }}" 
                                                                    {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                                    {{ $product->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">RFQ</label>
                                                        <select name="rfq_id" class="form-select" required>
                                                            <option value="">Select RFQ</option>
                                                            @foreach($rfqs as $rfq)
                                                                <option value="{{ $rfq->id }}" 
                                                                    {{ $item->rfq_id == $rfq->id ? 'selected' : '' }}>
                                                                    {{ $rfq->rfq_code }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="number" name="qty" class="form-control" 
                                                               value="{{ $item->qty }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Unit Price ($)</label>
                                                        <input type="number" name="unit_price" class="form-control" 
                                                               value="{{ $item->unit_price }}" step="0.01" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Discount (%)</label>
                                                        <input type="number" name="discount" class="form-control" 
                                                               value="{{ $item->discount }}" step="0.01">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">SKU No</label>
                                                        <input type="text" name="sku_no" class="form-control" 
                                                               value="{{ $item->sku_no }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Model No</label>
                                                        <input type="text" name="model_no" class="form-control" 
                                                               value="{{ $item->model_no }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Brand</label>
                                                        <select name="brand_name" class="form-select">
                                                            <option value="">Select Brand</option>
                                                            @foreach($brands as $brand)
                                                                <option value="{{ $brand->name }}" 
                                                                    {{ $item->brand_name == $brand->name ? 'selected' : '' }}>
                                                                    {{ $brand->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- Additional Information -->
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Additional Product</label>
                                                        <input type="text" name="additional_product_name" 
                                                               class="form-control" value="{{ $item->additional_product_name }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Additional Qty</label>
                                                        <input type="number" name="additional_qty" class="form-control" 
                                                               value="{{ $item->additional_qty }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Tax (%)</label>
                                                        <input type="number" name="tax" class="form-control" 
                                                               value="{{ $item->tax }}" step="0.01">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">VAT (%)</label>
                                                        <input type="number" name="vat" class="form-control" 
                                                               value="{{ $item->vat }}" step="0.01">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Image</label>
                                                        <input type="file" name="image" class="form-control">
                                                        @if($item->image)
                                                            <div class="mt-2">
                                                                <img src="{{ asset('storage/'.$item->image) }}" 
                                                                     width="80" height="80" class="rounded" alt="Current image">
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Product Description</label>
                                                        <textarea name="product_des" class="form-control" 
                                                                  rows="3">{{ $item->product_des }}</textarea>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label class="form-label">Additional Information</label>
                                                        <textarea name="additional_info" class="form-control" 
                                                                  rows="2">{{ $item->additional_info }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update Product</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-box-open fa-3x mb-3"></i>
                                        <h5>No RFQ Products Found</h5>
                                        <p>Get started by adding your first RFQ product.</p>
                                        <a href="{{ route('rfqProducts.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Add New Product
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination Section -->
        @if($rfqProducts->hasPages())
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Showing {{ $rfqProducts->firstItem() }} to {{ $rfqProducts->lastItem() }} of {{ $rfqProducts->total() }} products
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Previous Page Link --}}
                        @if($rfqProducts->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $rfqProducts->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach($rfqProducts->getUrlRange(1, $rfqProducts->lastPage()) as $page => $url)
                            @if($page == $rfqProducts->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if($rfqProducts->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $rfqProducts->nextPageUrl() }}" rel="next">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Enhanced search functionality
    document.getElementById('searchInput').addEventListener('input', filterProducts);
    document.getElementById('brandFilter').addEventListener('change', filterProducts);
    document.getElementById('rfqFilter').addEventListener('change', filterProducts);

    function filterProducts() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const brandFilter = document.getElementById('brandFilter').value.toLowerCase();
        const rfqFilter = document.getElementById('rfqFilter').value;
        
        const rows = document.querySelectorAll('#productsTableBody .product-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const productName = row.getAttribute('data-product-name');
            const sku = row.getAttribute('data-sku');
            const brand = row.getAttribute('data-brand');
            const rfqCode = row.getAttribute('data-rfq');
            
            // Check search term against multiple fields
            const matchesSearch = !searchTerm || 
                productName.includes(searchTerm) || 
                sku.includes(searchTerm) ||
                brand.includes(searchTerm) ||
                rfqCode.includes(searchTerm);
            
            // Check brand filter
            const matchesBrand = !brandFilter || brand === brandFilter.toLowerCase();
            
            // Check RFQ filter
            const matchesRfq = !rfqFilter || rfqCode === rfqFilter;
            
            // Show/hide row based on all filters
            const shouldShow = matchesSearch && matchesBrand && matchesRfq;
            row.style.display = shouldShow ? '' : 'none';
            
            if (shouldShow) visibleCount++;
        });

        // Update visible count
        document.getElementById('visibleCount').textContent = visibleCount;

        // Show no results message if needed
        const noResultsRow = document.querySelector('.no-results');
        if (visibleCount === 0 && !noResultsRow) {
            const tbody = document.getElementById('productsTableBody');
            const tr = document.createElement('tr');
            tr.className = 'no-results';
            tr.innerHTML = `
                <td colspan="10" class="text-center py-4">
                    <div class="text-muted">
                        <i class="fas fa-search fa-3x mb-3"></i>
                        <h5>No products found</h5>
                        <p>Try adjusting your search or filters</p>
                        <button class="btn btn-outline-primary" onclick="resetFilters()">
                            <i class="fas fa-refresh me-1"></i>Reset Filters
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        } else if (visibleCount > 0 && noResultsRow) {
            noResultsRow.remove();
        }
    }

    function resetFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('brandFilter').value = '';
        document.getElementById('rfqFilter').value = '';
        filterProducts();
    }

    // Initialize filters on page load
    document.addEventListener('DOMContentLoaded', function() {
        filterProducts();
    });
</script>
@endsection