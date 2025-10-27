@extends('frontend.master')

@section('metadata')
@endsection

@section('content')

<!--Banner -->
<div class="shadow-none swiper bannerSwiper product-banner">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="https://img.directindustry.com/images_di/bnr/7315/hd/54528.jpg" class="img-fluid" alt="" />
        </div>
        <div class="swiper-slide">
            <img src="https://img.directindustry.com/images_di/bnr/35784/hd/55169.jpg" class="img-fluid" alt="" />
        </div>
        <div class="swiper-slide">
            <img src="https://img.directindustry.com/images_di/bnr/4959/hd/54488.jpg" class="img-fluid" alt="" />
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
                    @if (!empty($category) && $category->parent_id)
                        <a href="{{ route('category', optional($category->parent)->slug) }}"
                            class="txt-mcl active">{{ optional($category->parent)->name }}</a> &gt;
                    @endif
                    <span class="txt-mcl active fw-bold">{{ optional($category)->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="row">
        <!-- 🟩 Category List Section -->
        <div class="col-lg-8 col-sm-12">
            <h4 class="text-center border-bottom industry_title">
                {{ optional($category)->name }}
            </h4>

            <div class="hoverizeList mt-3">
                <ul class="category-grouplist category-list">
                    @forelse (($category->children ?? []) as $subcat)
                        <li>
                            <div class="imgSubCat {{ $loop->first ? '' : 'hidden' }}">
                                <img src="{{ !empty($subcat->image) && file_exists(public_path('storage/category/image/' . $subcat->image)) 
                                    ? asset('storage/category/image/' . $subcat->image) 
                                    : asset('frontend/images/no-brand-img.png') }}"
                                    alt="{{ $subcat->name }}" />
                            </div>

                            @if (!empty($subcat->children) && $subcat->children->isNotEmpty())
                                <a href="{{ route('category', $subcat->slug) }}">{{ $subcat->name }}</a>
                            @else
                                <a href="{{ route('filtering.products', $subcat->slug) }}">{{ $subcat->name }}</a>
                            @endif
                        </li>
                    @empty
                        <p class="text-center">No subcategories found.</p>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- 🟦 Products Section -->
        <div class="col-lg-4 col-sm-12">
            <div class="mb-3">
                <h4 class="text-center border-bottom industry_title">Products</h4>

                @php
                    $products = $category?->products ?? collect();
                @endphp

                @if ($products->count() > 0)
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="mb-2 col-lg-3">
                                <a href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => $product->slug]) }}">
                                    <img class="img-fluid w-100" src="{{ $product->thumbnail }}" alt="{{ $product->name }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center">No Products Found!</p>
                @endif
            </div>

            <!-- 🟨 Sidebar Newsletter Section -->
            <div class="text-center mt-4">
                @if (!empty($subcat?->image) && file_exists(public_path('storage/category/image/' . $subcat->image)))
                    <div class="d-flex justify-content-center mb-3">
                        <img class="img-fluid" src="{{ asset('storage/category/image/' . $subcat->image) }}" alt="">
                    </div>
                @endif

                <div class="p-5 text-white bg-black rounded">
                    <div>
                        <h3 class="main-color">Subscribe to our newsletter</h3>
                        <p class="mb-3">Receive updates on this section <br /> every two weeks.</p>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control rounded-0" placeholder="Enter your email"
                            aria-label="email" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="p-3 input-group-text rounded-0" id="basic-addon2">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <p class="mt-3">
                    <i>
                        Please refer to our <a href="#" class="main-color">Privacy Policy</a>
                        for details on how DirectIndustry processes your personal data.
                    </i>
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <span class="my-4 text-sm text-center sub-color w-100" style="font-size: 10px;">
            *Prices are pre-tax. They exclude delivery charges and customs duties and do not include
            additional charges for installation or activation options. Prices are indicative only and
            may vary by country, with changes to the cost of raw materials and exchange rates.
        </span>
    </div>
</div>
@endsection
