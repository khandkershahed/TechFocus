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
                                Tip: Press "Enter" for new paragraph. Press "Shift+Enter" for line break.
                            </small>
                        </div>

                        <hr>
                        
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="mb-0">Sections (Optional)</label>
                                <button type="button" class="btn btn-sm btn-success" onclick="addSection()">
                                    <i class="fas fa-plus"></i> Add Section
                                </button>
                            </div>
                            <div id="sections-container">
                                <!-- Sections will be added here dynamically -->
                            </div>
                        </div>

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
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
    }
    .ck.ck-editor {
        margin-bottom: 10px;
    }
    .ck-editor__editable p {
        margin-bottom: 1rem;
    }
    .ck-editor__editable h2 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    .ck-editor__editable h3, .ck-editor__editable h4 {
        margin-top: 1.25rem;
        margin-bottom: 0.75rem;
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

// Function to clean HTML content
function cleanHTMLContent(html) {
    // Remove empty paragraphs with &nbsp;
    html = html.replace(/<p>\s*&nbsp;\s*<\/p>/gi, '');
    // Remove completely empty paragraphs
    html = html.replace(/<p>\s*<\/p>/gi, '');
    // Remove multiple line breaks
    html = html.replace(/\n{3,}/g, '\n\n');
    // Remove trailing/leading spaces in paragraphs
    html = html.replace(/<p>\s*/g, '<p>');
    html = html.replace(/\s*<\/p>/g, '</p>');
    // Replace multiple spaces with single space
    html = html.replace(/\s{2,}/g, ' ');
    
    return html.trim();
}

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
                'undo', 'redo', 'removeFormat'
            ]
        },
        language: 'en',
        licenseKey: '',
        // Prevent empty paragraphs
        fillEmptyBlocks: false,
        // Better paragraph handling
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
            ]
        },
        // Configure paragraph element
        htmlSupport: {
            allow: [
                {
                    name: /^.*$/,
                    styles: true,
                    attributes: true,
                    classes: true
                }
            ]
        },
        // Clean up content
        removePlugins: ['Markdown'],
        // Configure editor behavior
        editorConfig: {
            enterMode: ClassicEditor.ENTER_P,
            shiftEnterMode: ClassicEditor.ENTER_BR
        }
    })
    .then(editor => {
        mainEditor = editor;
        
        // Clean content before syncing
        editor.model.document.on('change:data', () => {
            let content = editor.getData();
            // Clean the HTML content
            content = cleanHTMLContent(content);
            // Update the hidden textarea
            document.querySelector('#content').value = content;
        });
        
        // Set initial content if exists
        const initialContent = document.querySelector('#content').value;
        if (initialContent) {
            // Clean initial content before setting
            const cleanedContent = cleanHTMLContent(initialContent);
            editor.setData(cleanedContent);
            // Update textarea with cleaned content
            document.querySelector('#content').value = cleanedContent;
        }
        
        // Listen for paste event to clean pasted content
        editor.editing.view.document.on('clipboardInput', (evt, data) => {
            setTimeout(() => {
                let content = editor.getData();
                content = cleanHTMLContent(content);
                editor.setData(content);
                document.querySelector('#content').value = content;
            }, 100);
        });
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
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'bulletedList', 'numberedList', '|',
                        'link', 'blockQuote', '|',
                        'undo', 'redo'
                    ]
                },
                language: 'en',
                licenseKey: '',
                fillEmptyBlocks: false,
                htmlSupport: {
                    allow: [
                        {
                            name: /^.*$/,
                            styles: true,
                            attributes: true,
                            classes: true
                        }
                    ]
                },
                editorConfig: {
                    enterMode: ClassicEditor.ENTER_P,
                    shiftEnterMode: ClassicEditor.ENTER_BR
                }
            })
            .then(editor => {
                sectionEditors[sectionCounter] = editor;
                
                // Sync editor content with textarea
                editor.model.document.on('change:data', () => {
                    let content = editor.getData();
                    content = cleanHTMLContent(content);
                    document.querySelector(`#section-content-${sectionCounter}`).value = content;
                });
                
                // Listen for paste event
                editor.editing.view.document.on('clipboardInput', (evt, data) => {
                    setTimeout(() => {
                        let content = editor.getData();
                        content = cleanHTMLContent(content);
                        editor.setData(content);
                        document.querySelector(`#section-content-${sectionCounter}`).value = content;
                    }, 100);
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
    // Ensure main editor content is synced and cleaned
    if (mainEditor) {
        let content = mainEditor.getData();
        content = cleanHTMLContent(content);
        document.querySelector('#content').value = content;
    }
    
    // Ensure all section editors are synced
    for (const id in sectionEditors) {
        if (sectionEditors[id]) {
            let content = sectionEditors[id].getData();
            content = cleanHTMLContent(content);
            document.querySelector(`#section-content-${id}`).value = content;
        }
    }
    
    // Optional: Validate that content is not empty
    const contentField = document.querySelector('#content');
    const cleanText = contentField.value.replace(/<[^>]*>/g, '').trim();
    if (cleanText.length === 0) {
        e.preventDefault();
        alert('Policy content cannot be empty. Please enter some content.');
        return false;
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