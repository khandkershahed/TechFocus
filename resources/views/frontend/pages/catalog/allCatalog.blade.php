@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
<!-- 🟦 Banner Section -->
<style>
    .catalog-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .catalog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .nav-pills .nav-link {
        transition: all 0.2s;
        width: 100%;
        text-align: start;
        padding: 15px 20px !important;
    }

    .nav-pills .nav-link.active {
        /* background-color: #0d6efd; */
        color: #fff;
        width: 100%;
        text-align: start;
        padding: 15px 20px;
    }

    .nav-pills .nav-link:hover {
        background-color: #0d6efd;
        color: #fff;
    }
</style>
<section class="mb-5 ban_sec section_one">
    <div class="px-0 container-fluid">
        <div class="ban_img position-relative">
            @if($banners->count() > 0)
            <div class="swiper bannerSwiper">
                <div class="swiper-wrapper">
                    @foreach($banners as $banner)
                    @if($banner->image)
                    <div class="swiper-slide">
                        <a href="{{ $banner->banner_link ?? '#' }}">
                            <img src="{{ asset('uploads/page_banners/' . $banner->image) }}"
                                class="shadow-sm img-fluid w-100 rounded-0"
                                alt="{{ $banner->title ?? 'Banner' }}"
                                style="height: 330px; object-fit: cover;"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-banner(1920-330).png') }}';">
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @else
            <img src="{{ asset('/img/TechFocus-Catalog-Page-Banner-(1920x525).png') }}" class="shadow-sm img-fluid w-100 " alt="No Banner" style="height: 330px; object-fit: cover;">
            @endif
        </div>
    </div>
