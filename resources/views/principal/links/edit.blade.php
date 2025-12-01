@extends('principal.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card shadow">
                <div class="card-header bg-warning text-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-edit fs-4 me-3"></i>
                        <div>
                            <h4 class="mb-0">Edit Links</h4>
                            <small class="opacity-75">Update existing links and files</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Validation Errors</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('principal.links.update', $link->id) }}" method="POST" enctype="multipart/form-data" id="editLinksForm">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="alert alert-info d-flex align-items-center">
                                    <i class="fas fa-info-circle fs-4 me-3"></i>
                                    <div>
                                        <strong>Editing {{ count($link->label) }} link(s):</strong> Update labels, URLs, types, or add/remove files.
                                        <span class="d-block mt-1">Required fields are marked with *</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="links-container">
                            @foreach($link->label as $index => $label)
                            <div class="card mb-3 link-row" data-index="{{ $index }}">
                                <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                    <span class="fw-medium">Link #{{ $index + 1 }}</span>
                                    @if($index === 0)
                                        <button type="button" onclick="addLinkRow()" class="btn btn-success btn-sm">
                                            <i class="fas fa-plus me-1"></i> Add More
                                        </button>
                                    @else
                                        <button type="button" onclick="removeLinkRow(this)" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash me-1"></i> Remove
                                        </button>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Label <span class="text-danger">*</span></label>
                                            <input type="text" name="links[{{ $index }}][label]" 
                                                   value="{{ old('links.'.$index.'.label', $label) }}" 
                                                   class="form-control" placeholder="Link label" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">URL <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-link"></i></span>
                                                <input type="url" name="links[{{ $index }}][url]" 
                                                       value="{{ old('links.'.$index.'.url', $link->url[$index] ?? '') }}" 
                                                       class="form-control" placeholder="https://example.com" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Type</label>
                                            <select name="links[{{ $index }}][type]" class="form-select">
                                                <option value="">Select Type</option>
                                                @foreach($types as $type)
                                                    <option value="{{ $type }}" 
                                                        {{ old('links.'.$index.'.type', $link->type[$index] ?? '') == $type ? 'selected' : '' }}>
                                                        {{ $type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Files</label>
                                            <input type="file" name="links[{{ $index }}][files][]" multiple 
                                                   class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                                            <small class="text-muted">Add new files (Max 2MB each)</small>
                                            
                                            @if(isset($link->file[$index]) && is_array($link->file[$index]) && count($link->file[$index]) > 0)
                                                <div class="mt-3">
                                                    <h6 class="text-muted mb-2">Existing Files:</h6>
                                                    <div class="row g-2">
                                                        @foreach($link->file[$index] as $fileIndex => $file)
                                                        <div class="col-12 col-md-6">
                                                            <div class="d-flex align-items-center bg-white border rounded p-2">
                                                                @php
                                                                    $fileIcon = 'fa-file';
                                                                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                                                                    if (in_array(strtolower($ext), ['pdf'])) {
                                                                        $fileIcon = 'fa-file-pdf text-danger';
                                                                    } elseif (in_array(strtolower($ext), ['doc', 'docx'])) {
                                                                        $fileIcon = 'fa-file-word text-primary';
                                                                    } elseif (in_array(strtolower($ext), ['xls', 'xlsx'])) {
                                                                        $fileIcon = 'fa-file-excel text-success';
                                                                    } elseif (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
                                                                        $fileIcon = 'fa-file-image text-warning';
                                                                    }
                                                                @endphp
                                                                <i class="fas {{ $fileIcon }} fa-lg me-3"></i>
                                                                <div class="flex-grow-1">
                                                                    <div class="text-truncate" style="max-width: 200px;">
                                                                        {{ basename($file) }}
                                                                    </div>
                                                                    <small class="text-muted">{{ strtoupper($ext) }} • {{ $fileIndex + 1 }}</small>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <a href="{{ asset('storage/' . $file) }}" target="_blank" 
                                                                       class="btn btn-sm btn-outline-primary">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                                            onclick="removeExistingFile(this, '{{ $index }}', '{{ $fileIndex }}')">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <input type="hidden" name="links[{{ $index }}][existing_files]" 
                                                           value="{{ json_encode($link->file[$index] ?? []) }}" 
                                                           id="existing_files_{{ $index }}">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="row mt-4 pt-4 border-top">
                            <div class="col-12 d-flex justify-content-between">
                                <div>
                                    <button type="button" onclick="addLinkRow()" class="btn btn-outline-success">
                                        <i class="fas fa-plus-circle me-2"></i> Add New Link
                                    </button>
                                </div>
                                <div>
                                    <a href="{{ route('principal.links.index') }}" class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-times me-2"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-warning px-4">
                                        <i class="fas fa-save me-2"></i> Update All Links
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let rowIndex = {{ count($link->label) - 1 }};
let removedFiles = {};

function addLinkRow() {
    rowIndex++;
    const container = document.getElementById('links-container');
    const div = document.createElement('div');
    div.className = 'card mb-3 link-row';
    div.setAttribute('data-index', rowIndex);
    div.innerHTML = `
        <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
            <span class="fw-medium">New Link</span>
            <button type="button" onclick="removeLinkRow(this)" class="btn btn-danger btn-sm">
                <i class="fas fa-trash me-1"></i> Remove
            </button>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Label <span class="text-danger">*</span></label>
                    <input type="text" name="links[${rowIndex}][label]" class="form-control" placeholder="Link label" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">URL <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-link"></i></span>
                        <input type="url" name="links[${rowIndex}][url]" class="form-control" placeholder="https://example.com" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Type</label>
                    <select name="links[${rowIndex}][type]" class="form-select">
                        <option value="">Select Type</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Files</label>
                    <input type="file" name="links[${rowIndex}][files][]" multiple 
                           class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                    <small class="text-muted">Add files (Max 2MB each)</small>
                </div>
            </div>
        </div>
    `;
    container.appendChild(div);
    
    // Scroll to the new row
    div.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function removeLinkRow(button) {
    const row = button.closest('.link-row');
    if (row && row.getAttribute('data-index') !== '0') {
        if (confirm('Remove this link?')) {
            row.remove();
        }
    }
}

function removeExistingFile(button, rowIndex, fileIndex) {
    if (confirm('Are you sure you want to remove this file?')) {
        const fileElement = button.closest('.col-12');
        
        // Mark file for removal
        if (!removedFiles[rowIndex]) {
            removedFiles[rowIndex] = [];
        }
        removedFiles[rowIndex].push(fileIndex);
        
        // Create hidden input for removed files
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = `links[${rowIndex}][removed_files][]`;
        hiddenInput.value = fileIndex;
        
        // Add to form
        const form = document.getElementById('editLinksForm');
        form.appendChild(hiddenInput);
        
        // Visual feedback - fade out and remove
        fileElement.style.opacity = '0.5';
        fileElement.style.transition = 'opacity 0.3s';
        setTimeout(() => {
            fileElement.remove();
        }, 300);
    }
}

// Form validation
document.getElementById('editLinksForm').addEventListener('submit', function(e) {
    const rows = document.querySelectorAll('.link-row');
    let isValid = true;
    
    rows.forEach(row => {
        const label = row.querySelector('input[name^="links"][name$="[label]"]');
        const url = row.querySelector('input[name^="links"][name$="[url]"]');
        
        if (!label.value.trim() || !url.value.trim()) {
            isValid = false;
            row.classList.add('border-danger');
        } else {
            row.classList.remove('border-danger');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Please fill in all required fields (Label and URL) for each link.');
    }
});
</script>

<style>
.link-row {
    transition: all 0.3s ease;
}
.link-row:hover {
    border-color: #ffc107 !important;
    box-shadow: 0 0 0 1px rgba(255, 193, 7, 0.25);
}
.link-row.border-danger {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 1px rgba(220, 53, 69, 0.25);
}
.card-header {
    background-color: rgba(248, 249, 250, 0.8) !important;
}
</style>
@endsection