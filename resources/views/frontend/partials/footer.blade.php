<div class="container-fluid" style="background-color: var(--secondary-color)">
    <div class="container text-white" style="font-size: 14px">
        <div class="row align-items-center">
            <div class="p-4 text-center col-lg-3 text-lg-start border-left-side">
                <div>
                    <a href="{{ route('buying.guide') }}">HOW TO BUY PRODUCTS </a>
                </div>
            </div>
            <div class="p-4 text-center col-lg-2 border-left-side">
                <div>
                    <a href="{{ route('exhibit') }}">EXHIBIT WITH US </a>
                </div>
            </div>
            <div class="p-4 text-center col-lg-2 border-left-side">
                <div>
                    <a href="{{route('faq')}}">FAQ </a>
                </div>
            </div>
            <div class="p-4 col-lg-5 d-flex justify-content-between align-items-center social-area">
                <ul class="">
                    <li class="pt-2">
                        <a href="{{route('brand.list')}}">Brand list</a>
                    </li>
                    <li class="pt-2">
                        <a href="{{ route('manufacturer.account') }}"> Manufacturer account</a>
                    </li>
                    <li class="pt-2">
                        <a href="{{route('service')}}"> Our Service</a>
                    </li>
                    <li class="pt-2">
                        <a href="{{route('subscription')}}"> Subscriptions</a>
                    </li>
                    <li class="pt-2">
                        <a href="{{route('about')}}">About Us</a>
                    </li>
                </ul>
                <div class="social-icons-btn">
                    <a class="icons twitter" href="https://www.x.com/ngenit
">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a class="icons facebook" href="https://www.facebook.com/share/1FZ8jpvcis/">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a class="icons instagram" href="https://www.instagram.com/ngenitltd">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a class="icons linkedin" href="https://www.linkedin.com/company/ngenitltd/">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" style="background-color: var(--secondary-deep-color)">
    <div class="container footer-logo">
        <div class="pt-5 row">
            <div class="col-lg-8 offset-lg-2 d-flex">
                @php
                $brandLogos = [
                'https://www.ngensoftware.com/storage/companyclient/logo/uUJbFPaf5J1759561216.png',
                'https://www.ngensoftware.com/storage/page-banner/logo/pINXJQPNZ11759560908.png',
                'https://www.ngensoftware.com/storage/page-banner/logo/8KEBk4kOj51759572777.png',
                'https://www.ngensoftware.com/storage/companyclient/logo/lPh0SvPTP91759561444.png',
                'https://www.ngensoftware.com/storage/page-banner/logo/mr48RIhQIJ1759560955.png',
                ];
                @endphp
                <div class="d-flex justify-content-center align-items-center">
                    <a href="{{ route('homepage') }}" class="border-left-side pe-lg-3">
                        <img src="{{ !empty($site->system_logo_white) && file_exists(public_path('storage/webSetting/systemLogoWhite/' . $site->system_logo_white)) ? asset('storage/webSetting/systemLogoWhite/' . $site->system_logo_white) : asset('backend/images/no-image-available.png') }}"
                            width="350px" class="me-3" alt="" />
                    </a>
                    @foreach($brandLogos as $logo)
                    <a href="#" class="mb-3 me-4">
                        <img src="{{ $logo }}"
                            width="300px"
                            alt="Brand Logo"
                            onerror="this.onerror=null; this.src='{{ asset('backend/images/no-image-available.png') }}';">
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="text-white col-lg-12 mt-lg-5 mb-lg-5">
                <p class="text-center">© 2025 All rights reserved</p>
                <ul class="d-flex justify-content-center ps-0">
                    <li>
                        <a href="{{route('terms')}}">Terms - </a>
                    </li>
                    <li>
                        <a href="privacy.html">Privacy Policy - </a>
                    </li>
                    <li>
                        <a href="{{route('terms')}}">General Terms - </a>
                    </li>
                    <li>
                        <a href="">Manage Cookies - </a>
                    </li>
                    <li>
                        <a href="distibutors.html">Distributors List </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>