<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon"
    href="{{ !empty($site->site_icon) && file_exists(public_path('storage/webSetting/siteIcon/' . $site->site_icon)) ? asset('storage/webSetting/siteIcon/' . $site->site_icon) : asset('backend/images/no-image-available.png') }}" />

@stack('metadata')
<!-- *********************************CSS Start*********************************** -->
<link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;1,400&family=Ubuntu:wght@400;500&display=swap"
    rel="stylesheet" />
<!-- Aos Scroll Animation Start-->
<link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('frontend/assets/css/swiper-bundle.min.css') }}" />
<link rel="stylesheet" href="{{ asset('frontend/assets/css/aos.css') }}" />
<!-- *********************************CSS End*********************************** -->
@include('frontend.partials.root_css')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('frontend/assets/css/global.css') }}" />
<link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/xzoom@1.0.14/src/xzoom.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css" />
@stack('styles')

<style>
    .menu-dropdown {
        position: relative;
        padding: 20px;
        border-radius: 8px;
        overflow: hidden;
    }

    .menu-dropdown::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://png.pngtree.com/background/20220729/original/pngtree-light-gray-geometry-abstract-subtle-background-vector-picture-image_1867383.jpg');
        background-size: cover;
        background-position: center;
        z-index: -1;
        opacity: 0.8;
        /* Adjust the opacity as needed */
    }

    .header-side-banner {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .column-transition {
        transition: all 0.3s ease;
    }

    .column-header a:hover,
    .column-header.active a {
        color: var(--primary-color);
    }

    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
    }
</style>