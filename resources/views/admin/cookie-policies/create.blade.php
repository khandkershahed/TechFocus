@extends('admin.master')

@section('title', 'Create Cookie Policy')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Create Cookie Policy</h1>
        <a href="{{ route('admin.cookie-policies.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Policy Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.cookie-policies.store') }}" method="POST" id="policyForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="title">Policy Title *</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   placeholder="Enter policy title" 
                                   required>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Policy Content *</label>
                            <!-- Hidden input to store HTML content -->
                            <input type="hidden" name="content" id="hiddenContent" value="{{ old('content') }}">
                            
                            <!-- Quill Editor Container -->
                            <div id="editor" style="height: 400px;"></div>
                            
                            @error('content')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">
                                Use the toolbar above for formatting. Minimum 10 characters.
                            </small>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">
                                            <strong>Active Status</strong>
                                        </label>
                                        <small class="form-text text-muted d-block mt-1">
                                            Active policies are visible to users.
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save mr-2"></i>Create Policy
                                </button>
                                
                                <button type="button" 
                                        onclick="previewContent()" 
                                        class="btn btn-outline-secondary btn-block mt-2">
                                    <i class="fas fa-eye mr-2"></i>Preview
                                </button>
                            </div>
                        </div>
                        
                        <div class="card mt-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Quick Tips</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-info-circle text-primary mr-2"></i>
                                        <small>Include all required cookie information</small>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-shield-alt text-success mr-2"></i>
                                        <small>Comply with GDPR regulations</small>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-cookie text-warning mr-2"></i>
                                        <small>List all cookie types used</small>
                                    </li>
                                    <li>
                                        <i class="fas fa-calendar-alt text-info mr-2"></i>
                                        <small>Update policy regularly</small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Policy Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="previewContent" class="policy-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
    .policy-content {
        line-height: 1.6;
    }
    
    .policy-content h1, .policy-content h2, .policy-content h3 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .policy-content ul, .policy-content ol {
        padding-left: 1.5rem;
        margin-bottom: 1rem;
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
    
    /* Quill Editor Custom Styles */
    #editor {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    
    .ql-toolbar {
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
        border-bottom: 1px solid #ced4da !important;
    }
    
    .ql-container {
        border-bottom-left-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
        font-family: inherit;
    }
</style>
@endpush

@push('scripts')
<!-- Quill Editor JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
// Initialize Quill Editor
const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['link', 'image'],
            ['clean']
        ]
    },
    placeholder: 'Enter detailed policy content...'
});

// Set initial content if there's old content
quill.root.innerHTML = `{!! old('content') !!}`;

// Update hidden input before form submission
document.getElementById('policyForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const content = quill.root.innerHTML.trim();
    
    // Set the content to hidden input
    document.getElementById('hiddenContent').value = content;
    
    if (!title) {
        e.preventDefault();
        alert('Please enter a policy title');
        document.getElementById('title').focus();
        return;
    }
    
    if (!content || content.replace(/<[^>]*>/g, '').trim().length < 10) {
        e.preventDefault();
        alert('Please enter policy content (minimum 10 characters)');
        return;
    }
});

function previewContent() {
    const title = document.getElementById('title').value;
    const content = quill.root.innerHTML;
    
    if (!title.trim()) {
        alert('Please enter a title first');
        return;
    }
    
    if (!content.trim() || content.replace(/<[^>]*>/g, '').trim().length < 10) {
        alert('Please enter some content first (minimum 10 characters)');
        return;
    }
    
    // Set preview content
    document.getElementById('previewContent').innerHTML = `
        <h1 class="mb-4">${title}</h1>
        <div class="text-muted mb-4">
            <small>Last Updated: ${new Date().toLocaleDateString()}</small>
        </div>
        <hr>
        ${content}
    `;
    
    // Show modal
    $('#previewModal').modal('show');
}
</script>
@endpush