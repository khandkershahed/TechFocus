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
                <div class="p-5 border-0 card rounded-0">
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
                                <div class="px-2 row gx-0">
                                    <h4>{{ $product->name }}</h4>
                                    <ul class="p-1 d-flex align-items-center">
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
                                    <div class="w-auto px-2 pt-1 border popover__wrapper me-2 rounded-pill">
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
                                <!-- Add this form to your page -->
                            <form id="cart-form-{{ $product->id }}" method="POST" action="{{ route('cart.add') }}" style="display: none;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                            </form>
                                <div class="pt-2">
                                    <span><i class="fa-regular main-color fa-clock"></i> This
                                        seller generally responds in under 48 hours</span>
                                </div>
                                <!-- Button Area -->
                                <div class="mt-5">
                                         <button class="btn btn-outline-danger rounded-0 add-to-cart-btn" 
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->name }}"
                                                data-product-price="{{ $product->sas_price ?? 0 }}"
                                                data-product-thumbnail="{{ asset($product->thumbnail) }}">
                                            <i class="fas fa-shopping-cart me-2"></i> $ Request Price Options
                                                                                </button>
                                    <button class="w-auto btn signin rounded-0" onclick="window.location.href='{{ route('rfq.create') }}'">
                                                Get Quote
                                            </button>
                                </div>
                                <!-- Product Short Desc -->
                                <div class="mt-3">
                                    <p class="text-justify">
                                        {!! $product->short_desc !!}
                                    </p>
                                </div>
                                <!-- Others Button -->
            <div class="mt-4 d-flex main-color">
                                            @auth
                            <form action="{{ route('favorites.store', $product->id) }}" method="POST" class="me-2">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 text-decoration-none main-color">
                                    <i class="fa-solid fa-heart me-1"></i>
                                    @if(Auth::user()->favourites->contains('product_id', $product->id))
                                        Added to Favorites
                                    @else
                                        Add to Favorites
                                    @endif
                                </button>
                            </form>
                        @else
                            <div class="dropdown me-2">
                                <a class="btn btn-link dropdown-toggle p-0 text-decoration-none main-color" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-heart me-1"></i> Add to Favorites
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('login', ['type' => 'client', 'redirect_to' => url()->current(), 'product_id' => $product->id]) }}">
                                            Login as Client
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('partner.login', ['type' => 'partner', 'redirect_to' => url()->current(), 'product_id' => $product->id]) }}">
                                            Login as Partner
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endauth
                        <div class="mt-4 d-flex main-color">
                                <a href="{{ route('products.compare.add', $product->id) }}" class="text-decoration-none main-color me-2">
                                    <i class="fa-solid fa-table-columns me-1"></i> Compare this product
                                </a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Extra Link -->
        {{-- <div class="pt-3 row">
            <div class="col-lg-12 col-sm-12 text-end font-three">
                <a href="" class="main-color">Go to the EXPERT-TÜNKERS GmbH website for more information
                    <i class="ms-2 fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>
        </div> --}}
        <!-- Product Specification & Overview -->
        <div class="mt-5 mb-5 row">
            @if (!empty($product->specification)) 
                <div class="{{ !empty($product->overview) ? 'col-lg-6' : 'col-lg-12' }}">
                    <div class="single-product-description" style="font-size: 16px">
                        <h2 class="description-title">Specification</h2>
                        <div class="container pb-3 specification-areas-brand">
                            <div class="px-2 row gx-1">
                                <p>{!! $product->specification !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (!empty($product->overview)) 
                <div class="{{ !empty($product->specification) ? 'col-lg-6' : 'col-lg-12' }}">
                    <div class="text-justify single-product-description" style="font-size: 16px; line-height: 1.5">
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
        {{-- <div class="mb-3 row">
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
                        <div class="mt-3 row">
                            <div class="col">
                                <a href="">
                                    <div>
                                        <img src="https://img.directindustry.com/pdf/repository_di/17587/kr-agilus-waterproof-519707_1m.jpg"
                                            height="190px" width="100%" alt="" />
                                        <div class="text-center catalog-details">
                                            <p class="p-1 m-0">KR AGILUS Waterproof</p>
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
                                        <div class="text-center catalog-details">
                                            <p class="p-1 m-0">KR AGILUS Waterproof</p>
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
                                        <div class="text-center catalog-details">
                                            <p class="p-1 m-0">KR AGILUS Waterproof</p>
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
        {{-- <div class="pt-3 row">
            <div class="col-lg-12 col-sm-12 text-end font-three">
                <a href="" class="main-color">Go to the {{ $product->brand->name }} website for more information
                    <i class="ms-2 fa-solid fa-arrow-up-right-from-square"></i></a>
            </div>
        </div>
        <!-- Others Related Product-->
        <div class="mt-3 mb-2 row">
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
                <div class="my-2 swiper relatedProductSwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="#" class="url-box">
                                <figure class="newsCard news-Slide-up rounded-0">
                                    <img class="img-fluid"
                                        src="https://img.directindustry.com/images_di/photo-mg/5693-18628211.jpg" />
                                    <div class="px-4 newsCaption">
                                        <div class="d-flex align-items-center justify-content-between cnt-title">
                                            <h5 class="m-0 text-white newsCaption-title">
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
                                        <div class="mt-2 newsCaption-content">
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
                                    <div class="px-4 newsCaption">
                                        <div class="d-flex align-items-center justify-content-between cnt-title">
                                            <h5 class="m-0 text-white newsCaption-title">
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
                                        <div class="mt-2 newsCaption-content">
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
                                    <div class="px-4 newsCaption">
                                        <div class="d-flex align-items-center justify-content-between cnt-title">
                                            <h5 class="m-0 text-white newsCaption-title">
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
                                        <div class="mt-2 newsCaption-content">
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
                                    <div class="px-4 newsCaption">
                                        <div class="d-flex align-items-center justify-content-between cnt-title">
                                            <h5 class="m-0 text-white newsCaption-title">
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
                                        <div class="mt-2 newsCaption-content">
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
                                    <div class="px-4 newsCaption">
                                        <div class="d-flex align-items-center justify-content-between cnt-title">
                                            <h5 class="m-0 text-white newsCaption-title">
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
                                        <div class="mt-2 newsCaption-content">
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
                                    <div class="px-4 newsCaption">
                                        <div class="d-flex align-items-center justify-content-between cnt-title">
                                            <h5 class="m-0 text-white newsCaption-title">
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
                                        <div class="mt-2 newsCaption-content">
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
        <div class="mt-3 mb-2 row">
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
                    <span class="p-2 border rounded-pill" style="font-size: 12px"><i class="fa fa-close me-2"
                            aria-hidden="true"></i> Clear
                        History</span>
                </a>
            </div>
        </div>
        <div class="mt-2 row">
            <div class="col-lg-3">
                <a href="#" class="url-box">
                    <figure class="newsCard news-Slide-up rounded-0">
                        <p class="p-2 m-0">Lorem ipsum dolor sit amet.</p>
                        <img class="img-fluid"
                            src="https://img.directindustry.com/images_di/photo-mg/5693-18628211.jpg" />
                        <div class="px-4 newsCaption">
                            <div class="mt-5 text-center newsCaption-content">
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
                        <div class="px-4 newsCaption">
                            <div class="mt-5 text-center newsCaption-content">
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
                        <div class="px-4 newsCaption">
                            <div class="mt-5 text-center newsCaption-content">
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
                        <div class="px-4 newsCaption">
                            <div class="mt-5 text-center newsCaption-content">
                                <a href=""> <i class="fa-regular fa-circle-xmark"></i></a>
                            </div>
                        </div>
                    </figure>
                </a>
            </div>
        </div> --}}
        <!-- Related Search -->
        {{-- <div class="mt-5 mb-5 row">
            <div class="col bg-light">
                <div class="border-0 shadow-lg card rounded-0">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    console.log('Cart system initialized');

    // Test the debug endpoint first
    function testCartSystem() {
        console.log('Testing cart system...');
        $.get('{{ route("cart.debug") }}', function(response) {
            console.log('Debug test result:', response);
        }).fail(function(xhr) {
            console.error('Debug test failed:', xhr);
        });
    }

    // Run test on page load
    testCartSystem();

    $('.add-to-cart-btn').click(function(e) {
        e.preventDefault();
        console.log('Add to cart clicked');
        
        const button = $(this);
        const productId = button.data('product-id');
        const productName = button.data('product-name');
        const originalHtml = button.html();
        
        console.log('Product details:', { id: productId, name: productName });
        
        // Show loading
        button.html('<i class="fa fa-spinner fa-spin"></i> Adding...');
        button.prop('disabled', true);
        
        // Simple AJAX request
        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Use Blade to output token directly
                product_id: productId,
                quantity: 1
            },
            success: function(response) {
                console.log('Success response:', response);
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    
                    // Update cart count
                    if (response.cart_count !== undefined) {
                        $('.cart-count, #cart-count').text(response.cart_count);
                        console.log('Cart count updated to:', response.cart_count);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error Details:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText,
                    error: error
                });
                
                let errorMessage = 'Failed to add product to cart. ';
                
                if (xhr.status === 500) {
                    // Server error - show more details
                    errorMessage += 'Server error occurred. ';
                    
                    // Try to parse the response for more details
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            errorMessage += 'Details: ' + response.message;
                        }
                    } catch (e) {
                        errorMessage += 'Please check the console for details.';
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error (500)',
                        text: errorMessage,
                        footer: '<a href="#" onclick="location.reload()">Click to refresh page</a>'
                    });
                } else if (xhr.status === 419) {
                    errorMessage = 'Session expired. Refreshing page...';
                    Swal.fire({
                        icon: 'warning',
                        title: 'Session Expired',
                        text: errorMessage,
                        showConfirmButton: false,
                        timer: 2000,
                        willClose: () => location.reload()
                    });
                } else {
                    errorMessage += 'Please try again.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error ' + xhr.status,
                        text: errorMessage
                    });
                }
            },
            complete: function() {
                button.html(originalHtml);
                button.prop('disabled', false);
            }
        });
    });
});
</script>

@endsection
