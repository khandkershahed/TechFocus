@extends('principal.layouts.app')

@section('title', 'Add New Brand - Principal Dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Add New Brand</h1>
        <p class="text-gray-600 mt-2">Submit a new brand for admin approval</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('principal.brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Brand Name -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Brand Name *</label>
                <input type="text" 
                       name="title" 
                       id="title"
                       value="{{ old('title') }}"
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
                          placeholder="Enter brand description">{{ old('description') }}</textarea>
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
                    <option value="Top" {{ old('category') == 'Top' ? 'selected' : '' }}>Top</option>
                    <option value="Featured" {{ old('category') == 'Featured' ? 'selected' : '' }}>Featured</option>
                    <option value="Standard" {{ old('category') == 'Standard' ? 'selected' : '' }}>Standard</option>
                    <option value="Premium" {{ old('category') == 'Premium' ? 'selected' : '' }}>Premium</option>
                </select>
                @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Website URL -->
            <div class="mb-6">
                <label for="website_url" class="block text-sm font-medium text-gray-700 mb-2">Website URL</label>
                <input type="url" 
                       name="website_url" 
                       id="website_url"
                       value="{{ old('website_url') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="https://example.com">
                @error('website_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Country ID -->
            <div class="mb-6">
                <label for="country_id" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                <input type="number" 
                       name="country_id" 
                       id="country_id"
                       value="{{ old('country_id') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="Enter country ID">
                @error('country_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Brand Logo -->
            <div class="mb-6">
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Brand Logo</label>
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
                    <p class="text-sm text-gray-600 mb-2">Logo Preview:</p>
                    <img id="logoPreviewImg" class="h-20 w-20 object-cover rounded-lg border">
                </div>
            </div>

            <!-- Brand Image -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Brand Image</label>
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
                    <p class="text-sm text-gray-600 mb-2">Image Preview:</p>
                    <img id="imagePreviewImg" class="h-32 w-full object-cover rounded-lg border">
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('principal.brands.index') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Back to Brands
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                    <i class="fa-solid fa-paper-plane mr-2"></i>Submit for Approval
                </button>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fa-solid fa-info-circle text-blue-500 mt-1 mr-3"></i>
            <div>
                <h3 class="font-medium text-blue-800">Submission Process</h3>
                <p class="text-blue-700 text-sm mt-1">
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
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
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
                field.classList.add('border-red-500');
            } else {
                field.classList.remove('border-red-500');
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