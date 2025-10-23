@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    @include('frontend.pages.brandPage.partials.page_header')
    <!-- content start -->
    <div class="container">
        <!-- Product Details -->
        <div class="row align-items-center">
            <div class="col-lg-12 col-sm-12">
                <div class="p-5 border-0 card rounded-0">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="xzoom-container w-100">
                                <!-- Main Image Default Show -->
                                <a data-fancybox-trigger="gallery" href="javascript:;">
                                    <img class="xzoom" id="xzoom-default" src="{{ asset($product->thumbnail) }}"
                                        xoriginal="{{ asset($product->thumbnail) }}" width="100%" height="100%" />
                                </a>
                                <!-- Main Image Default Show End-->
                                @if ($product->multiImages->isNotEmpty())
                                    <div class="xzoom-thumbs">
                                        @foreach ($product->multiImages as $multi_image)
                                            <a class="popup" data-fancybox="gallery"
                                                href="{{ asset($multi_image->photo) }}"><img class="xzoom-gallery"
                                                    src="{{ asset($multi_image->photo) }}"
                                                    xpreview="{{ asset($multi_image->photo) }}" width="80"
                                                    height="80" />
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div>
                                <div class="px-2 row gx-0">
                                    <h4>{{ $product->name }}</h4>
                                    <ul class="p-1 d-flex align-items-center">
                                        @if (!empty($product->sku_code))
                                            <li class="me-2">
                                                <p class="p-0 m-0" style="color: rgb(134, 134, 134);font-size: 13px;"><i
                                                        class="fa-solid fa-tag me-1 single-bp-tag"></i><strong>NG #
                                                    </strong>{{ $product->sku_code }}</p>
                                            </li>
                                        @endif
                                        @if (!empty($product->mf_code))
                                            <li class="me-2">
                                                <p class="p-0 m-0" style="color: rgb(134, 134, 134);font-size: 13px;"><i
                                                        class="fa-solid fa-tag me-1 single-bp-tag"></i><strong>MF #
                                                    </strong>{{ $product->mf_code }}</p>
                                            </li>
                                        @endif
                                        @if (!empty($product->product_code))
                                            <li class="me-1">
                                                <p class="p-0 m-0" style="color: rgb(134, 134, 134);font-size: 13px;"><i
                                                        class="fa-solid fa-tag me-1 single-bp-tag"></i><strong>SKU #
                                                    </strong>{{ $product->product_code }}
                                                </p>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <p class="pt-3">Manufactured by:</p>
                                <div class="d-flex align-items-center fw-bold">
                                    <h2 class="font-monospace">{{ $product->brand->name }}</h2>
                                </div>
                                
                                <!-- Seller Info -->
                                <div class="pt-2">
                                    <span><i class="fa-regular main-color fa-clock"></i> This
                                        seller generally responds in under 48 hours</span>
                                </div>
                                
                                <!-- Button Area -->
                                <div class="mt-5">
                                    <button class="btn btn-outline-danger rounded-0 add-to-cart-btn" 
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-price="{{ $product->sas_price ?? 0 }}"
                                            data-product-thumbnail="{{ asset($product->thumbnail) }}">
                                        <i class="fas fa-shopping-cart me-2"></i> $ Request Price Options
                                    </button>
                                    
                                    <button class="w-auto btn signin rounded-0 add-to-cart-and-rfq" 
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-sku="{{ $product->sku_code ?? '' }}"
                                            data-product-brand="{{ $product->brand->name ?? '' }}"
                                            data-product-thumbnail="{{ asset($product->thumbnail) }}">
                                        Get Quote
                                    </button>
                                </div>
                                
                                <!-- Product Short Desc -->
                                <div class="mt-3">
                                    <p class="text-justify">
                                        {!! $product->short_desc !!}
                                    </p>
                                </div>
                                
                                <!-- Others Button -->
                                <div class="mt-4 d-flex main-color">
                                    @auth
                                        <form action="{{ route('favorites.store', $product->id) }}" method="POST" class="me-2">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 text-decoration-none main-color">
                                                <i class="fa-solid fa-heart me-1"></i>
                                                @if(Auth::user()->favourites->contains('product_id', $product->id))
                                                    Added to Favorites
                                                @else
                                                    Add to Favorites
                                                @endif
                                            </button>
                                        </form>
                                    @else
                                        <div class="dropdown me-2">
                                            <a class="btn btn-link dropdown-toggle p-0 text-decoration-none main-color" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-heart me-1"></i> Add to Favorites
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('login', ['type' => 'client', 'redirect_to' => url()->current(), 'product_id' => $product->id]) }}">
                                                        Login as Client
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('partner.login', ['type' => 'partner', 'redirect_to' => url()->current(), 'product_id' => $product->id]) }}">
                                                        Login as Partner
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endauth
                                    
                                    <div class="mt-4 d-flex main-color">
                                        <a href="{{ route('products.compare.add', $product->id) }}" class="text-decoration-none main-color me-2">
                                            <i class="fa-solid fa-table-columns me-1"></i> Compare this product
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product Specification & Overview -->
        <div class="mt-5 mb-5 row">
            @if (!empty($product->specification)) 
                <div class="{{ !empty($product->overview) ? 'col-lg-6' : 'col-lg-12' }}">
                    <div class="single-product-description" style="font-size: 16px">
                        <h2 class="description-title">Specification</h2>
                        <div class="container pb-3 specification-areas-brand">
                            <div class="px-2 row gx-1">
                                <p>{!! $product->specification !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (!empty($product->overview)) 
                <div class="{{ !empty($product->specification) ? 'col-lg-6' : 'col-lg-12' }}">
                    <div class="text-justify single-product-description" style="font-size: 16px; line-height: 1.5">
                        <h2 class="description-title">Description</h2>
                        <div class="container pb-3">
                            <div class="row ps-2">
                                <p>{!! $product->overview !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    console.log('Cart system initialized');

    // Test the debug endpoint first
    function testCartSystem() {
        console.log('Testing cart system...');
        $.get('{{ route("cart.debug") }}', function(response) {
            console.log('Debug test result:', response);
        }).fail(function(xhr) {
            console.error('Debug test failed:', xhr);
        });
    }

//     // Run test on page load
//     testCartSystem();

//     // Regular Add to Cart functionality
//     $('.add-to-cart-btn').click(function(e) {
//         e.preventDefault();
//         console.log('Add to cart clicked');
        
//         const button = $(this);
//         const productId = button.data('product-id');
//         const productName = button.data('product-name');
//         const originalHtml = button.html();
        
//         console.log('Product details:', { id: productId, name: productName });
        
//         // Show loading
//         button.html('<i class="fa fa-spinner fa-spin"></i> Adding...');
//         button.prop('disabled', true);
        
//         // Simple AJAX request
//         $.ajax({
//             url: '{{ route("cart.add") }}',
//             method: 'POST',
//             data: {
//                 _token: '{{ csrf_token() }}',
//                 product_id: productId,
//                 quantity: 1
//             },
//             success: function(response) {
//                 console.log('Success response:', response);
                
//                 if (response.success) {
//                     Swal.fire({
//                         icon: 'success',
//                         title: 'Success!',
//                         text: response.message,
//                         showConfirmButton: false,
//                         timer: 2000
//                     });
                    
//                     // Update cart count
//                     if (response.cart_count !== undefined) {
//                         $('.cart-count, #cart-count').text(response.cart_count);
//                         console.log('Cart count updated to:', response.cart_count);
//                     }
//                 } else {
//                     Swal.fire({
//                         icon: 'error',
//                         title: 'Error',
//                         text: response.message
//                     });
//                 }
//             },
//             error: function(xhr, status, error) {
//                 console.error('AJAX Error Details:', {
//                     status: xhr.status,
//                     statusText: xhr.statusText,
//                     responseText: xhr.responseText,
//                     error: error
//                 });
                
//                 let errorMessage = 'Failed to add product to cart. ';
                
//                 if (xhr.status === 500) {
//                     errorMessage += 'Server error occurred. ';
                    
//                     try {
//                         const response = JSON.parse(xhr.responseText);
//                         if (response.message) {
//                             errorMessage += 'Details: ' + response.message;
//                         }
//                     } catch (e) {
//                         errorMessage += 'Please check the console for details.';
//                     }
                    
//                     Swal.fire({
//                         icon: 'error',
//                         title: 'Server Error (500)',
//                         text: errorMessage,
//                         footer: '<a href="#" onclick="location.reload()">Click to refresh page</a>'
//                     });
//                 } else if (xhr.status === 419) {
//                     errorMessage = 'Session expired. Refreshing page...';
//                     Swal.fire({
//                         icon: 'warning',
//                         title: 'Session Expired',
//                         text: errorMessage,
//                         showConfirmButton: false,
//                         timer: 2000,
//                         willClose: () => location.reload()
//                     });
//                 } else {
//                     errorMessage += 'Please try again.';
//                     Swal.fire({
//                         icon: 'error',
//                         title: 'Error ' + xhr.status,
//                         text: errorMessage
//                     });
//                 }
//             },
//             complete: function() {
//                 button.html(originalHtml);
//                 button.prop('disabled', false);
//             }
//         });
//     });

//     // Get Quote - Add to RFQ Session then Redirect to RFQ
//     $('.add-to-cart-and-rfq').click(function(e) {
//         e.preventDefault();
//         console.log('Get Quote clicked');
        
//         const button = $(this);
//         const productId = button.data('product-id');
//         const productName = button.data('product-name');
//         const originalHtml = button.html();
        
//         console.log('Product details for RFQ:', { 
//             id: productId, 
//             name: productName
//         });
        
//         // Show loading
//         button.html('<i class="fa fa-spinner fa-spin"></i> Processing...');
//         button.prop('disabled', true);
        
//         // Add to RFQ session using the updated CartController
//         $.ajax({
//             url: '{{ route("cart.add") }}',
//             method: 'POST',
//             data: {
//                 _token: '{{ csrf_token() }}',
//                 product_id: productId,
//                 quantity: 1,
//                 is_rfq: true // This tells the backend to add to RFQ session
//             },
//             success: function(response) {
//                 console.log('Add to RFQ session success:', response);
                
//                 if (response.success) {
//                     // Redirect to RFQ form - no need for URL parameters since data is in session
//                     const rfqUrl = '{{ route("rfq") }}?source=session';
                    
//                     // Show success message briefly, then redirect
//                     Swal.fire({
//                         icon: 'success',
//                         title: 'Added to RFQ!',
//                         text: 'Redirecting to quotation form...',
//                         showConfirmButton: false,
//                         timer: 1500,
//                         willClose: () => {
//                             window.location.href = rfqUrl;
//                         }
//                     });
                    
//                 } else {
//                     Swal.fire({
//                         icon: 'error',
//                         title: 'Error',
//                         text: response.message || 'Failed to add product to RFQ.'
//                     });
//                     button.html(originalHtml);
//                     button.prop('disabled', false);
//                 }
//             },
//             error: function(xhr, status, error) {
//                 console.error('Add to RFQ session error:', error);
                
//                 // Fallback: redirect to RFQ with direct parameters if session fails
//                 const productSku = button.data('product-sku');
//                 const productBrand = button.data('product-brand');
                
//                 const rfqUrl = '{{ route("rfq") }}' + 
//                               '?product_id=' + productId + 
//                               '&product_name=' + encodeURIComponent(productName) +
//                               '&product_sku=' + encodeURIComponent(productSku) +
//                               '&product_brand=' + encodeURIComponent(productBrand) +
//                               '&source=product_page&direct=true';
                
//                 Swal.fire({
//                     icon: 'warning',
//                     title: 'Proceeding to RFQ',
//                     text: 'Product information will be included in your quote request.',
//                     showConfirmButton: false,
//                     timer: 1500,
//                     willClose: () => {
//                         window.location.href = rfqUrl;
//                     }
//                 });
//             }
//         });
//     });

//     // Update cart count on page load
//     function updateCartCount() {
//         $.get('{{ route("cart.count") }}', function(response) {
//             if (response.success) {
//                 $('.cart-count, #cart-count').text(response.count);
//             }
//         });
//     }

//     // Update RFQ count on page load
//     function updateRfqCount() {
//         $.get('{{ route("cart.rfq-count") }}', function(response) {
//             if (response.success) {
//                 $('.rfq-count, #rfq-count').text(response.count);
//             }
//         });
//     }

//     // Initialize counts
//     updateCartCount();
//     updateRfqCount();
// });
// </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    console.log('%c[Cart + RFQ System Initialized]', 'color: green; font-weight: bold;');

    /** ============================
     *  ✅ CART: Add Product (Request Price)
     * ============================ */
    $('.add-to-cart-btn').off('click').on('click', function(e) {
        e.preventDefault();

        const button = $(this);
        const productId = button.data('product-id');
        const productName = button.data('product-name');
        const productPrice = button.data('product-price') ?? 0;
        const originalHtml = button.html();

        console.log('[Cart] Adding product:', { id: productId, name: productName });

        button.html('<i class="fa fa-spinner fa-spin"></i> Adding...').prop('disabled', true);

        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                quantity: 1 // Always 1 item only
            },
            success: function(response) {
                console.log('[Cart] Success:', response);

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart!',
                        text: response.message || `${productName} added to your cart.`,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Update cart count if available
                    if (response.cart_count !== undefined) {
                        $('.cart-count, #cart-count').text(response.cart_count);
                        console.log('[Cart] Updated count:', response.cart_count);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Could not add product to cart.'
                    });
                }
            },
            error: function(xhr) {
                console.error('[Cart] AJAX Error:', xhr);
                handleAjaxError(xhr, 'cart');
            },
            complete: function() {
                button.html(originalHtml).prop('disabled', false);
            }
        });
    });

    /** ============================
     *  ✅ RFQ: Add Product + Redirect
     * ============================ */
    $('.add-to-cart-and-rfq').off('click').on('click', function(e) {
        e.preventDefault();

        const button = $(this);
        const productId = button.data('product-id');
        const productName = button.data('product-name');
        const productSku = button.data('product-sku');
        const productBrand = button.data('product-brand');
        const originalHtml = button.html();

        console.log('[RFQ] Adding product to RFQ:', { id: productId, name: productName });

        button.html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);

        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                quantity: 1, // Always 1 only
                is_rfq: true
            },
            success: function(response) {
                console.log('[RFQ] Success:', response);

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to RFQ!',
                        text: 'Redirecting to quotation form...',
                        showConfirmButton: false,
                        timer: 1200,
                        willClose: () => {
                            window.location.href = '{{ route("rfq") }}?source=session';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Could not add product to RFQ.'
                    });
                }
            },
            error: function(xhr) {
                console.error('[RFQ] AJAX Error:', xhr);

                // Fallback redirect if session RFQ fails
                const rfqUrl = '{{ route("rfq") }}'
                    + '?product_id=' + productId
                    + '&product_name=' + encodeURIComponent(productName)
                    + '&product_sku=' + encodeURIComponent(productSku)
                    + '&product_brand=' + encodeURIComponent(productBrand)
                    + '&source=product_page&direct=true';

                Swal.fire({
                    icon: 'warning',
                    title: 'Redirecting to RFQ',
                    text: 'Session unavailable — redirecting directly...',
                    showConfirmButton: false,
                    timer: 1500,
                    willClose: () => {
                        window.location.href = rfqUrl;
                    }
                });
            },
            complete: function() {
                button.html(originalHtml).prop('disabled', false);
            }
        });
    });

    /** ============================
     *  ✅ Helper: Update Counts
     * ============================ */
    function updateCartCount() {
        $.get('{{ route("cart.count") }}', function(response) {
            if (response.success) $('.cart-count, #cart-count').text(response.count);
        });
    }

    function updateRfqCount() {
        $.get('{{ route("cart.rfq-count") }}', function(response) {
            if (response.success) $('.rfq-count, #rfq-count').text(response.count);
        });
    }

    /** ============================
     *  ⚙️ Helper: Handle AJAX Errors
     * ============================ */
    function handleAjaxError(xhr, context) {
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

        if (xhr.status === 500) {
            message = 'Server error occurred. Check console for details.';
        } else if (xhr.responseJSON?.message) {
            message = xhr.responseJSON.message;
        }

        Swal.fire({
            icon: 'error',
            title: context === 'cart' ? 'Cart Error' : 'RFQ Error',
            text: message
        });
    }

    /** Initialize counts on load */
    updateCartCount();
    updateRfqCount();
});
</script>


@endsection