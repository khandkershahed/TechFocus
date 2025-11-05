@extends('frontend.master')

@section('metadata')
@endsection

@section('content')

<!-- Banner Section -->
<section class="ban_sec section_one">
    <div class="container-fluid p-0">
        <div class="ban_img">
            @if(isset($banners) && $banners->count() > 0)
                <div class="swiper bannerSwiper">
                    <div class="swiper-wrapper">
                        @foreach($banners as $banner)
                            @if($banner->image)
                                <div class="swiper-slide">
                                    <a href="{{ $banner->banner_link ?? '#' }}">
                                        <img src="{{ asset('uploads/page_banners/' . $banner->image) }}"
                                             class="img-fluid"
                                             alt="{{ $banner->title ?? 'Banner' }}"
                                             onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-banner(1920-330).png') }}';" />
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <img src="{{ asset('frontend/images/no-banner(1920-330).png') }}" class="img-fluid" alt="No Banner">
            @endif
        </div>
    </div>
</section>

<!-- Breadcrumbs -->
<div class="container my-3">
    <div class="breadcrumbs">
        <a href="{{ route('homepage') }}" class="fw-bold">Home</a> &gt;
        @if (!empty($category) && $category->parent_id)
            <a href="{{ route('category', optional($category->parent)->slug) }}" class="txt-mcl active">
                {{ optional($category->parent)->name }}
            </a> &gt;
        @endif
        <span class="txt-mcl active fw-bold">{{ optional($category)->name }}</span>
    </div>
</div>

<div class="container my-4">
    <div class="row">

        <!-- Subcategories / Left Column -->
        <div class="col-lg-8 col-sm-12">
            <h4 class="text-center border-bottom industry_title">{{ optional($category)->name }}</h4>

            <div class="hoverizeList mt-3">
                <ul class="category-grouplist category-list">
                    @forelse (($category->children->sortBy('name') ?? []) as $subcat)
                        <li>
                            <div class="imgSubCat {{ $loop->first ? '' : 'hidden' }}">
                                <img src="{{ !empty($subcat->image) && file_exists(public_path('storage/category/image/' . $subcat->image)) 
                                    ? asset('storage/category/image/' . $subcat->image) 
                                    : asset('frontend/images/no-brand-img.png') }}"
                                    alt="{{ $subcat->name }}" />
                            </div>

                            @if ($subcat->children->count() > 0)
                                <a href="{{ route('category', $subcat->slug) }}">{{ $subcat->name }}</a>
                            @else
                                <a href="{{ route('filtering.products', $subcat->slug) }}">{{ $subcat->name }}</a>
                            @endif
                        </li>
                    @empty
                        <p class="text-center">No subcategories found.</p>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Right Column: Newsletter -->
        <div class="col-lg-4 col-sm-12">
            <!-- Products -->
            <h4 class="text-center border-bottom industry_title">New Products</h4>
            @if(isset($products) && $products->count() > 0)
                <div class="row g-2">
                    @foreach ($products as $product)
                        <div class="col-6 col-md-3">
                            <a href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => $product->slug]) }}">
                                <img class="img-fluid w-100 border" src="{{ $product->thumbnail }}" alt="{{ $product->name }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center">No Products Found!</p>
            @endif
            <div class="bg-dark text-white p-4 mb-3 newsletter-card">
                <h4 class="fw-semibold mb-2">Subscribe to our newsletter</h4>
                <p class="small mb-3">Receive updates on this section every two weeks.</p>

                <form id="newsletterForm" class="d-flex">
                    @csrf
                    <input type="email" name="email" class="form-control rounded-0 border-0 me-2" placeholder="Enter your email" required>
                    <button type="submit" class="btn btn-warning rounded-0 px-3">OK</button>
                </form>

                <p class="mt-3 small">
                    <i>
                        Please refer to our <a href="#" class="text-warning">Privacy Policy</a>
                        for details on how DirectIndustry processes your personal data.
                    </i>
                </p>
            </div>
        </div>

    </div>
</div>

<!-- Styles -->
<style>
    .newsletter-card {
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .newsletter-card .btn-warning {
        background-color: #f7941d;
        color: #fff;
        border: none;
    }
    .newsletter-card .btn-warning:hover {
        background-color: #d97e12;
    }
</style>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#newsletterForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var url = "{{ route('newsletter.subscribe') }}";
            var token = $('input[name="_token"]', form).val();
            var email = $('input[name="email"]', form).val();

            $.ajax({
                url: url,
                method: "POST",
                data: {_token: token, email: email},
                success: function(response) {
                    form[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Subscribed!',
                        text: response.message || 'You have successfully subscribed!',
                        timer: 3000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    var errMsg = 'Something went wrong!';
                    if(xhr.responseJSON && xhr.responseJSON.message){
                        errMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errMsg,
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            });
        });
    });
</script>
@endsection
