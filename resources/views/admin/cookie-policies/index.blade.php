@extends('admin.master')

@section('title', 'Cookie Policies Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Cookie Policies</h1>
        <a href="{{ route('admin.cookie-policies.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>Create New Policy
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Cookie Policies</h6>
            <div class="badge badge-info">Total: {{ $policies->total() }}</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="cookiePoliciesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Published Date</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($policies as $policy)
                            <tr>
                                <td>#{{ $policy->id }}</td>
                                <td>
                                    <strong>{{ $policy->title }}</strong>
                                    @if($policy->is_active)
                                        <span class="badge badge-success ml-2">Active</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" 
                                               class="custom-control-input toggle-status" 
                                               id="status-{{ $policy->id }}"
                                               data-id="{{ $policy->id }}"
                                               {{ $policy->is_active ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status-{{ $policy->id }}">
                                            {{ $policy->is_active ? 'Active' : 'Inactive' }}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    @if($policy->published_at)
                                        {{ $policy->published_at->format('M d, Y') }}
                                        <br>
                                        <small class="text-muted">{{ $policy->published_at->diffForHumans() }}</small>
                                    @else
                                        <span class="text-muted">Not published</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $policy->updated_at->format('M d, Y') }}
                                    <br>
                                    <small class="text-muted">{{ $policy->updated_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.cookie-policies.show', $policy) }}" 
                                           class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.cookie-policies.edit', $policy) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.cookie-policies.preview', $policy) }}" 
                                           class="btn btn-sm btn-secondary" title="Preview" target="_blank">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger delete-policy" 
                                                data-id="{{ $policy->id }}"
                                                data-title="{{ $policy->title }}"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-cookie fa-3x mb-3"></i>
                                        <p>No cookie policies found. Create your first one!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($policies->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $policies->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete "<span id="policyTitle"></span>"?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table td {
        vertical-align: middle;
    }
    
    .btn-group .btn {
        margin-right: 5px;
        border-radius: 4px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle status switch
    $('.toggle-status').change(function() {
        const policyId = $(this).data('id');
        const isChecked = $(this).is(':checked');
        
        $.ajax({
            url: `/admin/cookie-policies/${policyId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'PATCH'
            },
            success: function(response) {
                if (response.success) {
                    // Update label
                    const label = $(`label[for="status-${policyId}"]`);
                    label.text(isChecked ? 'Active' : 'Inactive');
                    
                    // Show success message
                    showAlert('success', response.message);
                    
                    // Reload page after 1.5 seconds to reflect changes
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            },
            error: function(xhr) {
                // Revert checkbox on error
                $(`#status-${policyId}`).prop('checked', !isChecked);
                showAlert('error', 'Failed to update status. Please try again.');
            }
        });
    });
    
    // Delete policy
    $('.delete-policy').click(function() {
        const policyId = $(this).data('id');
        const policyTitle = $(this).data('title');
        
        $('#policyTitle').text(policyTitle);
        $('#deleteForm').attr('action', `/admin/cookie-policies/${policyId}`);
        $('#deleteModal').modal('show');
    });
    
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="fas fa-${icon} mr-2"></i>
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        
        // Remove any existing alerts
        $('.alert-dismissible').remove();
        
        // Add new alert
        $('.container-fluid').prepend(alertHtml);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            $('.alert-dismissible').alert('close');
        }, 5000);
    }
});
</script>
@endpush