@extends('principal.layouts.app')

@section('content')
<div class="container mb-10">
    <div class="card card-flush">
        <div class="py-4 card-header">
            <div class="mt-2">
              <h1 class="mb-3 text-black">
                {{ $principal->legal_name ?? $principal->name ?? 'COMPANY NAME LLC' }}
            </h1>
                <div>
                     <span class="badge badge-light-success fs-10px">
                    Supplier Type: {{ $principal->entity_type ?? 'Manufacturer' }}
                </span>
                  <span class="badge badge-light-info fs-10px">
                    Supplier ID: {{ $principal->id ?? 'SUP-00123' }}
                </span>
                       <span class="badge badge-light-warning fs-10px">
                    {{ $principal->relationship_status ?? 'Active' }}
                </span>
                         {{-- Authorization --}}
                <span class="badge badge-light-success fs-10px">
                    {{ $principal->status ?? 'Authorized' }}
                </span>
                </div>
            </div>
            <div class="gap-2 d-flex align-items-center gap-lg-3">
                <a href="{{ route('principal.profile.edit', $principal->id) }}" class="btn btn-sm fw-bold btn-secondary">
                    <i class="fa fa-pen me-1"></i> Edit
                </a>
                <a href="{{ route('principal.notes.index', $principal->id) }}" class="btn btn-sm fw-bold btn-primary" >
                    <i class="fa fa-sticky-note me-1"></i> Add Note
                </a>
            </div>
     </div>
        <div class="pt-2 card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="px-5 border rounded shadow-sm border-light card card-flush">
                        <div class="p-3 card-header">
                            <h3 class="text-black card-title fw-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="building" class="w-5 h-5 lucide lucide-building text-accent">
                                    <path d="M12 10h.01"></path>
                                    <path d="M12 14h.01"></path>
                                    <path d="M12 6h.01"></path>
                                    <path d="M16 10h.01"></path>
                                    <path d="M16 14h.01"></path>
                                    <path d="M16 6h.01"></path>
                                    <path d="M8 10h.01"></path>
                                    <path d="M8 14h.01"></path>
                                    <path d="M8 6h.01"></path>
                                    <path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"></path>
                                    <rect x="4" y="2" width="16" height="20" rx="2"></rect>
                                </svg>
                                Company Info
                            </h3>

                            <div class="card-toolbar">
                                <button
                                    class="border btn btn-icon btn-sm rounded-circle btn-light btn-active-color-primary justify-content-center">
                                    <i class="text-gray-500 fas fa-pen"></i>
                                </button>
                            </div>
                        </div>

                        <div class="p-3 card-body">
                            <div class="d-flex flex-stack">
                               <a href="#" class="text-black fw-semibold fs-6 me-2">Company Name:</a>
                                {{ $principal->name ?? $principal->name ?? 'N/A' }}
                            </div>

                            <div class="my-3 separator separator-dashed"></div>

                            <div class="d-flex flex-stack">
                                <a href="#" class="text-black fw-semibold fs-6 me-2">Website:</a>
                                   <a href="{{ $principal->website_url }}" target="_blank">
                                       {{ $principal->website_url }}    </a>
                            </div>

                            <div class="my-3 separator separator-dashed"></div>

                            <div class="d-flex flex-stack">
                                <a href="#" class="text-black fw-semibold fs-6 me-2">Country:</a>

                                <div class="d-flex flex-stack">
                                    <span class="fw-semibold pe-3">
                            {{ $principal->country->name ?? 'N/A' }}      </span>
                                    <div class="cursor-pointer" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                         @php
                                                    $iso = \App\Helpers\CountryHelper::isoCode($principal->country->name);
                                                    @endphp
                                                    @if($iso)
                                                    <img src="https://flagsapi.com/{{ $iso }}/flat/32.png"
                                                        class="w-8 h-8 rounded-lg shadow-sm" alt="Flag">
                                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="my-3 separator separator-dashed"></div>

                            <div class="d-flex flex-stack">
                                <a href="#" class="text-black fw-semibold fs-6 me-2">Operational Offices:</a>
                                      {{ $principal->hq_city ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
              
                <div class="col-lg-8">
                    <div class="border rounded shadow-sm border-light card card-flush">
                        <div class="p-3 card-header d-flex justify-content-between align-items-center">
                            <h3 class="text-black card-title fw-bold ps-3">Addresses & Offices</h3>
                            <div>
                                <ul class="px-3 pt-2 nav nav-tabs nav-line-tabs fs-6">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_1">Offices</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">Social & Contact</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3">Commercial Info</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="pb-3 tab-content" id="myTabContent">

                                <!-- Headquarters -->
                                <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                                    <div class="d-flex justify-content-between">
                                        
                                            {{-- MAIN OFFICE – HQ --}}
                                            @php
                                                $mainOffice = $principal->addresses->where('type', 'HQ')->first();
                                            @endphp
                                        <div>
                                            <h5 class="pb-2 fw-bold">Main Office</h5>
                                            @if($mainOffice)
                                                        <p class="mb-1">
                                                            <i class="fas fa-location-dot me-2"></i>
                                                            {{ $mainOffice->line1 }}
                                                        </p>
                                                        <p class="mb-1 ps-5">
                                                            {{ $mainOffice->line2 ? $mainOffice->line2 . ', ' : '' }}
                                                            {{ $mainOffice->city }},
                                                            {{ $mainOffice->country_iso }}
                                                        </p>
                                                    @else
                                                        <p class="text-muted">No office address added</p>
                                                    @endif
                                        </div>
                                          @php
                                                $factoryOffice = $principal->addresses->where('type', 'Shipping')->first();
                                            @endphp
                                        <div>
                                            <h5 class="pb-2 fw-bold">Factory Office</h5>
                                           @if($factoryOffice)
                                                    <p class="mb-1">
                                                        <i class="fas fa-location-dot me-2"></i>
                                                        {{ $factoryOffice->line1 }}
                                                    </p>
                                                    <p class="mb-1 ps-5">
                                                        {{ $factoryOffice->line2 ? $factoryOffice->line2 . ', ' : '' }}
                                                        {{ $factoryOffice->city }},
                                                        {{ $factoryOffice->country_iso }}
                                                    </p>
                                                @else
                                                    <p class="text-muted">No factory address added</p>
                                                @endif
                                        </div>
                                           @php
                                                $warehouse = $principal->addresses->where('type', 'Billing')->first();
                                            @endphp
                                        <div>
                                            <h5 class="pb-2 fw-bold">Warehouse</h5>
                                             @if($warehouse)
                                                        <p class="mb-1">
                                                            <i class="fas fa-location-dot me-2"></i>
                                                            {{ $warehouse->line1 }}
                                                        </p>
                                                        <p class="mb-1 ps-5">
                                                            {{ $warehouse->line2 ? $warehouse->line2 . ', ' : '' }}
                                                            {{ $warehouse->city }},
                                                            {{ $warehouse->country_iso }}
                                                        </p>
                                                    @else
                                                        <p class="text-muted">No warehouse address added</p>
                                                    @endif
                                        </div>

                                        <div>
                                            <h6 class="pb-2 mb-1 fw-bold">Working Hours</h6>
                                           @if(!empty($principal->working_hours))
                                                    {!! nl2br(e($principal->working_hours)) !!}
                                                @else
                                                    <p>Sun - Thu <br> 9:00 AM – 6:00 PM</p>
                                                @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Social -->
                                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                                    <div class="gap-10 d-flex">
                                        <div>
                                            <h6 class="pb-2 fw-bold">Contact</h6>
                                          @if ($principal->primaryContact?->phone_e164)
                                                    <p class="mb-1">
                                                        <i class="fa fa-phone me-2"></i>
                                                        {{ $principal->primaryContact->phone_e164 }}
                                                    </p>
                                                @endif
                                             {{-- Email --}}
                                                    @if ($principal->email)
                                                        <p>
                                                            <i class="fa fa-envelope me-2"></i>
                                                            {{ $principal->email }}
                                                        </p>
                                                    @endif
                                        </div>
                                        <div>
                                            <h6 class="pb-2 fw-bold">Social</h6>
                                            <div>
                                                <a href="#" class="border me-3 btn btn-icon btn-sm rounded-circle btn-light btn-active-color-primary justify-content-center">
                                                    <i class="text-gray-500 fab fa-linkedin-in" aria-hidden="true"></i>
                                                </a>
                                                <a href="#" class="border me-3 btn btn-icon btn-sm rounded-circle btn-light btn-active-color-primary justify-content-center">
                                                    <i class="text-gray-500 fab fa-whatsapp" aria-hidden="true"></i>
                                                </a>
                                                <a href="#" class="border me-3 btn btn-icon btn-sm rounded-circle btn-light btn-active-color-primary justify-content-center">
                                                    <i class="text-gray-500 fas fa-comment" aria-hidden="true"></i>
                                                </a>
                                                <a href="#" class="border me-3 btn btn-icon btn-sm rounded-circle btn-light btn-active-color-primary justify-content-center">
                                                    <i class="text-gray-500 fab fa-instagram" aria-hidden="true"></i>
                                                </a>
                                                <a href="#" class="border me-3 btn btn-icon btn-sm rounded-circle btn-light btn-active-color-primary justify-content-center">
                                                    <i class="text-gray-500 fab fa-linkedin-in" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Info -->
                                <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="pb-2 fw-bold">Islami Bank PLC</h5>
                                            <p class="mb-1">
                                                <i class="fab fa-cc-mastercard me-2"></i> 12 12 12 12 12 12
                                            </p>
                                            <p class="mb-1 ps-5">XXXX | Year: YYYY</p>
                                        </div>
                                        <div>
                                            <h5 class="pb-2 fw-bold">UCB Bank Ltd</h5>
                                            <p class="mb-1">
                                                <i class="fab fa-cc-mastercard me-2"></i> 12 12 12 12 12 12
                                            </p>
                                            <p class="mb-1 ps-5">XXXX | Year: YYYY</p>
                                        </div>
                                        <div>
                                            <h5 class="pb-2 fw-bold">Western Union Bank</h5>
                                            <p class="mb-1">
                                                <i class="fab fa-cc-mastercard me-2"></i> 12 12 12 12 12 12
                                            </p>
                                            <p class="mb-1 ps-5">XXXX | Year: YYYY</p>
                                        </div>
                                        <div>
                                            <h5 class="pb-2 fw-bold">Bank Asia Mohammadpur</h5>
                                            <p class="mb-1">
                                                <i class="fab fa-cc-mastercard me-2"></i> 12 12 12 12 12 12
                                            </p>
                                            <p class="mb-1 ps-5">XXXX | Year: YYYY</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-4 mt-5 border rounded shadow-sm border-light card card-flush">
                        <h3 class="mb-5 text-black card-title fw-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="users" class="w-5 h-5 lucide lucide-users text-accent">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <path d="M16 3.128a4 4 0 0 1 0 7.744"></path>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                            </svg>
                            Key Contacts Info
                        </h3>
                        <!-- Tabs -->
                        <ul class="gap-1 mb-5 nav nav-pills">
                            <li class="nav-item">
                                <button class="px-4 py-2 rounded-pill btn-sm nav-link active fw-semibold" data-bs-toggle="pill" data-bs-target="#primaryContact">
                                    Primary
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="px-4 py-2 rounded-pill btn-sm nav-link fw-semibold" data-bs-toggle="pill" data-bs-target="#secondaryContact">
                                    Secondary
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="px-4 py-2 rounded-pill btn-sm nav-link fw-semibold" data-bs-toggle="pill" data-bs-target="#otherContact">
                                    Other
                                </button>
                            </li>
                        </ul>
                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Primary -->
                              {{-- PRIMARY CONTACT --}}
            <div class="tab-pane fade show active" id="primaryContact">
                @php $pc = $principal->primaryContact; @endphp
                @if($pc)
                    <div class="pt-2 row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Contact Type:</strong> {{ $pc->preferred_channel ?? 'Technical' }}</p>
                            <p class="mb-1"><strong>Name:</strong> {{ $pc->contact_name }}</p>
                            <p class="mb-1"><strong>Designation:</strong> {{ $pc->job_title ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Email:</strong> {{ $pc->email ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $pc->phone_e164 ?? 'N/A' }}</p>
                            <div>
                                @if($pc->linkedin_url ?? false)
                                    <a class="pe-3 justify-content-center">
                                        <i class="text-gray-500 fab fa-linkedin-in"></i>
                                    </a>
                                @endif
                                @if($pc->whatsapp_e164)
                                    <a class="pe-3 justify-content-center">
                                        <i class="text-gray-500 fab fa-whatsapp"></i>
                                    </a>
                                @endif
                                @if($pc->wechat_id)
                                    <a class="pe-3 justify-content-center">
                                        <i class="text-gray-500 fas fa-comment"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-muted">No primary contact added.</p>
                @endif
            </div>
                            <!-- Secondary -->
                              {{-- SECONDARY CONTACTS --}}
            <div class="tab-pane fade" id="secondaryContact">
                @forelse($principal->secondaryContacts ?? [] as $sc)
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Contact Type:</strong> {{ $sc->preferred_channel ?? 'Technical' }}</p>
                            <p class="mb-1"><strong>Name:</strong> {{ $sc->contact_name }}</p>
                            <p class="mb-1"><strong>Designation:</strong> {{ $pc->job_title ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Email:</strong> {{ $sc->email ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $sc->phone_e164 ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Social:</strong> 
                                {{ $sc->wechat_id ? 'WeChat' : ($sc->whatsapp_e164 ? 'WhatsApp' : 'N/A') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No secondary contacts available.</p>
                @endforelse
            </div>
                    
                        {{-- OTHER CONTACTS --}}
            <div class="tab-pane fade" id="otherContact">
                @forelse($principal->otherContacts ?? [] as $oc)
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Contact Type:</strong> Other</p>
                            <p class="mb-1"><strong>Name:</strong> {{ $oc->contact_name }}</p>
                            <p class="mb-1"><strong>Designation:</strong> {{ $oc->job_title ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Email:</strong> {{ $oc->email ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $oc->phone_e164 ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Social:</strong> {{ $oc->preferred_channel ?? 'N/A' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No other contacts available.</p>
                @endforelse
            </div>

        </div>
    </div>
</div>
                <div class="mt-5 border rounded shadow-sm col-lg-6 d-flex justify-content-center align-items-center border-light">
                    <div class="text-center ps-10">
                        <div>
                            <h3 class="mb-5 text-black card-title fw-bold">Quick Contact</h3>
                        </div>
                        <div>
                            <a href="#" class="border me-3 btn btn-icon btn-sm rounded-circle btn-light btn-active-color-primary justify-content-center">
                                <i class="text-gray-500 fab fa-linkedin-in" aria-hidden="true"></i>
                            </a>
                            <a href="#" class="border me-3 btn btn-icon btn-sm rounded-circle btn-light btn-active-color-primary justify-content-center">
                                <i class="text-gray-500 fab fa-whatsapp" aria-hidden="true"></i>
                            </a>
                            <a href="#" class="border me-3 btn btn-icon btn-sm rounded-circle btn-light btn-active-color-primary justify-content-center">
                                <i class="text-gray-500 fas fa-comment" aria-hidden="true"></i>
                            </a>
                            <a href="#" class="border me-3 btn btn-icon btn-sm rounded-circle btn-light btn-active-color-primary justify-content-center">
                                <i class="text-gray-500 fab fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a href="#" class="border me-3 btn btn-icon btn-sm rounded-circle btn-light btn-active-color-primary justify-content-center">
                                <i class="text-gray-500 fab fa-linkedin-in" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
          <div class="mt-5 col-lg-4">
    @if($latestBrand)
        <div class="p-5 border rounded shadow-sm border-light card card-flush mb-4">
            <h3 class="mb-5 text-black card-title fw-bold">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round"
                     class="w-5 h-5 text-green-500 lucide lucide-shield-check">
                    <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                    <path d="m9 12 2 2 4-4"></path>
                </svg>
                Brand Authorization
            </h3>

            <div class="pt-4 row g-2">
                <div class="col-6">
                    <p class="mb-1 text-black fw-bold">Brand:</p>
                    <p class="mb-0">{{ $latestBrand->title }}</p>
                </div>
                <div class="col-6">
                    <img width="100px" class="img-fluid rounded-1"
                         src="{{ $latestBrand->logo ? asset('storage/brand/logo/' . $latestBrand->logo) : 'https://via.placeholder.com/100x50?text=No+Logo' }}"
                         alt="{{ $latestBrand->title }}">
                </div>

                <hr class="my-0 mt-2 border-light">

                <div class="py-3 col-6">
                    <p class="mb-1 text-black fw-bold">Status:</p>
                    <p class="mb-0 text-white badge bg-success">{{ ucfirst($latestBrand->status) }}</p>
                </div>
                <div class="py-3 col-6">
                    <p class="mb-1 text-black fw-bold">Categories:</p>
                    <p class="mb-0">{{ $latestBrand->category ?? 'N/A' }}</p>
                </div>

                <hr class="my-0 mt-2">

                <div class="py-3 col-6">
                    <p class="mb-1 text-black fw-bold">Join Date:</p>
                    <p class="mb-0">{{ $latestBrand->created_at->format('Y-m-d') }}</p>
                </div>
                {{-- <div class="py-3 col-6">
                    <p class="mb-1 text-black fw-bold">Expiry Date:</p>
                    <p class="mb-0">{{ $latestBrand->expiry_date?->format('Y-m-d') ?? 'N/A' }}</p>
                </div> --}}
            </div>
        </div>
    @else
        <p class="text-muted">No approved brands yet.</p>
    @endif
</div>


                <div class="col-lg-8">
                    <div class="p-4 mt-4 border rounded shadow-sm border-light card card-flush ">
                        <h3 class="mb-5 text-black card-title fw-bold">
                            <i class="fa fa-list-alt text-info fs-2"></i> Product List (Top 5)
                        </h3>
                        <div class="table-responsive">
                            <table class="table align-middle table-borderless small">
                                <thead class="rounded bg-light">
                                    <tr class="fs-7 text-uppercase">
                                        <th scope="col" class="ps-3">Image</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">Price (USD)</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
    @forelse($products as $product)
        <tr style="border-bottom: 1px solid #d8d8d8;">
            <td>
                @if($product->thumbnail)
                    <img class="rounded-3" src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" style="width: 48px; height: 48px; object-fit: cover">
                @else
                    <img class="rounded-3" src="https://placehold.co/48x48/cccccc/ffffff?text=N/A" alt="No Thumbnail" style="width: 48px; height: 48px; object-fit: cover">
                @endif
            </td>
            <td class="fw-bold">{{ $product->name }}</td>
            <td>{{ $product->sku_code ?? 'N/A' }}</td>
            <td class="fw-bold text-success">${{ number_format($product->price, 2) }}</td>
            <td>
                <span class="badge {{ $product->product_status == 'active' ? 'bg-success' : 'bg-danger' }}">
                    {{ ucfirst($product->product_status) }}
                </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-muted text-center">No products available.</td>
        </tr>
    @endforelse
</tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 row">
                <div class="col-md-4">
                    <div class="p-4 border rounded shadow-sm border-light card card-flush h-100">
                        <h2 class="text-black card-title fw-bold ps-3">
                            <i class="fa fa-file-contract text-info"></i> Key Agreements
                        </h2>
                        <ul class="mt-4 mb-0 list-unstyled">
                            <li class="pb-2 mb-2 d-flex justify-content-between align-items-center border-bottom">
                                <span class="fw-medium">NDA (Signed)</span>
                                <button onclick="alert('Downloading NDA...')" class="p-0 btn btn-link text-info fw-semibold text-decoration-none">
                                    <i class="fa fa-download me-1"></i> Download
                                </button>
                            </li>
                            <li class="pb-2 mb-2 d-flex justify-content-between align-items-center border-bottom">
                                <span class="fw-medium">Distribution Agreement</span>
                                <button onclick="alert('Downloading Distribution Agreement...')" class="p-0 btn btn-link text-info fw-semibold text-decoration-none">
                                    <i class="fa fa-download me-1"></i> Download
                                </button>
                            </li>
                            <li class="pb-2 d-flex justify-content-between align-items-center">
                                <span class="fw-medium">Credit Terms (Net 60)</span>
                                <button onclick="alert('Viewing Credit Terms...')" class="p-0 btn btn-link text-info fw-semibold text-decoration-none">
                                    <i class="fa fa-eye me-1"></i> View
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
               <div class="col-lg-4">
                            <div class="p-4 border rounded shadow-sm border-light card card-flush h-100">
                                <h2 class="text-black card-title fw-bold ps-3">
                                    <i class="fa fa-link text-info"></i> Useful Links &amp; Notes
                                </h2>
                                <ul class="mt-4 mb-0 list-unstyled">
                                    @forelse($links as $link)
                                        @php
                                            // Handle label and URL in case they are stored as arrays
                                            $labels = is_array($link->label) ? $link->label : [$link->label];
                                            $urls = is_array($link->url) ? $link->url : [$link->url];
                                        @endphp

                                        @foreach($labels as $index => $label)
                                            <li class="mb-3">
                                                <a href="{{ $urls[$index] ?? '#' }}" target="_blank"
                                                class="text-info fw-semibold text-decoration-none hover:text-info-emphasis">
                                                    <i class="fa fa-sign-in-alt me-1"></i> {{ $label }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @empty
                                        <li class="text-muted">No links available.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                                    <div class="col-lg-4">
                            <div class="p-4 mb-4 border rounded shadow-sm border-light card card-flush h-100">
                                <h2 class="text-black card-title fw-bold ps-3">
                                    <i class="fa fa-box-open text-info"></i> Product Line
                                </h2>

                            <p class="mt-3 fw-medium">
                                        <span class="fw-bold">Product Categories:</span> <br>
                                        <span class="pt-2">{{ $categories }}</span>
                                    </p>

                                    <p class="mt-1 fw-medium">
                                        <span class="fw-bold">Product Brands:</span> <br>
                                        <span class="pt-2">{{ $brands }}</span>
                                    </p>


                                <div class="pt-3 d-flex justify-content-between align-items-center border-top">
                                    <span class="fw-bold">{{ $approvedProductsCount }} Active Products</span>
                                    <a href="{{ route('principal.products.index') }}" class="p-0 text-black btn btn-link fw-semibold text-decoration-none">
                                        Full List <i class="fa fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                                <div class="col">
                            <div class="p-5 text-center bg-white border border-gray-100 shadow-sm rounded-3">
                                <p class="mb-3 fs-2 fw-medium">Assigned Manager</p>
                                <h1 class="mb-0 text-black fw-bold">
                                    {{ $principal->legal_name ?? 'N/A' }}
                                </h1>
                            </div>
                        </div>
                <div class="col">
                    <div class="p-5 text-center bg-white border border-gray-100 shadow-sm rounded-3">
                        <p class="mb-3 fs-2 fw-medium">2024 Purchase Total</p>
                        <h1 class="mb-0 text-black fw-bold">$1.2M USD</h1>
                    </div>
                </div>
                <div class="col">
                    <div class="p-5 text-center bg-white border border-gray-100 shadow-sm rounded-3">
                        <p class="mb-3 fs-2 fw-medium">Risk Level</p>
                        <h1 class="mb-0 fw-bold text-danger">High (7/10)</h1>
                    </div>
                </div>
               <div class="col">
                    <div class="p-5 text-center bg-white border border-gray-100 shadow-sm rounded-3">
                        <p class="mb-3 fs-2 fw-medium">Relationship Since</p>
                        <h1 class="mb-0 text-black fw-bold">
                            {{ $principal->created_at->format('Y') }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection