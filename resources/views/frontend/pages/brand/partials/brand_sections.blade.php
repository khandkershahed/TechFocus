{{-- Top Brands --}}
<section class="mb-4">
    <div class="devider-wrap">
        <h4 class="mb-4 devider-content">
            <span class="devider-text">Top Brands</span>
        </h4>
    </div>

    <div class="row brand-logos">
        @if ($top_brands->count() > 0)
            @foreach ($top_brands as $brand)
                <div class="mb-3 col-lg-2 brand-card">
                    <div class="border-0 card card-news-trends">
                        <a href="{{ route('brand.overview', $brand->slug) }}">
                            <div class="content">
                                <div class="front">
                                    <div class="inset-img d-flex justify-content-center">
                                        <img src="{{ !empty($brand->logo) && file_exists(public_path('storage/brand/logo/' . $brand->logo)) ? asset('storage/brand/logo/' . $brand->logo) : asset('backend/images/no-image-available.png') }}"
                                            class="img-fluid" alt="{{ $brand->title }}">
                                    </div>
                                    <div class="p-2 d-flex align-items-center justify-content-center">
                                        <h2 class="text-center font-four">{{ $brand->title }}</h2>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center">
                <p>No top brands found.</p>
            </div>
        @endif
    </div>
</section>

{{-- Featured Brands --}}
<section class="mb-4">
    <div class="devider-wrap">
        <h4 class="mb-4 devider-content">
            <span class="devider-text">Featured Brands</span>
        </h4>
    </div>

    <div class="row brand-logos">
        @if ($featured_brands->count() > 0)
            @foreach ($featured_brands as $brand)
                <div class="mb-3 col-lg-2 brand-card">
                    <a href="{{ route('brand.overview', $brand->slug) }}">
                        <div class="border-0 card card-news-trends">
                            <div class="content">
                                <div class="front">
                                    <div class="inset-img d-flex justify-content-center">
                                        <img src="{{ !empty($brand->logo) && file_exists(public_path('storage/brand/logo/' . $brand->logo)) ? asset('storage/brand/logo/' . $brand->logo) : asset('backend/images/no-image-available.png') }}"
                                            class="img-fluid" alt="{{ $brand->title }}">
                                    </div>
                                    <div class="p-2 d-flex align-items-center justify-content-center">
                                        <h2 class="text-center font-four">{{ $brand->title }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center">
                <p>No featured brands found.</p>
            </div>
        @endif
    </div>
</section>
