<!-- Top Bar Start -->
<section class="fixed-top main_header">
    <div class="container-fluid d-sm-none d-md-block" style="background-color: var(--secondary-deep-color)">
        <div class="text-white row top-bar" style="background-color: var(--secondary-color)">
            <div class="empty-area"
                style="background-color: var(--secondary-deep-color);
          clip-path: polygon(0 0, 96% 0%, 100% 120%, 0% 100%);">
            </div>
            <div class="fill-area ps-0" style="background-color: var(--secondary-color)">
                <div class="container ps-0">
                    <div class="row ps-0">
                        <div class="col-lg-12 ps-0">
                            <div class="px-1 d-flex justify-content-end align-items-center">

                                <!-- My Techfocus -->
                                <div class="popover__wrapper">
                                    <a href="#">
                                        <h2 class="mb-1 popover__title fw-bold" data-aos="fade-left">
                                            <span>
                                                <i class="fa-solid fa-star-of-life"></i>
                                                <span class="p-0 m-0" style="color: var(--primary-color)">My</span>
                                                Techfocus
                                            </span>
                                        </h2>
                                    </a>
                                    <div class="popover__content text-start">
                                        @auth
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="mb-2 btn signin rounded-0">Log Out</button>
                                        </form>
                                        @else
                                        <div>
                                            <div class="mb-2 text-muted">
                                                Login As:
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <!-- Client Login/Register -->
                                            <a href="{{ route('login') }}" class="mb-2 btn signin rounded-0 me-2">Client</a>
                                            <!-- Partner Login/Register -->
                                            <a href="{{ route('partner.login') }}" class="mb-2 btn signin rounded-0">Partner</a>

                                            @endauth
                                        </div>
                                        <div class="text-muted">
                                            First time here?
                                            <a href="{{ route('register') }}" class="main-color">
                                                Sign Up</a>
                                            <a href="{{ route('principal.login') }}" class="btn btn-primary">Login as Principal</a>
                                            <a href="{{ route('principal.register') }}" class="btn btn-success">Register as Principal</a>
                                        </div>

                                        <!-- Partner Login/Register -->



                                        <hr class="text-muted" />
                                        <ul class="p-0 account text-muted text-start">
                                            <li>
                                                <i class="m-2 fa fa-user"></i>
                                                <a href="{{ route('client.profile') }}" class="">My Profile</a>
                                            </li>
                                            <li>
                                                <i class="m-2 fa fa-envelope"></i>
                                                <a href="{{ route('client.subscription') }}" class="">My
                                                    Subscriptions</a>
                                            </li>
                                            <li>
                                                <i class="m-2 fa fa-star"></i>
                                                <a href="{{ route('client.favourites') }}" class="">My
                                                    Favorites</a>
                                            </li>
                                            <li>
                                                <i class="m-2 fa fa-list"></i>
                                                <a href="{{ route('client.requests') }}" class="">My Requests</a>
                                            </li>
                                        </ul>
                                        <!-- <hr class="text-muted" />
                                        <ul class="p-0 account text-muted text-start" style="font-size: 7px">
                                            <li>
                                                Sign in to your manufacturer account
                                                <a target="_blank" class="main-color">Manufacturer account</a>
                                            </li>
                                            <li>
                                                Sign in to your distributor account
                                                <a target="_blank" class="main-color">Distributor account</a>
                                            </li>
                                        </ul> -->
                                    </div>
                                </div>
                                <!-- RFQ Link -->
                                <div class="mx-4" data-aos="fade-left">
                                    <a class="nav-link custom-nav" data-aos="fade-right" href="{{ route('rfq') }}">
                                        RFQ
                                    </a>
                                </div>

                                <!--  -->
                                {{-- <div class="dropdown">
                                    <button class="mx-3 dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false" data-aos="fade-left">
                                        EUR - €
                                    </button>
                                    <ul class="dropdown-menu extra-dropdown" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item top-dropdown" href="#">USD - $</a></li>
                                        <li><a class="dropdown-item top-dropdown" href="#">EUR - €</a></li>
                                        <li><a class="dropdown-item top-dropdown" href="#">GBP - £</a></li>
                                        <li><a class="dropdown-item top-dropdown" href="#">JPY - ¥</a></li>
                                        <li><a class="dropdown-item top-dropdown" href="#">INR - ₹</a></li>
                                    </ul>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Bar End -->
    <nav class="px-3 navbar navbar-expand-lg navbar-dark main-menu">
        <div class="container-fluid">
            <!-- Logo Start -->
            <a class="mb-0 navbar-brand" href="{{ route('homepage') }}" data-aos="fade-right">
                <img src="{{ !empty($site->system_logo_white) && file_exists(public_path('storage/webSetting/systemLogoWhite/' . $site->system_logo_white)) ? asset('storage/webSetting/systemLogoWhite/' . $site->system_logo_white) : asset('backend/images/no-image-available.png') }}"
                    height="60px" alt="TechFocus" />
            </a>
            <!-- Logo End -->

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link custom-nav dropdown-toggle" href="#" id="navbarDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            data-aos="fade-right">
                            Product
                        </a>
                        <div class="dropdown-menu menu-dropdown" aria-labelledby="navbarDropdown">
                            <div class="container">
                                <div class="my-5 row gx-3">
                                    <div class="col-lg-3">
                                        <div>
                                            <img class="img-fluid header-side-banner"
                                                src="https://www.kuka.com/-/media/kuka-corporate/images/ir/mitteilungen.jpg?rev=1b1c6d88287d493c9d06716764767b38&w=767&hash=D675CCDCE6BAF6450C5DB2F986F22751"
                                                alt="">
                                            <h5 class="pt-3">Products</h5>
                                            <p>Get an overview on the entire KUKA portfolio from industrial robots to
                                                complete production lines.</p>
                                            <div>
                                                <a href="" class="main-color">
                                                    Learn More <i class="fa-solid fa-chevron-right ps-1 font-one"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="row gx-2">
                                            <div class="col-lg-4 first-column column-transition">
                                                <div class="column-header">
                                                    <div class="pt-0">
                                                        <a href="#" class="">Industries</a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="expand-column-first"
                                                            onclick="toggleColumn('second-column')">Case Studies
                                                            <i class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="">Automative Industry</a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="expand-column-first"
                                                            onclick="toggleColumn('second-column')">Automated
                                                            House
                                                            Building<i
                                                                class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="expand-column-first"
                                                            onclick="toggleColumn('second-column')">Electronic
                                                            Industries<i
                                                                class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="expand-column-first"
                                                            onclick="toggleColumn('second-column')">Ecommerce &
                                                            Logistic
                                                            Service<i
                                                                class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="expand-column-first"
                                                            onclick="toggleColumn('second-column')">Helth Care<i
                                                                class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="expand-column-first"
                                                            onclick="toggleColumn('second-column')">Consumer
                                                            Goods
                                                            Industries<i
                                                                class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="">Metal Industires<i
                                                                class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 second-column column-transition"
                                                style="display: none;">
                                                <div class="column-header"
                                                    style="border-left: 1px solid var(--border-color)">
                                                    <div class="ps-3">
                                                        <div class="pt-0">
                                                            <a href="#" class="">Helthcare</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="expand-column-second"
                                                                onclick="toggleColumn('third-column')">Robots In
                                                                The
                                                                Medical Industry<i
                                                                    class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">3D Virdtual Showroom</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">Team And Service</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">3D Virdtual Showroom</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="expand-column-second"
                                                                onclick="toggleColumn('third-column')">Current
                                                                Topics<i
                                                                    class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">Swisslog Helthcare</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="expand-column-second"
                                                                onclick="toggleColumn('third-column')">Downloads<i
                                                                    class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 third-column column-transition"
                                                style="display: none;">
                                                <div class="column-header"
                                                    style="border-left: 1px solid var(--border-color)">
                                                    <div class="ps-3">
                                                        <div class="pt-4">
                                                            <a href="#" class="">3D Virdtual Showroom</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">Team And Service</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">4D Virdtual Showroom</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">5D Virdtual Showroom</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">6D Virdtual Showroom</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">7D Virdtual Showroom</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link custom-nav" data-aos="fade-right"
                            href="{{ route('homepage') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav" data-aos="fade-right"
                            href="{{ route('catalog.all') }}">Catalog</a>
                    </li>
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link custom-nav dropdown-toggle" href="news-trends.html" id="navbarDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            data-aos="fade-right">
                            News & Trends
                        </a>
                        <div class="dropdown-menu menu-dropdown" aria-labelledby="navbarDropdown">
                            <div class="container">
                                <div class="my-5 row gx-3">
                                    <div class="col-lg-3">
                                        <div>
                                            <img class="img-fluid header-side-banner"
                                                src="https://www.kuka.com/-/media/kuka-corporate/images/ir/mitteilungen.jpg?rev=1b1c6d88287d493c9d06716764767b38&w=767&hash=D675CCDCE6BAF6450C5DB2F986F22751"
                                                alt="">
                                            <h5 class="pt-3">Products</h5>
                                            <p>Get an overview on the entire KUKA portfolio from industrial robots to
                                                complete production lines.</p>
                                            <div>
                                                <a href="" class="main-color">
                                                    Learn More <i class="fa-solid fa-chevron-right ps-1 font-one"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="row gx-2">
                                            <div class="col-lg-4 first-column column-transition">
                                                <div class="column-header">
                                                    <div class="pt-0">
                                                        <a href="#" class="">Industries</a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="expand-column-first"
                                                            onclick="toggleColumn('second-column')">Case Studies
                                                            <i class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="">Automative Industry</a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="expand-column-first"
                                                            onclick="toggleColumn('second-column')">Automated
                                                            House
                                                            Building<i
                                                                class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="expand-column-first"
                                                            onclick="toggleColumn('second-column')">Electronic
                                                            Industries<i
                                                                class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="expand-column-first"
                                                            onclick="toggleColumn('second-column')">Ecommerce &
                                                            Logistic
                                                            Service<i
                                                                class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="expand-column-first"
                                                            onclick="toggleColumn('second-column')">Helth Care<i
                                                                class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="expand-column-first"
                                                            onclick="toggleColumn('second-column')">Consumer
                                                            Goods
                                                            Industries<i
                                                                class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                    <div class="pt-4">
                                                        <a href="#" class="">Metal Industires<i
                                                                class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 second-column column-transition"
                                                style="display: none;">
                                                <div class="column-header"
                                                    style="border-left: 1px solid var(--border-color)">
                                                    <div class="ps-3">
                                                        <div class="pt-0">
                                                            <a href="#" class="">Helthcare</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="expand-column-second"
                                                                onclick="toggleColumn('third-column')">Robots In
                                                                The
                                                                Medical Industry<i
                                                                    class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">3D Virdtual Showroom</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">Team And Service</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">3D Virdtual Showroom</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="expand-column-second"
                                                                onclick="toggleColumn('third-column')">Current
                                                                Topics<i
                                                                    class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">Swisslog Helthcare</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="expand-column-second"
                                                                onclick="toggleColumn('third-column')">Downloads<i
                                                                    class="fa-solid fa-chevron-right font-one ps-2"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 third-column column-transition"
                                                style="display: none;">
                                                <div class="column-header"
                                                    style="border-left: 1px solid var(--border-color)">
                                                    <div class="ps-3">
                                                        <div class="pt-4">
                                                            <a href="#" class="">3D Virdtual Showroom</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">Team And Service</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">4D Virdtual Showroom</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">5D Virdtual Showroom</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">6D Virdtual Showroom</a>
                                                        </div>
                                                        <div class="pt-4">
                                                            <a href="#" class="">7D Virdtual Showroom</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link custom-nav" data-aos="fade-right" href="{{ route('rfq') }}">RFQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>
                <!-- Search Box Start -->
                <!-- Search Box Start -->
                <div class="ms-auto">
                    <form action="{{ route('search.products') }}" method="GET" class="d-flex">
                        <!-- Input field -->
                        <input type="text" name="q" class="form-control me-2 border-primary text-primary" placeholder="Search products..." required>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>


                <!-- Search Box End -->
                <!-- Search Box End -->
            </div>
        </div>
    </nav>
</section>

<section class="fixed-top mobile_header">
    <div class="container px-0">
        <div class="mobile_top_bar">
            <div class="px-1 d-flex justify-content-end align-items-center" data-aos="fade-right">
                <div class="dropdown">
                    <button class="dropdown-toggle me-4" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false" data-aos="fade-left">
                        English
                    </button>
                    <ul class="dropdown-menu extra-dropdown" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a class="dropdown-item top-dropdown" href="#">English</a>
                        </li>
                        <li>
                            <a class="dropdown-item top-dropdown" href="#">France</a>
                        </li>
                        <li>
                            <a class="dropdown-item top-dropdown" href="#">Spanish</a>
                        </li>
                        <li>
                            <a class="dropdown-item top-dropdown" href="#">German</a>
                        </li>
                        <li>
                            <a class="dropdown-item top-dropdown" href="#">Russian</a>
                        </li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="dropdown-toggle me-3" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false" data-aos="fade-left">
                        EUR - €
                    </button>
                    <ul class="dropdown-menu extra-dropdown" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a class="dropdown-item top-dropdown" href="#">English</a>
                        </li>
                        <li>
                            <a class="dropdown-item top-dropdown" href="#">France</a>
                        </li>
                        <li>
                            <a class="dropdown-item top-dropdown" href="#">Spanish</a>
                        </li>
                        <li>
                            <a class="dropdown-item top-dropdown" href="#">German</a>
                        </li>
                        <li>
                            <a class="dropdown-item top-dropdown" href="#">Russian</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="popover__wrapper me-5" data-aos="fade-left">
                <a href="#">
                    <h2 class="mb-1 popover__title fw-bold" data-aos="fade-left">
                        <span>
                            <i class="fa-solid fa-star-of-life"></i>
                            <span class="p-0 m-0" style="color: var(--primary-color)">My</span>
                            Techfocus
                        </span>
                    </h2>
                </a>
                <div class="popover__content text-start">
                    @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mb-2 btn signin rounded-0">Log Out</button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="mb-2 btn signin rounded-0">Log In</a>
                    <div class="text-muted">
                        First time here?
                        <a href="{{ route('register') }}" class="main-color">Sign Up</a>
                    </div>
                    @endauth
                    <hr class="text-muted" />
                    <ul class="p-0 account text-muted text-start">
                        <li>
                            <i class="m-2 fa fa-user"></i>
                            <a href="{{ route('client.profile') }}" class="">My Profile</a>
                        </li>
                        <li>
                            <i class="m-2 fa fa-envelope"></i>
                            <a href="{{ route('client.subscription') }}" class="">My
                                Subscriptions</a>
                        </li>
                        <li>
                            <i class="m-2 fa fa-star"></i>
                            <a href="{{ route('favorites.index') }}" class="">My Favorites</a>
                        </li>
                        <li>
                            <i class="m-2 fa fa-list"></i>
                            <a href="{{ route('client.requests') }}" class="">My Requests</a>
                        </li>
                    </ul>
                    <hr class="text-muted" />
                    <ul class="p-0 account text-muted text-start" style="font-size: 7px">
                        <li>
                            Sign in to your manufacturer account
                            <a target="_blank" class="main-color">Manufacturer account</a>
                        </li>
                        <li>
                            Sign in to your distributor account
                            <a target="_blank" class="main-color">Distributor account</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mobile_nav_bar">
            <div class="text-start">
                <a class="mb-0 navbar-brand" href="{{ route('homepage') }}" data-aos="fade-right">
                    <img src="{{ !empty($site->system_logo_white) && file_exists(public_path('storage/webSetting/systemLogoWhite/' . $site->system_logo_white)) ? asset('storage/webSetting/systemLogoWhite/' . $site->system_logo_white) : asset('backend/images/no-image-available.png') }}"
                        height="60px" alt="TechFocus" style="margin: 7px 6px;" />
                </a>
            </div>
            <div data-aos="fade-left">
                <!-- Mobile Menu -->
                <div class="d-flex align-items-center">
                    <div>
                        <input type="checkbox" id="menyAvPaa" />
                        <label id="burger" for="menyAvPaa">
                            <div></div>
                            <div></div>
                            <div></div>
                        </label>
                        <nav id="meny">
                            <div class="" style="z-index: 9999; padding-top: 1rem; padding-left: 28rem;">
                                <!--Mobile Head -->
                                <p class="text-danger">
                                    <a class="navbar-brand" href="{{ route('homepage') }}">
                                        <img src="{{ !empty($site->system_logo_white) && file_exists(public_path('storage/webSetting/systemLogoWhite/' . $site->system_logo_white)) ? asset('storage/webSetting/systemLogoWhite/' . $site->system_logo_white) : asset('backend/images/no-image-available.png') }}"
                                            width="200px" height="60px" alt="TechFocus">
                                    </a>
                                </p>
                                <!-- Mobile Menu -->
                                <ul class="navbar-nav ms-auto">
                                    <li class="nav-item dropdown" data-aos="fade-right" data-aos-duration="500">
                                        <a class="nav-link custom-nav dropdown-toggle" href="#"
                                            id="navbarDropdown" role="button" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            Product
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <span class="text-white text-uppercase">Category 1</span>
                                                        <ul class="nav flex-column">
                                                            <li class="nav-item">
                                                                <a class="nav-link custom-nav active"
                                                                    href="#">Active</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link custom-nav" href="#">Link
                                                                    item</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link custom-nav" href="#">Link
                                                                    item</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /.col-md-4  -->
                                                    <div class="col-md-4">
                                                        <ul class="nav flex-column">
                                                            <li class="nav-item">
                                                                <a class="nav-link custom-nav active"
                                                                    href="#">Active</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link custom-nav" href="#">Link
                                                                    item</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link custom-nav" href="#">Link
                                                                    item</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /.col-md-4  -->
                                                    <div class="col-md-4">
                                                        <a target="_blank"
                                                            href="#resources/a-beginners-guide-to-hubspot-cms/">
                                                            <img src="https://i0.wp.com/bootstrapcreative.com/wp-bc/wp-content/uploads/2022/07/beginners-guide-to-hubspot-cms-cover.png?w=200&ssl=1"
                                                                alt="Web Design Guides" class="img-fluid" />
                                                        </a>
                                                        <p class="text-white">Get Free Guides</p>
                                                    </div>
                                                    <!-- /.col-md-4  -->
                                                </div>
                                            </div>
                                            <!--  /.container  -->
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link custom-nav" href="{{ route('catalog.all') }}">Catalog</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link custom-nav" href="{{ route('rfq') }}">RFQ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link custom-nav" href="{{ route('contact') }}">Contact Us</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link custom-nav dropdown-toggle" href="news-trends.html"
                                            id="navbarDropdown" role="button" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            News & Trends
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <span class="text-white text-uppercase">Category 2</span>
                                                        <ul class="nav flex-column">
                                                            <li class="nav-item">
                                                                <a class="nav-link custom-nav active"
                                                                    href="#">Active</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link custom-nav" href="#">Link
                                                                    item</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link custom-nav" href="#">Link
                                                                    item</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /.col-md-4  -->
                                                    <div class="col-md-4">
                                                        <ul class="nav flex-column">
                                                            <li class="nav-item">
                                                                <a class="nav-link custom-nav active"
                                                                    href="#">Active</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link custom-nav" href="#">Link
                                                                    item</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link custom-nav" href="#">Link
                                                                    item</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /.col-md-4  -->
                                                    <div class="col-md-4">
                                                        <a target="_blank" href="#shop/jake-portfolio-hubspot-theme/">
                                                            <img src="https://i0.wp.com/bootstrapcreative.com/wp-bc/wp-content/uploads/2022/01/jake-portfolio-cover.jpg?w=200&ssl=1"
                                                                alt="Portfolio Website Templates" class="img-fluid" />
                                                        </a>
                                                        <p class="text-white">
                                                            Create a Portfolio Website Fast
                                                        </p>
                                                    </div>
                                                    <!-- /.col-md-4  -->
                                                </div>
                                            </div>
                                            <!--  /.container  -->
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link custom-nav" href="#">E-Magazine</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>

                </div>
                <!-- Mobile Menu End-->
            </div>
        </div>
    </div>
</section>



<script>
    function toggleColumn(columnClassName, linkElement) {
        var column = document.querySelector('.' + columnClassName);
        var columnHeader = column.querySelector('.column-header');

        // Toggle the 'column-transition' class to enable transitions
        column.classList.toggle('column-transition');

        if (column.style.display === 'none' || column.style.display === '') {
            column.style.display = 'block';
            columnHeader.classList.add('active');
        } else {
            column.style.display = 'none';
            columnHeader.classList.remove('active');
        }

        // Remove 'active' class from all other links
        document.querySelectorAll('.column-header a').forEach(function(el) {
            if (el !== linkElement) {
                el.parentElement.classList.remove('active');
            }
        });
    }
</script>

<script>
    // Get the button and all dropdown items
    const currencyButton = document.getElementById('dropdownMenuButton1');
    const currencyItems = document.querySelectorAll('.dropdown-item.top-dropdown');

    currencyItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default link behavior
            currencyButton.textContent = this.textContent; // Update button text
        });
    });
</script>