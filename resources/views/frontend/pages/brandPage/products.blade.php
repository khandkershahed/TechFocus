@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    @include('frontend.pages.brandPage.partials.page_header')
    <!-- content start -->
    <div class="container">
        <div class="row">
            <div class="px-0 col-lg-12">
                <div class="devider-wrap">
                    <h4 class="devider-content">
                        <span class="devider-text">ALL {{ $brand->title }} PRODUCTS</span>
                    </h4>
                </div>
            </div>
        </div>
        <div class="mb-5 row">
            @foreach ($brand->products as $product)
                <div class="mb-3 col-lg-3 ps-0">
                    <div class="overflow-hidden card projects-card rounded-0">
                        <div class="badge-new">
                            <span class="">New</span>
                        </div>
                        <a href="{{ route('product.details', ['id' => $product->brand->slug, 'slug' => $product->slug]) }}">
                            <img src="{{ $product->thumbnail }}" class="p-card-img-top img-fluid rounded-0"
                                alt="{{ $product->name }}" />
                        </a>
                        <div class="pb-4 card-body">
                            <a
                                href="{{ route('product.details', ['id' => $product->brand->slug, 'slug' => $product->slug]) }}">
                                <p class="text-center card-text project-para" style="font-size: 14px">
                                    {{ Str::words($product->name, 10) }}
                                </p>
                            </a>
                            <div class="text-center">
                                <a
                                    href="{{ route('product.details', ['id' => $product->brand->slug, 'slug' => $product->slug]) }}">
                                    @if (!empty($brand->title))
                                        <span class="product-badge"><i
                                                class="fa-solid fa-tag me-1 main-color"></i>Manufacturer
                                            : {{ $brand->title }}</span>
                                            <br>
                                    @endif
                                    @if (!empty($product->sku_code))
                                        <span class="product-badge" style="font-size: 12px"><i class="fa-solid fa-tag me-1 main-color"></i>SKU
                                            #{{ $product->sku_code }}</span>
                                    @endif
                                    @if (!empty($product->mf_code))
                                        <span class="product-badge" style="font-size: 13px"><i class="fa-solid fa-tag me-1 main-color"></i>MF
                                            #{{ $product->mf_code }}</span>
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
      <!-- Related Brands -->
<div class="container">
    <div class="mt-5 mb-5 row">
        <div class="p-0 col">
            <div class="border-0 shadow-sm card rounded-0">
                <div class="card-header rounded-0">
                    <h4 class="pt-2 text-center">Related Brands</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="related-items d-flex flex-wrap gap-2 list-unstyled">

                                @forelse($relatedBrands as $relatedBrand)
                                    <li class="rounded-pill bg-light px-3 py-1">
                                        <a href="{{ route('brand.overview', $relatedBrand->slug) }}"
                                           class="text-decoration-none text-dark">
                                            {{ $relatedBrand->title }}
                                        </a>
                                    </li>
                                @empty
                                    <li>No related brands found</li>
                                @endforelse

                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

        <div class="p-3 row">
            <div class="col-lg-12 col-sm-12">
                <p class="mx-auto text-center sub-color w-75"> *Prices are pre-tax. They exclude delivery charges and
                    customs duties
                    and
                    do not include additional charges for installation or activation options. Prices are indicative only and
                    may
                    vary by country, with changes to the cost of raw materials and exchange rates. </p>
            </div>
        </div>
    </div>
@endsection
