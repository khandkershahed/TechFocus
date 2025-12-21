@extends('frontend.master')

@section('title', (isset($policy->title) ? $policy->title . ' | Techfocus' : 'Privacy Policy | Techfocus'))

@section('content')

<!-- Page Banner -->
<div class="policy-banner mb-5">
    <img 
        src="{{ asset('img/TechFocusTermsandConditionsPageBanner(1920x525).webp') }}" 
        alt="TechFocus Privacy Policy Banner"
        class="img-fluid w-100"
        style="max-height:525px; object-fit:cover;"
    >
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            @if(isset($policy) && $policy)
                <!-- Policy Header -->
                <div class="text-center mb-5">
                    <h1 class="display-4 text-primary mb-3">{{ $policy->title ?? 'Privacy Policy' }}</h1>
                    
                    {{-- @if(($policy->version ?? false) || ($policy->effective_date ?? false))
                    <div class="d-flex justify-content-center align-items-center gap-4 mb-3">
                        @if($policy->version ?? false)
                            <span class="badge badge-info p-2">
                                <i class="fas fa-code-branch me-1"></i> Version: {{ $policy->version }}
                            </span>
                        @endif
                        @if($policy->effective_date ?? false)
                            <span class="badge badge-success p-2">
                                <i class="fas fa-calendar-alt me-1"></i> 
                                Effective: {{ \Carbon\Carbon::parse($policy->effective_date)->format('F d, Y') }}
                            </span>
                        @endif
                    </div>
                    @endif --}}
                    
                    @if($policy->updated_at ?? false)
                    <p class="text-muted">
                        <i class="fas fa-clock me-1"></i> 
                        Last Updated: {{ $policy->updated_at->format('F d, Y') }}
                    </p>
                    @endif
                </div>

                <!-- Table of Contents (Only if sections exist) -->
                @if(isset($policy->sections) && $policy->sections && $policy->sections->isNotEmpty())
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>Table of Contents
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($policy->sections as $section)
                                    <div class="col-md-6 mb-2">
                                        <a href="#section-{{ $loop->index }}" class="text-decoration-none">
                                            <i class="fas fa-chevron-right text-primary me-2"></i>
                                            @if($section->section_number ?? false)
                                                <strong>{{ $section->section_number }}.</strong>
                                            @endif
                                            {{ $section->section_title ?? '' }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Policy Content -->
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4 p-lg-5">
                        @if(isset($policy->sections) && $policy->sections && $policy->sections->isNotEmpty())
                            @foreach($policy->sections as $index => $section)
                                <div class="mb-5 pb-4 border-bottom" id="section-{{ $index }}">
                                    <div class="d-flex align-items-start mb-3">
                                        @if($section->section_number ?? false)
                                            <span class="badge badge-primary badge-pill p-2 me-3" 
                                                  style="font-size: 1.1rem;">
                                                {{ $section->section_number }}
                                            </span>
                                        @endif
                                        <h2 class="h3 mb-0" style="color: #2c3e50;">
                                            {{ $section->section_title ?? '' }}
                                        </h2>
                                    </div>
                                    <div class="ps-5">
                                        <div class="policy-content" style="font-size: 1.05rem; line-height: 1.8;">
                                            {!! nl2br(e($section->section_content ?? '')) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @elseif($policy->content ?? false)
                            <div class="policy-content" style="font-size: 1.05rem; line-height: 1.8;">
                                {!! nl2br(e($policy->content)) !!}
                            </div>
                        @else
                            <div class="alert alert-info">
                                <p>No content available for this privacy policy.</p>
                            </div>
                        @endif

                        <!-- Contact Information -->
                        <div class="mt-5 pt-4 border-top">
                            <div class="alert alert-light" role="alert">
                                <h5 class="alert-heading">
                                    <i class="fas fa-question-circle me-2"></i>Questions?
                                </h5>
                                <p class="mb-0">
                                    If you have any questions about this Privacy Policy, please contact us at:
                                    <a href="mailto:techfocusltd@gmail.com" class="text-primary">techfocusltd@gmail.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Last Updated -->
                <div class="text-center mt-4">
                    <p class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        @if($policy->updated_at ?? false)
                            This policy was last updated on {{ $policy->updated_at->format('F d, Y') }} at {{ $policy->updated_at->format('h:i A') }}
                        @else
                            Privacy Policy Information
                        @endif
                    </p>
                </div>
            @else
                <!-- No policy available -->
                <div class="text-center py-5">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle fa-3x mb-3"></i>
                        <h3>Privacy Policy</h3>
                        <p class="mb-4">We are committed to protecting your privacy and ensuring the security of your personal information.</p>
                        
                        <div class="text-start mt-4">
                            <p>At Techfocus, we value your privacy and are committed to protecting your personal information. This Privacy Policy outlines how we collect, use, and safeguard your data when you use our services.</p>
                            
                            <div class="alert alert-light mt-4">
                                <p class="mb-0">
                                    <strong>Contact Us:</strong> If you have questions about privacy, email us at 
                                    <a href="mailto:privacy@techfocus.com">techfocusltd@gmail.com</a>
                                </p>
                            </div>
                        </div>
                        
                        @auth
                            @if(auth()->user()->is_admin)
                                <div class="mt-4">
                                    <a href="{{ route('admin.privacy-policy.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Create Detailed Privacy Policy
                                    </a>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<a href="#" class="btn btn-primary btn-lg back-to-top shadow" 
   style="position: fixed; bottom: 20px; right: 20px; display: none;" 
   id="back-to-top">
    <i class="fas fa-arrow-up"></i>
</a>
@endsection