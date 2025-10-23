{{-- resources/views/admin/pages/faq/partials/create.blade.php --}}
<div class="modal fade" id="faqAddModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 border-0 shadow-sm">
            <div class="modal-header p-2 rounded-0">
                <h5 class="modal-title ps-5">Add FAQ</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
            </div>
            <form action="{{ route('admin.faq.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Category --}}
                        <div class="col-md-6">
                            <label class="form-label required mb-0">Category</label>
                            <select name="dynamic_category_id" class="form-select form-select-sm" required>
                                <option value="">Select Category</option>
                                @foreach ($dynamicCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a category.</div>
                        </div>

                        {{-- Published --}}
                        <div class="col-md-6">
                            <label class="form-label required mb-0">Is Published</label>
                            <select name="is_published" class="form-select form-select-sm" required>
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <div class="invalid-feedback">Please select Yes or No.</div>
                        </div>

                        {{-- Order --}}
                        <div class="col-md-6">
                            <label class="form-label required mb-0">Order</label>
                            <input type="number" name="order" class="form-control form-control-sm" placeholder="Enter order" required>
                            <div class="invalid-feedback">Please enter order number.</div>
                        </div>

                        {{-- Question --}}
                        <div class="col-md-12">
                            <label class="form-label required mb-0">Question</label>
                            <input type="text" name="question" class="form-control form-control-sm" placeholder="Enter question" required>
                            <div class="invalid-feedback">Please enter a question.</div>
                        </div>

                        {{-- Answer --}}
                        <div class="col-md-12">
                            <label class="form-label required mb-0">Answer</label>
                            <textarea name="answer" rows="3" class="form-control form-control-sm" placeholder="Enter answer" required></textarea>
                            <div class="invalid-feedback">Please enter an answer.</div>
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
