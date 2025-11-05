@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    <!-- Banner -->
    <div class="swiper bannerSwiper product-banner">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <a href="">
                    <img src="https://img.directindustry.com/images_di/bnr/15876/hd/55276.jpg" class="img-fluid" alt="" />
                </a>
            </div>
            <div class="swiper-slide">
                <a href="">
                    <img src="https://img.directindustry.com/images_di/bnr/68695/hd/54611.jpg" class="img-fluid" alt="" />
                </a>
            </div>
            <div class="swiper-slide">
                <a href="">
                    <img src="https://img.directindustry.com/images_di/bnr/23164/hd/55467.jpg" class="img-fluid" alt="" />
                </a>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Breadcrumbs -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs">
                    <div>
                        <a href="{{ route('homepage') }}" class="fw-bold">Home</a> &gt;
                        @if(optional($category)->parent_id)
                            <a href="{{ route('category', optional($category->parent)->slug) }}" class="txt-mcl active">
                                {{ optional($category->parent)->name }}
                            </a> &gt;
                        @endif
                        <span class="txt-mcl active fw-bold">{{ optional($category)->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" id="filterForm" action="{{ route('filtering.products', $category->slug) }}">
        <input type="hidden" name="search" id="searchInput" value="{{ request('search') }}">
        <input type="hidden" name="whats_new" id="whatsNewInput" value="{{ request('whats_new') }}">
        <input type="hidden" name="brand_id" id="brandInput" value="{{ request('brand_id') }}">
    </form>

    <!-- Main content -->
    <div class="container my-3">
        <div class="row mt-5 bg-white p-3 mx-4">
            <div class="col-lg-12 d-flex align-items-center justify-content-between">
                <div class="info-area d-flex align-items-center">
                    <h3>{{ optional($category)->name }}</h3>
                    <div class="ms-4">
                        <i class="fa-solid fa-circle-question"></i>
                        <span>Do you need help making a decision?</span>
                    </div>
                </div>
                <div class="counting-area pt-3">
                    <h6>
                        <span class="main-color">{{ $products->total() }}</span> products
                    </h6>
                </div>
            </div>
        </div>

        <div class="row mt-3 mx-3">
            <!-- Sidebar -->
            <div class="col-lg-2 col-sm-12">

                {{-- What's New --}}
                <div class="bg-white p-2 mb-2 mt-3 category-border-top">
                    <div class="checkbox-wrapper-15">
                        <input class="inp-cbx" id="cbx-whats-new" type="checkbox"
                               style="display: none"
                               onchange="
                               document.getElementById('whatsNewInput').value = this.checked ? 1 : '';
                               document.getElementById('filterForm').submit();
                               "
                               {{ request('whats_new') == '1' ? 'checked' : '' }} />
                        <label class="cbx" for="cbx-whats-new">
                            <span>
                                <svg width="12px" height="9px" viewBox="0 0 12 9">
                                    <polyline points="1 5 4 8 11 1"></polyline>
                                </svg>
                            </span>
                            <span>What's New</span>
                        </label>
                    </div>
                </div>

                {{-- Search --}}
                <div class="bg-white p-2 mb-2 category-border-top">
                    <div class="pt-3">
                        <input type="text" id="searchBox"
                               class="form-control shadow-sm rounded-0 p-0 m-0"
                               placeholder="Search" value="{{ request('search') }}">
                        <button type="button" class="btn btn-sm btn-primary mt-2 w-100"
                                onclick="
                                document.getElementById('searchInput').value = document.getElementById('searchBox').value;
                                document.getElementById('filterForm').submit();
                                ">Search</button>
                    </div>
                </div>

                {{-- Brands / Manufacturers --}}
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
                                    <div class="mt-3 scroll-menu-container" style="height: 150px; overflow: auto">
                                        <ul class="m-0 p-0">
                                            @foreach ($brands as $brand)
                                                <li class="p-2">
                                                    <div class="checkbox-wrapper-15">
                                                        <input class="inp-cbx" id="cbx-{{ $brand->id }}" type="checkbox"
                                                               style="display: none"
                                                               onchange="
                                                               document.getElementById('brandInput').value = this.checked ? '{{ $brand->id }}' : '';
                                                               document.getElementById('filterForm').submit();
                                                               "
                                                               {{ request('brand_id') == $brand->id ? 'checked' : '' }} />
                                                        <label class="cbx" for="cbx-{{ $brand->id }}">
                                                            <span>
                                                                <svg width="12px" height="9px" viewBox="0 0 12 9">
                                                                    <polyline points="1 5 4 8 11 1"></polyline>
                                                                </svg>
                                                            </span>
                                                            <span class="font-six">{{ $brand->title }}</span>
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

            <!-- Products Grid -->
            <div class="col-lg-10 col-sm-12">
                <div class="card rounded-0 border-0 mt-2 p-1">
                    <div class="card-header d-flex align-items-center bg-white border-0">
                        <div>
                            <img src="https://img.virtual-expo.com/media/ps/images/di/logos/GA-icon.svg" width="25px" height="25px" alt="" />
                        </div>
                        <h6 class="ms-2 pt-3">{{ $category->name }} | Choosing the right {{ $category->name }}</h6>
                    </div>
                </div>

                <div class="row my-3">
                    @forelse ($products as $product)
                        <div class="col-lg-3 col-sm-12 mb-5">
                            <div class="card border-0 card-news-trends" style="height: 400px">
                                <div class="content">
                                    <div class="front">
                                        <img class="profile" width="100%" height="200px" src="{{ $product->thumbnail }}" alt="{{ $product->name }}" />
                                        <div class="d-flex align-items-center justify-content-between px-3 py-2 mt-3">
                                            <div>
                                                <a href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => optional($product)->slug]) }}">
                                                    <h6 class="text-start mb-0">{{ Str::words($product->name, 7) }}</h6>
                                                </a>
                                            </div>
                                            <div>
                                                <a href="{{ route('brand.overview', optional($product->brand)->slug) }}">
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
                                               class="btn signin w-auto rounded-0">Details</a>
                                        </span>
                                        <br />
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
@endsection
