@extends('frontend.master')

@section('metadata')
<meta name="description" content="Read our Privacy Policy and understand how we protect your personal information">
<title>{{ (isset($policy->title) ? $policy->title : 'Privacy Policy') }} - {{ config('app.name') }}</title>
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
  
  .policy-section {
    scroll-margin-top: 100px;
  }
</style>

<div class="container-fluid px-0">
  <div class="p-5 breadcrumb-banner-area"
    style="background-image: url('{{ asset('img/TechFocusTermsandConditionsPageBanner(1920x525).webp') }}')">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="breadcrumbs">
            <div class="text-white fw-bold">
              <a href="{{ url('/') }}" class="">Home</a> -
              <span class="txt-mcl">Privacy Policy</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="p-0 my-5 container-fluid">
  <h1 class="mt-3 text-center fw-bold">Priv<span style="color: var(--primary-color); font-size: 40px; font-weight: bold;">acy Pol</span>icy</h1>
  <p class="text-center">Understand how we collect, use, and protect your personal information through our comprehensive Privacy Policy.</p>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        
        @if(isset($policy) && $policy)
          <!-- Policy Header -->
          <div class="text-center mb-5">
            <h2 class="mb-3" style="color: var(--primary-color);">{{ $policy->title ?? 'Privacy Policy' }}</h2>
            
            @if(($policy->version ?? false) || ($policy->effective_date ?? false))
            <div class="d-flex justify-content-center align-items-center gap-4 flex-wrap mb-3">
              @if($policy->version ?? false)
                <span class="badge rounded-pill px-3 py-2" style="background-color: var(--primary-color); color: white;">
                  <i class="fas fa-code-branch me-1"></i> Version: {{ $policy->version }}
                </span>
              @endif
              @if($policy->effective_date ?? false)
                <span class="badge rounded-pill px-3 py-2" style="background-color: #28a745; color: white;">
                  <i class="fas fa-calendar-alt me-1"></i> 
                  Effective: {{ \Carbon\Carbon::parse($policy->effective_date)->format('M d, Y') }}
                </span>
              @endif
            </div>
            @endif
            
            @if($policy->updated_at ?? false)
            <p class="text-muted">
              <i class="fas fa-clock me-1"></i> 
              Last Updated: {{ $policy->updated_at->format('M d, Y') }}
            </p>
            @endif
          </div>

          <!-- Table of Contents -->
          @if(isset($policy->sections) && $policy->sections && $policy->sections->isNotEmpty())
            <div class="card mb-4 border-0 shadow-sm" style="border-left: 4px solid var(--primary-color) !important;">
              <div class="card-header bg-light border-0 py-3">
                <h5 class="mb-0 fw-bold">
                  <i class="fas fa-list me-2" style="color: var(--primary-color);"></i>Table of Contents
                </h5>
              </div>
              <div class="card-body">
                <div class="row">
                  @foreach($policy->sections as $section)
                    <div class="col-md-6 mb-2">
                      <a href="#section-{{ $loop->index }}" class="text-decoration-none d-flex align-items-start">
                        <i class="fas fa-chevron-right mt-1 me-2" style="color: var(--primary-color); font-size: 0.8rem;"></i>
                        <span>
                          @if($section->section_number ?? false)
                            <strong>{{ $section->section_number }}.</strong>
                          @endif
                          {{ $section->section_title ?? '' }}
                        </span>
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          @endif

          <!-- Policy Content -->
          <div class="card border-0 shadow-lg mb-5">
            <div class="card-body p-4">
              @if(isset($policy->sections) && $policy->sections && $policy->sections->isNotEmpty())
                @foreach($policy->sections as $index => $section)
                  <div class="mb-5 pb-4 border-bottom policy-section" id="section-{{ $index }}">
                    <div class="d-flex align-items-start mb-3">
                      @if($section->section_number ?? false)
                        <span class="badge rounded-pill px-3 py-2 me-3" 
                              style="background-color: var(--primary-color); color: white; font-size: 1rem;">
                          {{ $section->section_number }}
                        </span>
                      @endif
                      <h3 class="mb-0 fw-bold" style="color: var(--primary-color);">
                        {{ $section->section_title ?? '' }}
                      </h3>
                    </div>
                    <div class="ms-5 ps-2">
                      <div class="policy-content">
                        {!! $section->section_content ?? '' !!}
                      </div>
                    </div>
                  </div>
                @endforeach
              @elseif($policy->content ?? false)
                <div class="policy-content">
                  {!! $policy->content !!}
                </div>
              @else
                <div class="alert alert-info border-0 rounded-0">
                  <p class="mb-0">No content available for this privacy policy.</p>
                </div>
              @endif

              <!-- Contact Information -->
              <div class="mt-5 pt-4 border-top">
                <div class="alert alert-light border-0 rounded-0" role="alert" style="border-left: 4px solid var(--primary-color) !important;">
                  <h5 class="alert-heading fw-bold mb-3">
                    <i class="fas fa-question-circle me-2" style="color: var(--primary-color);"></i>Questions?
                  </h5>
                  <p class="mb-0">
                    If you have any questions about this Privacy Policy, please contact us at:
                    <a href="mailto:privacy@ngenit.com" class="fw-bold" style="color: var(--primary-color); text-decoration: none;">
                      privacy@ngenit.com
                    </a>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Last Updated -->
          <div class="text-center mb-5">
            <p class="text-muted small">
              <i class="fas fa-info-circle me-1"></i>
              @if($policy->updated_at ?? false)
                This policy was last updated on {{ $policy->updated_at->format('M d, Y') }}
              @endif
            </p>
          </div>

        @else
          <!-- No policy available -->
          <div class="py-5 text-center">
            <div class="p-5 border-0 alert alert-info rounded-0">
              <h4 class="mb-3" style="color: var(--primary-color);">Privacy Policy</h4>
              <p class="mb-4">We are committed to protecting your privacy and ensuring the security of your personal information.</p>
              
              <div class="text-start mt-4">
                <p>At Techfocus, we value your privacy and are committed to protecting your personal information. This Privacy Policy outlines how we collect, use, and safeguard your data when you use our services.</p>
                
                <div class="alert alert-light mt-4 border-0 rounded-0" style="border-left: 4px solid var(--primary-color) !important;">
                  <p class="mb-0">
                    <strong>Contact Us:</strong> If you have questions about privacy, email us at 
                    <a href="mailto:privacy@techfocus.com" class="fw-bold" style="color: var(--primary-color); text-decoration: none;">
                    techfocusltd@gmail.com
                    </a>
                  </p>
                </div>
              </div>
              
              @auth
                @if(auth()->user()->is_admin)
                  <div class="mt-4">
                    <a href="{{ route('admin.privacy-policy.create') }}" class="btn px-4 py-2" 
                       style="background-color: var(--primary-color); color: white; border: none;">
                      <i class="fas fa-plus me-2"></i>Create Detailed Privacy Policy
                    </a>
                  </div>
                @endif
              @endauth
            </div>
          </div>
        @endif

        <!-- Summary -->
        <p class="pt-5 text-center">
          Our Privacy Policy ensures transparency in how we handle your personal data. 
          We are dedicated to maintaining the trust you place in us by implementing robust security measures 
          and following best practices for data protection.
        </p>
      </div>
    </div>
  </div>
