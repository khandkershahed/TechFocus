@extends('admin.master')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Partner List</h2>

    <table class="table table-bordered table-striped table-hover">
        <thead style="background: #000; color:#fff;">
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($partners as $partner)
                <tr>
                    {{-- Correct numbering across pages --}}
                    <td>{{ $loop->iteration + ($partners->currentPage() - 1) * $partners->perPage() }}</td>

                    <td>
                        @if($partner->photo)
                            <img src="{{ asset('storage/'.$partner->photo) }}" width="40" class="rounded-circle">
                        @else
                            <img src="{{ asset('backend/images/no-image-available.png') }}" width="40" class="rounded-circle">
                        @endif
                    </td>

                    <td>{{ $partner->name }}</td>
                    <td>{{ $partner->email }}</td>
                    <td>{{ $partner->company_name }}</td>
                    <td>{{ $partner->phone }}</td>
                    <td>
                        <span class="badge {{ $partner->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $partner->status ?? 'active' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('partner.edit', $partner->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>

                        <form action="{{ route('partner.delete', $partner->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger mb-1">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-danger">No Partners Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination links --}}
    <div class="mt-3">
        {{ $partners->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
    /* Smooth hover effect */
    .table-row:hover {
        background-color: #f8f9fa !important;
        transition: 0.2s;
        cursor: pointer;
    }

    /* Card animation */
    .card {
        transition: .3s;
    }
    .card:hover {
        transform: translateY(-4px);
    }
</style>
@endsection
