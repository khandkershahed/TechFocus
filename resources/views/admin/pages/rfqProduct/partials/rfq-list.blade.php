@if($rfqs->count() > 0)
    <div class="row">
        <!-- Left Column: RFQ List -->
        <div class="col-lg-5 ps-3 ps-lg-0">
            <div class="shadow-none card mb-lg-0">
                <div class="px-5 pt-3 card-body rounded-2">
                    <div class="rfq-scroll" style="min-height: 630px; overflow-y: auto">
                        <ul class="border-0 nav nav-pills flex-column" id="{{ $status }}-list">
                            @foreach($rfqs as $index => $rfq)
                                @php
                                    // Calculate days since creation
                                    $createdAt = \Carbon\Carbon::parse($rfq->created_at);
                                    $now = \Carbon\Carbon::now();
                                    $daysDiff = $createdAt->diffInDays($now);
                                    $isUrgent = $daysDiff >= 1;
                                    
                                    // Format date
                                    $formattedDate = $createdAt->format('d M Y | h:i A');
                                    
                                    // Get RFQ number from your model
                                    $rfqNumber = $rfq->rfq_code ?? 'RFQ#' . $rfq->id;
                                    $dealCode = $rfq->deal_code ?? 'N/A';
                                @endphp
                                
                                <li class="mt-2 nav-item w-100 mb-md-2">
                                    <a class="p-3 border nav-link btn btn-flex btn-active-primary w-100 {{ $index === 0 ? 'active' : '' }}"
                                       data-bs-toggle="tab"
                                       href="#{{ $status }}_rfq_{{ $rfq->id }}">
                                        <div class="row w-100 align-items-center rfq-content-triger">
                                            <div class="col-md-6 col-12 d-flex align-items-center">
                                                <i class="fa-regular fa-file fs-2 text-primary pe-3"></i>
                                                <div class="text-start">
                                                    <h6 class="mb-0 text-white fw-bold">
                                                        {{ $rfq->company_name ?? 'Unknown Company' }}
                                                    </h6>
                                                    <small class="text-muted">
                                                        {{ $rfqNumber }} | {{ $rfq->country ?? 'N/A' }}
                                                    </small>
                                                    @if($dealCode !== 'N/A')
                                                        <br><small class="text-muted">Deal: {{ $dealCode }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 text-end pe-0">
                                                @if($isUrgent)
                                                    <div class="mb-1 d-flex align-items-center justify-content-end fs-7 notif-yellow">
                                                        <i class="fas fa-bell fa-shake me-1 notif-yellow"></i>
                                                        {{ $daysDiff }} Day{{ $daysDiff > 1 ? 's' : '' }}
                                                    </div>
                                                @else
                                                    <div class="mb-1 d-flex align-items-center justify-content-end fs-7 text-success">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $daysDiff === 0 ? 'Today' : 'Just now' }}
                                                    </div>
                                                @endif
                                                <p class="mb-1 small text-muted">{{ $formattedDate }}</p>
                                                <div class="gap-2 d-flex justify-content-end">
                                                    <button type="button" 
                                                            class="bg-white btn btn-sm btn-outline-primary"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#assignRfqModal-{{ $rfq->id }}">
                                                        Assign
                                                    </button>
                                                    <button class="btn btn-sm btn-primary" style="background-color: #296088">
                                                        Quote
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: RFQ Details -->
        <div class="col-lg-7 pe-3 pe-lg-0">
            <div class="border-0 card">
                <div class="p-5 card-body">
                    <div class="border-0 rounded tab-content" style="height: 630px; overflow-y: auto" id="{{ $status }}-details">
                        @foreach($rfqs as $index => $rfq)
                            @php
                                // Calculate progress based on status
                                $progress = 0;
                                if ($rfq->status === 'pending') {
                                    $progress = 20;
                                } elseif ($rfq->status === 'assigned') {
                                    $progress = 50;
                                } elseif ($rfq->status === 'quoted') {
                                    $progress = 80;
                                } elseif ($rfq->status === 'closed') {
                                    $progress = 100;
                                }
                                
                                // Get assigned user if exists
                                $assignedTo = $rfq->user ?? null;
                                
                                // Get RFQ number
                                $rfqNumber = $rfq->rfq_code ?? 'RFQ#' . $rfq->id;
                                $dealCode = $rfq->deal_code ?? '';
                                
                                // Get country
                                $country = $rfq->country ?? 'N/A';
                            @endphp
                            
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                 id="{{ $status }}_rfq_{{ $rfq->id }}"
                                 role="tabpanel">
                                <div class="border-0 shadow-none card">
                                    <div class="py-3 bg-white card-header border-bottom d-flex justify-content-between align-items-center">
                                        <h4 class="mb-0 text-muted">
                                            {{ $rfqNumber }} | {{ $rfq->company_name ?? 'Unknown Company' }} | {{ $country }}
                                            @if($dealCode)
                                                <br><small class="text-primary">Deal Code: {{ $dealCode }}</small>
                                            @endif
                                        </h4>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle"
                                                    type="button"
                                                    id="actionsDropdown{{ $rfq->id }}"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="actionsDropdown{{ $rfq->id }}">
                                                <li>
                                                    <a class="dropdown-item" href="#" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#assignRfqModal-{{ $rfq->id }}">
                                                        Assign RFQ
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        Send Quote
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        Close RFQ
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="pb-1 card-body">
                                        <!-- Progress bar code here -->
                                        <div class="mb-4 progress-container">
                                            <div class="progress" style="height: 4px">
                                                <div class="progress-bar bg-success"
                                                     role="progressbar"
                                                     style="width: {{ $progress }}%"
                                                     aria-valuenow="{{ $progress }}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>

                                            <div class="status-step active" style="left: 0%">
                                                <div class="text-white icon-circle bg-success">
                                                    <i class="bi bi-check2"></i>
                                                </div>
                                                <div class="step-label small text-success">
                                                    RFQ Created
                                                </div>
                                            </div>

                                            <div class="status-step {{ $rfq->user_id ? 'active' : 'pending' }}" style="left: 50%">
                                                <div class="icon-circle {{ $rfq->user_id ? 'bg-success text-white' : 'bg-light border border-secondary text-secondary' }}">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                                <div class="step-label small {{ $rfq->user_id ? 'text-success' : 'text-muted' }}">
                                                    Assigned To
                                                </div>
                                            </div>

                                            <div class="status-step pending" style="left: 100%">
                                                <div class="border icon-circle bg-light border-secondary text-secondary">
                                                    <i class="bi bi-slash-circle"></i>
                                                </div>
                                                <div class="step-label small text-muted">
                                                    Status Closed
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-0 card-body">
                                        <!-- Client Information code here -->
                                        <div class="pb-2 mb-3 d-flex justify-content-between align-items-center border-bottom">
                                            <h5 class="mb-0">Client Information</h5>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                Details
                                            </button>
                                        </div>
                                        <div class="row small">
                                            <div class="col-6">
                                                <div class="mb-1 d-flex">
                                                    <strong style="width: 120px">Name</strong>
                                                    <span>: {{ $rfq->name ?? 'N/A' }}</span>
                                                </div>
                                                <div class="mb-1 d-flex">
                                                    <strong style="width: 120px">Email</strong>
                                                    <span>: {{ $rfq->email ?? 'N/A' }}</span>
                                                </div>
                                                <div class="mb-1 d-flex">
                                                    <strong style="width: 120px">Company</strong>
                                                    <span>: {{ $rfq->company_name ?? 'N/A' }}</span>
                                                </div>
                                                <div class="mb-1 d-flex">
                                                    <strong style="width: 120px">Phone</strong>
                                                    <span>: {{ $rfq->phone ?? 'N/A' }}</span>
                                                </div>
                                                <div class="mb-1 d-flex">
                                                    <strong style="width: 120px">Designation</strong>
                                                    <span>: {{ $rfq->designation ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1 d-flex">
                                                    <strong style="width: 120px">Budget</strong>
                                                    <span>: {{ $rfq->budget ? '$' . number_format($rfq->budget, 2) : 'N/A' }}</span>
                                                </div>
                                                <div class="mb-1 d-flex">
                                                    <strong style="width: 120px">Create Date</strong>
                                                    <span>: {{ $rfq->create_date ? \Carbon\Carbon::parse($rfq->create_date)->format('d M, Y') : 'N/A' }}</span>
                                                </div>
                                                <div class="mb-1 d-flex">
                                                    <strong style="width: 120px">Country</strong>
                                                    <span>: {{ $rfq->country ?? 'N/A' }}</span>
                                                </div>
                                                <div class="mb-1 d-flex">
                                                    <strong style="width: 120px">City</strong>
                                                    <span>: {{ $rfq->city ?? 'N/A' }}</span>
                                                </div>
                                                <div class="mb-1 d-flex">
                                                    <strong style="width: 120px">Zip Code</strong>
                                                    <span>: {{ $rfq->zip_code ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                            @if($rfq->message)
                                                <div class="col-12 mt-2">
                                                    <div class="mb-1 d-flex">
                                                        <strong style="width: 120px">Message</strong>
                                                        <span>: {{ $rfq->message }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="pt-4 card-body">
                                        <!-- ✅ FIX: Product Information section -->
                                        <div class="pb-2 mb-3 d-flex justify-content-between align-items-center border-bottom">
                                            <h5 class="mb-0">Product Information</h5>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                Details
                                            </button>
                                        </div>
                                        @php
                                            // Make sure we're checking the correct relationship
                                            $rfqProducts = $rfq->rfqProducts ?? collect();
                                        @endphp
                                        @if($rfqProducts->count() > 0)
                                            <table class="table mb-0 table-sm small">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width: 50px">SL</th>
                                                        <th scope="col">Product Name</th>
                                                        <th scope="col" class="text-end" style="width: 80px">Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($rfqProducts as $index => $rfqProduct)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>
                                                                @if($rfqProduct->product)
                                                                    {{ $rfqProduct->product->name }}
                                                                    @if($rfqProduct->sku_no)
                                                                        <br><small class="text-muted">SKU: {{ $rfqProduct->sku_no }}</small>
                                                                    @endif
                                                                @elseif($rfqProduct->additional_product_name)
                                                                    {{ $rfqProduct->additional_product_name }}
                                                                    @if($rfqProduct->sku_no)
                                                                        <br><small class="text-muted">SKU: {{ $rfqProduct->sku_no }}</small>
                                                                    @endif
                                                                @elseif($rfqProduct->product_name)
                                                                    {{ $rfqProduct->product_name }}
                                                                @else
                                                                    Product #{{ $rfqProduct->id }}
                                                                @endif
                                                                
                                                                @if($rfqProduct->product_des)
                                                                    <br><small class="text-muted">{{ $rfqProduct->product_des }}</small>
                                                                @endif
                                                            </td>
                                                            <td class="text-end">{{ $rfqProduct->qty ?? 1 }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="text-center text-muted py-3">
                                                No products found for this RFQ
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="shadow-none card">
        <div class="text-center card-body py-5">
            <i class="fa-regular fa-file fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">No {{ ucfirst($status) }} RFQs</h4>
            <p class="text-muted mb-4">There are no {{ $status }} RFQs to display.</p>
        </div>
    </div>
@endif