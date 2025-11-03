<div class="container-fluid" style="background-color: var(--secondary-color)">
    <div class="container text-white" style="font-size: 14px">
        <div class="row align-items-center">
            <div class="p-4 text-center col-lg-2 text-lg-start border-left-side">
                <div>
                    <a href="{{ route('buying.guide') }}">Send RFQ </a>
                </div>
            </div>
            <div class="p-4 text-center col-lg-2 border-left-side">
                <div>
                    <a href="{{ route('exhibit') }}">Exhibit With Us </a>
                </div>
            </div>
            <div class="p-4 text-center col-lg-2 border-left-side">
                <div>
                    <a href="{{route('faq')}}">FAQ </a>
                </div>
            </div>
            <div class="p-4 text-center col-lg-2 border-left-side">
                <div>
                    <a href="{{route('about')}}">About Us</a>
                </div>
            </div>
            <div class="p-4 col-lg-4 d-flex justify-content-between align-items-center social-area">
                <ul class="">
                    <li class="pt-2">
                        <a href="{{route('brand.list')}}">Our Brands</a>
                    </li>
                    <!-- <li class="pt-2">
                        <a href="{{ route('manufacturer.account') }}"> Manufacturer account</a>
                    </li> -->
                    <!-- <li class="pt-2">
                        <a href="{{route('service')}}"> Our Service</a>
                    </li> -->
                    <!-- <li class="pt-2">
                        <a href="{{route('subscription')}}"> Subscriptions</a>
                    </li> -->
                </ul>
                <div class="social-icons-btn">
                    <a class="icons twitter" href="https://www.x.com/ngenit">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a class="icons facebook" href="https://www.facebook.com/ngenitltd/">
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
                '/frontend/images/NG IT Logo-01.png',
                '/frontend/images/NG IT Logo-01.png',
                '/frontend/images/NG IT Logo-01.png',
                '/frontend/images/NG IT Logo-01.png',
                ];
                @endphp
                <div class="d-flex justify-content-center align-items-center">
                    <a href="{{ route('homepage') }}" class="border-left-side pe-lg-3">
                        <img src="{{ !empty($site->system_logo_white) && file_exists(public_path('storage/webSetting/systemLogoWhite/' . $site->system_logo_white)) ? asset('storage/webSetting/systemLogoWhite/' . $site->system_logo_white) : asset('https://www.techfocusltd.com/storage/webSetting/systemLogoWhite/Tech-Focus_Rl8twpWh.png') }}"
                            style="width: 400px;" class="me-3" alt="" />
                    </a>
                    @foreach($brandLogos as $logo)
                    <a href="#" class="mb-3 me-4 ms-5">
                        <img src="{{ $logo }}"
                            width="200px"
                            alt="Brand Logo"
                            onerror="this.onerror=null; this.src='{{ asset('https://www.techfocusltd.com/storage/webSetting/systemLogoWhite/Tech-Focus_Rl8twpWh.png') }}';">
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
        <div class="pt-5 mt-5 row">
            <div class="text-white col-lg-6">
                <a href="{{ route('homepage') }}">
                    <p class="text-start">© 2025 All rights reserved {{ $site->site_name ?? "Techfocus LTD"}}</p>
                </a>
            </div>
            <div class="text-center col-lg-6 footer-bottom-menu text-lg-end">
                <ul class="flex-wrap gap-3 p-0 m-0 footer-links list-unstyled d-inline-flex">
                    <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Manage Cookies</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>