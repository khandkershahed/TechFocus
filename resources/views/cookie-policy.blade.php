@extends('frontend.master')

@section('title', $policy->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $policy->title }}</li>
                </ol>
            </nav>

            <!-- Policy Header -->
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold mb-3">
                    <i class="fas fa-cookie-bite text-warning me-2"></i>
                    {{ $policy->title }}
                </h1>
                <p class="lead text-muted">
                    Last Updated: {{ $policy->updated_at->format('F d, Y') }}
                    @if($policy->version)
                        <span class="ms-2 badge bg-secondary">Version {{ $policy->version }}</span>
                    @endif
                </p>
            </div>

            <!-- Policy Content (Dynamic from Admin) -->
            <div class="card border-0 shadow-lg mb-4">
                <div class="card-body p-4 p-lg-5">
                    <div class="policy-content">
                        {!! $policy->content !!}
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="fas fa-info-circle me-1"></i>
                            Effective Date: {{ $policy->published_at ? $policy->published_at->format('F d, Y') : 'Not published yet' }}
                        </div>
                        <div>
                            <a href="{{ route('manage.cookies') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-sliders-h me-1"></i>Manage Cookie Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cookie Management Section -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-cog text-primary me-2"></i>
                                Cookie Preferences
                            </h5>
                            <p class="card-text text-muted">
                                You have control over which cookies you accept. 
                                Manage your preferences to customize your browsing experience.
                            </p>
                            <a href="{{ route('manage.cookies') }}" class="btn btn-primary">
                                <i class="fas fa-sliders-h me-2"></i>Manage Preferences
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-question-circle text-success me-2"></i>
                                Need Help?
                            </h5>
                            <p class="card-text text-muted">
                                If you have questions about our cookie policy or need assistance 
                                with your cookie settings, please contact us.
                            </p>
                            <a href="{{ route('contact') ?? '#' }}" class="btn btn-outline-success">
                                <i class="fas fa-headset me-2"></i>Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-5 text-center">
                <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                    <a href="{{ route('manage.cookies') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-cookie-bite me-2"></i>Cookie Settings
                    </a>
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-home me-2"></i>Back to Home
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-info btn-lg">
                        <i class="fas fa-print me-2"></i>Print Policy
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.policy-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.policy-content h1 {
    font-size: 2.5rem;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f1f1f1;
}

.policy-content h2 {
    font-size: 2rem;
    color: #34495e;
    margin-top: 2.5rem;
    margin-bottom: 1rem;
}

.policy-content h3 {
    font-size: 1.5rem;
    color: #7f8c8d;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.policy-content p {
    margin-bottom: 1.5rem;
    color: #555;
}

.policy-content ul, 
.policy-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.policy-content li {
    margin-bottom: 0.5rem;
    color: #555;
}

.policy-content table {
    width: 100%;
    margin-bottom: 1.5rem;
    border-collapse: collapse;
    border: 1px solid #dee2e6;
}

.policy-content table th {
    background-color: #f8f9fa;
    font-weight: 600;
    padding: 1rem;
    border: 1px solid #dee2e6;
}

.policy-content table td {
    padding: 1rem;
    border: 1px solid #dee2e6;
}

.policy-content blockquote {
    border-left: 4px solid #3498db;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #7f8c8d;
}

@media print {
    .breadcrumb, 
    .btn,
    .card-footer {
        display: none !important;
    }
    
    .policy-content {
        font-size: 12pt;
    }
}
</style>
@endpush