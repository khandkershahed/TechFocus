@foreach($faqs as $faq)
<div class="modal fade" id="faqEditModal_{{ $faq->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 border-0 shadow-sm">
            <div class="modal-header p-2 rounded-0">
                <h5 class="modal-title ps-5">Edit FAQ</h5>
                <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label required mb-0">Category</label>
                            <select class="form-select form-select-sm form-select-solid" name="dynamic_category_id" required>
                                <option value="">Select Category</option>
                                @foreach($dynamicCategories as $dynamicCategory)
                                    <option value="{{ $dynamicCategory->id }}" @selected($dynamicCategory->id == $faq->dynamic_category_id)>{{ $dynamicCategory->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a category.</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label required mb-0">Published</label>
                            <select class="form-select form-select-sm form-select-solid" name="is_published" required>
                                <option value="1" @selected($faq->is_published == 1)>Yes</option>
                                <option value="0" @selected($faq->is_published == 0)>No</option>
                            </select>
                            <div class="invalid-feedback">Please select Yes or No.</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label required mb-0">Order</label>
                            <input type="number" name="order" class="form-control form-control-sm form-control-solid" value="{{ $faq->order }}" required>
                            <div class="invalid-feedback">Please enter an order number.</div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label required mb-0">Question</label>
                            <input type="text" name="question" class="form-control form-control-sm form-control-solid" value="{{ $faq->question }}" required>
                            <div class="invalid-feedback">Please enter a question.</div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label required mb-0">Answer</label>
                            <textarea name="answer" class="form-control form-control-sm form-control-solid" rows="3" required>{{ $faq->answer }}</textarea>
                            <div class="invalid-feedback">Please enter an answer.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-2">
                    <button type="submit" class="btn btn-sm btn-light-primary rounded-0">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
