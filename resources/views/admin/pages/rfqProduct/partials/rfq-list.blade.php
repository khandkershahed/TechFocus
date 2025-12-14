{{-- RFQ LIST PARTIAL --}}

@if(isset($rfqs) && $rfqs instanceof \Illuminate\Support\Collection && $rfqs->count() > 0)

    @foreach($rfqs as $rfq)

        @php
            $createdAt = \Carbon\Carbon::parse($rfq->created_at);
            $daysDiff = $createdAt->diffInDays(now());
            $formattedDate = $createdAt->format('d M Y, h:i A');
        @endphp

        {{-- ================= RFQ ITEM START ================= --}}
        <li class="nav-item w-100 mb-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    {{-- Time --}}
                    <div class="mb-1 d-flex align-items-center justify-content-end fs-7 text-success">
                        <i class="fas fa-clock me-1"></i>
                        {{ $daysDiff === 0 ? 'Today' : $daysDiff . ' days ago' }}
                    </div>

                    {{-- Date --}}
                    <p class="mb-1 small text-muted">
                        {{ $formattedDate }}
                    </p>

                    {{-- RFQ Info --}}
                    <h6 class="mb-1 fw-bold">
                        RFQ Code: {{ $rfq->rfq_code ?? 'N/A' }}
                    </h6>

                    <p class="mb-1 small">
                        <strong>Company:</strong> {{ $rfq->company_name ?? 'N/A' }}
                    </p>

                    <p class="mb-1 small">
                        <strong>Country:</strong> {{ $rfq->country ?? 'N/A' }}
                    </p>

                    <p class="mb-2 small">
                        <strong>Salesman:</strong> {{ $rfq->user->name ?? 'Unassigned' }}
                    </p>

                    {{-- Actions --}}
                    <div class="gap-2 d-flex justify-content-end">
                        <button type="button"
                                class="btn btn-sm btn-outline-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#assignRfqModal-{{ $rfq->id }}">
                            Assign
                        </button>

                        <a href="{{ route('rfqProducts.show', $rfq->id) }}"
                           class="btn btn-sm btn-primary"
                           style="background-color: #296088">
                            Quote
                        </a>
                    </div>

                </div>
            </div>
        </li>
        {{-- ================= RFQ ITEM END ================= --}}

    @endforeach

@else
    {{-- EMPTY STATE --}}
    <li class="mt-2 nav-item w-100 mb-md-2">
        <div class="p-3 border text-center text-muted">
            <i class="fa-regular fa-file fa-2x mb-2"></i>
            <p class="mb-0">No RFQs found with selected filters</p>
        </div>
    </li>
@endif
