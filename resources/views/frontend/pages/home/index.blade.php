<x-frontend-layout :title="'Tech Focus Limited'">
    <style>
        /* Product title with line clamp */
        .product-title {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* Card hover effects */
        .url-box a:hover .card {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        /* SKU/MF text styling */
        .tags-text {
            font-size: 0.875rem;
            color: #555;
        }

        /* Consistent card heights */
        .url-box,
        .url-box .card {
            height: 100%;
        }

        /* Product image scaling */
        .h-product-img {
            object-fit: contain;
            max-height: 180px;
            width: 100%;
        }

        /* Enhanced product title clamp */
        .product-title {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        /* Enhanced hover effect */
        .url-box:hover .card {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
       .product-title-wrapper {
            min-height: 80px;
            overflow: hidden;
        }

        .product-code-wrapper {
            min-height: 48px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            gap: 4px;
        }

        .product-title {
            line-height: 1.4;
        }
        
        /* Already added button style */
        .btn-added {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            color: white !important;
        }
        
        .btn-added:hover {
            background-color: #218838 !important;
            border-color: #1e7e34 !important;
        }
    </style>
    <!-- SECTION 1: BANNER -->
    <div class="swiper bannerSwiper">
        <div class="swiper-wrapper">
            @foreach ($banners as $banner)
                <div class="swiper-slide">
                    <a href="">
                        <img src="{{ asset('uploads/page_banners/' . $banner->image) }}" 
                             class="img-fluid"
                             alt="{{ $banner->title ?? 'Banner' }}"
                             onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-banner(1920-330).png') }}';" />
                    </a>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <!-- SECTION 2: CONTENT MENU -->
    <div class="container p-0 my-3">
        <div class="mt-2 mb-2">
            <div class="row">
                @php
                    $sortedCategories = $categories->sortBy('name')->values();
                    $columns = 3;
                    $chunks = $sortedCategories->chunk(ceil($sortedCategories->count() / $columns));
                @endphp
                <div class="px-0 col-lg-12 px-lg-0">
                    <div class="container">
                        <div class="pt-3 row">
                            @foreach ($chunks as $chunkKey => $chunk)
                                <div class="col-md-4 {{ $chunkKey == 0 ? 'pe-0 ps-0' : 'pe-0' }}">
                                    @foreach ($chunk as $key => $category)
                                        <div class="accordion accordion-flush" 
                                             id="accordionFlushExample-{{ $chunkKey }}-{{ $key }}">
                                            
                                            <div class="mb-2 accordion-item">
                                                <h2 class="accordion-header" 
                                                    id="flush-heading-{{ $chunkKey }}-{{ $key }}">
                                                    <button class="p-3 accordion-button collapsed" 
                                                            type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapse-{{ $chunkKey }}-{{ $key }}"
                                                            aria-expanded="false"
                                                            aria-controls="flush-collapse-{{ $chunkKey }}-{{ $key }}">
                                                        <div class="d-flex align-items-center w-100">
                                                            <img src="{{ asset('frontend/assets/img/Icon.svg') }}" 
                                                                 alt="" />
                                                            <p class="mb-0 ms-2">{{ ucwords($category->name) }}</p>
                                                        </div>
                                                    </button>
                                                </h2>

                                                <div id="flush-collapse-{{ $chunkKey }}-{{ $key }}"
                                                     class="accordion-collapse collapse"
                                                     aria-labelledby="flush-heading-{{ $chunkKey }}-{{ $key }}"
                                                     data-bs-parent="#accordionFlushExample-{{ $chunkKey }}-{{ $key }}">
                                                    
                                                    <div class="accordion-body">
                                                        @if ($category->children->count() > 0)
                                                            @foreach ($category->children->sortBy('name') as $sub_cat)
                                                                <li class="mb-2 menu-single-items">
                                                                    <a href="{{ route('category', $sub_cat->slug) }}">
                                                                        <span class="pe-2">-</span>{{ ucwords($sub_cat->name) }}
                                                                    </a>

                                                                    @if ($sub_cat->products->count() > 0)
                                                                        <ul class="ps-3">
                                                                            @foreach ($sub_cat->products as $product)
                                                                                <li class="mb-1">
                                                                                    <a href="{{ route('product.show', $product->slug) }}">
                                                                                        - {{ ucwords($product->name) }}
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- SECTION 3: DYNAMIC HERO SECTION ONE -->
            @if($homePage && $homePage->section_one_title)
                <div class="mx-1 my-5 bg-white row what-we-do"
                     style="background-position: center;
                            background-size: cover;
                            background-repeat: no-repeat;
                            background-image: url('{{ $homePage->section_one_image ? asset('storage/home-page/image/' . $homePage->section_one_image) : 'https://www.riverbed.com/riverbed-wp-content/uploads/2022/12/lady-with-laptop.png' }}')"
                            >
                    <div class="p-5 mb-3 col-lg-12">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-sm-12">
                                <div class="holder-main-text">
                                    @if($homePage->section_one_badge)
                                        <h6 style="line-height: 1.4;">
                                            {{ $homePage->section_one_badge }}
                                        </h6>
                                    @endif
                                    
                                    <h2 class="pb-2 mb-0">
                                        {{ $homePage->section_one_title }}
                                    </h2>
                                    
                                    @if($homePage->section_one_description)
                                        <p class="py-3 mt-0 text-black" style="text-align: justify">
                                            {!! $homePage->section_one_description !!}
                                        </p>
                                    @endif
                                    
                                    @if($homePage->section_one_button && $homePage->section_one_link)
                                        <a href="{{ $homePage->section_one_link }}" 
                                           class="mt-4 btn common-btn-3 rounded-0 w-25">
                                            {{ $homePage->section_one_button }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!-- SECTION 4: DYNAMIC SOLUTIONS SECTION -->
            @if ($homePage && $homePage->section_solutions_name && $solutions->count() > 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mt-2 devider-wrap">
                            <h4 class="pt-4 devider-content">
                                <span class="devider-text">{{ $homePage->section_solutions_name }}</span>
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="mb-3 border-0 card bg-primary"
                     style="border-top-right-radius: 40px; 
                            border-bottom-left-radius: 40px; 
                            background: linear-gradient(90deg, #0069bf 0%, #38b6ff 100%);">
                    
                    <div class="bg-transparent border-0 card-header">
                        <div class="px-5 row">
                            <div class="col-lg-12">
                                <div class="py-5 text-white d-flex justify-content-start">
                                    <h3>{{ $homePage->section_solutions_title ?? 'Solutions' }}</h3>
                                    @if ($homePage->section_solutions_badge)
                                        <h3 class="px-3">|</h3>
                                        <h3>{{ $homePage->section_solutions_badge }}</h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white card-body" style="border-bottom-left-radius: 40px">
                        <div class="px-5 row gx-5 special_solution_box">
                            @foreach ($solutions as $solution)
                                <div class="col-md-3">
                                    <div>
                                        <a href="{{ route('solution.details', $solution->slug) }}">
                                            <div class="p-3 border-0 shadow-sm card rounded-0 solution_cards">
                                                <div class="py-0 pt-2 d-flex align-items-center card-body">
                                                    <div class="icon-box">
                                                        @if ($solution->icon)
                                                            <img width="70px" 
                                                                 height="55px"
                                                                 src="{{ asset('storage/solutions/' . $solution->icon) }}"
                                                                 alt="{{ $solution->name }}" />
                                                        @else
                                                            <i class="fa-brands fa-draft2digital pe-2 main-color"
                                                               style="font-size: 2rem;"></i>
                                                        @endif
                                                    </div>
                                                    <div class="text-box">
                                                        <p class="p-0 m-0 ps-2 w-100">
                                                            {{ Str::words($solution->name, 5) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <a href="{{ route('solution.details', $solution->slug) }}"
                                                   class="pt-0 pb-2 mt-0 text-end main-color pe-1">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($homePage->section_solutions_button && $homePage->section_solutions_link)
                            <div class="mt-4 text-center">
                                <a href="{{ $homePage->section_solutions_link }}" 
                                   class="btn btn-primary">
                                    {{ $homePage->section_solutions_button }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <!-- SECTION 5: FEATURED PRODUCTS -->
            @if ($homePage && $homePage->section_two_name && $featuredProducts->count() > 0)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="devider-wrap">
                            <h4 class="devider-content">
                                <span class="devider-text">{{ $homePage->section_two_name }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($featuredProducts as $product)
                        <div class="mb-4 col-lg-3 col-12">
                            <a href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => optional($product)->slug]) }}" 
                               class="text-decoration-none h-100">
                                <div class="url-box h-100">
                                    <div class="overflow-hidden border-0 card rounded-0">
                                        <!-- CARD HEADER -->
                                        <div class="bg-white border-0 card-header d-flex justify-content-between align-items-center home-logo">
                                            <div class="badge-new">
                                                <span>New</span>
                                            </div>
                                            <div>
                                                <img src="{{ asset('storage/brand/logo/' . optional($product->brand)->logo) }}"
                                                     class="img-fluid"
                                                     style="height: 30px;"
                                                     alt="{{ optional($product->brand)->title }}"
                                                     loading="lazy"
                                                     onerror="this.onerror=null; 
                                                     this.src='{{ asset('https://www.techfocusltd.com/storage/brand/logo/Schneider-Electric-logo_1OzdzFNM.png') }}';" />
                                            </div>
                                        </div>
                                        <!-- CARD BODY -->
                                        <div class="p-0 card-body d-flex flex-column">
                                            <!-- PRODUCT IMAGE -->
                                            <div class="mb-2">
                                                <img class="img-fluid h-product-img" 
                                                    src="{{ $product->thumbnail }}" />
                                            </div>

                                            <!-- CONTENT AREA -->
                                            <div class="px-3 d-flex flex-column flex-grow-1">

                                                <!-- TITLE -->
                                                <div class="product-title-wrapper">
                                                    <h6 class="pt-3 mb-2 product-title text-start">
                                                        {{ Str::words($product->name, 15) }}
                                                    </h6>
                                                </div>

                                                <!-- SKU / MF CODES -->
                                                <div class="mb-3 product-code-wrapper">
                                                    @if (!empty($product->sku_code))
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa-solid fa-paperclip main-color me-2"></i>
                                                            <span class="tags-text">SKU #{{ $product->sku_code }}</span>
                                                        </div>
                                                    @endif

                                                    @if (!empty($product->mf_code))
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa-solid fa-paperclip main-color me-2"></i>
                                                            <span class="tags-text">MF #{{ $product->mf_code }}</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- BUTTONS (ALWAYS AT BOTTOM) -->
                                                <div class="gap-2 mt-auto mb-4 d-flex justify-content-between">
                                                   <!-- Change this button in your home page -->
                                             <a href="{{ route('product.request.form') }}" 
                                                class="btn btn-outline-primary flex-fill rounded-0">
                                                    Ask For Price
                                                </a>
                                                                                                        
                                                    <button class="btn btn-primary flex-fill add-to-rfq-btn rounded-0"
                                                            data-product-id="{{ $product->id }}"
                                                            data-product-name="{{ $product->name }}"
                                                            data-product-sku="{{ $product->sku_code ?? '' }}"
                                                            data-product-brand="{{ optional($product->brand)->name ?? '' }}"
                                                            data-product-thumbnail="{{ $product->thumbnail }}">
                                                        <span class="btn-text">+ Add RFQ</span>
                                                        <span class="btn-added-text d-none"><i class="fas fa-check me-1"></i> Added</span>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- SECTION 6: SERVICES/FEATURES -->
            @if ($homePage && $homePage->section_three_title)
                <div class="row pe-0">
                    <div class="col-lg-12">
                        <div class="devider-wrap">
                            <h4 class="devider-content">
                                <span class="devider-text">{{ $homePage->section_three_name ?? 'OUR SERVICES' }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="mb-3 border-0 card bg-primary pe-0"
                     style="border-top-right-radius: 40px; 
                            border-bottom-left-radius: 40px; 
                            background: linear-gradient(90deg, #0069bf 0%, #38b6ff 100%);">
                    
                    <div class="bg-transparent border-0 card-header">
                        <div class="px-5 row">
                            <div class="col-lg-12">
                                <div class="py-5 text-white d-flex justify-content-start">
                                    <h3>{{ $homePage->section_three_title }}</h3>
                                    @if ($homePage->section_three_badge)
                                        <h3 class="px-3">|</h3>
                                        <h3>{{ $homePage->section_three_badge }}</h3>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white card-body" style="border-bottom-left-radius: 40px">
                        <div class="px-5 row gx-5 special_solution_box">
                            @if ($homePage->section_three_first_column_title)
                                <div class="col-md-3">
                                    <div>
                                        <a href="{{ $homePage->section_three_first_column_link ?? 'javascript:void(0)' }}">
                                            <div class="p-3 border-0 shadow-sm card rounded-0 solution_cards">
                                                <div class="py-0 pt-2 d-flex align-items-center card-body">
                                                    <div class="icon-box">
                                                        @if ($homePage->section_three_first_column_logo)
                                                            <img width="70px" 
                                                                 height="55px"
                                                                 src="{{ asset('storage/home-page/logo/' . $homePage->section_three_first_column_logo) }}"
                                                                 alt="{{ $homePage->section_three_first_column_title }}" />
                                                        @else
                                                            <i class="fa-brands fa-draft2digital pe-2 main-color"
                                                               style="font-size: 2rem;"></i>
                                                        @endif
                                                    </div>
                                                    <div class="text-box">
                                                        <p class="p-0 m-0 ps-2 w-100">
                                                            {{ $homePage->section_three_first_column_title }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <a href="{{ $homePage->section_three_first_column_link ?? 'javascript:void(0)' }}"
                                                   class="pt-0 pb-2 mt-0 text-end main-color pe-1">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if ($homePage->section_three_second_column_title)
                                <div class="col-md-3">
                                    <div>
                                        <a href="{{ $homePage->section_three_second_column_link ?? 'javascript:void(0)' }}">
                                            <div class="p-3 border-0 shadow-sm card rounded-0 solution_cards">
                                                <div class="py-0 pt-2 d-flex align-items-center card-body">
                                                    <div class="icon-box">
                                                        @if ($homePage->section_three_second_column_logo)
                                                            <img width="70px" 
                                                                 height="55px"
                                                                 src="{{ asset('storage/home-page/logo/' . $homePage->section_three_second_column_logo) }}"
                                                                 alt="{{ $homePage->section_three_second_column_title }}" />
                                                        @else
                                                            <i class="fa-solid fa-cloud pe-2 main-color"
                                                               style="font-size: 2rem;"></i>
                                                        @endif
                                                    </div>
                                                    <div class="text-box">
                                                        <p class="p-0 m-0 ps-2 w-100">
                                                            {{ $homePage->section_three_second_column_title }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <a href="{{ $homePage->section_three_second_column_link ?? 'javascript:void(0)' }}"
                                                   class="pt-0 pb-2 mt-0 text-end main-color pe-1">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if ($homePage->section_three_third_column_title)
                                <div class="col-md-3">
                                    <div>
                                        <a href="{{ $homePage->section_three_third_column_link ?? 'javascript:void(0)' }}">
                                            <div class="p-3 border-0 shadow-sm card rounded-0 solution_cards">
                                                <div class="py-0 pt-2 d-flex align-items-center card-body">
                                                    <div class="icon-box">
                                                        @if ($homePage->section_three_third_column_logo)
                                                            <img width="70px" 
                                                                 height="55px"
                                                                 src="{{ asset('storage/home-page/logo/' . $homePage->section_three_third_column_logo) }}"
                                                                 alt="{{ $homePage->section_three_third_column_title }}" />
                                                        @else
                                                            <i class="fa-solid fa-shield-alt pe-2 main-color"
                                                               style="font-size: 2rem;"></i>
                                                        @endif
                                                    </div>
                                                    <div class="text-box">
                                                        <p class="p-0 m-0 ps-2 w-100">
                                                            {{ $homePage->section_three_third_column_title }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <a href="{{ $homePage->section_three_third_column_link ?? 'javascript:void(0)' }}"
                                                   class="pt-0 pb-2 mt-0 text-end main-color pe-1">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if ($homePage->section_three_fourth_column_title)
                                <div class="col-md-3">
                                    <div>
                                        <a href="{{ $homePage->section_three_fourth_column_link ?? 'javascript:void(0)' }}">
                                            <div class="p-3 border-0 shadow-sm card rounded-0 solution_cards">
                                                <div class="py-0 pt-2 d-flex align-items-center card-body">
                                                    <div class="icon-box">
                                                        @if ($homePage->section_three_fourth_column_logo)
                                                            <img width="70px" 
                                                                 height="55px"
                                                                 src="{{ asset('storage/home-page/logo/' . $homePage->section_three_fourth_column_logo) }}"
                                                                 alt="{{ $homePage->section_three_fourth_column_title }}" />
                                                        @else
                                                            <i class="fa-solid fa-network-wired pe-2 main-color"
                                                               style="font-size: 2rem;"></i>
                                                        @endif
                                                    </div>
                                                    <div class="text-box">
                                                        <p class="p-0 m-0 ps-2 w-100">
                                                            {{ $homePage->section_three_fourth_column_title }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <a href="{{ $homePage->section_three_fourth_column_link ?? 'javascript:void(0)' }}"
                                                   class="pt-0 pb-2 mt-0 text-end main-color pe-1">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($homePage->section_three_button && $homePage->section_three_link)
                            <div class="mt-4 text-center">
                                <a href="{{ $homePage->section_three_link }}" 
                                   class="btn btn-primary">
                                    {{ $homePage->section_three_button }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <!-- SECTION 7: NEWS & TRENDS -->
            @if ($homePage && $homePage->section_four_name && $sectionFourNews->count() > 0)
                <div class="mt-3 row">
                    <div class="col-lg-12">
                        <div class="devider-wrap">
                            <h4 class="devider-content">
                                <span class="devider-text">{{ $homePage->section_four_name }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row gx-5">
                    @foreach ($sectionFourNews as $news_trend)
                        <div class="col-lg-3 col-md-12">
                            <a href="{{ route('content.details', $news_trend->slug) }}">
                                <div class="card projects-card rounded-0">
                                    <img src="{{ asset('storage/content/' . $news_trend->thumbnail_image) }}"
                                         class="card-img-top img-fluid rounded-0" 
                                         alt="{{ $news_trend->title }}"
                                         onerror="this.onerror=null;this.src='{{ asset('frontend/images/error-image.avif') }}';">
                                    <div class="card-body">
                                        <p class="card-text project-para">{{ $news_trend->title }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
            <!-- SECTION 8: QUICK LINKS -->
            @if ($homePage && $homePage->section_five_title)
                <div class="mx-4 mt-5 mb-3">
                    <div class="mt-3">
                        <div class="bg-white row gx-5 develop-business-2 align-items-center">
                            <div class="p-2 col">
                                <div class="main-color d-flex">
                                    <a href="{{ $homePage->section_five_link_one_link ?? 'javascript:void(0)' }}">
                                        <h6 class="mb-0 ps-4">{{ $homePage->section_five_title }}</h6>
                                    </a>
                                </div>
                            </div>

                            @if ($homePage->section_five_link_one_title)
                                <div class="p-2 col">
                                    <a href="{{ $homePage->section_five_link_one_link ?? 'javascript:void(0)' }}">
                                        <div class="main-color d-flex align-items-center">
                                            <p class="p-0 m-0">
                                                <i class="{{ $homePage->section_five_link_one_icon ?? 'fa-solid fa-phone-volume' }}"></i>
                                            </p>
                                            <p class="p-0 m-0 ms-2">
                                                <span class="text-muted">{{ $homePage->section_five_link_one_title }}</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endif

                            @if ($homePage->section_five_link_two_title)
                                <div class="p-2 col">
                                    <a href="{{ $homePage->section_five_link_two_link ?? 'javascript:void(0)' }}">
                                        <div class="main-color d-flex align-items-center">
                                            <p class="p-0 m-0">
                                                <i class="{{ $homePage->section_five_link_two_icon ?? 'fa-solid fa-cart-shopping' }}"></i>
                                            </p>
                                            <p class="p-0 m-0 ms-2">
                                                <span class="text-muted">{{ $homePage->section_five_link_two_title }}</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endif

                            @if ($homePage->section_five_link_three_title)
                                <div class="p-2 col">
                                    <a href="{{ $homePage->section_five_link_three_link ?? 'javascript:void(0)' }}">
                                        <div class="main-color d-flex align-items-center">
                                            <p class="p-0 m-0">
                                                <i class="{{ $homePage->section_five_link_three_icon ?? 'fa-solid fa-box-open' }}"></i>
                                            </p>
                                            <p class="p-0 m-0 ms-2">
                                                <span class="text-muted">{{ $homePage->section_five_link_three_title }}</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endif

                            @if ($homePage->section_five_button_title)
                                <div class="p-2 m-0 col special-exhibit-2">
                                    <a href="{{ $homePage->section_five_button_link ?? 'javascript:void(0)' }}">
                                        <div class="p-3 text-center">
                                            <h4 class="mb-0 text-white">{{ $homePage->section_five_button_title }}</h4>
                                            @if ($homePage->section_five_button_sub_title)
                                                <p class="p-0 m-0 text-white ms-2" style="font-size: 12px">
                                                    {{ $homePage->section_five_button_sub_title }}
                                                </p>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <!-- FALLBACK STATIC DESIGN -->
                <div class="mx-4 mt-5 mb-3">
                    <div class="mt-3">
                        <div class="bg-white row gx-5 develop-business-2 align-items-center">
                            <div class="p-2 col">
                                <div class="main-color d-flex">
                                    <a href="">
                                        <h6 class="mb-0 ps-4">Develop Your Business!</h6>
                                    </a>
                                </div>
                            </div>
                            <div class="p-2 col">
                                <a href="">
                                    <div class="main-color d-flex align-items-center">
                                        <p class="p-0 m-0">
                                            <i class="fa-solid fa-phone-volume"></i>
                                        </p>
                                        <p class="p-0 m-0 ms-2">
                                            <span class="text-muted">Contact Us</span>
                                        </p>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 col">
                                <a href="">
                                    <div class="main-color d-flex align-items-center">
                                        <p class="p-0 m-0">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </p>
                                        <p class="p-0 m-0 ms-2">
                                            <span class="text-muted">Start Selling Online</span>
                                        </p>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 col">
                                <a href="">
                                    <div class="main-color d-flex align-items-center">
                                        <p class="p-0 m-0">
                                            <i class="fa-solid fa-box-open"></i>
                                        </p>
                                        <p class="p-0 m-0 ms-2">
                                            <span class="text-muted">Exhibit Your Products</span>
                                        </p>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 m-0 col special-exhibit-2">
                                <a href="">
                                    <div class="p-3 text-center">
                                        <h4 class="mb-0 text-white">Exhibit With Us</h4>
                                        <p class="p-0 m-0 text-white ms-2" style="font-size: 12px">
                                            Sign up in 2 minutes
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <!-- SECTION 11: WHY NEED US SECTION -->
            @if ($homePage && $homePage->section_seven_title)
                <div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="devider-wrap">
                                <h4 class="devider-content">
                                    <span class="devider-text">{{ $homePage->section_seven_name ?? 'WHY YOU NEED US ?' }}</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="mx-1 mb-5 bg-white row"
                         style="border-top-right-radius: 40px; border-bottom-left-radius: 40px">
                        <div class="p-5 mb-3 col-lg-12">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="holder-main-text">
                                        @if ($homePage->section_seven_badge)
                                            <h6 style="line-height: 25px">
                                                {{ $homePage->section_seven_badge }}
                                            </h6>
                                        @endif

                                        <h2 class="pt-3 pb-2 mb-0 text-capitalize">
                                            {{ $homePage->section_seven_title }}
                                        </h2>

                                        @if ($homePage->section_seven_description)
                                            <p class="pt-2 mt-0 text-black" style="text-align: justify">
                                                {!! $homePage->section_seven_description !!}
                                            </p>
                                        @endif

                                        @if ($homePage->section_seven_button && $homePage->section_seven_link)
                                            <a href="{{ $homePage->section_seven_link }}"
                                               class="mt-4 btn common-btn-3 rounded-0 w-25">
                                                {{ $homePage->section_seven_button }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <!-- FIRST GRID -->
                                        @if ($homePage->section_seven_first_grid_title)
                                            <div class="col-lg-6">
                                                <a href="{{ $homePage->section_seven_first_grid_button_link ?? 'javascript:void(0)' }}">
                                                    <div class="mt-2 shadow-lg card common-gradient"
                                                         style="border-top-right-radius: 40px; 
                                                                border-bottom-left-radius: 40px; 
                                                                border: 0px solid #fff;">
                                                        <div class="border-0 card-body">
                                                            <div class="icon-holder">
                                                                @if ($homePage->section_seven_first_grid_icon)
                                                                    <img src="{{ asset('storage/home-page/icon/' . $homePage->section_seven_first_grid_icon) }}"
                                                                         alt="{{ $homePage->section_seven_first_grid_title }}"
                                                                         style="width: 50px; height: 50px;" />
                                                                @else
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         viewBox="0 0 80 80">
                                                                        <defs>
                                                                            <style>
                                                                                .c {
                                                                                    fill: #fff;
                                                                                }
                                                                            </style>
                                                                        </defs>
                                                                        <g id="a">
                                                                            <g>
                                                                                <path class="c"
                                                                                      d="M65.4,66.68c-.51,0-.94-.39-.99-.9-.09-.94-.43-2.96-1.7-5.03v4.94c0,.55-.45,1-1,1s-1-.45-1-1v-7.8c0-.4,.24-.77,.62-.92,.37-.15,.8-.07,1.09,.21,3.17,3.14,3.85,6.93,3.99,8.41,.05,.55-.35,1.04-.9,1.09-.03,0-.07,0-.1,0Zm-51.06,0s-.06,0-.1,0c-.55-.05-.95-.54-.9-1.09,.14-1.48,.82-5.27,3.99-8.41,.29-.28,.72-.37,1.09-.21,.37,.16,.62,.52,.62,.92v7.8c0,.55-.45,1-1,1s-1-.45-1-1v-4.94c-1.27,2.07-1.61,4.09-1.7,5.03-.05,.52-.49,.9-.99,.9Zm-5,0s-.03,0-.05,0c-.55-.03-.98-.49-.95-1.04,.26-5.72,3.89-13.52,13.25-16.7,.28-.1,.6-.06,.85,.1l2.56,1.61,1.79-2.71c.13-.2,.33-.35,.56-.41,6.67-1.9,8.93-7.39,8.95-7.45,.33-.81,1.08-1.54,1.97-1.91,.88-.36,1.83-.36,2.69,.01,1.74,.75,2.53,2.66,1.83,4.44-.12,.31-3.02,7.68-11.63,10.99v12.07c0,.55-.45,1-1,1s-1-.45-1-1v-12.77c0-.43,.27-.8,.67-.94,8.26-2.87,11.06-9.99,11.09-10.06,.31-.79,0-1.56-.76-1.88-.37-.16-.76-.16-1.14,0-.45,.19-.77,.55-.87,.8-.1,.26-2.57,6.26-9.9,8.52l-2.13,3.23c-.3,.45-.91,.58-1.37,.3l-2.98-1.87c-8.07,2.94-11.21,9.74-11.45,14.74-.02,.54-.47,.95-1,.95Zm61.06,0c-.53,0-.97-.42-1-.95-.23-5.01-3.38-11.82-11.47-14.75l-2.95,1.88c-.46,.29-1.07,.16-1.37-.29l-2.15-3.22c-4.46-1.36-7.06-4-8.23-5.49-.34-.43-.27-1.06,.17-1.4,.43-.34,1.06-.27,1.4,.17,1.05,1.33,3.42,3.74,7.56,4.9,.23,.07,.43,.21,.56,.41l1.81,2.71,2.54-1.62c.26-.16,.57-.2,.86-.1,9.37,3.17,13.01,10.98,13.27,16.71,.03,.55-.4,1.02-.95,1.04-.02,0-.03,0-.05,0Zm-20.83,0c-.55,0-1-.45-1-1v-12.07c-3.3-1.28-6.43-3.44-8.11-5.63-.34-.44-.25-1.07,.19-1.4,.44-.33,1.07-.25,1.4,.19,1.55,2.02,4.7,4.11,7.85,5.2,.4,.14,.67,.52,.67,.94v12.77c0,.55-.45,1-1,1Zm6.06-18.9c-3.49,0-6.33-2.84-6.33-6.33s2.84-6.33,6.33-6.33,6.33,2.84,6.33,6.33-2.84,6.33-6.33,6.33Zm0-10.66c-2.39,0-4.33,1.94-4.33,4.33s1.94,4.33,4.33,4.33,4.33-1.94,4.33-4.33-1.94-4.33-4.33-4.33Zm-31.54,10.66c-3.49,0-6.33-2.84-6.33-6.33s2.84-6.33,6.33-6.33,6.33,2.84,6.33,6.33-2.84,6.33-6.33,6.33Zm0-10.66c-2.39,0-4.33,1.94-4.33,4.33s1.94,4.33,4.33,4.33,4.33-1.94,4.33-4.33-1.94-4.33-4.33-4.33Z">
                                                                                </path>
                                                                            </g>
                                                                        </g>
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                            <div class="solution-card-box">
                                                                <h5>{{ $homePage->section_seven_first_grid_title }}</h5>
                                                                <div class="text-white row">
                                                                    <div class="col-lg-12">
                                                                        <a href="{{ $homePage->section_seven_first_grid_button_link ?? 'javascript:void(0)' }}"
                                                                           class="mt-1 mb-3 learn_more_btn d-flex justify-content-between">
                                                                            <p class="p-0 pb-2 m-0">
                                                                                {{ $homePage->section_seven_first_grid_button_name ?? 'Learn More' }}
                                                                            </p>
                                                                            <p class="p-0 pb-2 m-0">
                                                                                <i class="fa-solid fa-plus"></i>
                                                                            </p>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif

                                        <!-- SECOND GRID -->
                                        @if ($homePage->section_seven_second_grid_title)
                                            <div class="col-lg-6">
                                                <a href="{{ $homePage->section_seven_second_grid_button_link ?? 'javascript:void(0)' }}">
                                                    <div class="mt-2 shadow-lg card common-gradient"
                                                         style="border-top-right-radius: 40px; 
                                                                border-bottom-left-radius: 40px; 
                                                                border: 0px solid #fff;">
                                                        <div class="border-0 card-body">
                                                            <div class="icon-holder">
                                                                @if ($homePage->section_seven_second_grid_icon)
                                                                    <img src="{{ asset('storage/home-page/icon/' . $homePage->section_seven_second_grid_icon) }}"
                                                                         alt="{{ $homePage->section_seven_second_grid_title }}"
                                                                         style="width: 50px; height: 50px;" />
                                                                @else
                                                                    <?xml version="1.0" encoding="UTF-8"?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         viewBox="0 0 80 80">
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                            <div class="solution-card-box">
                                                                <h5>{{ $homePage->section_seven_second_grid_title }}</h5>
                                                                <div class="text-white row">
                                                                    <div class="col-lg-12">
                                                                        <a href="{{ $homePage->section_seven_second_grid_button_link ?? 'javascript:void(0)' }}"
                                                                           class="mt-1 mb-3 learn_more_btn d-flex justify-content-between">
                                                                            <p class="p-0 pb-2 m-0">
                                                                                {{ $homePage->section_seven_second_grid_button_name ?? 'Learn More' }}
                                                                            </p>
                                                                            <p class="p-0 pb-2 m-0">
                                                                                <i class="fa-solid fa-plus"></i>
                                                                            </p>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-3 row">
                                        <!-- THIRD GRID -->
                                        @if ($homePage->section_seven_third_grid_title)
                                            <div class="col-lg-6">
                                                <a href="{{ $homePage->section_seven_third_grid_button_link ?? 'javascript:void(0)' }}">
                                                    <div class="mt-2 shadow-lg card common-gradient"
                                                         style="border-top-right-radius: 40px; 
                                                                border-bottom-left-radius: 40px; 
                                                                border: 0px solid #fff;">
                                                        <div class="border-0 card-body">
                                                            <div class="icon-holder">
                                                                @if ($homePage->section_seven_third_grid_icon)
                                                                    <img src="{{ asset('storage/home-page/icon/' . $homePage->section_seven_third_grid_icon) }}"
                                                                         alt="{{ $homePage->section_seven_third_grid_title }}"
                                                                         style="width: 50px; height: 50px;" />
                                                                @else
                                                                    <?xml version="1.0" encoding="UTF-8"?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         viewBox="0 0 80 80">
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                            <div class="solution-card-box">
                                                                <h5>{{ $homePage->section_seven_third_grid_title }}</h5>
                                                                <div class="text-white row">
                                                                    <div class="col-lg-12">
                                                                        <a href="{{ $homePage->section_seven_third_grid_button_link ?? 'javascript:void(0)' }}"
                                                                           class="mt-1 mb-3 learn_more_btn d-flex justify-content-between">
                                                                            <p class="p-0 pb-2 m-0">
                                                                                {{ $homePage->section_seven_third_grid_button_name ?? 'Learn More' }}
                                                                            </p>
                                                                            <p class="p-0 pb-2 m-0">
                                                                                <i class="fa-solid fa-plus"></i>
                                                                            </p>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif

                                        <!-- FOURTH GRID -->
                                        @if ($homePage->section_seven_fourth_grid_title)
                                            <div class="col-lg-6">
                                                <a href="{{ $homePage->section_seven_fourth_grid_button_link ?? 'javascript:void(0)' }}">
                                                    <div class="mt-2 shadow-lg card common-gradient"
                                                         style="border-top-right-radius: 40px; 
                                                                border-bottom-left-radius: 40px; 
                                                                border: 0px solid #fff;">
                                                        <div class="border-0 card-body">
                                                            <div class="icon-holder">
                                                                @if ($homePage->section_seven_fourth_grid_icon)
                                                                    <img src="{{ asset('storage/home-page/icon/' . $homePage->section_seven_fourth_grid_icon) }}"
                                                                         alt="{{ $homePage->section_seven_fourth_grid_title }}"
                                                                         style="width: 50px; height: 50px;" />
                                                                @else
                                                                    <?xml version="1.0" encoding="UTF-8"?>
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         viewBox="0 0 80 80">
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                            <div class="solution-card-box">
                                                                <h5>{{ $homePage->section_seven_fourth_grid_title }}</h5>
                                                                <div class="text-white row">
                                                                    <div class="col-lg-12">
                                                                        <a href="{{ $homePage->section_seven_fourth_grid_button_link ?? 'javascript:void(0)' }}"
                                                                           class="mt-1 mb-3 learn_more_btn d-flex justify-content-between">
                                                                            <p class="p-0 pb-2 m-0">
                                                                                {{ $homePage->section_seven_fourth_grid_button_name ?? 'Learn More' }}
                                                                            </p>
                                                                            <p class="p-0 pb-2 m-0">
                                                                                <i class="fa-solid fa-plus"></i>
                                                                            </p>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @push('scripts')
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
       <script>
    document.addEventListener("DOMContentLoaded", function() {
        var accordions = document.querySelectorAll('.accordion');

        accordions.forEach(function(accordion) {
            accordion.addEventListener('show.bs.collapse', function(event) {
                var currentlyOpen = accordion.querySelector('.show');
                if (currentlyOpen && currentlyOpen !== event.target) {
                    bootstrap.Collapse.getInstance(currentlyOpen).hide();
                }
            });
        });
    });

    $(document).ready(function() {
        console.log('%c[RFQ System Initialized for Home Page]', 'color: green; font-weight: bold;');
        
        // Store added products in localStorage to track added status
        let addedProducts = JSON.parse(localStorage.getItem('addedProducts') || '{}');
        
        // Update button states based on localStorage
        updateButtonStates();

        function handleAjaxError(xhr) {
            let message = 'Something went wrong. Please try again.';
            if (xhr.status === 419) {
                message = 'Session expired. Reloading...';
                Swal.fire({ 
                    icon: 'warning', 
                    title: 'Session Expired', 
                    text: message, 
                    showConfirmButton: false, 
                    timer: 1500, 
                    willClose: () => location.reload() 
                });
                return;
            }
            if (xhr.status === 500) message = 'Server error occurred.';
            else if (xhr.responseJSON?.message) message = xhr.responseJSON.message;
            Swal.fire({ icon: 'error', title: 'Error', text: message });
        }
        
        function updateButtonStates() {
            $('.add-to-rfq-btn').each(function() {
                const productId = $(this).data('product-id');
                if (addedProducts[productId]) {
                    // Update button to show "Added" state
                    $(this).addClass('btn-added');
                    $(this).find('.btn-text').addClass('d-none');
                    $(this).find('.btn-added-text').removeClass('d-none');
                } else {
                    // Update button to show "Add" state
                    $(this).removeClass('btn-added');
                    $(this).find('.btn-text').removeClass('d-none');
                    $(this).find('.btn-added-text').addClass('d-none');
                }
            });
        }
        
        function markProductAsAdded(productId) {
            addedProducts[productId] = true;
            localStorage.setItem('addedProducts', JSON.stringify(addedProducts));
            updateButtonStates();
        }
        
        function removeProductFromAdded(productId) {
            delete addedProducts[productId];
            localStorage.setItem('addedProducts', JSON.stringify(addedProducts));
            updateButtonStates();
        }
        
        function clearAllAddedProducts() {
            addedProducts = {};
            localStorage.removeItem('addedProducts');
            updateButtonStates();
        }
        
        function isProductAdded(productId) {
            return addedProducts[productId] || false;
        }

        // Add to RFQ for both buttons
        $('.add-to-rfq-btn').off('click').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevent card link navigation
            
            const button = $(this);
            const productId = button.data('product-id');
            const productName = button.data('product-name');
            const productSku = button.data('product-sku');
            const productBrand = button.data('product-brand');
            const productThumbnail = button.data('product-thumbnail');
            const originalHtml = button.html();
            
            // Check if product is already added
            if (isProductAdded(productId)) {
                Swal.fire({
                    icon: 'info',
                    title: 'Already Added',
                    text: `${productName} is already in your RFQ list.`,
                    showConfirmButton: true,
                    confirmButtonText: 'Go to RFQ',
                    showCancelButton: true,
                    cancelButtonText: 'Continue Browsing'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("rfq") }}';
                    }
                });
                return;
            }

            button.html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);

            $.ajax({
                url: '{{ route("cart.add") }}',
                method: 'POST',
                data: { 
                    _token: '{{ csrf_token() }}', 
                    product_id: productId, 
                    quantity: 1, 
                    is_rfq: true 
                },
                success: function(res) {
                    // Mark product as added
                    markProductAsAdded(productId);
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to RFQ!',
                        html: `<strong>${productName}</strong> has been added to your RFQ list.<br><small>SKU: ${productSku || 'N/A'}</small>`,
                        showConfirmButton: true,
                        confirmButtonText: 'View RFQ List',
                        showCancelButton: true,
                        cancelButtonText: 'Add More Items',
                        timer: 3000,
                        timerProgressBar: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = res.redirect_url || '{{ route("rfq") }}';
                        } else {
                            // Reset button to show "Added" state
                            button.html('<i class="fas fa-check me-1"></i> Added').prop('disabled', false);
                        }
                    });
                },
                error: function(xhr) {
                    // If AJAX fails, redirect directly to RFQ page with parameters
                    const rfqUrl = '{{ route("rfq") }}' +
                        '?product_id=' + productId +
                        '&product_name=' + encodeURIComponent(productName) +
                        '&product_sku=' + encodeURIComponent(productSku) +
                        '&product_brand=' + encodeURIComponent(productBrand) +
                        '&product_thumbnail=' + encodeURIComponent(productThumbnail) +
                        '&source=home_page&direct=true';
                    
                    Swal.fire({
                        icon: 'warning',
                        title: 'Redirecting to RFQ',
                        text: 'Adding product to quotation form...',
                        showConfirmButton: false,
                        timer: 1500,
                        willClose: () => {
                            // Mark product as added before redirecting
                            markProductAsAdded(productId);
                            window.location.href = rfqUrl;
                        }
                    });
                },
                complete: function() { 
                    if (!button.hasClass('btn-added')) {
                        button.html(originalHtml).prop('disabled', false); 
                    }
                }
            });
        });

        // Prevent card link from being clicked when button is clicked
        $('.url-box .card .add-to-rfq-btn').on('click', function(e) {
            e.stopPropagation();
        });
        
        // ============== SYNC WITH RFQ FORM SESSION ==============
        
        // Listen for session changes from RFQ form
        window.addEventListener('storage', function(e) {
            if (e.key === 'rfqSessionCleared') {
                clearAllAddedProducts();
                console.log('RFQ session cleared - resetting all buttons');
            }
            
            if (e.key === 'rfqItemRemoved') {
                const productId = e.newValue;
                if (productId) {
                    removeProductFromAdded(productId);
                    console.log(`Product ${productId} removed from session - resetting button`);
                }
            }
        });
        
        // Custom event listener for RFQ form actions
        document.addEventListener('rfqSessionCleared', function() {
            clearAllAddedProducts();
        });
        
        document.addEventListener('rfqItemRemoved', function(e) {
            const productId = e.detail?.productId;
            if (productId) {
                removeProductFromAdded(productId);
            }
        });
        
        // Check session status on page load
        $.ajax({
            url: '{{ route("rfq.get-session-status") }}',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const sessionItems = response.session_items || [];
                    
                    // Clear all added products
                    clearAllAddedProducts();
                    
                    // Mark only products that are currently in session
                    sessionItems.forEach(function(item) {
                        if (item.id) {
                            markProductAsAdded(item.id);
                        }
                    });
                    
                    console.log('Synced with RFQ session:', sessionItems.length, 'items');
                }
            },
            error: function() {
                console.log('Could not sync with RFQ session');
            }
        });
        
        // ============== END SYNC ==============
    });
</script>

    @endpush
</x-frontend-layout>