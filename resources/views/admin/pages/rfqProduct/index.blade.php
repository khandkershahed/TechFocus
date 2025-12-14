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
        <div
          class="p-4 rfq-status-card w-100 position-relative rounded-4"
          style="
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: #fff;
          "
        >
          <div class="p-5 row align-items-center">
            <div class="col-8">
              <h1 class="mb-1 text-white fw-bold">Total RFQ</h1>
                        <p class="mb-3 opacity-75 fs-6">{{ $todayDate }}</p>

                        <div class="pt-5">
                          <span class="mb-1 d-block fs-6 fw-medium">
                            This Month:
                            <strong>{{ $thisMonthRfq }}</strong>

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
                              <div
                                        class="mx-auto bg-white rfq-amount text-primary rounded-circle d-flex align-items-center justify-content-center"
                                        style="
                                          width: 70px;
                                          height: 70px;
                                          font-size: 3rem;
                                          font-weight: 700;
                                          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                                        "
                                      >
                                        {{ $totalRfq }}
                                      </div>
                                    </div>
                                     </div>

          <!-- Decorative Circle -->
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
        <div
          class="p-4 rfq-status-card w-100 rounded-4"
          style="background: #fff; border-left: 5px solid #6a11cb"
        >
          <div class="p-5 row align-items-center">
            <!-- Left side: Icon and Title -->
            <div class="text-center text-lg-start col-6">
              <div
                class="mb-3 rfq-icon bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px"
              >
                <img
                  src="https://ngenitltd.com/backend/assets/images/rfq/Total_RFQ.svg"
                  alt="RFQ Status Icon"
                  style="width: 30px; height: 30px"
                />
              </div>
              <h1 class="mt-2 mb-0 fw-bold">RFQ</h1>
              <p class="mb-0 text-muted">Status</p>
            </div>

            <!-- Right side: Tabs -->
            <div class="col-6">
              <ul class="border-0 nav nav-tabs flex-column rfq-tabs w-100">
                <li class="mb-2 nav-item w-100">
                  <a
                    class="px-3 py-2 rounded nav-link active rfq-pending d-flex justify-content-between align-items-center"
                    data-bs-toggle="tab"
                    href="#pending"
                    data-status="pending"
                    style="
                      background: #f0f4ff;
                      color: #1a3fc0;
                      font-weight: 600;
                    "
                  >
                    <span>Pending</span>
                   <span class="badge bg-primary rounded-pill">
                      {{ $pendingCount }}
                    </span>

                  </a>
                </li>
                <li class="mb-2 nav-item w-100">
                  <a
                    class="px-3 py-2 rounded nav-link rfq-quoted d-flex justify-content-between align-items-center"
                    data-bs-toggle="tab"
                    href="#quoted"
                    data-status="quoted"
                    style="
                      background: #e9f7ef;
                      color: #2f8f4d;
                      font-weight: 600;
                    "
                  >
                    <span>Quoted</span>
                  <span class="badge bg-success rounded-pill">
                  {{ $quotedCount }}
                </span>
                  </a>
                </li>
                <li class="nav-item w-100">
                  <a
                    class="px-3 py-2 rounded nav-link rfq-failed d-flex justify-content-between align-items-center"
                    data-bs-toggle="tab"
                    href="#failed"
                    data-status="lost"
                    style="
                      background: #fff5f5;
                      color: #d93025;
                      font-weight: 600;
                    "
                  >
                    <span>Lost</span>
                    <span class="badge bg-danger rounded-pill">
                      {{ $lostCount }}
                    </span>

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
        <!-- Search Input -->
        <div class="px-3 py-2 bg-white border-0 card-header rounded-top">
          <div class="position-relative">
            <input
              type="text"
              id="searchCountryQuery"
              class="rounded form-control form-control-solid ps-3 fs-7" style="border: 1px solid #eee; width: 480px;"
              placeholder="Search RFQ by Country"
            />
          </div>
        </div>

        <!-- Country List -->
        <div
          class="px-3 pt-2 card-body"
          style="overflow-y: scroll; height: 130px"
        >
          <div id="countryList">
            @php $countries = [ ['name' => 'Bangladesh', 'count' => 58], ['name'
            => 'United States', 'count' => 7], ['name' => 'Yemen', 'count' =>
            7], ['name' => 'United States of America', 'count' => 6], ]; @endphp
            @foreach($countries as $country)
            <div
              class="px-2 py-2 mb-1 country-wrapper hover-bg rounded-0"
              style="border-bottom: 1px solid #e9e9e9"
            >
              <div
                class="d-flex justify-content-between align-items-center country-item"
              >
                <h6 class="mb-0 fw-medium">{{ $country['name'] }}</h6>
                <span class="badge bg-primary rounded-pill"
                  >{{ $country['count'] }}</span
                >
              </div>
            </div>
            @endforeach
          </div>

          <p id="noResults" class="mt-4 text-center text-muted d-none">
            No countries match your search.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- RFQ Filter Section -->
  <div class="px-0 mb-5 row">
    <!-- Left Card: RFQ Filters -->
    <div class="col-12 col-lg-8 ps-0">
      <div class="shadow-none card rounded-4">
        <div class="p-4 card-body">
          <div class="row align-items-center">
            <!-- Left: Title -->
            <div class="mb-3 text-center col-lg-3 text-lg-start mb-lg-0">
              <a href="#allRFQ" class="text-decoration-none">
                <span class="d-block fw-bold fs-5">RFQ Filtered</span>
                <span class="small text-muted">All RFQ history here</span>
              </a>
            </div>

            <!-- Right: Filters -->
            <div class="col-lg-9">
              <div class="row g-2">
                <!-- Country -->
                <div class="col-12 col-md-6 col-lg-3">
                  <select
                    id="filterCountry"
                    class="form-select"
                    data-control="select2"
                    data-placeholder="Country"
                  >
                    <option></option>
                    <option>Bangladesh</option>
                    <option>United States</option>
                    <option>Yemen</option>
                    <option>Singapore</option>
                    <option>Nigeria</option>
                    <option>Saudi Arabia</option>
                  </select>
                </div>

                <!-- Salesman -->
                <div class="col-12 col-md-6 col-lg-3">
                  <select
                    id="filterSalesman"
                    class="form-select"
                    data-control="select2"
                    data-placeholder="Salesman"
                  >
                    <option></option>
                    <option>Johirul Islam Sobuj</option>
                    <option>Fairooz Maliha</option>
                    <option>Abdur Rahman Baktar</option>
                  </select>
                </div>

                <!-- Company -->
                <div class="col-12 col-md-6 col-lg-3">
                  <select
                    id="filterCompany"
                    class="form-select"
                    data-control="select2"
                    data-placeholder="Company"
                  >
                    <option></option>
                    <option>PowerCare Inc</option>
                    <option>Capital Engineering</option>
                    <option>Dil Z</option>
                  </select>
                </div>

                <!-- Search Input -->
                <div class="col-12 col-md-6 col-lg-3 position-relative">
                  <input
                    type="text"
                    class="form-control ps-5"
                    placeholder="Search RFQ..."
                  />
                  <button
                    type="button"
                    class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2 d-none"
                    id="clearSearch"
                  >
                    <i class="fas fa-times text-muted"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Card: Year / Month / Archived -->
    <div class="col-12 col-lg-4 pe-0">
      <div class="shadow-none card rounded-4">
        <div
          class="flex-wrap p-4 row card-body d-flex justify-content-between align-items-center"
        >
          <div class="flex-grow-1 col-12 col-md-6 col-lg-4">
            <select
              id="filterYear"
              class="form-select"
              data-control="select2"
              data-placeholder="Year"
            >
              <option>2022</option>
              <option>2023</option>
              <option selected>2025</option>
            </select>
          </div>
          <div class="flex-grow-1 col-12 col-md-6 col-lg-4">
            <select
              id="filterMonth"
              class="form-select"
              data-control="select2"
              data-placeholder="Month"
            >
              <option>January</option>
              <option>February</option>
              <option selected>December</option>
            </select>
          </div>
          <div class="flex-grow-1 col-12 col-md-6 col-lg-4">
            <a
              href="https://ngenitltd.com/admin/archived/rfq"
              class="text-center btn btn-outline-primary flex-grow-1 w-100"
            >
              Archived <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- RFQ Tab Content -->
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade active show" id="pending" role="tabpanel">
      <div class="row">
        <div class="col-lg-5 ps-3 ps-lg-0">
          <div class="shadow-none card mb-lg-0">
            <div class="px-5 pt-3 card-body rounded-2">
              <div
                class="rfq-scroll"
                style="min-height: 630px; overflow-y: auto"
              >
                <ul class="border-0 nav nav-pills flex-column">
                  <li class="mt-2 nav-item w-100 mb-md-2">
                    <a
                      class="p-3 border nav-link btn btn-flex btn-active-primary w-100 active"
                      data-bs-toggle="tab"
                      href="#pending_rfq_573"
                    >
                      <div
                        class="row w-100 align-items-center rfq-content-triger"
                      >
                        <div class="col-md-6 col-12 d-flex align-items-center">
                          <i
                            class="fa-regular fa-file fs-2 text-primary pe-3"
                          ></i>
                          <div class="text-start">
                            <h6 class="mb-0 text-white fw-bold">
                              Protea Electronics (Pty) Ltd
                            </h6>
                            <small class="text-muted"
                              >RFQ# 251212-2 | South Africa</small
                            >
                          </div>
                        </div>
                        <div class="col-md-6 col-12 text-end pe-0">
                          <div
                            class="mb-1 d-flex align-items-center justify-content-end fs-7 notif-yellow"
                          >
                            <i
                              class="fas fa-bell fa-shake me-1 notif-yellow"
                            ></i>
                            1 Day
                          </div>
                          <p class="mb-1 small text-muted">
                            12 Dec 2025 | 07:38 PM
                          </p>
                          <div class="gap-2 d-flex justify-content-end">
                            <button
                              type="button"
                              class="bg-white btn btn-sm btn-outline-primary"
                              data-bs-toggle="modal"
                              data-bs-target="#assignRfqModal-573"
                            >
                              Assign
                            </button>
                            <button
                              class="btn btn-sm btn-primary"
                              style="background-color: #296088"
                            >
                              Quote
                            </button>
                          </div>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- RFQ Item 2 -->
                  <li class="mt-2 nav-item w-100 mb-md-2">
                    <a
                      class="p-3 border nav-link btn btn-flex btn-active-primary w-100"
                      data-bs-toggle="tab"
                      href="#pending_rfq_574"
                    >
                      <div
                        class="row w-100 align-items-center rfq-content-triger"
                      >
                        <div class="col-md-6 col-12 d-flex align-items-center">
                          <i
                            class="fa-regular fa-file fs-2 text-primary pe-3"
                          ></i>
                          <div class="text-start">
                            <h6 class="mb-0 text-white fw-bold">
                              Global Tech Solutions
                            </h6>
                            <small class="text-muted"
                              >RFQ# 251212-3 | USA</small
                            >
                          </div>
                        </div>
                        <div class="col-md-6 col-12 text-end pe-0">
                          <div
                            class="mb-1 d-flex align-items-center justify-content-end fs-7 notif-yellow"
                          >
                            <i
                              class="fas fa-bell fa-shake me-1 notif-yellow"
                            ></i>
                            2 Days
                          </div>
                          <p class="mb-1 small text-muted">
                            13 Dec 2025 | 10:20 AM
                          </p>
                          <div class="gap-2 d-flex justify-content-end">
                            <button
                              type="button"
                              class="bg-white btn btn-sm btn-outline-primary"
                            >
                              Assign
                            </button>
                            <button
                              class="btn btn-sm btn-primary"
                              style="background-color: #296088"
                            >
                              Quote
                            </button>
                          </div>
                        </div>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column: RFQ Details -->
        <div class="col-lg-7 pe-3 pe-lg-0">
          <div class="border-0 card">
            <div class="p-5 card-body">
              <div
                class="border-0 rounded tab-content"
                style="height: 630px; overflow-y: auto"
              >
                <!-- RFQ 1 Details -->
                <div
                  class="tab-pane fade show active"
                  id="pending_rfq_573"
                  role="tabpanel"
                >
                  <div class="border-0 shadow-none card">
                    <div
                      class="py-3 bg-white card-header border-bottom d-flex justify-content-between align-items-center"
                    >
                      <h4 class="mb-0 text-muted">
                        RFQ# 251212-2 | Protea Electronics (Pty) Ltd | South
                        Africa
                      </h4>
                      <div class="dropdown">
                        <button
                          class="btn btn-primary dropdown-toggle"
                          type="button"
                          id="actionsDropdown"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                        >
                          Actions
                        </button>
                        <ul
                          class="dropdown-menu dropdown-menu-end"
                          aria-labelledby="actionsDropdown"
                        >
                          <li>
                            <a class="dropdown-item" href="#">Assign RFQ</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="#">Send Quote</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="#">Close RFQ</a>
                          </li>
                        </ul>
                      </div>
                    </div>

                    <div class="pb-1 card-body">
                      <div class="mb-4 progress-container">
                        <div class="progress" style="height: 4px">
                          <div
                            class="progress-bar bg-success"
                            role="progressbar"
                            style="width: 20%"
                            aria-valuenow="20"
                            aria-valuemin="0"
                            aria-valuemax="100"
                          ></div>
                        </div>

                        <div class="status-step active" style="left: 0%">
                          <div class="text-white icon-circle bg-success">
                            <i class="bi bi-check2"></i>
                          </div>
                          <div class="step-label small text-success">
                            Rfq Created
                          </div>
                        </div>

                        <div class="status-step pending" style="left: 50%">
                          <div
                            class="border icon-circle bg-light border-secondary text-secondary"
                          >
                            <i class="bi bi-person"></i>
                          </div>
                          <div class="step-label small text-muted">
                            Assigned To
                          </div>
                        </div>

                        <div class="status-step pending" style="left: 100%">
                          <div
                            class="border icon-circle bg-light border-secondary text-secondary"
                          >
                            <i class="bi bi-slash-circle"></i>
                          </div>
                          <div class="step-label small text-muted">
                            Status Closed
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="pt-0 card-body">
                      <div
                        class="pb-2 mb-3 d-flex justify-content-between align-items-center border-bottom"
                      >
                        <h5 class="mb-0">Client Information</h5>
                        <button class="btn btn-sm btn-outline-secondary">
                          Details
                        </button>
                      </div>
                      <div class="row small">
                        <div class="col-6">
                          <div class="mb-1 d-flex">
                            <strong style="width: 120px">Name</strong>
                            <span>: Kenny Nkabinde</span>
                          </div>
                          <div class="mb-1 d-flex">
                            <strong style="width: 120px">Email</strong>
                            <span>: kennyyn@protea.co.za</span>
                          </div>
                          <div class="mb-1 d-flex">
                            <strong style="width: 120px">Company</strong>
                            <span>: Protea Electronics (Pty) Ltd</span>
                          </div>
                          <div class="mb-1 d-flex">
                            <strong style="width: 120px">Phone</strong>
                            <span>: 078887298</span>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="mb-1 d-flex">
                            <strong style="width: 120px"
                              >Tentative Budget</strong
                            >
                            <span>:</span>
                          </div>
                          <div class="mb-1 d-flex">
                            <strong style="width: 120px">Purchase Date</strong>
                            <span>:</span>
                          </div>
                          <div class="mb-1 d-flex">
                            <strong style="width: 120px"
                              >Delivery Country</strong
                            >
                            <span>: South Africa</span>
                          </div>
                          <div class="mb-1 d-flex">
                            <strong style="width: 120px"
                              >Delivery Zip Code</strong
                            >
                            <span>: 2065</span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="pt-4 card-body">
                      <div
                        class="pb-2 mb-3 d-flex justify-content-between align-items-center border-bottom"
                      >
                        <h5 class="mb-0">Product Information</h5>
                        <button class="btn btn-sm btn-outline-secondary">
                          Details
                        </button>
                      </div>
                      <table class="table mb-0 table-sm small">
                        <thead>
                          <tr>
                            <th scope="col" style="width: 50px">SL</th>
                            <th scope="col">Product Name</th>
                            <th
                              scope="col"
                              class="text-end"
                              style="width: 80px"
                            >
                              Qty
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Radmin 3 – 200-license package</td>
                            <td class="text-end">1</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <!-- RFQ 2 Details -->
                <div class="tab-pane fade" id="pending_rfq_574" role="tabpanel">
                  <h5>Global Tech Solutions</h5>
                  <p><strong>RFQ#:</strong> 251212-3</p>
                  <p><strong>Country:</strong> USA</p>
                  <p><strong>Received:</strong> 13 Dec 2025 | 10:20 AM</p>
                  <p class="text-muted">
                    RFQ details content goes here. Include requested items,
                    quantities, notes, and any additional info.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Quoted -->
    <div class="tab-pane fade" id="quoted" role="tabpanel">
      <div class="shadow-none card">
        <div class="text-center card-body">No quoted RFQs yet.</div>
      </div>
    </div>
    <!-- Failed -->
    <div class="tab-pane fade" id="failed" role="tabpanel">
      <div class="shadow-none card">
        <div class="text-center card-body">
          <div class="mb-0 alert alert-info">
            <strong>No RFQs have been lost yet.</strong>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection


