@php
function highlight($text, $search) {
    if(!$search) return $text;
    return preg_replace("/($search)/i", '<span class="bg-warning">$1</span>', $text);
}
@endphp

<section class="mb-4">
    <div class="devider-wrap">
        <h4 class="mb-4 devider-content">
            <span class="devider-text">Top Brands</span>
        </h4>
    </div>
    <div class="row brand-logos">
        @forelse($top_brands as $top_brand)
        <div class="mb-3 col-lg-2 col-md-3 col-sm-4">
            <div class="border-0 card card-news-trends">
                <a href="{{ route('brand.overview', $top_brand->slug) }}">
                    <div class="content text-center">
                        <img src="{{ !empty($top_brand->logo) && file_exists(public_path('storage/brand/logo/' . $top_brand->logo)) ? asset('storage/brand/logo/' . $top_brand->logo) : asset('backend/images/no-image-available.png') }}" class="img-fluid" alt="{{ $top_brand->title }}">
                        <h2 class="mt-2">{!! highlight($top_brand->title, $search ?? '') !!}</h2>
                    </div>
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-4">No Top Brands found.</div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center">{{ $top_brands->links() }}</div>
</section>

<section class="mb-4">
    <div class="devider-wrap">
        <h4 class="mb-4 devider-content">
            <span class="devider-text">Featured Brands</span>
        </h4>
    </div>
    <div class="row brand-logos">
        @forelse($featured_brands as $featured_brand)
        <div class="mb-3 col-lg-2 col-md-3 col-sm-4">
            <div class="border-0 card card-news-trends">
                <a href="{{ route('brand.overview', $featured_brand->slug) }}">
                    <div class="content text-center">
                        <img src="{{ !empty($featured_brand->logo) && file_exists(public_path('storage/brand/logo/' . $featured_brand->logo)) ? asset('storage/brand/logo/' . $featured_brand->logo) : asset('backend/images/no-image-available.png') }}" class="img-fluid" alt="{{ $featured_brand->title }}">
                        <h2 class="mt-2">{!! highlight($featured_brand->title, $search ?? '') !!}</h2>
                    </div>
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-4">No Featured Brands found.</div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center">{{ $featured_brands->links() }}</div>
</section>
