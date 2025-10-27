@extends('frontend.master')
<!-- For Meta -->
@section('metadata')
@endsection
<!-- Main Content Section Start Here -->
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
            </div>
        </div>
    </section>

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

                        <!-- Alert Messages Container -->
                        <div id="formAlerts"></div>

                        <form id="stepperForm" action="{{ route('rfq.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Products Section -->
                            <div class="mt-4 mb-4">
                                <div class="repeater">
                                    <div data-repeater-list="products">
                                        @php
                                            $rfqItems = session()->get('rfq_items', []);
                                            $hasSessionItems = !empty($rfqItems);
                                        @endphp

                                        @if($hasSessionItems)
                                            <!-- Pre-filled products from session -->
                                            @foreach($rfqItems as $index => $product)
                                            <div data-repeater-item class="mb-3 row g-2 product-item">
                                                <div class="col-lg-1 col-12">
                                                    <button type="button" title="Provide Additional Product Information" 
                                                        class="px-10 border deal-modal-btn btn btn-light btn-sm w-100 me-1 rounded-0" 
                                                        style="font-size: 26px;" data-bs-toggle="modal" 
                                                        data-bs-target="#productModal{{ $index }}">
                                                        ...
                                                    </button>
                                                    <!-- Modal Content -->
                                                    <div class="modal fade" id="productModal{{ $index }}" tabindex="-1" aria-labelledby="productModalLabel{{ $index }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                                            <div class="border-0 modal-content rounded-0">
                                                                <div class="border-0 shadow-sm modal-header">
                                                                    <h1 class="modal-title fs-5" id="productModalLabel{{ $index }}">Product Information</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="p-5 modal-body">
                                                                    <div class="row gx-2">
                                                                        <div class="col-lg-2">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">SKU / Part No.</label>
                                                                                <input type="text" class="form-control modal-sku-no" 
                                                                                    value="{{ $product['sku_code'] ?? '' }}" 
                                                                                    placeholder="Enter SKU / Part No.">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Model No.</label>
                                                                                <input type="text" class="form-control modal-model-no" 
                                                                                    placeholder="Enter Model No.">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Brand Name</label>
                                                                                <input type="text" class="form-control modal-brand-name" 
                                                                                    value="{{ $product['brand'] ?? '' }}" 
                                                                                    placeholder="Enter Brand Name">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Quantity</label>
                                                                                <input type="number" class="form-control modal-additional-qty" 
                                                                                    value="{{ $product['quantity'] ?? 1 }}" 
                                                                                    placeholder="Enter Quantity">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Item Name</label>
                                                                                <input type="text" class="form-control modal-additional-product-name" 
                                                                                    value="{{ $product['name'] ?? '' }}" 
                                                                                    placeholder="Enter Item Name">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Item Description</label>
                                                                                <textarea class="form-control modal-product-des" rows="2" 
                                                                                    placeholder="Enter Item Description"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Additional Info</label>
                                                                                <textarea class="form-control modal-additional-info" rows="2" 
                                                                                    placeholder="Enter any additional information"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="my-5">
                                                                        <div class="col-lg-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Upload Product Datasheet / Images</label>
                                                                                <input type="file" class="form-control modal-image">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    {{-- <button type="button" class="btn btn-primary save-modal-data" data-modal-index="{{ $index }}">Save Changes</button> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-2">
                                                    <input type="text" class="text-center form-control sl-input" 
                                                        value="{{ $loop->iteration }}" disabled autocomplete="off" />
                                                </div>
                                                <div class="col-lg-8 col-6">
                                                    <input type="text" name="products[{{ $index }}][product_name]" class="form-control product-name-input" 
                                                        value="{{ $product['name'] ?? '' }}" 
                                                        placeholder="Product Name" required autocomplete="" />
                                                    <!-- Hidden fields to store product data -->
                                                    <input type="hidden" name="products[{{ $index }}][product_id]" class="product-id-input" value="{{ $product['id'] ?? '' }}">
                                                    <!-- Hidden fields for modal data -->
                                                    <input type="hidden" name="products[{{ $index }}][sku_no]" class="hidden-sku-no" value="{{ $product['sku_code'] ?? '' }}">
                                                    <input type="hidden" name="products[{{ $index }}][model_no]" class="hidden-model-no" value="">
                                                    <input type="hidden" name="products[{{ $index }}][brand_name]" class="hidden-brand-name" value="{{ $product['brand'] ?? '' }}">
                                                    <input type="hidden" name="products[{{ $index }}][additional_qty]" class="hidden-additional-qty" value="{{ $product['quantity'] ?? 1 }}">
                                                    <input type="hidden" name="products[{{ $index }}][additional_product_name]" class="hidden-additional-product-name" value="{{ $product['name'] ?? '' }}">
                                                    <input type="hidden" name="products[{{ $index }}][product_des]" class="hidden-product-des" value="">
                                                    <input type="hidden" name="products[{{ $index }}][additional_info]" class="hidden-additional-info" value="">
                                                </div>
                                                <div class="col-lg-1 col-4">
                                                    <div class="d-flex">
                                                        <input type="text" name="products[{{ $index }}][qty]" value="{{ $product['quantity'] ?? 1 }}" 
                                                            class="text-center form-control qty-input" 
                                                            style="width: 60px;margin-bottom: 6px;padding-inline-end: 5px;padding-inline-start: 5px;" />
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
                                                        <button type="button" data-repeater-delete 
                                                            class="py-2 border btn btn-danger btn-sm w-100 trash-btn delete-btn ms-1 btn-light" 
                                                            data-product-id="{{ $product['id'] ?? '' }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <!-- Empty template for new items -->
                                            <div data-repeater-item class="mb-3 row g-2 product-item">
                                                <div class="col-lg-1 col-12">
                                                    <button type="button" title="Provide Additional Product Information" 
                                                        class="px-10 border deal-modal-btn btn btn-light btn-sm w-100 me-1 rounded-0" 
                                                        style="font-size: 26px;" data-bs-toggle="modal" 
                                                        data-bs-target="#productModal0">
                                                        ...
                                                    </button>
                                                    <!-- Modal Content -->
                                                    <div class="modal fade" id="productModal0" tabindex="-1" aria-labelledby="productModalLabel0" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                                            <div class="border-0 modal-content rounded-0">
                                                                <div class="border-0 shadow-sm modal-header">
                                                                    <h1 class="modal-title fs-5" id="productModalLabel0">Product Information</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="p-5 modal-body">
                                                                    <div class="row gx-2">
                                                                        <div class="col-lg-2">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">SKU / Part No.</label>
                                                                                <input type="text" class="form-control modal-sku-no" placeholder="Enter SKU / Part No.">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Model No.</label>
                                                                                <input type="text" class="form-control modal-model-no" placeholder="Enter Model No.">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Brand Name</label>
                                                                                <input type="text" class="form-control modal-brand-name" placeholder="Enter Brand Name">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Quantity</label>
                                                                                <input type="number" class="form-control modal-additional-qty" placeholder="Enter Quantity">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Item Name</label>
                                                                                <input type="text" class="form-control modal-additional-product-name" placeholder="Enter Item Name">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Item Description</label>
                                                                                <textarea class="form-control modal-product-des" rows="2" placeholder="Enter Item Description"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Additional Info</label>
                                                                                <textarea class="form-control modal-additional-info" rows="2" placeholder="Enter any additional information"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <hr class="my-5">
                                                                        <div class="col-lg-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label fw-normal">Upload Product Datasheet / Images</label>
                                                                                <input type="file" class="form-control modal-image">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary save-modal-data" data-modal-index="0">Save Changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 col-2">
                                                    <input type="text" class="text-center form-control sl-input" value="1" disabled autocomplete="off" />
                                                </div>
                                                <div class="col-lg-8 col-6">
                                                    <input type="text" name="products[0][product_name]" class="form-control product-name-input" placeholder="Product Name" required autocomplete="" />
                                                    <!-- Hidden fields to store product data -->
                                                    <input type="hidden" name="products[0][product_id]" class="product-id-input" value="">
                                                    <!-- Hidden fields for modal data -->
                                                    <input type="hidden" name="products[0][sku_no]" class="hidden-sku-no" value="">
                                                    <input type="hidden" name="products[0][model_no]" class="hidden-model-no" value="">
                                                    <input type="hidden" name="products[0][brand_name]" class="hidden-brand-name" value="">
                                                    <input type="hidden" name="products[0][additional_qty]" class="hidden-additional-qty" value="">
                                                    <input type="hidden" name="products[0][additional_product_name]" class="hidden-additional-product-name" value="">
                                                    <input type="hidden" name="products[0][product_des]" class="hidden-product-des" value="">
                                                    <input type="hidden" name="products[0][additional_info]" class="hidden-additional-info" value="">
                                                </div>
                                                <div class="col-lg-1 col-4">
                                                    <div class="d-flex">
                                                        <input type="text" name="products[0][qty]" value="1" class="text-center form-control qty-input" style="width: 60px;margin-bottom: 6px;padding-inline-end: 5px;padding-inline-start: 5px;" />
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
                                                        <button type="button" data-repeater-delete class="py-2 border btn btn-danger btn-sm w-100 trash-btn delete-btn ms-1 btn-light">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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
                                                            <div id="imagePreview" class="flex-wrap gap-2 mb-2 d-flex"></div>
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
                            <!-- End Products Section -->

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

                            <!-- Form Steps -->
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
                                            <select class="form-select countrySelect" aria-label="Select Country" required name="country">
                                                <option value="" selected disabled style="color: #7a7577 !important">
                                                    Select Country
                                                </option>
                                                 <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Algeria">Algeria</option>
                                                    <option value="Andorra">Andorra</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Armenia">Armenia</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Austria">Austria</option>
                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                    <option value="Bahamas">Bahamas</option>
                                                    <option value="Bahrain">Bahrain</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Barbados">Barbados</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Belgium">Belgium</option>
                                                    <option value="Belize">Belize</option>
                                                    <option value="Benin">Benin</option>
                                                    <option value="Bhutan">Bhutan</option>
                                                    <option value="Bolivia">Bolivia</option>
                                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="Brunei">Brunei</option>
                                                    <option value="Bulgaria">Bulgaria</option>
                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                    <option value="Burundi">Burundi</option>
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Cameroon">Cameroon</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Cape Verde">Cape Verde</option>
                                                    <option value="Central African Republic">Central African Republic</option>
                                                    <option value="Chad">Chad</option>
                                                    <option value="Chile">Chile</option>
                                                    <option value="China">China</option>
                                                    <option value="Colombia">Colombia</option>
                                                    <option value="Comoros">Comoros</option>
                                                    <option value="Congo">Congo</option>
                                                    <option value="Costa Rica">Costa Rica</option>
                                                    <option value="Croatia">Croatia</option>
                                                    <option value="Cuba">Cuba</option>
                                                    <option value="Cyprus">Cyprus</option>
                                                    <option value="Czech Republic">Czech Republic</option>
                                                    <option value="Denmark">Denmark</option>
                                                    <option value="Djibouti">Djibouti</option>
                                                    <option value="Dominica">Dominica</option>
                                                    <option value="Dominican Republic">Dominican Republic</option>
                                                    <option value="Ecuador">Ecuador</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="El Salvador">El Salvador</option>
                                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                    <option value="Eritrea">Eritrea</option>
                                                    <option value="Estonia">Estonia</option>
                                                    <option value="Eswatini">Eswatini</option>
                                                    <option value="Ethiopia">Ethiopia</option>
                                                    <option value="Fiji">Fiji</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="France">France</option>
                                                    <option value="Gabon">Gabon</option>
                                                    <option value="Gambia">Gambia</option>
                                                    <option value="Georgia">Georgia</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="Ghana">Ghana</option>
                                                    <option value="Greece">Greece</option>
                                                    <option value="Grenada">Grenada</option>
                                                    <option value="Guatemala">Guatemala</option>
                                                    <option value="Guinea">Guinea</option>
                                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                    <option value="Guyana">Guyana</option>
                                                    <option value="Haiti">Haiti</option>
                                                    <option value="Honduras">Honduras</option>
                                                    <option value="Hungary">Hungary</option>
                                                    <option value="Iceland">Iceland</option>
                                                    <option value="India">India</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="Iran">Iran</option>
                                                    <option value="Iraq">Iraq</option>
                                                    <option value="Ireland">Ireland</option>
                                                    <option value="Israel">Israel</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Jamaica">Jamaica</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Jordan">Jordan</option>
                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Kiribati">Kiribati</option>
                                                    <option value="Kosovo">Kosovo</option>
                                                    <option value="Kuwait">Kuwait</option>
                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                    <option value="Laos">Laos</option>
                                                    <option value="Latvia">Latvia</option>
                                                    <option value="Lebanon">Lebanon</option>
                                                    <option value="Lesotho">Lesotho</option>
                                                    <option value="Liberia">Liberia</option>
                                                    <option value="Libya">Libya</option>
                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                    <option value="Lithuania">Lithuania</option>
                                                    <option value="Luxembourg">Luxembourg</option>
                                                    <option value="Madagascar">Madagascar</option>
                                                    <option value="Malawi">Malawi</option>
                                                    <option value="Malaysia">Malaysia</option>
                                                    <option value="Maldives">Maldives</option>
                                                    <option value="Mali">Mali</option>
                                                    <option value="Malta">Malta</option>
                                                    <option value="Marshall Islands">Marshall Islands</option>
                                                    <option value="Mauritania">Mauritania</option>
                                                    <option value="Mauritius">Mauritius</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Micronesia">Micronesia</option>
                                                    <option value="Moldova">Moldova</option>
                                                    <option value="Monaco">Monaco</option>
                                                    <option value="Mongolia">Mongolia</option>
                                                    <option value="Montenegro">Montenegro</option>
                                                    <option value="Morocco">Morocco</option>
                                                    <option value="Mozambique">Mozambique</option>
                                                    <option value="Myanmar">Myanmar</option>
                                                    <option value="Namibia">Namibia</option>
                                                    <option value="Nauru">Nauru</option>
                                                    <option value="Nepal">Nepal</option>
                                                    <option value="Netherlands">Netherlands</option>
                                                    <option value="New Zealand">New Zealand</option>
                                                    <option value="Nicaragua">Nicaragua</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="North Korea">North Korea</option>
                                                    <option value="North Macedonia">North Macedonia</option>
                                                    <option value="Norway">Norway</option>
                                                    <option value="Oman">Oman</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Palau">Palau</option>
                                                    <option value="Panama">Panama</option>
                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                    <option value="Paraguay">Paraguay</option>
                                                    <option value="Peru">Peru</option>
                                                    <option value="Philippines">Philippines</option>
                                                    <option value="Poland">Poland</option>
                                                    <option value="Portugal">Portugal</option>
                                                    <option value="Qatar">Qatar</option>
                                                    <option value="Romania">Romania</option>
                                                    <option value="Russia">Russia</option>
                                                    <option value="Rwanda">Rwanda</option>
                                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                    <option value="Saint Lucia">Saint Lucia</option>
                                                    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                                    <option value="Samoa">Samoa</option>
                                                    <option value="San Marino">San Marino</option>
                                                    <option value="São Tomé and Príncipe">São Tomé and Príncipe</option>
                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                    <option value="Senegal">Senegal</option>
                                                    <option value="Serbia">Serbia</option>
                                                    <option value="Seychelles">Seychelles</option>
                                                    <option value="Sierra Leone">Sierra Leone</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Slovakia">Slovakia</option>
                                                    <option value="Slovenia">Slovenia</option>
                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                    <option value="Somalia">Somalia</option>
                                                    <option value="South Africa">South Africa</option>
                                                    <option value="South Korea">South Korea</option>
                                                    <option value="South Sudan">South Sudan</option>
                                                    <option value="Spain">Spain</option>
                                                    <option value="Sri Lanka">Sri Lanka
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
                                            <select class="form-select countrySelect" aria-label="Select Country" name="shipping_country">
                                                <option value="" selected disabled style="color: #7a7577 !important">
                                                    Select Country
                                                </option>
                                              <option value="Afghanistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Central African Republic">Central African Republic</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Eswatini">Eswatini</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Kosovo">Kosovo</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Laos">Laos</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libya">Libya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia">Micronesia</option>
                                                <option value="Moldova">Moldova</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montenegro">Montenegro</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="North Korea">North Korea</option>
                                                <option value="North Macedonia">North Macedonia</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russia">Russia</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                <option value="Saint Lucia">Saint Lucia</option>
                                                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="São Tomé and Príncipe">São Tomé and Príncipe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Serbia">Serbia</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Korea">South Korea</option>
                                                <option value="South Sudan">South Sudan</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka
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
                                                placeholder="Enter your City Name" autocomplete="" />
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
                                                placeholder="Address (e.g: House No, Road, Block)" autocomplete="" />
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
                                                name="end_user_country">
                                                <option value="" selected disabled
                                                    style="color: #7a7577 !important">
                                                    Select Country
                                                </option>
                                              <option value="Afghanistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Central African Republic">Central African Republic</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Eswatini">Eswatini</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="India">India</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Kosovo">Kosovo</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Laos">Laos</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libya">Libya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Micronesia">Micronesia</option>
                                                <option value="Moldova">Moldova</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montenegro">Montenegro</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="North Korea">North Korea</option>
                                                <option value="North Macedonia">North Macedonia</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau">Palau</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russia">Russia</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                <option value="Saint Lucia">Saint Lucia</option>
                                                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="São Tomé and Príncipe">São Tomé and Príncipe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Serbia">Serbia</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Korea">South Korea</option>
                                                <option value="South Sudan">South Sudan</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka
                                            </select>
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
                                                placeholder="Enter your City Name" autocomplete="" />
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('rfq-scripts')
<!-- RFQ Specific Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>

<script>
$(document).ready(function() {
    console.log('RFQ JavaScript loaded successfully');
    
    let currentStep = 1;
    const totalSteps = 4;

    // Custom validation rules
    $.validator.addMethod(
        "customEmail",
        function(value, element) {
            return (
                this.optional(element) ||
                /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)
            );
        },
        "Please enter a valid email (e.g., user@gmail.com)"
    );

    $.validator.addMethod(
        "customPhone",
        function(value, element) {
            const isValidPattern = /^\d{9,15}$/.test(value);
            return this.optional(element) || isValidPattern;
        },
        "Please enter a valid phone number between 9 and 15 digits."
    );

    $.validator.addMethod(
        "customZip",
        function(value, element) {
            return this.optional(element) || /^[0-9]{4,6}$/.test(value);
        },
        "Please enter a valid ZIP code with 4 to 6 digits"
    );

    $("#stepperForm").validate({
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorPlacement: function(error, element) {
            error.addClass("text-danger");
            error.insertAfter(element);
        },
        onkeyup: false,
        onfocusout: function(element) {
            $(element).valid();
            toggleNextButton();
            toggleCheckboxes();
        },
        onclick: false,
    });

    $('input[name="email"]').rules("add", { customEmail: true });
    $('input[name="phone"]').rules("add", { customPhone: true });
    $('input[name="zip_code"]').rules("add", { customZip: true });
    $('input[name="shipping_email"]').rules("add", { customEmail: true });
    $('input[name="shipping_phone"]').rules("add", { customPhone: true });
    $('input[name="shipping_zip_code"]').rules("add", { customZip: true });

    function toggleNextButton() {
        const $currentStepContent = $(`.step-content[data-step="${currentStep}"]`);
        const $requiredInputs = $currentStepContent
            .find("input, select, textarea")
            .filter("[required]");

        let allValid = true;
        if ($requiredInputs.length > 0) {
            $requiredInputs.each(function() {
                if (!$("#stepperForm").validate().element(this)) {
                    allValid = false;
                    return false;
                }
            });
        }
        $currentStepContent.find(".next-step").prop("disabled", !allValid);
    }

    function toggleCheckboxes() {
        const $step1 = $('.step-content[data-step="1"]');
        const $requiredInputs = $step1.find("input, select").filter("[required]");
        let allValid = true;

        $requiredInputs.each(function() {
            const isValid = $("#stepperForm").validate().element(this);
            if (!isValid) {
                allValid = false;
                return false;
            }
        });

        $("#deliveryAddress, #endUser").prop("disabled", !allValid);
    }

    function updateProgress() {
        $(".step").removeClass("active completed current-step-red");

        $(".step").each(function(index) {
            const stepNum = index + 1;
            if (stepNum < currentStep) {
                $(this).addClass("completed").find("i").show();
            } else if (stepNum === currentStep) {
                $(this).addClass("active current-step-red").find("i").hide();
            } else {
                $(this).removeClass("completed").find("i").hide();
            }
        });

        $(".step-content").removeClass("active");
        $(`.step-content[data-step="${currentStep}"]`).addClass("active");

        toggleNextButton();
        toggleCheckboxes();
    }

    $(document).on(
        "input change",
        ".step-content.active input, .step-content.active select, .step-content.active textarea",
        function() {
            toggleNextButton();
            toggleCheckboxes();
        }
    );

    $(".next-step").click(function() {
        const $currentStepContent = $(`.step-content[data-step="${currentStep}"]`);
        const $requiredInputs = $currentStepContent
            .find("input, select, textarea")
            .filter("[required]");

        if ($requiredInputs.length === 0 || $requiredInputs.valid()) {
            if (currentStep === 1) {
                const deliveryAddress = $("#deliveryAddress").is(":checked");
                const endUser = $("#endUser").is(":checked");

                if (deliveryAddress && endUser) {
                    currentStep = 4;
                } else if (deliveryAddress) {
                    currentStep = 3;
                } else {
                    currentStep = 2;
                }
            } else if (currentStep < totalSteps) {
                currentStep++;
            }
            updateProgress();
        } else {
            $requiredInputs.valid();
        }
    });

    $(".prev-step").click(function() {
        if (currentStep > 1) {
            currentStep--;
            updateProgress();
        }
    });

    let isSubmitting = false;
    $("#stepperForm").on("submit", function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return;
        }

        if ($(this).valid()) {
            isSubmitting = true;
            $(this).find('button[type="submit"]').prop('disabled', true);
            $(this).find('button[type="submit"]').html('Submitting...');
        } else {
            e.preventDefault();
        }
    });

    function handleCheckboxVisibility() {
        const $checkDefaultWrapper = $("#endUser").closest(".form-check");
        if ($("#resellerCheckbox").is(":checked")) {
            $checkDefaultWrapper.hide();
            $("#endUser").prop("checked", false);
        } else {
            $checkDefaultWrapper.show();
        }
    }

    $("#resellerCheckbox").on("change", function() {
        handleCheckboxVisibility();
        toggleNextButton();
        toggleCheckboxes();
    });

    function setupStepTwoJumpCheckbox() {
        $("#stepTwoGotoStep3").on("change", function() {
            if ($(this).is(":checked") && currentStep === 2) {
                currentStep = 3;
                updateProgress();
            }
        });
    }

    function setupStepTwoJumpCheckboxThree() {
        $("#stepThreeGotoStep4").on("change", function() {
            if ($(this).is(":checked") && currentStep === 3) {
                currentStep = 4;
                updateProgress();
            }
        });
    }

    // Repeater functionality
    $('.repeater').repeater({
        show: function() {
            const $row = $(this);
            $row.slideDown('fast', function() {
                updateSerials();
            });

            const $modal = $row.find('.modal');
            if ($modal.length) {
                const modalId = 'modal-' + Date.now() + '-' + Math.floor(Math.random() * 1000);
                $modal.attr('id', modalId);
                $modal.find('.modal-title').attr('id', modalId + 'Label');

                const $button = $row.find('[data-bs-toggle="modal"]');
                $button.attr('data-bs-target', '#' + modalId);
            }
        },
        hide: function(deleteElement) {
            const $item = $(this);
            const $list = $item.closest('[data-repeater-list]');
            const itemCount = $list.find('[data-repeater-item]').length;

            if (itemCount > 1) {
                $item.slideUp('fast', function() {
                    deleteElement();
                    updateSerials();
                });
            } else {
                alert('At least one item must remain.');
            }
        },
        isFirstItemUndeletable: false
    });

    // Field pairing for shipping address
    const shippingFieldPairs = [
        ['shipping_name', 'name'],
        ['shipping_email', 'email'],
        ['shipping_phone', 'phone'],
        ['shipping_company_name', 'company_name'],
        ['shipping_designation', 'designation'],
        ['shipping_address', 'address'],
        ['shipping_country', 'country'],
        ['shipping_city', 'city'],
        ['shipping_zip_code', 'zip_code']
    ];

    $('[name="is_contact_address"], .deliveryAddress').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('[name="is_contact_address"]').prop('checked', isChecked);
        $('.deliveryAddress').prop('checked', isChecked);
        shippingFieldPairs.forEach(([shippingName, contactName]) => {
            const value = isChecked ? $(`[name="${contactName}"]`).val() : '';
            $(`[name="${shippingName}"]`).val(value);
        });
    });

    // Field pairing for end user
    const endUserFieldPairs = [
        ['end_user_name', 'name'],
        ['end_user_email', 'email'],
        ['end_user_phone', 'phone'],
        ['end_user_company_name', 'company_name'],
        ['end_user_designation', 'designation'],
        ['end_user_address', 'address'],
        ['end_user_country', 'country'],
        ['end_user_city', 'city'],
        ['end_user_zip_code', 'zip_code']
    ];

    $('[name="end_user_is_contact_address"], .endUser').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('[name="end_user_is_contact_address"]').prop('checked', isChecked);
        $('.endUser').prop('checked', isChecked);

        endUserFieldPairs.forEach(([shippingName, contactName]) => {
            const value = isChecked ? $(`[name="${contactName}"]`).val() : '';
            $(`[name="${shippingName}"]`).val(value);
        });
    });

    // Initial setup
    handleCheckboxVisibility();
    updateProgress();
    setupStepTwoJumpCheckbox();
    setupStepTwoJumpCheckboxThree();
    updateSerials();
});

