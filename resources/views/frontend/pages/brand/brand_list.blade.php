@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    <!--Banner -->
    <div class="swiper bannerSwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="https://img.directindustry.com/images_di/bnr/7990/hd/54364.jpg" class="img-fluid" alt="" />
            </div>
            <div class="swiper-slide">
                <img src="https://img.directindustry.com/images_di/bnr/7068/hd/55573v1.jpg" class="img-fluid" alt="" />
            </div>
            <div class="swiper-slide">
                <img src="https://img.directindustry.com/images_di/bnr/69508/hd/54314.jpg" class="img-fluid" alt="" />
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Search Bar -->
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-lg-12">
                <input type="text" id="productSearch" class="form-control" placeholder="Search products...">
            </div>
        </div>
    </div>

    <!-- content start -->
    <div class="container mb-5" id="brandsContainer">
        <section class="mb-4">
            <div class="devider-wrap">
                <h4 class="mb-4 devider-content">
                    <span class="devider-text">Top Brands</span>
                </h4>
            </div>
            <div class="row brand-logos">
                @if (count($top_brands) > 0)
                    @foreach ($top_brands as $top_brand)
                        <div class="mb-3 col-lg-2 brand-card">
                            <div class="border-0 card card-news-trends">
                                <a href="{{ route('brand.overview', $top_brand->slug) }}">
                                    <div class="content">
                                        <div class="front">
                                            <div class="inset-img d-flex justify-content-center">
                                                <img src="{{ !empty($top_brand->logo) && file_exists(public_path('storage/brand/logo/' . $top_brand->logo)) ? asset('storage/brand/logo/' . $top_brand->logo) : asset('backend/images/no-image-available.png') }}"
                                                    class="img-fluid" alt="{{ $top_brand->title }}">
                                            </div>
                                            <div class="p-2 d-flex align-items-center justify-content-center">
                                                <h2 class="text-center font-four">{{ $top_brand->title }}</h2>
                                            </div>
                                        </div>
                                        <div class="back from-bottom text-start">
                                            <span class="pt-4 font-two">{{ $top_brand->title }}</span>
                                            <br>
                                            <p class="subtitles"></p>
                                            <a href="{{ route('brand.overview', $top_brand->slug) }}" class="mt-5 btn common-btn-3 rounded-0">Learn More</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="d-flex justify-content-center">
                {{ $top_brands->links() }}
            </div>
        </section>

        <section class="mb-4">
            <div class="devider-wrap">
                <h4 class="mb-4 devider-content">
                    <span class="devider-text">Featured Brands</span>
                </h4>
            </div>
            <div class="row brand-logos">
                @if (count($featured_brands) > 0)
                    @foreach ($featured_brands as $featured_brand)
                        <div class="mb-3 col-lg-2 brand-card">
                            <a href="{{ route('brand.overview', $featured_brand->slug) }}">
                                <div class="border-0 card card-news-trends">
                                    <div class="content">
                                        <div class="front">
                                            <div class="inset-img d-flex justify-content-center">
                                                <img src="{{ !empty($featured_brand->logo) && file_exists(public_path('storage/brand/logo/' . $featured_brand->logo)) ? asset('storage/brand/logo/' . $featured_brand->logo) : asset('backend/images/no-image-available.png') }}"
                                                    class="img-fluid" alt="{{ $featured_brand->title }}">
                                            </div>
                                            <div class="p-2 d-flex align-items-center justify-content-center">
                                                <h2 class="text-center font-four">{{ $featured_brand->title }}</h2>
                                            </div>
                                        </div>
                                        <div class="back from-bottom text-start">
                                            <span class="pt-3 font-two">{{ $featured_brand->title }}</span>
                                            <br>
                                            <p class="subtitles"></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="d-flex justify-content-center">
                {{ $featured_brands->links() }}
            </div>
        </section>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#productSearch').on('keyup', function() {
            let query = $(this).val();

            $.ajax({
                url: "{{ route('search.products') }}",
                type: "GET",
                data: { search: query },
                success: function(data) {
                    $('#brandsContainer').html(data); // update brands container with results
                }
            });
        });
    });
</script>
@endsection
