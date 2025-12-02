@extends('principal.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0">My Brands</h1>
        <a href="{{ route('principal.brands.create') }}" 
           class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Brand
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white py-3 border-bottom">
            <h2 class="h5 mb-0">All Submitted Brands</h2>
        </div>
        
        @if($brands->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">Brand</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Category</th>
                            <th class="border-0">Submitted Date</th>
                            <th class="border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
                        <tr>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    @if($brand->logo)
                                    <div class="flex-shrink-0">
                                        <img class="rounded-circle" 
                                             src="{{ asset('storage/brand/logo/'.$brand->logo) }}" 
                                             alt="{{ $brand->title }}"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    </div>
                                    @endif
                                    <div class="ms-3">
                                        <div class="fw-medium">
                                            {{ $brand->title }}
                                        </div>
                                        <div class="text-muted small">
                                            {{ $brand->website_url }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="badge 
                                    @if($brand->status == 'approved') bg-success
                                    @elseif($brand->status == 'pending') bg-warning
                                    @else bg-danger @endif">
                                    {{ ucfirst($brand->status) }}
                                </span>
                                @if($brand->status == 'rejected' && $brand->rejection_reason)
                                <div class="small text-danger mt-1">
                                    Reason: {{ $brand->rejection_reason }}
                                </div>
                                @endif
                            </td>
                            <td class="align-middle">
                                {{ $brand->category }}
                            </td>
                            <td class="align-middle">
                                {{ $brand->created_at->format('M d, Y') }}
                            </td>
                            <td class="align-middle">
                                <a href="{{ route('principal.brands.edit', $brand->id) }}" 
                                   class="btn btn-sm btn-outline-primary me-2">
                                    Edit
                                </a>
                                <form action="{{ route('principal.brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this brand?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-store fa-3x text-secondary mb-3"></i>
                <h3 class="h5 mb-2">No brands yet</h3>
                <p class="text-muted mb-4">Start by adding your first brand.</p>
                <a href="{{ route('principal.brands.create') }}" 
                   class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Your First Brand
                </a>
            </div>
        @endif
    </div>
</div>
@endsection