@extends('admin.master')
@section('title', 'RFQ Products')
@section('content')
<style>
    .progress-container {
        position: relative;
        height: 60px;
        width: 520px;
        margin: auto;
    }

    .progress {
        position: absolute;
        top: 20px; 
        left: 0;
        right: 0;
        height: 4px !important;
        border-radius: 0;
    }

    .status-step {
        position: absolute;
        top: 0;
        transform: translateX(-50%); 
        text-align: center;
    }

    .icon-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 0 0 4px white;
        font-size: 16px;
    }

    .status-step.active .icon-circle {
        background-color: #198754 !important; 
        color: white;
    }

    .status-step.pending .icon-circle {
        background-color: #f8f9fa !important; 
        border: 1px solid #6c757d; 
        color: #6c757d;
    }

    .status-step .step-label {
        white-space: nowrap;
        margin-top: 5px;
    }
</style>

<div class="py-4 container-fluid">
    <div class="mb-5 row">
        <!-- Total RFQ Summary -->
        <div class="col-lg-4 ps-lg-0 ps-3">
            <div class="mb-3 border-0 shadow-none card rfq-box">
                <div class="p-4 rfq-status-card w-100 position-relative rounded-4"
                     style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); color: #fff;">
                    <div class="p-5 row align-items-center">
                        <div class="col-8">
                            <h1 class="mb-1 text-white fw-bold">Total RFQ</h1>
                            <p class="mb-3 opacity-75 fs-6">
                                {{ $todayDate ?? now()->format('d M, Y') }}
                            </p>
                            <div class="pt-5">
                                <span class="mb-1 d-block fs-6 fw-medium">
                                    This Month: <strong>{{ $thisMonthRfq }}</strong>
                                    <span class="{{ $growthPercent >= 0 ? 'text-success' : 'text-danger' }} ms-2 fw-bold">
                                        {{ $growthPercent >= 0 ? '▲' : '▼' }} {{ abs($growthPercent) }}%
                                    </span>
                                </span>
                                <span class="d-block fs-6 fw-medium">
                                    Last Month: <strong>{{ $lastMonthRfq }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="mx-auto bg-white rfq-amount text-primary rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 70px; height: 70px; font-size: 3rem; font-weight: 700; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);">
                                {{ $totalRfq }}
                            </div>
                        </div>
                    </div>
                    <div class="top-0 mt-3 opacity-25 position-absolute end-0 me-3">
                        <svg width="50" height="50">
                            <circle cx="25" cy="25" r="25" fill="white" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- RFQ Status -->
        <div class="col-lg-4">
            <div class="border-0 shadow-none card rfq-status mb-lg-0">
                <div class="p-4 rfq-status-card w-100 rounded-4"
                     style="background: #fff; border-left: 5px solid #6a11cb">
                    <div class="p-5 row align-items-center">
                        <div class="text-center text-lg-start col-6">
                            <div class="mb-3 rfq-icon bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                                 style="width: 60px; height: 60px">
                                <img src="https://ngenitltd.com/backend/assets/images/rfq/Total_RFQ.svg"
                                     alt="RFQ Status Icon"
                                     style="width: 30px; height: 30px">
                            </div>
                            <h1 class="mt-2 mb-0 fw-bold">RFQ</h1>
                            <p class="mb-0 text-muted">Status</p>
                        </div>
                        <div class="col-6">
                            <ul class="border-0 nav nav-tabs flex-column rfq-tabs w-100">
                                <li class="mb-2 nav-item w-100">
                                    <a class="px-3 py-2 rounded nav-link active rfq-pending d-flex justify-content-between align-items-center"
                                       data-bs-toggle="tab" href="#pending" data-status="pending"
                                       style="background: #f0f4ff; color: #1a3fc0; font-weight: 600;">
                                        <span>Pending</span>
                                        <span class="badge bg-primary rounded-pill pending-count">{{ $pendingCount }}</span>
                                    </a>
                                </li>
                                <li class="mb-2 nav-item w-100">
                                    <a class="px-3 py-2 rounded nav-link rfq-quoted d-flex justify-content-between align-items-center"
                                       data-bs-toggle="tab" href="#quoted" data-status="quoted"
                                       style="background: #e9f7ef; color: #2f8f4d; font-weight: 600;">
                                        <span>Quoted</span>
                                        <span class="badge bg-success rounded-pill quoted-count">{{ $quotedCount }}</span>
                                    </a>
                                </li>
                                <li class="nav-item w-100">
                                    <a class="px-3 py-2 rounded nav-link rfq-failed d-flex justify-content-between align-items-center"
                                       data-bs-toggle="tab" href="#failed" data-status="lost"
                                       style="background: #fff5f5; color: #d93025; font-weight: 600;">
                                        <span>Lost</span>
                                        <span class="badge bg-danger rounded-pill lost-count">{{ $lostCount }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RFQ by Country -->
        <div class="col-lg-4 pe-lg-3 pe-3">
            <div class="shadow-none card rounded-4 rfq-status-card">
                <div class="px-3 py-2 bg-white border-0 card-header rounded-top">
                    <div class="position-relative">
                        <input type="text" id="searchCountryQuery"
                               class="rounded form-control form-control-solid ps-3 fs-7"
                               style="border: 1px solid #eee; width: 480px;"
                               placeholder="Search RFQ by Country">
                    </div>
                </div>
                <div class="px-3 pt-2 card-body" style="overflow-y: scroll; height: 130px">
                    <div id="countryList">
                        @foreach($rfqByCountry as $country)
                            <div class="px-2 py-2 mb-1 country-wrapper hover-bg rounded-0"
                                 style="border-bottom: 1px solid #e9e9e9">
                                <div class="d-flex justify-content-between align-items-center country-item">
                                    <h6 class="mb-0 fw-medium">{{ $country->country }}</h6>
                                    <span class="badge bg-primary rounded-pill">{{ $country->total }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p id="noResults" class="mt-4 text-center text-muted d-none">No countries match your search.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- RFQ Filter Section -->
    <div class="px-0 mb-5 row">
        <div class="col-12 col-lg-8 ps-0">
            <div class="shadow-none card rounded-4">
                <div class="p-4 card-body">
                    <div class="row align-items-center">
                        <div class="mb-3 text-center col-lg-3 text-lg-start mb-lg-0">
                            <a href="#allRFQ" class="text-decoration-none">
                                <span class="d-block fw-bold fs-5">RFQ Filtered</span>
                                <span class="small text-muted">All RFQ history here</span>
                            </a>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-2">
                                <div class="col-12 col-md-6 col-lg-3">
                                    <select id="filterCountry" name="country" class="form-select filter-select"
                                            data-control="select2" data-placeholder="Country">
                                        <option></option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country }}" {{ $currentCountry == $country ? 'selected' : '' }}>
                                                {{ $country }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <select id="filterSalesman" name="salesman" class="form-select filter-select"
                                            data-control="select2" data-placeholder="Salesman">
                                        <option></option>
                                        @foreach($salesmen as $salesman)
                                            <option value="{{ $salesman }}" {{ $currentSalesman == $salesman ? 'selected' : '' }}>
                                                {{ $salesman }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <select id="filterCompany" name="company" class="form-select filter-select"
                                            data-control="select2" data-placeholder="Company">
                                        <option></option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company }}" {{ $currentCompany == $company ? 'selected' : '' }}>
                                                {{ $company }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3 position-relative">
                                    <input type="text" id="filterSearch" name="search" class="form-control ps-5"
                                           placeholder="Search RFQ..." value="{{ $currentSearch ?? '' }}">
                                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                    @if($currentSearch)
                                        <button type="button" class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2" id="clearSearch">
                                            <i class="fas fa-times text-muted"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 pe-0">
            <div class="shadow-none card rounded-4">
                <div class="flex-wrap p-4 row card-body d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1 col-12 col-md-6 col-lg-4">
                        <select id="filterYear" name="year" class="form-select filter-select" data-control="select2" data-placeholder="Year">
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('year', $currentYear) == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-grow-1 col-12 col-md-6 col-lg-4">
                        <select id="filterMonth" name="month" class="form-select filter-select" data-control="select2" data-placeholder="Month">
                            @foreach($months as $monthNumber => $monthName)
                                <option value="{{ $monthNumber }}" {{ request('month', $currentMonth) == $monthNumber ? 'selected' : '' }}>
                                    {{ $monthName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-grow-1 col-12 col-md-6 col-lg-4">
                        <a href="https://techfocusltd.com/admin/archived/rfq" class="text-center btn btn-outline-primary flex-grow-1 w-100">
                            Archived <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RFQ Tab Content -->
    <div class="tab-content" id="myTabContent">
        <!-- Pending Tab -->
        <div class="tab-pane fade active show" id="pending" role="tabpanel">
            @if($pendingRfqs->count() > 0)
                <div class="row">
                    <div class="col-lg-5 ps-3 ps-lg-0">
                        <div class="shadow-none card mb-lg-0">
                            <div class="px-5 pt-3 card-body rounded-2"style="min-height: 630px; overflow-y: auto">
                                <div class="rfq-scroll" >
                                    <ul class="border-0 nav nav-pills flex-column" id="pending-list">
                                        @foreach($pendingRfqs as $index => $rfq)
                                            @php
                                                $createdAt = \Carbon\Carbon::parse($rfq->created_at);
                                                $now = \Carbon\Carbon::now();
                                                $daysDiff = $createdAt->diffInDays($now);
                                                $isUrgent = $daysDiff >= 1;
                                                $formattedDate = $createdAt->format('d M Y | h:i A');
                                                $rfqNumber = $rfq->rfq_code ?? 'RFQ#' . $rfq->id;
                                                $dealCode = $rfq->deal_code ?? 'N/A';
                                                $productCount = $rfq->rfqProducts ? $rfq->rfqProducts->count() : 0;
                                            @endphp
                                            <li class="mt-2 nav-item w-100 mb-md-2">
                                                <a class="p-3 border nav-link btn btn-flex btn-active-primary w-100 {{ $index === 0 ? 'active' : '' }}"
                                                   data-bs-toggle="tab" href="#pending_rfq_{{ $rfq->id }}">
                                                    <div class="row w-100 align-items-center rfq-content-triger">
                                                        <div class="col-md-6 col-12 d-flex align-items-center">
                                                            <i class="fa-regular fa-file fs-2 text-primary pe-3"></i>
                                                            <div class="text-start">
                                                                <h6 class="mb-0 text-white fw-bold">{{ $rfq->company_name ?? 'Unknown Company' }}</h6>
                                                                <small class="text-muted">{{ $rfqNumber }} | {{ $rfq->country ?? 'N/A' }}</small>
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
                                                                <button type="button" class="bg-white btn btn-sm btn-outline-primary"
                                                                        data-bs-toggle="modal" data-bs-target="#assignRfqModal-{{ $rfq->id }}">
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

                    <div class="col-lg-7 pe-3 pe-lg-0">
                        <div class="border-0 card">
                            <div class="p-5 card-body">
                                <div class="border-0 rounded tab-content" style="height: 630px; overflow-y: auto" id="pending-details">
                                    @foreach($pendingRfqs as $index => $rfq)
                                        @php
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
                                            $assignedTo = $rfq->user ?? null;
                                            $rfqNumber = $rfq->rfq_code ?? 'RFQ#' . $rfq->id;
                                            $dealCode = $rfq->deal_code ?? '';
                                            $country = $rfq->country ?? 'N/A';
                                        @endphp
                                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                             id="pending_rfq_{{ $rfq->id }}" role="tabpanel">
                                            <div class="border-0 shadow-none card">
                                                <div class="py-3 bg-white card-header border-bottom d-flex justify-content-between align-items-center">
                                                    <h4 class="mb-0 text-muted">
                                                        {{ $rfqNumber }} | {{ $rfq->company_name ?? 'Unknown Company' }} | {{ $country }}
                                                        @if($dealCode)
                                                            <br><small class="text-primary">Deal Code: {{ $dealCode }}</small>
                                                        @endif
                                                    </h4>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                                                id="actionsDropdown{{ $rfq->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown{{ $rfq->id }}">
                                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#assignRfqModal-{{ $rfq->id }}">Assign RFQ</a></li>
                                                            <li><a class="dropdown-item" href="#">Send Quote</a></li>
                                                            <li><a class="dropdown-item" href="#">Close RFQ</a></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="pb-1 card-body">
                                                    <div class="mb-4 progress-container">
                                                        <div class="progress" style="height: 4px">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                 style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}"
                                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="status-step active" style="left: 0%">
                                                            <div class="text-white icon-circle bg-success"><i class="bi bi-check2"></i></div>
                                                            <div class="step-label small text-success">RFQ Created</div>
                                                        </div>
                                                        <div class="status-step {{ $rfq->user_id ? 'active' : 'pending' }}" style="left: 50%">
                                                            <div class="icon-circle {{ $rfq->user_id ? 'bg-success text-white' : 'bg-light border border-secondary text-secondary' }}">
                                                                <i class="bi bi-person"></i>
                                                            </div>
                                                            <div class="step-label small {{ $rfq->user_id ? 'text-success' : 'text-muted' }}">Assigned To</div>
                                                        </div>
                                                        <div class="status-step pending" style="left: 100%">
                                                            <div class="border icon-circle bg-light border-secondary text-secondary">
                                                                <i class="bi bi-slash-circle"></i>
                                                            </div>
                                                            <div class="step-label small text-muted">Status Closed</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="pt-0 card-body">
                                                    <div class="pb-2 mb-3 d-flex justify-content-between align-items-center border-bottom">
                                                        <h5 class="mb-0">Client Information</h5>
                                                        <button class="btn btn-sm btn-outline-secondary">Details</button>
                                                    </div>
                                                    <div class="row small">
                                                        <div class="col-6">
                                                            <div class="mb-1 d-flex"><strong style="width: 120px">Name</strong><span>: {{ $rfq->name ?? 'N/A' }}</span></div>
                                                            <div class="mb-1 d-flex"><strong style="width: 120px">Email</strong><span>: {{ $rfq->email ?? 'N/A' }}</span></div>
                                                            <div class="mb-1 d-flex"><strong style="width: 120px">Company</strong><span>: {{ $rfq->company_name ?? 'N/A' }}</span></div>
                                                            <div class="mb-1 d-flex"><strong style="width: 120px">Phone</strong><span>: {{ $rfq->phone ?? 'N/A' }}</span></div>
                                                            <div class="mb-1 d-flex"><strong style="width: 120px">Designation</strong><span>: {{ $rfq->designation ?? 'N/A' }}</span></div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-1 d-flex"><strong style="width: 120px">Budget</strong><span>: {{ $rfq->budget ? '$' . number_format($rfq->budget, 2) : 'N/A' }}</span></div>
                                                            <div class="mb-1 d-flex"><strong style="width: 120px">Create Date</strong><span>: {{ $rfq->create_date ? \Carbon\Carbon::parse($rfq->create_date)->format('d M, Y') : 'N/A' }}</span></div>
                                                            <div class="mb-1 d-flex"><strong style="width: 120px">Country</strong><span>: {{ $rfq->country ?? 'N/A' }}</span></div>
                                                            <div class="mb-1 d-flex"><strong style="width: 120px">City</strong><span>: {{ $rfq->city ?? 'N/A' }}</span></div>
                                                            <div class="mb-1 d-flex"><strong style="width: 120px">Zip Code</strong><span>: {{ $rfq->zip_code ?? 'N/A' }}</span></div>
                                                        </div>
                                                        @if($rfq->message)
                                                            <div class="col-12 mt-2">
                                                                <div class="mb-1 d-flex"><strong style="width: 120px">Message</strong><span>: {{ $rfq->message }}</span></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="pt-4 card-body">
                                                    @if(env('APP_DEBUG'))
                                                        <div class="alert alert-info small mb-2">
                                                            <strong>Debug Info:</strong> RFQ: {{ $rfq->rfq_code }}, Products: {{ $rfq->rfqProducts ? $rfq->rfqProducts->count() : 0 }}
                                                        </div>
                                                    @endif
                                                    <div class="pb-2 mb-3 d-flex justify-content-between align-items-center border-bottom">
                                                        <h5 class="mb-0">Product Information</h5>
                                                        <button class="btn btn-sm btn-outline-secondary">Details</button>
                                                    </div>
                                                    @if($rfq->rfqProducts && $rfq->rfqProducts->count() > 0)
                                                        <table class="table mb-0 table-sm small">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" style="width: 50px">SL</th>
                                                                    <th scope="col">Product Name</th>
                                                                    <th scope="col" class="text-end" style="width: 80px">Qty</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($rfq->rfqProducts as $index => $rfqProduct)
                                                                    @php
                                                                        $productName = 'N/A';
                                                                        if(isset($rfqProduct->product) && !empty($rfqProduct->product)) {
                                                                            $productName = $rfqProduct->product->name ?? 'Product #' . $rfqProduct->product_id;
                                                                        } elseif(!empty($rfqProduct->additional_product_name)) {
                                                                            $productName = $rfqProduct->additional_product_name;
                                                                        } elseif(!empty($rfqProduct->product_name)) {
                                                                            $productName = $rfqProduct->product_name;
                                                                        }
                                                                        $skuNo = $rfqProduct->sku_no ?? null;
                                                                        $productDes = $rfqProduct->product_des ?? null;
                                                                        $qty = $rfqProduct->qty ?? 1;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>
                                                                            {{ $productName }}
                                                                            @if($skuNo)<br><small class="text-muted">SKU: {{ $skuNo }}</small>@endif
                                                                            @if($productDes)<br><small class="text-muted">{{ $productDes }}</small>@endif
                                                                        </td>
                                                                        <td class="text-end">{{ $qty }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <div class="text-center text-muted py-3">No products found for this RFQ</div>
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
                        <h4 class="text-muted">No Pending RFQs</h4>
                        <p class="text-muted mb-4">There are no pending RFQs to display.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Quoted Tab -->
        <div class="tab-pane fade" id="quoted" role="tabpanel">
            <div class="shadow-none card">
                <div class="text-center card-body">
                    @if($quotedRfqs->count() > 0)
                        <p class="mb-3">Found {{ $quotedRfqs->count() }} quoted RFQ(s)</p>
                    @else
                        <i class="fas fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Quoted RFQs</h4>
                        <p class="text-muted">There are no quoted RFQs to display.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Failed/Lost Tab -->
        <div class="tab-pane fade" id="failed" role="tabpanel">
            <div class="shadow-none card">
                <div class="text-center card-body">
                    @if($lostRfqs->count() > 0)
                        <div class="mb-0 alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Found {{ $lostRfqs->count() }} lost RFQ(s)</strong>
                        </div>
                    @else
                        <div class="mb-0 alert alert-info">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>No RFQs have been lost yet.</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchCountryQuery');
    const countryList = document.getElementById('countryList');
    const noResults = document.getElementById('noResults');

    // Country search filter
    searchInput?.addEventListener('keyup', function () {
        const query = this.value.toLowerCase().trim();
        let visibleCount = 0;

        countryList.querySelectorAll('.country-wrapper').forEach(item => {
            const countryName = item.querySelector('.country-item h6')?.innerText.toLowerCase() || '';
            if (countryName.includes(query)) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        noResults?.classList.toggle('d-none', visibleCount > 0);
    });

    // Filter elements
    const filterCountry = document.getElementById('filterCountry');
    const filterSalesman = document.getElementById('filterSalesman');
    const filterCompany = document.getElementById('filterCompany');
    const filterSearch = document.getElementById('filterSearch');
    const filterYear = document.getElementById('filterYear');
    const filterMonth = document.getElementById('filterMonth');
    const clearSearchBtn = document.getElementById('clearSearch');

    // Update filters
    function updateFilters() {
        const filters = {
            country: filterCountry?.value || '',
            salesman: filterSalesman?.value || '',
            company: filterCompany?.value || '',
            search: filterSearch?.value || '',
            year: filterYear?.value || '',
            month: filterMonth?.value || ''
        };

        // Remove empty filters
        Object.keys(filters).forEach(key => { if (!filters[key]) delete filters[key]; });

        showLoading();

        fetch('{{ route("rfqProducts.filter") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(filters)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tabContent = document.getElementById('myTabContent');
                if (tabContent) {
                    tabContent.innerHTML = data.html;
                    updateCounts(data);
                }
            } else {
                console.error('Filter failed:', data.message);
                alert('Failed to apply filters: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to apply filters. Please try again.');
        })
        .finally(() => { hideLoading(); });
    }

    // Update counts (if needed)
    function updateCounts(data) {
        const pendingCount = document.querySelector('.pending-count');
        const quotedCount = document.querySelector('.quoted-count');
        const lostCount = document.querySelector('.lost-count');

        if (pendingCount && data.pendingCount !== undefined) pendingCount.textContent = data.pendingCount;
        if (quotedCount && data.quotedCount !== undefined) quotedCount.textContent = data.quotedCount;
        if (lostCount && data.lostCount !== undefined) lostCount.textContent = data.lostCount;
    }

    // Loading indicator
    function showLoading() {
        const tabContent = document.getElementById('myTabContent');
        if (tabContent) {
            tabContent.innerHTML = `<div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Applying filters...</p>
            </div>`;
        }
    }

    function hideLoading() {}

    // Attach change events
    [filterCountry, filterSalesman, filterCompany, filterYear, filterMonth].forEach(el => {
        if (el) el.addEventListener('change', updateFilters);
    });

    if (filterSearch) {
        let searchTimeout;
        filterSearch.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(updateFilters, 500);
        });
    }

    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            if (filterSearch) filterSearch.value = '';
            updateFilters();
        });
    }
});
</script>
@endpush
@endsection