@extends('frontend.master')
@section('styles')
    <meta property="og:title" content="{{ ucfirst($brand->title) }} in TechFocus Ltd.">
    <meta property="og:image"
        content="{{ !empty($brand->brandPage->banner_image) && file_exists(public_path('storage/' . $brand->brandPage->banner_image)) ? url('storage/' . $brand->brandPage->banner_image) : asset('frontend/images/no-banner(1920-330).png') }}" />
    <meta name="twitter:image"
        content="{{ !empty($brand->brandPage->banner_image) && file_exists(public_path('storage/' . $brand->brandPage->banner_image)) ? url('storage/' . $brand->brandPage->banner_image) : asset('frontend/images/no-banner(1920-330).png') }}">
    <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "Article",
              "headline": "{{ ucfirst($brand->title) }} in TechFocus",
              "description": "TechFocus Ltd. is a System Integration, Software & Hardware based License Provider & Software development based company established in 2008.",
              "image": "{{ !empty($brand->brandPage->banner_image) && file_exists(public_path('storage/' . $brand->brandPage->banner_image)) ? url('social-image/' . $brand->brandPage->banner_image) : asset('frontend/images/no-banner(1920-330).png') }}",
              "author": {
                "@type": "Organization",
                "name": "{{ !empty($setting->site_name) ? $setting->site_name : 'TechFocus Ltd.' }}"
              },
              "publisher": {
                "@type": "Organization",
                "name": "{{ !empty($setting->site_name) ? $setting->site_name : 'TechFocus Ltd.' }}",
                "logo": {
                  "@type": "ImageObject",
                  "url": "{{ !empty($setting->favicon) ? asset('storage/' . $setting->favicon) : url('upload/no_image.jpg') }}"
                }
              },
              "datePublished": "{{ date('d-M-Y') }}"
            }
    </script>
