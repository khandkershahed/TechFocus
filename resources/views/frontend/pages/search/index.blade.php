<x-frontend-layout :title="'Search Results'">
<div class="container py-5" style="margin-top: 150px;">

 
        <!-- Search Term and Brand at Top -->
        <h3 class="mb-4">
            @if(isset($products) && $products->count() && $products->first()->brand)
                Brand:
                <span class="text-success">
                    @if(Route::has('brand.overview'))
                        <a href="{{ route('brand.overview', $products->first()->brand->slug) }}" 
                           class="text-success text-decoration-none">
                            {{ $products->first()->brand->title }}
                        </a>
                    @else
                        {{ $products->first()->brand->title }}
                    @endif
                </span> |
            @endif
        </h3>

        <div class="row">

            <!-- Products -->
            <div class="col-lg-8">
                @if(isset($products) && $products->count())
                    <div class="row g-3">
                        @foreach ($products as $product)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm">
                                    <img src="{{ asset($product->thumbnail) }}" class="card-img-top"
                                         alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">

                                    <div class="card-body d-flex flex-column">

                                        <!-- Brand Name -->
                                        <p class="mb-1 text-muted small">
                                            @if($product->brand)
                                                @if(Route::has('brand.details'))
                                                    <a href="{{ route('brand.details', $product->brand->slug) }}">
                                                        {{ $product->brand->title }}
                                                    </a>
                                                @else
                                                    {{ $product->brand->title }}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </p>

                                        <!-- Product Name -->
                                        <h6 class="card-title">
                                            <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
                                                {{ $product->name }}
                                            </a>
                                        </h6>

                                        <!-- Price -->
                                        <p class="mb-1">
                                            Price: <strong>${{ $product->price ?? 'N/A' }}</strong>
                                        </p>

                                        <!-- View Details Button -->
                                        <a href="{{ route('product.details', ['id' => $product->brand->slug ?? '#', 'slug' => $product->slug]) }}"
                                           class="btn btn-sm btn-primary mt-auto">
                                            View Details
                                        </a> 
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        @if(method_exists($products, 'links'))
                            {{ $products->links() }}
                        @endif
                    </div>
                @else
                    <div class="alert alert-warning">
                        No products found for "{{ $searchTerm ?? $query ?? '' }}".
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">

                <!-- Categories -->
                <div class="mb-4">
                    <h5>Categories</h5>
                    <ul class="list-group">
                        @forelse($categories ?? [] as $category)
                            <li class="list-group-item">
                                <a href="{{ route('category', $category->slug) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No categories found</li>
                        @endforelse
                    </ul>
                </div>

              <!-- Solutions -->
                                <div class="mb-4">
                                    <h5>Solutions</h5>
                                    <ul class="list-group">
                                        @forelse($solutions ?? [] as $solution)
                                            <li class="list-group-item">
                                                <a href="{{ route('solution.details', $solution->slug) }}">
                                                    {{ $solution->name }}
                                                </a>
                                            </li>
                                        @empty
                                            <li class="list-group-item text-muted">No solutions available</li>
                                        @endforelse
                                    </ul>
                                </div>


                <!-- News & Trends -->
                <div>
                    <h5>Contents</h5>
                    <ul class="list-group">
                        @forelse($news_trends ?? [] as $trend)
                            <li class="list-group-item">
                                <a href="{{ route('news.details', $trend->slug) }}">
                                    {{ $trend->title }}
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No news available</li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-frontend-layout>
