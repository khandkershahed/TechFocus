<div id="kt_aside"
    class="aside aside-dark aside-hoverable"
    data-kt-drawer="true"
    data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default: '200px', '300px': '250px'}"
    data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">

    <!-- LOGO + TOGGLER -->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <a href="{{ route('principal.dashboard') }}">
            <img src="{{ asset('backend/assets/media/logos/main-Logo.png') }}"
                alt="Logo" class="h-45px logo" />
        </a>

        <div id="kt_aside_toggle"
            class="btn btn-icon aside-toggle"
            data-kt-toggle="true"
            data-kt-toggle-state="active"
            data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">

            <span class="rotate-180 svg-icon svg-icon-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                    <path opacity="0.5"
                        d="M14.27 11.43L18.45 7.25c.41-.41.41-1.08 0-1.5-.41-.41-1.08-.41-1.5 0L11.41 11.29c-.39.39-.39 1.03 0 1.41l5.54 5.55c.41.41 1.08.41 1.5 0 .41-.41.41-1.08 0-1.5l-4.19-4.36c-.32-.32-.32-.83 0-1.16z"
                        fill="currentColor" />
                    <path
                        d="M8.27 11.43L12.45 7.25c.41-.41.41-1.08 0-1.5-.41-.41-1.08-.41-1.5 0L5.41 11.29c-.39.39-.39 1.03 0 1.41L10.95 18.25c.41.41 1.08.41 1.5 0 .41-.41.41-1.08 0-1.5L8.27 12.56c-.32-.32-.32-.83 0-1.16z"
                        fill="currentColor" />
                </svg>
            </span>
        </div>
    </div>
    <!-- MENU -->
    <div class="aside-menu flex-column-fluid">
        <div class="my-5 hover-scroll-overlay-y" id="kt_aside_menu_wrapper"
            data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
            data-kt-scroll-offset="0">

            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary"
                id="kt_aside_menu" data-kt-menu="true">

                <!-- Dashboard -->
                <div class="menu-item">
                    <a class="menu-link {{ Route::is('principal.dashboard') ? 'active' : '' }}"
                        href="{{ route('principal.dashboard') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-house-chimney-window svg-icon svg-icon-2"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                <!-- Brand Management -->
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion 
                    {{ Route::is('principal.brands.*') || Route::is('principal.products.create') ? 'here show' : '' }}">

                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="fas fa-briefcase svg-icon svg-icon-2"></i>
                        </span>
                        <span class="menu-title">Brand Management</span>
                        <span class="menu-arrow"></span>
                    </span>

                    <div class="menu-sub menu-sub-accordion">
                        <!-- Brand List -->
                        <div class="menu-item">
                            <a class="menu-link {{ Route::is('principal.brands.index') ? 'active' : '' }}"
                                href="{{ route('principal.brands.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">My Brands</span>
                                <span class="badge bg-primary ms-auto">
                                    {{ \App\Models\Principal::count() }}
                                </span>
                            </a>
                        </div>

                        <!-- Add Brand -->
                        <div class="menu-item">
                            <a class="menu-link {{ Route::is('principal.products.create') ? 'active' : '' }}"
                                href="{{ route('principal.products.create') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Add New Brand</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div><!-- end menu -->
        </div>
    </div>
</div>