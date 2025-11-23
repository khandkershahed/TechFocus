@extends('principal.layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Welcome Principal, {{ auth('principal')->user()->legal_name }}</h1>
    
    <div class="flex justify-end mb-4">
    <a href="{{ route('principal.profile.edit') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
        Edit Profile
    </a>


        <form method="POST" action="{{ route('principal.logout') }}" class="inline-block">
            @csrf
            <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition duration-200">
                Logout
            </button>
        </form>
    </div>
</div>

<!-- Principal Links -->
{{-- <a href="{{ route('principal.links.create') }}" 
   class="inline-block bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition duration-200 mb-4">
   Add a Link
</a>

<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Shared Links</h2>
    @if($principal->links->count())
        <ul class="list-disc list-inside space-y-2">
            @foreach($principal->links as $link)
                <li>
                    <a href="{{ $link->url }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ $link->label }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">No shared links yet.</p>
    @endif
</div> --}}
<!-- Principal Links -->
<a href="{{ route('principal.links.create') }}" 
   class="inline-block bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition duration-200 mb-4">
   Add a Link
</a>

<!-- Shared Links Preview -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800"> Principal Shared Links</h2>
        <a href="{{ route('principal.links.index') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            View All Links
        </a>
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
</div>



<!-- Principal Info -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Principal Details</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
            <p class="text-sm text-gray-500">Company Name</p>
            <p class="font-medium text-gray-900">{{ auth('principal')->user()->name }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Entity Type</p>
            <p class="font-medium text-gray-900">
                {{ auth('principal')->user()->entity_type ?? 'Not specified' }}
            </p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Email</p>
            <p class="font-medium text-gray-900">{{ auth('principal')->user()->email }}</p>
        </div>
    </div>
</div> 

<!-- Principal Overview -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Principal / Company Overview</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
            <p class="text-sm text-gray-500">Legal Name</p>
            <p class="font-medium text-gray-900">{{ $principal->legal_name ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Trading Name</p>
            <p class="font-medium text-gray-900">{{ $principal->trading_name ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Entity Type</p>
            <p class="font-medium text-gray-900">{{ $principal->entity_type ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Website</p>
            <a href="{{ $principal->website_url }}" target="_blank" class="text-blue-600 hover:underline">
                {{ $principal->website_url ?? 'N/A' }}
            </a>
        </div>
        <div>
            <p class="text-sm text-gray-500">Headquarters</p>
            <p class="font-medium text-gray-900">
                {{ $principal->hq_city ?? '—' }}, {{ $principal->country_iso ?? '—' }}
            </p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Relationship Status</p>
            <span class="px-2 py-1 text-xs rounded-full 
                @if($principal->relationship_status == 'Active') bg-green-100 text-green-800
                @elseif($principal->relationship_status == 'Prospect') bg-yellow-100 text-yellow-800
                @elseif($principal->relationship_status == 'Dormant') bg-gray-200 text-gray-800
                @else bg-red-100 text-red-800 @endif">
                {{ $principal->relationship_status }}
            </span>
        </div>
    </div>

    @if($principal->notes)
    <div class="mt-6">
        <p class="text-sm text-gray-500">Internal Notes</p>
        <div class="prose max-w-none text-sm text-gray-700">
            {!! nl2br(e($principal->notes)) !!}
        </div>
    </div>
    @endif
</div>

<!-- Contacts -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Contacts</h2>
    @if($principal->contacts->count())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Preferred</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($principal->contacts as $contact)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $contact->contact_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $contact->job_title ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $contact->email ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $contact->phone_e164 ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $contact->preferred_channel ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">No contacts available.</p>
    @endif
</div>

<!-- Addresses -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Addresses</h2>
    @if($principal->addresses->count())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">City</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Country</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($principal->addresses as $address)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $address->type }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $address->line1 }} 
                                @if($address->line2)<br>{{ $address->line2 }}@endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $address->city ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $address->country_name ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">No addresses available.</p>
    @endif
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