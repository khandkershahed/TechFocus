@extends('frontend.master')
@section('metadata')
@endsection
@section('content')

<!-- Banner -->
<div class="swiper bannerSwiper product-banner">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <a href="#">
                <img src="https://img.directindustry.com/images_di/bnr/15876/hd/55276.jpg" class="img-fluid" alt="">
            </a>
        </div>
        <div class="swiper-slide">
            <a href="#">
                <img src="https://img.directindustry.com/images_di/bnr/68695/hd/54611.jpg" class="img-fluid" alt="">
            </a>
        </div>
        <div class="swiper-slide">
            <a href="#">
                <img src="https://img.directindustry.com/images_di/bnr/23164/hd/55467.jpg" class="img-fluid" alt="">
            </a>
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div>

<!-- Content Start -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumbs">
                <div>
                    <a href="{{ route('homepage') }}" class="fw-bold">Home</a> &gt;
                    @if (optional($category)->parent_id)
                        <a href="{{ route('category', optional($category->parent)->slug) }}"
                            class="txt-mcl active">{{ optional($category->parent)->name }}</a> &gt;
                    @endif
                    <span class="txt-mcl active fw-bold">{{ optional($category)->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-3">
    <form method="GET" id="filterForm" action="{{ route('filtering.products', $category->slug) }}">
        <div class="row bg-white p-3 mx-4">
            <div class="col-lg-12 d-flex align-items-center justify-content-between">
                <div class="info-area d-flex align-items-center">
                    <h3 class="mb-0">{{ $category->name }}</h3>
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

        <!-- Filters -->
        <div class="row mt-3 mx-3">
            <div class="col-lg-2 col-sm-12">
                <!-- What's New -->
                <div class="bg-white p-2 mb-2 mt-3 category-border-top">
                    <div class="checkbox-wrapper-21">
                        <label class="control control--checkbox">
                            What's New
                            <input type="checkbox" name="whats_new" value="1"
                                onchange="document.getElementById('filterForm').submit()"
                                {{ request('whats_new') == '1' ? 'checked' : '' }}>
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                </div>

                <!-- Manufacturers -->
                <div class="bg-white p-2 mb-2 mt-3 category-border-top">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed p-1 border-0" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseManufacturers"
                                    aria-expanded="false"
                                    aria-controls="flush-collapseManufacturers">
                                    Manufacturers
                                </button>
                            </h2>
                            <div id="flush-collapseManufacturers"
                                class="accordion-collapse collapse border-0"
                                aria-labelledby="flush-headingOne"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body p-0 m-0">
                                    <!-- Search inside brands -->
                                    <div class="pt-3">
                                        <input id="autocomplete_company" type="text"
                                            class="form-control shadow-sm rounded-0 p-0 m-0"
                                            placeholder="Search brand...">
                                    </div>

                                    <div class="mt-3 scroll-menu-container"
                                        style="height: 150px; overflow: auto">
                                        <ul class="m-0 p-0" id="brandList">
                                            @foreach ($brands as $brand)
                                                <li class="p-2 brand-item">
                                                    <label class="cbx" style="cursor: pointer;">
                                                        <input type="radio" name="brand_id"
                                                            value="{{ $brand->id }}"
                                                            onchange="document.getElementById('filterForm').submit()"
                                                            {{ request('brand_id') == $brand->id ? 'checked' : '' }}>
                                                        <span class="font-six">{{ $brand->title }}</span>
                                                    </label>
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

            <!-- Product Section -->
            <div class="col-lg-10 col-sm-12">
                {{-- <!-- Search Bar -->
                <div class="d-flex justify-content-end mb-3">
                    <input type="text" name="search" class="form-control w-50 rounded-0 shadow-sm"
                        placeholder="Search product..." value="{{ request('search') }}">
                    <button type="submit" class="btn signin rounded-0">Search</button>
                </div> --}}

                <!-- Product Cards -->
                <div class="row my-3">
                    @forelse ($products as $product)
                        <div class="col-lg-3 col-sm-12 mb-5">
                            <div class="card border-0 card-news-trends" style="height: 400px">
                                <div class="content">
                                    <div class="front">
                                        <img class="profile" width="100%" height="200px"
                                            src="{{ $product->thumbnail }}" alt="{{ $product->name }}">
                                        <div class="d-flex align-items-center justify-content-between px-3 py-2 mt-3">
                                            <div>
                                                <a href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => $product->slug]) }}">
                                                    <h6 class="text-start mb-0">
                                                        {{ Str::words($product->name, 7) }}
                                                    </h6>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="{{ route('brand.overview', optional($product->brand)->slug) }}">
                                                    <img class="lazyLoaded logo right" style="width: 150px;"
                                                        src="{{ asset('storage/brand/logo/' . optional($product->brand)->logo) }}"
                                                        title="{{ optional($product->brand)->title }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="back from-bottom text-start">
                                        <a href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => $product->slug]) }}"
                                            class="btn signin w-auto rounded-0">Details</a>
                                        <p class="pt-3 m-0 font-five">{{ $product->name }}</p>
                                        <p class="p-1 text-justify mb-0">{!! Str::words($product->short_desc, 10) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>No products found for this filter.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
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
    </form>
</div>

<!-- Brand Filter Search Script -->
<script>
    document.getElementById('autocomplete_company').addEventListener('keyup', function () {
        let search = this.value.toLowerCase();
        document.querySelectorAll('#brandList .brand-item').forEach(function (item) {
            let text = item.textContent.toLowerCase();
            item.style.display = text.includes(search) ? '' : 'none';
        });
    });
</script>

@endsection
