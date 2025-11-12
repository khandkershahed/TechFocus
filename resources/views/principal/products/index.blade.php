@extends('principal.layouts.app')

@section('title', 'My Products - Principal Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">My Products</h1>
            <p class="text-gray-600 mt-2">Manage your product submissions</p>
        </div>
        <a href="{{ route('principal.products.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
            <i class="fa-solid fa-plus mr-2"></i>Add New Product
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <i class="fa-solid fa-cube text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Products</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $products->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <i class="fa-solid fa-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Approved</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $products->where('submission_status', 'approved')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Pending</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $products->where('submission_status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-500">
                    <i class="fa-solid fa-times text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Rejected</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $products->where('submission_status', 'rejected')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status & Pricing</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Info</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submission Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <!-- Product Details Column -->
                            <td class="px-6 py-4">
                                <div class="flex items-start space-x-4">
                                    @if($product->thumbnail)
                                        <div class="flex-shrink-0">
                                            <img class="h-16 w-16 rounded-lg object-cover border" 
                                                 src="{{ asset('storage/' . $product->thumbnail) }}" 
                                                 alt="{{ $product->name }}">
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fa-solid fa-cube text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</h4>
                                            @if($product->featured)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                    <i class="fa-solid fa-star mr-1 text-xs"></i>Featured
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($product->short_desc)
                                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($product->short_desc, 80) }}</p>
                                        @endif
                                        
                                        <div class="flex flex-wrap gap-1 text-xs">
                                            @if($product->sku_code)
                                                <span class="inline-flex items-center px-2 py-1 rounded bg-gray-100 text-gray-700">
                                                    <i class="fa-solid fa-barcode mr-1"></i>SKU: {{ $product->sku_code }}
                                                </span>
                                            @endif
                                            @if($product->product_code)
                                                <span class="inline-flex items-center px-2 py-1 rounded bg-gray-100 text-gray-700">
                                                    <i class="fa-solid fa-hashtag mr-1"></i>Code: {{ $product->product_code }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Status & Pricing Column -->
                            <td class="px-6 py-4">
                                <div class="space-y-2">
                                    <!-- Submission Status -->
                                    <div>
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($product->submission_status == 'approved') bg-green-100 text-green-800
                                            @elseif($product->submission_status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($product->submission_status == 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($product->submission_status) }}
                                        </span>
                                    </div>

                                    <!-- Product Status -->
                                    @if($product->product_status)
                                    <div>
                                        <span class="text-xs text-gray-500">Product Status:</span>
                                        <span class="text-xs font-medium text-gray-700 ml-1">{{ ucfirst($product->product_status) }}</span>
                                    </div>
                                    @endif

                                    <!-- Pricing -->
                                    <div class="space-y-1">
                                        @if($product->price)
                                            <div class="text-sm font-semibold text-gray-900">
                                                ${{ number_format($product->price, 2) }}
                                            </div>
                                        @endif
                                        
                                        @if($product->price_status)
                                            <div class="text-xs text-gray-500">
                                                <span class="font-medium">Price Type:</span> 
                                                <span class="capitalize">{{ str_replace('_', ' ', $product->price_status) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Rejection Reason -->
                                    @if($product->submission_status == 'rejected' && $product->rejection_reason)
                                    <div class="mt-2 p-2 bg-red-50 rounded border border-red-200">
                                        <div class="text-xs font-medium text-red-800 mb-1">Rejection Reason:</div>
                                        <div class="text-xs text-red-700">{{ $product->rejection_reason }}</div>
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Product Info Column -->
                            <td class="px-6 py-4">
                                <div class="space-y-2 text-sm">
                                    <!-- Product Type -->
                                    @if($product->product_type)
                                    <div>
                                        <span class="text-gray-500">Type:</span>
                                        <span class="font-medium text-gray-700 ml-1 capitalize">{{ $product->product_type }}</span>
                                    </div>
                                    @endif

                                    <!-- Brand -->
                                    @if($product->brand)
                                    <div>
                                        <span class="text-gray-500">Brand:</span>
                                        <span class="font-medium text-gray-700 ml-1">{{ $product->brand->title }}</span>
                                    </div>
                                    @endif

                                    <!-- Category -->
                                    @if($product->category)
                                    <div>
                                        <span class="text-gray-500">Category:</span>
                                        <span class="font-medium text-gray-700 ml-1">{{ $product->category->name }}</span>
                                    </div>
                                    @endif

                                    <!-- Overview Preview -->
                                    @if($product->overview)
                                    <div class="mt-2">
                                        <div class="text-gray-500 text-xs mb-1">Overview:</div>
                                        <div class="text-xs text-gray-600 line-clamp-2">{{ Str::limit($product->overview, 100) }}</div>
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Submission Details Column -->
                            <td class="px-6 py-4">
                                <div class="space-y-2 text-sm">
                                    <!-- Dates -->
                                    <div>
                                        <div class="text-gray-500 text-xs">Submitted:</div>
                                        <div class="text-xs font-medium text-gray-700">
                                            {{ $product->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $product->created_at->format('h:i A') }}
                                        </div>
                                    </div>

                                    <!-- Last Updated -->
                                    @if($product->updated_at != $product->created_at)
                                    <div>
                                        <div class="text-gray-500 text-xs">Last Updated:</div>
                                        <div class="text-xs text-gray-600">
                                            {{ $product->updated_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Email Verification -->
                                    @if($product->email_verified_at)
                                    <div class="flex items-center text-xs text-green-600">
                                        <i class="fa-solid fa-check-circle mr-1"></i>
                                        <span>Email Verified</span>
                                    </div>
                                    @endif

                                    <!-- Created By -->
                                    {{-- @if($product->created_by)
                                    <div class="text-xs text-gray-500">
                                        Created by: {{ $product->created_by == $principalId ? 'You' : 'Admin' }}
                                    </div>
                                    @endif --}}
                                </div>
                            </td>

                            <!-- Actions Column -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col space-y-2">
                                    <!-- View Details Button -->
                                    {{-- <button onclick="showProductDetails({{ $product->id }})"
                                            class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded text-sm transition duration-200 flex items-center justify-center">
                                        <i class="fa-solid fa-eye mr-1"></i>View Details
                                    </button> --}}
                                    <!-- In your table actions column, replace the View Details button with: -->
                                    <button onclick="showSimpleProductDetails({{ $product }})"
                                            class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded text-sm transition duration-200 flex items-center justify-center">
                                        <i class="fa-solid fa-eye mr-1"></i>View Details
                                    </button>
                                                                        <!-- Edit Button -->
                                    <a href="{{ route('principal.products.edit', $product->id) }}" 
                                       class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-2 rounded text-sm transition duration-200 flex items-center justify-center">
                                        <i class="fa-solid fa-edit mr-1"></i>Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('principal.products.destroy', $product->id) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-2 rounded text-sm transition duration-200 flex items-center justify-center"
                                                onclick="return confirm('Are you sure you want to delete this product?')">
                                            <i class="fa-solid fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- <!-- Pagination -->
            @if($products->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $products->links() }}
            </div>
            @endif --}}
        @else
            <div class="text-center py-12">
                <i class="fa-solid fa-cube text-5xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No products yet</h3>
                <p class="text-gray-500 mb-4">Start by adding your first product.</p>
                <a href="{{ route('principal.products.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition duration-200">
                    Add Your First Product
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Product Details Modal -->
<div id="productDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-xl font-bold text-gray-800">Product Details</h3>
                <button onclick="closeProductDetails()" class="text-gray-400 hover:text-gray-600">
                    <i class="fa-solid fa-times text-2xl"></i>
                </button>
            </div>
            
            <div id="productDetailsContent" class="mt-4 max-h-96 overflow-y-auto">
                <!-- Content will be loaded via AJAX -->
            </div>
            
            <div class="flex justify-end space-x-3 pt-4 mt-4 border-t">
                <button onclick="closeProductDetails()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition duration-200">
                    Close
                </button>
                <a id="editProductLink" href="#" 
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">
                    Edit Product
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush

@push('scripts')
<script>
function showSimpleProductDetails(product) {
    const modalContent = `
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <h4 class="font-semibold text-gray-800">Product Name</h4>
                    <p class="text-gray-900">${product.name}</p>
                </div>
                ${product.sku_code ? `
                <div>
                    <h4 class="font-semibold text-gray-800">SKU Code</h4>
                    <p class="text-gray-900">${product.sku_code}</p>
                </div>
                ` : ''}
                ${product.price ? `
                <div>
                    <h4 class="font-semibold text-gray-800">Price</h4>
                    <p class="text-2xl font-bold text-green-600">$${parseFloat(product.price).toFixed(2)}</p>
                </div>
                ` : ''}
            </div>
            <div class="space-y-4">
                <div>
                    <h4 class="font-semibold text-gray-800">Status</h4>
                    <span class="px-3 py-1 rounded-full text-sm ${
                        product.submission_status === 'approved' ? 'bg-green-100 text-green-800' :
                        product.submission_status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                        'bg-red-100 text-red-800'
                    }">
                        ${product.submission_status}
                    </span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Product Type</h4>
                    <p class="text-gray-900 capitalize">${product.product_type}</p>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('productDetailsContent').innerHTML = modalContent;
    document.getElementById('editProductLink').href = `/principal/products/${product.id}/edit`;
    document.getElementById('productDetailsModal').classList.remove('hidden');
}



// Make the function globally available
window.closeProductDetails = function() {
    console.log('closeProductDetails function called'); // Debug log
    const modal = document.getElementById('productDetailsModal');
    if (modal) {
        modal.classList.add('hidden');
        console.log('Modal hidden'); // Debug log
    }
}

// Alternative approach - use event delegation
document.addEventListener('click', function(e) {
    // Check if click is on close button or its icon
    if (e.target.closest('button') && e.target.closest('button').onclick && 
        e.target.closest('button').onclick.toString().includes('closeProductDetails')) {
        closeProductDetails();
    }
    
    // Also check for the close icon itself
    if (e.target.classList.contains('fa-times') && e.target.closest('button')) {
        closeProductDetails();
    }
});

// Close on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeProductDetails();
    }
});

// Close when clicking outside modal
document.addEventListener('click', function(e) {
    if (e.target.id === 'productDetailsModal') {
        closeProductDetails();
    }
});
</script>
@endpush