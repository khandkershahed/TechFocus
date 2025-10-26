@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<div class="container-fluid">
    <div class="row breadcrumb-banner-area p-5"
        style="background-image: url('https://virtual-expo.my.site.com/Visitors/s/sfsites/c/file-asset/Background1?v=1');">
        <div class="col-lg-12">
            <h1 class="text-center font-poppins my-5 text-uppercase fw-bold">
                Welcome to the VirtualExpo <br />Knowledge Base
            </h1>
            <div class="col-lg-12 w-50 mx-auto pt-3">
                <form method="GET" action="{{ route('faq.search') }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control rounded-pill" placeholder="Search FAQ..."
                            name="q" value="{{ request('q') }}">
                        <button type="submit" class="btn signin w-auto rounded-pill faq-search">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container overflow-hidden my-5">
    <div class="row">
        <div class="col-lg-8 col-sm-12">
            <div class="accordion" id="faqAccordion">
                @forelse($faqs as $faq)
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="heading{{ $faq->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
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
                    <p>No FAQs available at the moment.</p>
                @endforelse
            </div>
        </div>

        <div class="col-lg-4 col-sm-12 bg-white">
            <div class="pt-5">
                <h6 class="fw-bold font-poppins mb-3">FAQ Categories</h6>
                <ul class="list-group mb-4">
                    @foreach($categories as $category)
                        <li class="list-group-item">
                            <a href="{{ route('faq.category', $category->slug) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <a href="#" class="btn signin rounded-0 w-100">Contact Support</a>
            </div>
        </div>
    </div>
</div>
@endsection
