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

        <!-- Debug Info -->
        {{-- <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <small>
                        <strong>Brand:</strong> {{ $brand->title }} (ID: {{ $brand->id }}) | 
                        <strong>Catalogs Found:</strong> {{ $brandCatalogs->count() }} | 
                        <strong>Categories:</strong> {{ $catalogCategories->implode(', ') ?: 'None' }}
                    </small>
                </div>
            </div>
        </div> --}}

        @if($brandCatalogs->count() > 0)
            <!-- Category Tabs -->
            @if($catalogCategories->count() > 0)
            <div class="row mb-4">
                <div class="col-lg-12">
                    <ul class="nav nav-pills justify-content-center">
                        {{-- <li class="nav-item">
                            <a class="nav-link active" href="#all" data-bs-toggle="pill">All Catalogs</a>
                        </li> --}}
                        @foreach($catalogCategories as $category)
                            @if($category)
                                {{-- <li class="nav-item">
                                    <a class="nav-link" href="#category-{{ $loop->index }}" data-bs-toggle="pill">
                                        {{ ucfirst($category) }}
                                    </a>
                                </li> --}}
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
                        @foreach($brandCatalogs as $catalog)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card projects-card rounded-0 h-100 catalog-card"
                                     style="cursor: pointer;"
                                     data-pdf-url="{{ $catalog->document ? asset('storage/catalog/document/' . $catalog->document) : '' }}">
                                    
                                    <img src="{{ $catalog->thumbnail ? asset('storage/catalog/thumbnail/' . $catalog->thumbnail) : asset('frontend/images/no-shop-imge.png') }}"
                                         class="card-img-top img-fluid rounded-0"
                                         alt="{{ $catalog->name }}"
                                         style="height: 200px; object-fit: cover;"
                                         onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';" />

                                    <div class="card-body d-flex flex-column">
                                        <p class="text-center flex-grow-1">{{ $catalog->name }}</p>

                                        <div class="mb-2 text-center">
                                            @if($brand->logo)
                                                <img src="{{ asset('storage/brand/logo/' . $brand->logo) }}"
                                                     title="{{ $brand->title }}"
                                                     alt="{{ $brand->title }}"
                                                     style="max-height: 40px; max-width: 100px; object-fit: contain;"
                                                     onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center"
                                                     style="height: 40px; max-width: 100px; margin: 0 auto;">
                                                    <span class="small text-muted">{{ $brand->title }}</span>
                                                </div>
                                            @endif
                                            <p class="mt-2 mb-0 small">{{ $catalog->page_number ?? '0' }} Pages</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
                                
                                @foreach($categoryCatalogs as $catalog)
                                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                        <div class="card projects-card rounded-0 h-100 catalog-card"
                                             style="cursor: pointer;"
                                             data-pdf-url="{{ $catalog->document ? asset('storage/catalog/document/' . $catalog->document) : '' }}">

                                            <img src="{{ $catalog->thumbnail ? asset('storage/catalog/thumbnail/' . $catalog->thumbnail) : asset('frontend/images/no-shop-imge.png') }}"
                                                 class="card-img-top img-fluid rounded-0"
                                                 alt="{{ $catalog->name }}"
                                                 style="height: 200px; object-fit: cover;"
                                                 onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';" />

                                            <div class="card-body d-flex flex-column">
                                                <p class="text-center flex-grow-1">{{ $catalog->name }}</p>

                                                <div class="mb-2 text-center">
                                                    @if($brand->logo)
                                                        <img src="{{ asset('storage/brand/logo/' . $brand->logo) }}"
                                                             title="{{ $brand->title }}"
                                                             alt="{{ $brand->title }}"
                                                             style="max-height: 40px; max-width: 100px; object-fit: contain;"
                                                             onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-shop-imge.png') }}';">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center"
                                                             style="height: 40px; max-width: 100px; margin: 0 auto;">
                                                            <span class="small text-muted">{{ $brand->title }}</span>
                                                        </div>
                                                    @endif
                                                    <p class="mt-2 mb-0 small">{{ $catalog->page_number ?? '0' }} Pages</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col-12 text-center">
                    <div class="alert alert-warning">
                        <h5>No Catalogs Found</h5>
                        <p class="mb-0">No catalogs are currently associated with {{ $brand->title }}.</p>
                        <p class="mb-0"><small>Brand ID: {{ $brand->id }} | Please check the admin panel to assign catalogs to this brand.</small></p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
@endpush
