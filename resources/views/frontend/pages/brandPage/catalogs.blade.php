@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    @include('frontend.pages.brandPage.partials.page_header')

    <div class="container my-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="devider-wrap">
                    <h4 class="devider-content mb-4">
                        <span class="devider-text">{{ $brand->title }} CATALOGS</span>
                    </h4>
                </div>
            </div>
        </div>

        <!-- Category Tabs -->
        @if($catalogCategories->count() > 0)
        <div class="row mb-4">
            <div class="col-lg-12">
                <ul class="nav nav-pills justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#all" data-bs-toggle="pill">All Catalogs</a>
                    </li>
                    @foreach($catalogCategories as $category)
                        @if($category)
                            <li class="nav-item">
                                <a class="nav-link" href="#category-{{ $loop->index }}" data-bs-toggle="pill">
                                    {{ ucfirst($category) }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Catalogs Content -->
        <div class="tab-content">
            <!-- All Catalogs Tab -->
            <div class="tab-pane fade show active" id="all">
                <div class="row">
                    @forelse($brandCatalogs as $catalog)
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                            <div class="card projects-card rounded-0 catalog-card"
                                 style="cursor: pointer;"
                                 data-pdf-url="{{ $catalog->document ? asset('storage/catalog/document/' . $catalog->document) : '' }}">
                                
                                <img src="{{ $catalog->thumbnail ? asset('storage/catalog/thumbnail/' . $catalog->thumbnail) : asset('frontend/images/no-shop-imge.png') }}"
                                     class="card-img-top img-fluid rounded-0"
                                     alt="{{ $catalog->name }}"
                                     style="height: 150px; object-fit: cover;"
                                     onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';" />
                                
                                <div class="card-body">
                                    <p class="card-text project-para text-center">
                                        {{ \Illuminate\Support\Str::limit($catalog->name, 40) }}
                                    </p>
                                    <div class="catalog-logo-area mt-3 text-center">
                                        @if($brand->logo)
                                            <img src="{{ asset('storage/brand/logo/' . $brand->logo) }}"
                                                 alt="{{ $brand->title }}"
                                                 style="max-height: 25px; object-fit: contain;"
                                                 onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';">
                                        @endif
                                        <p class="p-0 m-0 mt-1" style="font-size: 10px">
                                            {{ $catalog->page_number ?? 'N/A' }} Pages
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <div class="alert alert-info">
                                <p class="mb-0">No catalogs available for {{ $brand->title }} at the moment.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Category Tabs Content -->
            @foreach($catalogCategories as $category)
                @if($category)
                    <div class="tab-pane fade" id="category-{{ $loop->index }}">
                        <div class="row">
                            @php
                                $categoryCatalogs = $brandCatalogs->where('category', $category);
                            @endphp
                            
                            @forelse($categoryCatalogs as $catalog)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                                    <div class="card projects-card rounded-0 catalog-card"
                                         style="cursor: pointer;"
                                         data-pdf-url="{{ $catalog->document ? asset('storage/catalog/document/' . $catalog->document) : '' }}">
                                        
                                        <img src="{{ $catalog->thumbnail ? asset('storage/catalog/thumbnail/' . $catalog->thumbnail) : asset('frontend/images/no-shop-imge.png') }}"
                                             class="card-img-top img-fluid rounded-0"
                                             alt="{{ $catalog->name }}"
                                             style="height: 150px; object-fit: cover;"
                                             onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';" />
                                        
                                        <div class="card-body">
                                            <p class="card-text project-para text-center">
                                                {{ \Illuminate\Support\Str::limit($catalog->name, 40) }}
                                            </p>
                                            <div class="catalog-logo-area mt-3 text-center">
                                                @if($brand->logo)
                                                    <img src="{{ asset('storage/brand/logo/' . $brand->logo) }}"
                                                         alt="{{ $brand->title }}"
                                                         style="max-height: 25px; object-fit: contain;"
                                                         onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';">
                                                @endif
                                                <p class="p-0 m-0 mt-1" style="font-size: 10px">
                                                    {{ $catalog->page_number ?? 'N/A' }} Pages
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center">
                                    <div class="alert alert-warning">
                                        No catalogs found in {{ ucfirst($category) }} category.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // PDF viewer functionality
    document.querySelectorAll('.catalog-card').forEach(card => {
        card.addEventListener('click', function() {
            const pdfUrl = this.dataset.pdfUrl;
            if (pdfUrl) {
                window.open(pdfUrl, '_blank');
            } else {
                alert('PDF not available for this catalog.');
            }
        });
    });

    // Add hover effects
    document.querySelectorAll('.catalog-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
            this.style.transition = 'all 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
    });
});
</script>
@endpush