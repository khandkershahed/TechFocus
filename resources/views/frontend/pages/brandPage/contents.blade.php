@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    @include('frontend.pages.brandPage.partials.page_header')

    <div class="container">
        <div class="row align-items-center">
            <div class="container px-4">
                <div class="row gx-5">
                    <div class="col-lg-12">
                        <div class="devider-wrap">
                            <h4 class="devider-content mb-4">
                                <span class="devider-text">PRODUCT TRENDS</span>
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- News & Trends Content -->
                <div class="row">
                    @forelse($trends as $trend)
                        <div class="col-lg-3 mb-4">
                            <div class="card border-0 card-news-trends trends-card">
                                <a href="{{ route('content.details', $trend->slug) }}">
                                    <div class="content">
                                        <div class="front">
                                            <img class="img-fluid trend-img" width="100%"
                                                src="{{ $trend->thumbnail_image ? asset('storage/' . $trend->thumbnail_image) : 'https://img.directindustry.com/images_di/projects/images-om/156230-18911074.jpg' }}"
                                                alt="{{ $trend->title }}" />
                                            <div class="d-flex align-items-center justify-content-between p-2">
                                                <h2 class="text-center font-four mb-0">{{ \Illuminate\Support\Str::limit($trend->title, 30) }}</h2>
                                                <a href="#">
                                                    @if($brand && $brand->logo)
                                                        <img class="lazyLoaded logo right"
                                                            src="{{ asset('storage/' . $brand->logo) }}"
                                                            title="{{ $brand->title }}"
                                                            style="max-height: 40px; max-width: 80px; object-fit: contain;" />
                                                    @else
                                                        <img class="lazyLoaded logo right"
                                                            src="https://img.directindustry.com/images_di/logo-pp/L62761.gif"
                                                            title="Brand Logo"
                                                            style="max-height: 40px; max-width: 80px; object-fit: contain;" />
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                        <div class="back from-bottom text-start">
                                            <span class="font-three pt-3 text-muted">
                                                Posted on {{ $trend->created_at->format('m/d/Y') }}
                                            </span>
                                            <br />
                                            <p class="pt-3 pb-2 m-0 font-three">
                                                {{ \Illuminate\Support\Str::limit($trend->header, 50) }}
                                            </p>
                                            <p class="font-three pt-2 pb-3 text-justify">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($trend->short_des), 150) }}
                                            </p>
                                            <p class="pt-3 pb-2 m-0 text-center" style="border-top: 1px solid #eee">
                                                <a href="{{ route('content.details', $trend->slug) }}">
                                                    <span class="news-link">
                                                        <i class="fa fa-plus-circle me-2"></i>More information
                                                    </span>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-12">
                            <div class="alert alert-info text-center">
                                <h4>No trends found for this brand.</h4>
                                <p>Check back later for updates.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($trends->hasPages())
                    <div class="container my-5 pt-5">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-center">
                                    {{ $trends->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Localization Map Section -->
    <div class="container">
        <div class="row gx-5">
            <div class="col-lg-12">
                <div class="devider-wrap">
                    <h4 class="devider-content mb-4">
                        <span class="devider-text">LOCALIZATION MAP</span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="map-container">
                    <img src="http://res.cloudinary.com/slzr/image/upload/v1500321012/world-map-1500_vvekl5.png" />
                    <div class="point venezuela tippy" title="Venezuela"></div>
                    <div class="point brasil tippy" title="Brasil"></div>
                    <div class="point argentina tippy" title="Argentina"></div>
                    <div class="point colombia tippy" title="Colombia"></div>
                    <div class="point panama tippy" title="Panamá"></div>
                    <div class="point mexico tippy" title="Mexico"></div>
                    <div class="point usa tippy" title="Estados Unidos"></div>
                    <div class="point arabia tippy" title="Arabia Saudi"></div>
                    <div class="point turquia tippy" title="Turquía"></div>
                    <div class="point rusia tippy" title="Rusia"></div>
                    <div class="point china tippy" title="China"></div>
                    <div class="point japon tippy" title="Japon"></div>
                    <div class="point australia tippy" title="Australia"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
