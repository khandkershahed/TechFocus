{{-- resources/views/admin/principals/share-link-create.blade.php --}}
@extends('admin.master')

@section('title', 'Create Share Link')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0">Create Share Link for {{ $principal->legal_name }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.principals.share-links.store', $principal->id) }}" method="POST">
                        @csrf

                        <!-- Allowed Fields -->
                        <div class="mb-4">
                            <h5>Select Fields to Share</h5>
                            <div class="row">
                                @php
                                    $principalFields = [
                                        'basic' => [
                                            'legal_name' => 'Legal Name',
                                            'trading_name' => 'Trading Name', 
                                            'company_name' => 'Company Name',
                                            'entity_type' => 'Entity Type',
                                        ],
                                        'contact' => [
                                            'email' => 'Email',
                                            'website_url' => 'Website',
                                            'hq_city' => 'HQ City',
                                        ],
                                        'status' => [
                                            'status' => 'Status',
                                            'relationship_status' => 'Relationship Status',
                                        ]
                                    ];
                                @endphp

                                @foreach($principalFields as $group => $fields)
                                    <div class="col-md-4">
                                        <h6 class="mt-3">{{ ucfirst($group) }} Information</h6>
                                        @foreach($fields as $field => $label)
                                            <div class="form-check mb-2">
                                                <input type="checkbox" 
                                                       name="allowed_fields[]" 
                                                       value="{{ $field }}" 
                                                       id="field_{{ $field }}"
                                                       class="form-check-input"
                                                       checked>
                                                <label for="field_{{ $field }}" class="form-check-label">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Masked Fields -->
                        <div class="mb-4">
                            <h5>Mask Sensitive Fields</h5>
                            <p class="text-muted">Selected fields will show only first and last characters</p>
                            <div class="row">
                                <div class="col-md-6">
                                    @foreach(['email', 'legal_name', 'trading_name'] as $field)
                                        <div class="form-check mb-2">
                                            <input type="checkbox" 
                                                   name="masked_fields[]" 
                                                   value="{{ $field }}" 
                                                   id="mask_{{ $field }}"
                                                   class="form-check-input">
                                            <label for="mask_{{ $field }}" class="form-check-label">
                                                Mask {{ ucfirst(str_replace('_', ' ', $field)) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Link Settings -->
                        <div class="mb-4">
                            <h5>Link Settings</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Expires At *</label>
                                        <input type="datetime-local" 
                                               name="expires_at" 
                                               class="form-control" 
                                               value="{{ \Carbon\Carbon::now()->addDays(7)->format('Y-m-d\TH:i') }}"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Maximum Views (optional)</label>
                                        <input type="number" 
                                               name="max_views" 
                                               class="form-control" 
                                               placeholder="Leave empty for unlimited">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" 
                                               name="allow_download" 
                                               value="1" 
                                               id="allow_download"
                                               class="form-check-input">
                                        <label for="allow_download" class="form-check-label">
                                            Allow File Downloads
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" 
                                               name="disable_copy" 
                                               value="1" 
                                               id="disable_copy"
                                               class="form-check-input" 
                                               checked>
                                        <label for="disable_copy" class="form-check-label">
                                            Disable Copy/Paste
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Create Share Link</button>
                            <a href="{{ route('admin.principals.show', $principal->id) }}" 
                               class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5>Share Link Preview</h5>
                    <div class="alert alert-info">
                        <small>
                            <strong>How it works:</strong><br>
                            • Selected fields will be visible<br>
                            • Masked fields show only first/last characters<br>
                            • Other fields are completely hidden<br>
                            • Copy protection can be enabled<br>
                            • Link expires automatically
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection