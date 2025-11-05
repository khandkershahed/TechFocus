@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    <!-- Banner Section -->
    <section class="ban_sec section_one">
        <div class="p-0 container-fluid">
            <div class="ban_img">
                @if($banners->count() > 0)
                    <div class="swiper bannerSwiper">
                        <div class="swiper-wrapper">
                            @foreach($banners as $banner)
                                @if($banner->image)
                                    <div class="swiper-slide">
                                        <a href="{{ $banner->banner_link ?? '#' }}">
                                            <img src="{{ asset('uploads/page_banners/' . $banner->image) }}"
                                                 class="img-fluid"
                                                 alt="{{ $banner->title ?? 'Banner' }}"
                                                 onerror="this.onerror=null;this.src='{{ asset('/img/TechFocus-Catalog-Page-Banner-(1920x525).png') }}';" />
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    <img src="{{ asset('/img/TechFocus-Catalog-Page-Banner-(1920x525).png') }}" class="img-fluid" alt="No Banner">
                @endif
            </div>
        </div>
    </section>

    <!-- Catalogs Section -->
    <div class="container my-4 mt-5">
        <div class="row">
            <div class="col-lg-3">
                <h6 class="mb-3">Catalogs by Categories</h6>
                <ul class="nav nav-tabs flex-column" id="myTab" role="tablist">
                    <li class="p-0 mt-1 border nav-item" role="presentation">
                        <span class="nav-link ps-3 active" id="home-tab" data-bs-toggle="tab"
                              data-bs-target="#home" type="button" role="tab">All</span>
                    </li>
                    @foreach($catalogCategories as $key => $category)
                        <li class="p-0 mt-1 border nav-item" role="presentation">
                            <span class="nav-link ps-3" id="category-item-{{ $key }}-tab" data-bs-toggle="tab"
                                  data-bs-target="#category-item-{{ $key }}" type="button" role="tab">
                                {{ ucfirst($category) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-9">
                <div class="tab-content" id="myTabContent">
                    <!-- All Catalogs Tab -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <div class="row">
                            @forelse($allCatalogs as $catalog)
                                <div class="mb-4 col-lg-3 col-md-4 col-sm-6">
                                    <div class="card projects-card rounded-0 h-100 catalog-card"
                                         style="cursor: pointer;"
                                         data-pdf-url="{{ $catalog->document ? asset('storage/catalog/document/' . $catalog->document) : '' }}">
                                        <img src="{{ $catalog->thumbnail ? asset('storage/catalog/thumbnail/' . $catalog->thumbnail) : asset('frontend/images/no-shop-imge.png') }}"
                                             class="card-img-top img-fluid rounded-0"
                                             alt="{{ $catalog->name }}"
                                             style="height: 200px; object-fit: cover;" 
                                             onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';"/>
                                        <div class="card-body d-flex flex-column">
                                            <p class="text-center flex-grow-1">{{ $catalog->name }}</p>

                                            {{-- Catalog Logo with Debugging --}}
                                            @php
                                                $logoUrl = asset('frontend/images/no-shop-imge.png');
                                                $logoTitle = 'No Logo';
                                                $logoAlt = 'No Logo';

                                                // Debug information
                                                $debugInfo = [
                                                    'category' => $catalog->category,
                                                    'brands_count' => $catalog->brands->count(),
                                                    'companies_count' => $catalog->companies->count(),
                                                    'brand_id' => $catalog->brand_id,
                                                    'company_id' => $catalog->company_id
                                                ];

                                                if($catalog->category == 'brand' && $catalog->brands->count() > 0) {
                                                    $firstBrand = $catalog->brands->first();
                                                    if($firstBrand && $firstBrand->logo) {
                                                        $logoUrl = asset('storage/brand/logo/' . $firstBrand->logo);
                                                        $logoTitle = $firstBrand->title;
                                                        $logoAlt = $firstBrand->title;
                                                    } else {
                                                        // If brand exists but no logo, use brand name as text
                                                        $logoTitle = $firstBrand->title ?? 'Brand';
                                                        $logoAlt = $firstBrand->title ?? 'Brand';
                                                    }
                                                } elseif($catalog->category == 'company' && $catalog->companies->count() > 0) {
                                                    $firstCompany = $catalog->companies->first();
                                                    if($firstCompany && $firstCompany->logo) {
                                                        $logoUrl = asset('storage/company/logo/' . $firstCompany->logo);
                                                        $logoTitle = $firstCompany->name;
                                                        $logoAlt = $firstCompany->name;
                                                    } else {
                                                        // If company exists but no logo, use company name as text
                                                        $logoTitle = $firstCompany->name ?? 'Company';
                                                        $logoAlt = $firstCompany->name ?? 'Company';
                                                    }
                                                }

                                                // For debugging - uncomment to see what's happening
                                                // {{-- <div style="display: none;">Debug: {{ json_encode($debugInfo) }}</div> --}}
                                            @endphp

                                            <div class="mb-2 text-center">
                                                @if($logoUrl != asset('frontend/images/no-shop-imge.png'))
                                                    <img src="{{ $logoUrl }}" 
                                                         title="{{ $logoTitle }}" 
                                                         alt="{{ $logoAlt }}"
                                                         style="max-height: 40px; max-width: 100px; object-fit: contain;"
                                                         onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center" 
                                                         style="height: 40px; max-width: 100px; margin: 0 auto;">
                                                        <span class="small text-muted">{{ $logoTitle }}</span>
                                                    </div>
                                                @endif
                                                <p class="mt-2 mb-0 small">{{ $catalog->page_number ?? 0 }} Pages</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="text-center alert alert-info">No catalogs found.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Category-wise Catalogs --}}
                    @foreach($catalogCategories as $key => $category)
                        <div class="tab-pane fade" id="category-item-{{ $key }}">
                            <div class="row">
                                @if(isset($catalogsByCategory[$category]) && $catalogsByCategory[$category]->count() > 0)
                                    @foreach($catalogsByCategory[$category] as $catalog)
                                        <div class="mb-4 col-lg-3 col-md-4 col-sm-6">
                                            <div class="card projects-card rounded-0 h-100 catalog-card"
                                                 style="cursor: pointer;"
                                                 data-pdf-url="{{ $catalog->document ? asset('storage/catalog/document/' . $catalog->document) : '' }}">
                                                <img src="{{ $catalog->thumbnail ? asset('storage/catalog/thumbnail/' . $catalog->thumbnail) : asset('frontend/images/no-image.jpg') }}"
                                                     class="card-img-top img-fluid rounded-0"
                                                     alt="{{ $catalog->name }}"
                                                     style="height: 200px; object-fit: cover;" />
                                                <div class="card-body d-flex flex-column">
                                                    <p class="text-center flex-grow-1">{{ $catalog->name }}</p>

                                                    {{-- Catalog Logo --}}
                                                    @php
                                                        $logoUrl = asset('frontend/images/no-shop-imge.png');
                                                        $logoTitle = 'No Logo';
                                                        $logoAlt = 'No Logo';

                                                        if($catalog->category == 'brand' && $catalog->brands->count() > 0) {
                                                            $firstBrand = $catalog->brands->first();
                                                            if($firstBrand && $firstBrand->logo) {
                                                                $logoUrl = asset('storage/brand/logo/' . $firstBrand->logo);
                                                                $logoTitle = $firstBrand->title;
                                                                $logoAlt = $firstBrand->title;
                                                            }
                                                        } elseif($catalog->category == 'company' && $catalog->companies->count() > 0) {
                                                            $firstCompany = $catalog->companies->first();
                                                            if($firstCompany && $firstCompany->logo) {
                                                                $logoUrl = asset('storage/company/logo/' . $firstCompany->logo);
                                                                $logoTitle = $firstCompany->name;
                                                                $logoAlt = $firstCompany->name;
                                                            }
                                                        }
                                                    @endphp
                                                    <div class="mb-2 text-center">
                                                        @if($logoUrl != asset('frontend/images/no-shop-imge.png'))
                                                            <img src="{{ $logoUrl }}" 
                                                                 title="{{ $logoTitle }}" 
                                                                 alt="{{ $logoAlt }}"
                                                                 style="max-height: 40px; max-width: 100px; object-fit: contain;"
                                                                 onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';">
                                                        @else
                                                            <div class="d-flex align-items-center justify-content-center" 
                                                                 style="height: 40px; max-width: 100px; margin: 0 auto;">
                                                                <span class="small text-muted">{{ $logoTitle }}</span>
                                                            </div>
                                                        @endif
                                                        <p class="mt-2 mb-0 small">{{ $catalog->page_number ?? 0 }} Pages</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <div class="text-center alert alert-info">No catalogs found in {{ ucfirst($category) }} category.</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.catalog-card').forEach(card => {
        card.addEventListener('click', function() {
            const pdfUrl = this.dataset.pdfUrl;
            if(pdfUrl) {
                window.open(pdfUrl, '_blank');
            } else {
                alert('PDF not available for this catalog.');
            }
        });
    });
});
</script>
@endpush