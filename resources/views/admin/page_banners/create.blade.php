@extends('frontend.master')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header">
            <h4>Add New Page Banner</h4>
        </div>
        <div class="card-body">

            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('page_banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Page Name</label>
                    <select name="page_name" class="form-select" required>
                        <option value="">Select Page</option>
                        <option value="home">Home</option>
                        <option value="catalog">Catalog</option>
                        <option value="rfq">RFQ</option>
                        <option value="contact">Contact</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Banner Image</label>
                  <input type="file" name="image" class="form-control" required>

                </div>

                <div class="mb-3">
                    <label class="form-label">Badge</label>
                    <input type="text" name="badge" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Button Name</label>
                    <input type="text" name="button_name" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Button Link</label>
                    <input type="url" name="button_link" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Banner Link</label>
                    <input type="url" name="banner_link" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" selected>Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Add Banner</button>
            </form>
        </div>
    </div>
</div>
@endsection
