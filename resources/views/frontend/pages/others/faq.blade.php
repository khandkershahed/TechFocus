@extends('frontend.master')

@section('metadata')
@endsection

@section('content')

{{-- ✅ Banner Section --}}
<section class="ban_sec section_one">
    <div class="container-fluid p-0">
        <div class="ban_img">

            @if(isset($banners) && $banners->count() > 0)
                <div class="swiper bannerSwiper">
                    <div class="swiper-wrapper">

                        @foreach($banners as $banner)
                            @if($banner->image)
                                <div class="swiper-slide">
                                    <a href="{{ $banner->banner_link ?? '#' }}">
                                        <img src="{{ asset('uploads/page_banners/' . $banner->image) }}"
                                             class="img-fluid"
                                             alt="{{ $banner->title ?? 'Banner' }}"
                                             onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-banner(1920-330).png') }}';" />
                                    </a>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            @else
                <img src="{{ asset('frontend/images/no-banner(1920-330).png') }}"
                     class="img-fluid"
                     alt="No Banner">
            @endif

        </div>
    </div>
</section>

<div class="container my-5">
    <div class="row g-4">

        {{-- ✅ FAQ List --}}
        <div class="col-lg-8 col-sm-12">
            <div class="accordion shadow-sm" id="faqAccordion">

                @forelse($faqs as $faq)
                    <div class="accordion-item mb-3 border rounded-3">
                        <h2 class="accordion-header" id="heading{{ $faq->id }}">
                            <button class="accordion-button collapsed fw-semibold"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $faq->id }}"
                                    aria-expanded="false"
                                    aria-controls="collapse{{ $faq->id }}">
                                {!! isset($searchQuery)
                                    ? preg_replace('/(' . preg_quote($searchQuery, '/') . ')/i', '<mark>$1</mark>', $faq->question)
                                    : $faq->question !!}
                            </button>
                        </h2>

                        <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {!! isset($searchQuery)
                                    ? preg_replace('/(' . preg_quote($searchQuery, '/') . ')/i', '<mark>$1</mark>', $faq->answer)
                                    : $faq->answer !!}

                                @if($faq->dynamicCategory)
                                    <p class="mt-2">
                                        <small class="text-muted">
                                            Category: {{ $faq->dynamicCategory->name }}
                                        </small>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- No FAQ found --}}
                @endforelse

            </div>
        </div>

        {{-- ✅ FAQ Categories --}}
        <div class="col-lg-4 col-sm-12">
            <div class="p-4 bg-white shadow-sm rounded-3">

                <h5 class="fw-bold mb-3 font-poppins">FAQ Categories</h5>

                <ul class="list-group list-group-flush">
                    @foreach($categories as $cat)
                        <li class="list-group-item mb-2 d-flex justify-content-between align-items-center hover-shadow rounded-2">
                            <a href="{{ route('faq.category', $cat->slug) }}"
                               class="text-decoration-none {{ isset($category) && $category->id == $cat->id ? 'fw-bold text-primary' : '' }}">
                                {{ $cat->name }}
                            </a>

                            <span class="badge bg-primary rounded-pill">
                                {{ $cat->faqs->where('is_published', 1)->count() }}
                            </span>
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('contact') }}" class="btn btn-primary w-100 mt-4">Contact Support</a>

            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
.hover-shadow:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: 0.3s; }
mark { background-color: #fffb91; }
</style>
@endpush

@endsection
