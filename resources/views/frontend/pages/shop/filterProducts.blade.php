@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<!--Banner -->
<div class="shadow-none swiper bannerSwiper product-banner">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <a href="">
                <img src="https://img.directindustry.com/images_di/bnr/15876/hd/55276.jpg" class="img-fluid" alt="" />
            </a>
        </div>
        <div class="swiper-slide">
            <a href="">
                <img src="https://img.directindustry.com/images_di/bnr/68695/hd/54611.jpg" class="img-fluid" alt="" />
            </a>
        </div>
        <div class="swiper-slide">
            <a href="">
                <img src="https://img.directindustry.com/images_di/bnr/23164/hd/55467.jpg" class="img-fluid" alt="" />
            </a>
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div>

<div class="container my-3 mt-4">
    <div class="mx-4 mt-2 bg-white row align-items-center rounded-3">
        <div class="col-lg-12 d-flex align-items-center justify-content-between">
            <div class="info-area d-flex align-items-center">
                <h3 class="mb-0">{{ optional($category)->name }}</h3>
                <div class="ms-4">
                    <div>
                        <i class="fas fa-house-chimney-window text-primary"></i>
                        <a href="{{ route('homepage') }}" class="fw-bold">Home</a> /
                        @if (optional($category)->parent_id != null)
                            <a href="{{ route('category', optional($category->parent)->slug) }}" class="txt-mcl active">{{ optional($category->parent)->name }}</a> /
                        @endif
                        <span class="txt-mcl active fw-bold">{{ optional($category)->name }}</span>
                    </div>
                </div>
            </div>
            <div class="pt-3 counting-area">
                <h6><span class="main-color">{{ $products->count() }}</span> products</h6>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <form id="filterForm" method="GET" action="{{ route('filtering.products', $category->slug) }}">
        <div class="mx-3 mt-3 row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 col-sm-12">

                <!-- What's New -->
                <div class="p-3 mt-3 mb-2 bg-white category-border-top rounded-3">
                    <div class="checkbox-wrapper-21">
                        <label class="control control--checkbox">
                            What's New
                            <input type="checkbox" name="whats_new" value="1" {{ request('whats_new') == '1' ? 'checked' : '' }}>
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                </div>

                <!-- Brands -->
                <div class="p-3 my-3 bg-white category-border-top rounded-3">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="p-1 border-0 accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOnemanufactureer"
                                    aria-expanded="false" aria-controls="flush-collapseOnemanufactureer">
                                    Manufacturers
                                </button>
                            </h2>
                            <div id="flush-collapseOnemanufactureer" class="border-0 accordion-collapse collapse"
                                 aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="p-0 m-0 accordion-body">
                                    <!-- Brand search -->
                                    <div class="pt-3 position-relative">
                                        <input id="autocomplete_company" type="text"
                                               class="py-2 form-control ps-5 rounded-3" placeholder="Search...">
                                        <i class="pt-3 fa fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary"></i>
                                    </div>

                                    <!-- Brand List -->
                                    <div class="mt-3 scroll-menu-container" style="height: 500px; overflow: auto">
                                        <ul class="p-0 m-0" id="brandList">
                                            @foreach ($brands as $brand)
                                                <li class="p-2 brand-item">
                                                    <div class="checkbox-wrapper-21">
                                                        <label class="control control--checkbox">
                                                            {{ $brand->title }}
                                                            <input type="checkbox" name="brand_id[]" value="{{ $brand->id }}"
                                                                {{ in_array($brand->id, (array) request('brand_id')) ? 'checked' : '' }}>
                                                            <div class="control__indicator"></div>
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Brand Search Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('autocomplete_company');
    input.addEventListener('keyup', function() {
        let search = this.value.toLowerCase();
        document.querySelectorAll('#brandList .brand-item').forEach(function(item) {
            let text = item.textContent.toLowerCase();
            item.style.display = text.includes(search) ? '' : 'none';
        });
    });
});
</script>

<!-- AJAX Filter Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filterForm');
    const productContainer = document.getElementById('productContainer');

    // Listen to all checkboxes (Whats New + Brands)
    filterForm.querySelectorAll('input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', applyFilters);
    });

    function applyFilters() {
        const formData = new FormData(filterForm);

        // Collect multiple brand IDs
        const brandIds = [];
        filterForm.querySelectorAll('input[name="brand_id[]"]:checked').forEach(cb => {
            brandIds.push(cb.value);
        });

        // Build params
        const params = new URLSearchParams(formData);
        params.delete('brand_id'); // remove old single brand
        brandIds.forEach(id => params.append('brand_id[]', id));

        // Fetch filtered products via AJAX
        fetch(filterForm.action + '?' + params.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(data => {
            productContainer.innerHTML = data;
        })
        .catch(error => console.error('Filter error:', error));
    }
});
</script>
@endsection