</section>
<!-- 🟨 Catalogs Section -->
<div class="container my-5">
    <div class="row">

        <!-- Sidebar -->
        <div class="mb-4 bg-white col-lg-2">
            <h5 class="pt-3 mb-3 fw-bold">Catalogs by</h5>
            <ul class="gap-2 nav nav-pills flex-column" id="myTab" role="tablist">
                <li class="nav-item w-100">
                    <button class="nav-link active " id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button">All</button>
                </li>
                @foreach($catalogCategories as $key => $category)
                <li class="nav-item w-100">
                    <button class="py-2 nav-link " id="category-item-{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#category-item-{{ $key }}" type="button">
                        {{ ucfirst($category) }}
                    </button>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Content -->
        <div class="col-lg-10">
            <div class="tab-content" id="myTabContent">
                <!-- 🟩 All Catalogs Tab -->
                <div class="tab-pane fade show active" id="home">
                    <div class="row g-4">
                        @forelse($allCatalogs as $catalog)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="border-0 shadow-sm card catalog-card h-100 rounded-0"
                                style="cursor:pointer;"
                                data-pdf-url="{{ $catalog->document ? asset('storage/catalog/document/' . $catalog->document) : '' }}">

                                <img src="{{ $catalog->thumbnail ? asset('storage/catalog/thumbnail/' . $catalog->thumbnail) : asset('frontend/images/no-shop-imge.png') }}"
                                    class="mt-4 card-img-top rounded-top-3"
                                    alt="{{ $catalog->name }}"
                                    style="height:200px; object-fit:cover;"
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';">

                                <div class="text-center card-body d-flex flex-column justify-content-between">
                                    <p class="mb-2 fw-medium flex-grow-1">{{ $catalog->name }}</p>

                                    @php
                                    // Default logo
                                    $logoUrl = asset('frontend/images/no-shop-imge.png');
                                    $logoTitle = 'No Logo';
                                    $logoAlt = 'No Logo';

                                    switch($catalog->category) {
                                    case 'brand':
                                    if($catalog->brands->count() && $catalog->brands->first()->logo) {
                                    $logo = $catalog->brands->first();
                                    $logoUrl = asset('storage/brand/logo/' . $logo->logo);
                                    $logoTitle = $logo->title;
                                    $logoAlt = $logo->title;
                                    }
                                    break;
                                    case 'company':
                                    if($catalog->companies->count() && $catalog->companies->first()->logo) {
                                    $logo = $catalog->companies->first();
                                    $logoUrl = asset('storage/company/logo/' . $logo->logo);
                                    $logoTitle = $logo->name;
                                    $logoAlt = $logo->name;
                                    }
                                    break;
                                    case 'product':
                                    if($catalog->products->count()) {
                                    $product = $catalog->products->first();
                                    if($product->brand?->logo) {
                                    $logoUrl = asset('storage/brand/logo/' . $product->brand->logo);
                                    $logoTitle = $product->brand->title;
                                    $logoAlt = $product->brand->title;
                                    } else {
                                    $logoTitle = $product->name;
                                    $logoAlt = $product->name;
                                    }
                                    }
                                    break;
                                    case 'industry':
                                    if($catalog->industries->count() && $catalog->industries->first()->logo) {
                                    $industry = $catalog->industries->first();
                                    $logoUrl = asset('storage/industry/logo/' . $industry->logo);
                                    $logoTitle = $industry->name;
                                    $logoAlt = $industry->name;
                                    }
                                    break;
                                    }
                                    @endphp

                                    <div class="mb-2 text-center d-flex justify-content-center">
                                        @if($logoUrl != asset('frontend/images/no-shop-imge.png'))
                                        <img src="{{ $logoUrl }}"
                                            title="{{ $logoTitle }}"
                                            alt="{{ $logoAlt }}"
                                            class="mt-4 card-img-top rounded-top-3"
                                            style="max-height: 40px; max-width: 100px; object-fit: contain;"
                                            onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';">
                                        @else
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="height: 40px; max-width: 100px; margin: 0 auto;">
                                            <span class="small text-muted">{{ $logoTitle }}</span>
                                        </div>
                                        @endif
                                        <!-- <p class="mt-2 mb-0 small">{{ $catalog->page_number ?? 0 }} Pages</p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center alert alert-info">No catalogs found.</div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- 🟪 Category-wise Catalogs -->
                @foreach($catalogCategories as $key => $category)
                <div class="tab-pane fade" id="category-item-{{ $key }}">
                    <div class="row g-4">
                        @if(isset($catalogsByCategory[$category]) && $catalogsByCategory[$category]->count() > 0)
                        @foreach($catalogsByCategory[$category] as $catalog)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="border-0 shadow-sm card catalog-card h-100 "
                                style="cursor:pointer;"
                                data-pdf-url="{{ $catalog->document ? asset('storage/catalog/document/' . $catalog->document) : '' }}">

                                <img src="{{ $catalog->thumbnail ? asset('storage/catalog/thumbnail/' . $catalog->thumbnail) : asset('frontend/images/no-shop-imge.png') }}"

                                    class="mt-4 card-img-top rounded-top-3"
                                    alt="{{ $catalog->name }}"
                                    style="height:200px; object-fit:cover;"
                                    loading="lazy"
                                    onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';">

                                <div class="text-center card-body d-flex flex-column justify-content-between">
                                    <p class="mb-2 fw-medium flex-grow-1">{{ $catalog->name }}</p>

                                    @php
                                    $logoUrl = asset('frontend/images/no-shop-imge.png');
                                    $logoTitle = 'No Logo';
                                    $logoAlt = 'No Logo';

                                    switch($catalog->category) {
                                    case 'brand':
                                    if($catalog->brands->count() && $catalog->brands->first()->logo) {
                                    $logo = $catalog->brands->first();
                                    $logoUrl = asset('storage/brand/logo/' . $logo->logo);
                                    $logoTitle = $logo->title;
                                    $logoAlt = $logo->title;
                                    }
                                    break;
                                    case 'company':
                                    if($catalog->companies->count() && $catalog->companies->first()->logo) {
                                    $logo = $catalog->companies->first();
                                    $logoUrl = asset('storage/company/logo/' . $logo->logo);
                                    $logoTitle = $logo->name;
                                    $logoAlt = $logo->name;
                                    }
                                    break;
                                    case 'product':
                                    if($catalog->products->count()) {
                                    $product = $catalog->products->first();
                                    if($product->brand?->logo) {
                                    $logoUrl = asset('storage/brand/logo/' . $product->brand->logo);
                                    $logoTitle = $product->brand->title;
                                    $logoAlt = $product->brand->title;
                                    } else {
                                    $logoTitle = $product->name;
                                    $logoAlt = $product->name;
                                    }
                                    }
                                    break;
                                    case 'industry':
                                    if($catalog->industries->count() && $catalog->industries->first()->logo) {
                                    $industry = $catalog->industries->first();
                                    $logoUrl = asset('storage/industry/logo/' . $industry->logo);
                                    $logoTitle = $industry->name;
                                    $logoAlt = $industry->name;
                                    }
                                    break;
                                    }
                                    @endphp

                                    <div class="mb-2 text-center d-flex justify-content-center">
                                        @if($logoUrl != asset('frontend/images/no-shop-imge.png'))
                                        <img src="{{ $logoUrl }}"
                                            title="{{ $logoTitle }}"
                                            alt="{{ $logoAlt }}"
                                            style="max-height: 40px; max-width: 100px; object-fit: contain;"
                                            onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';">
                                        @else
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="height: 40px; max-width: 100px; margin: 0 auto;">
                                            <span class="small text-muted">{{ $logoTitle }}</span>
                                        </div>
                                        @endif
                                        <!-- <p class="mt-2 mb-0 small">{{ $catalog->page_number ?? 0 }} Pages</p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="col-12">
                            <div class="text-center alert alert-info">No catalogs found in {{ ucfirst($category) }} category.</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach

            </div>
        </div>

    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.catalog-card').forEach(card => {
            card.addEventListener('click', function() {
                const pdfUrl = this.dataset.pdfUrl;
                if (pdfUrl) {
                    window.open(pdfUrl, '_blank');
                } else {
                    alert('PDF not available for this catalog.');
                }
            });
        });
    });
</script>
@endpush