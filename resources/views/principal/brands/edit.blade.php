@extends('principal.layouts.app')

@section('title', 'Edit Brand - Principal Dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Edit Brand</h1>
        <p class="text-gray-600 mt-2">Update brand information</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('principal.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Brand Name -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Brand Name *</label>
                <input type="text" 
                       name="title" 
                       id="title"
                       value="{{ old('title', $brand->title) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="Enter brand name"
                       required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" 
                          id="description"
                          rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                          placeholder="Enter brand description">{{ old('description', $brand->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <select name="category" 
                        id="category"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <!-- Parent Category -->
                        <option value="{{ $category->id }}" 
                            {{ old('category', $brand->category) == $category->id ? 'selected' : '' }}
                            class="font-semibold text-gray-800 bg-gray-100">
                            {{ $category->name }}
                        </option>
                        
                        <!-- Child Categories -->
                        @if($category->children->count() > 0)
                            @foreach($category->children as $child)
                                <option value="{{ $child->id }}" 
                                    {{ old('category', $brand->category) == $child->id ? 'selected' : '' }}
                                    class="pl-6 text-gray-600">
                                    └─ {{ $child->name }}
                                </option>
                                
                                <!-- Grandchild Categories -->
                                @if($child->children->count() > 0)
                                    @foreach($child->children as $grandchild)
                                        <option value="{{ $grandchild->id }}" 
                                            {{ old('category', $brand->category) == $grandchild->id ? 'selected' : '' }}
                                            class="pl-10 text-gray-500">
                                            &nbsp;&nbsp;└─ {{ $grandchild->name }}
                                        </option>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </select>
                @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Country -->
            <div class="mb-6">
                <label for="country_id" class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                <select name="country_id" 
                        id="country_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
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
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Website URL -->
            <div class="mb-6">
                <label for="website_url" class="block text-sm font-medium text-gray-700 mb-2">Website URL</label>
                <input type="url" 
                       name="website_url" 
                       id="website_url"
                       value="{{ old('website_url', $brand->website_url) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="https://example.com">
                @error('website_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Logo -->
            @if($brand->logo)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Logo</label>
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('storage/brand/logo/' . $brand->logo) }}" 
                         alt="{{ $brand->title }}" 
                         class="h-20 w-20 object-cover rounded-lg border">
                    <div class="text-sm text-gray-600">
                        <p class="font-medium">Current Logo</p>
                        <p class="text-xs mt-1">Upload a new logo to replace this one</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Brand Logo -->
            <div class="mb-6">
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $brand->logo ? 'Change Logo' : 'Brand Logo' }}
                </label>
                <input type="file" 
                       name="logo" 
                       id="logo"
                       accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       onchange="previewImage(this, 'logoPreview')">
                @error('logo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div id="logoPreview" class="mt-2 hidden">
                    <p class="text-sm text-gray-600 mb-2">New Logo Preview:</p>
                    <img id="logoPreviewImg" class="h-20 w-20 object-cover rounded-lg border">
                </div>
                @if(!$brand->logo)
                    <p class="text-xs text-gray-500 mt-1">Recommended: Square image, 200x200 pixels or larger</p>
                @endif
            </div>

            <!-- Current Image -->
            @if($brand->image)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('storage/brand/image/' . $brand->image) }}" 
                         alt="{{ $brand->title }}" 
                         class="h-32 w-48 object-cover rounded-lg border">
                    <div class="text-sm text-gray-600">
                        <p class="font-medium">Current Brand Image</p>
                        <p class="text-xs mt-1">Upload a new image to replace this one</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Brand Image -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $brand->image ? 'Change Image' : 'Brand Image' }}
                </label>
                <input type="file" 
                       name="image" 
                       id="image"
                       accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       onchange="previewImage(this, 'imagePreview')">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <div id="imagePreview" class="mt-2 hidden">
                    <p class="text-sm text-gray-600 mb-2">New Image Preview:</p>
                    <img id="imagePreviewImg" class="h-32 w-full object-cover rounded-lg border">
                </div>
                @if(!$brand->image)
                    <p class="text-xs text-gray-500 mt-1">Recommended: Landscape image, 1200x600 pixels or larger</p>
                @endif
            </div>

            <!-- Current Status Display -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                <div class="flex items-center">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        @if($brand->status == 'approved') bg-green-100 text-green-800
                        @elseif($brand->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($brand->status == 'rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($brand->status) }}
                    </span>
                    <span class="ml-2 text-sm text-gray-600">
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
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="flex space-x-3">
                    <a href="{{ route('principal.brands.index') }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Back to Brands
                    </a>
                    <button type="button" 
                            onclick="confirmDelete({{ $brand->id }})"
                            class="px-6 py-2 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 transition duration-200">
                        <i class="fa-solid fa-trash mr-2"></i>Delete
                    </button>
                </div>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                    <i class="fa-solid fa-rotate mr-2"></i>Update Brand
                </button>
            </div>
        </form>
    </div>

    <!-- Status Info -->
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fa-solid fa-exclamation-triangle text-yellow-500 mt-1 mr-3"></i>
            <div>
                <h3 class="font-medium text-yellow-800">Note: Status Reset</h3>
                <p class="text-yellow-700 text-sm mt-1">
                    Updating this brand will reset its status to "Pending" and require admin approval again.
                    This ensures all changes are reviewed before going live.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Form (Hidden) -->
<form id="deleteForm" action="{{ route('principal.brands.destroy', $brand->id) }}" method="POST" class="hidden">
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
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
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
            categorySelect.classList.add('border-red-500');
            valid = false;
        } else {
            categorySelect.classList.remove('border-red-500');
        }
        
        if (!countrySelect.value) {
            countrySelect.classList.add('border-red-500');
            valid = false;
        } else {
            countrySelect.classList.remove('border-red-500');
        }
        
        if (!valid) {
            e.preventDefault();
            alert('Please fill in all required fields (marked with *).');
        }
    });
    
    // Clear validation on change
    categorySelect.addEventListener('change', function() {
        if (this.value) this.classList.remove('border-red-500');
    });
    
    countrySelect.addEventListener('change', function() {
        if (this.value) this.classList.remove('border-red-500');
    });
});
</script>
@endpush
@endsection