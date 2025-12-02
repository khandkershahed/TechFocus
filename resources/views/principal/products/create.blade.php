@extends('principal.layouts.app')

@section('title', 'Add New Product - Principal Dashboard')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="h2 mb-2">Add New Product</h1>
        <p class="text-muted">Submit a new product for admin approval</p>
    </div>

    <!-- Form -->
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('principal.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Basic Information -->
                <div class="mb-4">
                    <h3 class="h5 mb-3 border-bottom pb-2">Basic Information</h3>
                    
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name *</label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name') }}"
                               class="form-control"
                               placeholder="Enter product name"
                               required>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Product Code -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="sku_code" class="form-label">SKU Code</label>
                            <input type="text" 
                                   name="sku_code" 
                                   id="sku_code"
                                   value="{{ old('sku_code') }}"
                                   class="form-control"
                                   placeholder="Enter SKU code">
                            @error('sku_code')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="product_code" class="form-label">Product Code</label>
                            <input type="text" 
                                   name="product_code" 
                                   id="product_code"
                                   value="{{ old('product_code') }}"
                                   class="form-control"
                                   placeholder="Enter product code">
                            @error('product_code')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="mb-3">
                        <label for="short_desc" class="form-label">Short Description</label>
                        <textarea name="short_desc" 
                                  id="short_desc"
                                  rows="3"
                                  class="form-control"
                                  placeholder="Enter short description">{{ old('short_desc') }}</textarea>
                        @error('short_desc')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Overview -->
                    <div class="mb-4">
                        <label for="overview" class="form-label">Overview</label>
                        <textarea name="overview" 
                                  id="overview"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Enter product overview">{{ old('overview') }}</textarea>
                        @error('overview')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Pricing & Details -->
                <div class="mb-4">
                    <h3 class="h5 mb-3 border-bottom pb-2">Pricing & Details</h3>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" 
                                   name="price" 
                                   id="price"
                                   step="0.01"
                                   value="{{ old('price') }}"
                                   class="form-control"
                                   placeholder="0.00">
                            @error('price')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="product_type" class="form-label">Product Type *</label>
                            <select name="product_type" 
                                    id="product_type"
                                    class="form-select"
                                    required>
                                <option value="">Select Type</option>
                                <option value="software" {{ old('product_type') == 'software' ? 'selected' : '' }}>Software</option>
                                <option value="hardware" {{ old('product_type') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                                <option value="service" {{ old('product_type') == 'service' ? 'selected' : '' }}>Service</option>
                                <option value="other" {{ old('product_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('product_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price_status" class="form-label">Price Status *</label>
                            <select name="price_status" 
                                    id="price_status"
                                    class="form-select"
                                    required>
                                <option value="">Select Status</option>
                                <option value="price" {{ old('price_status') == 'price' ? 'selected' : '' }}>Price</option>
                                <option value="rfq" {{ old('price_status') == 'rfq' ? 'selected' : '' }}>RFQ</option>
                                <option value="offer_price" {{ old('price_status') == 'offer_price' ? 'selected' : '' }}>Offer Price</option>
                                <option value="starting_price" {{ old('price_status') == 'starting_price' ? 'selected' : '' }}>Starting Price</option>
                            </select>
                            @error('price_status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Brand -->
                    <div class="mb-3">
                        <label for="brand_id" class="form-label">Brand *</label>
                        <select name="brand_id" 
                                id="brand_id"
                                class="form-select"
                                required>
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="form-label">Category *</label>
                        <select name="category_id" 
                                id="category_id"
                                class="form-select"
                                required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Thumbnail -->
                <div class="mb-4">
                    <h3 class="h5 mb-3 border-bottom pb-2">Product Image</h3>
                    
                    <div class="mb-4">
                        <label for="thumbnail" class="form-label">Product Thumbnail *</label>
                        <input type="file" 
                               name="thumbnail" 
                               id="thumbnail"
                               accept="image/*"
                               class="form-control"
                               onchange="previewImage(this, 'thumbnailPreview')"
                               required>
                        @error('thumbnail')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div id="thumbnailPreview" class="mt-2 d-none">
                            <p class="text-muted small mb-2">Thumbnail Preview:</p>
                            <img id="thumbnailPreviewImg" class="img-thumbnail" style="width: 128px; height: 128px;">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('principal.products.index') }}" 
                       class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Products
                    </a>
                    <button type="submit" 
                            class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Submit for Approval
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Box -->
    <div class="alert alert-info mt-4">
        <div class="d-flex">
            <div class="me-3">
                <i class="fas fa-info-circle fa-lg mt-1"></i>
            </div>
            <div>
                <h5 class="alert-heading">Submission Process</h5>
                <p class="mb-0">
                    Your product submission will be reviewed by our admin team. 
                    You'll be notified once it's approved or if any changes are required.
                    The status will appear as "Pending" until reviewed.
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const previewImg = document.getElementById(previewId + 'Img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('d-none');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('d-none');
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let valid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                valid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!valid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
});
</script>
@endpush
@endsection