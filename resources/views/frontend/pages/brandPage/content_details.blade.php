@extends('frontend.master')

@section('metadata')
    {{-- Add metadata here if needed --}}
@endsection

@section('content')
    {{-- Brand Page Header --}}
    {{-- <section>
        <div class="brand-page-banner page_top_banner">
            <img src="{{ !empty(optional($brand->brandPage)->banner_image) && file_exists(public_path('storage/brand-page/banner-image/' . optional($brand->brandPage)->banner_image)) ? asset('storage/brand-page/banner-image/' . optional($brand->brandPage)->banner_image) : asset('frontend/images/no-banner(1920-330).png') }}"
                alt="">
        </div>
    </section> --}}

    {{-- Banner Section --}}

    <section>
        <div class="brand-page-banner page_top_banner">
            <img src="{{ !empty($newsTrend->banner_image) && file_exists(public_path('storage/content/' . $newsTrend->banner_image))
                ? asset('storage/content/' . $newsTrend->banner_image)
                : asset('frontend/images/no-banner(1920-330).png') }}"
                alt="{{ $newsTrend->title ?? 'Banner' }}">
        </div>
    </section>

{{-- =========================
    Main Content
========================== --}}
<div class="container mt-5">
    <div class="row my-3">

            {{-- Left Column: Trend Details --}}
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-lg-5 p-4">

                        @if (isset($newsTrend) && $newsTrend->badge)
                            <h2 class="subtitles fw-bold">{{ $newsTrend->badge }}</h2>
                        @endif

                        @if (isset($newsTrend) && $newsTrend->title)
                            <h3 class="titles main-color py-2">{{ $newsTrend->title }}</h3>
                        @endif

                        @if (isset($newsTrend) && $newsTrend->header)
                            <h5>{{ $newsTrend->header }}</h5>
                        @endif

                        @if (isset($newsTrend) && $newsTrend->short_des)
                            <h6 style="border-left: 3px solid #001430; padding-left:10px">
                                {!! $newsTrend->short_des !!}
                            </h6>
                        @endif

                        @if (isset($newsTrend) && $newsTrend->long_des)
                            <p class="text-justify" style="line-height: 1.5;">
                                {!! $newsTrend->long_des !!}
                            </p>
                        @endif
                    @else
                        <p>No details available for this content.</p>
                    @endif
                </div>
            </div>
        </div>

            {{-- Right Column: Brand Info --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header rounded-0 bg-white" style="border-top:5px solid #001430; border-bottom: 0;">
                        <div class="d-flex justify-content-center">
                            <img class="rounded-circle"
                                src="{{ isset($newsTrend) && $newsTrend->source_image && file_exists(public_path('storage/content/' . $newsTrend->source_image))
                                    ? asset('storage/content/' . $newsTrend->source_image)
                                    : asset('backend/images/no-image-available.png') }}"
                                width="200" height="200" alt="{{ $newsTrend->title }}" />
                        </div>

                        <div class="text-center mt-4">
                            @if (!empty($newsTrend->author))
                                <h3 class="fw-bolder">Details</h3>
                                <h6>
                                    <i class="fa-solid fa-user main-color"></i> {{ $newsTrend->author }}
                                </h6>
                            @endif

                            @if (isset($newsTrend) && $newsTrend->address)
                                <a href="{{ $newsTrend->source_link ?? '#' }}"
                                    class="border p-2 rounded-pill shadow-2 mt-2 d-inline-block">
                                    <i class="fa-solid fa-location-dot main-color"></i>
                                    {{ $newsTrend->address }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Note --}}
        @if (isset($newsTrend) && $newsTrend->footer)
            <div class="row mx-lg-5 mx-3 mt-2 mb-5">
                <div class="col-12" style="border-top: 3px dashed #001430; border-bottom: 3px dashed #001430;">
                    <p class="sub-color fw-semibold text-center mb-0 py-3">
                        {!! $newsTrend->footer !!}
                    </p>
                </div>
            </div>
        @endif

    </div>
@endsection
