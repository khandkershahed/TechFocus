<div class="swiper bannerSwiper product-banner">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="https://img.directindustry.com/images_di/bnr/16788/hd/55424v2.jpg" class="img-fluid" alt="" />
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div>
<div class="container">
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
</div>
<div class="container sticky-top">
    <!-- Tabbing Section Start -->
    <div class="row bg-white mb-4 p-3 align-items-center shadow-lg header" id="myHeader">
        <div class="col-lg-3">
            <img src="{{ !empty($brand->logo) && file_exists(public_path('storage/brand/logo/' . $brand->logo)) ? asset('storage/brand/logo/' . $brand->logo) : asset('backend/images/no-image-available.png') }}"
                class="img-fluid" />
        </div>
        <div class="col-lg-9">
            <ul class="d-flex justify-content-around pt-4 product-tabbing-menu">
                <li>
                    <a href="{{ route('brand.overview',$brand->slug) }}"
                        class="{{ Route::current()->getName() == 'brand.overview' ? 'product-tabbing-menu-active' : '' }}">Company</a>
                </li>
                <li><a href="{{ route('brand.products',$brand->slug) }}"
                        class="{{ Route::current()->getName() == 'brand.products' ? 'product-tabbing-menu-active' : '' }}">Products</a>
                </li>
                <li>
                    <a href="{{ route('brand.pdf',$brand->slug) }}"
                        class="{{ Route::current()->getName() == 'brand.pdf' ? 'product-tabbing-menu-active' : '' }}">Catalogs</a>
                </li>
                <li><a href="{{ route('brand.content',$brand->slug) }}"
                        class="{{ Route::current()->getName() == 'brand.content' ? 'product-tabbing-menu-active' : '' }}">News
                        & Trends</a></li>
                {{-- <li><a href="{{ route('brand.') }}">Exhibitions</a></li> --}}
            </ul>
        </div>
    </div>
    <!-- Tabbing Section End -->
</div>