@extends('principal.layouts.app')

@section('content')
<div class="container min-h-screen p-4 mx-auto antialiased bg-slate-50 md:p-8">

    {{-- Header & Actions --}}
    <div class="flex flex-col items-start justify-between p-6 mb-6 bg-white border shadow-xl border-slate-100 rounded-2xl md:flex-row md:items-center">
        <div>
                                <h1 class="mb-2 text-3xl font-extrabold text-slate-900 md:text-4xl flex items-center gap-2">
                                    {{ $principal->legal_name ?? $principal->name ?? 'Company Name' }}
                                    @if($principal->country)
                                        @php
                                            $iso = \App\Helpers\CountryHelper::isoCode($principal->country->name);
                                        @endphp
                                        @if($iso)
                                            <img src="https://flagsapi.com/{{ $iso }}/flat/32.png" 
                                                class="w-8 h-8 rounded-lg shadow-sm" alt="Flag">
                                        @endif
                                    @endif
                                </h1>
            <div class="flex flex-wrap items-center gap-3">
                <span class="px-3 py-1 text-xs font-semibold rounded-full shadow-sm text-cyan-700 bg-cyan-100">
                    <i class="mr-1 fa fa-industry"></i> Entity Type: {{ $principal->entity_type ?? 'N/A' }}
                </span>
            
                <span class="px-3 py-1 text-xs font-semibold rounded-full text-emerald-700 bg-emerald-100">
                    <i class="mr-1 fa fa-check-circle"></i> {{ $principal->relationship_status ?? 'Active' }}
                </span>
                @if($principal->country)
                <span class="px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">
                    <i class="mr-1 fa fa-globe"></i> {{ $principal->country->name }}
                </span>
                @endif
            </div>
            <p class="mt-2 text-sm text-slate-500">
                Created on <strong>{{ $principal->created_at->format('d M, Y') }}</strong> • 
                By: <strong>{{ $principal->created_by ?? 'System' }}</strong>
            </p>
        </div>

        <div class="flex flex-wrap gap-3 p-3 mt-4 md:mt-0">
            <a href="{{ route('principal.profile.edit') }}" 
               class="flex items-center px-5 py-2 text-white transition duration-200 rounded-full shadow-md bg-cyan-600 hover:bg-cyan-700 hover:shadow-lg">
                <i class="mr-2 fa fa-pen"></i> Edit
            </a>
            <a href="{{ route('principal.links.index') }}" 
               class="flex items-center px-5 py-2 transition duration-200 border rounded-full text-slate-700 border-slate-300 hover:bg-slate-100">
                <i class="mr-2 fa fa-share-nodes"></i> Share
            </a>
           <a href="{{ route('principal.notes.index') }}" 
                    class="flex items-center px-5 py-2 transition duration-200 border rounded-full text-slate-700 border-slate-300 hover:bg-slate-100">
                        <i class="mr-2 fa fa-sticky-note"></i> Add Note
                    </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 gap-6 mb-10 md:grid-cols-4">
        <div class="p-5 text-center bg-white rounded-xl shadow-md border-t-4 border-cyan-500 transition duration-300 hover:shadow-xl hover:scale-[1.01]">
            <h6 class="mb-1 text-sm font-medium text-slate-500">Total Brands</h6>
            <p class="text-xl font-extrabold text-slate-800 md:text-2xl">{{ $brands->count() }}</p>
        </div>
        <div class="p-5 text-center bg-white rounded-xl shadow-md border-t-4 border-green-500 transition duration-300 hover:shadow-xl hover:scale-[1.01]">
            <h6 class="mb-1 text-sm font-medium text-slate-500">Total Products</h6>
            <p class="text-xl font-extrabold text-green-600 md:text-2xl">{{ $products->count() }}</p>
        </div>
        <div class="p-5 text-center bg-white rounded-xl shadow-md border-t-4 border-purple-500 transition duration-300 hover:shadow-xl hover:scale-[1.01]">
            <h6 class="mb-1 text-sm font-medium text-slate-500">Quick Links</h6>
            <p class="text-xl font-extrabold text-purple-600 md:text-2xl">{{ $principal->links->count() }}</p>
        </div>
        <div class="p-5 text-center bg-white rounded-xl shadow-md border-t-4 border-cyan-500 transition duration-300 hover:shadow-xl hover:scale-[1.01]">
            <h6 class="mb-1 text-sm font-medium text-slate-500">Member Since</h6>
            <p class="text-xl font-extrabold text-slate-800 md:text-2xl">{{ $principal->created_at->format('Y') }}</p>
        </div>
    </div>

    <div class="grid gap-8 md:grid-cols-3">

        {{-- Left Column --}}
        <div class="space-y-8 md:col-span-2">

            {{-- Company Info --}}
            <div class="p-6 bg-white border shadow-xl border-slate-100 rounded-xl">
                <h2 class="pb-2 mb-4 text-2xl font-extrabold border-b-2 text-slate-800 border-cyan-100">Company & Contact Details</h2>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl hover:shadow-lg">
                        <h3 class="mb-4 text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-building"></i> Company Info</h3>
                        <p><strong>Legal Name:</strong> {{ $principal->legal_name ?? 'N/A' }}</p>
                        <p><strong>Trading Name:</strong> {{ $principal->name ?? 'N/A' }}</p>
                        <p><strong>Website:</strong> 
                            @if($principal->website_url)
                            <a href="{{ $principal->website_url }}" target="_blank" class="text-cyan-600 hover:underline">{{ $principal->website_url }}</a>
                            @else
                            N/A
                            @endif
                        </p>
                        <p><strong>Country:</strong> {{ $principal->country->name ?? 'N/A' }}</p>
                        <p class="pt-2"><strong>Entity Type:</strong> 
                            <span class="px-3 py-1 text-xs font-semibold rounded-full text-amber-800 bg-amber-100">
                                {{ $principal->entity_type ?? 'N/A' }}
                            </span>
                        </p>
                    </div>
                    
                    {{-- Primary Contact --}}
                    <div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl hover:shadow-lg">
                        <h3 class="mb-4 text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-user-tie"></i> Primary Contact</h3>
                        @if($principal->primaryContact)
                        <p><strong>Name:</strong> {{ $principal->primaryContact->contact_name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> 
                            @if($principal->email)
                            <a href="mailto:{{ $principal->email }}" class="text-cyan-600 hover:underline">{{ $principal->email }}</a>
                            @else
                            N/A
                            @endif
                        </p>
                        <p><strong>Phone:</strong> {{ $principal->primaryContact->phone_e164 ?? 'N/A' }}</p>
                        <p><strong>Job Title:</strong> {{ $principal->primaryContact->job_title ?? 'N/A' }}</p>
                        @else
                        <p class="text-slate-500">No primary contact assigned</p>
                        @endif
                    </div>
                </div>

                {{-- All Contacts --}}
                <div class="p-6 mt-6 bg-white border shadow-xl border-slate-100 rounded-xl">
                    <h3 class="mb-3 text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-users"></i> All Contacts</h3>
                    @if($principal->contacts->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-cyan-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-slate-700">Name</th>
                                    <th class="px-4 py-3 text-left text-slate-700">Email</th>
                                    <th class="px-4 py-3 text-left text-slate-700">Phone</th>
                                    <th class="px-4 py-3 text-left text-slate-700">Job Title</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @foreach($principal->contacts as $contact)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3">
                                        {{ $contact->contact_name }}
                                        @if($contact->is_primary)
                                        <span class="ml-2 px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Primary</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ $contact->email ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $contact->phone_e164 ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $contact->job_title ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-slate-500">No contacts available</p>
                    @endif
                </div>
            </div>

            {{-- Brand & Product Info --}}
            <div class="grid gap-8 mt-6 md:grid-cols-2">
                {{-- Brands Section --}}
                <div class="p-6 space-y-3 bg-white border shadow-md border-slate-100 rounded-xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-certificate"></i> Brand Info</h3>
                        <a href="{{ route('principal.brands.create') }}" class="px-3 py-1 text-sm text-white bg-cyan-600 rounded-lg hover:bg-cyan-700">
                            <i class="mr-1 fa fa-plus"></i> Add
                        </a>
                    </div>
                    
                    @if($brands->count())
                    <div class="space-y-2">
                        @foreach($brands->take(3) as $brand)
                        <div class="flex items-center justify-between p-3 border border-slate-200 rounded-lg hover:bg-slate-50">
                            <div>
                                <p class="font-medium text-slate-800">{{ $brand->name }}</p>
                                <p class="text-sm text-slate-500">{{ $brand->category ?? 'No category' }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($brand->status == 'approved') text-green-700 bg-green-100
                                @elseif($brand->status == 'pending') text-yellow-700 bg-yellow-100
                                @else text-red-700 bg-red-100 @endif">
                                {{ ucfirst($brand->status) }}
                            </span>
                        </div>
                        @endforeach
                        
                        @if($brands->count() > 3)
                        <div class="pt-2 text-center">
                            <a href="{{ route('principal.brands.index') }}" class="text-sm text-cyan-600 hover:underline">
                                View all {{ $brands->count() }} brands
                            </a>
                        </div>
                        @endif
                    </div>
                    @else
                    <p class="text-slate-500">No brands added yet</p>
                    <a href="{{ route('principal.brands.create') }}" class="inline-block px-4 py-2 text-white bg-cyan-600 rounded-lg hover:bg-cyan-700">
                        <i class="mr-1 fa fa-plus"></i> Add First Brand
                    </a>
                    @endif
                </div>

                {{-- Products Section --}}
                <div class="p-6 space-y-4 bg-white border shadow-md border-slate-100 rounded-xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-boxes-stacked"></i> Product List</h3>
                        <a href="{{ route('principal.products.create') }}" class="px-3 py-1 text-sm text-white bg-cyan-600 rounded-lg hover:bg-cyan-700">
                            <i class="mr-1 fa fa-plus"></i> Add
                        </a>
                    </div>
                    
                    @if($products->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-cyan-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-slate-700">Product Name</th>
                                    <th class="hidden px-4 py-3 text-left text-slate-700 sm:table-cell">Price</th>
                                    <th class="px-4 py-3 text-left text-slate-700">Status</th>
                                    <th class="px-4 py-3 text-left text-slate-700">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @foreach($products->take(5) as $product)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3">{{ $product->name }}</td>
                                    <td class="hidden px-4 py-3 sm:table-cell">
                                        @if($product->price)
                                        ${{ number_format($product->price, 2) }}
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($product->submission_status == 'approved') text-green-700 bg-green-100
                                            @elseif($product->submission_status == 'pending') text-yellow-700 bg-yellow-100
                                            @else text-red-700 bg-red-100 @endif">
                                            {{ ucfirst($product->submission_status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('principal.products.edit', $product) }}" 
                                           class="text-sm font-medium text-cyan-600 hover:text-cyan-800">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($products->count() > 5)
                        <div class="pt-3 text-center">
                            <a href="{{ route('principal.products.index') }}" class="text-sm text-cyan-600 hover:underline">
                                View all {{ $products->count() }} products
                            </a>
                        </div>
                        @endif
                    </div>
                    @else
                    <p class="text-slate-500">No products added yet</p>
                    <a href="{{ route('principal.products.create') }}" class="inline-block px-4 py-2 text-white bg-cyan-600 rounded-lg hover:bg-cyan-700">
                        <i class="mr-1 fa fa-plus"></i> Add First Product
                    </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-8">
            {{-- Addresses --}}
            <div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl">
                <h3 class="mb-4 text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-map-marked-alt"></i> Addresses</h3>
                @if($principal->addresses->count())
                <div class="space-y-3">
                    @foreach($principal->addresses as $address)
                    <div class="p-3 border border-slate-200 rounded-lg hover:bg-slate-50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">
                                {{ ucfirst($address->type) }}
                            </span>
                        </div>
                        <p class="text-sm font-medium text-slate-800">{{ $address->line1 }}</p>
                        @if($address->line2)
                        <p class="text-sm text-slate-600">{{ $address->line2 }}</p>
                        @endif
                        <p class="text-xs text-slate-500">
                            {{ $address->city ?? '' }}{{ $address->state ? ', '.$address->state : '' }}{{ $address->postal ? ' '.$address->postal : '' }}
                        </p>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-slate-500">No addresses available</p>
                @endif
            </div>



{{-- Quick Contact --}}
<div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl">
    <h3 class="mb-4 text-xl font-semibold text-slate-700">
        <i class="mr-2 text-cyan-500 fa fa-bolt-lightning"></i> Quick Contact
    </h3>
    
    @if($principal->primaryContact || $principal->email)
    <div class="space-y-4">
        <!-- Contact Info -->
        {{-- <div class="p-3 bg-slate-50 rounded-lg">
            <p class="text-sm font-medium text-slate-800">
                {{ $principal->primaryContact->contact_name ?? 'Contact' }}
            </p>
            <p class="text-xs text-slate-600">
                {{ $principal->primaryContact->job_title ?? 'Primary Contact' }}
            </p>
        </div> --}}

        <!-- Contact Buttons -->
        <div class="flex flex-wrap gap-3">
            @php
                // Get phone from primary contact or principal
                $phone = $principal->primaryContact->phone_e164 ?? 
                         $principal->primaryContact->phone ?? 
                         $principal->phone ?? null;
                
                // Get email from primary contact OR principal's email field
                $email = $principal->primaryContact->email ?? $principal->email ?? null;
                
                $whatsapp = $principal->primaryContact->whatsapp ?? $phone;
                $wechat = $principal->primaryContact->wechat ?? null;
            @endphp

            <!-- Phone -->
            @if($phone)
            <a href="tel:{{ $phone }}" 
               class="flex flex-col items-center justify-center w-16 h-16 transition duration-200 border rounded-full group border-slate-300 hover:bg-slate-100 hover:shadow-md"
               title="Call {{ $phone }}">
                <i class="mb-1 text-slate-600 fa fa-phone group-hover:text-cyan-600"></i>
                <span class="text-xs text-slate-500">Call</span>
            </a>
            @endif

            <!-- Email - FIXED -->
            @if(!empty($email))
            <a href="mailto:{{ $email }}" 
               class="flex flex-col items-center justify-center w-16 h-16 transition duration-200 border rounded-full group border-slate-300 hover:bg-slate-100 hover:shadow-md"
               title="Email {{ $email }}">
                <i class="mb-1 text-slate-600 fa fa-envelope group-hover:text-cyan-600"></i>
                <span class="text-xs text-slate-500">Email</span>
            </a>
            @endif

            <!-- WhatsApp - FIXED CSS CLASSES -->
            @if($whatsapp)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}?text=Hello%20{{ urlencode($principal->primaryContact->contact_name ?? 'there') }}" 
               target="_blank"
               class="flex flex-col items-center justify-center w-16 h-16 transition duration-200 border rounded-full group border-green-300 hover:bg-green-50 hover:shadow-md"
               title="Message on WhatsApp">
                <i class="mb-1 text-green-600 fa-brands fa-whatsapp group-hover:text-green-700"></i>
                <span class="text-xs text-green-600">WhatsApp</span>
            </a>
            @endif

            <!-- WeChat - FIXED CSS CLASSES -->
            @if($wechat)
            <button onclick="showWechatModal('{{ $wechat }}')"
                    class="flex flex-col items-center justify-center w-16 h-16 transition duration-200 border rounded-full group border-green-400 hover:bg-green-50 hover:shadow-md"
                    title="WeChat ID: {{ $wechat }}">
                <i class="mb-1 text-green-600 fa-brands fa-weixin group-hover:text-green-700"></i>
                <span class="text-xs text-green-600">WeChat</span>
            </button>
            @endif

            <!-- SMS - FIXED CSS CLASSES -->
            @if($phone)
            <a href="sms:{{ $phone }}?body=Hello%20{{ urlencode($principal->primaryContact->contact_name ?? 'there') }}" 
               class="flex flex-col items-center justify-center w-16 h-16 transition duration-200 border rounded-full group border-blue-300 hover:bg-blue-50 hover:shadow-md"
               title="Send SMS">
                <i class="mb-1 text-blue-600 fa fa-comment group-hover:text-blue-700"></i>
                <span class="text-xs text-blue-600">SMS</span>
            </a>
            @endif
        </div>

      
    </div>
    @else
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 mb-3 bg-slate-100 rounded-full">
            <i class="text-slate-400 fa fa-user"></i>
        </div>
        <p class="text-slate-500">No contact information available</p>
        <p class="text-sm text-slate-400 mt-1">Add contact details to enable quick communication</p>
    </div>
    @endif
</div>

<!-- WeChat Modal -->
<dialog id="wechatModal" class="fixed inset-0 z-50 flex items-center justify-center hidden p-4 bg-black/30">
    <div class="w-full max-w-sm p-6 bg-white rounded-xl">
        <h3 class="mb-3 text-lg font-bold text-slate-800">WeChat Contact</h3>
        <div class="text-center">
            <i class="mb-4 text-4xl text-green-600 fa-brands fa-weixin"></i>
            <p class="mb-2 text-sm text-slate-600">WeChat ID:</p>
            <p class="mb-4 text-lg font-semibold text-slate-800" id="wechatId"></p>
            <p class="text-xs text-slate-500">Add this ID in WeChat to connect</p>
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="closeWechatModal()" class="px-4 py-2 text-white rounded-lg bg-cyan-600 hover:bg-cyan-700">Close</button>
        </div>
    </div>
</dialog>


            {{-- Security & Visibility --}}
            <div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl">
                <h3 class="mb-4 text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-shield-alt"></i> Security & Visibility</h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-medium text-slate-700">Visibility Scope</p>
                        <div class="flex flex-wrap gap-1 mt-1">
                            <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">
                                Global Access
                            </span>
                            @if($principal->visibility_scopes)
                            @foreach($principal->visibility_scopes as $scope)
                            <span class="px-2 py-1 text-xs font-medium text-slate-700 bg-slate-100 rounded-full">
                                {{ ucfirst($scope) }}
                            </span>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-700">Brand Access</p>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @if($principal->brands->count())
                            @foreach($principal->brands->take(3) as $brand)
                            <span class="px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                {{ $brand->name }}
                            </span>
                            @endforeach
                            @if($principal->brands->count() > 3)
                            <span class="px-2 py-1 text-xs font-medium text-slate-500 bg-slate-100 rounded-full">
                                +{{ $principal->brands->count() - 3 }} more
                            </span>
                            @endif
                            @else
                            <span class="text-xs text-slate-500">No brands assigned</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-700">Account Status</p>
                        <span class="inline-flex items-center px-2 py-1 mt-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                            <i class="mr-1 fa fa-check-circle"></i> Active & Verified
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Timeline, Notes, Activities --}}
    <div class="grid gap-6 mt-8 md:grid-cols-3">
        {{-- Recent Activities --}}
        <div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl">
            <h3 class="mb-4 text-xl font-semibold text-slate-700">Recent Activities</h3>
            @if($activities->count())
            <div class="space-y-4">
                @foreach($activities->take(5) as $activity)
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 mt-1 rounded-full flex items-center justify-center
                        @if($activity->type == 'note') bg-blue-100 text-blue-600
                        @elseif($activity->type == 'important') bg-red-100 text-red-600
                        @elseif($activity->type == 'task') bg-green-100 text-green-600
                        @else bg-slate-100 text-slate-600 @endif">
                        <i class="text-sm fa-solid fa-note-sticky"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-slate-700">{{ $activity->description }}</p>
                        <p class="text-xs text-slate-500">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-slate-500">No recent activities</p>
            @endif
        </div>

        {{-- Notes Summary --}}
        <div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl">
            <h3 class="mb-4 text-xl font-semibold text-slate-700">Notes Notifications</h3>
            @if($activities->where('type', 'note')->count())
            <div class="space-y-3">
                @foreach($activities->where('type', 'note')->take(3) as $note)
                <div class="p-3 border border-slate-200 rounded-lg hover:bg-slate-50">
                    <p class="text-sm text-slate-700 line-clamp-2">{{ $note->description }}</p>
                    <p class="text-xs text-slate-500 mt-1">{{ $note->created_at->diffForHumans() }}</p>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-slate-500">No notes yet</p>
            <button onclick="openModal('noteModal')" class="inline-block px-3 py-1 mt-2 text-sm text-white bg-cyan-600 rounded-lg hover:bg-cyan-700">
                <i class="mr-1 fa fa-plus"></i> Add Note
            </button>
            @endif
        </div>
    </div>

</div>

{{-- Note Modal --}}
<dialog id="noteModal" class="fixed inset-0 z-50 flex items-center justify-center hidden p-4 bg-black/30">
    <div class="w-full max-w-lg p-6 bg-white rounded-xl">
        <h3 class="mb-4 text-xl font-bold text-slate-800">Add Note</h3>
        <form action="{{ route('principal.notes.store') }}" method="POST">
            @csrf
            <textarea name="note" class="w-full p-3 border rounded-md" rows="5" placeholder="Type your note here..." required></textarea>
            <div class="flex justify-end mt-4 space-x-3">
                <button type="submit" class="px-4 py-2 text-white rounded-lg bg-cyan-600 hover:bg-cyan-700">Save Note</button>
                <button type="button" onclick="closeModal('noteModal')" class="px-4 py-2 border rounded-lg border-slate-300 hover:bg-slate-100">Cancel</button>
            </div>
        </form>
    </div>
</dialog>

@endsection

@section('script')
<script>
    // Simple modal functions
    function openModal(modalId) {
        document.getElementById(modalId).showModal();
    }

    function closeModal(modalId) {
        document.getElementById(modalId).close();
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.tagName === 'DIALOG') {
            e.target.close();
        }
    });

    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-btn');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                
                // Update active tab
                tabButtons.forEach(btn => {
                    btn.classList.remove('text-cyan-600', 'border-cyan-600');
                    btn.classList.add('text-slate-500', 'border-transparent');
                });
                this.classList.add('text-cyan-600', 'border-cyan-600');
                this.classList.remove('text-slate-500', 'border-transparent');
                
                // Show target content
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(target).classList.remove('hidden');
            });
        });
    });
</script>
<script>
// WeChat Modal Functions
function showWechatModal(wechatId) {
    document.getElementById('wechatId').textContent = wechatId;
    document.getElementById('wechatModal').showModal();
}

function closeWechatModal() {
    document.getElementById('wechatModal').close();
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    if (e.target.tagName === 'DIALOG') {
        e.target.close();
    }
});
</script>
@endsection