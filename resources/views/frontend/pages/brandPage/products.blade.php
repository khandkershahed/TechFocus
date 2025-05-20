@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    @include('frontend.pages.brandPage.partials.page_header')
    <!-- content start -->
    <div class="container">

        <div class="row mb-3 mt-5">
            <div class="col-lg-12">
                <p class="">ALL {{ $brand->title }} PRODUCTS</p>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-lg-12">
                <div class="devider-wrap">
                    <h4 class="devider-content">
                        <span class="devider-text">6-AXIS ROBOTIC ARMS</span>
                    </h4>
                </div>
            </div>
        </div> --}}
        <div class="row mb-5">
            @foreach ($brand->products as $product)
                <div class="col-lg-3 mb-4">
                    <div class="card projects-card rounded-0">
                        <div>
                            <p class="video-tag">New</p>
                        </div>
                        <a href="{{ route('product.details', ['id' => $product->brand->slug, 'slug' => $product->slug]) }}">
                            <img src="{{ $product->thumbnail }}" class="card-img-top img-fluid rounded-0"
                                alt="{{ $product->name }}" />
                        </a>
                        <div class="card-body mb-4">
                            <a
                                href="{{ route('product.details', ['id' => $product->brand->slug, 'slug' => $product->slug]) }}">
                                <p class="card-text project-para text-center" style="font-size: 15px">
                                    {{ Str::words($product->name, 15) }}
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
                                        <span class="product-badge" style="font-size: 13px"><i class="fa-solid fa-tag me-1 main-color"></i>SKU
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
        <!-- Related Search -->
        <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col p-0">
                    <div class="card rounded-0 border-0 shadow-sm">
                        <div class="card-header rounded-0">
                            <h4 class="pt-2 text-center">Related Searches</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <ul class="related-items">
                                        <li class="rounded-pill bg-light">
                                            <a href="">Rail conveyor</a>
                                        </li>
                                        <li class="rounded-pill bg-light">
                                            <a href="">Belt conveyor</a>
                                        </li>
                                        <li class="rounded-pill bg-light">
                                            <a href="">Transfer conveyor</a>
                                        </li>
                                        <li class="rounded-pill bg-light">
                                            <a href="">Part conveyor</a>
                                        </li>
                                        <li class="rounded-pill bg-light">
                                            <a href="">Compact conveyor</a>
                                        </li>
                                        <li class="rounded-pill bg-light">
                                            <a href="">Assembly line conveyor</a>
                                        </li>
                                        <li class="rounded-pill bg-light">
                                            <a href="">Linear transfer system</a>
                                        </li>
                                        <li class="rounded-pill bg-light">
                                            <a href="">Modular transfer system</a>
                                        </li>
                                        <li class="rounded-pill bg-light">
                                            <a href="">Robot transfer system</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-lg-12 col-sm-12">
                <p class="sub-color text-center w-75 mx-auto"> *Prices are pre-tax. They exclude delivery charges and
                    customs duties
                    and
                    do not include additional charges for installation or activation options. Prices are indicative only and
                    may
                    vary by country, with changes to the cost of raw materials and exchange rates. </p>
            </div>
        </div>
    </div>
@endsection
