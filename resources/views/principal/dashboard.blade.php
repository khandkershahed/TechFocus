@extends('principal.layouts.app')

@section('content')
<div class="container mb-10">
    <div class="card card-flush">
        <div class="py-4 card-header">
            <div class="mt-2">
                <h1 class="mb-3 text-black">COMPANY NAME LLC</h1>
                <div>
                    <span class="badge badge-light-success fs-10px">
                        Supplier Type: Manufacturer
                    </span>
                    <span class="badge badge-light-info fs-10px">
                        Supplier ID: SUP-00123
                    </span>
                    <span class="badge badge-light-warning fs-10px">
                        Active
                    </span>
                    <span class="badge badge-light-success fs-10px">
                        Authorized
                    </span>
                </div>
            </div>
            <div class="gap-2 d-flex align-items-center gap-lg-3">
                <a href="#" class="btn btn-sm fw-bold btn-secondary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">
                    <i class="fa fa-pen me-1"></i> Edit
                </a>
                <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target">
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
                                NGen IT LTD.
                            </div>

                            <div class="my-3 separator separator-dashed"></div>

                            <div class="d-flex flex-stack">
                                <a href="#" class="text-black fw-semibold fs-6 me-2">Website:</a>
                                <a href="">http://ngenitltd.com</a>
                            </div>

                            <div class="my-3 separator separator-dashed"></div>

                            <div class="d-flex flex-stack">
                                <a href="#" class="text-black fw-semibold fs-6 me-2">Country:</a>

                                <div class="d-flex flex-stack">
                                    <span class="fw-semibold pe-3">United State</span>
                                    <div class="cursor-pointer" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                        <img width="30px" height="20px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Flag_of_the_United_States.svg/1024px-Flag_of_the_United_States.svg.png" class="rounded-3" alt="user">
                                    </div>
                                </div>
                            </div>
                            <div class="my-3 separator separator-dashed"></div>

                            <div class="d-flex flex-stack">
                                <a href="#" class="text-black fw-semibold fs-6 me-2">Operational Offices:</a>

                                LA, Texas, United State
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD
              
