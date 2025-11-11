@extends('admin.master')

@section('content')
<div class="container h-100">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3>Edit Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select name="country_id" class="form-select" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ $category->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Parent Category</label>
                            <select name="parent_id" class="form-select">
                                <option value="">No Parent</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Is Parent?</label>
                            <input type="checkbox" name="is_parent" value="1" {{ $category->is_parent ? 'checked' : '' }}>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Logo</label>
                            <input type="file" name="logo" class="form-control">
                            @if($category->logo)
                                <img src="{{ asset($category->logo) }}" width="50" class="mt-2">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                            @if($category->image)
                                <img src="{{ asset($category->image) }}" width="50" class="mt-2">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control">{{ $category->description }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Update Category</button>
                        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
