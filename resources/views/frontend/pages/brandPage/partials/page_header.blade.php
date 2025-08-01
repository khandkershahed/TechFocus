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
        <img src="{{ !empty($brand->brandPage->banner_image) && file_exists(public_path('storage/brand-page/banner-image/' . $brand->brandPage->banner_image)) ? asset('storage/brand-page/banner-image/' . $brand->brandPage->banner_image) : asset('frontend/images/no-banner(1920-330).png') }}"
                alt="">
    </div>
</section>
{{-- <div class="swiper bannerSwiper product-banner">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="{{ !empty($brand->brandPage->banner_image) && file_exists(public_path('storage/brand-page/banner-image/' . $brand->brandPage->banner_image)) ? asset('storage/brand-page/banner-image/' . $brand->brandPage->banner_image) : asset('frontend/images/no-banner(1920-330).png') }}"
                alt="">
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div> --}}
{{-- <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumbs">
                <div>
                    <a href="index.html" class="">Home page</a> &gt;
                    <span class="txt-mcl active"> Handling - Logistics</span> &gt;
                    <span class="txt-mcl active"> Conveying</span> &gt;
                    <span class="txt-mcl active"> Robot transfer system</span>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<section class="header d-lg-block d-sm-none" id="myHeader">
    <div class="container brand-page-header-container ">
        <!-- Tabbing Section Start -->
        <div class="mb-4 bg-white row align-items-center header" id="myHeader">
            <div class="col-lg-2 col-sm-12">
                {{-- <img id="stand-logo"
                    src="{{ !empty($brand->logo) && file_exists(public_path('storage/brand/logo/' . $brand->logo)) ? asset('storage/brand/logo/' . $brand->logo) : asset('backend/images/no-image-available.png') }}"
                    class="img-fluid" /> --}}
                <div class="d-flex justify-content-around align-items-center">
                    <a href="{{ route('brand.overview', $brand->slug) }}">
                        <img id="stand-logo" class="img-fluid" height=""
                            src="{{ !empty($brand->brandPage->brand_logo) && file_exists(public_path('storage/brand-page/logo/' . $brand->brandPage->brand_logo)) ? asset('storage/brand-page/logo/' . $brand->brandPage->brand_logo) : asset('frontend/images/no-banner(1920-330).png') }}"
                            alt="{{ $brand->title }} - logo">
                    </a>
                    {{-- <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <img class="img-fluid custom-video-icon"
                            src="http://ngenitltd.com/frontend/images/no-video-icon.png" alt=""> </a> --}}
                </div>
            </div>
            <div class="col-lg-10 col-sm-12">
                <ul class="pt-0 pt-lg-4 ps-0 ps-lg-3 d-flex justify-content-start align-items-center product-tabbing-menu stand-header-nav">
                    <li>
                        <a href="{{ route('brand.overview', $brand->slug) }}"
                            class="{{ Route::current()->getName() == 'brand.overview' ? 'product-tabbing-menu-active' : '' }}">Company</a>
                    </li>
                    <li><a href="{{ route('brand.products', $brand->slug) }}"
                            class="{{ Route::current()->getName() == 'brand.products' ? 'product-tabbing-menu-active' : '' }}">Products</a>
                    </li>
                    <li>
                        <a href="{{ route('brand.pdf', $brand->slug) }}"
                            class="{{ Route::current()->getName() == 'brand.pdf' ? 'product-tabbing-menu-active' : '' }}">Catalogs</a>
                    </li>
                    <li><a href="{{ route('brand.content', $brand->slug) }}"
                            class="{{ Route::current()->getName() == 'brand.content' ? 'product-tabbing-menu-active' : '' }}">News
                            & Trends</a></li>
                    {{-- <li><a href="{{ route('brand.') }}">Exhibitions</a></li> --}}
                </ul>
            </div>
        </div>
        <!-- Tabbing Section End -->
    </div>
</section>

<section class="header d-lg-none d-sm-block" id="mobileHeader">
    <div class="container mobile-brand-page-header-container">
        <div class="row d-lg-flex align-items-center">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <img id="stand-logo" class="img-fluid" height=""
                            src="{{ !empty($brand->brandPage->brand_logo) && file_exists(public_path('storage/brand-page/logo/' . $brand->brandPage->brand_logo)) ? asset('storage/brand-page/logo/' . $brand->brandPage->brand_logo) : asset('frontend/images/no-banner(1920-330).png') }}"
                            alt="{{ $brand->title }} - logo">
                    </div>
                    <div>
                        <a href="#" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <?php
                            if (isset($href) && !empty($href)) {
                                echo '<img class="img-fluid custom-video-icon" src="' . asset('frontend/images/video-icon.png') . '" alt="">';
                            } else {
                                echo '<img class="img-fluid custom-video-icon" src="' . asset('frontend/images/no-video-icon.png') . '" alt="">';
                            }
                            ?>
                        </a>
                    </div>
                </div>
                <div>
                    <div>
                        <ul class="d-flex align-items-center justify-content-center">
                            <li class="px-1">
                                <a class="{{ Route::current()->getName() == 'brand.overview' ? 'active-brands' : '' }}"
                                    href="{{ route('brand.overview', $brand->slug) }}">Overview</a>
                            </li>
                            <li class="px-1">
                                <a class="{{ in_array(Route::currentRouteName(), ['brand.products', 'product.details']) ? 'active-brands' : '' }}"
                                    href="{{ route('brand.products', $brand->slug) }}">Products</a>
                            </li>


                            <li class="px-1">
                                <a class="{{ Route::current()->getName() == 'brand.pdf' ? 'active-brands' : '' }}"
                                    href="{{ route('brand.pdf', $brand->slug) }}">Catalogs</a>
                            </li>

                            <li class="px-1">
                                <a class="{{ Route::current()->getName() == 'brand.content' ? 'active-brands' : '' }}"
                                    href="{{ route('brand.content', $brand->slug) }}">Contents</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var isMobile = window.innerWidth <= 768; // Adjust the threshold as needed

        var header, container, sticky;

        if (isMobile) {
            header = document.getElementById("mobileHeader");
            mainHeader = document.querySelector(".main_header");
            container = document.querySelector(".mobile-brand-page-header-container");
            sticky = header.offsetTop;
        } else {
            header = document.getElementById("myHeader");
            mainHeader = document.querySelector(".main_header");
            container = document.querySelector(".brand-page-header-container");
            sticky = header.offsetTop;
        }

        window.onscroll = function() {
            handleScroll(header, container, sticky);
        };

        function handleScroll(header, container, sticky) {
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky-header");
                container.classList.remove("container");
                mainHeader.classList.remove("fixed-top");
                container.classList.add("container-fluid");
            } else {
                mainHeader.classList.add("fixed-top");
                header.classList.remove("sticky-header");
                container.classList.remove("container-fluid");
                container.classList.add("container");
            }
        }
        // const threshold = 20; // Adjust the threshold value as needed

        // function handleScroll(header, container, sticky) {
        //     if (window.pageYOffset > threshold) {
        //         // Scrolled past the threshold, add sticky styles
        //         header.classList.add("sticky-header");
        //         container.classList.remove("container");
        //         mainHeader.classList.remove("fixed-top");
        //         container.classList.add("container-fluid");
        //     } else {
        //         // Not necessarily scrolled past the threshold, but user has started scrolling
        //         header.classList.add("sticky-header");
        //         container.classList.remove("container");
        //         mainHeader.classList.remove("fixed-top");
        //         container.classList.add("container-fluid");
        //     }
        // }
    });
</script>
