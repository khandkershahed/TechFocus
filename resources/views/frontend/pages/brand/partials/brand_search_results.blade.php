<div class="row brand-logos">
    @if ($brands->count() > 0)
        @foreach ($brands as $brand)
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
            <p>No brands found matching your search.</p>
        </div>
    @endif
</div>

<div class="d-flex justify-content-center">
    {{ $brands->links() }}
</div>
