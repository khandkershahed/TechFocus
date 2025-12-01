@extends('principal.layouts.app')

@section('title', 'Edit Product - Principal Dashboard')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="h2 mb-2">Edit Product</h1>
        <p class="text-muted">Update product information</p>
    </div>

    <!-- Debug Info -->
    @if($errors->any())
    <div class="alert alert-danger mb-4">
        <h5 class="alert-heading">Validation Errors:</h5>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <div class="card shadow">
        <div class="card-body">
            <form id="editProductForm" action="{{ route('principal.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="mb-4">
                    <h3 class="h5 mb-3 border-bottom pb-2">Basic Information</h3>
                    
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name *</label>
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name', $product->name) }}"
                               class="form-control"
                               placeholder="Enter product name"
                               required>
                    </div>

                    <!-- Product Code -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="sku_code" class="form-label">SKU Code</label>
                            <input type="text" 
                                   name="sku_code" 
                                   id="sku_code"
                                   value="{{ old('sku_code', $product->sku_code) }}"
                                   class="form-control"
                                   placeholder="Enter SKU code">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="product_code" class="form-label">Product Code</label>
                            <input type="text" 
                                   name="product_code" 
                                   id="product_code"
                                   value="{{ old('product_code', $product->product_code) }}"
                                   class="form-control"
                                   placeholder="Enter product code">
                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="mb-3">
                        <label for="short_desc" class="form-label">Short Description</label>
                        <textarea name="short_desc" 
                                  id="short_desc"
                                  rows="3"
                                  class="form-control"
                                  placeholder="Enter short description">{{ old('short_desc', $product->short_desc) }}</textarea>
                    </div>

                    <!-- Overview -->
                    <div class="mb-4">
                        <label for="overview" class="form-label">Overview</label>
                        <textarea name="overview" 
                                  id="overview"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Enter product overview">{{ old('overview', $product->overview) }}</textarea>
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
                                   value="{{ old('price', $product->price) }}"
                                   class="form-control"
                                   placeholder="0.00">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="product_type" class="form-label">Product Type *</label>
                            <select name="product_type" 
                                    id="product_type"
                                    class="form-select"
                                    required>
                                <option value="">Select Type</option>
                                <option value="software" {{ old('product_type', $product->product_type) == 'software' ? 'selected' : '' }}>Software</option>
                                <option value="hardware" {{ old('product_type', $product->product_type) == 'hardware' ? 'selected' : '' }}>Hardware</option>
                                <option value="service" {{ old('product_type', $product->product_type) == 'service' ? 'selected' : '' }}>Service</option>
                                <option value="other" {{ old('product_type', $product->product_type) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="price_status" class="form-label">Price Status *</label>
                            <select name="price_status" 
                                    id="price_status"
                                    class="form-select"
                                    required>
                                <option value="">Select Status</option>
                                <option value="price" {{ old('price_status', $product->price_status) == 'price' ? 'selected' : '' }}>Price</option>
                                <option value="rfq" {{ old('price_status', $product->price_status) == 'rfq' ? 'selected' : '' }}>RFQ</option>
                                <option value="offer_price" {{ old('price_status', $product->price_status) == 'offer_price' ? 'selected' : '' }}>Offer Price</option>
                                <option value="starting_price" {{ old('price_status', $product->price_status) == 'starting_price' ? 'selected' : '' }}>Starting Price</option>
                            </select>
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
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->title }}
                                </option>
                            @endforeach
                        </select>
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
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Current Thumbnail -->
                @if($product->thumbnail)
                <div class="mb-3">
                    <label class="form-label">Current Thumbnail</label>
                    <div>
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                             alt="{{ $product->name }}" 
                             class="img-thumbnail" style="width: 128px; height: 128px;">
                    </div>
                </div>
                @endif

                <!-- Thumbnail -->
                <div class="mb-4">
                    <h3 class="h5 mb-3 border-bottom pb-2">
                        {{ $product->thumbnail ? 'Change Thumbnail' : 'Product Thumbnail' }}
                    </h3>
                    
                    <div class="mb-4">
                        <label for="thumbnail" class="form-label">
                            {{ $product->thumbnail ? 'Change Thumbnail' : 'Product Thumbnail *' }}
                        </label>
                        <input type="file" 
                               name="thumbnail" 
                               id="thumbnail"
                               accept="image/*"
                               class="form-control">
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
                        <i class="fas fa-rotate me-2"></i>Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Simple form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editProductForm');
    
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
});

// Image preview function
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
</script>
@endpush
@endsection