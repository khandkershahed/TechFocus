@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
@include('frontend.pages.brandPage.partials.page_header')

<style>
    #main-product-image {
        height: 100% !important;
        object-fit: contain !important;
    }

    /* Image Gallery */
    .main-image {
        transition: all 0.3s ease;
    }

    .thumbnail-item {
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }

    .thumbnail-item:hover {
        transform: translateY(-2px);
        border-color: var(--primary-color);
    }

    .thumbnail-item.active {
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    /* Tabs */
    .nav-tabs .nav-link {
        color: var(--secondary-color);
        border: none;
        position: relative;
    }

    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
    }

    .nav-tabs .nav-link.active {
        color: var(--primary-color);
        background: transparent;
        border: none;
    }

    .nav-tabs .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--primary-color);
        border-radius: 3px 3px 0 0;
    }

    /* Content Areas */
    .specification-content,
    .description-content {
        line-height: 1.8;
        color: #333;
    }

    .specification-content ul,
    .description-content ul {
        padding-left: 1.5rem;
    }

    .specification-content li,
    .description-content li {
        margin-bottom: 0.5rem;
    }

    /* Button Hover Effects */
    .btn-primary {
        transition: all 0.3s ease;
        background: linear-gradient(135deg, var(--primary-color), #0b5ed7);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
    }

    .btn-outline-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.1);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .main-image .position-relative {
            height: 300px !important;
        }

        .nav-tabs .nav-link {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<!-- Main Product Container -->
<div class="container px-0 py-2">
    <!-- Product Details Card -->
    <div class="mb-4 overflow-hidden bg-white ">
        <div class="row g-0">
            <!-- Product Images Section -->
            <div class="p-4 col-lg-6 col-md-12">
                <div class="sticky-top" style="top: 20px;">
                    <!-- Main Image -->
                    <div class="mb-4 main-image">
                        <div class="overflow-hidden position-relative bg-light" style="height: 400px;">
                            <img id="main-product-image"
                                src="{{ asset($product->thumbnail) }}"
                                alt="{{ $product->name }}"
                                class="p-3 img-fluid w-100 h-100 object-fit-contain"
                                loading="lazy">
                            @if($product->featured || $product->new_arrival)
                            <div class="top-0 m-3 position-absolute start-0">
                                @if($product->new_arrival)
                                <span class="px-3 py-2 badge bg-success rounded-pill">NEW</span>
                                @endif
                                @if($product->featured)
                                <span class="px-3 py-2 badge bg-warning text-dark rounded-pill ms-1">FEATURED</span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Thumbnail Gallery -->
                    @if($product->multiImages->isNotEmpty())
                    <div class="thumbnail-gallery">
                        <div class="flex-wrap gap-2 d-flex">
                            <div class="thumbnail-item active"
                                data-image="{{ asset($product->thumbnail) }}"
                                style="width: 80px; height: 80px;">
                                <img src="{{ asset($product->thumbnail) }}"
                                    alt="Main"
                                    class="p-1 border img-fluid w-100 h-100 object-fit-contain rounded-2">
                            </div>
                            @foreach($product->multiImages as $multi_image)
                            <div class="thumbnail-item"
                                data-image="{{ asset($multi_image->photo) }}"
                                style="width: 80px; height: 80px;">
                                <img src="{{ asset($multi_image->photo) }}"
                                    alt="Gallery {{ $loop->iteration }}"
                                    class="p-1 border img-fluid w-100 h-100 object-fit-contain rounded-2">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Info Section -->
            <div class="p-4 col-lg-6 col-md-12 bg-light-subtle">
                <!-- Product Header -->
                <div class="mb-4">
                    <h1 class="mb-3 h2 fw-bold">{{ $product->name }}</h1>
                    <div class="mb-3 d-flex align-items-center">
                        @if($product->brand->logo)
                        <img src="{{ asset('storage/brand/logo/' . optional($product->brand)->logo) }}"
                            class="img-fluid me-3"
                            style="height: 40px;"
                            alt="{{ optional($product->brand)->title }}"
                            loading="lazy"
                            onerror="this.onerror=null; this.src='{{ asset('https://www.techfocusltd.com/storage/brand/logo/Schneider-Electric-logo_1OzdzFNM.png') }}';" />
                        @endif
                    </div>
                    <!-- Product Codes -->
                    <div class="flex-wrap gap-3 mb-4 d-flex">
                        @if(!empty($product->sku_code))
                        <div class="d-flex align-items-center">
                            <i class="fas fa-barcode text-muted me-2"></i>
                            <span class="small">
                                <strong class="text-dark">SKU:</strong>
                                <code class="ms-1">{{ $product->sku_code }}</code>
                            </span>
                        </div>
                        @endif
                        @if(!empty($product->mf_code))
                        <div class="d-flex align-items-center">
                            <i class="fas fa-fingerprint text-muted me-2"></i>
                            <span class="small">
                                <strong class="text-dark">MFG:</strong>
                                <code class="ms-1">{{ $product->mf_code }}</code>
                            </span>
                        </div>
                        @endif
                        @if(!empty($product->product_code))
                        <div class="d-flex align-items-center">
                            <i class="fas fa-hashtag text-muted me-2"></i>
                            <span class="small">
                                <strong class="text-dark">Code:</strong>
                                <code class="ms-1">{{ $product->product_code }}</code>
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- Short Description -->
                @if($product->short_desc)
                <div class="mb-4">
                    <h6 class="mb-2 text-uppercase text-muted fw-bold">Overview</h6>
                    <p cass="mb-0 text-uppercase">
                        {!! $product->short_desc !!}
                    </p>
                </div>
                @endif
                <!-- Action Buttons -->
                <div class="mb-5">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <button class="py-3 btn btn-primary w-100 fw-bold add-to-rfq-btn rounded-0"
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                data-product-sku="{{ $product->sku_code ?? '' }}"
                                data-product-brand="{{ $product->brand->name ?? '' }}"
                                data-product-thumbnail="{{ asset($product->thumbnail) }}">
                                <i class="fas fa-file-invoice-dollar me-2"></i>
                                Request Quote
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="py-3 btn btn-outline-primary w-100 fw-bold add-to-rfq-btn rounded-0"
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                data-product-sku="{{ $product->sku_code ?? '' }}"
                                data-product-brand="{{ $product->brand->name ?? '' }}"
                                data-product-thumbnail="{{ asset($product->thumbnail) }}">
                                <i class="fas fa-comments-dollar me-2"></i>
                                Get Pricing Options
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Additional Actions -->
                <div class="pt-4 border-top">
                    <div class="row g-3">
                        <!-- Favorites -->
                        <div class="col-md-6">
                            @auth
                            <form action="{{ route('favorites.store', $product->id) }}" method="POST" class="h-100">
                                @csrf
                                <button type="submit"
                                    class="btn btn-light w-100 h-100 d-flex align-items-center justify-content-center">
                                    <i class="fa-heart me-2 {{ Auth::user()->favourites->contains('product_id', $product->id) ? 'fas text-danger' : 'far' }}"></i>
                                    <span>{{ Auth::user()->favourites->contains('product_id', $product->id) ? 'Saved' : 'Save to Favorites' }}</span>
                                </button>
                            </form>
                            @else
                            <div class="dropdown h-100">
                                <button class="btn btn-light w-100 h-100 d-flex align-items-center justify-content-center dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="far fa-heart me-2"></i>
                                    <span>Save to Favorites</span>
                                </button>
                                <ul class="dropdown-menu w-100">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('login', ['type' => 'client', 'redirect_to' => url()->current(), 'product_id' => $product->id]) }}">
                                            <i class="fas fa-user me-2"></i> Login as Client
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('partner.login', ['type' => 'partner', 'redirect_to' => url()->current(), 'product_id' => $product->id]) }}">
                                            <i class="fas fa-handshake me-2"></i> Login as Partner
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            @endauth
                        </div>

                        <!-- Compare -->
                        <div class="col-md-6">
                            <a href="{{ route('products.compare.add', $product->id) }}"
                                class="btn btn-light w-100 h-100 d-flex align-items-center justify-content-center text-decoration-none">
                                <i class="fas fa-balance-scale me-2"></i>
                                <span>Compare Product</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Details Tabs -->
    @if(!empty($product->specification) || !empty($product->overview))
    <div class="mb-5 overflow-hidden bg-white">
        <div class="border-bottom">
            <ul class="border-0 nav nav-tabs" id="productTabs" role="tablist">
                @if(!empty($product->specification))
                <li class="nav-item" role="presentation">
                    <button class="px-4 py-3 nav-link active fw-medium"
                        id="specs-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#specs-content"
                        type="button"
                        role="tab">
                        <i class="fas fa-list-check me-2"></i> Specifications
                    </button>
                </li>
                @endif
                @if(!empty($product->overview))
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-3 fw-medium {{ empty($product->specification) ? 'active' : '' }}"
                        id="overview-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#overview-content"
                        type="button"
                        role="tab">
                        <i class="fas fa-file-lines me-2"></i> Description
                    </button>
                </li>
                @endif
            </ul>
        </div>

        <div class="p-4 tab-content p-md-5" id="productTabsContent">
            @if(!empty($product->specification))
            <div class="tab-pane fade show active"
                id="specs-content"
                role="tabpanel"
                tabindex="0">
                <div class="specification-content">
                    {!! $product->specification !!}
                </div>
            </div>
            @endif

            @if(!empty($product->overview))
            <div class="tab-pane fade {{ empty($product->specification) ? 'show active' : '' }}"
                id="overview-content"
                role="tabpanel"
                tabindex="0">
                <div class="description-content">
                    {!! $product->overview !!}
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Related Products Section (Optional - Add if you have related products) -->
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<div class="container px-0 py-2 mb-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h3 class="fw-bold">Related Products</h3>
        <a href="{{ route('category', $product->category->slug ?? '#') }}" class="text-primary text-decoration-none">
            View All <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="row g-4">
        @foreach($relatedProducts as $relatedProduct)
        <div class="col-md-3 col-sm-6">
            <!-- Add your product card component here -->
        </div>
        @endforeach
    </div>
