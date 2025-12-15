@if($rfqProducts->count() > 0)
    @foreach($rfqProducts as $rfqProduct)
        <div class="rfq-item mb-2 p-2 border rounded" data-status="{{ $rfqProduct->rfq->status ?? 'pending' }}">
            <div>
                <strong>RFQ Code:</strong> {{ $rfqProduct->rfq->rfq_code ?? '-' }}
            </div>
            <div>
                <strong>Product:</strong> {{ $rfqProduct->product_name ?? $rfqProduct->product->name ?? '-' }}
            </div>
            <div>
                <strong>Company:</strong> {{ $rfqProduct->rfq->company_name ?? '-' }}
            </div>
            <div>
                <strong>Status:</strong> {{ $rfqProduct->rfq->status ?? 'pending' }}
            </div>
        </div>
    @endforeach
@else
    <div class="text-center text-muted py-3">No RFQs found for this filter.</div>
@endif
