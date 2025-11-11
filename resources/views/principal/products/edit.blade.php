@extends('principal.layouts.app')

@section('title', 'Edit Product - Principal Dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Edit Product</h1>
        <p class="text-gray-600 mt-2">Update product information</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('principal.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
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
                               value="{{ old('sku_code', $product->sku_code) }}"
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
                               value="{{ old('product_code', $product->product_code) }}"
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
                              placeholder="Enter short description">{{ old('short_desc', $product->short_desc) }}</textarea>
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
                              placeholder="Enter product overview">{{ old('overview', $product->overview) }}</textarea>
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
                               value="{{ old('price', $product->price) }}"
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
                            <option value="software" {{ old('product_type', $product->product_type) == 'software' ? 'selected' : '' }}>Software</option>
                            <option value="hardware" {{ old('product_type', $product->product_type) == 'hardware' ? 'selected' : '' }}>Hardware</option>
                            <option value="service" {{ old('product_type', $product->product_type) == 'service' ? 'selected' : '' }}>Service</option>
                            <option value="other" {{ old('product_type', $product->product_type) == 'other' ? 'selected' : '' }}>Other</option>
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
                            <option value="price" {{ old('price_status', $product->price_status) == 'price' ? 'selected' : '' }}>Price</option>
                            <option value="rfq" {{ old('price_status', $product->price_status) == 'rfq' ? 'selected' : '' }}>RFQ</option>
                            <option value="offer_price" {{ old('price_status', $product->price_status) == 'offer_price' ? 'selected' : '' }}>Offer Price</option>
                            <option value="starting_price" {{ old('price_status', $product->price_status) == 'starting_price' ? 'selected' : '' }}>Starting Price</option>
                        </select>
                        @error('price_status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
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
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                           onchange="previewImage(this, 'thumbnailPreview')"
                           {{ $product->thumbnail ? '' : 'required' }}>
                    @error('thumbnail')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div id="thumbnailPreview" class="mt-2 hidden">
                        <p class="text-sm text-gray-600 mb-2">New Thumbnail Preview:</p>
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
                    <i class="fa-solid fa-rotate mr-2"></i>Update Product
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
                    Updating this product will reset its status to "Pending" and require admin approval again.
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelector("form").addEventListener("submit", function(e) {
    e.preventDefault();

    let form = this;
    let action = form.action;
    let formData = new FormData(form);

    fetch(action, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "X-Requested-With": "XMLHttpRequest"
        },
        body: formData
    })
    .then(res => {
        // Laravel responds with JSON even if response is not parsed correctly
        return res.text();
    })
    .then(text => {
        let data = {};

        try {
            data = JSON.parse(text); // ✅ Prevent JSON showing in browser
        } catch (e) {
            console.log("Non-JSON response:", text);
            return;
        }

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: data.message,
                timer: 1200,
                showConfirmButton: false
            });

            setTimeout(() => {
                window.location.href = data.redirect_url;
            }, 1200);

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.error || 'Something went wrong'
            });
        }
    })
    .catch(error => console.error(error));
});

</script>
@endpush

@endsection