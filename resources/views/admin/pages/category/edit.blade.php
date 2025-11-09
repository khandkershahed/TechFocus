<div class="modal fade" id="categoryAddModal" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 border-0 shadow-sm">
            <div class="modal-header p-2 rounded-0">
                <h5 class="modal-title">Add Category</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
            </div>

            <form action="{{ route('admin.category.store') }}" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="container px-0">

                        
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="row">
                                    {{-- Name --}}
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label required">Name</label>
                                        <input type="text" name="name" class="form-control form-control-solid form-control-sm" placeholder="Enter Name" required>
                                        <div class="invalid-feedback">Please Enter Name</div>
                                    </div>

                                    {{-- Image --}}
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="image" class="form-control form-control-solid form-control-sm">
                                    </div>

                                    {{-- Logo --}}
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label">Logo</label>
                                        <input type="file" name="logo" class="form-control form-control-solid form-control-sm">
                                    </div>

                                    {{-- Is Parent --}}
                                    <div class="col-md-4 mb-1">
                                        <div class="form-check form-check-custom form-check-solid mt-3 ms-4 mb-3">
                                            <input type="checkbox" name="is_parent" value="1" class="form-check-input" id="flexRadioLg">
                                            <label class="form-check-label" for="flexRadioLg">Is Parent</label>
                                        </div>
                                    </div>

                                    {{-- Parent Dropdown --}}
                                    <div class="col-md-8 mb-1 hide_parent_input" id="parentInputContainer">
                                        <label class="form-label">Parent Name</label>
                                        <select name="parent_id" class="form-select form-select-solid" data-dropdown-parent="#categoryAddModal">
                                            <option value="">Select Parent</option>
                                            @foreach ($categories->whereNull('parent_id') as $parent)
                                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Description --}}
                                    <div class="col-md-12 mb-1">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control form-control-sm form-control-solid" placeholder="Enter Description" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer p-2">
                    <button type="submit" class="btn btn-sm btn-light-primary rounded-0">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Toggle parent input based on "Is Parent" checkbox
    $('#flexRadioLg').change(function() {
        if($(this).is(':checked')) {
            $('#parentInputContainer').hide();
        } else {
            $('#parentInputContainer').show();
        }
    });
});
</script>
