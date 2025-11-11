@extends('admin.master')
@section('content')
    <div class="container h-100">
        <div class="card">
            <div class="card-header p-5">
                <h5 class="modal-title">Edit Category</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.category.update', $category->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                        <div class="row g-3">

                            <!-- Category Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Category Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $category->name) }}" required>
                            </div>

                            <!-- Is Parent -->
                            <div class="col-md-6">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="is_parent"
                                        id="edit_is_parent_checkbox" value="1"
                                        {{ old('is_parent', $category->is_parent) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edit_is_parent_checkbox">Is Parent
                                        Category?</label>
                                </div>
                            </div>

                            <!-- Parent Dropdown -->
                            <div class="col-md-6" id="edit_parent_dropdown_wrapper"
                                style="{{ old('is_parent', $category->is_parent) ? 'display:none;' : '' }}">
                                <label class="form-label fw-semibold">Parent Category</label>
                                <select name="parent_id" class="form-select" data-control="select2" data-allow-clear="true">
                                    <option value="">Select Parent</option>
                                    @foreach ($parentCategories as $parent)
                                        <option value="{{ $parent->id }}"
                                            {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Image Upload -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Image</label>
                                <input type="file" name="image" class="form-control">
                                @if ($category->image)
                                    <img src="{{ asset('storage/category/image/' . $category->image) }}" class="mt-2"
                                        width="60">
                                @endif
                            </div>

                            <!-- Logo Upload -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Logo</label>
                                <input type="file" name="logo" class="form-control">
                                @if ($category->logo)
                                    <img src="{{ asset('storage/category/logo/' . $category->logo) }}" class="mt-2"
                                        width="60">
                                @endif
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
                            </div>

                        </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary float-end">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Toggle parent dropdown on checkbox change
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('edit_is_parent_checkbox');
            const parentWrapper = document.getElementById('edit_parent_dropdown_wrapper');
            checkbox.addEventListener('change', () => {
                parentWrapper.style.display = checkbox.checked ? 'none' : 'block';
            });
        });
    </script>
@endpush
