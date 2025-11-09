@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
<style>
    .nav-tabs .nav-link {
        margin-bottom: -3px;
        width: 100%;
        border-left: 3px solid transparent;
        background: none;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .nav-tabs .nav-links.active {
        background-color: var(--primary-color);
        width: 100%;
        color: var(--white);
        border-left: 3px solid var(--secondary-color);
        border-top: 0px;
        border-bottom: 0px;
    }

    .nav-links {
        color: black;
    }

    .container,
    .container-lg,
    .container-md,
    .container-sm,
    .container-xl,
    .container-xxl {
        max-width: 1450px;
    }
</style>

@if(!empty($aboutPage))
<!-- Section One: Banner -->
<section class="ban_sec section_one">
    <div class="p-0 container-fluid">
        <div class="ban_img">
            <img src="{{ asset('img/About-Us-Page-Image_Tech-Focus.png') }}" alt="banner">
        </div>
    </div>
</section>

<!-- Section Two: About Content -->
<section class="section_two">
    <div class="container custom-spacer">
        <div class="row">
            <div class="col-lg-6">
                <div>
                    @if($aboutPage->section_two_badge)
                    <h6 class="main-color">{{ $aboutPage->section_two_badge }}</h6>
                    @endif
                    
                    <div class="mt-lg-2">
                        <h1 class="fw-bold">
                            {{ $aboutPage->section_two_title_1 ?? '' }}
                            <span class="main-color">{{ $aboutPage->section_two_title_span ?? '' }}</span>
                        </h1>
                        
                        @if($aboutPage->section_two_subtitle)
                        <h3>{{ $aboutPage->section_two_subtitle }}</h3>
                        @endif
                        
                        @if($aboutPage->section_two_description)
                        <p>{{ $aboutPage->section_two_description }}</p>
                        @endif
                    </div>
                    
                    @if($aboutPage->section_two_button_name && $aboutPage->section_two_button_link)
                    <div class="mt-lg-5">
                        <a href="{{ $aboutPage->section_two_button_link }}" 
                           class="btn common-btn-3 rounded-0 w-25">
                            {{ $aboutPage->section_two_button_name }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="d-flex justify-content-center">
                    <img class="img-fluid" width="470" height="541"
                        src="{{ !empty($aboutPage->section_two_main_image) && file_exists(public_path('app/public/about-us/' . $aboutPage->section_two_main_image)) ? asset('app/public/about-us/' . $aboutPage->section_two_main_image) : 'https://img.freepik.com/free-photo/about-as-service-contact-information-concept_53876-138509.jpg?semt=ais_hybrid&w=740' }}"
                        alt="Main Image"
                        onerror="this.onerror=null;this.src='https://img.freepik.com/free-photo/about-as-service-contact-information-concept_53876-138509.jpg?semt=ais_hybrid&w=740';" />
                </div>
                
                @if($aboutPage->section_two_secondary_image)
                <div class="showcase">
                    <img src="{{ !empty($aboutPage->section_two_secondary_image) && file_exists(public_path('app/public/about-us/' . $aboutPage->section_two_secondary_image)) ? asset('app/public/about-us/' . $aboutPage->section_two_secondary_image) : 'https://img.freepik.com/free-photo/about-as-service-contact-information-concept_53876-138509.jpg?semt=ais_hybrid&w=740' }}"
                        alt="Secondary Image"
                        onerror="this.onerror=null;this.src='https://img.freepik.com/free-photo/about-as-service-contact-information-concept_53876-138509.jpg?semt=ais_hybrid&w=740';" />
                    
                    @if($aboutPage->section_two_secondary_image_count)
                    <div class="overlay">
                        <h2 class="mb-1">{{ $aboutPage->section_two_secondary_image_count }}</h2>
                        @if($aboutPage->section_two_secondary_image_title)
                        <p>{{ $aboutPage->section_two_secondary_image_title }}</p>
                        @endif
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Section Three: Tabs -->
@if($aboutPage->section_three_tab_one_title || $aboutPage->section_three_tab_two_title || $aboutPage->section_three_tab_three_title || $aboutPage->section_three_tab_four_title)
<section class="section_three">
    <div class="container">
        <ul class="nav nav-tabs row" id="myTab" role="tablist">
            @if($aboutPage->section_three_tab_one_title)
            <li class="p-3 px-0 nav-item col-lg-3" role="presentation">
                <button class="p-4 shadow-sm nav-link nav-links active" id="home-tab" data-bs-toggle="tab"
                    style="height: 200px" data-bs-target="#home" type="button" role="tab" aria-controls="home"
                    aria-selected="true">
                    <div class="text-start">
                        <div>
                            <h6>{{ $aboutPage->section_three_tab_one_title }}</h6>
                            @if($aboutPage->section_three_tab_one_short_description)
                            <p>{{ $aboutPage->section_three_tab_one_short_description }}</p>
                            @endif
                        </div>
                    </div>
                </button>
            </li>
            @endif
            
            @if($aboutPage->section_three_tab_two_title)
            <li class="p-3 nav-item col-lg-3" role="presentation">
                <button class="p-4 shadow-sm nav-link nav-links" id="profile-tab" data-bs-toggle="tab"
                    style="height: 200px" data-bs-target="#profile" type="button" role="tab"
                    aria-controls="profile" aria-selected="false">
                    <div class="text-start">
                        <div>
                            <h6>{{ $aboutPage->section_three_tab_two_title }}</h6>
                            @if($aboutPage->section_three_tab_two_short_description)
                            <p>{{ $aboutPage->section_three_tab_two_short_description }}</p>
                            @endif
                        </div>
                    </div>
                </button>
            </li>
            @endif
            
            @if($aboutPage->section_three_tab_three_title)
            <li class="p-3 ps-0 nav-item col-lg-3" role="presentation">
                <button class="p-4 shadow-sm nav-link nav-links" id="contact-tab" data-bs-toggle="tab"
                    style="height: 200px" data-bs-target="#contact" type="button" role="tab"
                    aria-controls="contact" aria-selected="false">
                    <div class="text-start">
                        <div>
                            <h6>{{ $aboutPage->section_three_tab_three_title }}</h6>
                            @if($aboutPage->section_three_tab_three_short_description)
                            <p>{{ $aboutPage->section_three_tab_three_short_description }}</p>
                            @endif
                        </div>
                    </div>
                </button>
            </li>
            @endif
            
            @if($aboutPage->section_three_tab_four_title)
            <li class="p-3 ps-0 nav-item col-lg-3 pe-0" role="presentation">
                <button class="p-4 shadow-sm nav-link nav-links" id="contact-tabs" data-bs-toggle="tab"
                    style="height: 200px" data-bs-target="#contacts" type="button" role="tab"
                    aria-controls="contacts" aria-selected="false">
                    <div class="text-start">
                        <div>
                            <h6>{{ $aboutPage->section_three_tab_four_title }}</h6>
                            @if($aboutPage->section_three_tab_four_short_description)
                            <p>{{ $aboutPage->section_three_tab_four_short_description }}</p>
                            @endif
                        </div>
                    </div>
                </button>
            </li>
            @endif
        </ul>
        
        <div class="tab-content" id="myTabContent">
            <!-- Tab One Content -->
            @if($aboutPage->section_three_tab_one_title)
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="p-5 bg-white row align-items-center">
                    <div class="col-lg-7">
                        <h2>{{ $aboutPage->section_three_tab_one_title }}</h2>
                        @if($aboutPage->section_three_tab_one_detailed_description)
                        <p>{{ $aboutPage->section_three_tab_one_detailed_description }}</p>
                        @endif
                        
                        @if($aboutPage->section_three_tab_one_button_name)
                        <div class="pt-4">
                            <a href="{{ $aboutPage->section_three_tab_one_button_link ?? route('contact') }}" class="text-btn main-color">
                                {{ $aboutPage->section_three_tab_one_button_name }}
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Right Column Content -->
                    <div class="col-lg-5">
                        @if($aboutPage->section_three_tab_one_quote)
                        <div style="border-top: 1px solid black; border-bottom: 1px solid black">
                            <div class="p-5">
                                <h4>{{ $aboutPage->section_three_tab_one_quote }}</h4>
                                @if($aboutPage->section_three_tab_one_quote_author)
                                <p><span class="fw-bold">{{ $aboutPage->section_three_tab_one_quote_author }}</span></p>
                                @endif
                            </div>
                        </div>
                        @elseif($aboutPage->section_three_tab_one_list_title)
                        <div class="ms-5">
                            <h4>{{ $aboutPage->section_three_tab_one_list_title }}</h4>
                            <ul class="ps-2 ms-0">
                                @foreach([1,2,3,4] as $i)
                                    @php $listItem = "section_three_tab_one_list_$i"; @endphp
                                    @if($aboutPage->$listItem)
                                    <li class="pt-3">{{ $aboutPage->$listItem }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Repeat similar structure for other tabs (tab two, three, four) -->
            <!-- Tab Two Content -->
            @if($aboutPage->section_three_tab_two_title)
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="p-5 bg-white row align-items-center">
                    <div class="col-lg-7">
                        <h2>{{ $aboutPage->section_three_tab_two_title }}</h2>
                        @if($aboutPage->section_three_tab_two_detailed_description)
                        <p>{{ $aboutPage->section_three_tab_two_detailed_description }}</p>
                        @endif
                        
                        @if($aboutPage->section_three_tab_two_button_name)
                        <div class="pt-4">
                            <a href="{{ $aboutPage->section_three_tab_two_button_link ?? '#' }}" class="text-btn main-color">
                                {{ $aboutPage->section_three_tab_two_button_name }}
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </div>
                        @endif
                    </div>
                    
                    <div class="col-lg-5">
                        @if($aboutPage->section_three_tab_two_quote)
                        <div style="border-top: 1px solid black; border-bottom: 1px solid black">
                            <div class="p-5">
                                <h4>{{ $aboutPage->section_three_tab_two_quote }}</h4>
                                @if($aboutPage->section_three_tab_two_quote_author)
                                <p><span class="fw-bold">{{ $aboutPage->section_three_tab_two_quote_author }}</span></p>
                                @endif
                            </div>
                        </div>
                        @elseif($aboutPage->section_three_tab_two_list_title)
                        <div class="ms-5">
                            <h4>{{ $aboutPage->section_three_tab_two_list_title }}</h4>
                            <ul class="ps-2 ms-0">
                                @foreach([1,2,3,4] as $i)
                                    @php $listItem = "section_three_tab_two_list_$i"; @endphp
                                    @if($aboutPage->$listItem)
                                    <li class="pt-3">{{ $aboutPage->$listItem }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Add similar blocks for tab three and four -->
        </div>
    </div>
</section>
@endif

<!-- Section Four: Banner Middle -->
@if($aboutPage->section_four_banner_middle_image)
<section class="mt-5 container-faded section_four">
    <div class="p-0">
        <div class="">
            <img class="img-fluid w-100"
                src="{{ !empty($aboutPage->section_four_banner_middle_image) && file_exists(public_path('app/public/about-us/' . $aboutPage->section_four_banner_middle_image)) ? asset('app/public/about-us/' . $aboutPage->section_four_banner_middle_image) : asset('img/about-us-banner.jpg') }}"
                alt="banner">
        </div>
    </div>
</section>
@endif

<!-- Section Five: CEO & Features -->
@if($aboutPage->section_five_col_one_title || $aboutPage->section_five_col_two_title)
<section class="section_five">
    <div class="container custom-spacer">
        <div class="row align-items-center">
            <!-- Column 1: CEO Info -->
            @if($aboutPage->section_five_col_one_title)
            <div class="col-lg-6" style="border-right: 1px solid var(--secondary-color)">
                <div class="me-4">
                    <h1>{{ $aboutPage->section_five_col_one_title }}</h1>
                    @if($aboutPage->section_five_col_one_description)
                    <p class="pb-5">{{ $aboutPage->section_five_col_one_description }}</p>
                    @endif
                    
                    @if($aboutPage->section_five_ceo_sign)
                    <div class="d-flex justify-content-start align-items-start">
                        <img class="img-fluid" width="200px" src="{{ $aboutPage->section_five_ceo_sign }}"
                            alt="CEO Signature"
                            onerror="this.onerror=null;this.src='{{ asset('img/ceo.png') }}';">
                    </div>
                    @endif
                    
                    @if($aboutPage->section_five_ceo_name)
                    <div class="d-flex">
                        <div class="p-2 pe-3" style="border-right: 1px solid black">
                            <h6 class="mb-0 fw-bold">{{ $aboutPage->section_five_ceo_name }}</h6>
                            @if($aboutPage->section_five_ceo_designation)
                            <p class="mb-0">{{ $aboutPage->section_five_ceo_designation }}</p>
                            @endif
                        </div>
                        <div class="d-flex align-items-center">
                            @if($aboutPage->section_five_ceo_facebook_account_link)
                            <a href="{{ $aboutPage->section_five_ceo_facebook_account_link }}"><i
                                    class="p-2 fa-brands fa-square-facebook"></i></a>
                            @endif
                            @if($aboutPage->section_five_ceo_twitter_account_link)
                            <a href="{{ $aboutPage->section_five_ceo_twitter_account_link }}"><i
                                    class="p-2 fa-brands fa-twitter"></i></a>
                            @endif
                            @if($aboutPage->section_five_ceo_whatsapp_account_link)
                            <a href="{{ $aboutPage->section_five_ceo_whatsapp_account_link }}"><i
                                    class="p-2 fa-brands fa-whatsapp"></i></a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Column 2: Features -->
            @if($aboutPage->section_five_col_two_title)
            <div class="col-lg-6">
                <div class="ms-4">
                    <h3>{{ $aboutPage->section_five_col_two_title }}</h3>
                    @if($aboutPage->section_five_col_two_content)
                    <p>{{ $aboutPage->section_five_col_two_content }}</p>
                    @endif
                    
                    <ul class="ms-0 ps-0">
                        @foreach([1,2,3,4] as $i)
                            @php $listItem = "section_five_col_two_list_$i"; @endphp
                            @if($aboutPage->$listItem)
                            <li class="pt-3">
                                <a href="#">
                                    <i class="fa-regular fa-circle-check pe-2 main-color"></i>
                                    {{ $aboutPage->$listItem }}
                                </a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Section Six: Stats Cards -->
@if($aboutPage->section_six_card_one_title || $aboutPage->section_six_card_two_title || $aboutPage->section_six_card_three_title || $aboutPage->section_six_card_four_title)
<section class="section_six">
    <div class="container px-4 mt-5 custom-spacer">
        <div class="row gx-5">
            @foreach([1,2,3,4] as $cardNum)
                @php 
                    $cardTitle = "section_six_card_{$cardNum}_title";
                    $cardCount = "section_six_card_{$cardNum}_count";
                    $cardIcon = "section_six_card_{$cardNum}_icon";
                    $cardDesc = "section_six_card_{$cardNum}_short_description";
                @endphp
                
                @if($aboutPage->$cardTitle)
                <div class="col-lg-3 ps-0 {{ $cardNum == 4 ? 'pe-0' : '' }}">
                    <div class="px-4 py-5 text-center bg-white shadow-sm"
                        style="border-bottom: 1px solid var(--primary-color); height: 400px;">
                        <div style="width: 80px; height: 80px;" class="mx-auto text-center bg-light rounded-circle d-flex justify-content-center align-items-center">
                            @if($aboutPage->$cardIcon)
                            <i class="{{ $aboutPage->$cardIcon }} main-color fs-3"></i>
                            @endif
                        </div>
                        <h3>
                            {{ $aboutPage->$cardTitle }} 
                            @if($aboutPage->$cardCount)
                            <span class="main-color">{{ $aboutPage->$cardCount }}</span>
                            @endif
                        </h3>
                        @if($aboutPage->$cardDesc)
                        <p>{{ $aboutPage->$cardDesc }}</p>
                        @endif
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Section Seven: Brands Slider -->
@if($brands && count($brands) > 0)
<section class="bg-white section_seven">
    <div class="container p-0 py-3 mb-0 custom-spacer">
        <div class="customer-logos slider">
            @foreach ($brands as $brand)
            <div class="slide">
                <img style="width: 150px !important;" class="img-fluid" 
                     src="{{ !empty($brand->logo) && file_exists(public_path('storage/brand/logo/' . $brand->logo)) ? asset('storage/brand/logo/' . $brand->logo) : asset('backend/images/no-image-available.png') }}" 
                     alt="{{ $brand->title ?? 'Brand Logo' }}">
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@else
<!-- Fallback when no about page data -->
<section class="section_one">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center py-5">
                <h2>About Us</h2>
                <p class="text-muted">The about page is currently under construction. Please check back later.</p>
            </div>
        </div>
    </div>
</section>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize slick slider if brands exist
        @if($brands && count($brands) > 0)
        $('.customer-logos').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 1500,
            arrows: false,
            dots: false,
            pauseOnHover: false,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 3
                    }
                }
            ]
        });
        @endif
    });
</script>
@endpush