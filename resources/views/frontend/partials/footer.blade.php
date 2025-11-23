<!-- TOP FOOTER SECTION -->
<div class="container-fluid" style="background-color: var(--secondary-color)">
    <div class="container text-white" style="font-size: 14px">
        <div class="row align-items-center">

            <div class="p-4 text-center col-lg-2 border-left-side">
                <a href="{{ route('rfq') }}">Send RFQ</a>
            </div>

            <div class="p-4 text-center col-lg-2 border-left-side">
                <a href="{{ route('exhibit') }}">Exhibit With Us</a>
            </div>

            <div class="p-4 text-center col-lg-2 border-left-side">
                <a href="{{ route('faq') }}">FAQ</a>
            </div>

            <div class="p-4 col-lg-3 d-flex justify-content-between align-items-center social-area">
                <ul class="p-0 m-0 list-unstyled">
                    <li class="pt-2"><a href="{{ route('brand.list') }}">Our Brands</a></li>
                    <li class="pt-2"><a href="{{ route('about') }}">About Us</a></li>
                    <li class="pt-2"><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
            </div>

            <div class="col-lg-3">
                <div class="social-icons-btn d-flex justify-content-end">
                    <a class="icons twitter" href="https://www.x.com/ngenit"><i class="fa-brands fa-twitter"></i></a>
                    <a class="icons facebook" href="https://www.facebook.com/ngenitltd/"><i class="fa-brands fa-facebook-f"></i></a>
                    <a class="icons instagram" href="https://www.instagram.com/ngenitltd"><i class="fa-brands fa-instagram"></i></a>
                    <a class="icons linkedin" href="https://www.linkedin.com/company/ngenitltd/"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- LOGO + BRAND STRIP -->
<div class="container-fluid" style="background-color: var(--secondary-deep-color)">
    <div class="container footer-logo">

        <!-- Logo Section -->
        <div class="pt-5 pb-4 row"> <!-- Added pb-4 here -->
            <div class="col-lg-12 d-flex justify-content-center align-items-center">

                @php
                    $brandLogos = [
                        '/img/TechFocusLogo/agro.png',
                        '/img/TechFocusLogo/aviation.png',
                        '/img/TechFocusLogo/medical.png',
                        '/img/TechFocusLogo/nautic.png',
                        '/img/TechFocusLogo/robotics.png',
                    ];
                @endphp

                <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">

                    <a href="{{ route('homepage') }}" class="border-left-side pe-lg-3">
                        <img src="{{ !empty($site->system_logo_white) && file_exists(public_path('storage/webSetting/systemLogoWhite/' . $site->system_logo_white)) 
                            ? asset('storage/webSetting/systemLogoWhite/' . $site->system_logo_white) 
                            : asset('https://www.techfocusltd.com/storage/webSetting/systemLogoWhite/Tech-Focus_Rl8twpWh.png') }}"
                            style="width: 300px;" alt="Main Logo" />
                    </a>

                    @foreach($brandLogos as $logo)
                        <a href="#">
                            <img src="{{ $logo }}" style="width: 150px;" alt="Brand Logo"
                                 onerror="this.onerror=null; this.src='{{ asset('https://www.techfocusltd.com/storage/webSetting/systemLogoWhite/Tech-Focus_Rl8twpWh.png') }}';">
                        </a>
                    @endforeach

                </div>

            </div>
        </div>

        <!-- Legal + Copyright -->
        <div class="pt-4 pb-4 row"> <!-- Added pt-4 here -->
            <div class="col-12 d-flex justify-content-between align-items-center flex-wrap text-white">

                <div class="small mb-2">
                    © 2025 All rights reserved {{ $site->site_name ?? 'Techfocus LTD' }}
                </div>

                <ul class="d-flex gap-4 list-unstyled mb-2">
                    <li><a class="text-white" href="{{ route('terms') }}">Terms & Conditions</a></li>
                    <li><a class="text-white" href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                    <li><a class="text-white" href="{{ route('manage.cookies') }}">Manage Cookies</a></li>
                </ul>

            </div>
        </div>

    </div>
</div>
