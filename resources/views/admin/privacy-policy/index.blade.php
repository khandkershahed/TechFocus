@extends('admin.master')

@section('title', 'Privacy Policy Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Privacy Policies</h3>
                        <a href="{{ route('admin.privacy-policy.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New Policy
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($policies->isEmpty())
                        <div class="alert alert-info">
                            No privacy policies found. <a href="{{ route('admin.privacy-policy.create') }}">Create your first policy</a>.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Version</th>
                                        <th>Status</th>
                                        <th>Sections</th>
                                        <th>Effective Date</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($policies as $policy)
                                        <tr>
                                            <td>{{ $policy->id }}</td>
                                            <td>{{ $policy->title }}</td>
                                            <td>{{ $policy->version ?? 'N/A' }}</td>
                                            <td>
                                                @if($policy->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $policy->sections_count ?? 0 }}</td>
                                            <td>{{ $policy->effective_date ? $policy->effective_date->format('Y-m-d') : 'N/A' }}</td>
                                            <td>{{ $policy->updated_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('privacy-policy') }}" target="_blank" 
                                                       class="btn btn-sm btn-info" title="View on Frontend">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.privacy-policy.edit', $policy->id) }}" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" 
                                                            title="Delete" onclick="confirmDelete({{ $policy->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $policy->id }}" 
                                                          action="{{ route('admin.privacy-policy.destroy', $policy->id) }}" 
                                                          method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this privacy policy? This action cannot be undone.')) {
        event.preventDefault();
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush