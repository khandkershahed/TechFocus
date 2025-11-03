@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<div class="container-fluid">
    <!-- Hero / Banner Section -->
    <div class="p-5 text-center text-white row breadcrumb-banner-area"
         style="background: url('https://virtual-expo.my.site.com/Visitors/s/sfsites/c/file-asset/Background1?v=1') center/cover no-repeat;">
        <div class="col-lg-12">
            <h1 class="my-4 display-5 fw-bold font-poppins text-uppercase">
                Welcome to the VirtualExpo <br> Knowledge Base
            </h1>
            <div class="mx-auto col-lg-6">
                <form method="GET" action="{{ route('faq.search') }}">
                    <div class="input-group shadow-sm rounded-pill overflow-hidden">
                        <input type="text" class="form-control border-0 px-4" placeholder="Search FAQ..." name="q" value="{{ request('q', $searchQuery ?? '') }}">
                        <button type="submit" class="btn btn-primary px-4 rounded-0">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        <!-- FAQ List -->
        <div class="col-lg-8 col-sm-12">
            <div class="accordion shadow-sm" id="faqAccordion">
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

        <!-- FAQ Categories Sidebar -->
        <div class="col-lg-4 col-sm-12">
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
    </div>
</div>

@push('styles')
<style>
.hover-shadow:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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