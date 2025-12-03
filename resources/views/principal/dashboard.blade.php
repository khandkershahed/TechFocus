@extends('principal.layouts.app')

@section('content')
<div class="p-5">
    <div class="p-5 bg-white">
   <div class="p-5 bg-white">
    <!-- HEADER -->
  <div class="gap-3 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <h1 class="mb-0 fw-bold text-primary fs-2">
                    {{ $principal->legal_name ?? $principal->name ?? 'COMPANY NAME LLC' }}
                </h1>
                @if($principal->country)
                    @php
                        $iso = \App\Helpers\CountryHelper::isoCode($principal->country->name);
                    @endphp
                    @if($iso)
                        <img src="https://flagsapi.com/{{ $iso }}/flat/32.png" 
                             class="rounded shadow-sm" width="32" height="24" alt="Flag">
                    @endif
                @endif
            </div>
            
            <div class="flex-wrap gap-2 d-flex mb-2">
                @if($principal->entity_type)
                    <span class="badge bg-gradient-primary text-dark">
                        <i class="fa fa-industry me-1"></i>{{ $principal->entity_type }}
                    </span>
                @endif
                @if($principal->code)
                    <span class="badge bg-gradient-primary text-light">{{ $principal->code }}</span>
                @endif
                <span class="badge bg-success text-green">
                    <i class="fa fa-check-circle me-1"></i>{{ ucfirst($principal->relationship_status ?? 'Active') }}
                </span>
                @if($principal->is_authorized)
                    <span class="badge bg-info text-dark">Authorized</span>
                @endif
                @if($principal->country)
                    <span class="badge bg-secondary text-dark">
                        <i class="fa fa-globe me-1"></i>{{ $principal->country->name }}
                    </span>
                @endif
            </div>
            
            <p class="text-muted mb-0">
             <small>
                 Created on <strong>{{ $principal->created_at->format('d M, Y') }}</strong> • 
                    By: <strong>{{ $principal->created_by ?? $principal->creator->name ?? 'System' }}</strong>
                </small>
            </p>
        </div>
            <div class="flex-wrap gap-2 mt-2 d-flex mt-md-0">
                <a href="{{ route('principal.profile.edit', $principal) }}" class="btn btn-primary">
                    <i class="fa fa-pen me-1"></i> Edit
                </a>
                <a href="{{ route('principal.links.index', $principal) }}" class="btn btn-success">
                    <i class="fa fa-share-nodes me-1"></i> Share
                </a>
                   
                   <a href="{{ route('principal.notes.index') }}"
                        class="btn btn-primary d-flex align-items-center px-4 py-2 fw-bold">
                            <i class="fa fa-sticky-note me-2 fa-lg"></i> ADD NOTE
                        </a>
                </div>
        </div>
        
        <!-- SECTION 1 — Company & Contact -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="gap-4 col-md-6 d-flex flex-column">
                <!-- Company Info -->
                <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #e9f0ff);">
                    <h2 class="mb-3 fs-5 fw-bold text-primary">Company Info</h2>
                    <p><strong>Company_Name:</strong> {{ $principal->name ?? 'N/A' }}</p>
                
                    <p><strong>Website:</strong> 
                        @if($principal->website_url)
                            <a href="{{ $principal->website_url }}" target="_blank" class="text-primary">{{ $principal->website_url }}</a>
                        @else
                            N/A
                        @endif
                    </p>
                    <p><strong>Country:</strong> {{ $principal->country->name ?? 'N/A' }}</p>
                    
                </div>

                <!-- Contacts -->
                <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f2f9ff);">
                    <h2 class="mb-3 fs-5 fw-bold text-primary">Contacts</h2>
                    <ul class="mb-3 nav nav-tabs" id="contactTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#primary" type="button">Primary</button>
                        </li>
                        @if($principal->contacts->where('is_primary', false)->count() > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#other" type="button">Other Contacts</button>
                        </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#social" type="button">Social</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Primary -->
                        <div class="tab-pane fade show active" id="primary">
                            @if($principal->primaryContact)
                            <div class="row g-3">
                                <div class="col-6">
                                    <p><strong>Name:</strong> {{ $principal->primaryContact->contact_name ?? 'N/A' }}</p>
                                    <p><strong>Designation:</strong> {{ $principal->primaryContact->job_title ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Email:</strong> 
                                        @if($principal->primaryContact->email)
                                            <a href="mailto:{{ $principal->primaryContact->email }}" class="text-primary">{{ $principal->primaryContact->email }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <p><strong>Phone:</strong> {{ $principal->primaryContact->phone_e164 ?? $principal->primaryContact->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                            @else
                            <p class="text-muted">No primary contact assigned</p>
                            @endif
                        </div>
                        
                        <!-- Other Contacts -->
                        @if($principal->contacts->where('is_primary', false)->count() > 0)
                        <div class="tab-pane fade" id="other">
                            @foreach($principal->contacts->where('is_primary', false)->take(2) as $contact)
                            <div class="row g-3 mb-4 pb-3 border-bottom">
                                <div class="col-6">
                                    <p><strong>Email:</strong> 
                                        @if($contact->email)
                                            <a href="mailto:{{ $contact->email }}" class="text-primary">{{ $contact->email }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <p><strong>Phone:</strong> {{ $contact->phone_e164 ?? $contact->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                            @endforeach
                            @if($principal->contacts->where('is_primary', false)->count() > 2)
                            <div class="mt-3">
                                {{-- <a href="{{ route('principal.contacts.index', $principal) }}" class="text-primary">
                                    View all {{ $principal->contacts->count() }} contacts →
                                </a> --}}
                            </div>
                            @endif
                        </div>
                        @endif
                        
                        <!-- Social -->
                        <div class="tab-pane fade" id="social">
                            @php
                                $socialContact = $principal->contacts->first();
                            @endphp
                            @if($socialContact)
                            <div class="row g-3">
                                <div class="col-6">
                                    <p><strong>WeChat:</strong> {{ $socialContact->wechat_id ?? 'N/A' }}</p>
                                </div>
                                 <div class="col-6">
                                    <p><strong>Whatsapp:</strong> {{ $socialContact->whatsapp_e164 ?? 'N/A' }}</p>
                                </div>
                            </div>
                            @else
                            <p class="text-muted">No social information available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="gap-4 col-md-6 d-flex flex-column">
    <!-- Address -->
    <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #e6f7ff);">
        <h2 class="mb-3 fs-5 fw-bold text-primary">Address</h2>
        
        @if($principal->addresses->count() > 0)
            <ul class="nav nav-tabs" id="addressTabs" role="tablist">
                @foreach($principal->addresses as $index => $address)
                    @if($index == 0) {{-- First address shows as HQ --}}
                        <li class="nav-item">
                            <button class="nav-link {{ $index == 0 ? 'active' : '' }}" 
                                    data-bs-toggle="tab" 
                                    data-bs-target="#address-{{ $address->id }}" 
                                    type="button">
                                HQ
                            </button>
                        </li>
                    @endif
                @endforeach
                
                {{-- Line 1 Tab --}}
                @foreach($principal->addresses as $index => $address)
                    @if($index == 0)
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" 
                                    data-bs-target="#line1-{{ $address->id }}" 
                                    type="button">
                                Line One
                            </button>
                        </li>
                    @endif
                @endforeach
                
                {{-- Line 2 Tab --}}
                @foreach($principal->addresses as $index => $address)
                    @if($index == 0 && $address->line2)
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" 
                                    data-bs-target="#line2-{{ $address->id }}" 
                                    type="button">
                                Line Two
                            </button>
                        </li>
                    @endif
                @endforeach
                
                {{-- City Tab --}}
                @foreach($principal->addresses as $index => $address)
                    @if($index == 0 && ($address->city || $address->state || $address->postal))
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" 
                                    data-bs-target="#city-{{ $address->id }}" 
                                    type="button">
                                City
                            </button>
                        </li>
                        @break
                    @endif
                @endforeach
                
                {{-- State & Postal Tab --}}
                @foreach($principal->addresses as $index => $address)
                    @if($index == 0 && ($address->state || $address->postal))
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" 
                                    data-bs-target="#state-{{ $address->id }}" 
                                    type="button">
                                State & Postal
                            </button>
                        </li>
                        @break
                    @endif
                @endforeach
            </ul>
            
            <div class="pt-3 tab-content">
                @foreach($principal->addresses as $index => $address)
                    @if($index == 0) {{-- Only show first address --}}
                        <!-- HQ Tab -->
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="address-{{ $address->id }}">
                            <p><strong>Address Type:</strong> {{ $address->type ?? 'HQ' }}</p>
                            @if($address->country_iso)
                                <p><strong>Country:</strong> 
                                    {{ \App\Helpers\CountryHelper::countryName($address->country_iso) ?? $address->country_iso }}
                                </p>
                            @endif
                            <p><strong>Full Address:</strong></p>
                            <p>{{ $address->line1 }}</p>
                            @if($address->line2)
                                <p>{{ $address->line2 }}</p>
                            @endif
                            @if($address->city || $address->state || $address->postal)
                                <p>
                                    {{ $address->city ?? '' }}{{ $address->city && $address->state ? ', ' : '' }}
                                    {{ $address->state ?? '' }}{{ ($address->city || $address->state) && $address->postal ? ' ' : '' }}
                                    {{ $address->postal ?? '' }}
                                </p>
                            @endif
                        </div>
                        
                        <!-- Line 1 Tab -->
                        <div class="tab-pane fade" id="line1-{{ $address->id }}">
                            <p><strong>Address Line 1:</strong></p>
                            <p class="fs-5">{{ $address->line1 }}</p>
                        </div>
                        
                        <!-- Line 2 Tab -->
                        @if($address->line2)
                            <div class="tab-pane fade" id="line2-{{ $address->id }}">
                                <p><strong>Address Line 2:</strong></p>
                                <p class="fs-5">{{ $address->line2 }}</p>
                            </div>
                        @endif
                        
                        <!-- City Tab -->
                        @if($address->city || $address->state || $address->postal)
                            <div class="tab-pane fade" id="city-{{ $address->id }}">
                                @if($address->city)
                                    <p><strong>City:</strong> {{ $address->city }}</p>
                                @endif
                                @if($address->state)
                                    <p><strong>State/Province:</strong> {{ $address->state }}</p>
                                @endif
                                @if($address->postal)
                                    <p><strong>Postal Code:</strong> {{ $address->postal }}</p>
                                @endif
                            </div>
                        @endif
                        
                        <!-- State & Postal Tab -->
                        @if($address->state || $address->postal)
                            <div class="tab-pane fade" id="state-{{ $address->id }}">
                                @if($address->state)
                                    <p><strong>State/Province:</strong></p>
                                    <p class="fs-5">{{ $address->state }}</p>
                                @endif
                                @if($address->postal)
                                    <p class="mt-3"><strong>Postal Code:</strong></p>
                                    <p class="fs-5">{{ $address->postal }}</p>
                                @endif
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        @else
            {{-- <div class="text-center py-4">
                <i class="fa fa-map-marker-alt fa-3x text-muted mb-3"></i>
                <p class="text-muted">No addresses available</p>
                <a href="{{ route('principal.addresses.create', $principal) }}" class="btn btn-primary btn-sm mt-2">
                    <i class="fa fa-plus me-1"></i> Add Address
                </a>
            </div> --}}
        @endif
    </div>

        

                <!-- Quick Contact -->
                <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f0fff0);">
                    <h2 class="mb-3 fs-5 fw-bold text-primary">Quick Contact</h2>
                    <div class="flex-wrap gap-3 d-flex justify-content-start">
                        @php
                            $primaryContact = $principal->primaryContact;
                            $phone = $primaryContact->phone_e164 ?? $primaryContact->phone ?? null;
                            $email = $primaryContact->email ?? $principal->email ?? null;
                            $whatsapp = $primaryContact->whatsapp ?? $phone;
                            $wechat = $primaryContact->wechat ?? null;
                        @endphp
                        
                        @if($phone)
                        <a href="tel:{{ $phone }}" class="btn btn-outline-primary btn-lg" title="Call">
                            <i class="fa fa-phone"></i>
                        </a>
                        @endif
                        
                        @if($email)
                        <a href="mailto:{{ $email }}" class="btn btn-outline-primary btn-lg" title="Email">
                            <i class="fa fa-envelope"></i>
                        </a>
                        @endif
                        
                        @if($whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}?text=Hello%20{{ urlencode($primaryContact->contact_name ?? 'there') }}" 
                           target="_blank" class="btn btn-outline-success btn-lg" title="WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        @endif
                        
                        @if($wechat)
                        <button class="btn btn-outline-info btn-lg" title="WeChat" onclick="showWechatModal('{{ $wechat }}')">
                            <i class="fa-brands fa-weixin"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

   <!-- SECTION 2 — Brand & Products -->
<div class="mt-2 row g-4">
    <!-- Brand Info -->
    <div class="gap-4 col-md-5 d-flex flex-column">
        <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f0f7ff);">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1 fs-5 fw-bold text-primary">Brand Info</h3>
                    <p class="mb-0 text-muted">Brand Portfolio</p>
                </div>
                <a href="{{ route('principal.brands.create') }}" class="btn btn-primary btn-sm">+ Add Brand</a>
            </div>

            <div class="gap-3 text-center d-flex">
                <div class="p-3 border rounded shadow-sm flex-fill bg-light">
                    <h6 class="mb-1 text-muted">Total Brands</h6>
                    <span class="fs-5 fw-bold text-success">{{ $brands->count() }}</span>
                </div>
                <div class="p-3 border rounded shadow-sm flex-fill bg-light">
                    <h6 class="mb-1 text-muted">Active</h6>
                    <span class="fs-5 fw-bold text-primary">{{ $brands->where('status', 'approved')->count() }}</span>
                </div>
                <div class="p-3 border rounded shadow-sm flex-fill bg-light">
                    <h6 class="mb-1 text-muted">Pending</h6>
                    <span class="fs-5 fw-bold text-warning">{{ $brands->where('status', 'pending')->count() }}</span>
                </div>
            </div>

            <div class="mt-4 table-responsive">
                <table class="table text-center align-middle table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th></th>
                            <th>Brand Status</th>
                            <th>Categories</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands->take(3) as $brand)
                        <tr style="cursor:pointer;" onclick="window.location.href='{{ route('principal.brands.edit', $brand) }}';">
                            <td>
                                <div class="position-relative d-inline-block">
                                    <a href="{{ route('principal.brands.edit', $brand) }}" class="position-absolute start-100 translate-middle">
                                        <i class="p-1 text-white fa fa-pencil bg-primary rounded-circle fs-6"></i>
                                    </a>
                                    @if($brand->logo)
                                        <img src="{{ asset('storage/brand/logo/' . $brand->logo) }}" 
                                             class="rounded img-fluid" 
                                             width="50" 
                                             height="50" 
                                             alt="{{ $brand->title }}"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/50?text=No+Logo';">
                                    @elseif($brand->image)
                                        <img src="{{ asset('storage/brand/image/' . $brand->image) }}" 
                                             class="rounded img-fluid" 
                                             width="50" 
                                             height="50" 
                                             alt="{{ $brand->title }}"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/50?text=No+Image';">
                                    @else
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                            <i class="fa fa-certificate text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($brand->status == 'approved') bg-success
                                    @elseif($brand->status == 'pending') bg-warning text-dark
                                    @elseif($brand->status == 'rejected') bg-danger
                                    @else bg-secondary @endif">
                                    {{ ucfirst($brand->status) }}
                                </span>
                            </td>
                            <td>{{ $brand->category ?? 'No category' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No brands added yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Brand List -->
    <div class="gap-4 col-md-7 d-flex flex-column">
        <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f9f9ff);">
            <h3 class="mb-3 fs-5 fw-bold text-primary">Brand List</h3>
            <div class="table-responsive">
                <table class="table text-center align-middle table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start ps-4">Brand Image</th>
                            <th>Brand Name</th>
                            <th>Status</th>
                            <th>Created Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands->take(5) as $brand)
                        <tr style="cursor:pointer;" onclick="window.location.href='{{ route('principal.brands.edit', $brand) }}';">
                            <td class="text-start">
                                @if($brand->logo)
                                    <img src="{{ asset('storage/brand/logo/' . $brand->logo) }}" 
                                         class="rounded-2" 
                                         style="width:50px;height:50px;object-fit:cover;border:2px solid #dee2e6;"
                                         alt="{{ $brand->title }}"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/50?text=No+Logo';">
                                @elseif($brand->image)
                                    <img src="{{ asset('storage/brand/image/' . $brand->image) }}" 
                                         class="rounded-2" 
                                         style="width:50px;height:50px;object-fit:cover;border:2px solid #dee2e6;"
                                         alt="{{ $brand->title }}"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/50?text=No+Image';">
                                @else
                                    <div class="rounded-2 bg-light d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                        <i class="fa fa-certificate text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $brand->title }}</td>
                            <td>
                                <span class="badge 
                                    @if($brand->status == 'approved') bg-success
                                    @elseif($brand->status == 'pending') bg-warning text-dark
                                    @elseif($brand->status == 'rejected') bg-danger
                                    @else bg-secondary @endif">
                                    {{ ucfirst($brand->status) }}
                                </span>
                            </td>
                            <td>{{ $brand->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No brands available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SECTION 3 — Product Info & Product List Table -->
<div class="mt-2 row g-4">
    <!-- Product Info Summary -->
    <div class="gap-4 col-md-5 d-flex flex-column">
        <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f0f7ff);">
            <div class="mb-3 d-flex justify-content-between">
                <div>
                    <h3 class="mb-1 fs-5 fw-bold text-primary">Product Info</h3>
                    <p class="mb-0 text-muted">Top Products Overview</p>
                </div>
                <a href="{{ route('principal.products.create') }}" class="btn btn-primary btn-sm">+ Add Product</a>
            </div>

            <div class="gap-3 text-center d-flex">
                <div class="p-3 border rounded shadow-sm flex-fill bg-light">
                    <h6 class="mb-1 text-muted">Total Products</h6>
                    <span class="fs-5 fw-bold text-success">{{ $products->count() }}</span>
                </div>
                <div class="p-3 border rounded shadow-sm flex-fill bg-light">
                    <h6 class="mb-1 text-muted">Active</h6>
                    <span class="fs-5 fw-bold text-primary">{{ $products->where('submission_status', 'approved')->count() }}</span>
                </div>
                <div class="p-3 border rounded shadow-sm flex-fill bg-light">
                    <h6 class="mb-1 text-muted">Pending</h6>
                    <span class="fs-5 fw-bold text-warning">{{ $products->where('submission_status', 'pending')->count() }}</span>
                </div>
            </div>

            <div class="mt-4 table-responsive">
                <table class="table text-center align-middle table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th></th>
                            <th>Product</th>
                            <th>Brand</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products->take(3) as $product)
                        <tr style="cursor:pointer;" onclick="window.location.href='{{ route('principal.products.edit', $product) }}';">
                            <td>
                                @if($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                                         class="rounded img-fluid" 
                                         width="50" 
                                         height="50" 
                                         alt="{{ $product->name }}"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/50?text=Product';">
                                @else
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                        <i class="fa fa-box text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ Str::limit($product->name, 20) }}</td>
                            <td>
                                @if($product->brand)
                                    {{ $product->brand->title }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    @if($product->submission_status == 'approved') bg-success
                                    @elseif($product->submission_status == 'pending') bg-warning text-dark
                                    @elseif($product->submission_status == 'rejected') bg-danger
                                    @else bg-secondary @endif">
                                    {{ ucfirst($product->submission_status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No products added yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Product List Table -->
    <div class="gap-4 col-md-7 d-flex flex-column">
        <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f9f9ff);">
            <h3 class="mb-3 fs-5 fw-bold text-primary">Product List</h3>
            <div class="table-responsive">
                <table class="table text-center align-middle table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start ps-4">Logo</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Status</th>
                            <th>Created Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products->take(5) as $product)
                        <tr>
                            <td class="text-start">
                                @if($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" 
                                         class="rounded-2" 
                                         style="width:50px;height:50px;object-fit:cover;border:2px solid #dee2e6;"
                                         alt="{{ $product->name }}"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/50?text=Product';">
                                @else
                                    <div class="rounded-2 bg-light d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                        <i class="fa fa-box text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ Str::limit($product->name, 25) }}</td>
                            <td>{{ $product->sku_code ?? 'N/A' }}</td>
                            <td>
                                <span class="badge 
                                    @if($product->submission_status == 'approved') bg-success
                                    @elseif($product->submission_status == 'pending') bg-warning text-dark
                                    @elseif($product->submission_status == 'rejected') bg-danger
                                    @else bg-secondary @endif">
                                    {{ ucfirst($product->submission_status) }}
                                </span>
                            </td>
                            <td>{{ $product->created_at->format('Y-m-d') }}</td>
                         <td>
                            <a href="{{ route('principal.products.index') }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No products available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- SECTION 4 — AGREEMENTS & RESOURCES -->
<div class="mt-2 row g-4">
    <!-- Useful Links & Notes -->
    <div class="col-md-6">
        <div class="p-4 bg-white border shadow-sm rounded-4">
            <h3 class="mb-3 fs-4 fw-bold">Your Share Links</h3>
            
            @php
                // Get all links for this principal
                $principalLinks = $principal->links;
                $displayedLinks = 0;
                $maxDisplay = 5;
            @endphp
            
            @if($principalLinks->count() > 0)
                <div class="list-group">
                    @foreach($principalLinks as $linkRecord)
                        @if(is_array($linkRecord->label))
                            @foreach($linkRecord->label as $index => $label)
                                @if($displayedLinks < $maxDisplay && isset($linkRecord->url[$index]))
                                    <a href="{{ $linkRecord->url[$index] }}" target="_blank" 
                                       class="list-group-item list-group-item-action d-flex align-items-center text-decoration-none py-2 px-3 mb-1 rounded-2">
                                        <i class="fa fa-external-link text-primary me-3"></i>
                                        <div class="flex-grow-1">
                                            <div class="fw-medium text-dark">{{ $label }}</div>
                                            @if(isset($linkRecord->type[$index]) && $linkRecord->type[$index])
                                                <small class="text-muted">
                                                    <i class="fa fa-tag me-1"></i>{{ $linkRecord->type[$index] }}
                                                </small>
                                            @endif
                                            
                                            @if(isset($linkRecord->file[$index]) && is_array($linkRecord->file[$index]) && count($linkRecord->file[$index]) > 0)
                                                <div class="mt-1">
                                                    @foreach($linkRecord->file[$index] as $file)
                                                        @php
                                                            $fileName = basename($file);
                                                        @endphp
                                                        <span class="badge bg-light text-dark border me-1">
                                                            <i class="fa fa-paperclip me-1"></i>
                                                            {{ Str::limit($fileName, 15) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <i class="fa fa-chevron-right text-muted"></i>
                                    </a>
                                    @php $displayedLinks++; @endphp
                                @endif
                            @endforeach
                        @else
                            <!-- Fallback for single link records -->
                            @if($displayedLinks < $maxDisplay)
                                <a href="{{ $linkRecord->url }}" target="_blank" 
                                   class="list-group-item list-group-item-action d-flex align-items-center text-decoration-none py-2 px-3 mb-1 rounded-2">
                                    <i class="fa fa-external-link text-primary me-3"></i>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium text-dark">{{ $linkRecord->label }}</div>
                                        @if($linkRecord->type)
                                            <small class="text-muted">
                                                <i class="fa fa-tag me-1"></i>{{ $linkRecord->type }}
                                            </small>
                                        @endif
                                    </div>
                                    <i class="fa fa-chevron-right text-muted"></i>
                                </a>
                                @php $displayedLinks++; @endphp
                            @endif
                        @endif
                    @endforeach
                </div>
                
                @php
                    // Calculate total links count
                    $totalLinksCount = 0;
                    foreach ($principalLinks as $linkRecord) {
                        if (is_array($linkRecord->label)) {
                            $totalLinksCount += count($linkRecord->label);
                        } else {
                            $totalLinksCount++;
                        }
                    }
                @endphp
                
                @if($totalLinksCount > $maxDisplay)
                    <div class="mt-3 pt-3 border-top">
                        <a href="{{ route('principal.links.index', $principal) }}" class="text-primary text-decoration-none fw-medium">
                            <i class="fa fa-eye me-1"></i> View all {{ $totalLinksCount }} links →
                        </a>
                    </div>
                @endif
                
            @else
                {{-- <div class="text-center py-4">
                    <div class="mb-3">
                        <i class="fa fa-external-link-alt fa-3x text-muted"></i>
                    </div>
                    <p class="text-muted mb-4">No useful links added yet</p>
                    <a href="{{ route('principal.links.create', $principal) }}" class="btn btn-primary">
                        <i class="fa fa-plus me-1"></i> Add Links
                    </a>
                </div> --}}
            @endif
        </div>
    </div>
           <!-- Security & Visibility -->
            <div class="col-md-6">
                <div class="p-4 bg-white border shadow-sm rounded-4">
                    <h3 class="mb-3 fs-4 fw-bold">Security & Visibility</h3>
                    <!-- Key Info Cards -->
                    <div class="flex-wrap gap-3 d-flex flex-column">
                        <div class="d-flex justify-content-between">
                            <!-- Visibility Scope -->
                            <div class="p-3 text-center border rounded shadow-sm flex-fill bg-light">
                                <h6 class="mb-1 text-muted">Visibility Scope</h6>
                                @if($principal->visibility_scopes)
                                    <span class="fs-6 fw-bold">{{ implode(' / ', array_map('ucfirst', $principal->visibility_scopes)) }}</span>
                                @else
                                    <span class="fs-6 fw-bold text-muted">Principal </span>
                                @endif
                            </div>
                            <!-- Brand Access -->
                            <div class="p-3 text-center border rounded shadow-sm flex-fill bg-light">
                                <h6 class="mb-1 text-muted">Brand Access</h6>
                                <span class="fs-6 fw-bold">
                                    @if($brands->count() > 0)
                                        {{ $brands->count() }} brands
                                    @else
                                        No brands
                                    @endif
                                </span>
                            </div>
                        </div>
                        <!-- Account Status -->
                        <div class="p-3 text-center border rounded shadow-sm flex-fill bg-light">
                            <h6 class="mb-1 text-muted">Account Status</h6>
                            <span class="fs-5 fw-bold 
                                @if($principal->status == 'active') text-success
                                @elseif($principal->status == 'pending') text-warning
                                @else text-denger @endif">
                                {{ ucfirst($principal->status ?? 'active') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- SUMMARY -->
        <div class="mt-4 row row-cols-md-4 g-3">
            <div class="col">
                <div class="p-4 text-center shadow-sm bg-light rounded-4">
                    <h6 class="fw-semibold">Assigned Manager</h6>
                    <p>{{ $principal->assignedManager->name ?? 'Not assigned' }}</p>
                </div>
            </div>
            <div class="col">
                <div class="p-4 text-center shadow-sm bg-light rounded-4">
                    <h6 class="fw-semibold">2024 Purchase</h6>
                    <p>
                        @if($principal->total_purchase_2024)
                            ${{ number_format($principal->total_purchase_2024, 0) }} USD
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="p-4 text-center shadow-sm bg-light rounded-4">
                    <h6 class="fw-semibold">Risk Level</h6>
                    <p class="{{ $principal->risk_level >= 7 ? 'text-danger fw-bold' : ($principal->risk_level >= 4 ? 'text-warning fw-bold' : 'text-success fw-bold') }}">
                        @if($principal->risk_level)
                            {{ $principal->risk_level >= 7 ? 'High' : ($principal->risk_level >= 4 ? 'Medium' : 'Low') }} 
                            ({{ $principal->risk_level }}/10)
                        @else
                            Not assessed
                        @endif
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="p-4 text-center shadow-sm bg-light rounded-4">
                    <h6 class="fw-semibold">Relationship</h6>
                    <p>Since {{ $principal->relationship_start_date ? $principal->relationship_start_date->format('Y') : $principal->created_at->format('Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function showWechatModal(wechatId) {
        document.getElementById('wechatIdDisplay').textContent = wechatId;
        var modal = new bootstrap.Modal(document.getElementById('wechatModal'));
        modal.show();
    }
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
