@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    @if (!empty($banner->banner_one_image) || !empty($banner->banner_two_image) || !empty($banner->banner_three_image))
        <section class="ban_sec">
            <div class="swiper bannerSwiper">
                <div class="swiper-wrapper">
                    @if ($banner && !empty($banner->banner_one_image))
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('storage/' . $banner->banner_one_image) }}" class="img-fluid"
                                    alt="Banner One"
                                    onerror="this.onerror=null;this.src='https://templates.thememodern.com/industris/images/subheader-about.jpg';" />
                            </a>
                        </div>
                    @endif
                    @if ($banner && !empty($banner->banner_two_image))
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('storage/' . $banner->banner_two_image) }}" class="img-fluid"
                                    alt="Banner Two"
                                    onerror="this.onerror=null;this.src='https://templates.thememodern.com/industris/images/subheader-about.jpg';" />
                            </a>
                        </div>
                    @endif
                    @if ($banner && !empty($banner->banner_three_image))
                        <div class="swiper-slide">
                            <a href="">
                                <img src="{{ asset('storage/' . $banner->banner_three_image) }}" class="img-fluid"
                                    alt="Banner Three"
                                    onerror="this.onerror=null;this.src='https://templates.thememodern.com/industris/images/subheader-about.jpg';" />
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
    <section class="ban_sec section_one">
        <div class="p-0 container-fluid">
            <div class="ban_img">
                <img src="https://templates.thememodern.com/industris/images/subheader-about.jpg" alt="banner"
                    border="0">
                <div class="ban_text">
                    <strong>
                        Contact Us
                    </strong>
                    <ul class="mt-5 d-flex align-items-center ps-0">
                        <li class="text-white"><a href="#" class="">Home</a></li>
                        <li class="text-white"><span class="me-2 ms-2">/</span></li>
                        <li class="main-color"><a href="#">About Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container mt-4 custom-spacer">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="mb-4">
                        <h1 class="mb-0">Contact Info</h1>
                        <h5 class="pt-4 fw-bold">
                            <span class="main-color">Hotline :</span>
                            +84 1900 8198
                        </h5>
                        <ul class="ms-0 ps-0">
                            <li class="pt-3">
                                <a href=""><i
                                        class="fa-solid fa-envelope pe-2 main-color"></i>Info.industris@gmail.com</a>
                            </li>
                            <li class="pt-3">
                                <i class="fa-solid fa-location-dot pe-2 main-color"></i>
                                Crows Nest Apt 69, Sydney, Australia
                                <a href="https://www.google.com/maps?q=Crows+Nest+Apt+69,+Sydney,+Australia" target="_blank"
                                    class="main-color">(View map)</a>
                                Info.industris@gmail.com
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                             

                 <form action="{{ route('contact.add') }}" method="post" class="needs-validation" novalidate
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <input type="text" class="p-3 form-control rounded-0"
                                            id="exampleFormControlInput1" placeholder="Your Name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <input type="number" class="p-3 form-control rounded-0"
                                            id="exampleFormControlInput1" placeholder="Your Phone Number" name="phone"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <input type="email" class="p-3 form-control rounded-0"
                                            id="exampleFormControlInput1" placeholder="Your Email Address" name="email"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <textarea class="p-3 form-control rounded-0" id="exampleFormControlTextarea1" rows="10" placeholder="Your Message"
                                            name="message" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div style="width: 20%;">
                                <button type="submit" class="p-3 mx-auto common-btn-3">Submit <i
                                        class="fas fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="p-0 container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d11200.675829730526!2d-75.6876061!3d45.42609535!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cce04ff4fe494ef%3A0x26bb54f60c29f6e!2sParliament+Hill!5e0!3m2!1sen!2sca!4v1528808935681"
                        width="100%" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container custom-spacer">
            <div class="row">
                <div class="mb-5 text-center col-lg-12">
                    <h1 class="fw-bold"><span
                            style="border-top: 2px solid var(--primary-color); font-size: 38px;">Get</span> in Touch</h1>
                    <p class="mx-auto w-50">TechFocus strives to provide the best service possible with every contact! Fill
                        the online forms to get
                        the info you're looking for right now!</p>
                </div>
                <div class="col-lg-4">
                    <div class="p-3 border-0 contact-card card"
                        style=" background-color: var(--secondary-deep-color); box-shadow: var(--custom-shadow)">
                        <img class="mx-auto" width="150px"
                            src="https://www.cosmed.com/images/08_icons/get_in_touch/register_product.svg"
                            class="card-img-top" alt="...">
                        <div class="text-center card-body">
                            <h3 class="text-white card-title">Partner Registration</h3>
                            <p class="py-2 mx-auto text-white card-text w-75">Fill the online form to get software upgrades
                                and more
                                advantages</p>
                            <a href="{{ route('register') }}" class="mx-auto mt-2 bg-white border btn common-btn-2 rounded-0 w-50">
                                <span class="text-gradient">Register Now</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="p-3 border-0 contact-card card" style=" box-shadow: var(--custom-shadow)">
                        <img class="mx-auto" width="150px"
                            src="https://www.cosmed.com/images/08_icons/get_in_touch/request_information.svg"
                            class="card-img-top" alt="...">
                        <div class="text-center card-body">
                            <h3 class="card-title">Get Support Now</h3>
                            <p class="py-2 mx-auto card-text w-75">Fill the online form to get software upgrades
                                and more
                                advantages</p>
                            <a href="{{ route('buying.guide') }}" class="mx-auto mt-2 border btn common-btn-3 rounded-0 w-50">Contact
                                Us</a>
                        </div>
                    </div>
                </div>

    </section>

    <section class="bg-white">
        <div class="container pb-5">
            <div class="row">
                <div class="my-5 text-center col-lg-12">
                    <h1 class="fw-bold"><span class=""
                            style="border-top: 2px solid var(--primary-color); font-size: 38px;">Our</span> Office Location
                    </h1>
                </div>
                <div class="col-lg-4">
                    <div class="p-3">
                        <h4> <span class=""
                                style="border-top: 3px solid var(--primary-color); font-size: 22px;">APA</span>C (Asia and
                            Pacific )</h4>
                        <p class="m-0"><i class="fa-solid fa-location-dot main-color pe-2"></i>36-37, Probal
                            Housing, Ring Road</p>
                        <p class="m-0 ps-4">Mohammadpur, Dhaka-1207, Bangladesh</p>
                        <p class="m-0"><i class="fa-solid fa-mobile-screen main-color pe-2"></i>+880 1714-243446</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="p-3">
                        <h4><span class=""
                                style="border-top: 3px solid var(--primary-color); font-size: 22px;">EME</span>A (Europe,
                            Middle East, Africa)</h4>
                        <p class="m-0"><i class="fa-solid fa-location-dot main-color pe-2"></i> 10, Anson Road,
                            #21-07 International Plaza, </p>
                        <p class="m-0 ps-4">Singapore 079903</p>
                        <p class="m-0"><i class="fa-solid fa-mobile-screen main-color pe-2"></i>+44 7423 060208</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="p-3">
                        <h4><span class=""
                                style="border-top: 3px solid var(--primary-color); font-size: 22px;">SEA</span>N (South
                            East Asia, Australia)</h4>
                        <p class="m-0"><i class="fa-solid fa-location-dot main-color pe-2"></i>36-37, Probal
                            Housing,
                            Ring Road,</p>
                        <p class="m-0 ps-4">Mohammadpur, Dhaka-1207, Bangladesh</p>
                        <p class="m-0"><i class="fa-solid fa-mobile-screen main-color pe-2"></i>+65 9747 1974</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
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
