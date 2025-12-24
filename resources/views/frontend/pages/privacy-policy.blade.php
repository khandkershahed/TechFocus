@extends('frontend.layouts.app')

@section('title', 'Privacy Policy | NGen IT')

@section('content')
<!-- Page Banner Header - Always shown -->
<section class="page-banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="banner-content text-center">
                    <h1>Privacy Policy</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Privacy Policy Content -->
<section class="privacy-policy-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                @if($policy)
                    <div class="privacy-policy-header text-center mb-5">
                        <h1 class="mb-3">{{ $policy->title }}</h1>

                        @if($policy->version || $policy->effective_date)
                        <div class="policy-meta d-flex justify-content-center align-items-center gap-4 flex-wrap mb-4">
                            @if($policy->version)
                                <span class="badge bg-primary">
                                    <i class="fas fa-code-branch me-2"></i>Version: {{ $policy->version }}
                                </span>
                            @endif
                            {{-- @if($policy->effective_date)
                                <span class="badge bg-success">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Effective: {{ \Carbon\Carbon::parse($policy->effective_date)->format('F d, Y') }}
                                </span>
                            @endif --}}
                        </div>
                        @endif

                        <p class="text-muted">
                            <i class="fas fa-clock me-2"></i>
                            Last Updated: {{ $policy->updated_at->format('F d, Y') }}
                        </p>
                    </div>

                    <!-- Table of Contents -->
                    @if($policy->sections && $policy->sections->isNotEmpty())
                    <div class="card toc-card mb-5">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>Table of Contents
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($policy->sections as $index => $section)
                                <div class="col-md-6 mb-3">
                                    <a href="#section-{{ $index }}" class="toc-link d-flex align-items-center">
                                        <i class="fas fa-chevron-right text-primary me-3"></i>
                                        <div>
                                            @if($section->section_number)
                                                <span class="text-muted small d-block">Section {{ $section->section_number }}</span>
                                            @endif
                                            <strong>{{ $section->section_title }}</strong>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Policy Content -->
                    <div class="privacy-policy-content">
                        @if($policy->sections && $policy->sections->isNotEmpty())
                            @foreach($policy->sections as $index => $section)
                            <div class="policy-section mb-5" id="section-{{ $index }}">
                                <div class="section-header mb-4">
                                    @if($section->section_number)
                                        <span class="section-number badge bg-primary rounded-pill me-3">
                                            {{ $section->section_number }}
                                        </span>
                                    @endif
                                    <h2 class="section-title">{{ $section->section_title }}</h2>
                                </div>
                                <div class="section-content">
                                    {!! nl2br(e($section->section_content)) !!}
                                </div>
                            </div>
                            @endforeach
                        @else
                            <!-- If no sections, show main content -->
                            <div class="policy-content">
                                {!! nl2br(e($policy->content)) !!}
                            </div>
                        @endif
                    </div>

                    <!-- Contact Info -->
                    <div class="contact-info mt-5 pt-4 border-top">
                        <div class="alert alert-light" role="alert">
                            <h5 class="alert-heading d-flex align-items-center">
                                <i class="fas fa-question-circle me-3 text-primary"></i>
                                Questions About Our Privacy Policy?
                            </h5>
                            <p class="mb-2">If you have any questions or concerns regarding our privacy practices, please don't hesitate to contact us.</p>
                            <p class="mb-0">
                                <strong>Email:</strong> 
                                <a href="mailto:privacy@ngenit.com" class="text-primary">privacy@ngenit.com</a>
                            </p>
                        </div>
                    </div>
                @else
                    <!-- No policy available -->
                    <div class="text-center py-5">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <h3>Privacy Policy Under Review</h3>
                            <p>Our privacy policy is currently being updated. Please check back soon.</p>
                            <a href="{{ route('admin.privacy-policy.create') }}" class="btn btn-primary mt-3">
                                Create Privacy Policy (Admin)
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Back to Top Button -->
<a href="#" class="btn btn-primary back-to-top" id="backToTop">
    <i class="fas fa-arrow-up"></i>
</a>
@endsection

@push('styles')
<style>
.page-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 80px 0 40px;
    margin-bottom: 40px;
}

.page-banner h1 {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: white;
}

.page-banner .breadcrumb {
    background: transparent;
    justify-content: center;
    margin-bottom: 0;
}

.page-banner .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
}

.page-banner .breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.7);
}

.page-banner .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.5);
}

.privacy-policy-section {
    background: #f8f9fa;
    min-height: 70vh;
}

.toc-card {
    border-left: 4px solid #007bff;
    border-radius: 8px;
    overflow: hidden;
}

.toc-link {
    text-decoration: none;
    color: #333;
    padding: 10px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.toc-link:hover {
    background: #f8f9fa;
    color: #007bff;
    transform: translateX(5px);
}

.policy-section {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.section-header {
    display: flex;
    align-items: center;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.section-number {
    font-size: 1.2rem;
    padding: 8px 15px;
}

.section-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 0;
}

.section-content {
    font-size: 1.05rem;
    line-height: 1.8;
    color: #444;
    padding-top: 20px;
}

.section-content p {
    margin-bottom: 1rem;
}

.section-content ul, 
.section-content ol {
    padding-left: 2rem;
    margin-bottom: 1.5rem;
}

.section-content li {
    margin-bottom: 0.5rem;
}

.back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
}

.alert-light {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 10px;
}

@media (max-width: 768px) {
    .page-banner {
        padding: 60px 0 30px;
    }
    
    .page-banner h1 {
        font-size: 2.2rem;
    }
    
    .policy-section {
        padding: 20px;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .section-number {
        margin-bottom: 10px;
    }
    
    .toc-link {
        font-size: 0.9rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Back to Top functionality
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('backToTop');
    if (window.pageYOffset > 300) {
        backToTop.style.display = 'flex';
    } else {
        backToTop.style.display = 'none';
    }
});

document.getElementById('backToTop').addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Smooth scroll for table of contents
document.querySelectorAll('.toc-link').forEach(link => {
    link.addEventListener('click', function(e) {
        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        
        if (targetElement) {
            e.preventDefault();
            window.scrollTo({
                top: targetElement.offsetTop - 100,
                behavior: 'smooth'
            });
            
            // Add active class
            document.querySelectorAll('.toc-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        }
    });
});

// Add active class based on scroll position
window.addEventListener('scroll', function() {
    const sections = document.querySelectorAll('.policy-section');
    const links = document.querySelectorAll('.toc-link');
    
    let current = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        
        if (scrollY >= (sectionTop - 150)) {
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
</script>
@endpush