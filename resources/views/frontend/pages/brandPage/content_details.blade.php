@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    <style>
        .sticky-header {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            z-index: 1020;
            transition: all 0.3s;
        }

        main {
            margin-top: 6rem;
        }
    </style>

    <section>
        <div class="brand-page-banner page_top_banner">
            <img src="{{ !empty(optional($content)->banner_image) && file_exists(public_path('storage/content/' . optional($content)->banner_image)) ? asset('storage/content/' . optional($content)->banner_image) : asset('frontend/images/no-banner(1920-330).png') }}"
                alt="">
        </div>
    </section>

    <!-- content start -->
    <div class="container mt-5">
        <div class="row my-3">
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-lg-5 p-4">
                        <h2 class="subtitles fw-bold">
                            {{ optional($content)->badge }}
                        </h2>
                        <h3 class="titles main-color py-2">
                            {{ optional($content)->title }}
                        </h3>
                        @if (!empty(optional($content)->header))
                            <h5>
                                {{ optional($content)->header }}
                            </h5>
                        @endif
                        @if (!empty(optional($content)->short_des))
                            <h6 style="border-left: 3px solid #001430; padding-left:10px">
                                {!! optional($content)->short_des !!}
                            </h6>
                        @endif
                        <p class="text-justify" style="line-height: 1.2;">
                            {!! optional($content)->long_des !!}
                        </p>
                    </div>
                </div>
                {{-- <div class="d-flex justify-content-end me-5"
                    style="margin-bottom: -38px;z-index: 99;top: 10px;position: relative;">
                    <a href="javascript:vopid(0)" class="btn btn-outline-warning rounded-circle">
                        <i class="fa-solid fa-heart"></i>
                    </a>
                </div> --}}
                
            </div>
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm">
                    
                    <div class="card-header rounded-0 bg-white"
                        style="border-top:5px solid #001430; border-bottom: 0;">
                        <div class="d-flex justify-content-center">
                            <img class="rounded-circle"
                                src="{{ !empty(optional($content)->source_image) && file_exists(public_path('storage/content/' . optional($content)->source_image)) ? asset('storage/content/' . optional($content)->source_image) : asset('backend/images/no-image-available.png') }}"
                                width="200px" height="200px" alt="" />
                        </div>
                        <div>
                            <h3 class="text-center fw-bolder mt-4">Details</h3>
                            <h6 class="text-center">
                                <i class="fa-solid fa-user main-color"></i> 
                                {{ optional($content)->author }}
                            </h6>
                            <!-- Button trigger modal -->
                            <div class="text-center">
                                <a href="{{ optional($content)->source_link }}" class="border p-2 rounded-pill shadow-2" >
                                    <i class="fa-solid fa-location-dot main-color"></i>
                                    {{ optional($content)->address }}
                                </a>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content rounded-0">
                                        <div class="modal-header border-0">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.309132710686!2d90.35736377420783!3d23.77200378794874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c0a1a0a40001%3A0xbfdf3a0773c3ba03!2sMonico%20Technologies%20LTD!5e0!3m2!1sen!2sbd!4v1695017677535!5m2!1sen!2sbd"
                                                width="800" height="350" style="border:0;" allowfullscreen=""
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-lg-5 p-4">

                    </div>
                </div>
            </div>
        </div>
        @if (!empty(optional($content)->footer))
            <div class="row mx-lg-5 mx-3 mt-2 mb-5">
                <div class="col-12"
                    style="border-top: 3px dashed #001430;border-bottom: 3px dashed #001430; border-width: 20%">
                    <p class="sub-color fw-semibold text-center mb-0 py-3">
                        {{ optional($content)->footer }}
                    </p>
                </div>
            </div>
        @endif
    </div>
@endsection
