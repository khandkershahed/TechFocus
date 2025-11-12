@extends('principal.layouts.app')

@section('title', 'Edit Product - Principal Dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Edit Product</h1>
        <p class="text-gray-600 mt-2">Update product information</p>
    </div>

    <!-- Debug Info -->
    @if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
        <h3 class="font-medium text-red-800">Validation Errors:</h3>
        <ul class="text-red-700 text-sm mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form id="editProductForm" action="{{ route('principal.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Basic Information</h3>
                
                <!-- Product Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           value="{{ old('name', $product->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                           placeholder="Enter product name"
                           required>
                </div>

                <!-- Product Code -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="sku_code" class="block text-sm font-medium text-gray-700 mb-2">SKU Code</label>
                        <input type="text" 
                               name="sku_code" 
                               id="sku_code"
                               value="{{ old('sku_code', $product->sku_code) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Enter SKU code">
                    </div>
                    <div>
                        <label for="product_code" class="block text-sm font-medium text-gray-700 mb-2">Product Code</label>
                        <input type="text" 
                               name="product_code" 
                               id="product_code"
                               value="{{ old('product_code', $product->product_code) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Enter product code">
                    </div>
                </div>

                <!-- Short Description -->
                <div class="mb-6">
                    <label for="short_desc" class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                    <textarea name="short_desc" 
                              id="short_desc"
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                              placeholder="Enter short description">{{ old('short_desc', $product->short_desc) }}</textarea>
                </div>

                <!-- Overview -->
                <div class="mb-6">
                    <label for="overview" class="block text-sm font-medium text-gray-700 mb-2">Overview</label>
                    <textarea name="overview" 
                              id="overview"
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                              placeholder="Enter product overview">{{ old('overview', $product->overview) }}</textarea>
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
                               value="{{ old('price', $product->price) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="0.00">
                    </div>
                    <div>
                        <label for="product_type" class="block text-sm font-medium text-gray-700 mb-2">Product Type *</label>
                        <select name="product_type" 
                                id="product_type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                required>
                            <option value="">Select Type</option>
                            <option value="software" {{ old('product_type', $product->product_type) == 'software' ? 'selected' : '' }}>Software</option>
                            <option value="hardware" {{ old('product_type', $product->product_type) == 'hardware' ? 'selected' : '' }}>Hardware</option>
                            <option value="service" {{ old('product_type', $product->product_type) == 'service' ? 'selected' : '' }}>Service</option>
                            <option value="other" {{ old('product_type', $product->product_type) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="price_status" class="block text-sm font-medium text-gray-700 mb-2">Price Status *</label>
                        <select name="price_status" 
                                id="price_status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
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
                <div class="mb-6">
                    <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-2">Brand *</label>
                    <select name="brand_id" 
                            id="brand_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
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
                <div class="mb-6">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select name="category_id" 
                            id="category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
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
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Thumbnail</label>
                <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                     alt="{{ $product->name }}" 
                     class="h-32 w-32 object-cover rounded-lg border">
            </div>
            @endif

            <!-- Thumbnail -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                    {{ $product->thumbnail ? 'Change Thumbnail' : 'Product Thumbnail' }}
                </h3>
                
                <div class="mb-6">
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $product->thumbnail ? 'Change Thumbnail' : 'Product Thumbnail *' }}
                    </label>
                    <input type="file" 
                           name="thumbnail" 
                           id="thumbnail"
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
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
                    <i class="fa-solid fa-rotate mr-2"></i>Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Replace the entire scripts section with this: -->
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
                field.classList.add('border-red-500');
            } else {
                field.classList.remove('border-red-500');
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
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}
</script>
@endpush
@endsection