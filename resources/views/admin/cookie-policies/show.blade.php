@extends('admin.master')

@section('title', 'View Cookie Policy')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">View Cookie Policy</h1>
        <div>
            <a href="{{ route('admin.cookie-policies.edit', $cookiePolicy) }}" class="btn btn-warning">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.cookie-policies.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Policy Content</h6>
                    <span class="badge badge-{{ $cookiePolicy->is_active ? 'success' : 'secondary' }}">
                        {{ $cookiePolicy->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="card-body">
                    <h1 class="mb-4">{{ $cookiePolicy->title }}</h1>
                    
                    <div class="policy-content">
                        {!! $cookiePolicy->content !!}
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <small>Last updated: {{ $cookiePolicy->updated_at->format('F d, Y \a\t h:i A') }}</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Policy Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Status</h6>
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                @if($cookiePolicy->is_active)
                                    <i class="fas fa-circle text-success fa-2x"></i>
                                @else
                                    <i class="fas fa-circle text-secondary fa-2x"></i>
                                @endif
                            </div>
                            <div>
                                <p class="mb-0">{{ $cookiePolicy->is_active ? 'Active and visible to users' : 'Inactive and hidden from users' }}</p>
                                @if($cookiePolicy->published_at)
                                    <small class="text-muted">
                                        Published {{ $cookiePolicy->published_at->diffForHumans() }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Timeline</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-calendar-plus text-primary mr-2"></i>
                                Created: {{ $cookiePolicy->created_at->format('M d, Y') }}
                                @if($cookiePolicy->creator)
                                    <br>
                                    <small class="text-muted ml-4">
                                        By: {{ $cookiePolicy->creator->name }}
                                    </small>
                                @endif
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-history text-info mr-2"></i>
                                Last Updated: {{ $cookiePolicy->updated_at->format('M d, Y') }}
                                @if($cookiePolicy->updater)
                                    <br>
                                    <small class="text-muted ml-4">
                                        By: {{ $cookiePolicy->updater->name }}
                                    </small>
                                @endif
                            </li>
                            @if($cookiePolicy->published_at)
                                <li>
                                    <i class="fas fa-rocket text-success mr-2"></i>
                                    Published: {{ $cookiePolicy->published_at->format('M d, Y') }}
                                </li>
                            @endif
                        </ul>
                    </div>
                    
                    <hr>
                    
                    <div>
                        <h6 class="font-weight-bold">Actions</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.cookie-policies.preview', $cookiePolicy) }}" 
                               target="_blank" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-external-link-alt mr-2"></i>View as User
                            </a>
                            
                            <a href="{{ route('admin.cookie-policies.edit', $cookiePolicy) }}" 
                               class="btn btn-outline-warning">
                                <i class="fas fa-edit mr-2"></i>Edit Policy
                            </a>
                            
                            <button type="button" 
                                    class="btn btn-outline-danger delete-policy"
                                    data-id="{{ $cookiePolicy->id }}"
                                    data-title="{{ $cookiePolicy->title }}">
                                <i class="fas fa-trash mr-2"></i>Delete Policy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Stats</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <div class="text-muted mb-1">Content Length</div>
                            <div class="h4">{{ strlen(strip_tags($cookiePolicy->content)) }} characters</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted mb-1">Word Count</div>
                            <div class="h4">{{ str_word_count(strip_tags($cookiePolicy->content)) }} words</div>
                        </div>
                        <div>
                            <div class="text-muted mb-1">Age</div>
                            <div class="h4">{{ $cookiePolicy->created_at->diffInDays() }} days</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
@include('admin.cookie-policies.delete-modal')
@endsection

@push('styles')
<style>
.policy-content {
    line-height: 1.8;
    font-size: 16px;
}

.policy-content h1 {
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
}

.policy-content h2 {
    font-size: 2rem;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.policy-content h3 {
    font-size: 1.5rem;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.policy-content p {
    margin-bottom: 1rem;
}

.policy-content ul, .policy-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}

.policy-content table {
    width: 100%;
    margin-bottom: 1rem;
    border-collapse: collapse;
}

.policy-content table th,
.policy-content table td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}

.policy-content table th {
    background-color: #f8f9fa;
    font-weight: bold;
}
</style>
@endpush

@push('scripts')
<script>
// Delete policy confirmation
$('.delete-policy').click(function() {
    const policyId = $(this).data('id');
    const policyTitle = $(this).data('title');
    
    if (confirm(`Are you sure you want to delete "${policyTitle}"? This action cannot be undone.`)) {
        $('#deleteForm').attr('action', `/admin/cookie-policies/${policyId}`);
        $('#deleteForm').submit();
    }
});
</script>
@endpush