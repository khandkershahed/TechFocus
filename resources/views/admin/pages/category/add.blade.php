<!-- Add Category Modal -->
<div class="modal fade" id="categoryAddModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <form id="categoryAddForm" action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add New Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label fw-semibold">Category Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Country</label>
              <select name="country_id" id ="country_id" class="form-select" required data-control="select2">
                <option value="">Select Country</option>
                @foreach($countries ?? [] as $country)
                  <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="is_parent" id="flexRadioLg" value="1">
                <label class="form-check-label" for="flexRadioLg">Is Parent Category?</label>
              </div>
            </div>

            <div class="col-md-6 hide_parent_input">
              <label class="form-label fw-semibold">Parent Category</label>
              <select name="parent_id" class="form-select">
                <option value="">Select Parent</option>
                @foreach($parentCategories as $parent)
                  <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Image</label>
              <input type="file" name="image" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Logo</label>
              <input type="file" name="logo" class="form-control">
            </div>

            <div class="col-12">
              <label class="form-label fw-semibold">Description</label>
              <textarea name="description" rows="3" class="form-control"></textarea>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save Category</button>
        </div>
      </form>
    </div>
  </div>
</div>
