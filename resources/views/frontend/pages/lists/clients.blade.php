@extends('admin.master')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Client List</h2>

    <table class="table table-bordered table-striped table-hover">
        <thead style="background: #000; color:#fff;">
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Company</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($clients as $client)
                <tr>
                    {{-- Correct numbering across pages --}}
                    <td>{{ $loop->iteration + ($clients->currentPage() - 1) * $clients->perPage() }}</td>

                    <td>
                        @if($client->photo)
                            <img src="{{ asset('storage/'.$client->photo) }}" width="40" class="rounded-circle">
                        @else
                            <img src="{{ asset('backend/images/no-image-available.png') }}" width="40" class="rounded-circle">
                        @endif
                    </td>

                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->company_name }}</td>
                    <td>
                        <span class="badge {{ $client->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $client->status ?? 'active' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('client.edit', $client->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>

                        <form action="{{ route('client.delete', $client->id) }}" method="POST" class="d-inline">
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
                    <td colspan="8" class="text-center text-danger">No Clients Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination links --}}
    <div class="mt-3">
        {{ $clients->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
