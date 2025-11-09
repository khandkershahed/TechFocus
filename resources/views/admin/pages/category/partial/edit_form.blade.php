<form action="{{ route('admin.category.update', $category->id) }}" method="POST"
      enctype="multipart/form-data" class="needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="container px-0">
        <div class="row">

            {{-- Name --}}
            <div class="col-md-6 mb-2">
                <label class="form-label required">Name</label>
                <input type="text" name="name" value="{{ $category->name }}" class="form-control form-control-solid" required>
                <div class="invalid-feedback">Please enter a name</div>
            </div>

            {{-- Image --}}
            <div class="col-md-6 mb-2">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control form-control-solid">
                @if($category->image && file_exists(public_path('storage/category/image/'.$category->image)))
                    <img src="{{ asset('storage/category/image/'.$category->image) }}" width="50" class="img-thumbnail mt-1">
                @endif
            </div>

            {{-- Logo --}}
            <div class="col-md-6 mb-2">
                <label class="form-label">Logo</label>
                <input type="file" name="logo" class="form-control form-control-solid">
                @if($category->logo && file_exists(public_path('storage/category/logo/'.$category->logo)))
                    <img src="{{ asset('storage/category/logo/'.$category->logo) }}" width="50" class="img-thumbnail mt-1">
                @endif
            </div>

            {{-- Is Parent --}}
            <div class="col-md-4 mb-2">
                <div class="form-check mt-4 ms-4">
                    <input type="checkbox" name="is_parent" value="1" class="form-check-input"
                           id="edit_is_parent_checkbox" {{ $category->is_parent ? 'checked' : '' }}>
                    <label class="form-check-label" for="edit_is_parent_checkbox">Is Parent</label>
                </div>
            </div>

            {{-- Parent Dropdown --}}
            <div class="col-md-8 mb-2" id="edit_parent_dropdown_wrapper" style="{{ $category->is_parent ? 'display:none;' : '' }}">
                <label class="form-label">Parent Category</label>
                <select name="parent_id" class="form-select form-select-solid">
                    <option value="">Select Parent</option>
                    @foreach ($parentCategories as $parent)
                        @if($parent->id != $category->id)
                            @include('admin.pages.category.partial.parent_option', [
                                'category' => $parent,
                                'level' => 0,
                                'selectedParent' => $category->parent_id
                            ])
                        @endif
                    @endforeach
                </select>
            </div>

            {{-- Description --}}
            <div class="col-md-12 mb-2">
                <label class="form-label">Description</label>
                <textarea name="description" rows="2" class="form-control form-control-solid">{{ $category->description }}</textarea>
            </div>

        </div>
    </div>

    <div class="modal-footer p-2">
        <button type="submit" class="btn btn-light-primary">Update</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#edit_is_parent_checkbox').change(function() {
            $('#edit_parent_dropdown_wrapper').toggle(!$(this).is(':checked'));
        });
    });
</script>
