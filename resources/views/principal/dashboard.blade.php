@extends('principal.layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Welcome Principal, {{ auth('principal')->user()->name }}</h1>
    <form method="POST" action="{{ route('principal.logout') }}">
        @csrf
        <button type="submit" 
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition duration-200">
            Logout
        </button>
    </form>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Brands Stats -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <i class="fa-solid fa-store text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Brands</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_brands'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fa-solid fa-check text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Approved Brands</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['approved_brands'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <i class="fa-solid fa-clock text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Pending Brands</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_brands'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-500">
                <i class="fa-solid fa-times text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Rejected Brands</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['rejected_brands'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Products Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                <i class="fa-solid fa-cube text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Products</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <i class="fa-solid fa-check text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Approved Products</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['approved_products'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <i class="fa-solid fa-clock text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Pending Products</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_products'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-500">
                <i class="fa-solid fa-times text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Rejected Products</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['rejected_products'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('principal.brands.create') }}" 
               class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition duration-200">
                <i class="fa-solid fa-plus text-blue-600 mr-3"></i>
                <span>Add New Brand</span>
            </a>
            <a href="{{ route('principal.products.create') }}" 
               class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-indigo-50 hover:border-indigo-200 transition duration-200">
                <i class="fa-solid fa-plus text-indigo-600 mr-3"></i>
                <span>Add New Product</span>
            </a>
            <a href="{{ route('principal.brands.index') }}" 
               class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-200 transition duration-200">
                <i class="fa-solid fa-list text-green-600 mr-3"></i>
                <span>View All Brands</span>
            </a>
            <a href="{{ route('principal.products.index') }}" 
               class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-200 transition duration-200">
                <i class="fa-solid fa-list text-green-600 mr-3"></i>
                <span>View All Products</span>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Submission Guidelines</h3>
        <ul class="space-y-2 text-sm text-gray-600">
            <li class="flex items-start">
                <i class="fa-solid fa-check text-green-500 mr-2 mt-1"></i>
                <span>Ensure information is accurate and complete</span>
            </li>
            <li class="flex items-start">
                <i class="fa-solid fa-check text-green-500 mr-2 mt-1"></i>
                <span>Upload high-quality images</span>
            </li>
            <li class="flex items-start">
                <i class="fa-solid fa-check text-green-500 mr-2 mt-1"></i>
                <span>Provide valid details and pricing</span>
            </li>
            <li class="flex items-start">
                <i class="fa-solid fa-check text-green-500 mr-2 mt-1"></i>
                <span>Submissions require admin approval before going live</span>
            </li>
        </ul>
    </div>
</div>

<!-- Recent Submissions -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Brands -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Recent Brands</h2>
        </div>
        <div class="p-6">
            @if($brands->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Brand Name
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($brands->take(5) as $brand)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($brand->logo)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ asset('storage/brand/logo/'.$brand->logo) }}" 
                                                 alt="{{ $brand->title }}">
                                        </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $brand->title }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($brand->status == 'approved') bg-green-100 text-green-800
                                        @elseif($brand->status == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($brand->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $brand->category }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('principal.brands.edit', $brand->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($brands->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('principal.brands.index') }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            View All Brands →
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <i class="fa-solid fa-store text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No brands submitted yet.</p>
                    <a href="{{ route('principal.brands.create') }}" 
                       class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition duration-200">
                        Add Your First Brand
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Products -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Recent Products</h2>
        </div>
        <div class="p-6">
            @if($products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product Name
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($products->take(5) as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($product->thumbnail)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded object-cover" 
                                                 src="{{ asset('storage/' . $product->thumbnail) }}" 
                                                 alt="{{ $product->name }}">
                                        </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $product->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($product->submission_status == 'approved') bg-green-100 text-green-800
                                        @elseif($product->submission_status == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($product->submission_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($product->price)
                                        ${{ number_format($product->price, 2) }}
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('principal.products.edit', $product->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($products->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('principal.products.index') }}" 
                           class="text-indigo-600 hover:text-indigo-800 font-medium">
                            View All Products →
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <i class="fa-solid fa-cube text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No products submitted yet.</p>
                    <a href="{{ route('principal.products.create') }}" 
                       class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition duration-200">
                        Add Your First Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection