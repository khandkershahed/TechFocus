@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    @include('frontend.pages.brandPage.partials.page_header')
    <!-- content start -->
    <div class="container">
        <!-- Product Details -->
        <div class="row align-items-center">
            <div class="col-lg-12 col-sm-12">
                <div class="card rounded-0 p-5 border-0">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="xzoom-container w-100">
                                <!-- Main Image Default Show -->
                                <a data-fancybox-trigger="gallery" href="javascript:;">
                                    
                                    <img class="xzoom" id="xzoom-default" src="{{ asset($product->thumbnail) }}"
                                        xoriginal="{{ asset($product->thumbnail) }}" width="100%" height="100%" />
                                </a>
                                <!-- Main Image Default Show End-->
                                @if ($product->multiImages->isNotEmpty())
                                    <div class="xzoom-thumbs">
                                        @foreach ($product->multiImages as $multi_image)
                                            <a class="popup" data-fancybox="gallery"
                                                href="{{ asset($multi_image->photo) }}"><img class="xzoom-gallery"
                                                    src="{{ asset($multi_image->photo) }}"
                                                    xpreview="{{ asset($multi_image->photo) }}" width="80"
                                                    height="80" />
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div>
                                <div class="row gx-0 px-2">
                                    <h4>{{ $product->name }}</h4>
                                    <ul class="d-flex align-items-center p-1">
                                        @if (!empty($product->sku_code))
                                            <li class="me-2">
                                                <p class="p-0 m-0" style="color: rgb(134, 134, 134);font-size: 13px;"><i
                                                        class="fa-solid fa-tag me-1 single-bp-tag"></i><strong>NG #
                                                    </strong>{{ $product->sku_code }}</p>
                                            </li>
                                        @endif
                                        @if (!empty($product->mf_code))
                                            <li class="me-2">
                                                <p class="p-0 m-0" style="color: rgb(134, 134, 134);font-size: 13px;"><i
                                                        class="fa-solid fa-tag me-1 single-bp-tag"></i><strong>MF #
                                                    </strong>{{ $product->mf_code }}</p>
                                            </li>
                                        @endif
                                        @if (!empty($product->product_code))
                                            <li class="me-1">
                                                <p class="p-0 m-0" style="color: rgb(134, 134, 134);font-size: 13px;"><i
                                                        class="fa-solid fa-tag me-1 single-bp-tag"></i><strong>SKU #
                                                    </strong>{{ $product->product_code }}
                                                </p>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <p class="pt-3">Manufactured by:</p>
                                <div class="d-flex align-items-center fw-bold">
                                    <h2 class="font-monospace">{{ $product->brand->name }}</h2>
                                    {{-- <h2 class="ms-3 font-monospace">
                                        <i class="fa-solid fa-location-dot text-muted me-2"></i>Italy
                                    </h2> --}}
                                </div>
                                <!-- Rating Area -->
                                {{-- <div class="d-flex align-items-center">
                                    <div class="popover__wrapper me-2 border rounded-pill w-auto px-2 pt-1">
                                        <a href="#">
                                            <h2 class="popover__title" data-aos="fade-left">
                                                <div>
                                                    <i class="fa-solid fa-star main-color"></i>
                                                    <i class="fa-solid fa-star main-color"></i>
                                                    <!-- Empty Rating -->
                                                    <i class="fa-solid fa-star text-muted"></i>
                                                    <i class="fa-solid fa-star text-muted"></i>
                                                    <i class="fa-solid fa-star text-muted"></i>
                                                </div>
                                            </h2>
                                        </a>
                                        <div class="popover__content text-start">
                                            <span>Rating for the quality of the seller's responses,
                                                not the product.</span>
                                            <span>Rating for the quality of the seller's responses,
                                                not the product.</span>
                                        </div>
                                    </div>
                                    <p class="p-0 m-0 font-three">
                                        Feedback on the quality of responses
                                        <span class="main-color">(from 1 buyers)</span>
                                    </p>
                                </div> --}}
                                <!-- Seller Info -->
                                <div class="pt-2">
                                    <span><i class="fa-regular main-color fa-clock"></i> This
                                        seller generally responds in under 48 hours</span>
                                </div>
                                <!-- Button Area -->
                                <div class="mt-5">
                                    <button class="btn btn-outline-danger rounded-0">
                                        $ Request Price Options
                                    </button>
                                    <button class="btn signin w-auto rounded-0">
                                        $ Request Price Options
                                    </button>
                                </div>
                                <!-- Product Short Desc -->
                                <div class="mt-3">
                                    <p class="text-justify">
                                        {!! $product->short_desc !!}
                                    </p>
                                </div>
                                <!-- Others Button -->
                                <div class="d-flex main-color mt-4">
                                    <a href="">
                                        <i class="fa-solid fa-heart me-1"></i> Add to
                                        favorites</a>
                                    <span class="ms-2 me-2">|</span>
                                    <a href=""><i class="fa-solid fa-table-columns me-1"></i> Compare
                                        this product</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Extra Link -->
        {{-- <div class="row pt-3">
            <div class="col-lg-12 col-sm-12 text-end font-three">
                <a href="" class="main-color">Go to the EXPERT-TÜNKERS GmbH website for more information
                    <i class="ms-2 fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>
        </div> --}}
        <!-- Product Specification & Overview -->
        <div class="row mb-5 mt-5">
            @if (!empty($product->specification)) 
                <div class="{{ !empty($product->overview) ? 'col-lg-6' : 'col-lg-12' }}">
                    <div class="single-product-description" style="font-size: 16px">
                        <h2 class="description-title">Specification</h2>
                        <div class="container pb-3 specification-areas-brand">
                            <div class="row gx-1 px-2">
                                <p>{!! $product->specification !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (!empty($product->overview)) 
                <div class="{{ !empty($product->specification) ? 'col-lg-6' : 'col-lg-12' }}">
                    <div class="single-product-description text-justify" style="font-size: 16px; line-height: 1.5">
                        <h2 class="description-title">Description</h2>
                        <div class="container pb-3">
                            <div class="row ps-2">
                                <p>{!! $product->overview !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- Product Video & Catalog -->
        {{-- <div class="row mb-3">
            <div class="col-lg-6">
                <div class="single-product-description" style="font-size: 14px">
                    <h2 class="description-title">Video</h2>
                    <div class="container pb-3 mt-3 video-areas-brand">
                        <iframe class="responsive-iframe" src="https://www.youtube.com/embed/tgbNymZ7vqY"
                            style="width: 100%; height: 228px"></iframe>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="single-product-description" style="font-size: 14px">
                    <h2 class="description-title">CATALOGS</h2>
                    <div class="container pb-3">
                        <div class="row mt-3">
                            <div class="col">
                                <a href="">
                                    <div>
                                        <img src="https://img.directindustry.com/pdf/repository_di/17587/kr-agilus-waterproof-519707_1m.jpg"
                                            height="190px" width="100%" alt="" />
                                        <div class="catalog-details text-center">
                                            <p class="m-0 p-1">KR AGILUS Waterproof</p>
                                            <p class="p-1 m-0">2 Pages</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="">
                                    <div>
                                        <img src="https://img.directindustry.com/pdf/repository_di/17587/kr-agilus-waterproof-519707_1m.jpg"
                                            height="190px" width="100%" alt="" />
                                        <div class="catalog-details text-center">
                                            <p class="m-0 p-1">KR AGILUS Waterproof</p>
                                            <p class="p-1 m-0">2 Pages</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col">
                                <a href="">
                                    <div>
                                        <img src="https://img.directindustry.com/pdf/repository_di/17587/kr-agilus-waterproof-519707_1m.jpg"
                                            height="190px" width="100%" alt="" />
                                        <div class="catalog-details text-center">
                                            <p class="m-0 p-1">KR AGILUS Waterproof</p>
                                            <p class="p-1 m-0">2 Pages</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Extra Link -->
        {{-- <div class="row pt-3">
            <div class="col-lg-12 col-sm-12 text-end font-three">
                <a href="" class="main-color">Go to the {{ $product->brand->name }} website for more information
                    <i class="ms-2 fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>
        </div>
        <!-- Others Related Product-->
        <div class="row mt-3 mb-2">
            <h1 class="extra-titles">OTHER {{ $product->brand->name }} PRODUCTS</h1>
            <div class="col-lg-12">
                <div class="devider-wrap">
                    <h4 class="devider-content">
                        <span class="devider-text">TRANSPORTING TECHNOLOGY - LIFT POWERED ROLLERBED
                        </span>
                    </h4>
                </div>
            </div>
        </div> --}}
        {{-- <div class="row">
            <div class="col-lg-12">
                <!-- Related Product Slider -->
                <div class="swiper relatedProductSwiper my-2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="#" class="url-box">
                                <figure class="newsCard news-Slide-up rounded-0">
                                    <img class="img-fluid"
                                        src="https://img.directindustry.com/images_di/photo-mg/5693-18628211.jpg" />
                                    <div class="newsCaption px-4">
                                        <div class="d-flex align-items-center justify-content-between cnt-title">
                                            <h5 class="newsCaption-title text-white m-0">
                                                3D scanner
                                            </h5>
                                            <a href="asdasd">
                                                <img src="https://img.directindustry.com/images_di/logo-pp/L5693.gif"
                                                    width="20px" height="20px" alt="ZEISS Industrial Metrology"
                                                    loading="lazy" />
                                            </a>
                                            <a href="">
                                                <i class="fas fa-arrow-alt-circle-right"></i>
                                            </a>
                                        </div>
                                        <div class="newsCaption-content mt-2">
                                            <p class="col-10">ABIS III</p>
                                            <!-- Individual Content-->
                                            <div>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="overlay"></span>
                                </figure>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="url-box">
                                <figure class="newsCard news-Slide-up rounded-0">
                                    <img class="img-fluid"
                                        src="https://img.directindustry.com/images_di/photo-mg/5693-18628211.jpg" />
                                    <div class="newsCaption px-4">
                                        <div class="d-flex align-items-center justify-content-between cnt-title">
                                            <h5 class="newsCaption-title text-white m-0">
                                                3D scanner
                                            </h5>
                                            <a href="asdasd">
                                                <img src="https://img.directindustry.com/images_di/logo-pp/L5693.gif"
                                                    width="20px" height="20px" alt="ZEISS Industrial Metrology"
                                                    loading="lazy" />
                                            </a>
                                            <a href="">
                                                <i class="fas fa-arrow-alt-circle-right"></i>
                                            </a>
                                        </div>
                                        <div class="newsCaption-content mt-2">
                                            <p class="col-10">ABIS III</p>
                                            <!-- Individual Content-->
                                            <div>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="overlay"></span>
                                </figure>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="url-box">
                                <figure class="newsCard news-Slide-up rounded-0">
                                    <img class="img-fluid"
                                        src="https://img.directindustry.com/images_di/photo-mg/5693-18628211.jpg" />
                                    <div class="newsCaption px-4">
                                        <div class="d-flex align-items-center justify-content-between cnt-title">
                                            <h5 class="newsCaption-title text-white m-0">
                                                3D scanner
                                            </h5>
                                            <a href="asdasd">
                                                <img src="https://img.directindustry.com/images_di/logo-pp/L5693.gif"
                                                    width="20px" height="20px" alt="ZEISS Industrial Metrology"
                                                    loading="lazy" />
                                            </a>
                                            <a href="">
                                                <i class="fas fa-arrow-alt-circle-right"></i>
                                            </a>
                                        </div>
                                        <div class="newsCaption-content mt-2">
                                            <p class="col-10">ABIS III</p>
                                            <!-- Individual Content-->
                                            <div>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="overlay"></span>
                                </figure>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="url-box">
                                <figure class="newsCard news-Slide-up rounded-0">
                                    <img class="img-fluid"
                                        src="https://img.directindustry.com/images_di/photo-mg/5693-18628211.jpg" />
                                    <div class="newsCaption px-4">
                                        <div class="d-flex align-items-center justify-content-between cnt-title">
                                            <h5 class="newsCaption-title text-white m-0">
                                                3D scanner
                                            </h5>
                                            <a href="asdasd">
                                                <img src="https://img.directindustry.com/images_di/logo-pp/L5693.gif"
                                                    width="20px" height="20px" alt="ZEISS Industrial Metrology"
                                                    loading="lazy" />
                                            </a>
                                            <a href="">
                                                <i class="fas fa-arrow-alt-circle-right"></i>
                                            </a>
                                        </div>
                                        <div class="newsCaption-content mt-2">
                                            <p class="col-10">ABIS III</p>
                                            <!-- Individual Content-->
                                            <div>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="overlay"></span>
                                </figure>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="url-box">
                                <figure class="newsCard news-Slide-up rounded-0">
                                    <img class="img-fluid"
                                        src="https://img.directindustry.com/images_di/photo-mg/5693-18628211.jpg" />
                                    <div class="newsCaption px-4">
                                        <div class="d-flex align-items-center justify-content-between cnt-title">
                                            <h5 class="newsCaption-title text-white m-0">
                                                3D scanner
                                            </h5>
                                            <a href="asdasd">
                                                <img src="https://img.directindustry.com/images_di/logo-pp/L5693.gif"
                                                    width="20px" height="20px" alt="ZEISS Industrial Metrology"
                                                    loading="lazy" />
                                            </a>
                                            <a href="">
                                                <i class="fas fa-arrow-alt-circle-right"></i>
                                            </a>
                                        </div>
                                        <div class="newsCaption-content mt-2">
                                            <p class="col-10">ABIS III</p>
                                            <!-- Individual Content-->
                                            <div>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="overlay"></span>
                                </figure>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" class="url-box">
                                <figure class="newsCard news-Slide-up rounded-0">
                                    <img class="img-fluid"
                                        src="https://img.directindustry.com/images_di/photo-mg/5693-18628211.jpg" />
                                    <div class="newsCaption px-4">
                                        <div class="d-flex align-items-center justify-content-between cnt-title">
                                            <h5 class="newsCaption-title text-white m-0">
                                                3D scanner
                                            </h5>
                                            <a href="asdasd">
                                                <img src="https://img.directindustry.com/images_di/logo-pp/L5693.gif"
                                                    width="20px" height="20px" alt="ZEISS Industrial Metrology"
                                                    loading="lazy" />
                                            </a>
                                            <a href="">
                                                <i class="fas fa-arrow-alt-circle-right"></i>
                                            </a>
                                        </div>
                                        <div class="newsCaption-content mt-2">
                                            <p class="col-10">ABIS III</p>
                                            <!-- Individual Content-->
                                            <div>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                                <p class="p-0 m-0">
                                                    <i class="fa-solid fa-tag me-2 tags-text"></i>
                                                    <span class="tags-text">For surface inspection</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="overlay"></span>
                                </figure>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-button-next">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                    <div class="swiper-button-prev">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <!-- History Section Start -->
            </div>
        </div>
        <div class="row mt-3 mb-2">
            <h1 class="extra-titles">OTHER EXPERT-TÜNKERS GMBH PRODUCTS</h1>
            <div class="col-lg-12">
                <div class="devider-wrap">
                    <h4 class="devider-content">
                        <span class="devider-text">RECENTLY VIEWED PRODUCTS </span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a href="#" class="d-flex justify-content-end">
                    <span class="border rounded-pill p-2" style="font-size: 12px"><i class="fa fa-close me-2"
                            aria-hidden="true"></i> Clear
                        History</span>
                </a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-3">
                <a href="#" class="url-box">
                    <figure class="newsCard news-Slide-up rounded-0">
                        <p class="p-2 m-0">Lorem ipsum dolor sit amet.</p>
                        <img class="img-fluid"
                            src="https://img.directindustry.com/images_di/photo-mg/5693-18628211.jpg" />
                        <div class="newsCaption px-4">
                            <div class="newsCaption-content mt-5 text-center">
                                <a href=""> <i class="fa-regular fa-circle-xmark"></i></a>
                            </div>
                        </div>
                    </figure>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="#" class="url-box">
                    <figure class="newsCard news-Slide-up rounded-0">
                        <p class="p-2 m-0">Lorem ipsum dolor sit amet.</p>
                        <img class="img-fluid"
                            src="https://img.directindustry.com/images_di/photo-mg/5693-18628211.jpg" />
                        <div class="newsCaption px-4">
                            <div class="newsCaption-content mt-5 text-center">
                                <a href=""> <i class="fa-regular fa-circle-xmark"></i></a>
                            </div>
                        </div>
                    </figure>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="#" class="url-box">
                    <figure class="newsCard news-Slide-up rounded-0">
                        <p class="p-2 m-0">Lorem ipsum dolor sit amet.</p>
                        <img class="img-fluid"
                            src="https://img.directindustry.com/images_di/photo-mg/5693-18628211.jpg" />
                        <div class="newsCaption px-4">
                            <div class="newsCaption-content mt-5 text-center">
                                <a href=""> <i class="fa-regular fa-circle-xmark"></i></a>
                            </div>
                        </div>
                    </figure>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="#" class="url-box">
                    <figure class="newsCard news-Slide-up rounded-0">
                        <p class="p-2 m-0">Lorem ipsum dolor sit amet.</p>
                        <img class="img-fluid"
                            src="https://img.directindustry.com/images_di/photo-mg/5693-18628211.jpg" />
                        <div class="newsCaption px-4">
                            <div class="newsCaption-content mt-5 text-center">
                                <a href=""> <i class="fa-regular fa-circle-xmark"></i></a>
                            </div>
                        </div>
                    </figure>
                </a>
            </div>
        </div> --}}
        <!-- Related Search -->
        {{-- <div class="row mt-5 mb-5">
            <div class="col bg-light">
                <div class="card rounded-0 border-0 shadow-lg">
                    <div class="card-header rounded-0">
                        <h4 class="pt-2 text-center">Related Searches</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="related-items">
                                    <li class="rounded-pill bg-light">
                                        <a href="">Rail conveyor</a>
                                    </li>
                                    <li class="rounded-pill bg-light">
                                        <a href="">Belt conveyor</a>
                                    </li>
                                    <li class="rounded-pill bg-light">
                                        <a href="">Transfer conveyor</a>
                                    </li>
                                    <li class="rounded-pill bg-light">
                                        <a href="">Part conveyor</a>
                                    </li>
                                    <li class="rounded-pill bg-light">
                                        <a href="">Compact conveyor</a>
                                    </li>
                                    <li class="rounded-pill bg-light">
                                        <a href="">Assembly line conveyor</a>
                                    </li>
                                    <li class="rounded-pill bg-light">
                                        <a href="">Linear transfer system</a>
                                    </li>
                                    <li class="rounded-pill bg-light">
                                        <a href="">Modular transfer system</a>
                                    </li>
                                    <li class="rounded-pill bg-light">
                                        <a href="">Robot transfer system</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
