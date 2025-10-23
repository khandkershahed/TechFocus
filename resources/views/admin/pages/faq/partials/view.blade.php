@foreach($faqs as $faq)
<div class="modal fade" id="faqViewModal_{{ $faq->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 border-0 shadow-sm">
            <div class="modal-header p-2 rounded-0">
                <h5 class="modal-title ps-5">View FAQ</h5>
                <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4 fw-bold">Category:</div>
                    <div class="col-8">{{ $faq->dynamicCategoryName() ?? 'No Category' }}</div>

                    <div class="col-4 fw-bold mt-2">Question:</div>
                    <div class="col-8 mt-2">{{ $faq->question }}</div>

                    <div class="col-4 fw-bold mt-2">Answer:</div>
                    <div class="col-8 mt-2">{{ $faq->answer }}</div>

                    <div class="col-4 fw-bold mt-2">Published:</div>
                    <div class="col-8 mt-2">
                        <span class="badge {{ $faq->is_published ? 'bg-success' : 'bg-danger' }}">
                            {{ $faq->is_published ? 'Yes' : 'No' }}
                        </span>
                    </div>

                    <div class="col-4 fw-bold mt-2">Order:</div>
                    <div class="col-8 mt-2">{{ $faq->order }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
