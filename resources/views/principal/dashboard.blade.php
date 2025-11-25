@extends('principal.layouts.app')

@section('content')

<div class="p-6 mb-6 bg-white border border-gray-200 shadow-md rounded-xl">

    <!-- Header -->
    <div class="space-y-4">

        <!-- Top Row -->
        <div class="flex items-center justify-between">

            <!-- Entity Type + Relationship Status -->
            <div class="flex items-center gap-3">
                <h1 class="text-3xl font-bold text-gray-900 uppercase">
                    {{ $principal->legal_name }}
                </h1>

                @if($principal->country)
                <img src="https://flagsapi.com/{{ strtoupper($principal->country_code ?? 'US') }}/flat/32.png"
                    class="w-8 h-8" alt="Flag">
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">

                <!-- Edit Profile -->
                <a href="{{ route('principal.profile.edit') }}"
                    class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>

                <!-- Share -->
                <a href="{{ route('principal.links.index') }}"
                    class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-white transition bg-indigo-500 rounded-lg hover:bg-indigo-600">
                    <i class="fa-solid fa-share-nodes"></i> Share
                </a>

                <!-- Add Note -->
                <a href="#"
                    class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-white transition bg-green-600 rounded-lg hover:bg-green-700">
                    <i class="fa-solid fa-note-sticky"></i> Note
                </a>

                <!-- Attach File -->
                <a href="{{ route('principal.links.create') }}"
                    class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-white transition bg-purple-500 rounded-lg hover:bg-purple-600">
                    <i class="fa-solid fa-paperclip"></i> Attach
                </a>
            </div>
        </div>

        <!-- Entity + Relationship -->
        <div class="flex items-center gap-3">

            <span class="px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-md">
                {{ $principal->entity_type ?? 'N/A' }}
            </span>

            <span class="px-3 py-1 text-xs font-medium rounded-md
                @if($principal->relationship_status == 'Active') bg-green-100 text-green-700
                @elseif($principal->relationship_status == 'Prospect') bg-yellow-100 text-yellow-700
                @elseif($principal->relationship_status == 'Dormant') bg-gray-100 text-gray-700
                @else bg-red-100 text-red-700 @endif">
                {{ $principal->relationship_status }}
            </span>
        </div>

        <!-- Created Info -->
        <p class="text-sm text-gray-500">
            Created on <strong>{{ $principal->created_at->format('d M, Y') }}</strong> •
            By: <strong>{{ $principal->created_by ?? 'System' }}</strong>
        </p>

        <!-- TABS -->
        <div x-data="{ tab: 1 }" class="w-full mt-4">

            <!-- Tab Navigation -->
            <ul class="grid grid-flow-col p-1 pb-0 text-sm font-medium text-center text-gray-700 bg-gray-100 rounded-lg cursor-pointer">

                @php
                $tabs = [
                1 => 'Overview',
                2 => 'Share',
                3 => 'Add Note',
                4 => 'Archive',
                5 => 'Settings'
                ];
                @endphp

                @foreach($tabs as $key => $label)
                <li @click="tab = {{ $key }}"
                    :class="tab === {{ $key }} ? ' border-b-2 border-indigo-500 rounded-none' : 'hover:text-indigo-700'"
                    class="py-3 transition rounded-lg cursor-pointer">
                    {{ $label }}
                </li>
                @endforeach
            </ul>

            <!-- Tab Content -->
            <div class="space-y-4">

                <div x-show="tab === 1" x-transition class="w-full min-h-screen p-5 px-0">

                    <div class="grid max-w-full grid-cols-1 gap-6 mx-auto lg:grid-cols-3">

                        <div class="flex flex-col gap-6 lg:col-span-1">

                            <div class="p-5 bg-white border border-gray-200 shadow-sm rounded-xl">
                                <h3 class="mb-4 font-semibold text-gray-800">Company Info</h3>
                                <div class="space-y-3">
                                    <div class="grid items-center grid-cols-3">
                                        <span class="text-sm font-medium text-gray-600">Website</span>
                                        <div class="w-3/4 h-4 col-span-2 rounded">NGen IT LTD</div>
                                    </div>
                                    <div class="grid items-center grid-cols-3">
                                        <span class="text-sm font-medium text-gray-600">City Country</span>
                                        <div class="w-full h-4 col-span-2 rounded">Bangladesh</div>
                                    </div>
                                    <div class="grid items-start grid-cols-3 mt-2">
                                        <span class="mt-1 text-sm font-medium text-gray-600">Tags</span>
                                        <div class="flex col-span-2 gap-2">
                                            <div class="px-3 pt-0 text-center text-white bg-green-600 rounded badge">Tags</div>
                                            <div class="px-3 pt-0 text-center text-white bg-purple-600 rounded badge">Tags</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-users text-white text-sm"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Contacts</h3>
                <p class="text-sm text-gray-500">Manage your contact information</p>
            </div>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            <i class="fa-solid fa-user mr-1 text-xs"></i>
            {{ $principal->contacts->count() }} {{ Str::plural('Contact', $principal->contacts->count()) }}
        </span>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-200">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-user text-gray-400 text-xs"></i>
                            <span>Name</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-briefcase text-gray-400 text-xs"></i>
                            <span>Job Title</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-envelope text-gray-400 text-xs"></i>
                            <span>Email</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-phone text-gray-400 text-xs"></i>
                            <span>Phone</span>
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($principal->contacts as $contact)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-xs font-medium">
                                    {{ substr($contact->contact_name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $contact->contact_name }}</div>
                                @if($contact->is_primary)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mt-1">
                                    <i class="fa-solid fa-star mr-1 text-xs"></i>
                                    Primary
                                </span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ $contact->job_title ?? '—' }}
                        </div>
                        @if($contact->department)
                        <div class="text-xs text-gray-500">{{ $contact->department }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($contact->email)
                        <div class="flex items-center space-x-2">
                            <a href="mailto:{{ $contact->email }}" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">
                                {{ $contact->email }}
                            </a>
                            <button onclick="copyToClipboard('{{ $contact->email }}')" class="text-gray-400 hover:text-gray-600 transition-colors" title="Copy email">
                                <i class="fa-regular fa-copy text-xs"></i>
                            </button>
                        </div>
                        @else
                        <span class="text-sm text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($contact->phone_e164)
                        <div class="flex items-center space-x-2">
                            <a href="tel:{{ $contact->phone_e164 }}" class="text-sm text-gray-900 hover:text-blue-600 transition-colors">
                                {{ $contact->phone_e164 }}
                            </a>
                            @if($contact->whatsapp)
                            <a href="https://wa.me/{{ $contact->whatsapp }}" target="_blank" class="text-green-500 hover:text-green-600 transition-colors" title="WhatsApp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            @endif
                        </div>
                        @else
                        <span class="text-sm text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Contact">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Set as Primary">
                                <i class="fa-solid fa-star text-xs"></i>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete Contact">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center space-y-3">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-users text-2xl text-gray-300"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 font-medium">No contacts available</p>
                                <p class="text-sm text-gray-400 mt-1">Add contacts to get started</p>
                            </div>
                            <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Add First Contact
                            </button>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($principal->contacts->count() > 5)
    <div class="mt-4 flex items-center justify-between">
        <p class="text-sm text-gray-500">
            Showing {{ min(5, $principal->contacts->count()) }} of {{ $principal->contacts->count() }} contacts
        </p>
        <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
            View All Contacts
            <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
        </button>
    </div>
    @endif
</div>



                         <div class="p-5 bg-white border border-gray-200 shadow-sm rounded-xl">
                                <h3 class="mb-4 font-semibold text-gray-800">Addresses</h3>
                                @if($principal->addresses->count())
                                <div class="space-y-4">
                                    @foreach($principal->addresses as $address)
                                    <div class="flex items-center justify-between pb-2 border-b">
                                        <span class="text-sm font-medium text-gray-600">{{ $address->type }}</span>
                                        <div class="text-sm text-gray-700 w-100">
                                            {{ $address->line1 }}
                                            @if($address->line2)
                                            <br>{{ $address->line2 }}
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="py-8 text-center">
                                    <i class="mb-3 text-4xl text-gray-300 fa-solid fa-map-marker-alt"></i>
                                    <p class="text-gray-500">No addresses available</p>
                                </div>
                                @endif

                            </div>
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
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                            Brand
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                            Status
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                            Category
                        </th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
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
                                <div class="flex-shrink-0 w-10 h-10">
                                    <img class="object-cover w-10 h-10 rounded-full"
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
                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                            {{ $brand->category ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                            <a href="{{ route('principal.brands.edit', $brand->id) }}"
                               class="mr-3 text-indigo-600 hover:text-indigo-900">
                                                    <i class="fas fa-expand"></i>
                                                </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($brands->count() > 5)
        <div class="mt-4 text-center">
            <a href="{{ route('principal.brands.index') }}"
               class="font-medium text-blue-600 hover:text-blue-800">
               View All Brands →
            </a>
        </div>
        @endif

        @else
        <div class="py-8 text-center">
            <i class="mb-4 text-4xl text-gray-300 fa-solid fa-store"></i>
            <p class="text-gray-700">No brands submitted yet.</p>
            <a href="{{ route('principal.brands.create') }}"
               class="inline-flex items-center px-4 py-2 mt-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-200 bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
               Add Your First Brand
            </a>
        </div>
        @endif
    </div>
</div>

 <div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold">Products</h2>
    </div>
    <div class="p-6">
        @if($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                Product
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                Status
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
                                Price
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">
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
                                    <div class="flex-shrink-0 w-10 h-10">
                                        <img class="object-cover w-10 h-10 rounded"
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
                            <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                @if($product->price)
                                    ${{ number_format($product->price, 2) }}
                                @else
                                    <span class="text-gray-500">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                <a href="{{ route('principal.products.index', $product->id) }}"
                                   class="mr-3 text-indigo-600 hover:text-indigo-900">
                                                    <i class="fas fa-expand"></i>
                                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($products->count() > 5)
            <div class="mt-4 text-center">
                <a href="{{ route('principal.products.index') }}"
                   class="font-medium text-indigo-600 hover:text-indigo-800">
                   View All Products →
                </a>
            </div>
            @endif

        @else
            <div class="py-8 text-center">
                <i class="mb-4 text-4xl text-gray-300 fa-solid fa-cube"></i>
                <p class="text-gray-700">No products submitted yet.</p>
                <a href="{{ route('principal.products.create') }}"
                   class="inline-flex items-center px-4 py-2 mt-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-200 bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">
                   Add Your First Product
                </a>
            </div>
        @endif
    </div>
</div>


                            <div class="p-6 transition-all duration-300 bg-white border border-gray-100 rounded-2xl">
                                <!-- Header with Gradient Background -->
                                <div class="p-4 mb-6 border border-blue-100 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="p-3 shadow-md bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl">
                                                <i class="text-lg text-white fa-solid fa-link"></i>
                                            </div>
                                            <div>
                                                <h2 class="text-xl font-bold text-gray-800">Quick Links & Resources</h2>
                                                <p class="mt-1 text-sm text-gray-600">Share and manage your important links</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-3 py-1 text-sm font-medium text-blue-600 bg-white border border-blue-200 rounded-full shadow-sm">
                                                {{ $principal->links->count() }} {{ Str::plural('Link', $principal->links->count()) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-wrap gap-3 mb-6">
                                    <a href="{{ route('principal.links.create') }}"
                                        class="group inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        <i class="mr-2 transition-transform fa-solid fa-plus group-hover:scale-110"></i>
                                        Add New Links
                                    </a>

                                    <a href="{{ route('principal.links.index') }}"
                                        class="inline-flex items-center px-5 py-3 font-semibold text-gray-700 transition-all duration-300 bg-white border border-gray-200 shadow-sm group rounded-xl hover:border-indigo-300 hover:bg-indigo-50 hover:shadow-md">
                                        <i class="mr-2 text-indigo-600 fa-solid fa-list"></i>
                                        Manage All Links
                                    </a>
                                </div>

                                <!-- Links Grid -->
                                @if($principal->links->count())
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
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
                                                <i class="text-sm text-white fa-solid fa-link"></i>
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
                                                        <i class="mr-1 text-xs fa-solid fa-external-link"></i>
                                                        Visit
                                                    </span>
                                                </div>
                                            </div>
                                            @else
                                            <span class="text-xs italic text-gray-400">No URL provided</span>
                                            @endif
                                        </div>

                                        <!-- Hover Effect Border -->
                                        <div class="absolute inset-0 rounded-xl border-2 border-transparent group-hover:border-{{ $color }}-200 transition-all duration-300 pointer-events-none"></div>
                                    </div>
                                    @endforeach
                                    @endforeach
                                </div>

                                <!-- Links Summary -->
                                <div class="pt-4 mt-6 border-t border-gray-200">
                                    <div class="flex flex-wrap items-center justify-between text-sm text-gray-600">
                                        <div class="flex items-center space-x-4">
                                            <span class="flex items-center">
                                                <i class="mr-2 text-blue-500 fa-solid fa-layer-group"></i>
                                                {{ $principal->links->count() }} {{ Str::plural('Link Set', $principal->links->count()) }}
                                            </span>
                                            <span class="flex items-center">
                                                <i class="mr-2 text-green-500 fa-solid fa-link"></i>
                                                {{ array_reduce($principal->links->toArray(), function($carry, $link) {
                            $labels = is_string($link['label']) ? json_decode($link['label'], true) : $link['label'];
                            return $carry + count($labels);
                        }, 0) }} Total Links
                                            </span>
                                        </div>
                                        <a href="{{ route('principal.links.index') }}"
                                            class="inline-flex items-center font-medium text-blue-600 transition-colors hover:text-blue-700">
                                            View Detailed Analytics
                                            <i class="ml-1 text-xs fa-solid fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>

                                @else
                                <!-- Empty State -->
                                <div class="py-12 text-center">
                                    <div class="max-w-md mx-auto">
                                        <div class="flex items-center justify-center w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl">
                                            <i class="text-2xl text-gray-400 fa-solid fa-link"></i>
                                        </div>
                                        <h3 class="mb-2 text-lg font-semibold text-gray-700">No Links Added Yet</h3>
                                        <p class="mb-6 text-gray-500">Start by adding your important links and resources to share with your team.</p>
                                        <a href="{{ route('principal.links.create') }}"
                                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                            <i class="mr-2 fa-solid fa-plus"></i>
                                            Create Your First Link Set
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>

                        </div>

                        <div class="flex flex-col gap-6 lg:col-span-2">
                            <div class="p-5 bg-white border border-gray-200 rounded-xl">
                                <h3 class="mb-4 font-semibold text-gray-800">Shortcuts</h3>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <button class="flex items-center gap-3 text-sm font-medium text-gray-700 transition hover:text-blue-600">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                        </svg>
                                        Open WhatsApp
                                    </button>
                                    <button class="flex items-center gap-3 text-sm font-medium text-gray-700 transition hover:text-blue-600">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        Copy Address
                                    </button>
                                    <button class="flex items-center gap-3 text-sm font-medium text-gray-700 transition hover:text-blue-600">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                        Copy Address
                                    </button>
                                </div>
                            </div>

                            <div class="p-5 bg-white border border-gray-200 shadow-sm rounded-xl">
                                <!-- Activity & Notes Section -->
                                <div class="">
                                    <div class="flex items-center justify-between mb-6">
                                        <h2 class="text-xl font-semibold text-gray-800">Activity & Notes Timeline</h2>
                                        <button onclick="toggleNoteForm()" class="px-4 py-2 font-semibold text-white transition duration-200 bg-blue-600 rounded hover:bg-blue-700">
                                            <i class="mr-2 fa-solid fa-plus"></i>Add Note
                                        </button>
                                    </div>

                                    <!-- Rich Text Note Form (Initially Hidden) -->
                                    <div id="noteFormContainer" class="hidden p-4 mb-6 border border-gray-200 rounded-lg">
                                        <form id="noteForm" action="{{ route('principal.notes.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-4">
                                                <label class="block mb-2 text-sm font-medium text-gray-700">Note Type</label>
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
                                                <label for="richNote" class="block mb-2 text-sm font-medium text-gray-700">Your Note</label>
                                                <div class="border border-gray-300 rounded-lg">
                                                    <!-- Rich Text Toolbar -->
                                                    <div class="flex items-center p-2 space-x-1 border-b border-gray-200 rounded-t-lg bg-gray-50">
                                                        <button type="button" class="p-1 rounded hover:bg-gray-200" onclick="formatText('bold')">
                                                            <i class="text-sm fa-solid fa-bold"></i>
                                                        </button>
                                                        <button type="button" class="p-1 rounded hover:bg-gray-200" onclick="formatText('italic')">
                                                            <i class="text-sm fa-solid fa-italic"></i>
                                                        </button>
                                                        <button type="button" class="p-1 rounded hover:bg-gray-200" onclick="formatText('underline')">
                                                            <i class="text-sm fa-solid fa-underline"></i>
                                                        </button>
                                                        <div class="w-px h-6 mx-1 bg-gray-300"></div>
                                                        <button type="button" class="p-1 rounded hover:bg-gray-200" onclick="insertMention()">
                                                            <i class="text-sm fa-solid fa-at"></i>
                                                        </button>
                                                        <button type="button" class="p-1 rounded hover:bg-gray-200" onclick="insertLink()">
                                                            <i class="text-sm fa-solid fa-link"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Rich Text Area -->
                                                    <textarea
                                                        id="richNote"
                                                        name="note"
                                                        rows="4"
                                                        class="w-full px-3 py-2 border-0 rounded-b-lg resize-none focus:outline-none focus:ring-0"
                                                        placeholder="Type your note here... Use @ to mention team members or # to add tags"
                                                        oninput="handleInput(this)"></textarea>
                                                </div>
                                                <div class="flex items-center justify-between mt-2">
                                                    <span class="text-xs text-gray-500">
                                                        <span id="charCount">0</span>/2000 characters
                                                    </span>
                                                    <div class="flex items-center space-x-4">
                                                        <label class="inline-flex items-center">
                                                            <input type="checkbox" name="pin" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500">
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
                                                <label class="block mb-2 text-sm font-medium text-gray-700">Attachments</label>

                                                <!-- Link Input -->
                                                <div class="mb-3">
                                                    <label class="block mb-1 text-xs font-medium text-gray-600">Add Link</label>
                                                    <div class="flex space-x-2">
                                                        <input type="url"
                                                            id="linkUrl"
                                                            placeholder="https://example.com"
                                                            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                        <input type="text"
                                                            id="linkTitle"
                                                            placeholder="Link title (optional)"
                                                            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                        <button type="button" onclick="addLink()" class="px-4 py-2 text-sm text-white bg-gray-600 rounded-lg hover:bg-gray-700">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- File Upload -->
                                                <div class="mb-3">
                                                    <label class="block mb-1 text-xs font-medium text-gray-600">Upload Files</label>
                                                    <div class="flex items-center space-x-2">
                                                        <input type="file"
                                                            id="fileInput"
                                                            multiple
                                                            accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.xls,.xlsx"
                                                            class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                                    </div>
                                                    <p class="mt-1 text-xs text-gray-500">Supported: PDF, DOC, TXT, Images, Excel (Max: 10MB)</p>
                                                </div>

                                                <!-- Attachments Preview -->
                                                <div id="attachmentsPreview" class="hidden mt-3 space-y-2">
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
                                                <i class="text-sm fa-solid fa-note-sticky"></i>
                                                @elseif($activity->type == 'important')
                                                <i class="text-sm fa-solid fa-exclamation"></i>
                                                @elseif($activity->type == 'task')
                                                <i class="text-sm fa-solid fa-square-check"></i>
                                                @elseif($activity->type == 'created')
                                                <i class="text-sm fa-solid fa-plus"></i>
                                                @elseif($activity->type == 'edited')
                                                <i class="text-sm fa-solid fa-pen"></i>
                                                @elseif($activity->type == 'link_shared')
                                                <i class="text-sm fa-solid fa-link"></i>
                                                @elseif($activity->type == 'file_uploaded')
                                                <i class="text-sm fa-solid fa-file"></i>
                                                @else
                                                <i class="text-sm fa-solid fa-circle"></i>
                                                @endif
                                            </div>

                                            <!-- Activity Content -->
                                            <!-- Activity Content -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex flex-wrap items-center space-x-2">
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
                                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full pinned-badge">
                                                            <i class="mr-1 fa-solid fa-thumbtack"></i>Pinned
                                                        </span>
                                                        @endif

                                                        @if(isset($activity->metadata['last_edited_at']))
                                                        <span class="text-xs text-gray-400" title="Edited {{ \Carbon\Carbon::parse($activity->metadata['last_edited_at'])->diffForHumans() }}">
                                                            <i class="mr-1 fa-solid fa-pen"></i>Edited
                                                        </span>
                                                        @endif
                                                    </div>

                                                    <!-- Action Menu -->
                                                    <div class="relative group">
                                                        <button
                                                            class="p-2 text-gray-400 transition duration-200 rounded-full hover:text-gray-600 hover:bg-gray-200 action-menu-btn"
                                                            data-activity-id="{{ $activity->id }}"
                                                            onclick="toggleDropdown(this)">
                                                            <i class="text-sm fa-solid fa-ellipsis-vertical"></i>
                                                        </button>

                                                        <!-- Dropdown Menu -->
                                                        <div class="absolute right-0 z-10 hidden w-48 mt-1 bg-white border border-gray-200 rounded-md shadow-lg top-full dropdown-menu">
                                                            <div class="py-1">
                                                                <button
                                                                    onclick="editNote('{{ $activity->id }}')"
                                                                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 transition duration-150 hover:bg-gray-100 edit-note-btn"
                                                                    data-activity-id="{{ $activity->id }}">
                                                                    <i class="w-4 mr-3 text-gray-500 fa-solid fa-pen"></i>
                                                                    Edit Note
                                                                </button>
                                                                <button
                                                                    onclick="togglePinNote('{{ $activity->id }}')"
                                                                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 transition duration-150 hover:bg-gray-100 pin-note-btn"
                                                                    data-activity-id="{{ $activity->id }}">
                                                                    <i class="w-4 mr-3 text-gray-500 fa-solid fa-thumbtack"></i>
                                                                    <span class="pin-text">{{ $activity->pinned ? 'Unpin' : 'Pin' }}</span> Note
                                                                </button>
                                                                <hr class="my-1 border-gray-200">
                                                                <button
                                                                    onclick="deleteNote('{{ $activity->id }}')"
                                                                    class="flex items-center w-full px-4 py-2 text-sm text-red-600 transition duration-150 hover:bg-red-50 delete-note-btn"
                                                                    data-activity-id="{{ $activity->id }}">
                                                                    <i class="w-4 mr-3 fa-solid fa-trash"></i>
                                                                    Delete Note
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="prose-sm prose text-gray-700 break-words max-w-none" id="content-{{ $activity->id }}">
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
                                                    <div class="p-3 border-l-4 border-blue-500 rounded-r-lg bg-blue-50">
                                                        <div class="flex items-center mb-2">
                                                            <i class="mr-2 text-blue-500 fa-solid fa-paperclip"></i>
                                                            <span class="text-sm font-medium text-blue-800">Attached Files</span>
                                                            <span class="px-2 py-1 ml-2 text-xs text-blue-600 bg-blue-100 rounded-full">
                                                                {{ count($fileAttachments) }} file{{ count($fileAttachments) > 1 ? 's' : '' }}
                                                            </span>
                                                        </div>
                                                        <div class="space-y-2">
                                                            @foreach($fileAttachments as $file)
                                                            <div class="flex items-center justify-between p-2 transition-colors bg-white border border-blue-200 rounded-lg hover:border-blue-300">
                                                                <div class="flex items-center flex-1 min-w-0 space-x-3">
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
                                                                <div class="flex items-center ml-3 space-x-2">
                                                                    <a href="{{ $file['url'] }}"
                                                                        target="_blank"
                                                                        class="text-blue-600 transition-colors hover:text-blue-800"
                                                                        title="Download {{ $file['name'] }}">
                                                                        <i class="fa-solid fa-download"></i>
                                                                    </a>
                                                                    <a href="{{ $file['url'] }}"
                                                                        target="_blank"
                                                                        class="text-green-600 transition-colors hover:text-green-800"
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
                                                    <div class="p-3 border-l-4 border-green-500 rounded-r-lg bg-green-50">
                                                        <div class="flex items-center mb-2">
                                                            <i class="mr-2 text-green-500 fa-solid fa-link"></i>
                                                            <span class="text-sm font-medium text-green-800">Related Links</span>
                                                            <span class="px-2 py-1 ml-2 text-xs text-green-600 bg-green-100 rounded-full">
                                                                {{ count($linkAttachments) }} link{{ count($linkAttachments) > 1 ? 's' : '' }}
                                                            </span>
                                                        </div>
                                                        <div class="space-y-2">
                                                            @foreach($linkAttachments as $link)
                                                            <div class="flex items-center justify-between p-2 transition-colors bg-white border border-green-200 rounded-lg hover:border-green-300">
                                                                <div class="flex items-center flex-1 min-w-0 space-x-3">
                                                                    <i class="text-green-500 fa-solid fa-external-link-alt"></i>
                                                                    <div class="flex-1 min-w-0">
                                                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $link['name'] }}</p>
                                                                        <p class="text-xs text-gray-500 truncate">{{ $link['url'] }}</p>
                                                                    </div>
                                                                </div>
                                                                <a href="{{ $link['url'] }}"
                                                                    target="_blank"
                                                                    class="px-3 py-1 ml-3 text-xs text-white transition-colors bg-green-600 rounded hover:bg-green-700 whitespace-nowrap">
                                                                    Visit
                                                                </a>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <!-- Legacy Metadata Display (for backward compatibility) -->
                                                    @if($activity->metadata && (isset($activity->metadata['file']) || isset($activity->metadata['link'])) && empty($fileAttachments) && empty($linkAttachments))
                                                    <div class="flex flex-wrap gap-3 mt-3">
                                                        @if(isset($activity->metadata['file']))
                                                        <div class="flex items-center px-3 py-1 space-x-2 text-xs text-gray-600 bg-gray-100 rounded-full">
                                                            <i class="fa-solid fa-paperclip"></i>
                                                            <span class="font-medium">{{ $activity->metadata['file']['name'] ?? 'Attachment' }}</span>
                                                        </div>
                                                        @endif
                                                        @if(isset($activity->metadata['link']))
                                                        <div class="flex items-center px-3 py-1 space-x-2 text-xs text-gray-600 bg-gray-100 rounded-full">
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
                                                <div id="edit-form-{{ $activity->id }}" class="hidden mt-4">
                                                    <form class="edit-note-form" data-activity-id="{{ $activity->id }}">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="PUT">

                                                        <div class="mb-3">
                                                            <label class="block mb-1 text-sm font-medium text-gray-700">Note Type</label>
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
                                                            <label for="edit-note-{{ $activity->id }}" class="block mb-1 text-sm font-medium text-gray-700">Your Note</label>
                                                            <textarea
                                                                id="edit-note-{{ $activity->id }}"
                                                                name="note"
                                                                rows="3"
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                required
                                                                maxlength="2000">{{ $activity->description }}</textarea>
                                                            <div class="flex items-center justify-between mt-1">
                                                                <span class="text-xs text-gray-500">
                                                                    <span class="edit-char-count-{{ $activity->id }}">{{ strlen($activity->description) }}</span>/2000 characters
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center justify-between">
                                                            <label class="inline-flex items-center">
                                                                <input type="checkbox" name="pin" value="1" class="text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ $activity->pinned ? 'checked' : '' }}>
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
                                        <div class="py-12 text-center text-gray-500 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50">
                                            <i class="mb-4 text-5xl text-gray-300 fa-solid fa-inbox"></i>
                                            <p class="mb-2 text-lg font-medium text-gray-400">No activities yet</p>
                                            <p class="mb-4 text-sm text-gray-400">Start by adding your first note above</p>
                                            <button onclick="toggleNoteForm()" class="inline-flex items-center px-4 py-2 text-white transition duration-200 bg-blue-600 rounded-lg hover:bg-blue-700">
                                                <i class="mr-2 fa-solid fa-plus"></i>
                                                Add Your First Note
                                            </button>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Security & Visibility Section -->
                                    <div class="p-6 mt-4 bg-white border rounded-lg">
                                        <h2 class="mb-6 text-xl font-semibold text-gray-800">Security & Visibility</h2>

                                        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                                            <!-- Visibility Scope -->
                                            <div>
                                                <h3 class="mb-4 text-lg font-medium text-gray-900">Visibility Scope</h3>
                                                <div class="space-y-4">
                                                    <div>
                                                        <p class="mb-2 text-sm font-medium text-gray-700">Current Scope</p>
                                                        <div class="flex flex-wrap gap-2">
                                                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">
                                                                <i class="mr-2 fa-solid fa-globe"></i>Global Access
                                                            </span>
                                                            @if($principal->visibility_scopes)
                                                            @foreach($principal->visibility_scopes as $scope)
                                                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-gray-800 bg-gray-100 rounded-full">
                                                                {{ ucfirst($scope) }}
                                                            </span>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <p class="mb-2 text-sm font-medium text-gray-700">Brand Access</p>
                                                        <div class="flex flex-wrap gap-2">
                                                            @if($principal->brands->count())
                                                            @foreach($principal->brands->take(6) as $brand)
                                                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">
                                                                <i class="mr-2 text-xs fa-solid fa-store"></i>{{ $brand->title }}
                                                            </span>
                                                            @endforeach
                                                            @if($principal->brands->count() > 6)
                                                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-gray-800 bg-gray-100 rounded-full">
                                                                +{{ $principal->brands->count() - 6 }} more
                                                            </span>
                                                            @endif
                                                            @else
                                                            <span class="text-sm text-gray-500">No brands assigned</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <p class="mb-2 text-sm font-medium text-gray-700">Country Access</p>
                                                        <div class="flex flex-wrap gap-2">
                                                            @if($principal->countries && count($principal->countries))
                                                            @foreach($principal->countries as $country)
                                                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-purple-800 bg-purple-100 rounded-full">
                                                                <i class="mr-2 text-xs fa-solid fa-flag"></i>{{ $country }}
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
                                                <h3 class="mb-4 text-lg font-medium text-gray-900">Account Management</h3>
                                                <div class="space-y-6">
                                                    <div>
                                                        <p class="mb-3 text-sm font-medium text-gray-700">Account Owners</p>
                                                        <div class="space-y-3">
                                                            @if($principal->contacts->where('is_primary', true)->count())
                                                            @foreach($principal->contacts->where('is_primary', true) as $contact)
                                                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                                                <div class="flex items-center space-x-3">
                                                                    <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full">
                                                                        <span class="text-sm font-medium text-blue-700">
                                                                            {{ substr($contact->contact_name, 0, 1) }}
                                                                        </span>
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-sm font-medium text-gray-900">{{ $contact->contact_name }}</p>
                                                                        <p class="text-sm text-gray-500">{{ $contact->job_title ?? 'Primary Contact' }}</p>
                                                                    </div>
                                                                </div>
                                                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
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
                                                        <p class="mb-2 text-sm font-medium text-gray-700">Security Status</p>
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div class="p-3 text-center border border-green-200 rounded-lg bg-green-50">
                                                                <i class="mb-2 text-xl text-green-600 fa-solid fa-shield-check"></i>
                                                                <p class="text-sm font-medium text-green-800">Verified</p>
                                                                <p class="text-xs text-green-600">Account Active</p>
                                                            </div>
                                                            {{-- <div class="p-3 text-center border border-blue-200 rounded-lg bg-blue-50">
                            <i class="mb-2 text-xl text-blue-600 fa-solid fa-lock"></i>
                            <p class="text-sm font-medium text-blue-800">Secure</p>
                            <p class="text-xs text-blue-600">2FA Enabled</p>
                        </div> --}}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p class="mb-3 text-sm font-medium text-gray-700">Activity Overview</p>
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


                                </div>
                            </div>
                        </div>

                        <div x-show="tab === 2" x-transition>
                            <h2 class="text-xl font-semibold text-gray-800">Titan Maintenance</h2>
                            <p class="text-gray-600">Content for titan maintenance...</p>
                        </div>

                        <div x-show="tab === 3" x-transition>
                            <h2 class="text-xl font-semibold text-gray-800">Loadout</h2>
                            <p class="text-gray-600">Content for loadout...</p>
                        </div>

                        <div x-show="tab === 4" x-transition>
                            <h2 class="text-xl font-semibold text-gray-800">Server Browser</h2>
                            <p class="text-gray-600">Content for server browser...</p>
                        </div>

                        <div x-show="tab === 5" x-transition>
                            <h2 class="text-xl font-semibold text-gray-800">Settings</h2>
                            <p class="text-gray-600">Content for settings...</p>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Footer Action -->
            <div class="flex justify-end pt-6 mt-6">
                <a href="{{ route('principal.dashboard') }}"
                    class="px-5 py-2.5 text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow transition flex items-center gap-2">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard
                </a>
            </div>

        </div>
        @push('scripts')
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
                <div class="flex items-center flex-1 space-x-3">
                    <i class="text-blue-500 fa-solid fa-link"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${attachment.name}</p>
                        <p class="text-xs text-gray-500 truncate">${attachment.url}</p>
                    </div>
                </div>
                <button type="button" onclick="removeAttachment(${index})" class="ml-2 text-red-500 hover:text-red-700">
                    <i class="fa-solid fa-times"></i>
                </button>
            `;
                    } else if (attachment.type === 'file') {
                        const size = (attachment.size / 1024 / 1024).toFixed(2);
                        const fileExtension = attachment.name.split('.').pop().toLowerCase();
                        const icon = getFileIcon(fileExtension);

                        attachmentElement.innerHTML = `
                <div class="flex items-center flex-1 space-x-3">
                    <i class="fa-solid ${icon} text-green-500"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${attachment.name}</p>
                        <p class="text-xs text-gray-500">${size} MB</p>
                    </div>
                </div>
                <button type="button" onclick="removeAttachment(${index})" class="ml-2 text-red-500 hover:text-red-700">
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
                                submitButton.innerHTML = '<i class="mr-2 fa-solid fa-save"></i>Update Note';
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
                                pinButton.innerHTML = `<i class="mr-2 text-gray-500 fa-solid fa-thumbtack"></i>${isPinned ? 'Unpin' : 'Pin'} Note`;
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
                        submitButton.innerHTML = '<i class="mr-2 fa-solid fa-spinner fa-spin"></i>' +
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
                                submitButton.innerHTML = '<i class="mr-2 fa-solid fa-save"></i>Save Note';
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
                                submitButton.innerHTML = '<i class="mr-2 fa-solid fa-save"></i>Save Note';
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
                switch (command) {
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
        <script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Show notification
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-check"></i>
                <span>Copied to clipboard!</span>
            </div>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 2000);
    });
}
</script>
  @endpush
 @endsection