</div>

<style>
  .policy-content {
    line-height: 1.8;
    color: #333;
    font-size: 1.05rem;
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
    font-weight: 600;
  }

  .policy-content p {
    margin-bottom: 1.2rem;
  }

  .policy-content ul,
  .policy-content ol {
    margin-bottom: 1.2rem;
    padding-left: 2rem;
  }

  .policy-content li {
    margin-bottom: 0.6rem;
  }

  .policy-content strong {
    color: #2c3e50;
  }

  .card {
    transition: transform 0.3s ease-in-out;
  }

  .card:hover {
    transform: translateY(-5px);
  }

  .txt-mcl {
    color: white !important;
  }

  .breadcrumb-banner-area {
    background-size: cover;
    background-position: center;
    min-height: 250px;
    display: flex;
    align-items: center;
  }

  a:hover {
    color: var(--primary-color) !important;
  }
</style>

<!-- Back to Top Button -->
<a href="#" class="btn btn-lg back-to-top shadow" 
   style="position: fixed; bottom: 20px; right: 20px; display: none; 
          background-color: var(--primary-color); color: white; border: none; border-radius: 50%; 
          width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;" 
   id="back-to-top">
    <i class="fas fa-arrow-up"></i>
</a>

<script>
  // Back to top functionality
  document.addEventListener('DOMContentLoaded', function() {
    const backToTopButton = document.getElementById('back-to-top');
    
    window.addEventListener('scroll', function() {
      if (window.pageYOffset > 300) {
        backToTopButton.style.display = 'flex';
      } else {
        backToTopButton.style.display = 'none';
      }
    });
    
    backToTopButton.addEventListener('click', function(e) {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  });
</script>
@endsection