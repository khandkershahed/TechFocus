@extends('principal.layouts.app')

@section('title', 'Add New Product - Principal Dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Add New Product</h1>
        <p class="text-gray-600 mt-2">Submit a new product for admin approval</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('principal.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Basic Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Basic Information</h3>
                
                <!-- Product Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                           placeholder="Enter product name"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Code -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="sku_code" class="block text-sm font-medium text-gray-700 mb-2">SKU Code</label>
                        <input type="text" 
                               name="sku_code" 
                               id="sku_code"
                               value="{{ old('sku_code') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Enter SKU code">
                        @error('sku_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="product_code" class="block text-sm font-medium text-gray-700 mb-2">Product Code</label>
                        <input type="text" 
                               name="product_code" 
                               id="product_code"
                               value="{{ old('product_code') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Enter product code">
                        @error('product_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Short Description -->
                <div class="mb-6">
                    <label for="short_desc" class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                    <textarea name="short_desc" 
                              id="short_desc"
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                              placeholder="Enter short description">{{ old('short_desc') }}</textarea>
                    @error('short_desc')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Overview -->
                <div class="mb-6">
                    <label for="overview" class="block text-sm font-medium text-gray-700 mb-2">Overview</label>
                    <textarea name="overview" 
                              id="overview"
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                              placeholder="Enter product overview">{{ old('overview') }}</textarea>
                    @error('overview')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Pricing & Details -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Pricing & Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                        <input type="number" 
                               name="price" 
                               id="price"
                               step="0.01"
                               value="{{ old('price') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="0.00">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="product_type" class="block text-sm font-medium text-gray-700 mb-2">Product Type *</label>
                        <select name="product_type" 
                                id="product_type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                required>
                            <option value="">Select Type</option>
                            <option value="software" {{ old('product_type') == 'software' ? 'selected' : '' }}>Software</option>
                            <option value="hardware" {{ old('product_type') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                            <option value="service" {{ old('product_type') == 'service' ? 'selected' : '' }}>Service</option>
                            <option value="other" {{ old('product_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('product_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="price_status" class="block text-sm font-medium text-gray-700 mb-2">Price Status *</label>
                        <select name="price_status" 
                                id="price_status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                required>
                            <option value="">Select Status</option>
                            <option value="price" {{ old('price_status') == 'price' ? 'selected' : '' }}>Price</option>
                            <option value="rfq" {{ old('price_status') == 'rfq' ? 'selected' : '' }}>RFQ</option>
                            <option value="offer_price" {{ old('price_status') == 'offer_price' ? 'selected' : '' }}>Offer Price</option>
                            <option value="starting_price" {{ old('price_status') == 'starting_price' ? 'selected' : '' }}>Starting Price</option>
                        </select>
                        @error('price_status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Thumbnail -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Product Image</h3>
                
                <div class="mb-6">
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">Product Thumbnail *</label>
                    <input type="file" 
                           name="thumbnail" 
                           id="thumbnail"
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                           onchange="previewImage(this, 'thumbnailPreview')"
                           required>
                    @error('thumbnail')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div id="thumbnailPreview" class="mt-2 hidden">
                        <p class="text-sm text-gray-600 mb-2">Thumbnail Preview:</p>
                        <img id="thumbnailPreviewImg" class="h-32 w-32 object-cover rounded-lg border">
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('principal.products.index') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Back to Products
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