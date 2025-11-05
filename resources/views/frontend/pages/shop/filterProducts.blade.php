@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    <!--Banner -->
    <div class="swiper bannerSwiper product-banner">
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
    <!-- content start -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs">
                    <div>
                        <a href="{{ route('homepage') }}" class="fw-bold">Home</a> &gt;
                        @if (optional($category)->parent_id != null)
                            <a href="{{ route('category', optional($category->parent)->slug) }}"
                                class="txt-mcl active">{{ optional($category->parent)->name }}</a>
                            &gt;
                        @endif
                        <span class="txt-mcl active fw-bold">{{ optional($category)->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-3">
        <div class="row mt-5 bg-white p-3 mx-4">
            <div class="col-lg-12 d-flex align-items-center justify-content-between">
                <div class="info-area d-flex align-items-center">
                    <h3 class="">{{ optional($category)->name }}</h3>
                    <div class="ms-4">
                        <i class="fa-solid fa-circle-question"></i>
                        <span>Do you need help making a decision?</span>
                    </div>
                </div>
                <div class="counting-area pt-3">
                    <h6>
                        <span class="main-color">{{ $products->count() }}</span> products
                    </h6>
                </div>
            </div>
        </div>
        <!-- Section Container -->
        <div class="row mt-3 mx-3">
            <div class="col-lg-2 col-sm-12">
                <div class="bg-white p-2 mb-2 mt-3 category-border-top">
                    <div class="checkbox-wrapper-15">
                        <input class="inp-cbx" id="cbx-1" type="checkbox" style="display: none" />
                        <label class="cbx" for="cbx-1">
                            <span>
                                <svg width="12px" height="9px" viewbox="0 0 12 9">
                                    <polyline points="1 5 4 8 11 1"></polyline>
                                </svg>
                            </span>
                            <span>What's New</span>
                        </label>
                    </div>
                </div>
                {{-- <!-- Main Category Start-->
                <!-- Manufacturers -->
                <div class="bg-white p-2 mb-2 mt-3 category-border-top">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed p-1 border-0" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOnemanufactureer"
                                    aria-expanded="false" aria-controls="flush-collapseOnemanufactureer">
                                    Manufacturers
                                </button>
                            </h2>
                            <div id="flush-collapseOnemanufactureer" class="accordion-collapse collapse border-0"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body p-0 m-0">
                                    <div class="pt-3">
                                        <input id="autocomplete_company" type="text"
                                            class="form-control shadow-sm rounded-0 p-0 m-0" placeholder="Search"
                                            data-listener-added_7a174d58="true" />
                                    </div>
                                    <!-- Menu -->
                                    <div class="mt-3 scroll-menu-container" style="height: 150px; overflow: auto">
                                        <ul class="m-0 p-0">
                                            <p class="pb-1 mb-0 pt-1 fw-bold main-color"></p>
                                            @foreach ($brands as $brand)
                                                <li class="p-2">
                                                    <div class="checkbox-wrapper-15">
                                                        <input class="inp-cbx" id="cbx-2" type="checkbox"
                                                            style="display: none" />
                                                        <label title="{{ $brand->title }}" class="cbx" for="cbx-2">
                                                            <span>
                                                                <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                                    <polyline points="1 5 4 8 11 1"></polyline>
                                                                </svg>
                                                            </span>
                                                            <span class="font-six">{{ $brand->title }}
                                                            </span>
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
                </div> --}}
                <!-- Main Category Start-->
<!-- Manufacturers -->
<div class="bg-white p-2 mb-2 mt-3 category-border-top">
    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed p-1 border-0" type="button"
                    data-bs-toggle="collapse" data-bs-target="#flush-collapseManufacturers"
                    aria-expanded="false" aria-controls="flush-collapseManufacturers">
                    Manufacturers
                </button>
            </h2>
            <div id="flush-collapseManufacturers" class="accordion-collapse collapse border-0"
                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body p-0 m-0">
                    <div class="pt-3">
                        <input id="autocomplete_company" type="text"
                            class="form-control shadow-sm rounded-0 p-0 m-0" placeholder="Search" />
                    </div>
                    <!-- Brand Menu -->
                    <div class="mt-3 scroll-menu-container" style="height: 150px; overflow: auto">
                        <ul class="m-0 p-0">
                            @foreach ($brands as $brand)
                                <li class="p-2">
                                    <a href="{{ route('category.show', ['slug' => $category->slug, 'brand_id' => $brand->id]) }}"
                                       class="d-block text-decoration-none">
                                        <div class="checkbox-wrapper-15">
                                            <input class="inp-cbx" id="cbx-{{ $brand->id }}" type="checkbox"
                                                style="display: none" 
                                                @if(request('brand_id') == $brand->id) checked @endif />
                                            <label class="cbx" for="cbx-{{ $brand->id }}">
                                                <span>
                                                    <svg width="12px" height="9px" viewBox="0 0 12 9">
                                                        <polyline points="1 5 4 8 11 1"></polyline>
                                                    </svg>
                                                </span>
                                                <span class="font-six">{{ $brand->title }}</span>
                                            </label>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                {{-- <!-- TECHNOLOGIES -->
                <div class="bg-white p-2 mb-2 mt-3 category-border-top">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed p-1 border-0" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOneTechnologies"
                                    aria-expanded="false" aria-controls="flush-collapseOneTechnologies">
                                    Technologies
                                </button>
                            </h2>
                            <div id="flush-collapseOneTechnologies" class="accordion-collapse collapse border-0"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body p-0 m-0">
                                    <div class="pt-3">
                                        <input id="autocomplete_company" type="text"
                                            class="form-control shadow-sm rounded-0 p-0 m-0" placeholder="Search"
                                            data-listener-added_7a174d58="true" />
                                    </div>
                                    <!-- Menu -->
                                    <div class="mt-3 scroll-menu-container" style="height: 150px; overflow: auto">
                                        <ul class="m-0 p-0">
                                            <p class="pb-1 mb-0 pt-1 fw-bold main-color">(</p>
                                            <li>
                                                <div class="checkbox-wrapper-15">
                                                    <input class="inp-cbx" id="cbx-14" type="checkbox"
                                                        style="display: none" />
                                                    <label title="Althen Sensors & Controls" class="cbx"
                                                        for="cbx-14">
                                                        <span>
                                                            <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                                <polyline points="1 5 4 8 11 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span class="font-two">Althen Sensors & Controls
                                                        </span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox-wrapper-15">
                                                    <input class="inp-cbx" id="cbx-15" type="checkbox"
                                                        style="display: none" />
                                                    <label title="AMOT" class="cbx" for="cbx-15">
                                                        <span>
                                                            <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                                <polyline points="1 5 4 8 11 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span class="font-two">AMOT </span> (1)
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox-wrapper-15">
                                                    <input class="inp-cbx" id="cbx-16" type="checkbox"
                                                        style="display: none" />
                                                    <label title="Amphenol" class="cbx" for="cbx-16">
                                                        <span>
                                                            <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                                <polyline points="1 5 4 8 11 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span class="font-two">Amphenol </span> (1)
                                                    </label>
                                                </div>
                                            </li>
                                            <p class="pb-1 mb-0 pt-1 fw-bold main-color">A</p>
                                            <li>
                                                <div class="checkbox-wrapper-15">
                                                    <input class="inp-cbx" id="cbx-2" type="checkbox"
                                                        style="display: none" />
                                                    <label title="Althen Sensors & Controls" class="cbx"
                                                        for="cbx-2">
                                                        <span>
                                                            <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                                <polyline points="1 5 4 8 11 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span class="font-two">Althen Sensors & Controls
                                                        </span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox-wrapper-15">
                                                    <input class="inp-cbx" id="cbx-17" type="checkbox"
                                                        style="display: none" />
                                                    <label title="AMOT" class="cbx" for="cbx-17">
                                                        <span>
                                                            <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                                <polyline points="1 5 4 8 11 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span class="font-two">AMOT </span> (1)
                                                    </label>
                                                </div>
                                            </li>
                                            <p class="pb-1 mb-0 pt-1 fw-bold main-color">B</p>
                                            <li>
                                                <div class="checkbox-wrapper-15">
                                                    <input class="inp-cbx" id="cbx-18" type="checkbox"
                                                        style="display: none" />
                                                    <label title="Althen Sensors & Controls" class="cbx"
                                                        for="cbx-18">
                                                        <span>
                                                            <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                                <polyline points="1 5 4 8 11 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span class="font-two">Althen Sensors & Controls
                                                        </span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="flush-headingThree">
                                                            <button class="accordion-button collapsed p-0 m-0"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#flush-collapseThree"
                                                                aria-expanded="false" aria-controls="flush-collapseThree">
                                                                <div class="checkbox-wrapper-15">
                                                                    <input class="inp-cbx" id="cbx-19" type="checkbox"
                                                                        style="display: none" />
                                                                    <label title="AMOT" class="cbx" for="cbx-19">
                                                                        <span>
                                                                            <svg width="12px" height="9px"
                                                                                viewbox="0 0 12 9">
                                                                                <polyline points="1 5 4 8 11 1"></polyline>
                                                                            </svg>
                                                                        </span>
                                                                        <span class="font-two">AMOT </span> (1)
                                                                    </label>
                                                                </div>
                                                            </button>
                                                        </h2>
                                                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                                                            aria-labelledby="flush-headingThree"
                                                            data-bs-parent="#accordionFlushExample">
                                                            <div class="accordion-body">
                                                                <div class="checkbox-wrapper-15">
                                                                    <input class="inp-cbx" id="cbx-20" type="checkbox"
                                                                        style="display: none" />
                                                                    <label title="AMOT" class="cbx" for="cbx-20">
                                                                        <span>
                                                                            <svg width="12px" height="9px"
                                                                                viewbox="0 0 12 9">
                                                                                <polyline points="1 5 4 8 11 1"></polyline>
                                                                            </svg>
                                                                        </span>
                                                                        <span class="font-two">AMOT </span> (1)
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <p class="pb-1 mb-0 pt-1 fw-bold main-color">C</p>
                                            <li>
                                                <div class="checkbox-wrapper-15">
                                                    <input class="inp-cbx" id="cbx-21" type="checkbox"
                                                        style="display: none" />
                                                    <label title="Althen Sensors & Controls" class="cbx"
                                                        for="cbx-21">
                                                        <span>
                                                            <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                                <polyline points="1 5 4 8 11 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span class="font-two">Althen Sensors & Controls
                                                        </span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox-wrapper-15">
                                                    <input class="inp-cbx" id="cbx-23" type="checkbox"
                                                        style="display: none" />
                                                    <label title="AMOT" class="cbx" for="cbx-23">
                                                        <span>
                                                            <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                                <polyline points="1 5 4 8 11 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span class="font-two">AMOT </span> (1)
                                                    </label>
                                                </div>
                                            </li>
                                            <p class="pb-1 mb-0 pt-1 fw-bold main-color">D</p>
                                            <li>
                                                <div class="checkbox-wrapper-15">
                                                    <input class="inp-cbx" id="cbx-24" type="checkbox"
                                                        style="display: none" />
                                                    <label title="Althen Sensors & Controls" class="cbx"
                                                        for="cbx-24">
                                                        <span>
                                                            <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                                <polyline points="1 5 4 8 11 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span class="font-two">Althen Sensors & Controls
                                                        </span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox-wrapper-15">
                                                    <input class="inp-cbx" id="cbx-25" type="checkbox"
                                                        style="display: none" />
                                                    <label title="AMOT" class="cbx" for="cbx-25">
                                                        <span>
                                                            <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                                <polyline points="1 5 4 8 11 1"></polyline>
                                                            </svg>
                                                        </span>
                                                        <span class="font-two">AMOT </span> (1)
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Price -->
                <div class="bg-white p-2 mb-2 mt-3 category-border-top">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed p-1 border-0" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOnePressureRange"
                                    aria-expanded="false" aria-controls="flush-collapseOnePressureRange">
                                    Pressure Range
                                </button>
                            </h2>
                            <div id="flush-collapseOnePressureRange" class="accordion-collapse collapse border-0"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body p-0 m-0">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="price-range">
                                                    <input type="text" id="price-slider" name="price-slider"
                                                        value="" />
                                                </div>

                                                <div class="price-values d-flex">
                                                    <div>
                                                        <input type="number"
                                                            class="form-control form-control-sm rounded-0" id="min-price"
                                                            min="0" step="1" value="0" />
                                                    </div>

                                                    <div class="ms-1">
                                                        <input type="number"
                                                            class="form-control form-control-sm rounded-0" id="max-price"
                                                            min="0" step="1" value="100" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <!-- Main Category End-->
            <div class="col-lg-10 col-sm-12">
                <div class="card rounded-0 border-0 mt-2 p-1">
                    <div class="card-header d-flex align-items-center bg-white border-0">
                        <div>
                            <img src="https://img.virtual-expo.com/media/ps/images/di/logos/GA-icon.svg" width="25px"
                                height="25px" alt="" />
                        </div>
                        <h6 class="ms-2 pt-3">
                            {{ $category->name }} | Choosing the right {{ $category->name }}
                        </h6>
                    </div>
                    {{-- <div class="card-body">
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
                        <a href="" class="btn signin rounded-0 w-auto mt-2">Read More</a>
                    </div> --}}
                </div>
                <div class="row my-3">
                    @foreach ($products as $product)
                        <div class="col-lg-3 col-sm-12 mb-5">
                            <div class="card border-0 card-news-trends" style="height: 400px">
                                <div class="content">
                                    <div class="front">
                                        <img class="profile" width="100%" height="200px" src="{{ $product->thumbnail }}"
                                            alt="{{ $product->name }}" />
                                        <div class="d-flex align-items-center justify-content-between px-3 py-2 mt-3">
                                            <div>
                                                <a href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => optional($product)->slug]) }}">
                                                    <h6 class="text-start mb-0">
                                                        {{ Str::words( $product->name , 7) }}
                                                    </h6>
                                                </a>
                                            </div>

                                            <!-- Brand Logo -->
                                            <div>
                                                <a href="{{ route('brand.overview',optional($product->brand)->slug) }}" class="">
                                                    <img class="lazyLoaded logo right" style="width: 150px;"
                                                        src="{{ asset('storage/brand/logo/' . optional($product->brand)->logo) }}"
                                                        title="{{ optional($product->brand)->title }}" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="back from-bottom text-start">
                                        <span class="font-three pt-3 text-muted text-center">
                                            <a href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => optional($product)->slug]) }}"
                                                class="btn signin w-auto rounded-0">Detals</a>
                                        </span>
                                        <br />
                                        <p class="pt-3 m-0 font-five">
                                            {{ $product->name }}
                                        </p>
                                        <p class="subtitles"></p>
                                        <p class="p-1 text-justify mb-0">
                                            {!! Str::words( $product->short_desc , 10) !!}
                                        </p>
                                        {{-- <p class="pt-3 pb-2 m-0 text-center" style="border-top: 1px solid #eee">
                                            <a href="">
                                                <span class="news-link">
                                                    <i class="fa-solid fa-window-restore me-2"></i>Compare This Product
                                                </span>
                                            </a>
                                        </p> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <p class="text-center">Choose By Page</p>
                        <div class="d-flex justify-content-center">
                                {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="container">
        <div class="row bg-white">
            <p class="my-3">HOW TO CHOOSE THIS PRODUCT</p>
            <div class="col-lg-3">
                <div>
                    <img src="https://img.directindustry.com/images_di/kwref/kwref-m2/6/6/60866.jpg" alt="" />
                </div>
            </div>
            <div class="col-lg-9">
                <p>
                    Pressure sensor detects pressure and transfors this physical value
                    into an electrical output signal. A device connected to the sensor
                    calculates the pressure and displays it in bars, pascals (Pa),
                    pounds per square inch (psi) or atmospheres.
                </p>
                <p>
                    <strong>Applications</strong> <br />
                    These devices are used in every industrial sector for measuring
                    process conditions. They also are used to measure atmospheric
                    pressure in climatology.
                </p>
                <p>
                    <strong>Technologies</strong> <br />
                    Various techniques are used to measure pressure. These include
                    capacitive, inductive, piezoresistive, piezoelectric and
                    Hall-effect methods.
                </p>
                <p>
                    <strong>How to choose</strong> <br />
                    In addition to temperature, explosion risk and other environmental
                    factors, choice will depend on the range of values and whether
                    measuring relative, absolute, differential or vacuum (negative
                    gauge) pressure.
                </p>
            </div>
        </div>
        <div class="row p-5">
            <div class="col-lg-12">
                <div class="d-flex justify-content-center">
                    <h4 class="me-5">Subscribe to our newsletter</h4>
                    <div class="search w-auto">
                        <input type="text" class="searchTerm w-auto" placeholder="Your Mail"
                            style="height: auto; border-radius: 0" />
                        <button type="submit" class="searchButton rounded-0">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center pb-5">
                <p>Receive updates on this section every two weeks.</p>
                <p>
                    Please refer to our
                    <a href="" class="main-color">Privacy Policy</a> for details on
                    how DirectIndustry processes your personal data.
                </p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row p-3 bg-white">
            <div class="col-lg-12 col-sm-12 pt-3">
                <p class="text-center">Average score: 4.0/5 (53 votes)</p>
                <p class="text-center">
                    With DirectIndustry you can: Find the product, subcontractor or
                    service provider you need | Find a nearby distributor or reseller|
                    Contact the manufacturer to get a quote or a price | Examine
                    product characteristics and technical specifications for major
                    brands | View PDF catalogues and other online documentation
                </p>
                <p class="sub-color text-center w-75 mx-auto">
                    *Prices are pre-tax. They exclude delivery charges and customs
                    duties and do not include additional charges for installation or
                    activation options. Prices are indicative only and may vary by
                    country, with changes to the cost of raw materials and exchange
                    rates.
                </p>
            </div>
        </div>
    </div> --}}
@endsection
