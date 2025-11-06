<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Principal Dashboard</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <!-- Include your admin theme CSS files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Include your admin theme styles -->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    
    <style>
        .principal-header {
            background: #1E1E2D;
            border-bottom: 1px solid #2D2D43;
        }
        .principal-sidebar {
            background: #1E1E2D;
        }
    </style>
</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-fixed aside-secondary-enabled">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->
            <div id="kt_aside" class="aside aside-dark aside-hoverable principal-sidebar" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px':'250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
                <!--begin::Brand-->
                <div class="aside-logo flex-column-auto" id="kt_aside_logo">
                    <!--begin::Logo-->
                    <a href="{{ route('principal.dashboard') }}">
                        <img alt="Logo" src="{{ asset('assets/media/logos/logo-1.svg') }}" class="h-25px logo" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Aside toggler-->
                    <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
                        <span class="svg-icon svg-icon-1 rotate-180">
                            <i class="fa-solid fa-angles-left"></i>
                        </span>
                    </div>
                    <!--end::Aside toggler-->
                </div>
                <!--end::Brand-->
                
                <!--begin::Aside menu-->
                <div class="aside-menu flex-column-fluid">
                    <!--begin::Aside Menu-->
                    <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
                        <!--begin::Menu-->
                        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
                            
                            <!-- Dashboard Menu -->
                            <div class="menu-item">
                                <a class="menu-link {{ Route::current()->getName() == 'principal.dashboard' ? 'active' : '' }}" href="{{ route('principal.dashboard') }}">
                                    <span class="menu-icon">
                                        <i class="fa-solid fa-gauge-high"></i>
                                    </span>
                                    <span class="menu-title">Dashboard</span>
                                </a>
                            </div>

                            <!-- Supply Chain Menu (Same as Admin) -->
                            @php
                                $supplychain = [
                                    'principal.supply-chain.categories.index', 
                                    'principal.supply-chain.brands.index', 
                                    'principal.supply-chain.attributes.index', 
                                    'principal.supply-chain.product-colors.index', 
                                    'principal.supply-chain.products.index', 
                                    'principal.supply-chain.products.create', 
                                    'principal.supply-chain.products.edit'
                                ];
                            @endphp
                            
                            <div data-kt-menu-trigger="click"
                                class="menu-item menu-accordion {{ in_array(Route::current()->getName(), $supplychain) ? 'here show' : '' }}">
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="fa-solid fa-truck"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">Supply Chain</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <div class="menu-sub menu-sub-accordion">
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item menu-accordion {{ in_array(Route::current()->getName(), $supplychain) ? 'here show' : '' }}">
                                        <span class="menu-link">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Logistics</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <div class="menu-sub menu-sub-accordion">
                                            <div class="menu-item">
                                                <a class="menu-link {{ Route::current()->getName() == 'principal.supply-chain.brands.index' ? 'active' : '' }}"
                                                    href="{{ route('principal.supply-chain.brands.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Brands</span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a class="menu-link {{ Route::current()->getName() == 'principal.supply-chain.categories.index' ? 'active' : '' }}"
                                                    href="{{ route('principal.supply-chain.categories.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Categories</span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a class="menu-link {{ Route::current()->getName() == 'principal.supply-chain.attributes.index' ? 'active' : '' }}"
                                                    href="{{ route('principal.supply-chain.attributes.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Attributes</span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a class="menu-link {{ Route::current()->getName() == 'principal.supply-chain.product-colors.index' ? 'active' : '' }}"
                                                    href="{{ route('principal.supply-chain.product-colors.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Product Colors</span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a class="menu-link {{ in_array(Route::current()->getName(), ['principal.supply-chain.products.index', 'principal.supply-chain.products.create', 'principal.supply-chain.products.edit']) ? 'active' : '' }}"
                                                    href="{{ route('principal.supply-chain.products.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Products</span>
                                                </a>
                                            </div>
                                            <div class="menu-item">
                                                <a class="menu-link {{ in_array(Route::current()->getName(), ['principal.supply-chain.products-saas.index', 'principal.supply-chain.products-saas.create', 'principal.supply-chain.products-saas.edit']) ? 'active' : '' }}"
                                                    href="{{ route('principal.supply-chain.products-saas.index') }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Products SAAS</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <span class="menu-link">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Purchase</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <div class="menu-sub menu-sub-accordion">
                                            <div class="menu-item">
                                                <a class="menu-link" href="#">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Orders Listing</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                        <span class="menu-link">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Delivery</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <div class="menu-sub menu-sub-accordion">
                                            <div class="menu-item">
                                                <a class="menu-link" href="#">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Customer Listing</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Add more menu items as needed -->
                            
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Aside Menu-->
                </div>
                <!--end::Aside menu-->
            </div>
            <!--end::Aside-->

            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" class="header align-items-stretch principal-header">
                    <!--begin::Container-->
                    <div class="container-fluid d-flex align-items-stretch justify-content-between">
                        <!--begin::Aside mobile toggle-->
                        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
                            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                                <span class="svg-icon svg-icon-1">
                                    <i class="fa-solid fa-bars"></i>
                                </span>
                            </div>
                        </div>
                        <!--end::Aside mobile toggle-->
                        
                        <!--begin::Mobile logo-->
                        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                            <a href="{{ route('principal.dashboard') }}" class="d-lg-none">
                                <img alt="Logo" src="{{ asset('assets/media/logos/logo-1.svg') }}" class="h-30px" />
                            </a>
                        </div>
                        <!--end::Mobile logo-->
                        
                        <!--begin::Topbar-->
                        <div class="d-flex align-items-stretch justify-content-end flex-lg-grow-1">
                            <!--begin::Navbar-->
                            <div class="d-flex align-items-stretch" id="kt_header_nav">
                                <!--begin::Toolbar wrapper-->
                                <div class="d-flex align-items-stretch flex-shrink-0">
                                    <!-- User Menu -->
                                    <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                                        <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                            <div class="symbol-label fs-3 bg-light-primary text-primary">
                                                {{ substr(auth('principal')->user()->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <div class="menu-content d-flex align-items-center px-3">
                                                    <div class="symbol symbol-50px me-5">
                                                        <div class="symbol-label fs-3 bg-light-primary text-primary">
                                                            {{ substr(auth('principal')->user()->name, 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <div class="fw-bold d-flex align-items-center fs-5">
                                                            {{ auth('principal')->user()->name }}
                                                        </div>
                                                        <span class="fw-semibold text-muted fs-7">
                                                            {{ auth('principal')->user()->email }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Menu item-->
                                            
                                            <!--begin::Menu separator-->
                                            <div class="separator my-2"></div>
                                            <!--end::Menu separator-->
                                            
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-5">
                                                <a href="{{ route('principal.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-link px-5">
                                                    Sign Out
                                                </a>
                                                <form id="logout-form" action="{{ route('principal.logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                    </div>
                                    <!--end::User account menu-->
                                </div>
                                <!--end::Toolbar wrapper-->
                            </div>
                            <!--end::Navbar-->
                        </div>
                        <!--end::Topbar-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Container-->
                    <div class="container-xxl" id="kt_content_container">
                        <!-- SweetAlert Notifications -->
                        @if(session('swal'))
                            <div class="alert alert-success d-none" id="swal-alert">
                                {{ session('swal')['text'] }}
                            </div>
                        @endif

                        <!-- Main Content -->
                        @yield('content')
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->

                <!--begin::Footer-->
                <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                    <!--begin::Container-->
                    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <!--begin::Copyright-->
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted fw-semibold me-1">2024©</span>
                            <a href="#" class="text-gray-800 text-hover-primary">Principal Dashboard</a>
                        </div>
                        <!--end::Copyright-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->

    <!--begin::Javascript-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Javascript-->

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('swal'))
                const swalData = @json(session('swal'));
                Swal.fire({
                    icon: swalData.icon || 'success',
                    title: swalData.title || 'Success!',
                    text: swalData.text || 'Operation completed successfully.',
                    timer: swalData.timer || 4000,
                    showConfirmButton: swalData.showConfirmButton !== undefined ? swalData.showConfirmButton : false,
                    timerProgressBar: swalData.timerProgressBar !== undefined ? swalData.timerProgressBar : true,
                });
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>