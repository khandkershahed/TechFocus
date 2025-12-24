@extends('admin.master')

@section('title', 'Create Privacy Policy')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Privacy Policy</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.privacy-policy.store') }}" method="POST" id="privacyPolicyForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Policy Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="version">Version (Optional)</label>
                                    <input type="text" class="form-control" id="version" name="version" 
                                           value="{{ old('version') }}" placeholder="e.g., 1.0, 2.1">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="effective_date">Effective Date</label>
                                    <input type="date" class="form-control" id="effective_date" 
                                           name="effective_date" value="{{ old('effective_date') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch mt-4">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="is_active" name="is_active" value="1" checked>
                                        <label class="custom-control-label" for="is_active">
                                            Set as Active Policy
                                        </label>
                                        <small class="form-text text-muted d-block">
                                            If checked, this will deactivate all other policies
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="content">Main Content *</label>
                            <div id="content-editor"></div>
                            <textarea class="form-control d-none @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                            @error('content')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                This is the main content of your privacy policy. You can also add structured sections below.
                            </small>
                        </div>

                        <hr>
                        
                        {{-- <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="mb-0">Sections (Optional)</label>
                                <button type="button" class="btn btn-sm btn-success" onclick="addSection()">
                                    <i class="fas fa-plus"></i> Add Section
                                </button>
                            </div>
                            <div id="sections-container">
                                <!-- Sections will be added here dynamically -->
                            </div>
                        </div> --}}

                        <div class="form-group text-center">
                            <a href="{{ route('admin.privacy-policy.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Policy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- CKEditor 5 Styles -->
<style>
    .ck-editor__editable {
        min-height: 400px;
        border: 1px solid #e3e6f0 !important;
        border-radius: 0.35rem;
    }
    .ck.ck-editor {
        margin-bottom: 10px;
    }
    .section-editor .ck-editor__editable {
        min-height: 200px;
    }
</style>
@endpush

@push('scripts')
<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>

<script>
let sectionCounter = 0;
let mainEditor = null;
const sectionEditors = {};

// Initialize main CKEditor
ClassicEditor
    .create(document.querySelector('#content-editor'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'link', 'bulletedList', 'numberedList', '|',
                'alignment', 'outdent', 'indent', '|',
                'blockQuote', 'insertTable', '|',
                'undo', 'redo'
            ]
        },
        language: 'en',
        licenseKey: '',
    })
    .then(editor => {
        mainEditor = editor;
        
        // Sync editor content with textarea
        editor.model.document.on('change:data', () => {
            document.querySelector('#content').value = editor.getData();
        });
        
        // Set initial content if exists
        const initialContent = document.querySelector('#content').value;
        if (initialContent) {
            editor.setData(initialContent);
        }
    })
    .catch(error => {
        console.error('Failed to initialize main editor:', error);
        // Fallback to textarea if editor fails
        document.querySelector('#content').classList.remove('d-none');
        document.querySelector('#content-editor').style.display = 'none';
    });

function addSection() {
    sectionCounter++;
    const container = document.getElementById('sections-container');
    
    const sectionHtml = `
        <div class="card mb-3 section-item" id="section-${sectionCounter}">
            <div class="card-header bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Section ${sectionCounter}</h6>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeSection(${sectionCounter})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Section Number</label>
                            <input type="text" class="form-control" 
                                   name="sections[${sectionCounter}][number]" 
                                   placeholder="e.g., 1.1, 2.3">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label>Section Title *</label>
                            <input type="text" class="form-control" 
                                   name="sections[${sectionCounter}][title]" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Section Content *</label>
                    <div id="section-editor-${sectionCounter}" class="section-editor"></div>
                    <textarea class="form-control d-none section-content-hidden" 
                              id="section-content-${sectionCounter}"
                              name="sections[${sectionCounter}][content]" 
                              rows="4" required></textarea>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', sectionHtml);
    
    // Initialize CKEditor for the new section
    setTimeout(() => {
        ClassicEditor
            .create(document.querySelector(`#section-editor-${sectionCounter}`), {
                toolbar: {
                    items: [
                        'bold', 'italic', 'underline', '|',
                        'bulletedList', 'numberedList', '|',
                        'link', 'blockQuote', '|',
                        'undo', 'redo'
                    ]
                },
                language: 'en',
                licenseKey: '',
            })
            .then(editor => {
                sectionEditors[sectionCounter] = editor;
                
                // Sync editor content with textarea
                editor.model.document.on('change:data', () => {
                    document.querySelector(`#section-content-${sectionCounter}`).value = editor.getData();
                });
            })
            .catch(error => {
                console.error(`Failed to initialize section editor ${sectionCounter}:`, error);
                // Fallback to textarea
                document.querySelector(`#section-editor-${sectionCounter}`).style.display = 'none';
                document.querySelector(`#section-content-${sectionCounter}`).classList.remove('d-none');
            });
    }, 100);
}

function removeSection(id) {
    const section = document.getElementById(`section-${id}`);
    if (section) {
        // Destroy CKEditor instance
        if (sectionEditors[id]) {
            sectionEditors[id].destroy()
                .then(() => {
                    delete sectionEditors[id];
                })
                .catch(error => {
                    console.error('Error destroying editor:', error);
                });
        }
        section.remove();
    }
}

// Sync all editors before form submission
document.getElementById('privacyPolicyForm').addEventListener('submit', function(e) {
    // Ensure main editor content is synced
    if (mainEditor) {
        document.querySelector('#content').value = mainEditor.getData();
    }
    
    // Ensure all section editors are synced
    for (const id in sectionEditors) {
        if (sectionEditors[id]) {
            document.querySelector(`#section-content-${id}`).value = sectionEditors[id].getData();
        }
    }
});

// Add one empty section by default when page loads
document.addEventListener('DOMContentLoaded', function() {
    addSection();
});
</script>

@if($errors->has('sections.*'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    alert('Please fill all required fields in sections.');
});
</script>
@endif
@endpush