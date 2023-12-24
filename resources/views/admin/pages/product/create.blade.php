@extends('admin.master')
@section('content')
    <div class="post d-flex flex-column-fluid mb-3" id="kt_post">
        <div id="kt_content_container" class="container-fluid mb-3">
            <div class="card">
                <div class="main_bg card-header py-2 main_bg align-items-center">
                    <div class="col-lg-5 col-sm-12">
                        <div>
                            <a class="btn btn-sm btn-primary btn-rounded rounded-circle btn-icon back-btn"
                                href="{{ URL::previous() }}">
                                <i class="fa-solid fa-arrow-left text-white"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-sm-12 d-flex justify-content-start">
                        <h4 class="text-white p-0 m-0 fw-bold">Product Sourcing Add</h4>
                    </div>
                </div>
                <div class="card-body p-1">
                    <div class="row gx-0">
                        <div class="col-lg-2">
                            <ul class="nav nav-tabs nav-pills border-0 flex-row flex-md-column mb-3 mb-md-0 fs-6"
                                role="tablist">
                                <li class="nav-item w-md-290px me-0 my-1" role="presentation">
                                    <a class="nav-link p-5 rounded-0 active tab-trigger" data-bs-toggle="tab"
                                        href="#kt_vtab_pane_1" aria-selected="true" role="tab">Required Fields</a>
                                </li>
                                <li class="nav-item w-md-290px me-0 my-1" role="presentation">
                                    <a class="nav-link p-5 rounded-0 tab-trigger" data-bs-toggle="tab"
                                        href="#kt_vtab_pane_2" aria-selected="false" role="tab">General Informations</a>
                                </li>
                                <li class="nav-item w-md-290px me-0 my-1" role="presentation">
                                    <a class="nav-link p-5 rounded-0 tab-trigger" data-bs-toggle="tab"
                                        href="#kt_vtab_pane_3" aria-selected="false" role="tab"
                                        tabindex="-1">Descripton</a>
                                </li>
                                <li class="nav-item w-md-290px my-1" role="presentation">
                                    <a class="nav-link p-5 rounded-0 tab-trigger" data-bs-toggle="tab"
                                        href="#kt_vtab_pane_4" aria-selected="false" role="tab" tabindex="-1">Source
                                        Details</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-10 px-4 p-2">
                            <form id="productForm" method="post" action="{{ route('admin.product.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="kt_vtab_pane_1" role="tabpanel">
                                        <div class="w-100">
                                            <div class="pb-5 pb-lg-5">
                                                <h2
                                                    class="fw-bolder d-flex justify-content-center align-items-center text-dark">
                                                    Required Informations
                                                </h2>
                                                <p class="text-center p-0 m-0"><small
                                                        class="ms-4 text-danger fw-normal fs-sm-9">All The Red Star Mark
                                                        Field Is Required.</small></p>
                                            </div>
                                            <div class="fv-row">
                                                <div class="row">
                                                    <div class="col-lg-8 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Product Name</label>
                                                            <input name="name"
                                                                class="form-control form-control-sm form-control-solid"
                                                                placeholder="Enter Product Name" type="text" value="{{ old('name') }}" required />
                                                            <div class="invalid-feedback"> Please Enter Product Name.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">SKU Code</label>
                                                            <input name="sku_code"
                                                                class="form-control form-control-sm form-control-solid"
                                                                placeholder="Eg: NG-2647374" type="text" required />
                                                            <div class="invalid-feedback"> Please Enter SKU Code.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">MF Code</label>
                                                            <input name="mf_code"
                                                                class="form-control form-control-sm form-control-solid"
                                                                placeholder="Eg: MF-2647374" type="text" value="{{ old('mf_code') }}" required />
                                                            <div class="invalid-feedback"> Please Enter MF Code.</div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-4 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Notification Days</label>
                                                            <input name="notification_days"
                                                                class="form-control form-control-sm form-control-solid"
                                                                placeholder="Eg:15 days,30 days" type="text" value="{{ old('notification_days') }}" required />
                                                            <div class="invalid-feedback"> Please Enter Notification Days.
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-2 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Product Type</label>
                                                            <select class="form-select form-select-solid form-select-sm"
                                                                name="product_type" data-control="select2"
                                                                data-hide-search="true"
                                                                data-placeholder="Select an Product Type"
                                                                data-allow-clear="true" required>
                                                                <option></option>
                                                                <option value="software">Software</option>
                                                                <option value="hardware">Hardware</option>
                                                                <option value="book">Book</option>
                                                                <option value="training">Training</option>
                                                            </select>
                                                            <div class="invalid-feedback"> Please Enter Product Type.</div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-2 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Stock Status</label>
                                                            <select
                                                                class="form-select form-select-solid form-select-sm stock_select"
                                                                name="stock" data-control="select2"
                                                                data-placeholder="Select Stock Status"
                                                                data-allow-clear="true" required>
                                                                <option></option>
                                                                <option class="form-select" value="available">
                                                                    Available
                                                                </option>
                                                                <option class="form-select" value="limited">
                                                                    Limited</option>
                                                                <option class="form-select" value="unlimited">
                                                                    UnLimited</option>
                                                                <option class="form-select" value="stock_out">
                                                                    Out of Stock</option>
                                                            </select>
                                                            <div class="invalid-feedback"> Please Enter Stock Status.</div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-2 mb-3 qty_display d-none">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Current Stock</label>
                                                            <input type="number" name="qty" pattern="\d+"
                                                                step="1"
                                                                class="form-control form-control-sm form-control-solid qty_required"
                                                                placeholder="Enter Current Stock" required />
                                                            <div class="invalid-feedback"> Please Enter Current Stock.
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-2 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Price Status</label>
                                                            <select class="form-select form-select-solid form-select-sm"
                                                                data-control="select2"
                                                                data-placeholder="Select Price Status" name="price_status"
                                                                data-hide-search="true" data-allow-clear="true" required>
                                                                <option></option>
                                                                <option value="rfq">RFQ</option>
                                                                <option value="price">Price</option>
                                                                {{-- <option value="starting_price">Offer Price</option> --}}
                                                            </select>
                                                            <div class="invalid-feedback"> Please Enter Price Status.</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Brand Name</label>
                                                            <select class="form-select form-select-solid form-select-sm"
                                                                name="brand_id" data-control="select2"
                                                                data-placeholder="Select an Brand Name"
                                                                data-allow-clear="true" required>
                                                                <option></option>
                                                                @foreach ($brands as $brand)
                                                                    <option value="{{ $brand->id }}">{{ $brand->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback"> Please Enter Brand Name.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Category Name</label>
                                                            <select class="form-select form-select-solid form-select-sm"
                                                                name="category_id[]" id="field2" multiple
                                                                multiselect-search="true" multiselect-select-all="true">
                                                                @if (count($categories) > 0)
                                                                    @foreach ($categories->whereNull('parent_id') as $category)
                                                                        @include(
                                                                            'admin.pages.category.partial.add_parent',
                                                                            [
                                                                                'category' => $category,
                                                                                'level' => 0,
                                                                            ]
                                                                        )
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <div class="invalid-feedback"> Please Enter Category Name.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Industry Name</label>
                                                            <select class="form-select form-select-solid form-select-sm"
                                                                name="industry_id[]" id="field2" multiple
                                                                multiselect-search="true" multiselect-select-all="true"
                                                                multiselect-max-items="2">
                                                                @if (count($industries) > 0)
                                                                    @foreach ($industries as $industry)
                                                                        <option value="{{ $industry->id }}">
                                                                            {{ $industry->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <div class="invalid-feedback"> Please Enter Industry Name.
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-3 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Solution Name</label>
                                                            <select class="form-select form-select-solid form-select-sm"
                                                                name="solution_id[]" id="field2" multiple
                                                                multiselect-search="true" multiselect-select-all="true"
                                                                multiselect-max-items="2">
                                                                @if (count($solutions) > 0)
                                                                    @foreach ($solutions as $solution)
                                                                        <option value="{{ $solution->id }}">
                                                                            {{ $solution->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <div class="invalid-feedback"> Please Enter Solution Name.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <label class="form-label required">Thumbnail Image</label>
                                                        <div class="image-input image-input-empty"
                                                            data-kt-image-input="true"
                                                            style="background-image: url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSu9SD4sBJ2uIPWpGacTtmooVTnf3pW06iT33PFqNYxFoQMdq6ObFkaJYnhYaIIm8eGsak&usqp=CAU);width: auto;
                                                            background-size: contain;
                                                            border: 1px solid #009ae5;">
                                                            <div class="image-input-wrapper w-100px h-70px"></div>

                                                            <label
                                                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="change"
                                                                data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                title="Change avatar">
                                                                <i class="bi bi-pencil-fill fs-7"></i>

                                                                <input type="file" name="thumbnail"
                                                                    accept=".png, .jpg, .jpeg" />
                                                                <input type="hidden" name="avatar_remove" />
                                                            </label>

                                                            <span
                                                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="cancel"
                                                                data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                title="Cancel avatar">
                                                                <i class="bi bi-x fs-2"></i>
                                                            </span>

                                                            <span
                                                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                data-kt-image-input-action="remove"
                                                                data-bs-toggle="tooltip" data-bs-dismiss="click"
                                                                title="Remove avatar">
                                                                <i class="bi bi-x fs-2"></i>
                                                            </span>
                                                        </div>
                                                        <div class="invalid-feedback"> Please Enter Thumbnail Image. </div>
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <label class="form-label required">Multi Image</label>
                                                        {{-- <div class="fv-row">
                                                            <div class="dropzone" id="product_multiimage" name="multi_image[]">
                                                                <div class="dz-message needsclick p-6">
                                                                    <i
                                                                        class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>

                                                                    <div class="ms-4">
                                                                        <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Drop
                                                                            files here or click to upload.</h3>
                                                                        <span class="fs-7 fw-bold text-gray-400">Upload up
                                                                            to 10 files</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="dropzone-field">
                                                            <label for="files" class="custom-file-upload">
                                                                <div class="d-flex align-items-center">
                                                                    <p class="mb-0"><i
                                                                            class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                                    </p>
                                                                    <h5 class="mb-0">Drop files here or click to upload.
                                                                        <br>
                                                                        <span class="text-muted"
                                                                            style="font-size: 10px">Upload 10 File</span>
                                                                    </h5>
                                                                </div>
                                                            </label>
                                                            <input type="file" id="files" name="multi_img[]" multiple
                                                                class="form-control" style="display: none;"
                                                                onchange="console.log(this.selected.value)" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2 justify-content-end">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <a class="btn btn-lg btn-info rounded-0 tab-trigger-next"
                                                            data-bs-toggle="tab" data-bs-target="#kt_vtab_pane_2"
                                                            aria-selected="false" role="tab" tabindex="-1">
                                                            Continue
                                                            <span class="svg-icon svg-icon-4 ms-1 me-0">
                                                                <i class="fa-solid fa-arrow-right"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="kt_vtab_pane_2" role="tabpanel">
                                        <div class="w-100">
                                            <div class="pb-10 pb-lg-10">
                                                <h2
                                                    class="fw-bolder d-flex justify-content-center align-items-center text-dark">
                                                    General Informations
                                                </h2>
                                            </div>
                                            <div class="fv-row">
                                                <div class="row">
                                                    <div class="col-lg-9">
                                                        <label class="form-label">Tags</label>
                                                        <input class="form-control form-select-sm form-control-solid"
                                                            name="tags" id="kt_tagify_2" value="{{ old('tags') }}" />
                                                    </div>
                                                    <div class="col-lg-3 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Product Colors</label>
                                                            <select class="form-select form-select-solid form-select-sm"
                                                                name="color_id[]" id="field2" multiple
                                                                multiselect-search="true" multiselect-select-all="true"
                                                                multiselect-max-items="2">
                                                                @if (count($colors) > 0)
                                                                    @foreach ($colors as $color)
                                                                        <option value="{{ $color->id }}">
                                                                            {{ $color->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <div class="invalid-feedback"> Please Enter Product Colors.
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Parent Products</label>
                                                            <select class="form-select form-select-solid form-select-sm"
                                                                name="parent_id[]" id="field2" multiple
                                                                multiselect-search="true" multiselect-select-all="true"
                                                                multiselect-max-items="2">
                                                                @if (count($products) > 0)
                                                                    @foreach ($products as $parent_product)
                                                                        <option value="{{ $parent_product->id }}">
                                                                            {{ $parent_product->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <div class="invalid-feedback"> Please Enter Parent Product.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Child Products</label>
                                                            <select class="form-select form-select-solid form-select-sm"
                                                                name="child_id[]" id="field2" multiple
                                                                multiselect-search="true" multiselect-select-all="true"
                                                                multiselect-max-items="2">
                                                                @if (count($products) > 0)
                                                                    @foreach ($products as $child_product)
                                                                        <option value="{{ $child_product->id }}">
                                                                            {{ $child_product->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <div class="invalid-feedback"> Please Enter Child Products.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 mb-3">
                                                        <div class="fv-row mb-3">
                                                            <label class="form-label required">Currency</label>
                                                            <select class="form-select form-select-solid form-select-sm"
                                                                name="currency_id" data-control="select2"
                                                                data-placeholder="Select an Brand Name"
                                                                data-allow-clear="true" required>
                                                                <option></option>
                                                                @foreach ($currencys as $currency)
                                                                    <option value="{{ $currency->id }}">{{ $currency->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback"> Please Enter Currency</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3">
                                                        <label class="form-label"></label>
                                                        <div class="form-check form-check-custom form-check-solid mb-5">
                                                            <input class="form-check-input me-3" name="refurbished"
                                                                type="checkbox" value="1"
                                                                id="kt_docs_formvalidation_checkbox_option_1" />
                                                            <label class="form-check-label"
                                                                for="kt_docs_formvalidation_checkbox_option_1">
                                                                <div class="fw-bolder text-gray-800">Is Refurbished</div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 mb-3">
                                                        <label class="form-label"></label>
                                                        <div class="form-check form-check-custom form-check-solid mb-5">
                                                            <input class="form-check-input me-3" name="refurbished"
                                                                type="checkbox" value="1" id="dealCheckbox">
                                                            <label class="form-check-label">
                                                                <div class="fw-bolder text-gray-800">Is Deal</div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mb-3" id="dealsInputContainer"
                                                        style="display: none;">
                                                        <label class="form-label">Deal Price</label>
                                                        <input type="text"
                                                            class="form-control form-select-sm form-control-solid"
                                                            name="tags" placeholder="Enter Deal" />
                                                    </div>
                                                </div>
                                                <div class="row mt-2 justify-content-end">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <a class="btn btn-lg btn-info rounded-0 tab-trigger-previous"
                                                            data-bs-target="#kt_vtab_pane_1" aria-selected="false"
                                                            role="tab" tabindex="-1">
                                                            Previous
                                                            <span class="svg-icon svg-icon-4 ms-1 me-0">
                                                                <i class="fa-solid fa-arrow-right"></i>
                                                            </span>
                                                        </a>
                                                        <a class="btn btn-lg btn-info rounded-0 tab-trigger-next"
                                                            data-bs-toggle="tab" data-bs-target="#kt_vtab_pane_3"
                                                            aria-selected="false" role="tab" tabindex="-1">
                                                            Continue
                                                            <span class="svg-icon svg-icon-4 ms-1 me-0">
                                                                <i class="fa-solid fa-arrow-right"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="kt_vtab_pane_3" role="tabpanel">
                                        <div class="w-100">
                                            <div class="pb-10 pb-lg-10">
                                                <h2
                                                    class="fw-bolder d-flex justify-content-center align-items-center text-dark">
                                                    General Informations
                                                </h2>
                                            </div>
                                            <div class="fv-row">
                                                <div class="row">
                                                    <div class="col-lg-6 mb-2">
                                                        <label class="form-label mb-0">Short Desc</label>
                                                        <textarea name="short_desc" class="tox-target kt_docs_tinymce_plugins" placeholder="Write Short Desc">
                                                            {{ old('short_desc') }}
                                                        </textarea>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <label class="form-label mb-0">Overview</label>
                                                        <textarea name="overview" class="tox-target kt_docs_tinymce_plugins" placeholder="Write Overview">
                                                            {{ old('overview') }}
                                                        </textarea>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <label class="form-label mb-0">Specification</label>
                                                        <textarea name="specification" class="tox-target kt_docs_tinymce_plugins" placeholder="Write Specification">
                                                            {{ old('specification') }}
                                                        </textarea>
                                                    </div>
                                                    <div class="col-lg-6 mb-2">
                                                        <label class="form-label mb-0">Accessories</label>
                                                        <textarea name="accessories" class="tox-target kt_docs_tinymce_plugins" placeholder="Write Accessories">
                                                            {{ old('accessories') }}
                                                        </textarea>
                                                    </div>
                                                </div>
                                                <div class="row mt-2 justify-content-end">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <a class="btn btn-lg btn-info rounded-0 tab-trigger-previous"
                                                            data-bs-target="#kt_vtab_pane_2" aria-selected="false"
                                                            role="tab" tabindex="-1">
                                                            Previous
                                                            <span class="svg-icon svg-icon-4 ms-1 me-0">
                                                                <i class="fa-solid fa-arrow-right"></i>
                                                            </span>
                                                        </a>
                                                        <a class="btn btn-lg btn-info rounded-0 tab-trigger-next"
                                                            data-bs-toggle="tab" data-bs-target="#kt_vtab_pane_4"
                                                            aria-selected="false" role="tab" tabindex="-1">
                                                            Continue
                                                            <span class="svg-icon svg-icon-4 ms-1 me-0">
                                                                <i class="fa-solid fa-arrow-right"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="kt_vtab_pane_4" role="tabpanel">
                                        <div class="w-100">
                                            <div class="pb-10 pb-lg-10">
                                                <h2
                                                    class="fw-bolder d-flex justify-content-center align-items-center text-dark">
                                                    General Informations
                                                </h2>
                                            </div>
                                            <div class="fv-row">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="table-responsive">
                                                            <table
                                                                class="table table-hover table-rounded table-striped border gy-7 gs-7">
                                                                <thead>
                                                                    <tr
                                                                        class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                        <th>Source Name</th>
                                                                        <th>Source Link</th>
                                                                        <th>Price</th>
                                                                        <th>Estimate Time</th>
                                                                        <th>Principal Time</th>
                                                                        <th>Shipping Time</th>
                                                                        <th>Location</th>
                                                                        <th>Country</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_one_name" value="{{ old('source_one_name') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source one Name"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_one_link" value="{{ old('source_one_link') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source one link"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_one_price" value="{{ old('source_one_price') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source one price"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_one_estimate_time" value="{{ old('source_one_estimate_time') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source one estimate_time"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_one_principal_time" value="{{ old('source_one_principal_time') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source one principal_time"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_one_shipping_time" value="{{ old('source_one_shipping_time') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source one shipping_time"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_one_location" value="{{ old('source_one_location') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source one location"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_one_country" value="{{ old('source_one_country') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source one country"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_two_name" value="{{ old('source_two_name') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source two name"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_two_link" value="{{ old('source_two_link') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source two link"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_two_price" value="{{ old('source_two_price') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source two price"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_two_estimate_time" value="{{ old('source_two_estimate_time') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source two estimate_time"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_two_principal_time" value="{{ old('source_two_principal_time') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source two principal_time"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_two_shipping_time" value="{{ old('source_two_shipping_time') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source two shipping_time"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_two_location" value="{{ old('source_two_location') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source two location"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="source_two_country" value="{{ old('source_two_country') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter source two country"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="table-responsive">
                                                            <table
                                                                class="table table-hover table-rounded table-striped border gy-7 gs-7">
                                                                <thead>
                                                                    <tr
                                                                        class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                        <th>Competetor Name</th>
                                                                        <th>Competetor Link</th>
                                                                        <th>Price</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div>
                                                                                <input name="competitor_one_name" value="{{ old('competitor_one_name') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter Product Name"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="competitor_one_link" value="{{ old('competitor_one_link') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter Product Name"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="competitor_one_price" value="{{ old('competitor_one_price') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter Product Name"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div>
                                                                                <input name="competitor_two_name" value="{{ old('competitor_two_name') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter Product Name"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="competitor_two_link" value="{{ old('competitor_two_link') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter Product Name"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <input name="competitor_two_price" value="{{ old('competitor_two_price') }}"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Enter Product Name"
                                                                                    type="text" />
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label class="form-label mb-0">Source Contact</label>
                                                        <textarea rows="1" name="source_contact" value="{{ old('source_contact') }}" class="form-control form-control-sm form-control-solid"
                                                            placeholder="Enter Source Contact"></textarea>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <div class="table-responsive">
                                                            <table
                                                                class="table table-hover table-rounded table-striped border gy-7 gs-7">
                                                                <thead>
                                                                    <tr
                                                                        class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                                                        <th>Details</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div>
                                                                                Is this solid source? ( Y/N )
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex align-items-center fv-row">
                                                                                <div
                                                                                    class="form-check form-check-custom form-check-solid mb-5 me-2">
                                                                                    <input class="form-check-input me-2"
                                                                                        name="solid_source" value="{{ old('solid_source') }}" type="radio"
                                                                                        value="1"
                                                                                        id="kt_docs_formvalidation_radio_option_1" />

                                                                                    <label class="form-check-label"
                                                                                        for="kt_docs_formvalidation_radio_option_1">
                                                                                        <div
                                                                                            class="fw-bolder text-gray-800">
                                                                                            Yes</div>
                                                                                    </label>
                                                                                </div>

                                                                                <div
                                                                                    class="form-check form-check-custom form-check-solid mb-5 me-2">
                                                                                    <input class="form-check-input me-2"
                                                                                        name="solid_source" value="{{ old('solid_source') }}" type="radio"
                                                                                        value="2"
                                                                                        id="kt_docs_formvalidation_radio_option_2" />

                                                                                    <label class="form-check-label"
                                                                                        for="kt_docs_formvalidation_radio_option_2">
                                                                                        <div
                                                                                            class="fw-bolder text-gray-800">
                                                                                            No</div>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div>
                                                                                Is this direct Principal ? ( Y/N )
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex align-items-center fv-row">
                                                                                <div
                                                                                    class="form-check form-check-custom form-check-solid mb-5 me-2">
                                                                                    <input class="form-check-input me-2"
                                                                                        name="direct_principal" value="{{ old('direct_principal') }}"
                                                                                        type="radio" value="1"
                                                                                        id="kt_docs_formvalidation_radio_option_1" />

                                                                                    <label class="form-check-label"
                                                                                        for="kt_docs_formvalidation_radio_option_1">
                                                                                        <div
                                                                                            class="fw-bolder text-gray-800">
                                                                                            Yes</div>
                                                                                    </label>
                                                                                </div>

                                                                                <div
                                                                                    class="form-check form-check-custom form-check-solid mb-5 me-2">
                                                                                    <input class="form-check-input me-2"
                                                                                        name="direct_principal" value="{{ old('direct_principal') }}"
                                                                                        type="radio" value="2"
                                                                                        id="kt_docs_formvalidation_radio_option_2" />

                                                                                    <label class="form-check-label"
                                                                                        for="kt_docs_formvalidation_radio_option_2">
                                                                                        <div
                                                                                            class="fw-bolder text-gray-800">
                                                                                            No</div>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <div>
                                                                                Does it have Agreement ? ( Y/N )
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex align-items-center fv-row">
                                                                                <div
                                                                                    class="form-check form-check-custom form-check-solid mb-5 me-2">
                                                                                    <input class="form-check-input me-2"
                                                                                        name="agreement" value="{{ old('agreement') }}" type="radio"
                                                                                        value="1"
                                                                                        id="kt_docs_formvalidation_radio_option_1" />

                                                                                    <label class="form-check-label"
                                                                                        for="kt_docs_formvalidation_radio_option_1">
                                                                                        <div
                                                                                            class="fw-bolder text-gray-800">
                                                                                            Yes</div>
                                                                                    </label>
                                                                                </div>

                                                                                <div
                                                                                    class="form-check form-check-custom form-check-solid mb-5 me-2">
                                                                                    <input class="form-check-input me-2"
                                                                                        name="agreement" value="{{ old('agreement') }}" type="radio"
                                                                                        value="2"
                                                                                        id="kt_docs_formvalidation_radio_option_2" />

                                                                                    <label class="form-check-label"
                                                                                        for="kt_docs_formvalidation_radio_option_2">
                                                                                        <div
                                                                                            class="fw-bolder text-gray-800">
                                                                                            No</div>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Source Type :
                                                                        </td>
                                                                        <td>
                                                                            <select
                                                                                class="form-select form-select-solid form-select-sm"
                                                                                name="source_type" value="{{ old('source_type') }}" data-control="select2"
                                                                                data-hide-search="false"
                                                                                data-placeholder="Select an Source Type"
                                                                                data-allow-clear="true">
                                                                                <option></option>
                                                                                <option value="software">Software</option>
                                                                                <option value="hardware">Hardware</option>
                                                                                <option value="book">Book</option>
                                                                                <option value="training">Training</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2 justify-content-end">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <a class="btn btn-lg btn-info rounded-0 tab-trigger-previous"
                                                            data-bs-target="#kt_vtab_pane_3" aria-selected="false"
                                                            role="tab" tabindex="-1">
                                                            Previous
                                                            <span class="svg-icon svg-icon-4 ms-1 me-0">
                                                                <i class="fa-solid fa-arrow-right"></i>
                                                            </span>
                                                        </a>
                                                        <button class="btn btn-lg btn-info rounded-0" type="submit">
                                                            Submit
                                                            <span class="svg-icon svg-icon-4 ms-1 me-0">
                                                                <i class="fa-solid fa-arrow-right"></i>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.nav-tabs a').click(function() {
                $(this).tab('show');
            });
        });
    </script>
    
    <script>
        //---------Sidebar list Show Hide----------
        $(document).ready(function() {
            $('#dealId').click(function() {
                $("#dealExpand").toggle(this.checked);
            });
            $('#rfqId').click(function() {
                $("#rfqExpand").toggle('slow');
            });
        });
    </script>
    <script>
        $('.stock_select').on('change', function() {
            var stock_value = $(this).find(":selected").val();
            if (stock_value == 'available') {
                $(".qty_display").removeClass("d-none");
                $(".qty_required").prop('required', true);
            } else if (stock_value == 'limited') {
                $(".qty_display").removeClass("d-none");
                $(".qty_required").prop('required', true);
            } else {
                $(".qty_display").addClass("d-none");
                $(".qty_required").prop('required', false);
            }
        });


        $('.price_select').on('change', function() {
            var price_value = $(this).find(":selected").val();
            if (price_value == 'rfq') {
                // alert(price_value);
                $(".rfq_price").removeClass("d-none");
                $(".offer_price").addClass("d-none");
                $(".price").addClass("d-none");
            } else if (price_value == 'offer_price') {
                $(".offer_price").removeClass("d-none");
                $(".rfq_price").addClass("d-none");
                $(".price").addClass("d-none");
            } else {
                $(".price").removeClass("d-none");
                $(".offer_price").addClass("d-none");
                $(".rfq_price").addClass("d-none");
            }

        });
    </script>
    <script>
        var uploadedDocumentMap = {}; // Assuming you have this variable defined somewhere

        var myDropzone = new Dropzone("#product_multiimage", {
            url: "{{ route('admin.product.store') }}",
            paramName: "multi_image", // The name that will be used to transfer the file
            uploadMultiple: true,
            parallelUploads: 10,
            maxFiles: 10,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            accept: function(file, done) {
                console.log(file);
                $('#productForm').append('<input type="hidden" name="document[ value="{{ old('document') }}"]" value="' + file.file + '">');
                done();
            },
            method: "post",
        });

        document.getElementById('productForm').addEventListener('submit', function(event) {
            var formData = new FormData(this);
            console.log(formData);
        });
    </script>
    <script>
        // The DOM elements you wish to replace with Tagify
        var input1 = document.querySelector("#kt_tagify_1");
        var input2 = document.querySelector("#kt_tagify_2");

        // Initialize Tagify components on the above inputs
        new Tagify(input1);
        new Tagify(input2);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the checkbox and colors input container
            var checkbox = document.getElementById('dealCheckbox');
            var dealsInputContainer = document.getElementById('dealsInputContainer');

            // Add change event listener to the checkbox
            checkbox.addEventListener('change', function() {
                // Toggle the visibility of the colors input field based on checkbox state
                dealsInputContainer.style.display = checkbox.checked ? 'block' : 'none';
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Function to validate and switch tabs
            function validateAndSwitchTab(targetTabId) {
                let isValid = true;


                // Get the index of the tab to be shown
                const activeTabHref = $('.tab-trigger.active').attr('href');
                $(activeTabHref).find('input, textarea, select').each(function() {
                    var $field = $(this);


                    // Check if it's a Select2 element
                    var isSelect2 = $field.hasClass('select2-hidden-accessible');


                    if ($field.prop('required') && $field.val() === '') {
                        isValid = false;


                        if (isSelect2) {
                            // Apply CSS based on the element type
                            $field.next('.select2-container').addClass('is-invalid');
                        } else {
                            $field.addClass('is-invalid');
                        }
                    }
                });


                if (!isValid) {
                    // Fields are not valid, prevent the tab switch
                    return false;
                } else {
                    // Fields are valid, switch to the next tab
                    switchTab(targetTabId);
                    return true;
                }
            }


            // Function to switch tabs
            function switchTab(targetTabId) {
                $('.nav-link[href="' + targetTabId + '"]').tab('show');
            }


            // Event handler for tab switch
            $('.tab-trigger').on('show.bs.tab', function(event) {
                return validateAndSwitchTab($(this).data('bs-target'));
            });


            // Event handler for input change
            $('.tab-content').on('input change', 'input, textarea, select', function() {
                var $field = $(this);
                var isSelect2 = $field.hasClass('select2-hidden-accessible');


                // Remove red border when user interacts with the field
                if (isSelect2) {
                    $field.next('.select2-container').removeClass('is-invalid');
                } else {
                    $field.removeClass('is-invalid');
                }
            });


            // Event handler for multi-select change
            $('.multiple-select').on('change', function() {
                // Remove validation error only from the changed multi-select field
                var $multiSelect = $(this);
                $multiSelect.removeClass('is-invalid');
            });


            // Event handler for the "Continue" button
            $('.tab-trigger-next').on('click', function(event) {
                // Assuming the data-bs-target attribute contains the tab ID to switch to
                const targetTabId = $(this).data('bs-target');


                // Validate and switch to the next tab
                validateAndSwitchTab(targetTabId);
            });


            // Event handler for the "Previous" button
            $('.tab-trigger-previous').on('click', function(event) {
                // Assuming the data-bs-target attribute contains the tab ID to switch to
                const targetTabId = $(this).data('bs-target');


                // Validate and switch to the previous tab
                validateAndSwitchTab(targetTabId);
            });
        });
    </script>

   
@endpush
