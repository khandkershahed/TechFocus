@extends('admin.master')
@section('title', 'Pending Principal Products - Admin Panel')

@section('content')
<!--begin::Container-->
<div class="container-fluid">
    <!--begin::Header-->
    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between mb-8">
        <div class="flex-grow-1">
            <h1 class="fw-bolder text-dark mb-2">Pending Principal Products</h1>
            <p class="text-muted fw-semibold fs-6">Manage product submissions from principals - Approve or reject principal submissions</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.products.index') }}" class="btn btn-light-primary">
                <i class="fa-solid fa-arrow-left me-2"></i>Back to All Products
            </a>
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Principal Products Waiting for Approval</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($pendingProducts->count() > 0)
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table table-hover table-row-bordered table-row-gray-300 align-middle gs-0 gy-4">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-150px">Product</th>
                                <th class="min-w-150px">Submitted By Principal</th>
                                <th class="min-w-120px">Brand</th>
                                <th class="min-w-120px">Category</th>
                                <th class="min-w-100px">Price</th>
                                <th class="min-w-100px">Type</th>
                                <th class="min-w-100px">Submitted Date</th>
                                <th class="min-w-150px text-end">Review Actions</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->

                        <!--begin::Table body-->
                        <tbody>
                            @foreach($pendingProducts as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->thumbnail)
                                            <div class="symbol symbol-50px me-3">
                                                <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="rounded">
                                            </div>
                                        @else
                                            <div class="symbol symbol-50px me-3 bg-light-primary rounded">
                                                <span class="symbol-label text-primary fw-bold fs-6">
                                                    {{ substr($product->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark mb-1">{{ $product->name }}</span>
                                            <span class="text-muted fs-7">{{ $product->short_desc ? Str::limit($product->short_desc, 50) : 'No description' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($product->principal)
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark">{{ $product->principal->name }}</span>
                                            <span class="text-muted fs-7">{{ $product->principal->email }}</span>
                                            <span class="text-muted fs-7">{{ $product->principal->company_name ?? 'No company' }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">Principal not found</span>
                                    @endif
                                </td>
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
                                <td>
                                    @if($product->category)
                                        <span class="badge badge-light-info fs-7">{{ $product->category->name }}</span>
                                    @else
                                        <span class="text-muted">No category</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->price)
                                        <span class="fw-bold text-dark">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-light-primary fs-7">{{ $product->product_type ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="text-muted fs-7">{{ $product->created_at->format('M d, Y') }}</span>
                                    <br>
                                    <span class="text-muted fs-8">{{ $product->created_at->format('h:i A') }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <!-- View Details Button -->
                                        <button type="button" class="btn btn-sm btn-icon btn-light-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#productModal{{ $product->id }}"
                                                title="View Product Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <!-- Approve Button -->
                                        <form action="{{ route('admin.products.approve', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" 
                                                    onclick="return confirm('Approve this product submitted by {{ $product->principal->name ?? 'principal' }}?')"
                                                    title="Approve Product">
                                                <i class="fa-solid fa-check me-1"></i>Approve
                                            </button>
                                        </form>

                                        <!-- Reject Button -->
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal{{ $product->id }}"
                                                title="Reject Product">
                                            <i class="fa-solid fa-times me-1"></i>Reject
                                        </button>
                                    </div>

                                    <!-- Product Details Modal -->
                                    <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Product Details - {{ $product->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                            
                                                            <!-- Brand and Category Information -->
                                                            <div class="row mt-3">
                                                                <div class="col-6">
                                                                    <strong>Brand:</strong>
                                                                    <br>
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
                                                                    <strong>Category:</strong>
                                                                    <br>
                                                                    @if($product->category)
                                                                        <span class="badge badge-light-info mt-1">{{ $product->category->name }}</span>
                                                                    @else
                                                                        <span class="text-muted">No category</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Product Type and Price Status -->
                                                            <div class="row mt-3">
                                                                <div class="col-6">
                                                                    <strong>Product Type:</strong>
                                                                    <br>
                                                                    <span class="badge badge-light-info">{{ $product->product_type ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="col-6">
                                                                    <strong>Price Status:</strong>
                                                                    <br>
                                                                    <span class="badge badge-light-primary">{{ $product->price_status ?? 'N/A' }}</span>
                                                                </div>
                                                            </div>

                                                            <!-- Price Information -->
                                                            @if($product->price)
                                                            <div class="row mt-2">
                                                                <div class="col-12">
                                                                    <strong>Price:</strong>
                                                                    <br>
                                                                    <span class="fw-bold text-dark">${{ number_format($product->price, 2) }}</span>
                                                                </div>
                                                            </div>
                                                            @endif

                                                            <!-- Product Codes -->
                                                            @if($product->sku_code || $product->product_code)
                                                            <div class="row mt-2">
                                                                @if($product->sku_code)
                                                                <div class="col-6">
                                                                    <strong>SKU Code:</strong>
                                                                    <br>
                                                                    <span class="text-muted">{{ $product->sku_code }}</span>
                                                                </div>
                                                                @endif
                                                                @if($product->product_code)
                                                                <div class="col-6">
                                                                    <strong>Product Code:</strong>
                                                                    <br>
                                                                    <span class="text-muted">{{ $product->product_code }}</span>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            @endif

                                                            <!-- Overview -->
                                                            @if($product->overview)
                                                            <div class="mt-3">
                                                                <strong>Overview:</strong>
                                                                <p class="text-muted mt-1">{{ $product->overview }}</p>
                                                            </div>
                                                            @endif

                                                            <!-- Principal Information -->
                                                            @if($product->principal)
                                                                <div class="mt-3 p-3 bg-light rounded">
                                                                    <h6>Submitted by Principal:</h6>
                                                                    <p class="mb-1"><strong>Name:</strong> {{ $product->principal->name }}</p>
                                                                    <p class="mb-1"><strong>Email:</strong> {{ $product->principal->email }}</p>
                                                                    <p class="mb-0"><strong>Company:</strong> {{ $product->principal->company_name ?? 'N/A' }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Reason Modal -->
                                    <div class="modal fade" id="rejectModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.products.reject', $product->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reject Product Submission</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>You are about to reject <strong>{{ $product->name }}</strong> submitted by <strong>{{ $product->principal->name ?? 'principal' }}</strong>.</p>
                                                        <p class="text-warning"><strong>Note:</strong> The principal will be notified of this rejection.</p>
                                                        <div class="form-group mt-3">
                                                            <label for="rejection_reason" class="form-label">Reason for Rejection *</label>
                                                            <textarea name="rejection_reason" 
                                                                      class="form-control" 
                                                                      rows="4" 
                                                                      placeholder="Please provide a clear reason for rejection so the principal can make necessary changes..."
                                                                      required></textarea>
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
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <!--end::Table-->
            @else
                <!--begin::Empty state-->
                <div class="text-center py-10">
                    <div class="mb-7">
                        <i class="fa-solid fa-clipboard-check text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="text-dark mb-4">No Pending Principal Products</h3>
                    <p class="text-muted fs-6 mb-6">All principal product submissions have been reviewed. Check back later for new submissions.</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                        <i class="fa-solid fa-list me-2"></i>View All Products
                    </a>
                </div>
                <!--end::Empty state-->
            @endif
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>
<!--end::Container-->
@endsection

@push('scripts')
<script>
    // Auto-focus on rejection reason textarea when modal opens
    document.addEventListener('DOMContentLoaded', function() {
        const rejectModals = document.querySelectorAll('[id^="rejectModal"]');
        rejectModals.forEach(modal => {
            modal.addEventListener('shown.bs.modal', function () {
                const textarea = this.querySelector('textarea[name="rejection_reason"]');
                if (textarea) {
                    textarea.focus();
                }
            });
        });
    });
</script>
@endpush