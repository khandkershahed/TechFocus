@extends('admin.master')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h4>Edit Page Banner</h4>
        <a href="{{ route('page_banners.index') }}" class="btn btn-secondary">Back to Banners</a>
    </div>

    @include('admin.partials.alert') {{-- Flash messages --}}

    <div class="card">
        <div class="card-body">
            <form action="{{ route('page_banners.update', $pageBanner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="page_name" class="form-label">Page Name <span class="text-danger">*</span></label>
                    <input type="text" name="page_name" id="page_name" class="form-control" value="{{ old('page_name', $pageBanner->page_name) }}" required>
                    @error('page_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Banner Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $pageBanner->title) }}">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="badge" class="form-label">Badge</label>
                    <input type="text" name="badge" id="badge" class="form-control" value="{{ old('badge', $pageBanner->badge) }}">
                    @error('badge')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="button_name" class="form-label">Button Name</label>
                    <input type="text" name="button_name" id="button_name" class="form-control" value="{{ old('button_name', $pageBanner->button_name) }}">
                    @error('button_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="button_link" class="form-label">Button Link</label>
                    <input type="url" name="button_link" id="button_link" class="form-control" value="{{ old('button_link', $pageBanner->button_link) }}">
                    @error('button_link')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="banner_link" class="form-label">Banner Link</label>
                    <input type="url" name="banner_link" id="banner_link" class="form-control" value="{{ old('banner_link', $pageBanner->banner_link) }}">
                    @error('banner_link')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Banner Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @if($pageBanner->image && file_exists(public_path('uploads/page_banners/' . $pageBanner->image)))
                        <div class="mt-2">
                            <img src="{{ asset('uploads/page_banners/' . $pageBanner->image) }}" alt="{{ $pageBanner->page_name }}" width="150">
                        </div>
                    @endif
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="active" {{ $pageBanner->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $pageBanner->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Update Banner</button>
            </form>
        </div>
    </div>
</div>
@endsection
