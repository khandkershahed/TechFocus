<!-- Top Bar Start -->
<style>
    /* Change text color to white on hover and keep outline effect */
    .gap-2 a.btn:hover {
        color: #fff !important;
        background-color: #0d6efd;
        /* matches primary color of btn-outline-primary */
        border-color: #0d6efd;
        transition: all 0.3s ease;
    }
</style>
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
                            <div class="px-2 d-flex justify-content-end align-items-center">
                                <!-- My Techfocus -->
                                <div class="popover__wrapper me-4 position-relative">
                                    <a href="#" class="text-decoration-none">
                                        <h2 class="mb-1 popover__title fw-bold" data-aos="fade-left">
                                            <i class="fa-solid fa-star-of-life me-1"></i>
                                            <span class="text-primary">My</span> Techfocus
                                        </h2>
                                    </a>
                                    <div class="p-3 bg-white border rounded shadow-sm popover__content position-absolute end-0" style="min-width: 220px; z-index: 1000;">
                                        @auth
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="mb-2 btn btn-outline-primary w-100">Log Out</button>
                                        </form>
                                        @else
                                        <div class="mb-2 text-muted fw-medium">Login As:</div>
                                        <div class="gap-2 mb-3 d-flex flex-column">
                                            <a href="{{ route('login') }}" class="text-black btn btn-outline-primary w-100">Client</a>
                                            <a href="{{ route('partner.login') }}" class="text-black btn btn-outline-primary w-100">Partner</a>
                                            <a href="{{ route('principal.login') }}" class="text-black btn btn-outline-primary w-100">Principal</a>
                                        </div>
                                        <div class="text-muted small">
                                            <span class="">First time here?</span>
                                            <div>
                                                <a href="{{ route('register') }}" class="text-primary">Sign Up</a> or register as
                                                <a href="{{ route('principal.register') }}" class="text-primary">Principal</a>
                                            </div>
                                        </div>
                                        @endauth

                                        <hr class="my-3" />
                                        <ul class="m-0 list-unstyled text-muted">
                                            <li class="mb-2">
                                                <i class="fa fa-user me-2"></i>
                                                <a href="{{ route('client.profile') }}" class="text-decoration-none text-muted">My Profile</a>
                                            </li>
                                            <li class="mb-2">
                                                <i class="fa fa-envelope me-2"></i>
                                                <a href="{{ route('client.subscription') }}" class="text-decoration-none text-muted">My Subscriptions</a>
                                            </li>
                                            <li class="mb-2">
                                                <i class="fa fa-star me-2"></i>
                                                <a href="{{ route('client.favourites') }}" class="text-decoration-none text-muted">My Favorites</a>
                                            </li>
                                            <li>
                                                <i class="fa fa-list me-2"></i>
                                                <a href="{{ route('client.requests') }}" class="text-decoration-none text-muted">My Requests</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- RFQ Link -->
                                <div class="me-3" data-aos="fade-left">
                                    <a href="{{ route('rfq') }}" class="nav-link text-primary fw-semibold">RFQ</a>
                                </div>
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

                    <li class="nav-item">
                        <a class="nav-link custom-nav" data-aos="fade-right"
                            href="{{ route('homepage') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav" data-aos="fade-right"
                            href="{{ route('catalog.all') }}">Catalog</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link custom-nav" data-aos="fade-right" href="{{ route('rfq') }}">RFQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>
                <!-- Search Box Start -->
                <div class="ms-auto">
    <form action="{{ route('search.products') }}" method="GET" class="d-flex position-relative">
        <input 
            type="text" 
            name="q" 
            id="globalSearch"
            class="form-control me-2 border-primary text-primary"
            placeholder="Search products, brands, categories..." 
            autocomplete="off"
            required
        >
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
        </button>

        <div id="searchSuggestions"
            class="list-group position-absolute w-100 shadow"
            style="top: 100%; left: 0; z-index: 9999; display: none; max-height: 320px; overflow-y: auto;">
        </div>
    </form>
