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
  
  /* Status badge colors */
  .badge-status-pending { background-color: #ffc107; color: #fff7f7; }
  .badge-status-assigned { background-color: #17a2b8; color: #fff; }
  .badge-status-quoted { background-color: #007bff; color: #fff; }
  .badge-status-closed { background-color: #28a745; color: #fff; }
  .badge-status-lost { background-color: #dc3545; color: #fff; }
</style>

<!-- Display success/error messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif 

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
                  <a class="px-3 py-2 rounded nav-link {{ $activeTab == 'all' ? 'active' : '' }} rfq-all d-flex justify-content-between align-items-center"
                    href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}"
                   style="background: #f0f4ff; color: #1a3fc0; font-weight: 600;">
                    <span>All RFQ</span>
                     <span class="badge bg-primary rounded-pill pending-count">{{ $allRfqs->count() }}</span>
                  </a>
                </li> 
                <li class="mb-2 nav-item w-100">
                  <a class="px-3 py-2 rounded nav-link {{ $activeTab == 'pending' ? 'active' : '' }} rfq-pending d-flex justify-content-between align-items-center"
                    href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
                    style="background: #f0f4ff; color: #1a3fc0; font-weight: 600;">
                    <span>Pending</span>
                    <span class="badge bg-primary rounded-pill pending-count">{{ $pendingCount }}</span>
                  </a>
                </li> 
                <li class="mb-2 nav-item w-100">
                  <a class="px-3 py-2 rounded nav-link {{ $activeTab == 'quoted' ? 'active' : '' }} rfq-quoted d-flex justify-content-between align-items-center"
                    href="{{ request()->fullUrlWithQuery(['status' => 'quoted']) }}"
                    style="background: #e9f7ef; color: #2f8f4d; font-weight: 600;">
                    <span>Quoted</span>
                    <span class="badge bg-success rounded-pill quoted-count">{{ $quotedCount }}</span>
                  </a>
                </li>
                <li class="nav-item w-100">
                  <a class="px-3 py-2 rounded nav-link {{ $activeTab == 'failed' ? 'active' : '' }} rfq-failed d-flex justify-content-between align-items-center"
                    href="{{ request()->fullUrlWithQuery(['status' => 'lost']) }}"
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
              style="border: 1px solid #eee; width: 495px;"
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
  <div class="px-0 mb-4 row">
    <div class="col-12">
      <div class="shadow-none card rounded-4">
        <div class="p-4 card-body">
          <!-- Filter Form -->
          <form id="rfqFilterForm" method="GET" action="{{ route('rfqProducts.index') }}" class="filter-form">
            <!-- Hidden status field to maintain tab state -->
            <input type="hidden" name="status" value="{{ $currentStatus }}">
            
            <div class="row align-items-center">
              <div class="mb-3 text-center col-lg-2 text-lg-start mb-lg-0">
                <a href="#allRFQ" class="text-decoration-none">
                  <span class="d-block fw-bold fs-5">RFQ Filtered</span>
                  <span class="small text-muted">
                    @if($activeTab == 'all')
                      All RFQs ({{ $allRfqs->count() }})
                    @elseif($activeTab == 'pending')
                      Pending RFQs ({{ $pendingCount }})
                    @elseif($activeTab == 'quoted')
                      Quoted RFQs ({{ $quotedCount }})
                    @elseif($activeTab == 'failed')
                      Lost RFQs ({{ $lostCount }})
                    @endif
                  </span>
                </a>
              </div>
              <div class="col-lg-10">
                <div class="row g-2">
                  <!-- Country Filter -->
                  <div class="col-12 col-md-6 col-lg-3">
                    <select id="filterCountry" name="country" class="form-select filter-select"
                      data-control="select2" data-placeholder="Country">
                      <option value="">All Countries</option>
                      @foreach($countries as $country)
                      <option value="{{ $country }}" {{ $currentCountry == $country ? 'selected' : '' }}>
                        {{ $country }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                  
                  <!-- Product Filter -->
                  <div class="col-12 col-md-6 col-lg-3">
                    <select id="filterProduct" name="product" class="form-select filter-select"
                      data-control="select2" data-placeholder="Product">
                      <option value="">All Products</option>
                      @foreach($products as $product)
                      <option value="{{ $product }}" {{ $currentProduct == $product ? 'selected' : '' }}>
                        {{ $product }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                  
                  <!-- Company Filter -->
                  <div class="col-12 col-md-6 col-lg-3">
                    <select id="filterCompany" name="company" class="form-select filter-select"
                      data-control="select2" data-placeholder="Company">
                      <option value="">All Companies</option>
                      @foreach($companies as $company)
                      <option value="{{ $company }}" {{ $currentCompany == $company ? 'selected' : '' }}>
                        {{ $company }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                  
                  <!-- Search Input -->
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
                  
                  <!-- Salesman Filter -->
                  <div class="col-12 col-md-6 col-lg-3">
                    <select id="filterSalesman" name="salesman" class="form-select filter-select"
                      data-control="select2" data-placeholder="Salesman">
                      <option value="">All Salesmen</option>
                      @foreach($salesmen as $salesman)
                      <option value="{{ $salesman }}" {{ $currentSalesman == $salesman ? 'selected' : '' }}>
                        {{ $salesman }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                  
                  <!-- Year Filter -->
                  <div class="col-12 col-md-6 col-lg-2">
                    <select id="filterYear" name="year" class="form-select filter-select" data-control="select2" data-placeholder="Year">
                      <option value="">All Years</option>
                      @foreach($years as $year)
                      <option value="{{ $year }}" {{ $currentYearFilter == $year ? 'selected' : '' }}>{{ $year }}</option>
                      @endforeach
                    </select>
                  </div>
                  
                  <!-- Month Filter -->
                  <div class="col-12 col-md-6 col-lg-2">
                    <select id="filterMonth" name="month" class="form-select filter-select" data-control="select2" data-placeholder="Month">
                      <option value="">All Months</option>
                      @foreach($months as $monthNumber => $monthName)
                      <option value="{{ $monthNumber }}" {{ $currentMonthFilter == $monthNumber ? 'selected' : '' }}>
                        {{ $monthName }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                  
                  <!-- Clear All Filters Button -->
                  <div class="col-12 col-md-12 col-lg-2">
                    <a href="{{ route('rfqProducts.index', ['status' => $currentStatus]) }}" 
                       class="btn btn-outline-secondary w-100" 
                       id="clearAllFilters">
                      <i class="fas fa-times me-1"></i> Clear All
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </form>
          
          <!-- Active Filters Display -->
          @if($currentCountry || $currentProduct || $currentCompany || $currentSearch || $currentSalesman || $currentYearFilter || $currentMonthFilter)
          <div class="mt-3 p-3 bg-light rounded">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <small class="text-muted">Active Filters:</small>
                @if($currentCountry)
                <span class="badge bg-primary me-2">Country: {{ $currentCountry }}</span>
                @endif
                @if($currentProduct)
                <span class="badge bg-success me-2">Product: {{ $currentProduct }}</span>
                @endif
                @if($currentCompany)
                <span class="badge bg-info me-2">Company: {{ $currentCompany }}</span>
                @endif
                @if($currentSearch)
                <span class="badge bg-warning me-2">Search: {{ $currentSearch }}</span>
                @endif
                @if($currentSalesman)
                <span class="badge bg-secondary me-2">Salesman: {{ $currentSalesman }}</span>
                @endif
                @if($currentYearFilter)
                <span class="badge bg-dark me-2">Year: {{ $currentYearFilter }}</span>
                @endif
                @if($currentMonthFilter)
                <span class="badge bg-dark me-2">Month: {{ $months[$currentMonthFilter] }}</span>
                @endif
              </div>
              <a href="{{ route('rfqProducts.index', ['status' => $currentStatus]) }}" 
                 class="text-danger clear-filters-btn">
                <i class="fas fa-times-circle me-1"></i> Clear All
              </a>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- RFQ Content -->
  <div class="card">
    <div class="card-body">
      @if($displayRfqs->count() > 0)
      <div class="row">
        <div class="col-lg-5 ps-3 ps-lg-0">
          <div class="shadow-none card mb-lg-0">
            <div class="px-5 pt-3 card-body rounded-2">
              <div class="rfq-scroll" style="height: 630px; overflow-y: scroll">
                <ul class="border-0 nav nav-pills flex-column" id="rfq-list">
                  @foreach($displayRfqs as $index => $rfq)
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
                    <a class="p-3 border nav-link btn btn-flex btn-outline-primary btn-active-primary w-100 {{ $index === 0 ? 'active' : '' }}"
                      data-bs-toggle="tab" href="#rfq_{{ $rfq->id }}">
                      <div class="row w-100 align-items-center rfq-content-triger">
                        <div class="col-md-6 col-12 d-flex align-items-center">
                          <i class="text-white fa-regular fa-file fs-2 pe-3"></i>
                          <div class="text-start">
                            <h6 class="mb-0 text-white fw-bold">{{ $rfq->company_name ?? 'Unknown Company' }}</h6>
                            <small class="text-white">{{ $rfqNumber }} | {{ $rfq->country ?? 'N/A' }}</small>
                            @if($dealCode !== 'N/A')
                            <br><small class="text-white">Deal: {{ $dealCode }}</small>
                            @endif
                          </div>
                        </div>
                        <div class="col-md-6 col-12 text-end pe-0">
                          @if($isUrgent)
                         <div class="mb-1 d-flex align-items-center justify-content-end fs-7 notif-yellow">
                              <i class="fas fa-bell fa-shake me-1 notif-yellow"></i>
                              {{ sprintf('%02d', $daysDiff) }} Day{{ $daysDiff > 1 ? 's' : '' }}
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
              <div class="border-0 rounded tab-content" style="height: 630px; overflow-y: auto" id="rfq-details">
                @foreach($displayRfqs as $index => $rfq)
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
                } elseif ($rfq->status === 'lost') {
                  $progress = 100;
                }
                $assignedTo = $rfq->user ?? null;
                $rfqNumber = $rfq->rfq_code ?? 'RFQ#' . $rfq->id;
                $dealCode = $rfq->deal_code ?? '';
                $country = $rfq->country ?? 'N/A';
                @endphp
                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                  id="rfq_{{ $rfq->id }}" role="tabpanel">
                  <div class="border-0 shadow-none card">
                    <div class="py-3 bg-white card-header border-bottom d-flex justify-content-between align-items-center">
                      <div>
                        <span>
                          <span class="fs-3">{{ $rfqNumber }}</span> 
                          <span class="text-muted">| {{ $rfq->company_name ?? 'Unknown Company' }} | {{ $country }}</span>
                          <!-- Status badge -->
                          <span class="ms-2 badge badge-status-{{ $rfq->status ?? 'pending' }}">
                            {{ ucfirst($rfq->status ?? 'pending') }}
                          </span>
                        </span>
                        <p> @if($dealCode)
                          <small class="text-primary">Deal Code: {{ $dealCode }}</small>
                          @endif
                        </p>
                      </div>
                      <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button"
                          id="actionsDropdown{{ $rfq->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                          Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown{{ $rfq->id }}">
                          <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#assignRfqModal-{{ $rfq->id }}">Assign RFQ</a></li>
                          <li><a class="dropdown-item" href="#">Send Quote</a></li>
                          <!-- Quick status update links -->
                          <li><hr class="dropdown-divider"></li>
                          <li><h6 class="dropdown-header">Quick Status Update</h6></li>
                           <li>
                            <form method="POST" action="/rfq-products/{{ $rfq->id }}/status" style="display: inline;">
                              @csrf
                              @method('PUT')
                              <input type="hidden" name="status" value="pending">
                              <button type="submit" class="dropdown-item" onclick="return confirm('Mark as Pending?')">
                                <i class="fas fa-clock text-warning me-2"></i> Mark as Pending
                              </button>
                            </form>
                          </li> 
                          <li>
                            <form method="POST" action="/rfq-products/{{ $rfq->id }}/status" style="display: inline;">
                              @csrf
                              @method('PUT')
                              <input type="hidden" name="status" value="quoted">
                              <button type="submit" class="dropdown-item" onclick="return confirm('Mark as Quoted?')">
                                <i class="fas fa-file-invoice-dollar text-info me-2"></i> Mark as Quoted
                              </button>
                            </form>
                          </li>
                          <li>
                            <form method="POST" action="/rfq-products/{{ $rfq->id }}/status" style="display: inline;">
                              @csrf
                              @method('PUT')
                              <input type="hidden" name="status" value="lost">
                              <button type="submit" class="dropdown-item" onclick="return confirm('Mark as Lost?')">
                                <i class="fas fa-times-circle text-danger me-2"></i> Mark as Lost
                              </button>
                            </form>
                          </li>
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
                        <div class="mt-2 col-12">
                          <div class="mb-1 d-flex"><strong style="width: 120px">Message</strong><span>: {{ $rfq->message }}</span></div>
                        </div>
                        @endif
                      </div>
                    </div>

                    <div class="pt-4 card-body">
                      @if(env('APP_DEBUG'))
                      <div class="mb-2 alert alert-info small">
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
                      <div class="py-3 text-center text-muted">No products found for this RFQ</div>
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
        <div class="py-5 text-center card-body">
          <i class="mb-3 fa-regular fa-file fa-4x text-muted"></i>
          <h4 class="text-muted">
            @if($activeTab == 'all')
              No RFQs Found
            @elseif($activeTab == 'pending')
              No Pending RFQs
            @elseif($activeTab == 'quoted')
              No Quoted RFQs
            @elseif($activeTab == 'failed')
              No Lost RFQs
            @endif
          </h4>
          <p class="mb-4 text-muted">
            @if($currentCountry || $currentProduct || $currentCompany || $currentSearch || $currentSalesman || $currentYearFilter || $currentMonthFilter)
              No RFQs match your filter criteria. Try adjusting your filters.
            @else
              @if($activeTab == 'all')
                There are no RFQs to display.
              @elseif($activeTab == 'pending')
                There are no pending RFQs to display.
              @elseif($activeTab == 'quoted')
                There are no quoted RFQs to display.
              @elseif($activeTab == 'failed')
                There are no lost RFQs to display.
              @endif
            @endif
          </p>
          @if($currentCountry || $currentProduct || $currentCompany || $currentSearch || $currentSalesman || $currentYearFilter || $currentMonthFilter)
          <a href="{{ route('rfqProducts.index', ['status' => $currentStatus]) }}" 
             class="btn btn-primary">
            <i class="fas fa-times me-1"></i> Clear Filters
          </a>
          @endif
        </div>
      </div>
      @endif
    </div>
  </div>
</div>

@push('modals')
<!-- Status Update Modal -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1" aria-labelledby="statusUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="statusUpdateForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="statusUpdateModalLabel">Update RFQ Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="rfq_id" id="modalRfqId">
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="pending">Pending</option>
                            <option value="assigned">Assigned</option>
                            <option value="quoted">Quoted</option>
                            <option value="closed">Closed</option>
                            <option value="lost">Lost</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status_notes" class="form-label">Notes (Optional)</label>
                        <textarea name="status_notes" id="status_notes" class="form-control" rows="3" placeholder="Add any notes about this status change..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="follow_up_date" class="form-label">Follow-up Date (Optional)</label>
                        <input type="date" name="follow_up_date" id="follow_up_date" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Country search filter
    const searchInput = document.getElementById('searchCountryQuery');
    const countryList = document.getElementById('countryList');
    const noResults = document.getElementById('noResults');

    if (searchInput && countryList) {
        searchInput.addEventListener('keyup', function() {
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

            if (noResults) {
                noResults.classList.toggle('d-none', visibleCount > 0);
            }
        });
    }

    // Filter form handling
    const filterForm = document.getElementById('rfqFilterForm');
    const clearSearchBtn = document.getElementById('clearSearch');
    const clearAllFiltersBtn = document.getElementById('clearAllFilters');
    
    // Function to submit form automatically
    function autoSubmitForm() {
        // Update the hidden status field to maintain tab state
        const urlParams = new URLSearchParams(window.location.search);
        const currentStatus = urlParams.get('status') || 'all';
        document.querySelector('input[name="status"]').value = currentStatus;
        
        // Submit the form
        filterForm.submit();
    }
    
    // Auto-submit on filter change
    const filterSelects = document.querySelectorAll('.filter-select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            autoSubmitForm();
        });
    });
    
    // Clear search button
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            const searchInput = document.getElementById('filterSearch');
            if (searchInput) {
                searchInput.value = '';
                autoSubmitForm();
            }
        });
    }
    
    // Clear all filters button
    if (clearAllFiltersBtn) {
        clearAllFiltersBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get current status from URL
            const urlParams = new URLSearchParams(window.location.search);
            const currentStatus = urlParams.get('status') || 'all';
            
            // Redirect to base URL with only status parameter
            window.location.href = "{{ route('rfqProducts.index') }}" + "?status=" + currentStatus;
        });
    }
    
    // Search input with debounce
    const searchInputField = document.getElementById('filterSearch');
    let searchTimeout;
    
    if (searchInputField) {
        searchInputField.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                autoSubmitForm();
            }, 500); // 500ms delay for search input
        });
    }
    
    // Tab click handling - update form status
    document.querySelectorAll('.rfq-tabs .nav-link').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get status from href
            const url = new URL(this.href);
            const status = url.searchParams.get('status') || 'all';
            
            // Update hidden status field
            document.querySelector('input[name="status"]').value = status;
            
            // Submit form
            filterForm.submit();
        });
    });
    
    // Initialize Select2 if available
    if (typeof $.fn.select2 !== 'undefined') {
        $('.filter-select').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });
        
        // Also trigger change on select2 change
        $('.filter-select').on('select2:select', function() {
            autoSubmitForm();
        });
        
        $('.filter-select').on('select2:clear', function() {
            autoSubmitForm();
        });
    }
    
    // Status modal function
    window.setModalValues = function(rfqId, currentStatus) {
        document.getElementById('modalRfqId').value = rfqId;
        document.getElementById('status').value = currentStatus || 'pending';
        document.getElementById('statusUpdateForm').action = '/rfq-products/' + rfqId + '/status';
    };
});

</script>
@endpush
@endsection