// Standalone functions
function increment(button) {
    const input = button.closest('.counting-btn').previousElementSibling;
    let value = parseInt(input.value);
    input.value = isNaN(value) || value < 1 ? 1 : value + 1;
}

function decrement(button) {
    const input = button.closest('.counting-btn').previousElementSibling;
    let value = parseInt(input.value);
    if (isNaN(value) || value <= 1) {
        input.value = 1;
    } else {
        input.value = value - 1;
    }
}

function updateSerials() {
    $('[data-repeater-list] [data-repeater-item]').each(function(i) {
        $(this).find('.sl-input').val(i + 1);
    });
}

function deleteRFQFromServer(rowId, onSuccess) {
    var cartHeader = $('.miniRFQQTY');
    var offcanvasRFQ = $('.offcanvasRFQ');

    $.ajax({
        type: 'GET',
        url: "rfq-remove/" + rowId,
        dataType: 'json',
        success: function(data) {
            cartHeader.empty();
            if (data.cartHeader > 0) {
                const label = data.cartHeader > 1 ? 'Item(s)' : 'Item';
                cartHeader.append(`${data.cartHeader} ${label} Added`);
            } else {
                cartHeader.append('Ask Query');
            }

            offcanvasRFQ.html(data.html);

            Swal.fire({
                icon: 'info',
                title: 'Successfully Removed from RFQ!',
                showConfirmButton: false,
                timer: 1500
            });

            if (typeof onSuccess === 'function') {
                onSuccess();
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Something happened. Try again.',
                text: error,
                showConfirmButton: true
            });
        }
    });
}

// Country placeholder
const selects = document.getElementsByClassName("countrySelect");
for (let i = 0; i < selects.length; i++) {
    const select = selects[i];
    if (select.value === "") {
        select.style.color = "#888888b2";
    }
    select.addEventListener("change", function() {
        if (select.value === "") {
            select.style.color = "#888888b2";
        } else {
            select.style.color = "#000";
        }
    });
}

function toggleDiv() {
    const checkbox = document.getElementById("delivery");
    const toggleContent = document.getElementById("toggle-content");
    toggleContent.style.display = checkbox.checked ? "block" : "none";
}

// Product name validation for file upload
const productInput = document.querySelector('[name="product_name"]');
const fileInput = document.querySelector('.file-input');
const warningText = document.querySelector('.warning-text');

function checkProductName() {
    if (productInput.value.trim() === "") {
        fileInput.disabled = true;
        warningText.style.display = "block";
    } else {
        fileInput.disabled = false;
        warningText.style.display = "none";
    }
}

if (productInput) {
    productInput.addEventListener('input', checkProductName);
    checkProductName();
}
</script>
@endsection