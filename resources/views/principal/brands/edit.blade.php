@extends('principal.layouts.app')

@section('title', 'Edit Brand - Principal Dashboard')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="h2 mb-2">Edit Brand</h1>
        <p class="text-muted">Update brand information</p>
    </div>

    <!-- Form -->
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('principal.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Brand Name -->
                <div class="mb-3">
                    <label for="title" class="form-label">Brand Name *</label>
                    <input type="text" 
                           name="title" 
                           id="title"
                           value="{{ old('title', $brand->title) }}"
                           class="form-control"
                           placeholder="Enter brand name"
                           required>
                    @error('title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" 
                              id="description"
                              rows="4"
                              class="form-control"
                              placeholder="Enter brand description">{{ old('description', $brand->description) }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label for="category" class="form-label">Category *</label>
                    <select name="category" 
                            id="category"
                            class="form-select"
                            required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <!-- Parent Category -->
                            <option value="{{ $category->id }}" 
                                {{ old('category', $brand->category) == $category->id ? 'selected' : '' }}
                                class="fw-bold">
                                {{ $category->name }}
                            </option>
                            
                            <!-- Child Categories -->
                            @if($category->children->count() > 0)
                                @foreach($category->children as $child)
                                    <option value="{{ $child->id }}" 
                                        {{ old('category', $brand->category) == $child->id ? 'selected' : '' }}
                                        class="ps-4">
                                        └─ {{ $child->name }}
                                    </option>
                                    
                                    <!-- Grandchild Categories -->
                                    @if($child->children->count() > 0)
                                        @foreach($child->children as $grandchild)
                                            <option value="{{ $grandchild->id }}" 
                                                {{ old('category', $brand->category) == $grandchild->id ? 'selected' : '' }}
                                                class="ps-5">
                                                &nbsp;&nbsp;└─ {{ $grandchild->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                    @error('category')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Country -->
                <div class="mb-3">
                    <label for="country_id" class="form-label">Country *</label>
                    <select name="country_id" 
                            id="country_id"
                            class="form-select"
                            required>
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" 
                                {{ old('country_id', $brand->country_id) == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('country_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Website URL -->
                <div class="mb-3">
                    <label for="website_url" class="form-label">Website URL</label>
                    <input type="url" 
                           name="website_url" 
                           id="website_url"
                           value="{{ old('website_url', $brand->website_url) }}"
                           class="form-control"
                           placeholder="https://example.com">
                    @error('website_url')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Current Logo -->
                @if($brand->logo)
                <div class="mb-3">
                    <label class="form-label">Current Logo</label>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/brand/logo/' . $brand->logo) }}" 
                             alt="{{ $brand->title }}" 
                             class="img-thumbnail me-3" style="width: 80px; height: 80px;">
                        <div class="text-muted small">
                            <p class="mb-1">Current Logo</p>
                            <p class="mb-0">Upload a new logo to replace this one</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Brand Logo -->
                <div class="mb-3">
                    <label for="logo" class="form-label">
                        {{ $brand->logo ? 'Change Logo' : 'Brand Logo' }}
                    </label>
                    <input type="file" 
                           name="logo" 
                           id="logo"
                           accept="image/*"
                           class="form-control"
                           onchange="previewImage(this, 'logoPreview')">
                    @error('logo')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div id="logoPreview" class="mt-2 d-none">
                        <p class="text-muted small mb-2">New Logo Preview:</p>
                        <img id="logoPreviewImg" class="img-thumbnail" style="width: 80px; height: 80px;">
                    </div>
                    @if(!$brand->logo)
                        <p class="text-muted small mt-1">Recommended: Square image, 200x200 pixels or larger</p>
                    @endif
                </div>

                <!-- Current Image -->
                @if($brand->image)
                <div class="mb-3">
                    <label class="form-label">Current Image</label>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/brand/image/' . $brand->image) }}" 
                             alt="{{ $brand->title }}" 
                             class="img-thumbnail me-3" style="width: 150px; height: 100px;">
                        <div class="text-muted small">
                            <p class="mb-1">Current Brand Image</p>
                            <p class="mb-0">Upload a new image to replace this one</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Brand Image -->
                <div class="mb-4">
                    <label for="image" class="form-label">
                        {{ $brand->image ? 'Change Image' : 'Brand Image' }}
                    </label>
                    <input type="file" 
                           name="image" 
                           id="image"
                           accept="image/*"
                           class="form-control"
                           onchange="previewImage(this, 'imagePreview')">
                    @error('image')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div id="imagePreview" class="mt-2 d-none">
                        <p class="text-muted small mb-2">New Image Preview:</p>
                        <img id="imagePreviewImg" class="img-thumbnail" style="width: 150px;">
                    </div>
                    @if(!$brand->image)
                        <p class="text-muted small mt-1">Recommended: Landscape image, 1200x600 pixels or larger</p>
                    @endif
                </div>

                <!-- Current Status Display -->
                <div class="mb-4 p-3 bg-light rounded">
                    <label class="form-label">Current Status</label>
                    <div class="d-flex align-items-center">
                        <span class="badge 
                            @if($brand->status == 'approved') bg-success
                            @elseif($brand->status == 'pending') bg-warning text-dark
                            @elseif($brand->status == 'rejected') bg-danger
                            @else bg-secondary @endif">
                            {{ ucfirst($brand->status) }}
                        </span>
                        <span class="ms-2 text-muted small">
                            @if($brand->status == 'pending')
                                - Waiting for admin approval
                            @elseif($brand->status == 'approved')
                                - Approved and visible
                            @elseif($brand->status == 'rejected')
                                - Needs changes before resubmission
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <div class="d-flex">
                        <a href="{{ route('principal.brands.index') }}" 
                           class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Back to Brands
                        </a>
                        <button type="button" 
                                onclick="confirmDelete({{ $brand->id }})"
                                class="btn btn-outline-danger">
                            <i class="fas fa-trash me-2"></i>Delete
                        </button>
                    </div>
                    <button type="submit" 
                            class="btn btn-primary">
                        <i class="fas fa-rotate me-2"></i>Update Brand
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Status Info -->
    <div class="alert alert-warning mt-4">
        <div class="d-flex">
            <div class="me-3">
                <i class="fas fa-exclamation-triangle fa-lg mt-1"></i>
            </div>
            <div>
                <h5 class="alert-heading">Note: Status Reset</h5>
                <p class="mb-0">
                    Updating this brand will reset its status to "Pending" and require admin approval again.
                    This ensures all changes are reviewed before going live.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Form (Hidden) -->
<form id="deleteForm" action="{{ route('principal.brands.destroy', $brand->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

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

function confirmDelete(brandId) {
    if (confirm('Are you sure you want to delete this brand? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const categorySelect = document.getElementById('category');
    const countrySelect = document.getElementById('country_id');
    
    form.addEventListener('submit', function(e) {
        let valid = true;
        
        // Check required fields
        if (!categorySelect.value) {
            categorySelect.classList.add('is-invalid');
            valid = false;
        } else {
            categorySelect.classList.remove('is-invalid');
        }
        
        if (!countrySelect.value) {
            countrySelect.classList.add('is-invalid');
            valid = false;
        } else {
            countrySelect.classList.remove('is-invalid');
        }
        
        if (!valid) {
            e.preventDefault();
            alert('Please fill in all required fields (marked with *).');
        }
    });
    
    // Clear validation on change
    categorySelect.addEventListener('change', function() {
        if (this.value) this.classList.remove('is-invalid');
    });
    
    countrySelect.addEventListener('change', function() {
        if (this.value) this.classList.remove('is-invalid');
    });
});
</script>
@endpush
@endsection