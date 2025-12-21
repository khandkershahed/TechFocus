@extends('frontend.master')
@section('metadata')
@endsection
@section('content')

<!-- ================= HERO BANNER ================= -->
<section class="ban_sec section_one">
    <div class="px-0 container-fluid">
        <div class="overflow-hidden ban_img position-relative">
            <img
                src="{{ asset('img/TechFocus-Catalog-Page-Banner-(1920x525).png') }}"
                class="img-fluid w-100"
                alt="Catalog Banner"
                style="height: 475px; object-fit: cover;"
                loading="lazy"
                onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-banner(1920-330).png') }}';">

            <!-- Optional overlay -->
            <div class="top-0 position-absolute start-0 w-100 h-100"
                style="background: linear-gradient(180deg, rgba(0,0,0,.35), rgba(0,0,0,.05));">
            </div>
        </div>
    </div>
</section>

<!-- ================= REQUEST PRICE ================= -->
<section class="pb-5 request-price-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="my-5 text-center fw-light" style="color:#444;">
                    Request price options
                </h2>

                <div class="row g-4">
                    <!-- ================= FORM ================= -->
                    <div class="col-md-9">
                        <div class="p-4 bg-white shadow-sm p-md-5 rounded-3 h-100">
                            <form action="#" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="mb-1 form-label small text-muted">
                                        Your email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email"
                                        class="border-0 form-control rounded-2 bg-light"
                                        placeholder="john.doe@mail.com"
                                        required>
                                </div>
                                <div class="mb-4">
                                    <label class="mb-1 form-label small text-muted">
                                        Your project
                                    </label>
                                    <textarea rows="4"
                                              class="form-control rounded-2 border-light-subtle"
                                              style="resize:none;">Hello,
I am interested in the following product: belt conveyor.
I would like to learn more about your prices and options.
Thank you in advance.</textarea>
                                </div>
                                <div class="mb-4">
                                    <p class="mb-2 small text-muted">I would also like to:</p>
                                    <div class="mb-2 form-check">
                                        <input class="form-check-input" type="checkbox" id="documentation">
                                        <label class="pt-1 form-check-label small" for="documentation">
                                            Receive documentation
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="contact">
                                        <label class="pt-1 form-check-label small" for="contact">
                                            Be contacted by telephone
                                        </label>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="p-3 py-2 text-white btn fw-semibold"
                                    style="background:#f79433;border-radius:6px;">
                                    Send request
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- ================= PRODUCT INFO ================= -->
                    <div class="col-md-3">
                        <div class="gap-4 d-flex flex-column">
                            <div class="p-4 bg-white shadow-sm rounded-3">
                                <p class="mb-3 small text-muted">
                                    Your request concerns:
                                </p>
                                <div class="mb-3 text-center">
                                    <img src="https://img.directindustry.com/images_di/photo-mg/58734-20973186.jpg"
                                        class="rounded img-fluid"
                                        alt="Belt Conveyor">
                                </div>
                                <h6 class="mb-1 text-uppercase fw-bold small text-muted">
                                    Belt Conveyor
                                </h6>
                                <p class="mb-3 small text-muted">TS 1600-105</p>
                                <img src="https://img.directindustry.com/images_di/logo-p/L58734.gif"
                                    class="img-fluid"
                                    style="max-height:40px;"
                                    alt="Brand Logo">
                            </div>
                            <div class="p-4 bg-white shadow-sm rounded-3">
                                <p class="mb-1 small text-muted">Sold by:</p>
                                <h6 class="mb-1 fw-bold" style="color:#333;">
                                    TechFocus System GmbH
                                </h6>
                                <p class="mb-0 small text-muted">
                                    <i class="bi bi-geo-alt-fill text-warning"></i> Bangladesh
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ================= FOOTER TEXT ================= -->
                <div class="mt-4">
                    <p class="small text-muted" style="line-height:1.6;">
                        TechFocus Group protects your privacy. When you request an RFQ, quote,
                        documentation, prices and options, please refer to
                        <a href="#" class="text-decoration-none">our Privacy Policy</a> and
                        <a href="#" class="text-decoration-none">terms of use</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@endpush