<div class="mt-3 row gx-3">
    @forelse ($products as $product)
        <div class="mb-3 col-lg-3 col-sm-12">
            <div class="overflow-hidden border-0 shadow-sm card rounded-4 card-hover h-100">
                <div class="position-relative">
                    <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-100" style="height: 100%; object-fit: cover;">
                    <!-- Brand Logo -->
                    <a href="{{ route('brand.overview', optional($product->brand)->slug) }}"
                        class="top-0 p-1 m-2 bg-white rounded shadow-sm position-absolute end-0">
                        <img src="{{ asset('storage/brand/logo/' . optional($product->brand)->logo) }}"
                             alt="{{ optional($product->brand)->title }}"
                             class="img-fluid" style="width: 60px; object-fit: contain;"
                             onerror="this.onerror=null;this.src='https://www.techfocusltd.com/storage/brand/logo/apc-logo_AndEzWuc.png';">
                    </a>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <a href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => $product->slug]) }}"
                       class="text-decoration-none text-dark">
                        <h6 class="mb-2 fw-bold text-truncate">{{ Str::words($product->name, 7) }}</h6>
                    </a>
                    <p class="mb-3 text-muted small">{!! Str::words($product->short_desc, 8) !!}</p>
                    <div class="mt-auto">
                        <a href="{{ route('product.details', ['id' => optional($product->brand)->slug, 'slug' => $product->slug]) }}"
                           class="btn btn-sm btn-outline-primary w-100 rounded-pill">
                           <i class="fa-solid fa-circle-info me-1"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 text-muted">No products found.</div>
    @endforelse

    <!-- Pagination -->
    @if (!$products->isEmpty())
        <div class="col-12">
            <div class="d-flex justify-content-center mt-3">
                {{ $products->links() }}
            </div>
        </div>
    @endif
</div>
