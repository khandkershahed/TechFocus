<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Left Column - Basic Info -->
    <div class="space-y-6">
        <!-- Product Image -->
        <div>
            <h4 class="text-lg font-semibold text-gray-800 mb-3">Product Image</h4>
            @if($product->thumbnail && Storage::exists('public/' . $product->thumbnail))
                <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-64 object-cover rounded-lg border">
            @else
                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-cube text-4xl text-gray-400"></i>
                    <span class="ml-2 text-gray-500">No image available</span>
                </div>
            @endif
        </div>

        <!-- Basic Information -->
        <div>
            <h4 class="text-lg font-semibold text-gray-800 mb-3">Basic Information</h4>
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-medium text-gray-500">Product Name</label>
                    <p class="text-gray-900 font-semibold">{{ $product->name }}</p>
                </div>
                
                @if($product->sku_code)
                <div>
                    <label class="text-sm font-medium text-gray-500">SKU Code</label>
                    <p class="text-gray-900">{{ $product->sku_code }}</p>
                </div>
                @endif
                
                @if($product->product_code)
                <div>
                    <label class="text-sm font-medium text-gray-500">Product Code</label>
                    <p class="text-gray-900">{{ $product->product_code }}</p>
                </div>
                @endif
                
                @if($product->short_desc)
                <div>
                    <label class="text-sm font-medium text-gray-500">Short Description</label>
                    <p class="text-gray-900">{{ $product->short_desc }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column - Details -->
    <div class="space-y-6">
        <!-- Pricing Information -->
        <div>
            <h4 class="text-lg font-semibold text-gray-800 mb-3">Pricing Information</h4>
            <div class="space-y-3">
                @if($product->price)
                <div>
                    <label class="text-sm font-medium text-gray-500">Price</label>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($product->price, 2) }}</p>
                </div>
                @endif
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Price Status</label>
                    <p class="text-gray-900 capitalize">{{ str_replace('_', ' ', $product->price_status) }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Product Type</label>
                    <p class="text-gray-900 capitalize">{{ $product->product_type }}</p>
                </div>
            </div>
        </div>

        <!-- Category & Brand -->
        <div>
            <h4 class="text-lg font-semibold text-gray-800 mb-3">Category & Brand</h4>
            <div class="space-y-3">
                @if($product->brand)
                <div>
                    <label class="text-sm font-medium text-gray-500">Brand</label>
                    <p class="text-gray-900">{{ $product->brand->title }}</p>
                </div>
                @endif
                
                @if($product->category)
                <div>
                    <label class="text-sm font-medium text-gray-500">Category</label>
                    <p class="text-gray-900">{{ $product->category->name }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Status Information -->
        <div>
            <h4 class="text-lg font-semibold text-gray-800 mb-3">Status Information</h4>
            <div class="space-y-3">
                <div>
                    <label class="text-sm font-medium text-gray-500">Submission Status</label>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        @if($product->submission_status == 'approved') bg-green-100 text-green-800
                        @elseif($product->submission_status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($product->submission_status == 'rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($product->submission_status) }}
                    </span>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500">Product Status</label>
                    <p class="text-gray-900 capitalize">{{ $product->product_status ?? 'Not specified' }}</p>
                </div>
                
                @if($product->submission_status == 'rejected' && $product->rejection_reason)
                <div>
                    <label class="text-sm font-medium text-gray-500">Rejection Reason</label>
                    <div class="mt-1 p-3 bg-red-50 border border-red-200 rounded">
                        <p class="text-red-700">{{ $product->rejection_reason }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Overview -->
        @if($product->overview)
        <div>
            <h4 class="text-lg font-semibold text-gray-800 mb-3">Product Overview</h4>
            <div class="p-3 bg-gray-50 rounded border">
                <p class="text-gray-700 leading-relaxed">{{ $product->overview }}</p>
            </div>
        </div>
        @endif

        <!-- Timestamps -->
        <div>
            <h4 class="text-lg font-semibold text-gray-800 mb-3">Timestamps</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Created:</span>
                    <span class="text-gray-900">{{ $product->created_at->format('M d, Y h:i A') }}</span>
                </div>
                
                @if($product->updated_at != $product->created_at)
                <div class="flex justify-between">
                    <span class="text-gray-500">Last Updated:</span>
                    <span class="text-gray-900">{{ $product->updated_at->format('M d, Y h:i A') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>