</div>
@endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        console.log('%c[Product Page Initialized]', 'color: #0d6efd; font-weight: bold;');

        // Image Gallery Functionality
        $('.thumbnail-item').on('click', function() {
            const imageUrl = $(this).data('image');
            $('#main-product-image').attr('src', imageUrl);
            $('.thumbnail-item').removeClass('active');
            $(this).addClass('active');
        });

        // Tab Switching Animation
        $('#productTabs .nav-link').on('click', function() {
            $('#productTabs .nav-link').removeClass('active');
            $(this).addClass('active');
        });

        // Add to RFQ Functionality
        function handleAjaxError(xhr) {
            let message = 'Something went wrong. Please try again.';
            if (xhr.status === 419) {
                message = 'Session expired. Please refresh the page.';
                Swal.fire({
                    icon: 'warning',
                    title: 'Session Expired',
                    text: message,
                    showConfirmButton: true,
                    confirmButtonText: 'Refresh',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) location.reload();
                });
                return;
            }
            if (xhr.status === 500) message = 'Server error occurred.';
            else if (xhr.responseJSON?.message) message = xhr.responseJSON.message;

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonText: 'OK'
            });
        }

        // RFQ Button Handler
        $('.add-to-rfq-btn').off('click').on('click', function(e) {
            e.preventDefault();
            const button = $(this);
            const productId = button.data('product-id');
            const productName = button.data('product-name');
            const productSku = button.data('product-sku');
            const productBrand = button.data('product-brand');
            const originalHtml = button.html();

            // Add loading state
            button.html('<i class="fas fa-spinner fa-spin me-2"></i>Processing...')
                .prop('disabled', true)
                .addClass('disabled');

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
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to RFQ!',
                        text: 'Redirecting to quotation form...',
                        showConfirmButton: false,
                        timer: 1200,
                        willClose: () => {
                            window.location.href = res.redirect_url || '{{ route("rfq") }}';
                        }
                    });
                },
                error: function(xhr) {
                    // Fallback redirect
                    const rfqUrl = '{{ route("rfq") }}' +
                        '?product_id=' + productId +
                        '&product_name=' + encodeURIComponent(productName) +
                        '&product_sku=' + encodeURIComponent(productSku) +
                        '&product_brand=' + encodeURIComponent(productBrand) +
                        '&source=product_page&direct=true';

                    Swal.fire({
                        icon: 'info',
                        title: 'Redirecting to RFQ Form',
                        text: 'You will be redirected to complete your request',
                        showConfirmButton: false,
                        timer: 1500,
                        willClose: () => window.location.href = rfqUrl
                    });
                },
                complete: function() {
                    // Reset button state
                    button.html(originalHtml)
                        .prop('disabled', false)
                        .removeClass('disabled');
                }
            });
        });

        // Add smooth scrolling for tabs on mobile
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            if ($(window).width() < 768) {
                $('html, body').animate({
                    scrollTop: $('#productTabs').offset().top - 20
                }, 300);
            }
        });

        // Add to favorites feedback
        $('form[action*="favorites.store"]').on('submit', function(e) {
            const form = $(this);
            const button = form.find('button[type="submit"]');
            const originalText = button.find('span').text();

            if (originalText === 'Saved') {
                button.find('span').text('Saving...');
            } else {
                button.find('span').text('Adding...');
            }
        });
    });
</script>
@endsection