@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
{{-- Banner Section --}}
<section class="ban_sec section_one">
    <div class="container-fluid p-0">
        <div class="ban_img position-relative">
            @if($banners->count() > 0)
                <div class="swiper bannerSwiper">
                    <div class="swiper-wrapper">
                        @foreach($banners as $banner)
                            @if($banner->image)
                                <div class="swiper-slide">
                                    <a href="{{ $banner->banner_link ?? '#' }}">
                                        <img src="{{ asset('uploads/page_banners/' . $banner->image) }}"
                                             class="img-fluid w-100"
                                             alt="{{ $banner->title ?? 'Banner' }}"
                                             onerror="this.onerror=null;this.src='{{ asset('/img/TechFocus Contact us Page Banner (1920x525).webp') }}';">
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <img src="{{ asset('/img/TechFocus Contact us Page Banner (1920x525).webp') }}"
                     class="img-fluid w-100" alt="No Banner">
            @endif

            <!-- <div class="ban_overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-center">
                <div class="text-white">
                    <h1 class="fw-bold display-5">Contact Us</h1>
                    <ul class="breadcrumb justify-content-center bg-transparent p-0 mt-3">
                        <li class="breadcrumb-item"><a href="{{ route('homepage') }}" class="text-white text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Contact</li>
                    </ul>
                </div>
            </div> -->
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5 align-items-start">
            {{-- Contact Info --}}
            <div class="col-lg-5">
                <div class="p-4 bg-white shadow-sm rounded-4 h-100">
                    <h3 class="fw-bold mb-4" style="color: var(--main-color)">Get In Touch</h3>

                    <div class="d-flex align-items-start mb-3">
                        <div class="icon-wrapper me-3">
                            <i class="fa-solid fa-phone-volume fa-lg main-color"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Hotline</h6>
                            <p class="mb-0 text-muted">{{ $site->phone_one ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start mb-3">
                        <div class="icon-wrapper me-3">
                            <i class="fa-solid fa-envelope fa-lg main-color"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Email</h6>
                            <a href="mailto:{{ $site->contact_email ?? 'info@example.com' }}" class="text-muted text-decoration-none">
                                {{ $site->contact_email ?? 'info@example.com' }}
                            </a>
                        </div>
                    </div>

                    <div class="d-flex align-items-start">
                        <div class="icon-wrapper me-3">
                            <i class="fa-solid fa-location-dot fa-lg main-color"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Office Address</h6>
                            <p class="mb-0 text-muted">{{ $site->address ?? 'Address not set' }}</p>
                            @if($site->google_map_link)
                                <a href="{{ $site->google_map_link }}" target="_blank" class="small main-color text-decoration-none">(View map)</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="col-lg-7">
                <div class="p-4 bg-white shadow-sm rounded-4">
                    <h3 class="fw-bold mb-4" style="color: var(--main-color)">Send Us a Message</h3>
                    <form action="{{ route('contact.add') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control rounded-3" placeholder="Your Name" name="name" required>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control rounded-3" placeholder="Your Phone" name="phone" required>
                            </div>
                            <div class="col-md-4">
                                <input type="email" class="form-control rounded-3" placeholder="Your Email" name="email" required>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control rounded-3" rows="6" placeholder="Your Message" name="message" required></textarea>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn px-5 py-3 text-white fw-semibold rounded-3"
                                style="background-color: var(--primary-color);">
                                Send Message <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Google Map --}}
@if($site->google_map_link)
<section class="map-section">
    <div class="container-fluid p-0">
        <iframe src="{{ $site->google_map_link }}" width="100%" height="550" frameborder="0" style="border:0;" allowfullscreen></iframe>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})();
</script>
@endpush
