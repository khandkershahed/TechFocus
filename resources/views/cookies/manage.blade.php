@extends('frontend.master')

@section('title', 'Manage Cookie Preferences')

@section('content')

<!-- Dynamic Banner Section -->
<div class="container-fluid px-0">
  @if(isset($banners) && $banners->count() > 0)
    @foreach($banners as $banner)
      <div class="p-5 breadcrumb-banner-area" 
           style="background-image: url('{{ asset('uploads/page_banners/' . $banner->image) }}'); 
                  background-size: cover; 
                  background-position: center;
                  background-repeat: no-repeat;
                  min-height: 300px;"> 
            </div>
          </div>
        </div>
      </div>
    @endforeach
  @else
    <!-- Default banner if no dynamic banners -->
    <div class="p-5 breadcrumb-banner-area"
      style="background-image: url('{{ asset('/img/TechFocusTermsandConditionsPageBanner(1920x525).webp') }}');
             min-height: 300px;">
    </div>
  @endif
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="h2 mb-3">
                    <i class="fas fa-cookie-bite text-warning me-2"></i>
                    Manage Cookies
                </h1>
            </div>
            
            <!-- Policy Reference -->
            @if(isset($policy) && $policy)
            <div class="alert alert-info mb-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-lg me-3"></i>
                    <div>
                        <strong>Current Policy:</strong> {{ $policy->title }}
                        <br>
                        <small>Last Updated: {{ $policy->updated_at->format('F d, Y') }}</small>
                    </div>
                </div>
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
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                No active cookie policy found.
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.accordion-button:not(.collapsed) {
    background-color: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-check-input:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Banner styling */
.breadcrumb-banner-area {
    display: flex;
    align-items: center;
    position: relative;
}



.breadcrumb-banner-area > .container {
    position: relative;
    z-index: 1;
}

.banner-content {
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush

@push('scripts')
<script>
// Update switch labels on change
document.querySelectorAll('.form-check-input').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const label = this.nextElementSibling;
        label.textContent = this.checked ? 'Enabled' : 'Disabled';
    });
});

// Accept all cookies
function acceptAll() {
    document.getElementById('analytics').checked = true;
    document.getElementById('marketing').checked = true;
    
    // Update labels
    document.querySelectorAll('.form-check-input').forEach(checkbox => {
        const label = checkbox.nextElementSibling;
        label.textContent = checkbox.checked ? 'Enabled' : 'Disabled';
    });
    
    // Submit form
    document.getElementById('cookieForm').submit();
}

// Reject all optional cookies
function rejectAll() {
    document.getElementById('analytics').checked = false;
    document.getElementById('marketing').checked = false;
    
    // Update labels
    document.querySelectorAll('.form-check-input').forEach(checkbox => {
        const label = checkbox.nextElementSibling;
        label.textContent = checkbox.checked ? 'Enabled' : 'Disabled';
    });
    
    // Submit form
    document.getElementById('cookieForm').submit();
}
</script>
@endpush