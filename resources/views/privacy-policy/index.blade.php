@extends('frontend.master')

@section('title', (isset($policy->title) ? $policy->title . ' | Techfocus' : 'Privacy Policy | Techfocus'))

@section('content')

<!-- Page Banner -->
<div class="policy-banner mb-5">
    @if(isset($banners) && $banners->count() > 0)
        @foreach($banners as $banner)
            <a href="{{ $banner->banner_link ?? '#' }}" class="d-block banner-link">
                <img 
                    src="{{ asset('uploads/page_banners/' . $banner->image) }}" 
                    alt="{{ $banner->title ?? 'Privacy Policy Banner' }}"
                    class="img-fluid w-100"
                    style="max-height:525px; object-fit:cover;"
                >
            </a>
        @endforeach
    @else
        <!-- Default banner -->
        <img 
            src="{{ asset('img/TechFocusTermsandConditionsPageBanner(1920x525).webp') }}" 
            alt="TechFocus Privacy Policy Banner"
            class="img-fluid w-100"
            style="max-height:525px; object-fit:cover;"
        >
    @endif
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            @if(isset($policy) && $policy)
                <!-- Policy Header -->
                <div class="text-center mb-5">
                    <h1 class="display-4 text-primary mb-3">{{ $policy->title ?? 'Privacy Policy' }}</h1>
                    
                    @if($policy->updated_at ?? false)
                    <p class="text-muted">
                        <i class="fas fa-clock me-1"></i> 
                        Last Updated: {{ $policy->updated_at->format('F d, Y') }}
                    </p>
                    @endif
                </div>

                <!-- Table of Contents (Only if sections exist) -->
                @if(isset($policy->sections) && $policy->sections->isNotEmpty())
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
                                        <div class="section-content" style="font-size: 1.05rem; line-height: 1.8;">
                                            {!! $section->section_content ?? '' !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @elseif($policy->content ?? false)
                            <div class="policy-content" style="font-size: 1.05rem; line-height: 1.8;">
                                {!! $policy->content !!}
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

@push('styles')
<style>
/* Custom CSS for better HTML content display */

/* General content styling */
.policy-content,
.section-content {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
    line-height: 1.8;
}

/* Style paragraphs */
.policy-content p,
.section-content p {
    margin-bottom: 1.2rem;
    text-align: justify;
}

/* Hide empty paragraphs */
.policy-content p:empty,
.section-content p:empty {
    display: none;
}

/* Style headings */
.policy-content h1,
.policy-content h2,
.policy-content h3,
.policy-content h4,
.policy-content h5,
.policy-content h6,
.section-content h1,
.section-content h2,
.section-content h3,
.section-content h4,
.section-content h5,
.section-content h6 {
    color: #2c3e50;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

/* Banner styling */
.policy-banner img {
    transition: opacity 0.5s ease;
}

.policy-banner img:hover {
    opacity: 0.95;
}

/* Style headings */
.policy-content h1,
.section-content h1 {
    font-size: 2rem;
    border-bottom: 2px solid #e0e0e0;
    padding-bottom: 0.5rem;
    margin-top: 2rem;
}

.policy-content h2,
.section-content h2 {
    font-size: 1.75rem;
    border-bottom: 1px solid #e0e0e0;
    padding-bottom: 0.5rem;
    margin-top: 1.75rem;
}

.policy-content h3,
.section-content h3 {
    font-size: 1.5rem;
    margin-top: 1.5rem;
}

.policy-content h4,
.section-content h4 {
    font-size: 1.25rem;
    margin-top: 1.25rem;
}

/* Style lists */
.policy-content ul,
.policy-content ol,
.section-content ul,
.section-content ol {
    padding-left: 2rem;
    margin-bottom: 1.5rem;
}

.policy-content li,
.section-content li {
    margin-bottom: 0.5rem;
    line-height: 1.6;
}

/* Style links */
.policy-content a,
.section-content a {
    color: #3498db;
    text-decoration: none;
    border-bottom: 1px dotted #3498db;
    transition: all 0.3s ease;
}

.policy-content a:hover,
.section-content a:hover {
    color: #2980b9;
    border-bottom: 1px solid #2980b9;
}

/* Style tables */
.policy-content table,
.section-content table {
    width: 100%;
    margin-bottom: 1.5rem;
    border-collapse: collapse;
    border: 1px solid #dee2e6;
}

.policy-content table th,
.policy-content table td,
.section-content table th,
.section-content table td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}

.policy-content table th,
.section-content table th {
    background-color: #f8f9fa;
    font-weight: 600;
    text-align: left;
}

/* Style blockquotes */
.policy-content blockquote,
.section-content blockquote {
    border-left: 4px solid #3498db;
    padding-left: 1.5rem;
    margin-left: 0;
    margin-right: 0;
    font-style: italic;
    color: #7f8c8d;
    background: #f8f9fa;
    padding: 1rem;
    margin: 1.5rem 0;
    border-radius: 0 4px 4px 0;
}

/* Style strong and emphasis */
.policy-content strong,
.policy-content b,
.section-content strong,
.section-content b {
    font-weight: 700;
    color: #2c3e50;
}

.policy-content em,
.policy-content i,
.section-content em,
.section-content i {
    font-style: italic;
}

/* Table of Contents */
.card a.text-decoration-none {
    color: #495057;
    transition: all 0.3s ease;
    padding: 8px 12px;
    border-radius: 6px;
    display: inline-block;
    width: 100%;
}

.card a.text-decoration-none:hover {
    color: #007bff;
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.card a.text-decoration-none.active {
    color: #007bff;
    background-color: #e3f2fd;
    border-left: 3px solid #007bff;
    padding-left: 15px;
}

/* Back to top button */
.back-to-top {
    transition: all 0.3s ease;
}

.back-to-top:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3) !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .policy-content h1,
    .section-content h1 {
        font-size: 1.8rem;
    }
    
    .policy-content h2,
    .section-content h2 {
        font-size: 1.5rem;
    }
    
    .policy-content h3,
    .section-content h3 {
        font-size: 1.3rem;
    }
    
    .policy-content,
    .section-content {
        font-size: 1rem;
        line-height: 1.6;
    }
    
    .ps-5 {
        padding-left: 1rem !important;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
    
    .policy-banner img {
        max-height: 300px !important;
    }
}

/* Print Styles */
@media print {
    .policy-banner,
    .card.mb-4.shadow-sm,
    .back-to-top,
    .alert-light {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
    
    .policy-content a,
    .section-content a {
        color: #000 !important;
        text-decoration: underline !important;
        border: none !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Back to Top functionality
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('back-to-top');
    if (window.pageYOffset > 300) {
        backToTop.style.display = 'block';
    } else {
        backToTop.style.display = 'none';
    }
});

document.getElementById('back-to-top').addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Smooth scroll for table of contents
document.querySelectorAll('.card a.text-decoration-none').forEach(link => {
    link.addEventListener('click', function(e) {
        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        
        if (targetElement) {
            e.preventDefault();
            window.scrollTo({
                top: targetElement.offsetTop - 80,
                behavior: 'smooth'
            });
            
            // Add active class
            document.querySelectorAll('.card a.text-decoration-none').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        }
    });
});

// Add active class based on scroll position
window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('.mb-5.pb-4.border-bottom');
    const links = document.querySelectorAll('.card a.text-decoration-none');
    
    let current = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        
        if (scrollY >= (sectionTop - 100)) {
            current = section.getAttribute('id');
        }
    });
    
    links.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + current) {
            link.classList.add('active');
        }
    });
});

// Clean up any empty paragraphs from HTML content on page load
document.addEventListener('DOMContentLoaded', function() {
    function cleanEmptyParagraphs() {
        const contentElements = document.querySelectorAll('.policy-content, .section-content');
        
        contentElements.forEach(element => {
            const paragraphs = element.querySelectorAll('p');
            paragraphs.forEach(p => {
                // Check if paragraph is effectively empty
                const text = p.textContent.trim();
                const html = p.innerHTML.trim();
                
                // Remove if empty or contains only &nbsp; or <br>
                if (text === '' || text === '\u00A0' || html === '&nbsp;' || html === '<br>') {
                    p.style.display = 'none';
                }
                
                // Remove &nbsp; entities
                p.innerHTML = p.innerHTML.replace(/&nbsp;/g, ' ');
            });
        });
    }
    
    // Clean on load
    cleanEmptyParagraphs();
    
    // Also clean after a short delay
    setTimeout(cleanEmptyParagraphs, 500);
});
</script>
@endpush