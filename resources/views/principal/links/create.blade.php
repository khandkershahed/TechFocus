@extends('principal.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Share New Links</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('principal.links.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div id="links-container" class="row g-3">
                            <!-- First Row -->
                            <div class="link-row col-12 border rounded p-3 mb-3 bg-light" data-index="0">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label fw-medium">Label *</label>
                                        <input type="text" name="links[0][label]" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-medium">URL *</label>
                                        <input type="url" name="links[0][url]" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-medium">Type</label>
                                        <select name="links[0][type]" class="form-select">
                                            @foreach($types as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-medium">Files</label>
                                        <input type="file" name="links[0][files][]" multiple class="form-control">
                                        <small class="text-muted">Multiple files allowed (Max: 2MB each)</small>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" onclick="addLinkRow()" class="btn btn-success btn-sm w-100">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="fas fa-share-alt me-2"></i> Share Links
                            </button>
                            <a href="{{ route('principal.links.index') }}" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let rowIndex = 0;

function addLinkRow() {
    rowIndex++;
    const container = document.getElementById('links-container');
    const div = document.createElement('div');
    div.className = 'link-row col-12 border rounded p-3 mb-3 bg-light';
    div.setAttribute('data-index', rowIndex);
    div.innerHTML = `
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-medium">Label *</label>
                <input type="text" name="links[${rowIndex}][label]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-medium">URL *</label>
                <input type="url" name="links[${rowIndex}][url]" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-medium">Type</label>
                <select name="links[${rowIndex}][type]" class="form-select">
                    @foreach($types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-medium">Files</label>
                <input type="file" name="links[${rowIndex}][files][]" multiple class="form-control">
                <small class="text-muted">Multiple files allowed (Max: 2MB each)</small>
            </div>
            <div class="col-md-1">
                <button type="button" onclick="removeLinkRow(this)" class="btn btn-danger btn-sm w-100">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(div);
}

function removeLinkRow(button) {
    const row = button.closest('.link-row');
    if (row && row.getAttribute('data-index') !== '0') {
        row.remove();
    }
}
</script>

<style>
.link-row {
    transition: all 0.3s ease;
}
.link-row:hover {
    background-color: #f8f9fa !important;
}
</style>
@endsection