@extends('principal.layouts.app')

@section('content')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth shadow transitions */
.shadow-md {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

/* Custom gradient backgrounds */
.bg-gradient-to-br {
    background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
}
</style>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Welcome Principal, {{ auth('principal')->user()->legal_name }}</h1>
    
    <div class="flex gap-3">
        <a href="{{ route('principal.profile.edit') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded transition duration-200">
            Edit Profile
        </a>

        <form method="POST" action="{{ route('principal.logout') }}" class="inline-block">
            @csrf
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded transition duration-200">
                Logout
            </button>
        </form>
    </div>
</div>
    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Principal Info Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Company Profile</h2>
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-building text-white text-sm"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Legal Name</span>
                        <span class="text-sm font-medium text-gray-900">{{ $principal->legal_name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Trading Name</span>
                        <span class="text-sm font-medium text-gray-900">{{ $principal->trading_name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Entity Type</span>
                        <span class="text-sm font-medium text-gray-900">{{ $principal->entity_type ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            @if($principal->relationship_status == 'Active') bg-green-100 text-green-800
                            @elseif($principal->relationship_status == 'Prospect') bg-yellow-100 text-yellow-800
                            @elseif($principal->relationship_status == 'Dormant') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $principal->relationship_status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Activity Summary Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Activity Summary</h2>
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-teal-600 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-chart-line text-white text-sm"></i>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['total_brands'] }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Brands</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['total_products'] }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Products</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['approved_brands'] }}</div>
                        <div class="text-sm text-gray-600 mt-1">Approved Brands</div>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-xl">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['approved_products'] }}</div>
                        <div class="text-sm text-gray-600 mt-1">Approved Products</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Stats Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Brands Stats -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Brands Overview</h3>
                    <i class="fa-solid fa-store text-gray-400"></i>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fa-solid fa-layer-group text-white text-xs"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Total Brands</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900">{{ $stats['total_brands'] }}</span>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-3">
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <div class="text-lg font-bold text-green-600">{{ $stats['approved_brands'] }}</div>
                            <div class="text-xs text-gray-600 mt-1">Approved</div>
                        </div>
                        <div class="text-center p-3 bg-yellow-50 rounded-lg">
                            <div class="text-lg font-bold text-yellow-600">{{ $stats['pending_brands'] }}</div>
                            <div class="text-xs text-gray-600 mt-1">Pending</div>
                        </div>
                        <div class="text-center p-3 bg-red-50 rounded-lg">
                            <div class="text-lg font-bold text-red-600">{{ $stats['rejected_brands'] }}</div>
                            <div class="text-xs text-gray-600 mt-1">Rejected</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Stats -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Products Overview</h3>
                    <i class="fa-solid fa-cube text-gray-400"></i>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-indigo-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fa-solid fa-boxes-stacked text-white text-xs"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Total Products</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900">{{ $stats['total_products'] }}</span>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-3">
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <div class="text-lg font-bold text-green-600">{{ $stats['approved_products'] }}</div>
                            <div class="text-xs text-gray-600 mt-1">Approved</div>
                        </div>
                        <div class="text-center p-3 bg-yellow-50 rounded-lg">
                            <div class="text-lg font-bold text-yellow-600">{{ $stats['pending_products'] }}</div>
                            <div class="text-xs text-gray-600 mt-1">Pending</div>
                        </div>
                        <div class="text-center p-3 bg-red-50 rounded-lg">
                            <div class="text-lg font-bold text-red-600">{{ $stats['rejected_products'] }}</div>
                            <div class="text-xs text-gray-600 mt-1">Rejected</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contacts & Addresses Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Contacts Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Contacts</h3>
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $principal->contacts->count() }} contacts
                    </span>
                </div>
                
                @if($principal->contacts->count())
                    <div class="space-y-4">
                        @foreach($principal->contacts as $contact)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-white text-sm font-medium">
                                            {{ substr($contact->contact_name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900">{{ $contact->contact_name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $contact->job_title ?? 'No title' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-900">{{ $contact->email ?? '—' }}</p>
                                    <p class="text-xs text-gray-500">{{ $contact->phone_e164 ?? '—' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fa-solid fa-users text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">No contacts available</p>
                    </div>
                @endif
            </div>

            <!-- Addresses Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Addresses</h3>
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $principal->addresses->count() }} addresses
                    </span>
                </div>
                
                @if($principal->addresses->count())
                    <div class="space-y-4">
                        @foreach($principal->addresses as $address)
                            <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $address->type }}
                                    </span>
                                    <i class="fa-solid fa-location-dot text-gray-400"></i>
                                </div>
                                <p class="text-sm text-gray-900 font-medium mb-1">
                                    {{ $address->line1 }}
                                    @if($address->line2)
                                        <br>{{ $address->line2 }}
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $address->city ?? '—' }}, 
                                    {{ $address->country_name ? ucwords(strtolower($address->country_name)) : '—' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fa-solid fa-map-marker-alt text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">No addresses available</p>
                    </div>
                @endif
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
        <ul class="space-y-2 text-sm text-gray-700">
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
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
                    <p class="text-gray-700">No brands submitted yet.</p>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    @if($product->price)
                                        ${{ number_format($product->price, 2) }}
                                    @else
                                        <span class="text-gray-500">N/A</span>
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
                    <p class="text-gray-700">No products submitted yet.</p>
                    <a href="{{ route('principal.products.create') }}" 
                       class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition duration-200">
                        Add Your First Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>


{{-- <!-- Principal Links -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
    
        <div class="flex gap-3">
            <a href="{{ route('principal.links.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">
                Add Your Links
            </a>

            <a href="{{ route('principal.links.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition duration-200">
                View Your All Links
            </a>
        </div>
    </div>

    @if($principal->links->count())
        <ul class="list-disc list-inside space-y-2">
            @foreach($principal->links as $link)
                @php
                    // Decode JSON if stored as JSON
                    $labels = is_string($link->label) ? json_decode($link->label, true) : $link->label;
                    $urls   = is_string($link->url) ? json_decode($link->url, true) : $link->url;
                @endphp

                @foreach($labels as $i => $lbl)
                    <li>
                        <a href="{{ $urls[$i] ?? '#' }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $lbl }}
                        </a>
                    </li>
                @endforeach
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">No shared links yet.</p>
    @endif
</div> --}}
<!-- Enhanced Principal Links Section -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8 hover:shadow-xl transition-all duration-300">
    <!-- Header with Gradient Background -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 mb-6 border border-blue-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-md">
                    <i class="fa-solid fa-link text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Quick Links & Resources</h2>
                    <p class="text-sm text-gray-600 mt-1">Share and manage your important links</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 bg-white rounded-full text-sm font-medium text-blue-600 border border-blue-200 shadow-sm">
                    {{ $principal->links->count() }} {{ Str::plural('Link', $principal->links->count()) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('principal.links.create') }}" 
           class="group inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
            <i class="fa-solid fa-plus mr-2 group-hover:scale-110 transition-transform"></i>
            Add New Links
        </a>

        <a href="{{ route('principal.links.index') }}" 
           class="group inline-flex items-center px-5 py-3 bg-white text-gray-700 font-semibold rounded-xl border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-300 shadow-sm hover:shadow-md">
            <i class="fa-solid fa-list mr-2 text-indigo-600"></i>
            Manage All Links
        </a>
    </div>

    <!-- Links Grid -->
    @if($principal->links->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($principal->links as $linkIndex => $link)
                @php
                    $labels = is_string($link->label) ? json_decode($link->label, true) : $link->label;
                    $urls = is_string($link->url) ? json_decode($link->url, true) : $link->url;
                    $colors = ['blue', 'green', 'purple', 'orange', 'pink', 'indigo'];
                    $colorClasses = [
                        'blue' => 'from-blue-400 to-blue-500',
                        'green' => 'from-green-400 to-green-500',
                        'purple' => 'from-purple-400 to-purple-500',
                        'orange' => 'from-orange-400 to-orange-500',
                        'pink' => 'from-pink-400 to-pink-500',
                        'indigo' => 'from-indigo-400 to-indigo-500'
                    ];
                @endphp

                @foreach($labels as $i => $label)
                    @php
                        $colorIndex = ($linkIndex + $i) % count($colors);
                        $color = $colors[$colorIndex];
                        $gradientClass = $colorClasses[$color];
                    @endphp

                    <div class="group relative bg-gradient-to-br from-white to-gray-50 rounded-xl border border-gray-200 p-4 hover:border-{{ $color }}-300 hover:shadow-md transition-all duration-300">
                        <!-- Link Icon -->
                        <div class="flex items-start justify-between mb-3">
                            <div class="p-2 bg-gradient-to-br {{ $gradientClass }} rounded-lg shadow-sm">
                                <i class="fa-solid fa-link text-white text-sm"></i>
                            </div>
                        </div>

                        <!-- Link Content -->
                        <div class="space-y-2">
                            <h3 class="font-semibold text-gray-800 text-sm line-clamp-2 group-hover:text-{{ $color }}-600 transition-colors">
                                {{ $label }}
                            </h3>
                            
                            @if(isset($urls[$i]) && $urls[$i])
                                <div class="flex items-center justify-between">
                                    <a href="{{ $urls[$i] }}" 
                                       target="_blank" 
                                       class="text-xs text-gray-500 hover:text-{{ $color }}-600 transition-colors truncate flex-1 mr-2">
                                        {{ \Illuminate\Support\Str::limit($urls[$i], 40) }}
                                    </a>
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-{{ $color }}-50 text-{{ $color }}-600 border border-{{ $color }}-200">
                                            <i class="fa-solid fa-external-link mr-1 text-xs"></i>
                                            Visit
                                        </span>
                                    </div>
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">No URL provided</span>
                            @endif
                        </div>

                        <!-- Hover Effect Border -->
                        <div class="absolute inset-0 rounded-xl border-2 border-transparent group-hover:border-{{ $color }}-200 transition-all duration-300 pointer-events-none"></div>
                    </div>
                @endforeach
            @endforeach
        </div>

        <!-- Links Summary -->
        <div class="mt-6 pt-4 border-t border-gray-200">
            <div class="flex flex-wrap items-center justify-between text-sm text-gray-600">
                <div class="flex items-center space-x-4">
                    <span class="flex items-center">
                        <i class="fa-solid fa-layer-group mr-2 text-blue-500"></i>
                        {{ $principal->links->count() }} {{ Str::plural('Link Set', $principal->links->count()) }}
                    </span>
                    <span class="flex items-center">
                        <i class="fa-solid fa-link mr-2 text-green-500"></i>
                        {{ array_reduce($principal->links->toArray(), function($carry, $link) {
                            $labels = is_string($link['label']) ? json_decode($link['label'], true) : $link['label'];
                            return $carry + count($labels);
                        }, 0) }} Total Links
                    </span>
                </div>
                <a href="{{ route('principal.links.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium transition-colors">
                    View Detailed Analytics
                    <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center">
                    <i class="fa-solid fa-link text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No Links Added Yet</h3>
                <p class="text-gray-500 mb-6">Start by adding your important links and resources to share with your team.</p>
                <a href="{{ route('principal.links.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Create Your First Link Set
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Activity & Notes Section -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Activity & Notes Timeline</h2>
        <button onclick="toggleNoteForm()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded transition duration-200">
            <i class="fa-solid fa-plus mr-2"></i>Add Note
        </button>
    </div>

    <!-- Rich Text Note Form (Initially Hidden) -->
    <div id="noteFormContainer" class="mb-6 p-4 border border-gray-200 rounded-lg hidden">
        <form id="noteForm" action="{{ route('principal.notes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Note Type</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="note" class="text-blue-600 focus:ring-blue-500" checked>
                        <span class="ml-2 text-sm text-gray-700">General Note</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="important" class="text-red-600 focus:ring-red-500">
                        <span class="ml-2 text-sm text-gray-700">Important</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="task" class="text-green-600 focus:ring-green-500">
                        <span class="ml-2 text-sm text-gray-700">Task</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label for="richNote" class="block text-sm font-medium text-gray-700 mb-2">Your Note</label>
                <div class="border border-gray-300 rounded-lg">
                    <!-- Rich Text Toolbar -->
                    <div class="flex items-center space-x-1 p-2 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                        <button type="button" class="p-1 hover:bg-gray-200 rounded" onclick="formatText('bold')">
                            <i class="fa-solid fa-bold text-sm"></i>
                        </button>
                        <button type="button" class="p-1 hover:bg-gray-200 rounded" onclick="formatText('italic')">
                            <i class="fa-solid fa-italic text-sm"></i>
                        </button>
                        <button type="button" class="p-1 hover:bg-gray-200 rounded" onclick="formatText('underline')">
                            <i class="fa-solid fa-underline text-sm"></i>
                        </button>
                        <div class="w-px h-6 bg-gray-300 mx-1"></div>
                        <button type="button" class="p-1 hover:bg-gray-200 rounded" onclick="insertMention()">
                            <i class="fa-solid fa-at text-sm"></i>
                        </button>
                        <button type="button" class="p-1 hover:bg-gray-200 rounded" onclick="insertLink()">
                            <i class="fa-solid fa-link text-sm"></i>
                        </button>
                    </div>
                    <!-- Rich Text Area -->
                    <textarea 
                        id="richNote" 
                        name="note" 
                        rows="4" 
                        class="w-full px-3 py-2 border-0 focus:outline-none focus:ring-0 resize-none rounded-b-lg"
                        placeholder="Type your note here... Use @ to mention team members or # to add tags"
                        oninput="handleInput(this)"
                    ></textarea>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-xs text-gray-500">
                        <span id="charCount">0</span>/2000 characters
                    </span>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="pin" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Pin this note</span>
                        </label>
                        <button type="button" onclick="toggleNoteForm()" class="text-sm text-gray-600 hover:text-gray-800">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>

            <!-- File Upload Section -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Attachments</label>
                
                <!-- Link Input -->
                <div class="mb-3">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Add Link</label>
                    <div class="flex space-x-2">
                        <input type="url" 
                               id="linkUrl" 
                               placeholder="https://example.com" 
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <input type="text" 
                               id="linkTitle" 
                               placeholder="Link title (optional)" 
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <button type="button" onclick="addLink()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-sm">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- File Upload -->
                <div class="mb-3">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Upload Files</label>
                    <div class="flex items-center space-x-2">
                        <input type="file" 
                               id="fileInput" 
                               multiple 
                               accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.xls,.xlsx"
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Supported: PDF, DOC, TXT, Images, Excel (Max: 10MB)</p>
                </div>

                <!-- Attachments Preview -->
                <div id="attachmentsPreview" class="space-y-2 mt-3 hidden">
                    <h4 class="text-xs font-medium text-gray-700">Attachments:</h4>
                    <div id="attachmentsList" class="space-y-2"></div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="toggleNoteForm()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                    Save Note
                </button>
            </div>
        </form>
    </div>

<!-- Activity Timeline -->
<div class="space-y-4" id="activitiesList">
    @php
        // Safe check for activities
        $activities = $activities ?? collect();
    @endphp
    
    @if($activities->count())
        @foreach($activities->sortByDesc('pinned') as $activity)
        <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all duration-200 {{ $activity->pinned ? 'bg-yellow-50 border-yellow-200' : 'bg-white' }}" 
             data-activity-id="{{ $activity->id }}"
             style="transition: all 0.3s ease-in-out;">
            
            <!-- Activity Icon -->
            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center
                @if($activity->type == 'note') bg-blue-100 text-blue-600
                @elseif($activity->type == 'important') bg-red-100 text-red-600
                @elseif($activity->type == 'task') bg-green-100 text-green-600
                @elseif($activity->type == 'created') bg-green-100 text-green-600
                @elseif($activity->type == 'edited') bg-indigo-100 text-indigo-600
                @elseif($activity->type == 'link_shared') bg-purple-100 text-purple-600
                @elseif($activity->type == 'file_uploaded') bg-orange-100 text-orange-600
                @else bg-gray-100 text-gray-600 @endif">
                @if($activity->type == 'note')
                <i class="fa-solid fa-note-sticky text-sm"></i>
                @elseif($activity->type == 'important')
                <i class="fa-solid fa-exclamation text-sm"></i>
                @elseif($activity->type == 'task')
                <i class="fa-solid fa-square-check text-sm"></i>
                @elseif($activity->type == 'created')
                <i class="fa-solid fa-plus text-sm"></i>
                @elseif($activity->type == 'edited')
                <i class="fa-solid fa-pen text-sm"></i>
                @elseif($activity->type == 'link_shared')
                <i class="fa-solid fa-link text-sm"></i>
                @elseif($activity->type == 'file_uploaded')
                <i class="fa-solid fa-file text-sm"></i>
                @else
                <i class="fa-solid fa-circle text-sm"></i>
                @endif
            </div>

            <!-- Activity Content -->
           <!-- Activity Content -->
<div class="flex-1 min-w-0">
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center space-x-2 flex-wrap">
            <span class="text-sm font-medium text-gray-900">
                @if($activity->createdBy && method_exists($activity->createdBy, 'name'))
                    {{ $activity->createdBy->name }}
                @else
                    You
                @endif
            </span>
            <span class="text-xs text-gray-500">•</span>
            <span class="text-xs text-gray-500">
                @if(method_exists($activity->created_at, 'diffForHumans'))
                    {{ $activity->created_at->diffForHumans() }}
                @else
                    Recently
                @endif
            </span>
            
            @if($activity->pinned)
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 pinned-badge">
                <i class="fa-solid fa-thumbtack mr-1"></i>Pinned
            </span>
            @endif
            
            @if(isset($activity->metadata['last_edited_at']))
            <span class="text-xs text-gray-400" title="Edited {{ \Carbon\Carbon::parse($activity->metadata['last_edited_at'])->diffForHumans() }}">
                <i class="fa-solid fa-pen mr-1"></i>Edited
            </span>
            @endif
        </div>
        
        <!-- Action Menu -->
        <div class="relative group">
            <button 
                class="p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-200 transition duration-200 action-menu-btn"
                data-activity-id="{{ $activity->id }}"
                onclick="toggleDropdown(this)"
            >
                <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
            </button>
            
            <!-- Dropdown Menu -->
            <div class="absolute right-0 top-full mt-1 w-48 bg-white rounded-md shadow-lg border border-gray-200 z-10 hidden dropdown-menu">
                <div class="py-1">
                    <button 
                        onclick="editNote('{{ $activity->id }}')" 
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 edit-note-btn"
                        data-activity-id="{{ $activity->id }}"
                    >
                        <i class="fa-solid fa-pen mr-3 text-gray-500 w-4"></i>
                        Edit Note
                    </button>
                    <button 
                        onclick="togglePinNote('{{ $activity->id }}')" 
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150 pin-note-btn"
                        data-activity-id="{{ $activity->id }}"
                    >
                        <i class="fa-solid fa-thumbtack mr-3 text-gray-500 w-4"></i>
                        <span class="pin-text">{{ $activity->pinned ? 'Unpin' : 'Pin' }}</span> Note
                    </button>
                    <hr class="my-1 border-gray-200">
                    <button 
                        onclick="deleteNote('{{ $activity->id }}')" 
                        class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-150 delete-note-btn"
                        data-activity-id="{{ $activity->id }}"
                    >
                        <i class="fa-solid fa-trash mr-3 w-4"></i>
                        Delete Note
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="prose prose-sm max-w-none text-gray-700 break-words" id="content-{{ $activity->id }}">
        {!! $activity->rich_content ?: nl2br(e($activity->description)) !!}
    </div>

    <!-- Enhanced Attachments Section -->
    @if($activity->metadata && (isset($activity->metadata['attachments']) || isset($activity->metadata['file']) || isset($activity->metadata['link'])))
    <div class="mt-4 space-y-3">
        <!-- Files Section -->
        @php
            $fileAttachments = [];
            $linkAttachments = [];
            
            // Collect all file attachments
            if (isset($activity->metadata['attachments']) && is_array($activity->metadata['attachments'])) {
                foreach ($activity->metadata['attachments'] as $attachment) {
                    if ($attachment['type'] === 'file') {
                        $fileAttachments[] = $attachment;
                    } elseif ($attachment['type'] === 'link') {
                        $linkAttachments[] = $attachment;
                    }
                }
            }
            
            // Legacy single file support
            if (isset($activity->metadata['file'])) {
                $fileAttachments[] = [
                    'type' => 'file',
                    'name' => $activity->metadata['file']['name'] ?? 'Attachment',
                    'url' => $activity->metadata['file']['url'] ?? '#',
                    'size' => $activity->metadata['file']['size'] ?? null
                ];
            }
            
            // Legacy single link support
            if (isset($activity->metadata['link'])) {
                $linkAttachments[] = [
                    'type' => 'link',
                    'name' => $activity->metadata['link']['title'] ?? 'Link',
                    'url' => $activity->metadata['link']['url'] ?? '#'
                ];
            }
        @endphp

        <!-- File Attachments -->
        @if(count($fileAttachments) > 0)
        <div class="border-l-4 border-blue-500 bg-blue-50 rounded-r-lg p-3">
            <div class="flex items-center mb-2">
                <i class="fa-solid fa-paperclip text-blue-500 mr-2"></i>
                <span class="text-sm font-medium text-blue-800">Attached Files</span>
                <span class="ml-2 text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                    {{ count($fileAttachments) }} file{{ count($fileAttachments) > 1 ? 's' : '' }}
                </span>
            </div>
            <div class="space-y-2">
                @foreach($fileAttachments as $file)
                <div class="flex items-center justify-between bg-white p-2 rounded-lg border border-blue-200 hover:border-blue-300 transition-colors">
                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                        @php
                            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                            $icon = 'fa-file';
                            $color = 'text-gray-500';
                            
                            switch(strtolower($fileExtension)) {
                                case 'pdf':
                                    $icon = 'fa-file-pdf';
                                    $color = 'text-red-500';
                                    break;
                                case 'doc':
                                case 'docx':
                                    $icon = 'fa-file-word';
                                    $color = 'text-blue-500';
                                    break;
                                case 'xls':
                                case 'xlsx':
                                    $icon = 'fa-file-excel';
                                    $color = 'text-green-500';
                                    break;
                                case 'jpg':
                                case 'jpeg':
                                case 'png':
                                case 'gif':
                                    $icon = 'fa-file-image';
                                    $color = 'text-purple-500';
                                    break;
                                case 'zip':
                                case 'rar':
                                    $icon = 'fa-file-archive';
                                    $color = 'text-yellow-500';
                                    break;
                                case 'txt':
                                    $icon = 'fa-file-text';
                                    $color = 'text-gray-500';
                                    break;
                            }
                        @endphp
                        <i class="fa-solid {{ $icon }} {{ $color }} text-lg"></i>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $file['name'] }}</p>
                            @if(isset($file['size']))
                            <p class="text-xs text-gray-500">
                                {{ round($file['size'] / 1024 / 1024, 2) }} MB
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 ml-3">
                        <a href="{{ $file['url'] }}" 
                           target="_blank" 
                           class="text-blue-600 hover:text-blue-800 transition-colors"
                           title="Download {{ $file['name'] }}">
                            <i class="fa-solid fa-download"></i>
                        </a>
                        <a href="{{ $file['url'] }}" 
                           target="_blank" 
                           class="text-green-600 hover:text-green-800 transition-colors"
                           title="View {{ $file['name'] }}">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Link Attachments -->
        @if(count($linkAttachments) > 0)
        <div class="border-l-4 border-green-500 bg-green-50 rounded-r-lg p-3">
            <div class="flex items-center mb-2">
                <i class="fa-solid fa-link text-green-500 mr-2"></i>
                <span class="text-sm font-medium text-green-800">Related Links</span>
                <span class="ml-2 text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">
                    {{ count($linkAttachments) }} link{{ count($linkAttachments) > 1 ? 's' : '' }}
                </span>
            </div>
            <div class="space-y-2">
                @foreach($linkAttachments as $link)
                <div class="flex items-center justify-between bg-white p-2 rounded-lg border border-green-200 hover:border-green-300 transition-colors">
                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                        <i class="fa-solid fa-external-link-alt text-green-500"></i>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $link['name'] }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $link['url'] }}</p>
                        </div>
                    </div>
                    <a href="{{ $link['url'] }}" 
                       target="_blank" 
                       class="ml-3 px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition-colors whitespace-nowrap">
                        Visit
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Legacy Metadata Display (for backward compatibility) -->
        @if($activity->metadata && (isset($activity->metadata['file']) || isset($activity->metadata['link'])) && empty($fileAttachments) && empty($linkAttachments))
        <div class="mt-3 flex flex-wrap gap-3">
            @if(isset($activity->metadata['file']))
            <div class="flex items-center space-x-2 text-xs text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                <i class="fa-solid fa-paperclip"></i>
                <span class="font-medium">{{ $activity->metadata['file']['name'] ?? 'Attachment' }}</span>
            </div>
            @endif
            @if(isset($activity->metadata['link']))
            <div class="flex items-center space-x-2 text-xs text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                <i class="fa-solid fa-link"></i>
                <a href="{{ $activity->metadata['link']['url'] }}" target="_blank" class="font-medium hover:text-blue-700">
                    {{ $activity->metadata['link']['title'] ?? 'Link' }}
                </a>
            </div>
            @endif
        </div>
        @endif
    </div>
    @endif

    <!-- Edit Form (Hidden by default) -->
    <div id="edit-form-{{ $activity->id }}" class="mt-4 hidden">
        <form class="edit-note-form" data-activity-id="{{ $activity->id }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Note Type</label>
                <div class="flex space-x-3">
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="note" class="text-blue-600 focus:ring-blue-500" {{ $activity->type == 'note' ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">General</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="important" class="text-red-600 focus:ring-red-500" {{ $activity->type == 'important' ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Important</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="task" class="text-green-600 focus:ring-green-500" {{ $activity->type == 'task' ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Task</span>
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <label for="edit-note-{{ $activity->id }}" class="block text-sm font-medium text-gray-700 mb-1">Your Note</label>
                <textarea 
                    id="edit-note-{{ $activity->id }}" 
                    name="note" 
                    rows="3" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                    required
                    maxlength="2000"
                >{{ $activity->description }}</textarea>
                <div class="flex justify-between items-center mt-1">
                    <span class="text-xs text-gray-500">
                        <span class="edit-char-count-{{ $activity->id }}">{{ strlen($activity->description) }}</span>/2000 characters
                    </span>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="pin" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" {{ $activity->pinned ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Pin this note</span>
                </label>
                <div class="flex space-x-2">
                    <button type="button" onclick="cancelEdit('{{ $activity->id }}')" class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-1.5 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                        Update Note
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
        </div>
        @endforeach
    @else
        <!-- Empty State -->
        <div class="text-center py-12 text-gray-500 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
            <i class="fa-solid fa-inbox text-5xl mb-4 text-gray-300"></i>
            <p class="text-lg font-medium text-gray-400 mb-2">No activities yet</p>
            <p class="text-sm text-gray-400 mb-4">Start by adding your first note above</p>
            <button onclick="toggleNoteForm()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                <i class="fa-solid fa-plus mr-2"></i>
                Add Your First Note
            </button>
        </div>
    @endif
</div>
<!-- Simple dropdown toggle function -->
<script>
function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;
    const allDropdowns = document.querySelectorAll('.dropdown-menu');
    
    // Close all other dropdowns
    allDropdowns.forEach(dd => {
        if (dd !== dropdown) {
            dd.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.group')) {
        document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});
</script>

<!-- Security & Visibility Section -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Security & Visibility</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Visibility Scope -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Visibility Scope</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-2">Current Scope</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <i class="fa-solid fa-globe mr-2"></i>Global Access
                        </span>
                        @if($principal->visibility_scopes)
                            @foreach($principal->visibility_scopes as $scope)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                {{ ucfirst($scope) }}
                            </span>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-700 mb-2">Brand Access</p>
                    <div class="flex flex-wrap gap-2">
                        @if($principal->brands->count())
                            @foreach($principal->brands->take(6) as $brand)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fa-solid fa-store mr-2 text-xs"></i>{{ $brand->title }}
                            </span>
                            @endforeach
                            @if($principal->brands->count() > 6)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                +{{ $principal->brands->count() - 6 }} more
                            </span>
                            @endif
                        @else
                            <span class="text-sm text-gray-500">No brands assigned</span>
                        @endif
                    </div>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-700 mb-2">Country Access</p>
                    <div class="flex flex-wrap gap-2">
                        @if($principal->countries && count($principal->countries))
                            @foreach($principal->countries as $country)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                <i class="fa-solid fa-flag mr-2 text-xs"></i>{{ $country }}
                            </span>
                            @endforeach
                        @else
                            <span class="text-sm text-gray-500">All countries</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Owners & Security -->
        <div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Management</h3>
            <div class="space-y-6">
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-3">Account Owners</p>
                    <div class="space-y-3">
                        @if($principal->contacts->where('is_primary', true)->count())
                            @foreach($principal->contacts->where('is_primary', true) as $contact)
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-blue-700">
                                            {{ substr($contact->contact_name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $contact->contact_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $contact->job_title ?? 'Primary Contact' }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Owner
                                </span>
                            </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-500">No primary contacts assigned</p>
                        @endif
                    </div>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-700 mb-2">Security Status</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 border border-green-200 rounded-lg bg-green-50">
                            <i class="fa-solid fa-shield-check text-green-600 text-xl mb-2"></i>
                            <p class="text-sm font-medium text-green-800">Verified</p>
                            <p class="text-xs text-green-600">Account Active</p>
                        </div>
                        {{-- <div class="text-center p-3 border border-blue-200 rounded-lg bg-blue-50">
                            <i class="fa-solid fa-lock text-blue-600 text-xl mb-2"></i>
                            <p class="text-sm font-medium text-blue-800">Secure</p>
                            <p class="text-xs text-blue-600">2FA Enabled</p>
                        </div> --}}
                    </div>
                </div>

                {{-- <div>
                    <p class="text-sm font-medium text-gray-700 mb-2">Last Activity</p>
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <span>Last login</span>
                        <span>{{ $principal->last_login_at ? $principal->last_login_at->diffForHumans() : 'Never' }}</span>
                    </div>
                </div> --}}
                <div>
    <p class="text-sm font-medium text-gray-700 mb-3">Activity Overview</p>
    <div class="space-y-3">
        <!-- Last Activity -->
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600">Last activity</span>
            <span class="text-sm font-medium text-gray-900">
                @if($lastActivity)
                    {{ $lastActivity->created_at->diffForHumans() }}
                @else
                    <span class="text-gray-400">Never</span>
                @endif
            </span>
        </div>

        <!-- Total Activities -->
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600">Total activities</span>
            <span class="text-sm font-medium text-gray-900">
                {{ $activities->count() }}
            </span>
        </div>

        <!-- Today's Activities -->
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600">Today</span>
            <span class="text-sm font-medium text-gray-900">
                {{ $activities->where('created_at', '>=', today())->count() }}
            </span>
        </div>

        <!-- Pinned Activities -->
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600">Pinned</span>
            <span class="text-sm font-medium text-gray-900">
                {{ $activities->where('pinned', true)->count() }}
            </span>
        </div>
    </div>
</div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
// Global variables
let currentEditingNoteId = null;
let attachments = []; // Store attachments for the current note

// Helper function to get CSRF token safely
function getCsrfToken() {
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    if (metaTag) {
        return metaTag.content;
    }
    
    const formToken = document.querySelector('input[name="_token"]');
    if (formToken) {
        return formToken.value;
    }
    
    console.warn('CSRF token not found');
    return '';
}

// Character counter function
function updateCharCount(textarea) {
    const charCount = document.getElementById('charCount');
    if (charCount && textarea) {
        charCount.textContent = textarea.value.length;
    }
}

// Add link to attachments
function addLink() {
    const urlInput = document.getElementById('linkUrl');
    const titleInput = document.getElementById('linkTitle');
    const url = urlInput.value.trim();
    const title = titleInput.value.trim() || 'Link';

    if (!url) {
        showNotification('Please enter a URL', 'error');
        return;
    }

    // Validate URL
    try {
        new URL(url);
    } catch (e) {
        showNotification('Please enter a valid URL', 'error');
        return;
    }

    const link = {
        type: 'link',
        url: url,
        name: title,
        title: title
    };

    attachments.push(link);
    updateAttachmentsPreview();
    
    // Clear inputs
    urlInput.value = '';
    titleInput.value = '';
    
    showNotification('Link added to attachments', 'success');
}

// Handle file selection
function handleFileSelect(event) {
    const files = Array.from(event.target.files);
    
    files.forEach(file => {
        // Check file size (10MB limit)
        if (file.size > 10 * 1024 * 1024) {
            showNotification(`File ${file.name} is too large. Max size is 10MB.`, 'error');
            return;
        }

        const fileAttachment = {
            type: 'file',
            file: file,
            name: file.name,
            size: file.size
        };

        attachments.push(fileAttachment);
    });

    updateAttachmentsPreview();
    event.target.value = ''; // Reset file input
}

// Update attachments preview
function updateAttachmentsPreview() {
    const previewContainer = document.getElementById('attachmentsPreview');
    const attachmentsList = document.getElementById('attachmentsList');
    
    if (attachments.length === 0) {
        previewContainer.classList.add('hidden');
        attachmentsList.innerHTML = '';
        return;
    }

    previewContainer.classList.remove('hidden');
    attachmentsList.innerHTML = '';

    attachments.forEach((attachment, index) => {
        const attachmentElement = document.createElement('div');
        attachmentElement.className = 'flex items-center justify-between bg-gray-50 p-3 rounded-lg border border-gray-200';
        
        if (attachment.type === 'link') {
            attachmentElement.innerHTML = `
                <div class="flex items-center space-x-3 flex-1">
                    <i class="fa-solid fa-link text-blue-500"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${attachment.name}</p>
                        <p class="text-xs text-gray-500 truncate">${attachment.url}</p>
                    </div>
                </div>
                <button type="button" onclick="removeAttachment(${index})" class="text-red-500 hover:text-red-700 ml-2">
                    <i class="fa-solid fa-times"></i>
                </button>
            `;
        } else if (attachment.type === 'file') {
            const size = (attachment.size / 1024 / 1024).toFixed(2);
            const fileExtension = attachment.name.split('.').pop().toLowerCase();
            const icon = getFileIcon(fileExtension);
            
            attachmentElement.innerHTML = `
                <div class="flex items-center space-x-3 flex-1">
                    <i class="fa-solid ${icon} text-green-500"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${attachment.name}</p>
                        <p class="text-xs text-gray-500">${size} MB</p>
                    </div>
                </div>
                <button type="button" onclick="removeAttachment(${index})" class="text-red-500 hover:text-red-700 ml-2">
                    <i class="fa-solid fa-times"></i>
                </button>
            `;
        }

        attachmentsList.appendChild(attachmentElement);
    });
}

// Get appropriate file icon
function getFileIcon(extension) {
    const iconMap = {
        'pdf': 'fa-file-pdf',
        'doc': 'fa-file-word',
        'docx': 'fa-file-word',
        'txt': 'fa-file-text',
        'jpg': 'fa-file-image',
        'jpeg': 'fa-file-image',
        'png': 'fa-file-image',
        'xls': 'fa-file-excel',
        'xlsx': 'fa-file-excel',
        'zip': 'fa-file-archive',
        'rar': 'fa-file-archive'
    };
    
    return iconMap[extension] || 'fa-file';
}

// Remove attachment
function removeAttachment(index) {
    attachments.splice(index, 1);
    updateAttachmentsPreview();
    showNotification('Attachment removed', 'info');
}

// Edit Note with improved error handling
async function editNote(activityId) {
    try {
        // Show loading state
        const menuButton = document.querySelector(`[data-activity-id="${activityId}"] .fa-ellipsis-vertical`)?.parentElement;
        if (menuButton) {
            menuButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            menuButton.disabled = true;
        }

        console.log('Fetching note:', activityId);
        
        const response = await fetch(`/principal/notes/${activityId}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Non-JSON response:', text.substring(0, 200));
            throw new Error('Server returned non-JSON response. Please check the console for details.');
        }

        const result = await response.json();
        
        if (!response.ok) {
            throw new Error(result.message || `HTTP error! status: ${response.status}`);
        }
        
        if (result.success) {
            const activity = result.activity;
            currentEditingNoteId = activityId;
            
            // Populate the form
            const noteField = document.querySelector('textarea[name="note"]');
            if (noteField) {
                noteField.value = activity.description || '';
                updateCharCount(noteField);
            }
            
            // Set note type
            const typeInputs = document.querySelectorAll('input[name="type"]');
            typeInputs.forEach(input => {
                if (input.value === activity.type) {
                    input.checked = true;
                }
            });
            
            // Set pin status
            const pinInput = document.querySelector('input[name="pin"]');
            if (pinInput) {
                pinInput.checked = !!activity.pinned;
            }
            
            // Load existing attachments if any
            attachments = [];
            if (activity.metadata && activity.metadata.attachments) {
                attachments = activity.metadata.attachments.map(att => ({
                    type: att.type,
                    url: att.url,
                    name: att.name,
                    size: att.size
                }));
            }
            updateAttachmentsPreview();
            
            // Change form to update mode
            const form = document.getElementById('noteForm');
            if (form) {
                form.setAttribute('data-mode', 'edit');
                form.setAttribute('data-activity-id', activityId);
                
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.innerHTML = '<i class="fa-solid fa-save mr-2"></i>Update Note';
                    submitButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                    submitButton.classList.add('bg-green-600', 'hover:bg-green-700');
                }
            }
            
            // Show the form if hidden
            const formContainer = document.getElementById('noteFormContainer');
            if (formContainer && formContainer.classList.contains('hidden')) {
                toggleNoteForm();
            }
            
            // Scroll to form
            if (formContainer) {
                formContainer.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }
            
            showNotification('Note loaded successfully', 'success');
            
        } else {
            throw new Error(result.message || 'Failed to load note');
        }
    } catch (error) {
        console.error('Error loading note:', error);
        showNotification('Error loading note: ' + error.message, 'error');
    } finally {
        // Reset menu button
        const menuButton = document.querySelector(`[data-activity-id="${activityId}"] .fa-spinner`)?.parentElement;
        if (menuButton) {
            menuButton.innerHTML = '<i class="fa-solid fa-ellipsis-vertical"></i>';
            menuButton.disabled = false;
        }
    }
}

// Delete Note
async function deleteNote(activityId) {
    if (!confirm('Are you sure you want to delete this note? This action cannot be undone.')) {
        return;
    }
    
    try {
        const response = await fetch(`/principal/notes/${activityId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        
        if (result.success) {
            // Remove the note from the DOM with animation
            const noteElement = document.querySelector(`[data-activity-id="${activityId}"]`);
            if (noteElement) {
                noteElement.style.opacity = '0';
                noteElement.style.transform = 'translateX(-100%)';
                setTimeout(() => {
                    noteElement.remove();
                    updateActivityStats();
                }, 300);
            }
            
            showNotification('Note deleted successfully!', 'success');
            
        } else {
            throw new Error(result.message || 'Failed to delete note');
        }
    } catch (error) {
        console.error('Error deleting note:', error);
        showNotification('Error deleting note: ' + error.message, 'error');
    }
}

// Toggle Pin Note
async function togglePinNote(activityId) {
    try {
        const response = await fetch(`/principal/notes/${activityId}/pin`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        
        if (result.success) {
            // Update the note element immediately
            const noteElement = document.querySelector(`[data-activity-id="${activityId}"]`);
            if (noteElement) {
                const isPinned = result.activity.pinned;
                
                // Toggle pinned styles
                if (isPinned) {
                    noteElement.classList.add('bg-yellow-50', 'border-yellow-200');
                    noteElement.classList.remove('bg-white');
                } else {
                    noteElement.classList.remove('bg-yellow-50', 'border-yellow-200');
                    noteElement.classList.add('bg-white');
                }
                
                // Update pinned badge
                const pinnedBadge = noteElement.querySelector('.pinned-badge');
                if (pinnedBadge) {
                    if (isPinned) {
                        pinnedBadge.classList.remove('hidden');
                    } else {
                        pinnedBadge.classList.add('hidden');
                    }
                }
                
                // Update pin button text in dropdown
                const pinButton = noteElement.querySelector('[onclick*="togglePinNote"]');
                if (pinButton) {
                    pinButton.innerHTML = `<i class="fa-solid fa-thumbtack mr-2 text-gray-500"></i>${isPinned ? 'Unpin' : 'Pin'} Note`;
                }
                
                // Move pinned notes to top
                if (isPinned) {
                    const activitiesList = document.getElementById('activitiesList');
                    activitiesList.insertBefore(noteElement, activitiesList.firstChild);
                }
            }
            
            showNotification(result.message, 'success');
        } else {
            throw new Error(result.message || 'Failed to toggle pin');
        }
    } catch (error) {
        console.error('Error toggling pin:', error);
        showNotification('Error toggling pin: ' + error.message, 'error');
    }
}

// Update form submission to handle both create and update with file attachments
document.addEventListener('DOMContentLoaded', function() {
    const noteForm = document.getElementById('noteForm');
    if (noteForm) {
        // Add input event listener for character count
        const noteField = noteForm.querySelector('textarea[name="note"]');
        if (noteField) {
            noteField.addEventListener('input', function() {
                updateCharCount(this);
            });
        }

        // Initialize file input event listener
        const fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.addEventListener('change', handleFileSelect);
        }

        noteForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const mode = this.getAttribute('data-mode');
            const activityId = this.getAttribute('data-activity-id');
            
            // Get form values explicitly to ensure they're captured
            const noteField = this.querySelector('textarea[name="note"]');
            const noteValue = noteField ? noteField.value.trim() : '';
            const typeInput = this.querySelector('input[name="type"]:checked');
            const typeValue = typeInput ? typeInput.value : 'note';
            const pinInput = this.querySelector('input[name="pin"]');
            const pinValue = pinInput ? pinInput.checked : false;
            
            // Validate required fields
            if (!noteValue) {
                showNotification('Please enter a note before saving.', 'error');
                if (noteField) noteField.focus();
                return;
            }
            
            if (!typeValue) {
                showNotification('Please select a note type.', 'error');
                return;
            }
            
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            const originalClass = submitButton.className;
            
            // Show loading state
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>' + 
                                   (mode === 'edit' ? 'Updating...' : 'Saving...');
            submitButton.disabled = true;
            
            try {
                let url = '/principal/notes';
                let method = 'POST';
                
                if (mode === 'edit' && activityId) {
                    url = `/principal/notes/${activityId}`;
                    method = 'PUT';
                }
                
                // Create form data properly with explicit values
                const formData = new FormData();
                formData.append('note', noteValue);
                formData.append('type', typeValue);
                formData.append('pin', pinValue ? '1' : '0');
                
                // Add attachments
                if (attachments.length > 0) {
                    attachments.forEach((attachment, index) => {
                        if (attachment.type === 'file' && attachment.file) {
                            formData.append(`attachments[${index}][file]`, attachment.file);
                            formData.append(`attachments[${index}][type]`, 'file');
                            formData.append(`attachments[${index}][name]`, attachment.name);
                        } else if (attachment.type === 'link') {
                            formData.append(`attachments[${index}][type]`, 'link');
                            formData.append(`attachments[${index}][url]`, attachment.url);
                            formData.append(`attachments[${index}][name]`, attachment.name);
                        }
                    });
                }
                
                // For PUT requests, we need to add _method for Laravel to recognize it
                if (method === 'PUT') {
                    formData.append('_method', 'PUT');
                }
                
                // Add CSRF token
                formData.append('_token', getCsrfToken());
                
                const response = await fetch(url, {
                    method: 'POST', // Always use POST when using FormData with _method
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                
                if (result.success) {
                    showNotification(result.message, 'success');
                    
                    // Reset form and hide it
                    this.reset();
                    attachments = []; // Clear attachments
                    updateAttachmentsPreview();
                    const charCount = document.getElementById('charCount');
                    if (charCount) charCount.textContent = '0';
                    toggleNoteForm();
                    
                    // Reset form mode
                    this.removeAttribute('data-mode');
                    this.removeAttribute('data-activity-id');
                    submitButton.innerHTML = '<i class="fa-solid fa-save mr-2"></i>Save Note';
                    submitButton.className = originalClass;
                    
                    // Reload the page to show updated activities
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                    
                } else {
                    // Show validation errors from server
                    if (result.errors) {
                        const errorMessages = Object.values(result.errors).flat().join(', ');
                        throw new Error(errorMessages);
                    } else {
                        throw new Error(result.message || 'Unknown error occurred');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error: ' + error.message, 'error');
            } finally {
                // Reset button state
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }
        });
    }
});

// Update toggleNoteForm to reset form mode when canceling
function toggleNoteForm() {
    const formContainer = document.getElementById('noteFormContainer');
    const form = document.getElementById('noteForm');
    const submitButton = form?.querySelector('button[type="submit"]');
    
    if (formContainer) {
        formContainer.classList.toggle('hidden');
        
        if (!formContainer.classList.contains('hidden')) {
            const noteField = form?.querySelector('textarea[name="note"]');
            if (noteField) noteField.focus();
        } else {
            // Reset form to create mode when hiding
            if (form) {
                form.removeAttribute('data-mode');
                form.removeAttribute('data-activity-id');
                form.reset();
                attachments = []; // Clear attachments
                updateAttachmentsPreview();
                
                // Reset type to default
                const defaultType = form.querySelector('input[name="type"][value="note"]');
                if (defaultType) {
                    defaultType.checked = true;
                }
                
                // Reset pin to default
                const pinInput = form.querySelector('input[name="pin"]');
                if (pinInput) {
                    pinInput.checked = false;
                }
                
                // Clear link inputs
                const linkUrl = document.getElementById('linkUrl');
                const linkTitle = document.getElementById('linkTitle');
                if (linkUrl) linkUrl.value = '';
                if (linkTitle) linkTitle.value = '';
                
                if (submitButton) {
                    submitButton.innerHTML = '<i class="fa-solid fa-save mr-2"></i>Save Note';
                    submitButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                    submitButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
                }
                
                const charCount = document.getElementById('charCount');
                if (charCount) charCount.textContent = '0';
            }
        }
    }
}

// Enhanced notification system
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.custom-notification');
    existingNotifications.forEach(notification => notification.remove());
    
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 
                   type === 'error' ? 'bg-red-500' : 
                   type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';
    
    notification.className = `custom-notification fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 translate-x-full`;
    notification.innerHTML = `
        <div class="flex items-center space-x-2">
            <i class="fa-solid ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'}"></i>
            <span class="font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
    
    // Click to dismiss
    notification.addEventListener('click', () => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    });
}

// Update activity stats
function updateActivityStats() {
    const activityCount = document.querySelectorAll('[data-activity-id]').length;
    const activityStatsElement = document.querySelector('[data-activity-stats]');
    
    if (activityStatsElement) {
        activityStatsElement.textContent = activityCount;
    }
    
    // Update last activity if needed
    const lastActivityElement = document.querySelector('[data-last-activity]');
    if (lastActivityElement && activityCount === 0) {
        lastActivityElement.textContent = 'No activities yet';
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.group')) {
        document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    updateActivityStats();
    
    // Initialize character counter
    const noteField = document.querySelector('textarea[name="note"]');
    if (noteField) {
        updateCharCount(noteField);
    }
    
    // Initialize file input
    const fileInput = document.getElementById('fileInput');
    if (fileInput) {
        fileInput.addEventListener('change', handleFileSelect);
    }
});

// Simple dropdown toggle function
function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;
    const allDropdowns = document.querySelectorAll('.dropdown-menu');
    
    // Close all other dropdowns
    allDropdowns.forEach(dd => {
        if (dd !== dropdown) {
            dd.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    dropdown.classList.toggle('hidden');
}

// Rich text formatting functions (placeholder implementations)
function formatText(command) {
    const textarea = document.getElementById('richNote');
    if (!textarea) return;
    
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selectedText = textarea.value.substring(start, end);
    
    let formattedText = '';
    switch(command) {
        case 'bold':
            formattedText = `**${selectedText}**`;
            break;
        case 'italic':
            formattedText = `*${selectedText}*`;
            break;
        case 'underline':
            formattedText = `__${selectedText}__`;
            break;
        default:
            formattedText = selectedText;
    }
    
    textarea.setRangeText(formattedText, start, end, 'select');
    textarea.focus();
}

function insertMention() {
    const textarea = document.getElementById('richNote');
    if (!textarea) return;
    
    const start = textarea.selectionStart;
    textarea.setRangeText('@', start, start, 'end');
    textarea.focus();
}

function insertLink() {
    const textarea = document.getElementById('richNote');
    if (!textarea) return;
    
    const url = prompt('Enter URL:');
    if (url) {
        const title = prompt('Enter link title (optional):') || 'Link';
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selectedText = textarea.value.substring(start, end);
        const linkText = selectedText || title;
        
        textarea.setRangeText(`[${linkText}](${url})`, start, end, 'select');
        textarea.focus();
    }
}

function handleInput(textarea) {
    updateCharCount(textarea);
}
</script>
@endpush