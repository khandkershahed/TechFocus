@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<div class="faq-banner">
    <img src="{{ asset('/img/jak_stahnout_wordpress_featured.webp') }}" alt="FAQ Banner">
</div>

<div class="container my-5">
    <div class="row g-4">
        <!-- FAQ List -->
        <!-- FAQ Categories Sidebar -->
        <div class="col-lg-3 col-sm-12">
            <div class="p-4 bg-white shadow-sm rounded-3">
                <h5 class="mb-3 fw-bold font-poppins">FAQ Categories</h5>
                <ul class="list-group list-group-flush">
                    @foreach($categories as $cat)
                    <li class="mb-2 list-group-item d-flex justify-content-between align-items-center hover-shadow rounded-2">
                        <a href="{{ route('faq.category', $cat->slug) }}"
                            class="text-decoration-none {{ (isset($category) && $category->id == $cat->id) ? 'fw-bold text-primary' : '' }}">
                            {{ $cat->name }}
                        </a>
                        <span class="badge bg-primary rounded-pill">{{ $cat->faqs->where('is_published', '1')->count() }}</span>
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('contact',) }}" class="mt-4 btn btn-primary w-100">Contact Support</a>
            </div>
        </div>
        <div class="col-lg-9 col-sm-12">
            <div class="shadow-sm accordion" id="faqAccordion">
                @forelse($faqs as $faq)
                <div class="mb-3 border accordion-item rounded-3">
                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                        <button class="accordion-button collapsed fw-semibold" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $faq->id }}"
                            aria-expanded="false"
                            aria-controls="collapse{{ $faq->id }}">
                            {!! isset($searchQuery) && $searchQuery
                            ? preg_replace('/(' . preg_quote($searchQuery, '/') . ')/i', '<mark>$1</mark>', $faq->question)
                            : $faq->question !!}
                        </button>
                    </h2>
                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            {!! isset($searchQuery) && $searchQuery
                            ? preg_replace('/(' . preg_quote($searchQuery, '/') . ')/i', '<mark>$1</mark>', $faq->answer)
                            : $faq->answer !!}
                            @if($faq->dynamicCategory)
                            <p class="mt-2"><small class="text-muted">Category: {{ $faq->dynamicCategory->name }}</small></p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                {{-- No FAQs handled by alert --}}
                @endforelse
            </div>
        </div>


    </div>
</div>

@push('styles')
<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: 0.3s;
    }

    .accordion-button {
        font-size: 1rem;
        color: #333;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    mark {
        background-color: #fffb91;
    }

    .fw-bold.text-primary {
        font-weight: 600;
        color: #0d6efd !important;
    }
</style>
@endpush
@endsection