@endsection
@section('content')
    <style>
        .container,
        .container-lg,
        .container-md,
        .container-sm,
        .container-xl,
        .container-xxl {
            max-width: 1320px;
        }
    </style>
    <style>
        @keyframes wave {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .wave-bg {
            animation: wave 2s infinite;
        }
    </style>
    <!--Banner -->

    @include('frontend.pages.brandPage.partials.page_header')
    <!-- content start -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 p-0">
                <div class="card rounded-0 border-0">
                    <div class="card-body p-0">
                        <div class="row px-5 pt-4">
                            <div class="col-lg-12">
                                <div class="devider-wrap">
                                    <h4 class="devider-content">
                                        <span class="devider-text bg-white">
                                            {{ $brand->brandPage->row_one_title }}
                                        </span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row px-5">
                            <div class="col-lg-12">
                                <p>
                                    {{ $brand->brandPage->row_one_header }}
                                </p>
                            </div>
                        </div>
                        {{-- @dd($brand->brandPage->rowFour) --}}
                        @if (!empty($brand->brandPage->rowFour->badge))
                            <div class="row px-5">
                                <div class="col-lg-12">
                                    <div class="devider-wrap">
                                        <h4 class="devider-content">
                                            <span class="devider-text bg-white">{{ $brand->brandPage->rowFour->badge }}</span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- Fist Row --}}
                        @if (!empty($brand->brandPage->rowFour))
                            <div class="row align-items-center px-5">
                                <div class="{{ !empty($brand->brandPage->rowFour->image) ? 'col-lg-6' : 'col-lg-12' }}">
                                    @if (!empty($brand->brandPage->rowFour->title))
                                        <h3 class="title ">
                                            {{ $brand->brandPage->rowFour->title }}
                                        </h3>
                                    @endif
                                    @if (!empty($brand->brandPage->rowFour->description))
                                        <p style="text-align: justify;">
                                            {!! $brand->brandPage->rowFour->description !!}
                                        </p>
                                    @endif
                                    @if (!empty($row_one->link))
                                        <a href="{{ $brand->brandPage->rowFour->link }}"
                                            class="btn common-btn-3 rounded-0 w-25 mt-2">{{ $brand->brandPage->rowFour->btn_name }}</a>
                                    @endif
                                </div>
                                @if (!empty($brand->brandPage->rowFour->image))
                                    <div class="col-lg-6">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <img class="img-fluid shadow-sm"
                                                src="{{ asset('storage/row/' . $brand->brandPage->rowFour->image) }}" alt="">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                        {{-- Second Row --}}
                        <div class="row my-5 align-items-center px-5">
                            @if (!empty(optional($brand->brandPage->rowFive)->image))
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img class="img-fluid shadow-sm"
                                            src="{{ asset('storage/row/' . optional($brand->brandPage->rowFive)->image) }}"
                                            alt="">
                                    </div>
                                </div>
                            @endif
                            <div class="{{ !empty(optional($brand->brandPage->rowFive)->image) ? 'col-lg-6' : 'col-lg-12' }}">
                                @if (!empty(optional($brand->brandPage->rowFive)->title))
                                    <h3 class="title">
                                        {{ optional($brand->brandPage->rowFive)->title }}
                                    </h3>
                                @endif
                                @if (!empty(optional($brand->brandPage->rowFive)->description))
                                    <p style="text-align: justify;">
                                        {!! optional($brand->brandPage->rowFive)->description !!}
                                    </p>
                                @endif
                                @if (!empty($row_one->link))
                                    <a href="{{ optional($brand->brandPage->rowFive)->link }}"
                                        class="btn common-btn-3 rounded-0 w-25 mt-2">{{ optional($brand->brandPage->rowFive)->btn_name }}</a>
                                @endif
                            </div>
                        </div>
                        @if (!empty(optional($brand->brandPage)->row_six_image))
                            <div class="row">
                                {{-- <div class="col-lg-12 wave-bg"> --}}
                                <div class="col-lg-12">
                                    <img class="img-fluid"
                                        src="{{ asset('storage/brand-page/row/' . optional($brand->brandPage)->row_six_image) }}"
                                        alt="">
                                </div>
                            </div>
                        @endif
                        {{-- Third Row --}}
                        <div class="row my-5 align-items-center px-5">
                            <div class="{{ !empty(optional($brand->brandPage->rowSeven)->image) ? 'col-lg-6' : 'col-lg-12' }}">
                                @if (!empty(optional($brand->brandPage->rowSeven)->title))
                                    <h3 class="title">
                                        {{ optional($brand->brandPage->rowSeven)->title }}
                                    </h3>
                                @endif
                                @if (!empty(optional($brand->brandPage->rowSeven)->description))
                                    <p style="text-align: justify;">
                                        {!! optional($brand->brandPage->rowSeven)->description !!}
                                    </p>
                                @endif
                                @if (!empty($row_one->link))
                                    <a href="{{ optional($brand->brandPage->rowSeven)->link }}"
                                        class="btn common-btn-3 rounded-0 w-25 mt-2">{{ optional($brand->brandPage->rowSeven)->btn_name }}</a>
                                @endif
                            </div>
                            @if (!empty($brand->brandPage->rowSeven->image))
                                <div class="col-lg-6">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img class="img-fluid shadow-sm"
                                            src="{{ asset('storage/row/' . $brand->brandPage->rowSeven->image) }}" alt="">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-lg-12 col-sm-12">
                <p class="sub-color text-center mx-auto pt-4 pb-2"> *Prices are pre-tax. They exclude delivery charges and
                    customs duties
                    and do not include additional charges for installation or activation options. Prices are indicative
                    only and may vary by country, with changes to the cost of raw materials and exchange rates. </p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
            var accordions = document.querySelectorAll('.accordion');

            accordions.forEach(function(accordion) {
                accordion.addEventListener('show.bs.collapse', function(event) {
                    var currentlyOpen = accordion.querySelector('.show');
                    if (currentlyOpen && currentlyOpen !== event.target) {
                        bootstrap.Collapse.getInstance(currentlyOpen).hide();
                    }
                });
            });
        });
</script> --}}
@endpush
