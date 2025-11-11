@extends('admin.master')

@section('content')
<div class="container h-100">
    <div class="row">
        <div class="col-lg-12 card rounded-0 shadow-sm">
            <div class="card card-p-0 card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="container px-0">
                        <div class="row">
                            <div class="col-lg-4 col-sm-12 text-lg-start text-sm-center">
                                <!-- Search -->
                          <form method="GET" action="{{ route('admin.category.index') }}" class="d-flex align-items-center position-relative my-1">
                                            <input type="text" name="search"
                                                value="{{ request('search') }}"
                                                class="form-control form-control-sm form-control-solid w-150px ps-14 rounded-0"
                                                placeholder="Search category..." style="border: 1px solid #eee;" />
                                        </form>
                            </div>
                            <div class="col-lg-4 col-sm-12 text-center">
                                <h2 class="mb-0">Category</h2>
                            </div>
                            <div class="col-lg-4 col-sm-12 text-lg-end text-sm-center">
                                <button type="button" class="btn btn-sm btn-light-success rounded-0"
                                    data-bs-toggle="modal" data-bs-target="#categoryAddModal">
                                    Add New
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-hover align-middle rounded-0 table-row-bordered border fs-6 g-5" id="kt_datatable_example">
                        <thead class="table_header_bg">
                            <tr class="text-center text-gray-900 fw-bolder fs-7 text-uppercase">
                                <th width="5%">Sl</th>
                                <th width="10%">Logo</th>
                                <th width="30%">Parent Name</th>
                                <th width="20%">Name</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600 text-center">
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $categories->firstItem() + $loop->index }}</td>
                                <td>
                                    <img class="img-fluid rounded-circle" width="35px"
                                        src="{{ $category->logo && file_exists(public_path($category->logo)) 
                                            ? asset($category->logo) 
                                            : asset('backend/images/no-image-available.png') }}" 
                                        alt="{{ $category->name }} Logo">
                                </td>
                                <td>{{ $category->parentName() ?? 'No Parent' }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                           <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm">
                                                <i class="fa-solid fa-trash-can-arrow-up"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Add Category Modal --}}
@include('admin.pages.category.add')

{{-- ✅ Edit Category Modal Placeholder --}}
<div class="modal fade" id="categoryEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" id="categoryEditContent">
            <!-- AJAX content loads here -->
        </div>
    </div>
</div>
@endsection


@push('scripts')
<!-- ✅ SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {

    /* ---------------------------------------------
     ✅ TOGGLE PARENT FIELD ON ADD FORM
    --------------------------------------------- */
    $(document).on('change', '#flexRadioLg', function() {
        $('.hide_parent_input').toggle(!$(this).is(':checked'));
    });


    /* ---------------------------------------------
     ✅ AJAX — ADD CATEGORY FORM
    --------------------------------------------- */
    $(document).on('submit', '#categoryAddForm', function(e) {
        e.preventDefault();
        let form = $(this)[0];
        let formData = new FormData(form);

        $.ajax({
            url: form.action,
            type: form.method,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                Swal.showLoading();
            },
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Category added successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#categoryAddModal').modal('hide');
                form.reset();
                setTimeout(() => location.reload(), 1500);
            },
            error: function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: err.responseJSON?.message || 'Something went wrong!'
                });
            }
        });
    });


    /* ---------------------------------------------
     ✅ AJAX — LOAD EDIT FORM
    --------------------------------------------- */
    $(document).on('click', '.editCategoryBtn', function() {
        let categoryId = $(this).data('id');
        let modalBody = $('#categoryEditContent');

        modalBody.html('<div class="p-5 text-center">Loading...</div>');
        $('#categoryEditModal').modal('show');

        $.ajax({
            url: "/admin/category/" + categoryId + "/edit",
            type: "GET",
            success: function(res) {
                modalBody.html(res);

                // toggle for parent dropdown inside edit modal
                $('#edit_is_parent_checkbox').change(function() {
                    $('#edit_parent_dropdown_wrapper').toggle(!$(this).is(':checked'));
                });
            },
            error: function() {
                modalBody.html('<div class="p-5 text-center text-danger">Error loading category.</div>');
            }
        });
    });


    /* ---------------------------------------------
     ✅ AJAX — UPDATE CATEGORY FORM
    --------------------------------------------- */
    $(document).on('submit', '#categoryEditForm', function(e) {
        e.preventDefault();
        let form = $(this)[0];
        let formData = new FormData(form);

        $.ajax({
            url: form.action,
            type: form.method,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                Swal.showLoading();
            },
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: 'Category updated successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#categoryEditModal').modal('hide');
                setTimeout(() => location.reload(), 1500);
            },
            error: function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: err.responseJSON?.message || 'Update failed.'
                });
            }
        });
    });

});
</script>
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if(!confirm("Are you sure you want to delete this category?")) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
