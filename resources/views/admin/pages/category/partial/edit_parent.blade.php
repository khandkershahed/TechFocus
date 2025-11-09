<!-- Edit Category Modal -->
<div class="modal fade" id="categoryEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header p-2">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>

            <!-- Modal Body (AJAX content will load the form here) -->
            <div class="modal-body" id="categoryEditContent">
                <div class="text-center p-5">
                    Loading...
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AJAX Script to load the edit form -->
@push('scripts')
<script>
$(document).ready(function() {
    // Open Edit Modal and load content via AJAX
    $(document).on('click', '.editCategoryBtn', function() {
        let categoryId = $(this).data('id');
        let modalBody = $('#categoryEditContent');

        modalBody.html('<div class="text-center p-5">Loading...</div>');
        $('#categoryEditModal').modal('show');

        $.ajax({
            url: '/admin/category/' + categoryId + '/edit',
            type: 'GET',
            success: function(res) {
                modalBody.html(res);

                // Re-bind the "Is Parent" toggle inside AJAX content
                $('#edit_is_parent_checkbox').change(function() {
                    $('#edit_parent_dropdown_wrapper').toggle(!$(this).is(':checked'));
                });
            },
            error: function() {
                modalBody.html('<div class="text-center p-5 text-danger">Error loading data</div>');
            }
        });
    });
});
</script>
@endpush
