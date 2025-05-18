<x-frontend-layout :title="'Tech Focus Limited'">
    @push('metadata')
        <title>Tech Focus Limited | Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description"
            content="Welcome to Your Website Name your go-to source for [brief value proposition or service]. Discover more today.">
        <meta name="keywords" content="keyword1, keyword2, keyword3">
        <meta name="author" content="Your Company or Name">

        <!-- Open Graph for social sharing -->
        <meta property="og:title" content="Tech Focus Limited | Home">
        <meta property="og:description"
            content="Welcome to Your Website Name your go-to source for [brief value proposition].">
        <meta property="og:image" content="https://yourwebsite.com/images/og-image.jpg">
        <meta property="og:url" content="https://yourwebsite.com/">
        <meta property="og:type" content="website">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Tech Focus Limited | Home">
        <meta name="twitter:description"
            content="Welcome to Your Website Name your go-to source for [brief value proposition].">
        <meta name="twitter:image" content="https://yourwebsite.com/images/twitter-card.jpg">
    @endpush
    <!-- Banner -->
    <div class="swiper bannerSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <a href=""><img src="https://i.ibb.co/72jrMpF/54667.jpg" class="img-fluid" alt="" /></a>
            </div>
            <div class="swiper-slide">
                <a href=""><img src="https://i.ibb.co/pfYZQK4/54574v2.jpg" class="img-fluid"
                        alt="" /></a>
            </div>
            <div class="swiper-slide">
                <a href=""><img src="https://i.ibb.co/W3X5G2H/54361.jpg" class="img-fluid" alt="" /></a>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <!-- Content Menu -->
    <div class="container p-0 my-3">
        <div class="mt-2 mb-2">
            <div class="row">
                @php
                    $chunks = $categories->chunk(4); // Split into 3 chunks of 4 items each
                @endphp

                <div class="col-lg-12">
                    <div class="container">
                        <div class="pt-4 row">
                            @foreach ($chunks as $chunkKey => $chunk)
                                <div class="col-md-4 {{ $chunkKey == 0 ? 'ps-0' : 'pe-0' }}">
                                    @foreach ($chunk as $key => $category)
                                        <div class="accordion accordion-flush"
                                            id="accordionFlushExample-{{ $chunkKey }}-{{ $key }}">
                                            <div class="mb-2 accordion-item">
                                                <h2 class="accordion-header"
                                                    id="flush-heading-{{ $chunkKey }}-{{ $key }}">
                                                    <button class="p-3 accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#flush-collapse-{{ $chunkKey }}-{{ $key }}"
                                                        aria-expanded="false"
                                                        aria-controls="flush-collapse-{{ $chunkKey }}-{{ $key }}">
                                                        <p class="p-2 m-0 accordion-button-area ps-0">
                                                            <span class="ms-0"> </span>
                                                        </p>
                                                        <div class="d-flex align-items-center w-100">
                                                            <img src="{{ asset('frontend/assets/img/Icon.svg') }}"
                                                                alt="" />
                                                            <p class="mb-0 ms-2">
                                                                {{ $category->name }}
                                                            </p>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse-{{ $chunkKey }}-{{ $key }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="flush-heading-{{ $chunkKey }}-{{ $key }}"
                                                    data-bs-parent="#accordionFlushExample-{{ $chunkKey }}-{{ $key }}">
                                                    <div class="accordion-body">
                                                        <ul class="ps-3">
                                                            @if (count($category->children) > 0)
                                                                @foreach ($category->children as $sub_cat)
                                                                    <li class="mb-2 menu-single-items">
                                                                        <a
                                                                            href="{{ route('category', $sub_cat->slug) }}">{{ $sub_cat->name }}</a>
                                                                    </li>
                                                                @endforeach
                                                            @else
                                                                <li class="mb-2 menu-single-items">
                                                                    <a href="javascript:void(0)">No Content Found!</a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div>
                <div class="mt-1 mb-3 row">
                    <div class="col-lg-12">
                        <div class="devider-wrap">
                            <h4 class="devider-content">
                                <span class="devider-text">WHAT WE DO</span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="mx-1 mb-5 bg-white row what-we-do"
                    style="background-image: url(https://www.riverbed.com/riverbed-wp-content/uploads/2022/12/lady-with-laptop.png);">
                    <div class="p-5 mb-3 col-lg-12">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="holder-main-text">
                                    <h6 style="width: 28%; line-height: 1.4;">
                                        WHY YOU NEED US ?
                                    </h6>
                                    <h2 class="pb-2 mb-0 w-75">
                                        Modernize IT for Digital and Cloud Success
                                    </h2>
                                    <p class="py-3 mt-0 w-75" style="text-align: justify">
                                        To take advantage of digital and cloud technologies that
                                        fuel transformation, organizations must modernize their IT
                                        infrastructure. But this doesn’t happen overnight. Whatever
                                        the pace, Riverbed can help IT teams make the transition in
                                        the most performant, cost-effective, and secure way.
                                    </p>
                                    <a href="guide.html" class="btn common-btn-3 rounded-0 w-25">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="devider-wrap">
                        <h4 class="devider-content">
                            <span class="devider-text">New products</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="url-box">
                            <div class="border-0 card rounded-0 h-product">
                                <div class="bg-white card-header d-flex justify-content-between">
                                    <span class="product_badge">New</span>
                                    <img src="{{ asset('storage/brand/logo/' . optional($product->brand)->logo) }}"
                                        height="20px" alt="{{ optional($product->brand)->title }}"
                                        loading="lazy" />
                                    <!-- <span class="product_badge2">New</span> -->
                                </div>
                                <div class="p-0 card-body">
                                    <div class="">
                                        <img class="img-fluid h-product-img" src="{{ $product->thumbnail }}" />
                                    </div>
                                    <div class="px-3">
                                        <a class="title"
                                            href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => optional($product)->slug]) }}">
                                            <h6 class="pt-3">{{ $product->name }}</h6>
                                        </a>

                                        <div class="mb-3">
                                            @if (!empty($product->sku_code))
                                                <p class="p-0 pb-2 m-0">
                                                    <a href="javascript:void(0)">
                                                        <i class="fa-solid fa-paperclip main-color tags-text me-2"></i>
                                                        <span class="tags-text">SKU #{{ $product->sku_code }}</span>
                                                    </a>
                                                </p>
                                            @endif
                                            @if (!empty($product->mf_code))
                                                <p class="p-0 pb-2 m-0">
                                                    <a href="javascript:void(0)">
                                                        <i class="fa-solid fa-paperclip main-color tags-text me-2"></i>
                                                        <span class="tags-text">MF #{{ $product->mf_code }}</span>
                                                    </a>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="mt-2 devider-wrap">
                        <h4 class="pt-4 devider-content">
                            <span class="devider-text">New Solution</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- New Product -->
        <div>
            <div class="mb-3 border-0 card bg-primary"
                style="border-top-right-radius: 40px; border-bottom-left-radius: 40px; background: linear-gradient(90deg, #0069bf 0%, #38b6ff 100%);">
                <div class="bg-transparent border-0 card-header">
                    <div class="px-5 row">
                        <div class="col-lg-12">
                            <div class="py-5 text-white d-flex justify-content-start">
                                <h3>Solutions</h3>
                                {{-- <h3 class="px-3">|</h3>
                                <h3>Full-fidelity, No Sampling</h3> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white card-body" style="border-bottom-left-radius: 40px">
                    <div class="px-5 row gx-5 special_solution_box">
                        @foreach ($solutions as $solution)
                            <div class="col-md-3">
                                <div>
                                    <a href="{{ route('solution.details', $solution->slug) }}">
                                        <div class="p-3 border-0 shadow-sm card rounded-0 solution_cards">
                                            <div class="py-0 pt-2 d-flex align-items-center card-body">
                                                <div class="icon-box">
                                                    {{-- <img width="70px" height="55px"
                                                        src="https://www.riverbed.com/riverbed-wp-content/uploads/2022/12/brainstorm_color.png"
                                                        alt="" /> --}}
                                                    <i class="fa-brands fa-draft2digital pe-2"></i>
                                                </div>
                                                <div class="text-box">
                                                    <p class="p-0 m-0 ps-2 w-75">
                                                        {{ Str::words($solution->name, 5) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="{{ route('solution.details', $solution->slug) }}"
                                                class="pt-0 pb-2 mt-0 text-end main-color pe-1">
                                                <i class="fa-solid fa-plus"></i>
                                            </a>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- New Trends -->
        <div>
            <div class="mt-3 row">
                <div class="col-lg-12">
                    <div class="devider-wrap">
                        <h4 class="devider-content">
                            <span class="devider-text">NEW TRENDS </span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="row gx-5">
                @foreach ($news_trends as $news_trend)
                    <div class="col">
                        <a href="{{ route('content.details', $news_trend->slug) }}">
                            <div class="card projects-card rounded-0">
                                <img src="{{ asset('storage/content/' . $news_trend->thumbnail_image) }}"
                                    class="card-img-top img-fluid rounded-0" alt="{{ $news_trend->title }}" />
                                <div class="card-body">
                                    <p class="card-text project-para">{{ $news_trend->title }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Exhibitions -->
        <div>
            <div class="mx-4 mt-5 mb-3">
                <div class="mt-3">
                    <div class="bg-white row gx-5 develop-business-2 align-items-center">
                        <div class="p-2 col">
                            <div class="main-color d-flex">
                                <a href="">
                                    <h6 class="mb-0 ps-4">Develop Your Business!</h6>
                                </a>
                            </div>
                        </div>
                        <div class="p-2 col">
                            <a href="">
                                <div class="main-color d-flex align-items-center">
                                    <p class="p-0 m-0">
                                        <i class="fa-solid fa-phone-volume"></i>
                                    </p>
                                    <p class="p-0 m-0 ms-2">
                                        <span class="text-muted">Contact Us</span>
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="p-2 col">
                            <a href="">
                                <div class="main-color d-flex align-items-center">
                                    <p class="p-0 m-0">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </p>
                                    <p class="p-0 m-0 ms-2">
                                        <span class="text-muted">Start Selling Online</span>
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="p-2 col">
                            <a href="">
                                <div class="main-color d-flex align-items-center">
                                    <p class="p-0 m-0">
                                        <i class="fa-solid fa-box-open"></i>
                                    </p>
                                    <p class="p-0 m-0 ms-2">
                                        <span class="text-muted">Exhibit Your Products</span>
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="p-2 m-0 col special-exhibit-2">
                            <a href="">
                                <div class="p-3 text-center">
                                    <h4 class="mb-0 text-white">Exhibit With Us</h4>
                                    <p class="p-0 m-0 text-white ms-2" style="font-size: 12px">
                                        Sign up in 2 minutes
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Our Buying Guides -->
        {{-- <div>
            <div class="mt-3 row gx-5">
                <div class="col-lg-12">
                    <div class="devider-wrap">
                        <h4 class="devider-content">
                            <span class="devider-text">Our Buying Guides </span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Guides -->
        <div class="overflow-hidden">
            <div class="row gx-3">
                <div class="col-lg-4 col-sm-12">
                    <div class="p-4 bg-white buying-area">
                        <div class="ms-1">
                            <img src="https://img.directindustry.com/buyingguide/di/en/501.jpg"
                                alt="Choosing the Right Pressure Gauge" class="img-fluid" width="800px" />
                        </div>
                        <div class="ms-2">
                            <h6 class="main-color">CHOOSING THE RIGHT PRESSURE GAUGE</h6>
                            <p class="p-0 m-0 my-3"
                                style="
                    font-size: 14px;
                    word-spacing: 5px;
                    line-height: 1.2;
                    text-align: justify;
                  ">
                                A pressure gauge is an instrument for measuring pressure. The
                                term pressure indicator may also be used. In industry,
                                pressure is certainly the [...]
                            </p>
                            <!-- <a href="guide.html" class="mt-2 btn signin rounded-0">Learn More</a> -->
                            <a href="guide.html" class="mt-2 btn common-btn-4 rounded-0">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="p-4 bg-white buying-area">
                        <div class="ms-1">
                            <img src="https://img.directindustry.com/buyingguide/di/en/480.jpg"
                                alt="Choosing the Right Pressure Gauge" class="img-fluid" width="800px" />
                        </div>
                        <div class="ms-2">
                            <h6 class="main-color">CHOOSING THE RIGHT LEVEL SWITCH</h6>
                            <p class="p-0 m-0 my-3"
                                style="
                    font-size: 14px;
                    word-spacing: 5px;
                    line-height: 1.2;
                    text-align: justify;
                  ">
                                A pressure gauge is an instrument for measuring pressure. The
                                term pressure indicator may also be used. In industry,
                                pressure is certainly the [...]
                            </p>
                            <!-- <a href="guide.html" class="mt-2 btn signin rounded-0">Learn More</a> -->
                            <a href="guide.html" class="mt-2 btn common-btn-4 rounded-0">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="p-4 bg-white buying-area">
                        <div class="ms-1">
                            <img src="https://img.directindustry.com/buyingguide/di/en/444.jpg"
                                alt="Choosing the Right Pressure Gauge" class="img-fluid" width="800px" />
                        </div>
                        <div class="ms-2">
                            <h6 class="main-color">CHOOSING THE RIGHT INDUSTRIAL MINCER</h6>
                            <p class="p-0 m-0 my-3"
                                style="
                    font-size: 14px;
                    word-spacing: 5px;
                    line-height: 1.2;
                    text-align: justify;
                  ">
                                A pressure gauge is an instrument for measuring pressure. The
                                term pressure indicator may also be used. In industry,
                                pressure is certainly the [...]
                            </p>
                            <!-- <a href="guide.html" class="mt-2 btn signin rounded-0">Learn More</a> -->
                            <a href="guide.html" class="mt-2 btn common-btn-4 rounded-0">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mt-3 col-lg-12 text-end">
                    <a class="main-color" href="https://projects.directindustry.com/">See
                        All Projects <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div> --}}
        <div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="devider-wrap">
                        <h4 class="devider-content">
                            <span class="devider-text">WHY YOU NEED US ?</span>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="mx-1 mb-5 bg-white row"
                style="border-top-right-radius: 40px; border-bottom-left-radius: 40px">
                <div class="p-5 mb-3 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="holder-main-text">
                                <h6 style="width: 23%; line-height: 25px">
                                    WHY YOU NEED US?
                                </h6>
                                <h2 class="pt-3 pb-2 mb-0 w-75 text-capitalize">
                                    Maximize Visibility and Performance
                                </h2>
                                <p class="pt-2 mt-0 w-75" style="text-align: justify">
                                    Overcome the challenges of insufficient visibility,
                                    unpredictable network and application performance, and
                                    expanded cyber security risks—all while improving your
                                    ability to be agile and resilient.
                                </p>
                                <a href="guide.html" class="mt-4 btn common-btn-3 rounded-0 w-25">Learn More</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="">
                                        <div class="mt-2 shadow-lg card common-gradient"
                                            style="
                          border-top-right-radius: 40px;
                          border-bottom-left-radius: 40px;
                          border: 0px solid #fff;
                        ">
                                            <div class="border-0 card-body">
                                                <div class="icon-holder">
                                                    <?xml version="1.0" encoding="UTF-8"?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                                                        <defs>
                                                            <style>
                                                                .c {
                                                                    fill: #fff;
                                                                }
                                                            </style>
                                                        </defs>
                                                        <g id="a">
                                                            <g>
                                                                <path class="c"
                                                                    d="M65.4,66.68c-.51,0-.94-.39-.99-.9-.09-.94-.43-2.96-1.7-5.03v4.94c0,.55-.45,1-1,1s-1-.45-1-1v-7.8c0-.4,.24-.77,.62-.92,.37-.15,.8-.07,1.09,.21,3.17,3.14,3.85,6.93,3.99,8.41,.05,.55-.35,1.04-.9,1.09-.03,0-.07,0-.1,0Zm-51.06,0s-.06,0-.1,0c-.55-.05-.95-.54-.9-1.09,.14-1.48,.82-5.27,3.99-8.41,.29-.28,.72-.37,1.09-.21,.37,.16,.62,.52,.62,.92v7.8c0,.55-.45,1-1,1s-1-.45-1-1v-4.94c-1.27,2.07-1.61,4.09-1.7,5.03-.05,.52-.49,.9-.99,.9Zm-5,0s-.03,0-.05,0c-.55-.03-.98-.49-.95-1.04,.26-5.72,3.89-13.52,13.25-16.7,.28-.1,.6-.06,.85,.1l2.56,1.61,1.79-2.71c.13-.2,.33-.35,.56-.41,6.67-1.9,8.93-7.39,8.95-7.45,.33-.81,1.08-1.54,1.97-1.91,.88-.36,1.83-.36,2.69,.01,1.74,.75,2.53,2.66,1.83,4.44-.12,.31-3.02,7.68-11.63,10.99v12.07c0,.55-.45,1-1,1s-1-.45-1-1v-12.77c0-.43,.27-.8,.67-.94,8.26-2.87,11.06-9.99,11.09-10.06,.31-.79,0-1.56-.76-1.88-.37-.16-.76-.16-1.14,0-.45,.19-.77,.55-.87,.8-.1,.26-2.57,6.26-9.9,8.52l-2.13,3.23c-.3,.45-.91,.58-1.37,.3l-2.98-1.87c-8.07,2.94-11.21,9.74-11.45,14.74-.02,.54-.47,.95-1,.95Zm61.06,0c-.53,0-.97-.42-1-.95-.23-5.01-3.38-11.82-11.47-14.75l-2.95,1.88c-.46,.29-1.07,.16-1.37-.29l-2.15-3.22c-4.46-1.36-7.06-4-8.23-5.49-.34-.43-.27-1.06,.17-1.4,.43-.34,1.06-.27,1.4,.17,1.05,1.33,3.42,3.74,7.56,4.9,.23,.07,.43,.21,.56,.41l1.81,2.71,2.54-1.62c.26-.16,.57-.2,.86-.1,9.37,3.17,13.01,10.98,13.27,16.71,.03,.55-.4,1.02-.95,1.04-.02,0-.03,0-.05,0Zm-20.83,0c-.55,0-1-.45-1-1v-12.07c-3.3-1.28-6.43-3.44-8.11-5.63-.34-.44-.25-1.07,.19-1.4,.44-.33,1.07-.25,1.4,.19,1.55,2.02,4.7,4.11,7.85,5.2,.4,.14,.67,.52,.67,.94v12.77c0,.55-.45,1-1,1Zm6.06-18.9c-3.49,0-6.33-2.84-6.33-6.33s2.84-6.33,6.33-6.33,6.33,2.84,6.33,6.33-2.84,6.33-6.33,6.33Zm0-10.66c-2.39,0-4.33,1.94-4.33,4.33s1.94,4.33,4.33,4.33,4.33-1.94,4.33-4.33-1.94-4.33-4.33-4.33Zm-31.54,10.66c-3.49,0-6.33-2.84-6.33-6.33s2.84-6.33,6.33-6.33,6.33,2.84,6.33,6.33-2.84,6.33-6.33,6.33Zm0-10.66c-2.39,0-4.33,1.94-4.33,4.33s1.94,4.33,4.33,4.33,4.33-1.94,4.33-4.33-1.94-4.33-4.33-4.33Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M44.78,34.14h-6.38c-.38,0-1.64-.14-1.64-1.98,0-.1,0-.25-.11-.66-.17-.62-.27-.9-1.31-2.77-.99-1.63-1.48-3.16-1.48-4.53,0-4.26,3.47-7.73,7.73-7.73,2.19,0,4.09,.74,5.48,2.15,1.43,1.44,2.27,3.55,2.25,5.62-.02,1.43-.5,2.9-1.49,4.51-.77,1.26-1.13,2.02-1.28,2.68-.06,.28-.12,.65-.13,.79,.04,.54-.11,1.02-.43,1.38-.31,.34-.73,.53-1.21,.53Zm-6-1.72h0Zm-.02-.28h5.66c.02-.35,.12-.91,.17-1.13,.23-1.04,.78-2.07,1.53-3.3,.79-1.29,1.18-2.43,1.2-3.48,.01-1.2-.42-2.93-1.67-4.19-1.02-1.03-2.39-1.56-4.06-1.56-3.16,0-5.73,2.57-5.73,5.73,0,.69,.21,1.86,1.21,3.51l.02,.03c1.07,1.92,1.27,2.39,1.5,3.23,.16,.58,.18,.9,.19,1.17Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M37.77,25.57c-.55,0-1-.45-1-1,0-2.95,2.4-5.35,5.35-5.35,.55,0,1,.45,1,1s-.45,1-1,1c-1.85,0-3.35,1.5-3.35,3.35,0,.55-.45,1-1,1Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M41.6,37.31c-1.7,0-2.46-.79-2.79-1.36-.92-.64-1.47-1.79-1.6-2.67-.08-.55,.3-1.05,.85-1.13,.56-.08,1.05,.3,1.13,.85,.08,.54,.47,1.18,.85,1.37,.22,.11,.4,.31,.48,.55,.13,.36,.73,.41,1.08,.41s.94-.05,1.07-.41c.09-.24,.26-.44,.49-.55,.31-.15,.78-.91,.83-1.33,.06-.55,.56-.95,1.11-.88,.55,.06,.94,.56,.88,1.11-.1,.88-.74,2.09-1.59,2.7-.33,.57-1.09,1.37-2.79,1.37Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M52.45,29.8c-.13,0-.26-.03-.39-.08l-1.64-.69c-.51-.21-.75-.8-.54-1.31,.21-.51,.8-.75,1.31-.54l1.64,.69c.51,.21,.75,.8,.54,1.31-.16,.38-.53,.61-.92,.61Zm-21.75-.09c-.39,0-.77-.23-.93-.62-.21-.51,.04-1.1,.55-1.3l1.65-.67c.51-.21,1.09,.03,1.3,.55,.21,.51-.04,1.1-.55,1.3l-1.65,.67c-.12,.05-.25,.08-.38,.08Zm20.14-8.25c-.39,0-.77-.23-.93-.62-.21-.51,.04-1.1,.55-1.3l1.64-.67c.51-.21,1.09,.04,1.3,.55,.21,.51-.04,1.1-.55,1.3l-1.64,.67c-.12,.05-.25,.07-.38,.07Zm-18.47-.08c-.13,0-.26-.03-.39-.08l-1.64-.69c-.51-.21-.75-.8-.54-1.31,.21-.51,.8-.75,1.31-.54l1.64,.69c.51,.21,.75,.8,.54,1.31-.16,.38-.53,.61-.92,.61Zm13.08-5.35c-.13,0-.26-.03-.39-.08-.51-.21-.75-.8-.54-1.31l.69-1.64c.21-.51,.8-.75,1.31-.54,.51,.21,.75,.8,.54,1.31l-.69,1.64c-.16,.38-.53,.61-.92,.61Zm-7.65-.03c-.39,0-.77-.23-.93-.62l-.67-1.65c-.21-.51,.04-1.09,.55-1.3,.51-.21,1.09,.03,1.3,.55l.67,1.65c.21,.51-.04,1.09-.55,1.3-.12,.05-.25,.08-.38,.08Z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                        <g id="b"></g>
                                                    </svg>
                                                </div>
                                                <div class="solution-card-box">
                                                    <h5>Unified Observability</h5>
                                                    <div class="text-white row">
                                                        <div class="col-lg-12">
                                                            <a href="#"
                                                                class="mt-1 mb-3 learn_more_btn d-flex justify-content-between">
                                                                <p class="p-0 pb-2 m-0">Learn More</p>
                                                                <p class="p-0 pb-2 m-0">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-6">
                                    <a href="">
                                        <div class="mt-2 shadow-lg card common-gradient"
                                            style="
                          border-top-right-radius: 40px;
                          border-bottom-left-radius: 40px;
                          border: 0px solid #fff;
                        ">
                                            <div class="border-0 card-body">
                                                <div class="icon-holder">
                                                    <?xml version="1.0" encoding="UTF-8"?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                                                        <defs>
                                                            <style>
                                                                .c {
                                                                    fill: #fff;
                                                                }
                                                            </style>
                                                        </defs>
                                                        <g id="a">
                                                            <g>
                                                                <path class="c"
                                                                    d="M65.4,66.68c-.51,0-.94-.39-.99-.9-.09-.94-.43-2.96-1.7-5.03v4.94c0,.55-.45,1-1,1s-1-.45-1-1v-7.8c0-.4,.24-.77,.62-.92,.37-.15,.8-.07,1.09,.21,3.17,3.14,3.85,6.93,3.99,8.41,.05,.55-.35,1.04-.9,1.09-.03,0-.07,0-.1,0Zm-51.06,0s-.06,0-.1,0c-.55-.05-.95-.54-.9-1.09,.14-1.48,.82-5.27,3.99-8.41,.29-.28,.72-.37,1.09-.21,.37,.16,.62,.52,.62,.92v7.8c0,.55-.45,1-1,1s-1-.45-1-1v-4.94c-1.27,2.07-1.61,4.09-1.7,5.03-.05,.52-.49,.9-.99,.9Zm-5,0s-.03,0-.05,0c-.55-.03-.98-.49-.95-1.04,.26-5.72,3.89-13.52,13.25-16.7,.28-.1,.6-.06,.85,.1l2.56,1.61,1.79-2.71c.13-.2,.33-.35,.56-.41,6.67-1.9,8.93-7.39,8.95-7.45,.33-.81,1.08-1.54,1.97-1.91,.88-.36,1.83-.36,2.69,.01,1.74,.75,2.53,2.66,1.83,4.44-.12,.31-3.02,7.68-11.63,10.99v12.07c0,.55-.45,1-1,1s-1-.45-1-1v-12.77c0-.43,.27-.8,.67-.94,8.26-2.87,11.06-9.99,11.09-10.06,.31-.79,0-1.56-.76-1.88-.37-.16-.76-.16-1.14,0-.45,.19-.77,.55-.87,.8-.1,.26-2.57,6.26-9.9,8.52l-2.13,3.23c-.3,.45-.91,.58-1.37,.3l-2.98-1.87c-8.07,2.94-11.21,9.74-11.45,14.74-.02,.54-.47,.95-1,.95Zm61.06,0c-.53,0-.97-.42-1-.95-.23-5.01-3.38-11.82-11.47-14.75l-2.95,1.88c-.46,.29-1.07,.16-1.37-.29l-2.15-3.22c-4.46-1.36-7.06-4-8.23-5.49-.34-.43-.27-1.06,.17-1.4,.43-.34,1.06-.27,1.4,.17,1.05,1.33,3.42,3.74,7.56,4.9,.23,.07,.43,.21,.56,.41l1.81,2.71,2.54-1.62c.26-.16,.57-.2,.86-.1,9.37,3.17,13.01,10.98,13.27,16.71,.03,.55-.4,1.02-.95,1.04-.02,0-.03,0-.05,0Zm-20.83,0c-.55,0-1-.45-1-1v-12.07c-3.3-1.28-6.43-3.44-8.11-5.63-.34-.44-.25-1.07,.19-1.4,.44-.33,1.07-.25,1.4,.19,1.55,2.02,4.7,4.11,7.85,5.2,.4,.14,.67,.52,.67,.94v12.77c0,.55-.45,1-1,1Zm6.06-18.9c-3.49,0-6.33-2.84-6.33-6.33s2.84-6.33,6.33-6.33,6.33,2.84,6.33,6.33-2.84,6.33-6.33,6.33Zm0-10.66c-2.39,0-4.33,1.94-4.33,4.33s1.94,4.33,4.33,4.33,4.33-1.94,4.33-4.33-1.94-4.33-4.33-4.33Zm-31.54,10.66c-3.49,0-6.33-2.84-6.33-6.33s2.84-6.33,6.33-6.33,6.33,2.84,6.33,6.33-2.84,6.33-6.33,6.33Zm0-10.66c-2.39,0-4.33,1.94-4.33,4.33s1.94,4.33,4.33,4.33,4.33-1.94,4.33-4.33-1.94-4.33-4.33-4.33Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M44.78,34.14h-6.38c-.38,0-1.64-.14-1.64-1.98,0-.1,0-.25-.11-.66-.17-.62-.27-.9-1.31-2.77-.99-1.63-1.48-3.16-1.48-4.53,0-4.26,3.47-7.73,7.73-7.73,2.19,0,4.09,.74,5.48,2.15,1.43,1.44,2.27,3.55,2.25,5.62-.02,1.43-.5,2.9-1.49,4.51-.77,1.26-1.13,2.02-1.28,2.68-.06,.28-.12,.65-.13,.79,.04,.54-.11,1.02-.43,1.38-.31,.34-.73,.53-1.21,.53Zm-6-1.72h0Zm-.02-.28h5.66c.02-.35,.12-.91,.17-1.13,.23-1.04,.78-2.07,1.53-3.3,.79-1.29,1.18-2.43,1.2-3.48,.01-1.2-.42-2.93-1.67-4.19-1.02-1.03-2.39-1.56-4.06-1.56-3.16,0-5.73,2.57-5.73,5.73,0,.69,.21,1.86,1.21,3.51l.02,.03c1.07,1.92,1.27,2.39,1.5,3.23,.16,.58,.18,.9,.19,1.17Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M37.77,25.57c-.55,0-1-.45-1-1,0-2.95,2.4-5.35,5.35-5.35,.55,0,1,.45,1,1s-.45,1-1,1c-1.85,0-3.35,1.5-3.35,3.35,0,.55-.45,1-1,1Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M41.6,37.31c-1.7,0-2.46-.79-2.79-1.36-.92-.64-1.47-1.79-1.6-2.67-.08-.55,.3-1.05,.85-1.13,.56-.08,1.05,.3,1.13,.85,.08,.54,.47,1.18,.85,1.37,.22,.11,.4,.31,.48,.55,.13,.36,.73,.41,1.08,.41s.94-.05,1.07-.41c.09-.24,.26-.44,.49-.55,.31-.15,.78-.91,.83-1.33,.06-.55,.56-.95,1.11-.88,.55,.06,.94,.56,.88,1.11-.1,.88-.74,2.09-1.59,2.7-.33,.57-1.09,1.37-2.79,1.37Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M52.45,29.8c-.13,0-.26-.03-.39-.08l-1.64-.69c-.51-.21-.75-.8-.54-1.31,.21-.51,.8-.75,1.31-.54l1.64,.69c.51,.21,.75,.8,.54,1.31-.16,.38-.53,.61-.92,.61Zm-21.75-.09c-.39,0-.77-.23-.93-.62-.21-.51,.04-1.1,.55-1.3l1.65-.67c.51-.21,1.09,.03,1.3,.55,.21,.51-.04,1.1-.55,1.3l-1.65,.67c-.12,.05-.25,.08-.38,.08Zm20.14-8.25c-.39,0-.77-.23-.93-.62-.21-.51,.04-1.1,.55-1.3l1.64-.67c.51-.21,1.09,.04,1.3,.55,.21,.51-.04,1.1-.55,1.3l-1.64,.67c-.12,.05-.25,.07-.38,.07Zm-18.47-.08c-.13,0-.26-.03-.39-.08l-1.64-.69c-.51-.21-.75-.8-.54-1.31,.21-.51,.8-.75,1.31-.54l1.64,.69c.51,.21,.75,.8,.54,1.31-.16,.38-.53,.61-.92,.61Zm13.08-5.35c-.13,0-.26-.03-.39-.08-.51-.21-.75-.8-.54-1.31l.69-1.64c.21-.51,.8-.75,1.31-.54,.51,.21,.75,.8,.54,1.31l-.69,1.64c-.16,.38-.53,.61-.92,.61Zm-7.65-.03c-.39,0-.77-.23-.93-.62l-.67-1.65c-.21-.51,.04-1.09,.55-1.3,.51-.21,1.09,.03,1.3,.55l.67,1.65c.21,.51-.04,1.09-.55,1.3-.12,.05-.25,.08-.38,.08Z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                        <g id="b"></g>
                                                    </svg>
                                                </div>
                                                <div class="solution-card-box">
                                                    <h5>Unified Observability</h5>
                                                    <div class="text-white row">
                                                        <div class="col-lg-12">
                                                            <a href="#"
                                                                class="mt-1 mb-3 learn_more_btn d-flex justify-content-between">
                                                                <p class="p-0 pb-2 m-0">Learn More</p>
                                                                <p class="p-0 pb-2 m-0">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="mt-3 row">
                                <div class="col-lg-6">
                                    <a href="">
                                        <div class="mt-2 shadow-lg card common-gradient"
                                            style="
                          border-top-right-radius: 40px;
                          border-bottom-left-radius: 40px;
                          border: 0px solid #fff;
                        ">
                                            <div class="border-0 card-body">
                                                <div class="icon-holder">
                                                    <?xml version="1.0" encoding="UTF-8"?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                                                        <defs>
                                                            <style>
                                                                .c {
                                                                    fill: #fff;
                                                                }
                                                            </style>
                                                        </defs>
                                                        <g id="a">
                                                            <g>
                                                                <path class="c"
                                                                    d="M65.4,66.68c-.51,0-.94-.39-.99-.9-.09-.94-.43-2.96-1.7-5.03v4.94c0,.55-.45,1-1,1s-1-.45-1-1v-7.8c0-.4,.24-.77,.62-.92,.37-.15,.8-.07,1.09,.21,3.17,3.14,3.85,6.93,3.99,8.41,.05,.55-.35,1.04-.9,1.09-.03,0-.07,0-.1,0Zm-51.06,0s-.06,0-.1,0c-.55-.05-.95-.54-.9-1.09,.14-1.48,.82-5.27,3.99-8.41,.29-.28,.72-.37,1.09-.21,.37,.16,.62,.52,.62,.92v7.8c0,.55-.45,1-1,1s-1-.45-1-1v-4.94c-1.27,2.07-1.61,4.09-1.7,5.03-.05,.52-.49,.9-.99,.9Zm-5,0s-.03,0-.05,0c-.55-.03-.98-.49-.95-1.04,.26-5.72,3.89-13.52,13.25-16.7,.28-.1,.6-.06,.85,.1l2.56,1.61,1.79-2.71c.13-.2,.33-.35,.56-.41,6.67-1.9,8.93-7.39,8.95-7.45,.33-.81,1.08-1.54,1.97-1.91,.88-.36,1.83-.36,2.69,.01,1.74,.75,2.53,2.66,1.83,4.44-.12,.31-3.02,7.68-11.63,10.99v12.07c0,.55-.45,1-1,1s-1-.45-1-1v-12.77c0-.43,.27-.8,.67-.94,8.26-2.87,11.06-9.99,11.09-10.06,.31-.79,0-1.56-.76-1.88-.37-.16-.76-.16-1.14,0-.45,.19-.77,.55-.87,.8-.1,.26-2.57,6.26-9.9,8.52l-2.13,3.23c-.3,.45-.91,.58-1.37,.3l-2.98-1.87c-8.07,2.94-11.21,9.74-11.45,14.74-.02,.54-.47,.95-1,.95Zm61.06,0c-.53,0-.97-.42-1-.95-.23-5.01-3.38-11.82-11.47-14.75l-2.95,1.88c-.46,.29-1.07,.16-1.37-.29l-2.15-3.22c-4.46-1.36-7.06-4-8.23-5.49-.34-.43-.27-1.06,.17-1.4,.43-.34,1.06-.27,1.4,.17,1.05,1.33,3.42,3.74,7.56,4.9,.23,.07,.43,.21,.56,.41l1.81,2.71,2.54-1.62c.26-.16,.57-.2,.86-.1,9.37,3.17,13.01,10.98,13.27,16.71,.03,.55-.4,1.02-.95,1.04-.02,0-.03,0-.05,0Zm-20.83,0c-.55,0-1-.45-1-1v-12.07c-3.3-1.28-6.43-3.44-8.11-5.63-.34-.44-.25-1.07,.19-1.4,.44-.33,1.07-.25,1.4,.19,1.55,2.02,4.7,4.11,7.85,5.2,.4,.14,.67,.52,.67,.94v12.77c0,.55-.45,1-1,1Zm6.06-18.9c-3.49,0-6.33-2.84-6.33-6.33s2.84-6.33,6.33-6.33,6.33,2.84,6.33,6.33-2.84,6.33-6.33,6.33Zm0-10.66c-2.39,0-4.33,1.94-4.33,4.33s1.94,4.33,4.33,4.33,4.33-1.94,4.33-4.33-1.94-4.33-4.33-4.33Zm-31.54,10.66c-3.49,0-6.33-2.84-6.33-6.33s2.84-6.33,6.33-6.33,6.33,2.84,6.33,6.33-2.84,6.33-6.33,6.33Zm0-10.66c-2.39,0-4.33,1.94-4.33,4.33s1.94,4.33,4.33,4.33,4.33-1.94,4.33-4.33-1.94-4.33-4.33-4.33Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M44.78,34.14h-6.38c-.38,0-1.64-.14-1.64-1.98,0-.1,0-.25-.11-.66-.17-.62-.27-.9-1.31-2.77-.99-1.63-1.48-3.16-1.48-4.53,0-4.26,3.47-7.73,7.73-7.73,2.19,0,4.09,.74,5.48,2.15,1.43,1.44,2.27,3.55,2.25,5.62-.02,1.43-.5,2.9-1.49,4.51-.77,1.26-1.13,2.02-1.28,2.68-.06,.28-.12,.65-.13,.79,.04,.54-.11,1.02-.43,1.38-.31,.34-.73,.53-1.21,.53Zm-6-1.72h0Zm-.02-.28h5.66c.02-.35,.12-.91,.17-1.13,.23-1.04,.78-2.07,1.53-3.3,.79-1.29,1.18-2.43,1.2-3.48,.01-1.2-.42-2.93-1.67-4.19-1.02-1.03-2.39-1.56-4.06-1.56-3.16,0-5.73,2.57-5.73,5.73,0,.69,.21,1.86,1.21,3.51l.02,.03c1.07,1.92,1.27,2.39,1.5,3.23,.16,.58,.18,.9,.19,1.17Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M37.77,25.57c-.55,0-1-.45-1-1,0-2.95,2.4-5.35,5.35-5.35,.55,0,1,.45,1,1s-.45,1-1,1c-1.85,0-3.35,1.5-3.35,3.35,0,.55-.45,1-1,1Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M41.6,37.31c-1.7,0-2.46-.79-2.79-1.36-.92-.64-1.47-1.79-1.6-2.67-.08-.55,.3-1.05,.85-1.13,.56-.08,1.05,.3,1.13,.85,.08,.54,.47,1.18,.85,1.37,.22,.11,.4,.31,.48,.55,.13,.36,.73,.41,1.08,.41s.94-.05,1.07-.41c.09-.24,.26-.44,.49-.55,.31-.15,.78-.91,.83-1.33,.06-.55,.56-.95,1.11-.88,.55,.06,.94,.56,.88,1.11-.1,.88-.74,2.09-1.59,2.7-.33,.57-1.09,1.37-2.79,1.37Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M52.45,29.8c-.13,0-.26-.03-.39-.08l-1.64-.69c-.51-.21-.75-.8-.54-1.31,.21-.51,.8-.75,1.31-.54l1.64,.69c.51,.21,.75,.8,.54,1.31-.16,.38-.53,.61-.92,.61Zm-21.75-.09c-.39,0-.77-.23-.93-.62-.21-.51,.04-1.1,.55-1.3l1.65-.67c.51-.21,1.09,.03,1.3,.55,.21,.51-.04,1.1-.55,1.3l-1.65,.67c-.12,.05-.25,.08-.38,.08Zm20.14-8.25c-.39,0-.77-.23-.93-.62-.21-.51,.04-1.1,.55-1.3l1.64-.67c.51-.21,1.09,.04,1.3,.55,.21,.51-.04,1.1-.55,1.3l-1.64,.67c-.12,.05-.25,.07-.38,.07Zm-18.47-.08c-.13,0-.26-.03-.39-.08l-1.64-.69c-.51-.21-.75-.8-.54-1.31,.21-.51,.8-.75,1.31-.54l1.64,.69c.51,.21,.75,.8,.54,1.31-.16,.38-.53,.61-.92,.61Zm13.08-5.35c-.13,0-.26-.03-.39-.08-.51-.21-.75-.8-.54-1.31l.69-1.64c.21-.51,.8-.75,1.31-.54,.51,.21,.75,.8,.54,1.31l-.69,1.64c-.16,.38-.53,.61-.92,.61Zm-7.65-.03c-.39,0-.77-.23-.93-.62l-.67-1.65c-.21-.51,.04-1.09,.55-1.3,.51-.21,1.09,.03,1.3,.55l.67,1.65c.21,.51-.04,1.09-.55,1.3-.12,.05-.25,.08-.38,.08Z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                        <g id="b"></g>
                                                    </svg>
                                                </div>
                                                <div class="solution-card-box">
                                                    <h5>Unified Observability</h5>
                                                    <div class="text-white row">
                                                        <div class="col-lg-12">
                                                            <a href="#"
                                                                class="mt-1 mb-3 learn_more_btn d-flex justify-content-between">
                                                                <p class="p-0 pb-2 m-0">Learn More</p>
                                                                <p class="p-0 pb-2 m-0">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-6">
                                    <a href="">
                                        <div class="mt-2 shadow-lg card common-gradient"
                                            style="
                          border-top-right-radius: 40px;
                          border-bottom-left-radius: 40px;
                          border: 0px solid #fff;
                        ">
                                            <div class="border-0 card-body">
                                                <div class="icon-holder">
                                                    <?xml version="1.0" encoding="UTF-8"?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                                                        <defs>
                                                            <style>
                                                                .c {
                                                                    fill: #fff;
                                                                }
                                                            </style>
                                                        </defs>
                                                        <g id="a">
                                                            <g>
                                                                <path class="c"
                                                                    d="M65.4,66.68c-.51,0-.94-.39-.99-.9-.09-.94-.43-2.96-1.7-5.03v4.94c0,.55-.45,1-1,1s-1-.45-1-1v-7.8c0-.4,.24-.77,.62-.92,.37-.15,.8-.07,1.09,.21,3.17,3.14,3.85,6.93,3.99,8.41,.05,.55-.35,1.04-.9,1.09-.03,0-.07,0-.1,0Zm-51.06,0s-.06,0-.1,0c-.55-.05-.95-.54-.9-1.09,.14-1.48,.82-5.27,3.99-8.41,.29-.28,.72-.37,1.09-.21,.37,.16,.62,.52,.62,.92v7.8c0,.55-.45,1-1,1s-1-.45-1-1v-4.94c-1.27,2.07-1.61,4.09-1.7,5.03-.05,.52-.49,.9-.99,.9Zm-5,0s-.03,0-.05,0c-.55-.03-.98-.49-.95-1.04,.26-5.72,3.89-13.52,13.25-16.7,.28-.1,.6-.06,.85,.1l2.56,1.61,1.79-2.71c.13-.2,.33-.35,.56-.41,6.67-1.9,8.93-7.39,8.95-7.45,.33-.81,1.08-1.54,1.97-1.91,.88-.36,1.83-.36,2.69,.01,1.74,.75,2.53,2.66,1.83,4.44-.12,.31-3.02,7.68-11.63,10.99v12.07c0,.55-.45,1-1,1s-1-.45-1-1v-12.77c0-.43,.27-.8,.67-.94,8.26-2.87,11.06-9.99,11.09-10.06,.31-.79,0-1.56-.76-1.88-.37-.16-.76-.16-1.14,0-.45,.19-.77,.55-.87,.8-.1,.26-2.57,6.26-9.9,8.52l-2.13,3.23c-.3,.45-.91,.58-1.37,.3l-2.98-1.87c-8.07,2.94-11.21,9.74-11.45,14.74-.02,.54-.47,.95-1,.95Zm61.06,0c-.53,0-.97-.42-1-.95-.23-5.01-3.38-11.82-11.47-14.75l-2.95,1.88c-.46,.29-1.07,.16-1.37-.29l-2.15-3.22c-4.46-1.36-7.06-4-8.23-5.49-.34-.43-.27-1.06,.17-1.4,.43-.34,1.06-.27,1.4,.17,1.05,1.33,3.42,3.74,7.56,4.9,.23,.07,.43,.21,.56,.41l1.81,2.71,2.54-1.62c.26-.16,.57-.2,.86-.1,9.37,3.17,13.01,10.98,13.27,16.71,.03,.55-.4,1.02-.95,1.04-.02,0-.03,0-.05,0Zm-20.83,0c-.55,0-1-.45-1-1v-12.07c-3.3-1.28-6.43-3.44-8.11-5.63-.34-.44-.25-1.07,.19-1.4,.44-.33,1.07-.25,1.4,.19,1.55,2.02,4.7,4.11,7.85,5.2,.4,.14,.67,.52,.67,.94v12.77c0,.55-.45,1-1,1Zm6.06-18.9c-3.49,0-6.33-2.84-6.33-6.33s2.84-6.33,6.33-6.33,6.33,2.84,6.33,6.33-2.84,6.33-6.33,6.33Zm0-10.66c-2.39,0-4.33,1.94-4.33,4.33s1.94,4.33,4.33,4.33,4.33-1.94,4.33-4.33-1.94-4.33-4.33-4.33Zm-31.54,10.66c-3.49,0-6.33-2.84-6.33-6.33s2.84-6.33,6.33-6.33,6.33,2.84,6.33,6.33-2.84,6.33-6.33,6.33Zm0-10.66c-2.39,0-4.33,1.94-4.33,4.33s1.94,4.33,4.33,4.33,4.33-1.94,4.33-4.33-1.94-4.33-4.33-4.33Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M44.78,34.14h-6.38c-.38,0-1.64-.14-1.64-1.98,0-.1,0-.25-.11-.66-.17-.62-.27-.9-1.31-2.77-.99-1.63-1.48-3.16-1.48-4.53,0-4.26,3.47-7.73,7.73-7.73,2.19,0,4.09,.74,5.48,2.15,1.43,1.44,2.27,3.55,2.25,5.62-.02,1.43-.5,2.9-1.49,4.51-.77,1.26-1.13,2.02-1.28,2.68-.06,.28-.12,.65-.13,.79,.04,.54-.11,1.02-.43,1.38-.31,.34-.73,.53-1.21,.53Zm-6-1.72h0Zm-.02-.28h5.66c.02-.35,.12-.91,.17-1.13,.23-1.04,.78-2.07,1.53-3.3,.79-1.29,1.18-2.43,1.2-3.48,.01-1.2-.42-2.93-1.67-4.19-1.02-1.03-2.39-1.56-4.06-1.56-3.16,0-5.73,2.57-5.73,5.73,0,.69,.21,1.86,1.21,3.51l.02,.03c1.07,1.92,1.27,2.39,1.5,3.23,.16,.58,.18,.9,.19,1.17Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M37.77,25.57c-.55,0-1-.45-1-1,0-2.95,2.4-5.35,5.35-5.35,.55,0,1,.45,1,1s-.45,1-1,1c-1.85,0-3.35,1.5-3.35,3.35,0,.55-.45,1-1,1Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M41.6,37.31c-1.7,0-2.46-.79-2.79-1.36-.92-.64-1.47-1.79-1.6-2.67-.08-.55,.3-1.05,.85-1.13,.56-.08,1.05,.3,1.13,.85,.08,.54,.47,1.18,.85,1.37,.22,.11,.4,.31,.48,.55,.13,.36,.73,.41,1.08,.41s.94-.05,1.07-.41c.09-.24,.26-.44,.49-.55,.31-.15,.78-.91,.83-1.33,.06-.55,.56-.95,1.11-.88,.55,.06,.94,.56,.88,1.11-.1,.88-.74,2.09-1.59,2.7-.33,.57-1.09,1.37-2.79,1.37Z">
                                                                </path>
                                                                <path class="c"
                                                                    d="M52.45,29.8c-.13,0-.26-.03-.39-.08l-1.64-.69c-.51-.21-.75-.8-.54-1.31,.21-.51,.8-.75,1.31-.54l1.64,.69c.51,.21,.75,.8,.54,1.31-.16,.38-.53,.61-.92,.61Zm-21.75-.09c-.39,0-.77-.23-.93-.62-.21-.51,.04-1.1,.55-1.3l1.65-.67c.51-.21,1.09,.03,1.3,.55,.21,.51-.04,1.1-.55,1.3l-1.65,.67c-.12,.05-.25,.08-.38,.08Zm20.14-8.25c-.39,0-.77-.23-.93-.62-.21-.51,.04-1.1,.55-1.3l1.64-.67c.51-.21,1.09,.04,1.3,.55,.21,.51-.04,1.1-.55,1.3l-1.64,.67c-.12,.05-.25,.07-.38,.07Zm-18.47-.08c-.13,0-.26-.03-.39-.08l-1.64-.69c-.51-.21-.75-.8-.54-1.31,.21-.51,.8-.75,1.31-.54l1.64,.69c.51,.21,.75,.8,.54,1.31-.16,.38-.53,.61-.92,.61Zm13.08-5.35c-.13,0-.26-.03-.39-.08-.51-.21-.75-.8-.54-1.31l.69-1.64c.21-.51,.8-.75,1.31-.54,.51,.21,.75,.8,.54,1.31l-.69,1.64c-.16,.38-.53,.61-.92,.61Zm-7.65-.03c-.39,0-.77-.23-.93-.62l-.67-1.65c-.21-.51,.04-1.09,.55-1.3,.51-.21,1.09,.03,1.3,.55l.67,1.65c.21,.51-.04,1.09-.55,1.3-.12,.05-.25,.08-.38,.08Z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                        <g id="b"></g>
                                                    </svg>
                                                </div>
                                                <div class="solution-card-box">
                                                    <h5>Unified Observability</h5>
                                                    <div class="text-white row">
                                                        <div class="col-lg-12">
                                                            <a href="#"
                                                                class="mt-1 mb-3 learn_more_btn d-flex justify-content-between">
                                                                <p class="p-0 pb-2 m-0">Learn More</p>
                                                                <p class="p-0 pb-2 m-0">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
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
        </script>
    @endpush

</x-frontend-layout>
