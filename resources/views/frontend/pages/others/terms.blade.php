@extends('frontend.master')
@section('metadata')
<meta name="description" content="Read our Terms & Conditions and Privacy Policy">
<title>Terms & Conditions - {{ config('app.name') }}</title>
@endsection
@section('content')
<style>
  .flowpaper_viewer_container>* {
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background: white !important;
    background-color: white !important;
  }
</style>

<div class="container-fluid px-0">
  <div class="p-5 breadcrumb-banner-area"
    style="background-image: url('{{ asset('/img/TechFocusTermsandConditionsPageBanner(1920x525).webp') }}')">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumbs">
            <div class="text-white fw-bold">
              <a href="{{ url('/') }}" class="">Home</a> -
              <span class="txt-mcl">Terms & Conditions</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="p-0 my-5 container-fluid">
  <h1 class="mt-3 text-center fw-bold">Ter<span style="color: var(--primary-color); font-size: 40px; font-weight: bold;">ms & Con</span>ditions</h1>
  <p class="text-center">Explore the intricate landscape of our 'Terms & Conditions' as we delineate the rules.</p>

  <div class="container">
    <div class="row">
      <div class="col-lg-12">

        @if($termsAndPolicies && count($termsAndPolicies) > 0)
        @foreach($termsAndPolicies as $policy)
        <div class="mb-4 ">
          <div>
            <h3 class="mb-0 fw-bold" style="color: var(--primary-color);">
              {{ $policy->name }}
            </h3>
            <div class="mt-2">
              <small class="text-muted">
                <strong>Version:</strong> {{ $policy->version }}
              </small>
              <small class="text-muted">
                <strong>Effective Date:</strong> {{ \Carbon\Carbon::parse($policy->effective_date)->format('M d, Y') }}
              </small>
            </div>
          </div>
          <div class="py-3">
            @if($policy->content)
            <div class="policy-content">
              {!! $policy->content !!}
            </div>
            @else
            <div class="py-4 text-center">
              <p class="text-muted">No content available for this policy.</p>
            </div>
            @endif

            @if($policy->expiration_date)
            <div class="pt-3 mt-3 border-top">
              <small class="text-muted">
                <strong>Expiration Date:</strong> {{ \Carbon\Carbon::parse($policy->expiration_date)->format('M d, Y') }}
              </small>
            </div>
            @endif
          </div>
        </div>
        @endforeach
        @else
        <div class="py-5 text-center">
          <div class="p-5 border-0 alert alert-info rounded-0">
            <h4 class="mb-0">No Terms & Policies Available</h4>
            <p class="mb-0">We're currently updating our terms and policies. Please check back later.</p>
          </div>
        </div>
        @endif

        {{-- PDF Viewer Section (if you want to keep it for specific policies) --}}
        @if(isset($specificPolicyWithPdf) && $specificPolicyWithPdf)
        <div class="mt-5" style="border: 10px solid var(--primary-color); padding: 0; box-shadow: var(--custom-shadow)">
          <iframe class="fp-embed"
            src="http://flowpaper.com/flipbook/http://ngenitltd.com/storage/files/DTCBdrWUiJ9QEJyE4XZtNN80ySnCHBmXstUluR2w.pdf"
            width="100%" height="800" allowFullScreen>
          </iframe>
        </div>
        @endif

        <p class="pt-5 text-center">
          Terms & Conditions' as we delineate the rules, agreements, and expectations that govern our digital space.
          Delve into the fine print where clarity meets responsibility, ensuring a harmonious interaction between users and the platform.
        </p>
      </div>
    </div>
  </div>
</div>

<style>
  .policy-content {
    line-height: 1.6;
    color: #333;
  }

  .policy-content h1,
  .policy-content h2,
  .policy-content h3,
  .policy-content h4,
  .policy-content h5,
  .policy-content h6 {
    color: var(--primary-color);
    margin-top: 1.5rem;
    margin-bottom: 1rem;
  }

  .policy-content p {
    margin-bottom: 1rem;
  }

  .policy-content ul,
  .policy-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
  }

  .policy-content li {
    margin-bottom: 0.5rem;
  }

  .card {
    transition: transform 0.2s ease-in-out;
  }

  .card:hover {
    transform: translateY(-2px);
  }
</style>
@endsection