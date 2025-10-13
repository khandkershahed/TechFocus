@extends('admin.master')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h4>Page Banners</h4>
        <a href="{{ route('page_banners.create') }}" class="btn btn-primary">Add New Banner</a>
    </div>

    @include('admin.partials.alert') {{-- Flash messages --}}

    <div class="card">
        <div class="card-body">
            @if($banners->count() > 0)
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Page Name</th>
                            <th>Title</th>
                            <th>Badge</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $banner)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucfirst($banner->page_name) }}</td>
                                <td>{{ $banner->title ?? '-' }}</td>
                                <td>{{ $banner->badge ?? '-' }}</td>
                                <td>
                                    @if($banner->image && file_exists(public_path('uploads/page_banners/' . $banner->image)))
                                        <img src="{{ asset('uploads/page_banners/' . $banner->image) }}" alt="{{ $banner->page_name }}" width="80">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $banner->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($banner->status) }}
                                    </span>
                                </td>
                                <td class="d-flex gap-2">
                                    {{-- Optional Edit button --}}
                                    <a href="{{ route('page_banners.edit', $banner->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                    {{-- Delete Form --}}
                                    <form action="{{ route('page_banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">No banners found. <a href="{{ route('page_banners.create') }}">Add a banner</a></p>
            @endif
        </div>
    </div>
</div>
@endsection
