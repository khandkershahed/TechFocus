@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
<!--Banner -->
<div class="shadow-none swiper bannerSwiper product-banner">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <a href="">
                <img src="https://img.directindustry.com/images_di/bnr/15876/hd/55276.jpg" class="img-fluid"
                    alt="" />
            </a>
        </div>
        <div class="swiper-slide">
            <a href="">
                <img src="https://img.directindustry.com/images_di/bnr/68695/hd/54611.jpg" class="img-fluid"
                    alt="" />
            </a>
        </div>
        <div class="swiper-slide">
            <a href="">
                <img src="https://img.directindustry.com/images_di/bnr/23164/hd/55467.jpg" class="img-fluid"
                    alt="" />
            </a>
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div>

<div class="container my-3 mt-4">
    <div class="mx-4 mt-2 bg-white row align-items-center rounded-3">
        <div class="col-lg-12 d-flex align-items-center justify-content-between">
            <div class="info-area d-flex align-items-center">
                <h3 class="mb-0">{{ optional($category)->name }}</h3>
                <div class="ms-4">
                    <div>
                        <i class="fas fa-house-chimney-window text-primary"></i>
                        <a href="{{ route('homepage') }}" class="fw-bold">Home</a> /
                        @if (optional($category)->parent_id != null)
                        <a href="{{ route('category', optional($category->parent)->slug) }}"
                            class="txt-mcl active">{{ optional($category->parent)->name }}</a>
                        /
                        @endif
                        <span class="txt-mcl active fw-bold">{{ optional($category)->name }}</span>
                    </div>
                </div>
            </div>
            <div class="pt-3 counting-area">
                <h6>
                    <span class="main-color">{{ $products->count() }}</span> products
                </h6>
            </div>
        </div>
    </div>
    <!-- Section Container -->
    <div class="mx-3 mt-3 row">
        <div class="col-lg-3 col-sm-12">
            <div class="p-3 mt-3 mb-2 bg-white category-border-top rounded-3">
                <div class="checkbox-wrapper-21">
                    <label class="control control--checkbox">
                        What's New
                        <input type="checkbox" name="whats_new" value="1"
                            onchange="document.getElementById('filterForm').submit()"
                            {{ request('whats_new') == '1' ? 'checked' : '' }} />
                        <div class="control__indicator"></div>
                    </label>
                </div>
            </div>
            <!-- Main Category Start-->
            <!-- Manufacturers -->
            <div class="p-3 my-3 bg-white category-border-top rounded-3">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="p-1 border-0 accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOnemanufactureer"
                                aria-expanded="false" aria-controls="flush-collapseOnemanufactureer">
                                Manufacturers
                            </button>
                        </h2>
                        <div id="flush-collapseOnemanufactureer" class="border-0 accordion-collapse collapse"
                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="p-0 m-0 accordion-body">
                                <div class="pt-3 position-relative">
                                    <input
                                        id="autocomplete_company"
                                        type="text"
                                        class="py-2 form-control ps-5 rounded-3"
                                        placeholder="Search...">
                                    <i class="pt-3 fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                                </div>
                                <!-- Menu -->
                                <div class="mt-3 scroll-menu-container" style="height: 500px; overflow: auto">
                                    <ul class="p-0 m-0" id="brandList">
                                        @foreach ($brands as $brand)
                                        <li class="p-2 brand-item">
                                            <div class="checkbox-wrapper-21">
                                                <label class="control control--checkbox">
                                                    {{ $brand->title }}
                                                    <input type="checkbox" name="brand_id" value="{{ $brand->id }}"
                                                        onchange="document.getElementById('filterForm').submit()"
                                                        {{ request('brand_id') == $brand->id ? 'checked' : '' }} />
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Category End-->
        <div class="col-lg-9 col-sm-12">
            <div class="p-1 mt-2 border-0 card rounded-0">
                <div class="bg-white border-0 card-header d-flex align-items-center">
                    <div>
                        <img src="https://img.virtual-expo.com/media/ps/images/di/logos/GA-icon.svg" width="25px"
                            height="25px" alt="" />
                    </div>
                    <h6 class="mb-0 ms-3 fw-bold">
                        {{ $category->name }} | Choosing the right {{ $category->name }}
                    </h6>
                </div>
                <div class="card-body">
                    <p style="line-height: 1.1">
                        Measuring pressure is necessary in the control of most
                        industrial processes. A pressure sensor converts pressure
                        information into an electrical signal. Most pressure sensors
                        measure the deformation of a membrane under the effect of the
                        difference in the pressure applied to both sides.
                        Manufacturers use different terms for these products. While
                        “pressure sensor” and “pressure transducer” can be considered
                        synonyms, the term “pressure transmitter” refers to a...
                    </p>
                    <a href="" class="w-auto mt-2 btn signin rounded-0">Read More</a>
                </div>
            </div>
            <div class="mt-3 row gx-3">
                @foreach ($products as $product)
                <div class="mb-3 col-lg-3 col-sm-12">
                    <div class="overflow-hidden border-0 shadow-sm card rounded-4 card-hover h-100">
                        <div class="position-relative">
                            <!-- Product Image -->
                            <img
                                src="{{ $product->thumbnail }}"
                                alt="{{ $product->name }}"
                                class="w-100"
                                style="height: 250px; object-fit: contain;">
                            <!-- Brand Logo (Overlay Top Right) -->
                            <a href="{{ route('brand.overview', optional($product->brand)->slug) }}"
                                class="top-0 p-1 m-2 bg-white rounded shadow-sm position-absolute end-0">
                                <img
                                    src="{{ asset('storage/brand/logo/' . optional($product->brand)->logo) }}"
                                    alt="{{ optional($product->brand)->title }}"
                                    class="img-fluid"
                                    style="width: 60px; object-fit: contain;"
                                    onerror="this.onerror=null;this.src='{{ asset('https://www.techfocusltd.com/storage/brand/logo/apc-logo_AndEzWuc.png') }}';">
                            </a>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <!-- Product Title -->
                            <a href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => optional($product)->slug]) }}"
                                class="text-decoration-none text-dark">
                                <h6 class="mb-2 fw-bold text-truncate">{{ Str::words($product->name, 7) }}</h6>
                            </a>
                            <!-- Product Short Description -->
                            <p class="mb-3 text-muted small">
                                {!! Str::words($product->short_desc, 8) !!}
                            </p>
                            <!-- Buttons -->
                            <div class="mt-auto">
                                <a href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => optional($product)->slug]) }}"
                                    class="btn btn-sm btn-outline-primary w-100 rounded-pill">
                                    <i class="fa-solid fa-circle-info me-1"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Brand Filter Search Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('autocomplete_company');
        input.addEventListener('keyup', function() {
            let search = this.value.toLowerCase();
            document.querySelectorAll('#brandList .brand-item').forEach(function(item) {
                let text = item.textContent.toLowerCase();
                item.style.display = text.includes(search) ? '' : 'none';
            });
        });
    });
</script>
@endsection