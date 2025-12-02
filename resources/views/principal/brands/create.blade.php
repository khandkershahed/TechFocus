@extends('principal.layouts.app')

@section('title', 'Add New Brand - Principal Dashboard')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="mb-4">
        <h1 class="h2 mb-2">Add New Brand</h1>
        <p class="text-muted">Submit a new brand for admin approval</p>
    </div>

    <!-- Form -->
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('principal.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Brand Name -->
                <div class="mb-3">
                    <label for="title" class="form-label">Brand Name *</label>
                    <input type="text" 
                           name="title" 
                           id="title"
                           value="{{ old('title') }}"
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
                              placeholder="Enter brand description">{{ old('description') }}</textarea>
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
                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}
                                class="fw-bold">
                                {{ $category->name }}
                            </option>
                            
                            <!-- Child Categories -->
                            @if($category->children->count() > 0)
                                @foreach($category->children as $child)
                                    <option value="{{ $child->id }}" {{ old('category') == $child->id ? 'selected' : '' }}
                                        class="ps-4">
                                        └─ {{ $child->name }}
                                    </option>
                                    
                                    <!-- Grandchild Categories -->
                                    @if($child->children->count() > 0)
                                        @foreach($child->children as $grandchild)
                                            <option value="{{ $grandchild->id }}" {{ old('category') == $grandchild->id ? 'selected' : '' }}
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
                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
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
                           value="{{ old('website_url') }}"
                           class="form-control"
                           placeholder="https://example.com">
                    @error('website_url')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Brand Logo -->
                <div class="mb-3">
                    <label for="logo" class="form-label">Brand Logo</label>
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
                        <p class="text-muted small mb-2">Logo Preview:</p>
                        <img id="logoPreviewImg" class="img-thumbnail" style="width: 80px; height: 80px;">
                    </div>
                </div>

                <!-- Brand Image -->
                <div class="mb-4">
                    <label for="image" class="form-label">Brand Image</label>
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
                        <p class="text-muted small mb-2">Image Preview:</p>
                        <img id="imagePreviewImg" class="img-thumbnail" style="width: 200px;">
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('principal.brands.index') }}" 
                       class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Brands
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
    <div class="mt-4 alert alert-info">
        <div class="d-flex">
            <div class="me-3">
                <i class="fas fa-info-circle fa-lg mt-1"></i>
            </div>
            <div>
                <h5 class="alert-heading">Submission Process</h5>
                <p class="mb-0">
                    Your brand submission will be reviewed by our admin team. 
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