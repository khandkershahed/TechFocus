@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<div class="container-fluid">
    <!-- Hero / Banner Section -->
    <div class="row breadcrumb-banner-area p-5 text-white text-center"
         style="background: url('https://virtual-expo.my.site.com/Visitors/s/sfsites/c/file-asset/Background1?v=1') center/cover no-repeat;">
        <div class="col-lg-12">
            <h1 class="display-5 fw-bold font-poppins text-uppercase my-4">
                Welcome to the VirtualExpo <br> Knowledge Base
            </h1>
            <div class="col-lg-6 mx-auto">
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
                    <div class="accordion-item mb-3 border rounded-3">
                        <h2 class="accordion-header" id="heading{{ $faq->id }}">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false"
                                aria-controls="collapse{{ $faq->id }}">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                             aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        No FAQs available at the moment.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- FAQ Categories Sidebar -->
        <div class="col-lg-4 col-sm-12">
            <div class="bg-white p-4 rounded-3 shadow-sm">
                <h5 class="fw-bold font-poppins mb-3">FAQ Categories</h5>
                <ul class="list-group list-group-flush">
                    @foreach($categories as $cat)
                        <li class="list-group-item d-flex justify-content-between align-items-center hover-shadow rounded-2 mb-2">
                            <a href="{{ route('faq.category', $cat->slug) }}"
                               class="text-decoration-none {{ (isset($category) && $category->id == $cat->id) ? 'fw-bold text-primary' : '' }}">
                                {{ $cat->name }}
                            </a>
                            <span class="badge bg-primary rounded-pill">{{ $cat->faqs->count() }}</span>
                        </li>
                    @endforeach
                </ul>

                <a href="#" class="btn btn-primary w-100 mt-4">Contact Support</a>
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
</style>
@endpush
@endsection
