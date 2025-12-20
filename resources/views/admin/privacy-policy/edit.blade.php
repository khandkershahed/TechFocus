@extends('admin.master')

@section('title', 'Edit Privacy Policy')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Privacy Policy</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.privacy-policy.update', $privacyPolicy->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Policy Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" 
                                           value="{{ old('title', $privacyPolicy->title) }}" required>
                                    @error('title')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="version">Version (Optional)</label>
                                    <input type="text" class="form-control" id="version" name="version" 
                                           value="{{ old('version', $privacyPolicy->version) }}" 
                                           placeholder="e.g., 1.0, 2.1">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="effective_date">Effective Date</label>
                                    <input type="date" class="form-control" id="effective_date" 
                                           name="effective_date" 
                                           value="{{ old('effective_date', $privacyPolicy->effective_date ? $privacyPolicy->effective_date->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch mt-4">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="is_active" name="is_active" value="1" 
                                               {{ $privacyPolicy->is_active ? 'checked' : '' }}>
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
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="10" required>{{ old('content', $privacyPolicy->content) }}</textarea>
                            @error('content')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr>
                        
                        <div class="form-group">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="mb-0">Sections</label>
                                <button type="button" class="btn btn-sm btn-success" onclick="addSection()">
                                    <i class="fas fa-plus"></i> Add Section
                                </button>
                            </div>
                            <div id="sections-container">
                                @foreach($privacyPolicy->sections as $index => $section)
                                    <div class="card mb-3 section-item" id="section-{{ $index }}">
                                        <div class="card-header bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">Section {{ $index + 1 }}</h6>
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        onclick="removeSection({{ $index }})">
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
                                                               name="sections[{{ $index }}][number]" 
                                                               value="{{ $section->section_number }}"
                                                               placeholder="e.g., 1.1, 2.3">
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label>Section Title *</label>
                                                        <input type="text" class="form-control" 
                                                               name="sections[{{ $index }}][title]" 
                                                               value="{{ $section->section_title }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Section Content *</label>
                                                <textarea class="form-control" 
                                                          name="sections[{{ $index }}][content]" 
                                                          rows="4" required>{{ $section->section_content }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <a href="{{ route('admin.privacy-policy.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Policy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let sectionCounter = {{ $privacyPolicy->sections->count() }};

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
                    <textarea class="form-control" 
                              name="sections[${sectionCounter}][content]" 
                              rows="4" required></textarea>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', sectionHtml);
}

function removeSection(id) {
    const section = document.getElementById(`section-${id}`);
    if (section) {
        section.remove();
    }
}

// Add an empty section if no sections exist
document.addEventListener('DOMContentLoaded', function() {
    @if($privacyPolicy->sections->isEmpty())
        addSection();
    @endif
});
</script>
@endpush