</div>

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


<!-- Optional scripts -->
<script>
    function toggleColumn(columnClassName, linkElement) {
        var column = document.querySelector('.' + columnClassName);
        var columnHeader = column.querySelector('.column-header');

        column.classList.toggle('column-transition');

        if (column.style.display === 'none' || column.style.display === '') {
            column.style.display = 'block';
            columnHeader.classList.add('active');
        } else {
            column.style.display = 'none';
            columnHeader.classList.remove('active');
        }

        document.querySelectorAll('.column-header a').forEach(function(el) {
            if (el !== linkElement) {
                el.parentElement.classList.remove('active');
            }
        });
    }
</script>

<script>
    // Currency Dropdown Update
    const currencyButton = document.getElementById('dropdownMenuButton1');
    const currencyItems = document.querySelectorAll('.dropdown-item.top-dropdown');

    currencyItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            currencyButton.textContent = this.textContent;
        });
    });
</script>

<!-- 🔥 Instant Search Suggestions -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('globalSearch');
    const suggestionBox = document.getElementById('searchSuggestions');
    let controller;

    input.addEventListener('input', function () {
        const query = this.value.trim();

        if (query.length === 0) {
            suggestionBox.style.display = 'none';
            suggestionBox.innerHTML = '';
            return;
        }

        if (controller) controller.abort();
        controller = new AbortController();

        fetch(`{{ route('search.suggestions') }}?q=${encodeURIComponent(query)}`, {
            signal: controller.signal
        })
        .then(res => res.json())
        .then(data => {
            suggestionBox.innerHTML = '';

            if (!data.length) {
                suggestionBox.style.display = 'none';
                return;
            }

            data.forEach(item => {
                const el = document.createElement('a');
                el.href = item.url;
                el.className = 'list-group-item list-group-item-action';

                el.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="${item.icon} me-2 text-primary"></i>
                        <div>
                            <strong>${item.name}</strong><br>
                            <small class="text-muted">${item.description}</small>
                        </div>
                    </div>
                `;
                suggestionBox.appendChild(el);
            });

            suggestionBox.style.display = 'block';
        })
        .catch(err => {
            if (err.name !== 'AbortError') {
                console.error('Search error:', err);
            }
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#globalSearch') && !e.target.closest('#searchSuggestions')) {
            suggestionBox.style.display = 'none';
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('globalSearch');
    const suggestionBox = document.getElementById('searchSuggestions');
    let controller;

    input.addEventListener('input', function () {
        const query = this.value.trim();

        if (query.length === 0) {
            suggestionBox.style.display = 'none';
            suggestionBox.innerHTML = '';
            return;
        }

        if (controller) controller.abort();
        controller = new AbortController();

        fetch(`{{ route('search.suggestions') }}?q=${encodeURIComponent(query)}`, {
            signal: controller.signal
        })
        .then(res => res.json())
        .then(data => {
            suggestionBox.innerHTML = '';

            if (!data.length) {
                suggestionBox.style.display = 'none';
                return;
            }

            data.forEach(item => {
                const el = document.createElement('a');
                el.href = item.url;
                el.className = 'list-group-item list-group-item-action';

                el.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="${item.icon} me-2 text-primary"></i>
                        <div>
                            <strong>${item.name}</strong><br>
                            <small class="text-muted">${item.description}</small>
                        </div>
                    </div>
                `;
                suggestionBox.appendChild(el);
            });

            suggestionBox.style.display = 'block';
        })
        .catch(err => {
            if (err.name !== 'AbortError') console.error('Search error:', err);
        });
    });

    // Close suggestions when clicking outside
    document.addEventListener('click', function (e) {
        if (!e.target.closest('#globalSearch') && !e.target.closest('#searchSuggestions')) {
            suggestionBox.style.display = 'none';
        }
    });
});
</script>
