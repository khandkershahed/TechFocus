<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ route('principal.dashboard.overview') }}">
            <img alt="Logo" src="https://i.ibb.co/dD1P3Wt/Demo-Logo.png" class="h-45px logo" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="w-auto px-0 btn btn-icon btn-active-color-primary aside-toggle"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="rotate-180 svg-icon svg-icon-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="currentColor" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="my-5 hover-scroll-overlay-y my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">

                <!-- Dashboard Overview -->
                <div class="menu-item">
                    <a class="menu-link {{ Route::is('principal.dashboard.overview') ? 'active' : '' }}"
                        href="{{ route('principal.dashboard.overview') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-chart-pie svg-icon svg-icon-2"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </div>

                <!-- Main Dashboard -->
                <div class="menu-item">
                    <a class="menu-link {{ Route::is('principal.dashboard') ? 'active' : '' }}"
                        href="{{ route('principal.profile.overview') }}">
                        <span class="menu-icon">
                            <i class="fa-solid fa-house-chimney-window svg-icon svg-icon-2"></i>
                        </span>
                        <span class="menu-title">Principal Overview</span>
                    </a>
                </div>

                {{-- Brand Management --}}
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ in_array(Route::current()->getName(), [
                        'principal.brands.index',
                        'principal.brands.create',
                        'principal.brands.edit'
                    ]) ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <i class="fas fa-certificate side_baricon"></i>
                            </span>
                        </span>
                        <span class="menu-title">Brand Management</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ Route::current()->getName() == 'principal.brands.index' ? 'active' : '' }}"
                                href="{{ route('principal.brands.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">My Brands</span>
                                <span class="badge bg-primary float-end">{{ Auth::guard('principal')->user()->brands->count() }}</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Route::current()->getName() == 'principal.brands.create' ? 'active' : '' }}"
                                href="{{ route('principal.brands.create') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Add New Brand</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Product Management --}}
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ in_array(Route::current()->getName(), [
                        'principal.products.index',
                        'principal.products.create',
                        'principal.products.edit'
                    ]) ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </span>
                        </span>
                        <span class="menu-title">Product Management</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ Route::current()->getName() == 'principal.products.index' ? 'active' : '' }}"
                                href="{{ route('principal.products.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">My Products</span>
                                <span class="badge bg-primary float-end">{{ Auth::guard('principal')->user()->products->count() }}</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Route::current()->getName() == 'principal.products.create' ? 'active' : '' }}"
                                href="{{ route('principal.products.create') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">Add New Product</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Notes & Activities --}}
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ in_array(Route::current()->getName(), [
                        'principal.notes.index'
                    ]) ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <i class="fa-solid fa-sticky-note"></i>
                            </span>
                        </span>
                        <span class="menu-title">Notes & Activities</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link {{ Route::current()->getName() == 'principal.notes.index' ? 'active' : '' }}"
                                href="{{ route('principal.notes.index') }}">
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                                <span class="menu-title">All Notes</span>
                                <span class="badge bg-primary float-end">{{ Auth::guard('principal')->user()->activities->count() }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Profile Management --}}
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ in_array(Route::current()->getName(), [
                        'principal.profile.index',
                        'principal.profile.edit',
                        'principal.profile.settings'
                    ]) ? 'here show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <i class="fa-solid fa-user-tie"></i>
                            </span>
                        </span>
                        <span class="menu-title">Profile & Settings</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        {{-- <div class="menu-item">
                            <a class="menu-link {{ Route::current()->getName() == 'principal.profile.index' ? 'active' : '' }}"
                        href="{{ route('principal.profile.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">My Profile</span>
                        </a>
                    </div> --}}
                    <div class="menu-item">
                        <a class="menu-link {{ Route::current()->getName() == 'principal.profile.edit' ? 'active' : '' }}"
                            href="{{ route('principal.profile.edit') }}">
                            <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            <span class="menu-title">Edit Profile</span>
                        </a>
                    </div>
                    {{-- <div class="menu-item">
                            <a class="menu-link {{ Route::current()->getName() == 'principal.profile.settings' ? 'active' : '' }}"
                    href="{{ route('principal.profile.settings') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">Account Settings</span>
                    </a>
                </div> --}}
            </div>
        </div>

        {{-- Quick Links Management --}}
        <div data-kt-menu-trigger="click"
            class="menu-item menu-accordion {{ in_array(Route::current()->getName(), [
                        'principal.links.index',
                        'principal.links.create',
                        'principal.links.edit'
                    ]) ? 'here show' : '' }}">
            <span class="menu-link">
                <span class="menu-icon">
                    <span class="svg-icon svg-icon-2">
                        <i class="fa-solid fa-link"></i>
                    </span>
                </span>
                <span class="menu-title">Quick Links</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion">
                <div class="menu-item">
                    <a class="menu-link {{ Route::current()->getName() == 'principal.links.index' ? 'active' : '' }}"
                        href="{{ route('principal.links.index') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">My Links</span>
                        <span class="badge bg-primary float-end">{{ Auth::guard('principal')->user()->links->count() }}</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::current()->getName() == 'principal.links.create' ? 'active' : '' }}"
                        href="{{ route('principal.links.create') }}">
                        <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                        <span class="menu-title">Add New Link</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <!--end::Menu-->
</div>
<!--end::Aside Menu-->
</div>
<!--end::Aside menu-->
</div>