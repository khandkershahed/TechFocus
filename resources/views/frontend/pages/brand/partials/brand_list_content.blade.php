<!-- Search Results -->
{{-- <div class="search-info mb-3 p-3 bg-light rounded">
    <small class="text-muted">
        @if(request()->has('search') && !empty(request('search')))
            Showing results for: "<strong>{{ request('search') }}</strong>"
        @else
            Showing all brands
        @endif
    </small>
</div> --}}

<section class="mb-4">
    <div class="devider-wrap">
        <h4 class="mb-4 devider-content">
            <span class="devider-text">Top Brands</span>
            {{-- <small class="text-muted">({{ $top_brands->total() }} found)</small> --}}
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
        @else
            <div class="col-12 text-center py-4">
                <p class="text-muted">No top brands found.</p>
            </div>
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
            {{-- <small class="text-muted">({{ $featured_brands->total() }} found)</small> --}}
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
        @else
            <div class="col-12 text-center py-4">
                <p class="text-muted">No featured brands found.</p>
            </div>
        @endif
    </div>
    <div class="d-flex justify-content-center">
        {{ $featured_brands->links() }}
    </div>
</section>