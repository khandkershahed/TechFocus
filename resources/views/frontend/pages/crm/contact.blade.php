@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
    {{-- Banner Section --}}
    <section class="ban_sec section_one">
        <div class="p-0 container-fluid">
            <div class="ban_img">
                @if($banners->count() > 0)
                    <div class="swiper bannerSwiper">
                        <div class="swiper-wrapper">
                            @foreach($banners as $banner)
                                @if($banner->image)
                                    <div class="swiper-slide">
                                        <a href="{{ $banner->banner_link ?? '#' }}">
                                            <img src="{{ asset('uploads/page_banners/' . $banner->image) }}" class="img-fluid" alt="{{ $banner->title ?? 'Banner' }}"
                                                onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-banner(1920-330).png') }}';" />
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    <img src="{{ asset('frontend/images/no-banner(1920-330).png') }}" class="img-fluid" alt="No Banner">
                @endif

                <div class="ban_text">
                    <strong>Contact Us</strong>
                    <ul class="mt-5 d-flex align-items-center ps-0">
                        <li class="text-white"><a href="{{ route('homepage') }}">Home</a></li>
                        <li class="text-white"><span class="me-2 ms-2">/</span></li>
                        <li class="main-color"><a href="#">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact Form Section --}}
    <section>
        <div class="container mt-4 custom-spacer">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="mb-4">
                        <h1 class="mb-0">Contact Info</h1>
                        <h5 class="pt-4 fw-bold">
                            <span class="main-color">Hotline :</span> {{ $site->phone_one ?? 'N/A' }}
                        </h5>
                        <ul class="ms-0 ps-0">
                            <li class="pt-3">
                                <a href="mailto:{{ $site->contact_email ?? 'info@example.com' }}">
                                    <i class="fa-solid fa-envelope pe-2 main-color"></i>{{ $site->contact_email ?? 'info@example.com' }}
                                </a>
                            </li>
                            <li class="pt-3">
                                <i class="fa-solid fa-location-dot pe-2 main-color"></i>
                                {{ $site->address ?? 'Address not set' }}
                                @if($site->google_map_link)
                                    <a href="{{ $site->google_map_link }}" target="_blank" class="main-color">(View map)</a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6">
                    <form action="{{ route('contact.add') }}" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <input type="text" class="p-3 form-control rounded-0" placeholder="Your Name" name="name" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <input type="number" class="p-3 form-control rounded-0" placeholder="Your Phone Number" name="phone" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <input type="email" class="p-3 form-control rounded-0" placeholder="Your Email Address" name="email" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <textarea class="p-3 form-control rounded-0" rows="10" placeholder="Your Message" name="message" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div style="width: 20%;">
                            <button type="submit" class="p-3 mx-auto common-btn-3">Submit <i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Google Maps --}}
    @if($site->google_map_link)
    <section>
        <div class="p-0 container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <iframe src="{{ $site->google_map_link }}" width="100%" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
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
})()
</script>
@endpush
