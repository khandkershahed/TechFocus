@extends('frontend.master')
<!-- For Meta -->
@section('metadata')
@endsection
<!-- Main Content Section Start Here -->
@section('content')

    {{-- Banner Section --}}
    <section class="ban_sec section_one">
        <div class="p-0 container-fluid">
            <div class="ban_img">
                @if($banners->count() > 0)
                    <div class="swiper bannerSwiper">
                        <div class="swiper-wrapper">
                            @foreach($banners as $banner)
                                @if($banner->image)
                                    <div class="swiper-slide">
                                        <a href="{{ $banner->banner_link ?? '#' }}">
                                            <img src="{{ asset('uploads/page_banners/' . $banner->image) }}"
                                                 class="img-fluid"
                                                 alt="{{ $banner->title ?? 'Banner' }}"
                                                 onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-banner(1920-330).png') }}';" />
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    <img src="{{ asset('frontend/images/no-banner(1920-330).png') }}"
                         class="img-fluid"
                         alt="No Banner">
                @endif

@include('frontend.pages.rfq.partials.rfq_css')
<div class="container mm">
    <!-- Header Section -->
    <div class="row align-items-center">
        <div class="my-5 text-center col-lg-12">
            <h2 class="mb-1 titles font-two">RECEIVE AND <span class="main-color">COMPARE</span></h2>
            <h2 class="titles font-two"><span class="main-color">QUOTATIONS</span> FOR FREE</h2>
            <p class="pt-2">Take advantage of our supplier network to complete your purchasing projects.</p>
        </div>
    </div>

    <!-- Steps Icons -->
    <div class="mb-5 row align-items-center">
        @foreach(['Company Info', 'Shipping Details', 'End User Info', 'Additional Details'] as $i => $step)
        <div class="col-lg-3">
            <div class="d-flex flex-column align-items-center">
                <img class="mb-2 rfq-img rounded-circle"
                    src="{{ 'https://img.directindustry.com/media/ps/images/common/rfq/ao-step-0' . ($i+1) . '.svg' }}"
                    alt="No Image" style="width: 120px;">
                <p class="text-center font-three">{{ $step }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
<section class="py-5 pt-0 d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="border-0 shadow-sm card">
                    <div class="py-3 border card-header d-flex justify-content-between align-items-center"
                        style="background-color: #001430">
                        <h3 class="mb-0 text-white card-title rfq-title fw-normal">
                            Request for Quotation
                        </h3>
                        <div class="text-white d-flex align-items-center">
                            <p class="mb-0 pe-2 case-title">RFQ by case</p>
                            <div class="border rounded-circle icon-info">
                                <i class="fas fa-question" data-toggle="tooltip"
                                    title="Coming Soon: Create RFQ Describing by Project Case."></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 card-body p-lg-4">

                        <form id="stepperForm" action="{{ route('rfq.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- ✅ Repeater goes here as you said -->
                            <div class="mt-4 mb-4">
                                <div class="repeater">
                                    <div data-repeater-list="contacts">
                                        <div data-repeater-item class="row g-2">
                                            <div class="col-lg-1 col-12">
                                                <button type="button" title="Provide Additional Product Information" class="px-10 border deal-modal-btn btn btn-light btn-sm w-100 me-1 rounded-0" style="font-size: 26px;" data-bs-toggle="modal" data-bs-target="#Product">
                                                    ...
                                                </button>
                                                <!-- Modal Content -->
                                                <div class="modal fade" id="Product" tabindex="-1" aria-labelledby="ProductLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                                        <div class="border-0 modal-content rounded-0">
                                                            <div class="border-0 shadow-sm modal-header">
                                                                <h1 class="modal-title fs-5" id="ProductLabel">Product Information</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="p-5 modal-body">
                                                                <div class="row gx-2">
                                                                    <div class="col-lg-2">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-normal">SKU / Part No.</label>
                                                                            <input type="text" name="sku_no" class="form-control" placeholder="Enter SKU / Part No.">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-normal">Model No.</label>
                                                                            <input type="text" name="model_no" class="form-control" placeholder="Enter Model No.">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-normal">Brand Name</label>
                                                                            <input type="text" name="brand_name" class="form-control" placeholder="Enter Brand Name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-normal">Quantity</label>
                                                                            <input type="number" name="additional_qty" class="form-control" placeholder="Enter Quantity">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-normal">Item Name</label>
                                                                            <input type="text" name="additional_product_name" class="form-control" placeholder="Enter Item Name">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-normal">Item Description</label>
                                                                            <textarea class="form-control" name="product_des" rows="2" placeholder="Enter Item Description"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-normal">Additional Info</label>
                                                                            <textarea class="form-control" name="additional_info" rows="2" placeholder="Enter any additional information"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <hr class="my-5">
                                                                    <div class="col-lg-12">
                                                                        <div class="mb-3">
                                                                            <label class="form-label fw-normal">Upload Product Datasheet / Images</label>
                                                                            <input type="file" name="image" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-2">
                                                <input type="text" name="sl" class="text-center form-control sl-input" value="1" disabled autocomplete="off" />
                                            </div>
                                            <div class="col-lg-8 col-6">
                                                <input type="text" name="product_name" class="form-control" value="asdasd" placeholder="Product Name" required autocomplete="" />
                                            </div>
                                            <div class="col-lg-1 col-4">
                                                <div class="d-flex">
                                                    <input type="text" name="qty" value="1" class="text-center form-control qty-input" style="width: 60px;margin-bottom: 6px;padding-inline-end: 5px;padding-inline-start: 5px;" />
                                                    <div class="d-flex flex-column counting-btn">
                                                        <button type="button" class="qty-btn increment-quantity" onclick="increment(this)" style="width: 32px; height: 32px">
                                                            <i class="fas fa-chevron-up btn-icons"></i>
                                                        </button>
                                                        <button type="button" class="qty-btn decrement-quantity" onclick="decrement(this)" style="width: 32px; height: 32px">
                                                            <i class="fas fa-chevron-down btn-icons"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-2">
                                                <div class="d-flex">
                                                    <button type="button" data-repeater-delete class="py-2 border btn btn-danger btn-sm w-100 trash-btn delete-btn ms-1 btn-light" data-id="{{ $cart_product->rowId ?? 'new' }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="button" data-repeater-create class="mt-4 mb-3 rfq-add-btns">
                                            <i class="fas fa-plus"></i> Add Items
                                        </button>
                                        <div>
<!-- Button to trigger modal -->
<button type="button" class="bg-transparent border-0 modal-text-btn" data-bs-toggle="modal" data-bs-target="#rfqModal">
    Upload RFQ/Tender Images
</button>

<!-- Modal -->
<div class="modal fade" id="rfqModal" tabindex="-1" aria-labelledby="rfqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="border-0 modal-content rounded-0">
            <div class="py-2 modal-header bg-light">
                <h1 class="modal-title fs-5" id="rfqModalLabel">Upload RFQ/Tender Images</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="p-5 modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <input type="file" class="form-control file-input" multiple>
                        </div>
                    </div>
                </div>
                <div id="imagePreview" class="d-flex flex-wrap gap-2 mb-2"></div>
                <p class="text-sm text-danger warning-text" style="display:none;">
                    You must input product name in item Box.
                </p>
            </div>
        </div>
    </div>
</div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- ✅ End of repeater placement -->
                            <hr class="mb-4" autocomplete="" />
                            <!-- Progress Bar -->
                            <div class="pt-3 progress-bar-steps for-desktop">
                                <div class="step" data-step="1">
                                    <div class="step-label">
                                        <span class="d-lg-block d-none">Company Information</span>
                                        <span class="d-lg-none d-block">Company</span>
                                    </div>
                                    <div class="pt-1 circle ps-2">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                                <div class="step" data-step="2">
                                    <div class="step-label">
                                        <span class="d-lg-block d-none">Shipping Details</span>
                                        <span class="d-lg-none d-block">Shipping</span>
                                    </div>
                                    <div class="pt-1 circle ps-2">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                                <div class="step" data-step="3">
                                    <div class="step-label">
                                        <span class="d-lg-block d-none">End User Information</span>
                                        <span class="d-lg-none d-block" title="End User Info">User</span>
                                    </div>
                                    <div class="pt-1 circle ps-2">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                                <div class="step" data-step="4">
                                    <div class="step-label">
                                        <span class="d-lg-block d-none">Additional Details</span>
                                        <span class="d-lg-none d-block">Additional</span>
                                    </div>
                                    <div class="pt-1 circle ps-2">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Form starts here -->
                            {{-- <form > --}}
                            <!-- Step 1 -->
                            <div class="step-content active" data-step="1">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="company_name" class="form-control"
                                                placeholder="Company Name (e.g: NGen It)" required autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-2 mb-4 form-check">
                                            <div class="">
                                                <input class="form-check-input custom-form-check" type="checkbox"
                                                    value="1" name="is_reseller" id="resellerCheckbox"
                                                    autocomplete="" />
                                                <label class="pt-1 form-check-label fw-normal" for="resellerCheckbox"
                                                    style="color:#001430;">
                                                    <span style="font-weight: 600; font-size: 14px;">I am a
                                                        reseller</span> <small>(Check if you are a reseller
                                                        partner)</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Contact Name (e.g: Jhone Doe)" required
                                                autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="address" class="form-control"
                                                placeholder="Address (e.g: House No, Road, Block)" required
                                                autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="designation" class="form-control"
                                                placeholder="Designation (e.g: Sales Manager)" required
                                                autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <select class="form-select countrySelect" aria-label="Select Country"
                                                required name="country">
                                                <option value="" selected disabled
                                                    style="color: #7a7577 !important">
                                                    Select Country
                                                </option>
                                                <option value="Dhaka">Dhaka</option>
                                                <option value="Chattogram">Chattogram</option>
                                                <option value="Khulna">Khulna</option>
                                                <option value="Rajshahi">Rajshahi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Email Address (e.g: jhone@mail.com)" required
                                                autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="city" class="form-control"
                                                placeholder="Enter your City Name" required autocomplete="" />
                                            {{-- <select class="form-select countrySelect" aria-label="Select City"
                                                    required name="city">
                                                    <option value="" selected disabled>
                                                        Select City
                                                    </option>
                                                    <option value="Dhaka">Dhaka</option>
                                                    <option value="Chattogram">Chattogram</option>
                                                    <option value="Khulna">Khulna</option>
                                                    <option value="Rajshahi">Rajshahi</option>
                                                </select> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="number" name="phone" class="form-control no-spinners"
                                                placeholder="Phone Number (e.g: 018687955852)" required
                                                autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="zip_code" class="form-control"
                                                placeholder="ZIP Code (e.g: 1207)" required autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mt-4">
                                            <!-- Delivery Address Checkbox -->
                                            <div class="mt-2 form-check">
                                                <input class="form-check-input custom-form-check deliveryAddress"
                                                    type="checkbox" value="1" id="deliveryAddress" disabled
                                                    required autocomplete="" />
                                                <label class="pt-1 text-black form-check-label fw-normal"
                                                    for="deliveryAddress" style="opacity: 1; font-size: 13px;">
                                                    My delivery address is the same as the company
                                                    address
                                                </label>
                                            </div>
                                            <div id="checkDefaultContainer">
                                                <div class="mb-4 form-check">
                                                    <input class="form-check-input custom-form-check endUser"
                                                        type="checkbox" value="1" id="endUser" disabled
                                                        required autocomplete />
                                                    <label class="pt-1 text-black form-check-label fw-normal"
                                                        for="endUser" style="opacity: 1; font-size: 13px;">
                                                        I am the end user and my information is the same
                                                        as the company address
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0 fw-semibold case-title" style="font-size: 12px;">
                                            *Please provide accurate and complete details so we
                                            can quote & reach out to you smoothly
                                        </p>
                                    </div>
                                    <button type="button" class="btn btn-primary next-step next-btn">
                                        Next <i class="fas fa-arrow-right-long"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Step 2 -->
                            <div class="step-content" data-step="2">
                                <div>
                                    <!-- Delivery Address Checkbox -->

                                    <div class="mt-2 mb-4 form-check">
                                        <input class="form-check-input custom-form-check deliveryAddress"
                                            type="checkbox" value="1" name="is_contact_address"
                                            id="step2Address" autocomplete="" />
                                        <label class="pt-1 form-check-label" for="step2Address">
                                            Delivery address is same as the company address
                                        </label>
                                    </div>
                                </div>
                                <!-- Step 2 Inputs Field -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <input type="text" name="shipping_company_name" class="form-control"
                                                placeholder="Shipping Company Name (e.g: NGen It)" autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="shipping_name" class="form-control"
                                                placeholder="Contact Name (e.g: Jhone Doe)" autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="shipping_address" class="form-control"
                                                placeholder="Address (e.g: House No, Road, Block)" autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="shipping_designation" class="form-control"
                                                placeholder="Designation (e.g: Sales Manager)" autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <select class="form-select countrySelect" aria-label="Select Country"
                                                required name="shipping_country">
                                                <option value="" selected disabled
                                                    style="color: #7a7577 !important">
                                                    Select Country
                                                </option>
                                                <option value="Dhaka">Dhaka</option>
                                                <option value="Chattogram">Chattogram</option>
                                                <option value="Khulna">Khulna</option>
                                                <option value="Rajshahi">Rajshahi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="email" name="shipping_email" class="form-control"
                                                placeholder="Email Address (e.g: jhone@mail.com)" autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="shipping_city" class="form-control"
                                                placeholder="Enter your City Name" required autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="number" name="shipping_phone" class="form-control"
                                                placeholder="Phone Number (e.g: 018687955852)" autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="shipping_zip_code" class="form-control"
                                                placeholder="ZIP Code (e.g: 1207)" autocomplete="" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Step 2 Inputs Field End-->
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-secondary prev-step prev-btn">
                                        <i class="fas fa-arrow-left-long pe-2"></i> Previous
                                    </button>
                                    <button type="button" class="btn btn-primary next-step next-btn">
                                        Next <i class="fas fa-arrow-right-long"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Step 3 -->
                            <div class="step-content" data-step="3">
                                <!-- End User Checkbox -->
                                <div>
                                    <div class="mt-2 mb-4 form-check">
                                        <input class="form-check-input custom-form-check" type="checkbox"
                                            name="end_user_is_contact_address" value="1" id="stepThreeGotoStep4"
                                            autocomplete="" />
                                        <label class="pt-1 form-check-label" for="stepThreeGotoStep4">
                                            I am the end user & same as the company address
                                        </label>
                                    </div>
                                </div>
                                <!-- Step 3 Inputs Field-->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <input type="text" name="end_user_company_name" class="form-control"
                                                placeholder="Destination/Company Name (e.g: NGen It)"
                                                autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="end_user_name" class="form-control"
                                                placeholder="Contact Name (e.g: Jhone Doe)" autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="end_user_address" class="form-control"
                                                placeholder="Address (e.g: House No, Road, Block)" required
                                                autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="end_user_designation" class="form-control"
                                                placeholder="Designation (e.g: Sales Manager)" autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <select class="form-select countrySelect" aria-label="Select Country"
                                                required name="end_user_country">
                                                <option value="" selected disabled
                                                    style="color: #7a7577 !important">
                                                    Select Country
                                                </option>
                                                <option value="Dhaka">Dhaka</option>
                                                <option value="Chattogram">Chattogram</option>
                                                <option value="Khulna">Khulna</option>
                                                <option value="Rajshahi">Rajshahi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="email" name="end_user_email" class="form-control"
                                                placeholder="Email Address (e.g: jhone@mail.com)" autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="end_user_city" class="form-control"
                                                placeholder="Enter your City Name" required autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="number" name="end_user_phone" class="form-control"
                                                placeholder="Phone Number (e.g: 018687955852)" autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="end_user_zip_code" class="form-control"
                                                placeholder="ZIP Code (e.g: 1207)" autocomplete="" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Step 3 Inputs Field End-->
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-secondary prev-step prev-btn">
                                        <i class="fas fa-arrow-left-long pe-2"></i> Previous
                                    </button>
                                    <button type="button" class="btn btn-primary next-step next-btn">
                                        Next <i class="fas fa-arrow-right-long"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Step 4 -->
                            <div class="step-content" data-step="4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="text" name="project_name" class="form-control"
                                                placeholder="Project Name" autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <input type="number" name="budget" class="form-control"
                                                placeholder="Tentative Budget.." autocomplete="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <select class="form-select countrySelect" aria-label="Select Country"
                                                name="project_status">
                                                <option value="" selected> Current project status </option>
                                                <option value="budget_stage">Budget Stage</option>
                                                <option value="tor_stage">Tor Stage</option>
                                                <option value="rfq_stage">RFQ Stage</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <select class="form-select countrySelect" aria-label="Select Country"
                                                name="approximate_delivery_time">
                                                <option value="" selected>
                                                    Tentetive Purchase Date
                                                </option>
                                                <option value="less_one_month">1 Month</option>
                                                <option value="two_month">2 Month</option>
                                                <option value="three_month">3 Month</option>
                                                <option value="six_month">6 Month</option>
                                                <option value="one_year">1 Year</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-lg-12">
                                        <textarea class="form-control" id="messageTextarea" name="project_brief"
                                            placeholder="Leave a comment or message here..." rows="2" data-gtm-form-interact-field-id="9"></textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="my-2 mb-5 form-check">
                                            <input class="form-check-input custom-form-check" type="checkbox"
                                                value="" id="flexCheckChecked" checked autocompletee="off" />
                                            <label class="pt-1 form-check-label" for="flexCheckChecked">
                                                Skip the additional information
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-secondary prev-step prev-btn">
                                        <i class="fas fa-arrow-left-long pe-2"></i> Previous
                                    </button>
                                    <button type="submit" class="btn btn-primary next-step next-btn">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- End form -->
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('frontend.pages.rfq.partials.rfq_js')
{{-- <script>
$(document).ready(function() {
    console.log('RFQ Auto-fill initialized - Aggressive mode');
    
    function autoFillProductDetails() {
        const urlParams = new URLSearchParams(window.location.search);
        const productName = urlParams.get('product_name');
        const productSku = urlParams.get('product_sku');
        const productBrand = urlParams.get('product_brand');
        
        if (productName && productName !== 'asdasd') {
            console.log('Auto-filling:', productName, productSku, productBrand);
            
            // Direct targeting for main row
            $('input[placeholder="Product Name"]').first().val(productName);
            $('input[placeholder="Product Name"]').first().attr('value', productName);
            
            // Direct targeting for modal - wait for modal to be in DOM
            setTimeout(() => {
                // Target by placeholder or name attribute
                $('input[placeholder="Enter SKU / Part No."]').val(productSku);
                $('input[placeholder="Enter Brand Name"]').val(productBrand);
                $('input[placeholder="Enter Item Name"]').val(productName);
                $('input[placeholder="Enter Quantity"]').val('1');
                
                // Also target by name attribute with modal context
                $('#Product input[name="sku_no"]').val(productSku);
                $('#Product input[name="brand_name"]').val(productBrand);
                $('#Product input[name="additional_product_name"]').val(productName);
                $('#Product input[name="additional_qty"]').val('1');
                
                console.log('Aggressive auto-fill completed');
            }, 1000);
        }
    }
    
    // Run on load and also when modal opens
    autoFillProductDetails();
    
    $('#Product').on('show.bs.modal', function() {
        setTimeout(autoFillProductDetails, 100);
    });
    
    $('.deal-modal-btn').click(function() {
        setTimeout(autoFillProductDetails, 200);
    });
});
</script> --}}

<script>
$(document).ready(function() {
    console.log('RFQ Auto-fill initialized');
    
    // Initialize auto-fill when page loads
    setTimeout(function() {
        autoFillProductDetails();
    }, 500);

    function autoFillProductDetails() {
        console.log('Starting auto-fill product details...');
        
        // Get product data from URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('product_id');
        const productName = urlParams.get('product_name');
        const productSku = urlParams.get('product_sku');
        const productBrand = urlParams.get('product_brand');
        
        console.log('URL Parameters found:', {
            productId: productId,
            productName: productName,
            productSku: productSku,
            productBrand: productBrand
        });

        // Check if we have product data to auto-fill
        if (productName && productName !== 'asdasd') {
            console.log('Auto-filling product details for:', productName);
            
            // Fill main product row
            fillMainProductRow(productName, productBrand);
            
            // Fill modal fields (EXCLUDING SKU)
            fillModalFields(productName, productBrand);
            
            console.log('Product details auto-filled successfully (SKU excluded)');
        } else {
            console.log('No valid product data found for auto-fill');
        }
    }

    function fillMainProductRow(productName, productBrand) {
        console.log('Filling main product row...');
        
        // Fill the main product name input
        const mainProductInput = $('input[name*="[product_name]"]').first();
        if (mainProductInput.length) {
            console.log('Found main product input, current value:', mainProductInput.val());
            if (mainProductInput.val() === 'asdasd' || !mainProductInput.val().trim()) {
                mainProductInput.val(productName);
                console.log('Main product name filled:', productName);
            }
        }
        
        // Set quantity to 1 if empty
        const qtyInput = $('input[name*="[qty]"]').first();
        if (qtyInput.length) {
            if (!qtyInput.val() || qtyInput.val() === '1') {
                qtyInput.val('1');
                console.log('Quantity set to 1');
            }
        }
        
        // Update SL number
        const slInput = $('input[name*="[sl]"]').first();
        if (slInput.length) {
            slInput.val('1');
            console.log('SL number set to 1');
        }
    }

    function fillModalFields(productName, productBrand) {
        console.log('Filling modal fields (SKU excluded)...');
        
        // SKU FIELD INTENTIONALLY EXCLUDED - No auto-fill for SKU
        
        // Fill Brand Name in modal
        if (productBrand) {
            const brandInput = $('#Product input[name="brand_name"]');
            if (brandInput.length) {
                brandInput.val(productBrand);
                console.log('Brand filled in modal:', productBrand);
            }
        }
        
        // Fill Item Name (additional product name) in modal
        const additionalNameInput = $('#Product input[name="additional_product_name"]');
        if (additionalNameInput.length) {
            additionalNameInput.val(productName);
            console.log('Additional product name filled in modal:', productName);
        }
        
        // Set additional quantity to 1 in modal
        const additionalQtyInput = $('#Product input[name="additional_qty"]');
        if (additionalQtyInput.length) {
            additionalQtyInput.val('1');
            console.log('Additional quantity set to 1 in modal');
        }
        
        // Model No. also excluded since you didn't mention it
    }

    // Sync data when modal opens (excluding SKU)
    $('#Product').on('show.bs.modal', function() {
        console.log('Product modal opened - syncing data (SKU excluded)...');
        
        setTimeout(function() {
            // Get data from main product row to populate modal
            const mainProductName = $('input[name*="[product_name]"]').first().val();
            const mainProductQty = $('input[name*="[qty]"]').first().val();
            
            console.log('Syncing from main row - Name:', mainProductName, 'Qty:', mainProductQty);
            
            if (mainProductName && mainProductName !== 'asdasd') {
                // Update modal fields with main row data (SKU excluded)
                const modalNameInput = $('#Product input[name="additional_product_name"]');
                const modalQtyInput = $('#Product input[name="additional_qty"]');
                
                if (modalNameInput.length) {
                    modalNameInput.val(mainProductName);
                    console.log('Modal product name synced:', mainProductName);
                }
                
                if (modalQtyInput.length) {
                    modalQtyInput.val(mainProductQty || '1');
                    console.log('Modal quantity synced:', mainProductQty || '1');
                }
                
                // Note: SKU is intentionally NOT synced
            }
        }, 100);
    });

    // Update main product row when modal fields change (SKU changes don't affect main row)
    $(document).on('change', '#Product input[name="additional_product_name"]', function() {
        const additionalName = $(this).val();
        if (additionalName) {
            $('input[name*="[product_name]"]').first().val(additionalName);
            console.log('Main product name updated from modal:', additionalName);
        }
    });

    $(document).on('change', '#Product input[name="additional_qty"]', function() {
        const additionalQty = $(this).val();
        if (additionalQty) {
            $('input[name*="[qty]"]').first().val(additionalQty);
            console.log('Main quantity updated from modal:', additionalQty);
        }
    });

    // Modal button click handler (SKU excluded)
    $(document).on('click', '.deal-modal-btn', function() {
        console.log('Modal button clicked - ensuring data sync (SKU excluded)...');
        
        const mainProductName = $('input[name*="[product_name]"]').first().val();
        const mainProductQty = $('input[name*="[qty]"]').first().val();
        
        console.log('Current main row data - Name:', mainProductName, 'Qty:', mainProductQty);
        
        if (mainProductName && mainProductName !== 'asdasd') {
            setTimeout(function() {
                const modalNameInput = $('#Product input[name="additional_product_name"]');
                const modalQtyInput = $('#Product input[name="additional_qty"]');
                
                if (modalNameInput.length) {
                    modalNameInput.val(mainProductName);
                    console.log('Modal product name set from main row:', mainProductName);
                }
                
                if (modalQtyInput.length) {
                    modalQtyInput.val(mainProductQty || '1');
                    console.log('Modal quantity set from main row:', mainProductQty || '1');
                }
                
                // SKU is intentionally left empty
            }, 300);
        }
    });

    // Debug function
    function debugInputs() {
        console.log('=== DEBUG INPUTS ===');
        console.log('Main product name:', $('input[name*="[product_name]"]').first().val());
        console.log('Modal brand name:', $('#Product input[name="brand_name"]').val());
        console.log('Modal additional name:', $('#Product input[name="additional_product_name"]').val());
        console.log('Modal SKU (should be empty):', $('#Product input[name="sku_no"]').val());
        console.log('====================');
    }

    // Run debug on load
    setTimeout(debugInputs, 1000);

    window.debugRFQ = debugInputs;
});

// Quantity functions
function increment(button) {
    const input = $(button).closest('.d-flex').find('.qty-input');
    let value = parseInt(input.val()) || 1;
    input.val(value + 1);
}

function decrement(button) {
    const input = $(button).closest('.d-flex').find('.qty-input');
    let value = parseInt(input.val()) || 1;
    if (value > 1) {
        input.val(value - 1);
    }
}
</script>
@endsection