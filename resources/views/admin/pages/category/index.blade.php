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
                                <div class="d-flex align-items-center position-relative my-1">
                                    <span class="svg-icon svg-icon-2 svg-icon-gray-700 position-absolute top-50 translate-middle-y ms-4">
                                        <!-- SVG icon -->
                                    </span>
                                    <input type="text" data-kt-filter="search"
                                        class="form-control form-control-sm form-control-solid w-150px ps-14 rounded-0"
                                        placeholder="Search" style="border: 1px solid #eee;" />
                                </div>
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
                                <th width="10%">Name</th>
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
                                          <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 editCategoryBtn"
                                                                data-id="{{ $category->id }}">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </button>

                                            <a href="{{ route('admin.category.destroy', $category->id) }}" 
                                               class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 delete">
                                                <i class="fa-solid fa-trash-can-arrow-up"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    <div class="mt-3">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Modal --}}
@include('admin.pages.category.edit')

{{-- Edit Modal Placeholder --}}
<div class="modal fade" id="categoryEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="categoryEditContent">
            <!-- AJAX content will be loaded here -->
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    /* ---------------------------------------------
     ✅ ADD MODAL — Handle Parent Input Toggle
    --------------------------------------------- */
    $(document).on('change', '#flexRadioLg', function() {
        $('.hide_parent_input').toggle(!$(this).is(':checked'));
    });


    /* ---------------------------------------------
     ✅ EDIT MODAL — Load content via AJAX
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

                // ✅ Re-bind toggle for parent dropdown after AJAX load
                $('#edit_is_parent_checkbox').change(function () {
                    $('#edit_parent_dropdown_wrapper').toggle(!$(this).is(':checked'));
                });
            },
            error: function() {
                modalBody.html('<div class="p-5 text-center text-danger">Error loading data</div>');
            }
        });
    });


});
</script>
@endpush

