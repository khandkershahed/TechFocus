@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    <!--Banner -->
    <div class="swiper bannerSwiper product-banner">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="https://img.directindustry.com/images_di/bnr/7315/hd/54528.jpg" class="img-fluid" alt="" />
            </div>
            <div class="swiper-slide">
                <img src="https://img.directindustry.com/images_di/bnr/35784/hd/55169.jpg" class="img-fluid" alt="" />
            </div>
            <div class="swiper-slide">
                <img src="https://img.directindustry.com/images_di/bnr/4959/hd/54488.jpg" class="img-fluid"
                    alt="" />
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
    <div class="container mb-5">
        <h3 class="text-center border-bottom industry_title">
            {{ optional($category)->name }}
        </h3>
        <div class="p-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-sm-12">
                        <div class="hoverizeList">
                            <ul class="category-grouplist category-list">
                                @foreach (optional($category)->children as $subcat)
                                    <li>
                                        <div class="imgSubCat {{ $loop->first ?? 'hidden' }}">
                                            <img src="{{ !empty($subcat->image) && file_exists(public_path('storage/category/image/' . $subcat->image)) ? asset('storage/category/image/' . $subcat->image) : asset('frontend/images/no-brand-img.png') }}"
                                                alt="{{ $subcat->name }}" />
                                        </div>
                                        <a href="{{ route('category', optional($subcat)->slug) }}">
                                            {{ $subcat->name }}
                                        </a>
                                        {{-- <a href="{{ route('filtering.products', 'laptop-computers') }}">
                                            {{ $subcat->name }}
                                        </a> --}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-12">
                        <div class="row mb-3">
                            <h5>Products</h5>
                            <hr class="pb-0 mb-0">
                            @foreach (optional($category)->products() as $product)
                                <div class="col-lg-4 mb-2">
                                    <a
                                        href="{{ route('product.details', ['id' => optional($product->brand)->id, 'slug' => optional($product)->slug]) }}">
                                        <img class="img-fluid w-100" src="{{ asset('storage/' . $product->thumbnail) }}"
                                            alt="{{ $product->name }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center">
                            @if (!empty($subcat->image) && file_exists(public_path('storage/category/image/' . $subcat->image)))
                                <div class="d-flex justify-content-center">
                                    <img class="img-fluid" src="{{ asset('storage/category/image/' . $subcat->image) }}"
                                        alt="">
                                </div>
                            @endif
                            <div class="bg-black m-5 px-5 py-5 text-white">
                                <div>
                                    <h3 class="main-color">Subscribe to our newsletter</h3>
                                    <p class="mb-2">Receive updates on this section every two weeks.</p>
                                </div>
                                <div class="input-group ">
                                    <input type="text" class="form-control rounded-0" placeholder="Recipient's username"
                                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="input-group-text rounded-0 p-3" id="basic-addon2"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </div>
                            </div>
                            <p>
                                <i class="font-two">Please refer to our
                                    <a href="#" class="main-color">Privacy
                                        Policy</a> for details on how DirectIndustry processes your personal data.
                                </i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row p-3">
                <div class="col-lg-12 col-sm-12">
                    <p class="sub-color text-center w-75 mx-auto">
                        *Prices are pre-tax. They exclude delivery charges and customs
                        duties and do not include additional charges for installation or
                        activation options. Prices are indicative only and may vary by
                        country, with changes to the cost of raw materials and exchange
                        rates.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
