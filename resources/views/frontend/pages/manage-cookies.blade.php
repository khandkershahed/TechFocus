@extends('frontend.master') {{-- or your frontend layout --}}

@section('title', 'Manage Cookies - ' . config('app.name'))

@section('content')
<!-- Page Header -->
<section class="page-header bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="h2 fw-bold text-primary">Cookie Preferences</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Cookies</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

{{-- <!-- Cookie Management Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Info Alert -->
                <div class="alert alert-info border-0 shadow-sm">
                    <div class="d-flex">
                        <i class="fas fa-info-circle fa-2x text-info me-3 mt-1"></i>
                        <div>
                            <h5 class="alert-heading mb-2">Cookie Settings</h5>
                            <p class="mb-0">You can manage your cookie preferences for this website below. Essential cookies cannot be disabled as they are necessary for the website to function properly.</p>
                        </div>
                    </div>
                </div>

                <!-- Cookie Preferences Form -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-sliders-h me-2"></i>Cookie Preferences</h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="cookiePreferencesForm">
                            @csrf
                            
                            <!-- Essential Cookies -->
                            <div class="cookie-category mb-4 p-3 border rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-shield-alt text-success me-2"></i>
                                    <h5 class="mb-0 text-success">Essential Cookies</h5>
                                </div>
                                <p class="text-muted mb-3">These cookies are necessary for the website to function and cannot be switched off. They are usually only set in response to actions made by you.</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked disabled>
                                    <label class="form-check-label fw-semibold">
                                        Required Cookies
                                        <span class="badge bg-success ms-2">Always Active</span>
                                    </label>
                                    <small class="d-block text-muted mt-1">Session management, security, and basic functionality</small>
                                </div>
                            </div>

                            <!-- Analytics Cookies -->
                            <div class="cookie-category mb-4 p-3 border rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-chart-bar text-primary me-2"></i>
                                    <h5 class="mb-0 text-primary">Analytics Cookies</h5>
                                </div>
                                <p class="text-muted mb-3">These cookies allow us to count visits and traffic sources so we can measure and improve the performance of our site.</p>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="analyticsCookies" name="analytics" checked>
                                    <label class="form-check-label fw-semibold" for="analyticsCookies">
                                        Enable Analytics Cookies
                                    </label>
                                </div>
                            </div>

                            <!-- Marketing Cookies -->
                            <div class="cookie-category mb-4 p-3 border rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-bullhorn text-warning me-2"></i>
                                    <h5 class="mb-0 text-warning">Marketing Cookies</h5>
                                </div>
                                <p class="text-muted mb-3">These cookies may be set through our site by our advertising partners to build a profile of your interests.</p>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="marketingCookies" name="marketing">
                                    <label class="form-check-label fw-semibold" for="marketingCookies">
                                        Enable Marketing Cookies
                                    </label>
                                </div>
                            </div>

                            <!-- Preferences Cookies -->
                            <div class="cookie-category mb-4 p-3 border rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-cog text-info me-2"></i>
                                    <h5 class="mb-0 text-info">Preferences Cookies</h5>
                                </div>
                                <p class="text-muted mb-3">These cookies enable the website to provide enhanced functionality and personalization based on your preferences.</p>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="preferenceCookies" name="preferences" checked>
                                    <label class="form-check-label fw-semibold" for="preferenceCookies">
                                        Enable Preference Cookies
                                    </label>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Save Preferences
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="resetCookies">
                                    <i class="fas fa-undo me-2"></i>Reset to Default
                                </button>
                                <div class="d-flex gap-2 ms-md-auto mt-3 mt-md-0">
                                    <button type="button" class="btn btn-outline-danger" id="rejectAll">
                                        <i class="fas fa-times me-2"></i>Reject All
                                    </button>
                                    <button type="button" class="btn btn-success" id="acceptAll">
                                        <i class="fas fa-check me-2"></i>Accept All
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Cookie Policy Information -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Cookie Policy Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-question-circle me-2"></i>What are cookies?
                                </h6>
                                <p class="text-muted">Cookies are small text files that are stored on your computer or mobile device when you visit our website. They help us provide you with a better experience by remembering your preferences and understanding how you use our site.</p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-cookie me-2"></i>How we use cookies?
                                </h6>
                                <ul class="text-muted">
                                    <li>To remember your preferences and settings</li>
                                    <li>To understand how visitors interact with our website</li>
                                    <li>To provide personalized content and recommendations</li>
                                    <li>To improve our website performance and services</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning border-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Note:</strong> You can change your cookie preferences at any time by revisiting this page. If you disable certain cookies, some features of our website may not function properly.
                        </div>

                        <div class="mt-4">
                            <h6 class="text-primary mb-3">Need more information?</h6>
                            <p class="text-muted mb-0">
                                If you have any questions about our cookie policy or how we handle your data, 
                                please <a href="{{ route('contact') }}" class="text-primary">contact us</a> or 
                                read our full <a href="{{ route('privacy.policy') }}" class="text-primary">Privacy Policy</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
@endsection

