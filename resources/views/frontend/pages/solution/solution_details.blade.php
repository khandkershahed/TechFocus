@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    <style>
        .sticky-header {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            z-index: 1020;
            transition: all 0.3s;
        }

        main {
            margin-top: 6rem;
        }
    </style>

    <section>
        <div class="brand-page-banner page_top_banner">
            <img src="{{ !empty(optional($solution)->banner_image) && file_exists(public_path('storage/solution-details/banner-image/' . optional($solution)->banner_image)) ? asset('storage/solution-details/banner-image/' . optional($solution)->banner_image) : asset('frontend/images/no-banner(1920-330).png') }}"
                alt="">
        </div>
    </section>
    <div class="container">
        <!-- content start -->
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumbs">
                        <div>
                            <a href="{{ route('homepage') }}" class="fw-bold">Home</a> &gt;
                            <a href="javascrit:void(0)" class="txt-mcl">Solutions</a> &gt;
                            <span class="txt-mcl active fw-bolder">{{ optional($solution)->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-lg-5 p-4">
                <div class="row mb-4">
                    <h3 class="titles main-color py-2" style="border-bottom: 3px solid #00143073;">
                        {{ optional($solution)->name }}
                    </h3>
                    @if (!empty(optional($solution)->header))
                        <h5 style="border-left: 3px solid #001430; padding-left:10px">
                            {{ optional($solution)->header }}
                        </h5>
                    @endif
                </div>
            </div>
        </div>

        @if (!empty(optional($solution)->rowOne))
            <section class="container section_padding my-4">
                <div class="row py-lg-5 py-2">
                    <div class="col-lg-7 col-sm-12">
                        <div class="section_text_wrapper">
                            <h4 class="m-0">{{ optional($solution->rowOne)->title }}</h4>
                            <p style="text-align: justify;font-size: var(--paragraph-font-size);" class="pt-3">
                                {!! optional($solution->rowOne)->short_des !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-12">
                        <div class="industry_single_help_list">
                            <h5 class="p-0">{{ optional($solution->rowOne)->list_title }}</h5>
                            <ul class="ms-1 solution-list-area">
                                <li class="d-flex">
                                    <div>
                                        <span><i class="fa-regular fa-bookmark main_color pe-2"></i>
                                            {{ optional($solution->rowOne)->list_one }}</span>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <div>
                                        <span><i class="fa-regular fa-bookmark main_color pe-2"></i>
                                            {{ optional($solution->rowOne)->list_two }}</span>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <div>
                                        <span><i class="fa-regular fa-bookmark main_color pe-2"></i>
                                            {{ optional($solution->rowOne)->list_three }}</span>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <div>
                                        <span><i class="fa-regular fa-bookmark main_color pe-2"></i>
                                            {{ optional($solution->rowOne)->list_four }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!----------End--------->
        <!--======// Solution feature //======-->
        @if (!empty(optional($solution)->solutionCardOne) || !empty(optional($solution)->solutionCardTwo) || !empty(optional($solution)->solutionCardThree) || !empty(optional($solution)->solutionCardFour)) 
            <section class="my-4" style="background-color: #eee;">
                <div class="container py-lg-5 py-2">
                    @php
                        $cards = [
                            optional($solution)->solutionCardOne,
                            optional($solution)->solutionCardTwo,
                            optional($solution)->solutionCardThree,
                            optional($solution)->solutionCardFour,
                        ];
                       
                    @endphp
                    <div class="row d-flex justify-content-center pt-3">
                        @foreach ($cards as $card)
                            <div class="col-lg-3 col-sm-12">
                                <div class="card border-0 shadow-none rounded-2 solution-feature-container mx-auto">
                                    <img class="card-img-top"
                                        src="{{ !empty($card->image) && file_exists(public_path('storage/solution-card/' . $card->image)) ? asset('storage/solution-card/' . $card->image) : asset('frontend/images/brandPage-logo-no-img(217-55).jpg') }}"
                                        alt="Card image cap" width="150px" height="150px">
                                    <div class="card-body rounded-2 w-sm-100 solution-feature-cards">
                                        <h5 class="card-title text-center main_color">{{ $card->title }}</h5>
                                        <p class="text-muted p-2"
                                            style="font-size: 15px; font-weight: 300; text-align: center;">
                                            {{ Str::words($card->short_des, 22, '...') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <!----------End--------->
        <!--======// Gradian Background //======-->
        <section class="gradient_bg my-4">
            <div class="container">
                <div class="call_to_action_text py-sm-3">
                    <h4 class="section_title">{{ optional($solution)->row_three_title }}</h4>
                    <p class="w-100 mx-auto solution_para mb-1">{{ optional($solution)->row_three_header }}</p>
                </div>
            </div>
        </section>
        <!----------End--------->
        <!--=======// Building resilient IT //=====-->
        @if (!empty(optional($solution)->rowFour))
            <section class="section_padding my-4">
                <div class="container my-5">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 account_benefits_section" style="text-align: justify;">
                            <h3>{{ optional($solution->rowFour)->title }}</h3>
                            <p>{!! optional($solution->rowFour)->description !!} </p>
                            @if (!empty(optional($solution->rowFour)->btn_name))
                                <a href="{{ optional($solution->rowFour)->link }}"
                                    class="common_button effect01 mt-4">{{ optional($solution->rowFour)->btn_name }}</a>
                            @endif
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            {{-- <img class="img-fluid rounded" src="{{ asset('storage/' . optional($solution->rowFour)->image) }}" alt="" width="540px" height="338px"> --}} <img class="img-fluid"
                                src="{{ !empty(optional($solution->rowFour)->image) && file_exists(public_path('storage/row/' . optional($solution->rowFour)->image)) ? asset('storage/row/' . optional($solution->rowFour)->image) : asset('frontend/images/no-row-img(580-326).png') }}"
                                alt="" width="540px" height="338px"
                                style="    border-top-right-radius: 60px !important;
                              border-bottom-left-radius: 60px !important;">
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-------------End--------->
        <!--======// Solution feature //======-->
        <section class="my-4" style="background-color: #eee;">
            <div class="container py-lg-5 py-2">
                <!--title-->
                <div class="section_text_wrapper">
                    <h3 class="section_title solution_title">{{ optional($solution)->row_five_title }}</h3>
                    <p class="text-center w-75 mx-auto solution_para">{{ optional($solution)->row_five_header }}</p>
                </div>
                 @if (!empty(optional($solution)->solutionCardFive) || !empty(optional($solution)->solutionCardSix) || !empty(optional($solution)->solutionCardSeven) || !empty(optional($solution)->solutionCardEight)) 
                    <div class="row py-lg-5 py-2 justify-content-center">
                        @php
                             $cardsections2 = [
                                optional($solution)->solutionCardFive,
                                optional($solution)->solutionCardSix,
                                optional($solution)->solutionCardSeven,
                                optional($solution)->solutionCardEight,
                            ];
                        @endphp
                        <!-- item -->
                        @foreach ($cardsections2 as $cardsection2)
                            <div class="col-lg-4 col-sm-12 product_veiw_details_item mb-3">
                                <!-- image -->
                                <img class="rounded-circle img-fluid"
                                    src="{{ !empty($cardsection2->image) && file_exists(public_path('storage/solution-card/' . $cardsection2->image)) ? asset('storage/solution-card/' . $cardsection2->image) : asset('frontend/images/no-brand-img.png') }}"
                                    alt="" style="width: 150px; height: 150px;">
                                <!-- content -->
                                <div class="product_veiw_details_item_content">
                                    <h5 class="m-0 py-3 main_color">{{ $cardsection2->title }}</h5>
                                    <p class="p-0 m-0" style="font-size: 16px;">{!! $cardsection2->short_des !!}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

    </div>
@endsection


{{-- <div class="container">
    <!-- content start -->
    <div class="">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs">
                    <div>
                        <a href="{{ route('homepage') }}" class="fw-bold">Home</a> &gt;
                        <a href="javascrit:void(0)" class="txt-mcl">Solutions</a> &gt;
                        <span class="txt-mcl active fw-bolder">{{ optional($solution)->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-lg-5 p-4">
           <div class="row mb-4">
            <h3 class="titles main-color py-2" style="border-bottom: 3px solid #00143073;">
                {{ optional($solution)->name }}
            </h3>
            @if (!empty(optional($solution)->header))
                <h5 style="border-left: 3px solid #001430; padding-left:10px">
                    {{ optional($solution)->header }}
                </h5>
            @endif
           </div>
           <div class="row mb-4">
                <div class="col-lg-7 col-sm-12">
                    <div class="section_text_wrapper">
                        <h4 class="m-0">Bridging the Gap Unveiling the Evolution and Impact of Smart Terminals in Modern Connectivity Solutions</h4>
                        <p style="text-align: justify;font-size: var(--paragraph-font-size);" class="pt-3">
                            </p><p>In the rapidly changing tech world, smart terminals are now crucial, transforming how businesses work and people access information. They surpass traditional terminals by adding advanced features and connectivity, becoming essential tools in different industries.<br></p><p></p>
                    </div>
                </div>
                <div class="col-lg-5 col-sm-12">
                    <div class="industry_single_help_list">
                        <h5 class="p-0">Feature of Smart Terminals</h5>
                        <ul class="ms-1 solution-list-area">
                            <li class="d-flex">
                                <div>
                                    <span><i class="fa-regular fa-bookmark main_color pe-2" aria-hidden="true"></i> Intuitive touch screens enhance user-friendliness.</span>
                                </div>
                            </li>
                            <li class="d-flex">
                                <div>
                                    <span><i class="fa-regular fa-bookmark main_color pe-2" aria-hidden="true"></i> Promotes a more interactive experience.</span>
                                </div>
                            </li>
                            <li class="d-flex">
                                <div>
                                    <span><i class="fa-regular fa-bookmark main_color pe-2" aria-hidden="true"></i> Enables seamless integration with various devices and systems.</span>
                                </div>
                            </li>
                            <li class="d-flex">
                                <div>
                                    <span><i class="fa-regular fa-bookmark main_color pe-2" aria-hidden="true"></i> Handles complex tasks efficiently.</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
           </div>
        </div>
    </div>
    <div class="">
        <div class="row my-5">
            <div class="col-lg-12 text-center">
                <div class="">
                    <a href="">
                        <span class="badge rounded-0" style="background-color: var(--main-color)">CHEMICAL &
                            BIOTECH</span>
                    </a>
                    <a href="">
                        <span class="badge rounded-0" style="background-color: var(--main-color)">FEATURED</span>
                    </a>
                    <a href="">
                        <span class="badge rounded-0" style="background-color: var(--main-color)">LABORATORY</span>
                    </a>
                    <a href="">
                        <span class="badge rounded-0" style="background-color: var(--main-color)">MEDICAL
                            INDUSTRY</span>
                    </a>
                    <a href="">
                        <span class="badge rounded-0" style="background-color: var(--main-color)">SPONSORED
                            CONTENT</span>
                    </a>
                </div>
                <div class="pt-3 pb-5">
                    <h3>SPONSORED. Evolving in Response to a Global Health Crisis</h3>
                    <p class="pt-3">Share on</p>
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="" class="social-icons-sponserd">
                            <img class="ms-1" src="https://i.ibb.co/fXM97wS/facebook.png" width="40px" height="40px"
                                alt="" />
                        </a>
                        <a href="" class="social-icons-sponserd">
                            <img class="ms-1" src="https://i.ibb.co/nCD0yR1/twitter.png" width="40px" height="40px"
                                alt="" />
                        </a>
                        <a href="" class="social-icons-sponserd">
                            <img class="ms-1" src="https://i.ibb.co/9q63kzj/linkedin.png" width="40px" height="40px"
                                alt="" />
                        </a>
                        <a href="" class="social-icons-sponserd">
                            <img class="ms-1" src="https://i.ibb.co/y4hBvJD/pinterest.png" width="40px" height="40px"
                                alt="" />
                        </a>
                    </div>
                </div>
                <div>
                    <img src="https://i.ibb.co/NSv9TpN/12-trendspot-integra-viaflo-96-384-shaker-heater-front.jpg"
                        alt="" />
                    <p class=" p-4">
                        INTEGRA Biosciences which manufactures laboratory equipment is
                        unveiling the VIAFLO 96 and VIAFLO 384 pipettes which are
                        compact, affordable, and easy to use (Credit: INTEGRA
                        Biosciences)
                    </p>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-lg-9 col-sm-12">
                <!--Sponsored Profile -->
                <div class="profile">
                    <div class="d-flex justify-content-center">
                        <img class="rounded-circle"
                            src="https://emag.directindustry.com/wp-content/uploads/sites/3/sponsor-139x93.jpg"
                            width="80px" height="80px" alt="" />
                    </div>
                    <div class="profile-details text-center">
                        <p class="pt-3">By Sponsor</p>
                        <p>
                            July 5, 20236 mins <span class="main-color">Updated</span> on
                            July 5, 2023
                        </p>
                        <hr />
                    </div>
                    <!-- Sponsored Information -->
                    <div>
                        <p class="fw-bold text-justify sp-info font-poppins font-height">
                            The sudden outbreak of SARS-CoV-2 meant that clinical research
                            labs all over the world invested in high-quality electronic
                            liquid handling tools to improve the throughput of PCR testing
                            as part of wider efforts to bring the virus under control. PCR
                            testing for SARS-CoV-2 has since been gradually scaled back,
                            sparking curiosity as to how the liquid handling tools
                            acquired during the pandemic are now being used, if at all. To
                            shed some light on this topic, INTEGRA Biosciences surveyed
                            its customers who had previously been performing COVID-19
                            testing, asking how they were using their new platforms and
                            devices now.
                        </p>
                        <i class="fw-bold text-justify sp-info font-poppins font-height">Content provided by Dr. Éva
                            Mészáros, Application Specialist,
                            INTEGRA Biosciences</i>
                        <p class="pt-4 text-justify sp-info font-poppins font-height">
                            The rapid onset of the SARS-CoV-2 pandemic forced clinical
                            labs around the world to change their focus to rapid PCR
                            testing. The scale of these operations also prompted
                            facilities to seek new instruments that would allow them to
                            streamline their testing workflows, increasing sample
                            throughputs and accelerating turnaround times despite frequent
                            staff absences and highly variable workloads.
                        </p>
                        <p class="pt-2 text-justify sp-info font-poppins font-height">
                            Since then, the need for SARS-CoV-2 testing has slowly
                            diminished, forcing labs to evolve and shift their focus once
                            again. A survey by INTEGRA Biosciences aimed to find out how
                            its customers from a broad spectrum of scientific
                            fields—spanning genomics, toxicology, virology, and molecular
                            diagnostics—have since repurposed the liquid handling
                            instruments that they originally purchased for SARS-CoV-2
                            testing.
                        </p>
                    </div>
                    <div>
                        <img src="https://i.ibb.co/smsBynV/image1-1250x726.jpg" alt="" />
                        <p class="text-center py-2">
                            INTEGRA pipetting solutions purchased
                        </p>
                    </div>
                    <div>
                        <h4 class="fw-bold pb-3">Adapting to the Need</h4>
                        <p>
                            Half of all the facilities surveyed were performing all of
                            their liquid handling tasks manually prior to the pandemic and
                            purchased INTEGRA pipetting systems to up their capacity and
                            cope with high numbers of samples.
                        </p>
                        <p>
                            This included a variety of instruments—such as the
                            <a href="#" class="main-color fw-bold">VOYAGER adjustable tip spacing pipettes
                                <i class="fa-solid fa-arrow-up-right-from-square"></i></a>,
                            <a href="#" class="main-color fw-bold">VIAFLO 96 and VIAFLO 384 handheld electronic pipettes
                                <i class="fa-solid fa-arrow-up-right-from-square"></i></a>,
                            <a href="#" class="main-color fw-bold">VIAFLO lightweight electronic pipettes
                                <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                            , and
                            <a href="#" class="main-color fw-bold">MINI 96 portable electronic pipettes—depending on the
                                labs
                                <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                            ’ specific needs, set-up and team size. In addition, 75
                            percent of labs chose to automate their liquid handling
                            workflows with an ASSIST PLUS pipetting robot.
                        </p>

                        <h4 class="fw-bold pb-3">Demonstrating Versatility</h4>
                        <p class="pt-2">
                            All of the laboratories involved in the survey reported that
                            the demand for COVID-19 testing is now far less than it was
                            during the peak of the pandemic, with 75 percent of facilities
                            processing only 10 percent of the sample volumes they saw at
                            the height of their testing operations.
                        </p>
                        <p class="pt-2">
                            As the need for testing has decreased, these pipetting
                            instruments have gradually become available for use in other
                            applications, and INTEGRA pipettes are now being used to
                            prepare, reformat and transfer samples for genetics
                            studies—such as nucleic acid extraction and NGS library
                            preparation—as well as for the investigation of mutations in
                            the hemochromatosis, factor V and prothrombin genes.
                        </p>
                        <p class="pt-2">
                            Other labs are using these instruments in antibiotic
                            resistance studies, women’s health testing and biochemical
                            assays. This ability to rapidly evolve in the face of new
                            healthcare needs demonstrates the versatility of both the
                            liquid handling products and the innovative laboratories using
                            them.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div>
                    <img src="https://i.ibb.co/FBGFHkY/Emag-DI-7527-Staubli-Connectors-300x600-1309-CLIENT.jpg"
                        height="500px" width="100%" alt="" />
                </div>
                <div class="pt-2">
                    <img src="https://i.ibb.co/gPLQkQZ/Emag-DI-11812-Smalley-300x600-3008-CLIENT.gif" height="500px"
                        width="100%" alt="" />
                </div>
                <div class="pt-2">
                    <img src="https://i.ibb.co/1dYZ9fp/Emag-DI-213927-HNP-Microsystem-300x600-1309-CLIENT.jpg"
                        height="500px" width="100%" alt="" />
                </div>
            </div>
        </div>
    </div>
    <div class="  p-3 mb-3">
        <div class="row">
            <div class="col-lg-12 p-lg-0">
                <h5 class="fw-bold">Conclusion</h5>
                <p class="pt-3">
                    The constantly changing scientific landscape and unpredictable
                    external challenges—such as an erratic supply chain, inflated
                    running costs, and widespread understaffing—mean that labs need to
                    adopt flexible and robust liquid handling solutions that can adapt
                    to their workflow needs.
                </p>
                <p class="pt-2">
                    The findings of this short survey indicate that high-quality
                    liquid handling products—like those produced by INTEGRA—are
                    valuable assets for any lab serious about staying cost-effective
                    and remaining adaptable to the diagnostic needs of the future.
                </p>
                <div class="">
                    <span class="badge rounded-0" style="background-color: var(--main-color)">CHEMICAL & BIOTECH</span>
                    <span class="badge rounded-0" style="background-color: var(--main-color)">FEATURED</span>
                    <span class="badge rounded-0" style="background-color: var(--main-color)">LABORATORY</span>
                    <span class="badge rounded-0" style="background-color: var(--main-color)">MEDICAL INDUSTRY</span>
                    <span class="badge rounded-0" style="background-color: var(--main-color)">SPONSORED CONTENT</span>
                </div>
                <div class="mt-3 d-flex justify-content-start">
                    <img src="https://emag.directindustry.com/wp-content/uploads/sites/3/EMO_2023_Banner_1000x258px.png"
                        alt="" />
                </div>
            </div>
        </div>
    </div>
    <div class=" my-4">
        <div class="row">
            <div class="col-lg-12">
                <!--Banner -->
                <div class="swiper reletedArticale">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="card rounded-0 border-0 text-start">
                                <img class="card-img-top rounded-0"
                                    src="https://emag.directindustry.com/wp-content/uploads/sites/3/Featured-17-320x213.png"
                                    alt="Title" />
                                <div class="card-body feature-fixed">
                                    <div class="">
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">CHEMICAL & BIOTECH</span>
                                        </a>
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">FEATURED</span>
                                        </a>
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">LABORATORY</span>
                                        </a>
                                    </div>
                                    <h4 class="card-title fw-bold font-four pt-2"><a href="">Hannover Kicks Off Today!
                                            What’s in Store?</a></h4>
                                    <p class="card-text font-one">September 18, 202353 secs</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card rounded-0 border-0 text-start">
                                <img class="card-img-top rounded-0"
                                    src="https://emag.directindustry.com/wp-content/uploads/sites/3/Featured-17-320x213.png"
                                    alt="Title" />
                                <div class="card-body feature-fixed">
                                    <div class="">
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">CHEMICAL & BIOTECH</span>
                                        </a>
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">FEATURED</span>
                                        </a>
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">LABORATORY</span>
                                        </a>
                                    </div>
                                    <h4 class="card-title fw-bold font-four pt-2"><a href="">Hannover Kicks Off Today!
                                            What’s in Store?</a></h4>
                                    <p class="card-text font-one">September 18, 202353 secs</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card rounded-0 border-0 text-start">
                                <img class="card-img-top rounded-0"
                                    src="https://emag.directindustry.com/wp-content/uploads/sites/3/Featured-17-320x213.png"
                                    alt="Title" />
                                <div class="card-body feature-fixed">
                                    <div class="">
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">CHEMICAL & BIOTECH</span>
                                        </a>
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">FEATURED</span>
                                        </a>
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">LABORATORY</span>
                                        </a>
                                    </div>
                                    <h4 class="card-title fw-bold font-four pt-2"><a href="">Hannover Kicks Off Today!
                                            What’s in Store?</a></h4>
                                    <p class="card-text font-one">September 18, 202353 secs</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card rounded-0 border-0 text-start">
                                <img class="card-img-top rounded-0"
                                    src="https://emag.directindustry.com/wp-content/uploads/sites/3/Featured-17-320x213.png"
                                    alt="Title" />
                                <div class="card-body feature-fixed">
                                    <div class="">
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">CHEMICAL & BIOTECH</span>
                                        </a>
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">FEATURED</span>
                                        </a>
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">LABORATORY</span>
                                        </a>
                                    </div>
                                    <h4 class="card-title fw-bold font-four pt-2"><a href="">Hannover Kicks Off Today!
                                            What’s in Store?</a></h4>
                                    <p class="card-text font-one">September 18, 202353 secs</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="card rounded-0 border-0 text-start">
                                <img class="card-img-top rounded-0"
                                    src="https://emag.directindustry.com/wp-content/uploads/sites/3/Featured-17-320x213.png"
                                    alt="Title" />
                                <div class="card-body feature-fixed">
                                    <div class="">
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">CHEMICAL & BIOTECH</span>
                                        </a>
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">FEATURED</span>
                                        </a>
                                        <a href="">
                                            <span class="badge rounded-0 mt-1 font-two"
                                                style="background-color: var(--main-color)">LABORATORY</span>
                                        </a>
                                    </div>
                                    <h4 class="card-title fw-bold font-four pt-2"><a href="">Hannover Kicks Off Today!
                                            What’s in Store?</a></h4>
                                    <p class="card-text font-one">September 18, 202353 secs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-prev"><i class="fa-solid fa-arrow-left-long"></i></div>
                    <div class="swiper-button-next"><i class="fa-solid fa-arrow-right-long"></i></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid bg-white">
    <div class="p-3">
        <div class="row align-items-center">
            <div class="col-lg-2 col-sm-12">
                <div>
                    <img src="https://emag.directindustry.com/wp-content/uploads/sites/3/logo.svg" alt="">
                </div>
                <p class="font-two py-2">Industry News for Business Leaders</p>
            </div>
            <div class="col-lg-2 col-sm-12">
                <div>
                    <ul class="text-center">
                        <li><a href="" style="border-bottom: 3px solid var(--main-color);">CATEGORIES</a></li>
                        <li class="pt-3"><a href="">Aerospace</a></li>
                        <li><a href="">Agriculture & Food Industry</a></li>
                        <li><a href="">Automotive</a></li>
                        <li><a href="">Building & Construction</a></li>
                        <li><a href="">Electronics</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-sm-12">
                <div>
                    <div>
                        <ul class="text-center">
                            <li><a href="" style="border-bottom: 3px solid var(--main-color);">ABOUT US</a></li>
                            <li class="pt-3"><a href="">Aerospace</a></li>
                            <li><a href="">Agriculture & Food Industry</a></li>
                            <li><a href="">Automotive</a></li>
                            <li><a href="">Building & Construction</a></li>
                            <li><a href="">Electronics</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-12">
                <div>
                    <div>
                        <ul class="text-center">
                            <li><a href="" style="border-bottom: 3px solid var(--main-color);">SERVICES</a></li>
                            <li class="pt-3"><a href="">Aerospace</a></li>
                            <li><a href="">Agriculture & Food Industry</a></li>
                            <li><a href="">Automotive</a></li>
                            <li><a href="">Building & Construction</a></li>
                            <li><a href="">Electronics</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-12">
                <div>
                    <div>
                        <ul class="text-center">
                            <li><a href="" style="border-bottom: 3px solid var(--main-color);">GENERAL</a></li>
                            <li class="pt-3"><a href="">Aerospace</a></li>
                            <li><a href="">Agriculture & Food Industry</a></li>
                            <li><a href="">Automotive</a></li>
                            <li><a href="">Building & Construction</a></li>
                            <li><a href="">Electronics</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-12">
                <div>
                    <div>
                        <ul class="text-center">
                            <li><a href="" style="border-bottom: 3px solid var(--main-color);">SITES OF THE GROUP</a>
                            </li>
                            <li class="pt-3"><a href="">Aerospace</a></li>
                            <li><a href="">Agriculture & Food Industry</a></li>
                            <li><a href="">Automotive</a></li>
                            <li><a href="">Building & Construction</a></li>
                            <li><a href="">Electronics</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