=======
>>>>>>> 44b68216cb7d75b9104f48a13207f64ea65bf576
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
                                        <div>
                                            <h5 class="pb-2 fw-bold">Main Office</h5>
                                            <p class="mb-1">
                                                <i class="fas fa-location-dot me-2"></i> 123 Main Street, Sector 7
                                            </p>
                                            <p class="mb-1 ps-5">Dhaka, Bangladesh</p>
                                        </div>
                                        <div>
                                            <h5 class="pb-2 fw-bold">Factory Office</h5>
                                            <p class="mb-1">
                                                <i class="fas fa-location-dot me-2"></i> 123 Main Street, Sector 7
                                            </p>
                                            <p class="mb-1 ps-5">Dhaka, Bangladesh</p>
                                        </div>
                                        <div>
                                            <h5 class="pb-2 fw-bold">Warehouse</h5>
                                            <p class="mb-1">
                                                <i class="fas fa-location-dot me-2"></i> 123 Main Street, Sector 7
                                            </p>
                                            <p class="mb-1 ps-5">Dhaka, Bangladesh</p>
                                        </div>

                                        <div>
                                            <h6 class="pb-2 mb-1 fw-bold">Working Hours</h6>
                                            <p>Sun - Thu <br> 9:00 AM – 6:00 PM</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Social -->
                                <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                                    <div class="gap-10 d-flex">
                                        <div>
                                            <h6 class="pb-2 fw-bold">Contact</h6>
                                            <p class="mb-1"><i class="fa fa-phone me-2"></i> +880 1234 567890</p>
                                            <p><i class="fa fa-envelope me-2"></i> info@company.com</p>
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
                            <div class="tab-pane fade show active" id="primaryContact">
                                <div class="pt-2 row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Contact Type:</strong> Technical</p>
                                        <p class="mb-1"><strong>Name:</strong> Alice Tech</p>
                                        <p class="mb-1"><strong>Designation:</strong> Technical Lead</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Email:</strong> alice@company.com</p>
                                        <p class="mb-1"><strong>Phone:</strong> +1 555 222 8888</p>
                                        <div>
                                            <div>
                                                <a href="#" class="pe-3 justify-content-center">
                                                    <i class="text-gray-500 fab fa-linkedin-in" aria-hidden="true"></i>
                                                </a>
                                                <a href="#" class="pe-3 justify-content-center">
                                                    <i class="text-gray-500 fab fa-whatsapp" aria-hidden="true"></i>
                                                </a>
                                                <a href="#" class="pe-3 justify-content-center">
                                                    <i class="text-gray-500 fas fa-comment" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Secondary -->
                            <div class="tab-pane fade" id="secondaryContact">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Contact Type:</strong> Support</p>
                                        <p class="mb-1"><strong>Name:</strong> John Support</p>
                                        <p class="mb-1"><strong>Designation:</strong> Customer Support</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Email:</strong> support@company.com</p>
                                        <p class="mb-1"><strong>Phone:</strong> +1 555 111 4444</p>
                                        <p class="mb-1"><strong>Social:</strong> Telegram</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Other -->
                            <div class="tab-pane fade" id="otherContact">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Contact Type:</strong> Finance</p>
                                        <p class="mb-1"><strong>Name:</strong> Diana Accounts</p>
                                        <p class="mb-1"><strong>Designation:</strong> Finance Manager</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Email:</strong> finance@company.com</p>
                                        <p class="mb-1"><strong>Phone:</strong> +1 555 333 7777</p>
                                        <p class="mb-1"><strong>Social:</strong> LinkedIn</p>
                                    </div>
                                </div>
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
                    <div class="p-5 border rounded shadow-sm border-light card card-flush h-100">
                        <h3 class="mb-5 text-black card-title fw-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="shield-check" class="w-5 h-5 text-green-500 lucide lucide-shield-check">
                                <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                            Brand Authorization
                        </h3>

                        <div class="pt-4 row g-2">
                            <div class="col-6">
                                <p class="mb-1 text-black fw-bold">Brands:</p>
                                <p class="mb-0">NGen It</p>
                            </div>
                            <div class="col-6">
                                <img width="100px" class="img-fluid rounded-1" src="https://financialit.net/sites/default/files/acronis_6.png" alt="">
                            </div>
                            <hr class="my-0 mt-2 border-light">
                            <div class="py-3 col-6 align-items-center">
                                <p class="mb-1 text-black fw-bold">Status:</p>
                                <p class="mb-0 text-white badge bg-info">Authorized</p>
                            </div>
                            <div class="py-3 col-6">
                                <p class="mb-1 text-black fw-bold">Categories:</p>
                                <p class="mb-0">Electronics, Hardware</p>
                            </div>
                            <hr class="my-0 mt-2">
                            <div class="py-3 col-6">
                                <p class="mb-1 text-black fw-bold">Join Date:</p>
                                <p class="mb-0">2026-12-31</p>
                            </div>
                            <div class="py-3 col-6">
                                <p class="mb-1 text-black fw-bold">Expiry Date:</p>
                                <p class="mb-0">2026-12-31</p>
                            </div>
                        </div>
                    </div>
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
                                    <tr style="border-bottom: 1px solid #d8d8d8;">
                                        <td>
                                            <img class="rounded-3" src="https://placehold.co/48x48/6366f1/ffffff?text=W" alt="Product Thumbnail" style="width: 48px; height: 48px; object-fit: cover">
                                        </td>
                                        <td class="fw-bold">Widget Pro Max</td>
                                        <td>WPM-001</td>
                                        <td class="fw-bold text-success">$199.99</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #d8d8d8;">
                                        <td>
                                            <img class="rounded-3" src="https://placehold.co/48x48/3b82f6/ffffff?text=S" alt="Product Thumbnail" style="width: 48px; height: 48px; object-fit: cover">
                                        </td>
                                        <td class="fw-bold">Service Pack Basic</td>
                                        <td>SPB-002</td>
                                        <td class="fw-bold text-success">$49.99</td>
                                        <td><span class="badge bg-danger">Inactive</span></td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #d8d8d8;">
                                        <td>
                                            <img class="rounded-3" src="https://placehold.co/48x48/a855f7/ffffff?text=G" alt="Product Thumbnail" style="width: 48px; height: 48px; object-fit: cover">
                                        </td>
                                        <td class="fw-bold">Gadget Mini</td>
                                        <td>GAD-003</td>
                                        <td class="fw-bold text-success">$9.99</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                    </tr>
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
<<<<<<< HEAD
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
=======
                <div class="col-lg-4">
                    <div class="p-4 border rounded shadow-sm border-light card card-flush h-100">
                        <h2 class="text-black card-title fw-bold ps-3">
                            <i class="fa fa-link text-info"></i> Useful Links &amp; Notes
                        </h2>
                        <ul class="mt-4 mb-0 list-unstyled">
                            <li class="mb-3">
                                <a href="#" class="text-info fw-semibold text-decoration-none hover:text-info-emphasis">
                                    <i class="fa fa-sign-in-alt me-1"></i> Principal Portal Login
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#" class="text-info fw-semibold text-decoration-none hover:text-info-emphasis">
                                    <i class="fa fa-book-open me-1"></i> Technical Library - Docs &amp; Manuals
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#" class="text-info fw-semibold text-decoration-none hover:text-info-emphasis">
                                    <i class="fa fa-book-open me-1"></i> Technical Library - Docs &amp; Manuals
                                </a>
                            </li>
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
                            <span class="pt-2">Electronics, Hardware</span>
                        </p>
                        <div class="pt-3 d-flex justify-content-between align-items-center border-top">
                            <span class=" fw-bold">3 Active Products</span>
                            <button onclick="alert('Go to Product Page...')" class="p-0 text-black btn btn-link fw-semibold text-decoration-none">
                                Full List <i class="fa fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2 mb-5 row row-cols-2 row-cols-md-4 g-5">
                <div class="col">
                    <div class="p-5 text-center bg-white border border-gray-100 shadow-sm rounded-3">
                        <p class="mb-3 fs-2 fw-medium">Assigned Manager</p>
                        <h1 class="mb-0 text-black fw-bold">John Smith</h1>
                    </div>
                </div>
>>>>>>> 44b68216cb7d75b9104f48a13207f64ea65bf576
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
                        <h1 class="mb-0 text-black fw-bold">2019</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection