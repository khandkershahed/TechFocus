
@extends('principal.layouts.app')

@section('content')
<div class="p-5">

    <div class="p-5 bg-white">
        <!-- HEADER -->
        <div class="gap-3 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start">
            <div>
                <h1 class="mb-2 fw-bold text-primary fs-2">COMPANY NAME LLC</h1>
                <div class="flex-wrap gap-2 d-flex">
                    <span class="badge bg-gradient-primary text-light">Manufacturer</span>
                    <span class="badge bg-gradient-primary text-light">SUP-00123</span>
                    <span class="badge bg-success text-light">Active</span>
                    <span class="badge bg-info text-light">Authorized</span>
                </div>
            </div>
            <div class="flex-wrap gap-2 mt-2 d-flex mt-md-0">
                <button class="btn btn-primary"><i class="fa fa-pen me-1"></i> Edit</button>
                <button class="btn btn-success"><i class="fa fa-share-nodes me-1"></i> Share</button>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#noteModal"><i class="fa fa-sticky-note me-1"></i> Add Note</button>
            </div>
        </div>

        <!-- SECTION 1 — Company & Contact -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="gap-4 col-md-6 d-flex flex-column">

                <!-- Company Info -->
                <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #e9f0ff);">
                    <h2 class="mb-3 fs-5 fw-bold text-primary">Company Info</h2>
                    <p><strong>Company Name:</strong> Company LLC</p>
                    <p><strong>Website:</strong> <a href="#" class="text-primary">http://company.com</a></p>
                    <p><strong>Country:</strong> USA</p>
                </div>

                <!-- Contacts -->
                <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f2f9ff);">
                    <h2 class="mb-3 fs-5 fw-bold text-primary">Contacts</h2>
                    <ul class="mb-3 nav nav-tabs" id="contactTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#primary" type="button">Primary</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#social" type="button">Social</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Primary -->
                        <div class="tab-pane fade show active" id="primary">
                            <div class="row g-3">
                                <div class="col-6">
                                    <p><strong>Type:</strong> Management</p>
                                    <p><strong>Name:</strong> Jane Doe</p>
                                    <p><strong>Designation:</strong> Head of Sales</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Email:</strong> jane@company.com</p>
                                    <p><strong>Phone:</strong> +1 555 123 4567</p>
                                </div>
                            </div>
                        </div>
                        <!-- Social -->
                        <div class="tab-pane fade" id="social">
                            <div class="row g-3">
                                <div class="col-6">
                                    <p><strong>Platform:</strong> LinkedIn</p>
                                    <p><strong>Name:</strong> John Public</p>
                                    <p><strong>Position:</strong> Procurement Manager</p>
                                    <p><strong>WhatsApp:</strong> +1 555 123 4567</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Profile:</strong> <a href="https://linkedin.com/in/johnpublic" target="_blank">linkedin.com/in/johnpublic</a></p>
                                    <p><strong>Twitter:</strong> <a href="https://twitter.com/johnpublic" target="_blank">@johnpublic</a></p>
                                    <p><strong>Facebook:</strong> <a href="https://facebook.com/johnpublic" target="_blank">fb.com/johnpublic</a></p>
                                    <p><strong>WeChat:</strong> jane_wechat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="gap-4 col-md-6 d-flex flex-column">

                <!-- Address -->
                <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #e6f7ff);">
                    <h2 class="mb-3 fs-5 fw-bold text-primary">Address</h2>
                    <ul class="nav nav-tabs" id="addressTabs" role="tablist">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#hq">Headquarter</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#line1">Line One</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#line2">Line Two</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#city">City</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#state">State & Postal</button></li>
                    </ul>
                    <div class="pt-3 tab-content">
                        <div class="tab-pane fade show active" id="hq">
                            <p><strong>Official Emails:</strong> info@company.com, sales@company.com</p>
                            <p><strong>Social Media:</strong> LinkedIn, Twitter</p>
                            <p><strong>Bank:</strong> XXXX | <strong>SWIFT:</strong> YYYY</p>
                            <p><strong>Regional Distributors:</strong> ABC Corp, Global Co.</p>
                        </div>
                        <div class="tab-pane fade" id="line1">
                            <p>123 Main St</p>
                        </div>
                        <div class="tab-pane fade" id="line2">
                            <p>Industrial Zone</p>
                        </div>
                        <div class="tab-pane fade" id="city">
                            <p>New York, LA, Texas</p>
                        </div>
                        <div class="tab-pane fade" id="state">
                            <p>NY 10001, TX 75001</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Contact -->
                <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f0fff0);">
                    <h2 class="mb-3 fs-5 fw-bold text-primary">Quick Contact</h2>
                    <div class="flex-wrap gap-3 d-flex justify-content-start">
                        <button class="btn btn-outline-primary btn-lg" title="Call"><i class="fa fa-phone"></i></button>
                        <button class="btn btn-outline-primary btn-lg" title="Email"><i class="fa fa-envelope"></i></button>
                        <button class="btn btn-outline-success btn-lg" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></button>
                        <button class="btn btn-outline-info btn-lg" title="WeChat"><i class="fa-brands fa-weixin"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2 — Brand & Products -->
        <div class="mt-2 row g-4">

            <!-- Brand Info -->
            <div class="gap-4 col-md-5 d-flex flex-column">
                <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f0f7ff);">
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 fs-5 fw-bold text-primary">Brand Info</h3>
                            <p class="mb-0 text-muted">Trusted & Authorized Brand</p>
                        </div>
                        <button class="btn btn-primary btn-sm">+ Add Brand</button>
                    </div>

                    <div class="gap-3 text-center d-flex">
                        <div class="p-3 border rounded shadow-sm flex-fill bg-light">
                            <h6 class="mb-1 text-muted">Total Products</h6>
                            <span class="fs-5 fw-bold text-success">12</span>
                        </div>
                        <div class="p-3 border rounded shadow-sm flex-fill bg-light">
                            <h6 class="mb-1 text-muted">Pending</h6>
                            <span class="fs-5 fw-bold text-warning">3</span>
                        </div>
                        <div class="p-3 border rounded shadow-sm flex-fill bg-light">
                            <h6 class="mb-1 text-muted">Approval</h6>
                            <span class="fs-5 fw-bold text-primary">9</span>
                        </div>
                    </div>

                    <div class="mt-4 table-responsive">
                        <table class="table text-center align-middle table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th></th>
                                    <th>Brand Status</th>
                                    <th>Categories</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="cursor:pointer;" onclick="window.location.href='https://example.com/brand-details';">
                                    <td>
                                        <div class="position-relative d-inline-block">
                                            <a href="#" class="position-absolute start-100 translate-middle">
                                                <i class="p-1 text-white fa fa-pencil bg-primary rounded-circle fs-6"></i>
                                            </a>
                                            <img src="https://seeklogo.com/images/A/acronis-logo-F00F666DAC-seeklogo.com.png" class="rounded img-fluid" width="50" height="50">
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                    <td>Electronics, Hardware</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Product List -->
            <div class="gap-4 col-md-7 d-flex flex-column">
                <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f9f9ff);">
                    <h3 class="mb-3 fs-5 fw-bold text-primary">Products</h3>
                    <div class="table-responsive">
                        <table class="table text-center align-middle table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-start ps-4">Brand Image</th>
                                    <th>Brand Name</th>
                                    <th>Status</th>
                                    <th>Created Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="cursor:pointer;" onclick="window.location.href='https://example.com/brand/acronis';">
                                    <td class="text-start"><img src="https://seeklogo.com/images/A/acronis-logo-F00F666DAC-seeklogo.com.png" class="rounded-2" style="width:50px;height:50px;object-fit:cover;border:2px solid #dee2e6;"></td>
                                    <td>Acronis</td>
                                    <td><span class="badge bg-success">Approved</span></td>
                                    <td>2024-05-01</td>
                                </tr>
                                <tr style="cursor:pointer;" onclick="window.location.href='https://example.com/brand/norton';">
                                    <td class="text-start"><img src="https://seeklogo.com/images/A/acronis-logo-F00F666DAC-seeklogo.com.png" class="rounded-2" style="width:50px;height:50px;object-fit:cover;border:2px solid #dee2e6;"></td>
                                    <td>Norton</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td>2024-08-15</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3 — Product Info & Product List Table -->
        <div class="mt-2 row g-4">
            <!-- Product Info Summary -->
            <div class="gap-4 col-md-5 d-flex flex-column">
                <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f0f7ff);">
                    <div class="mb-3 d-flex justify-content-between">
                        <div>
                            <h3 class="mb-1 fs-5 fw-bold text-primary">Product Info</h3>
                            <p class="mb-0 text-muted">Top Products Overview</p>
                        </div>
                        <button class="btn btn-primary btn-sm">+ Add Product</button>
                    </div>

                    <div class="gap-3 text-center d-flex">
                        <div class="p-3 border rounded shadow-sm flex-fill bg-light">
                            <h6 class="mb-1 text-muted">Total Products</h6>
                            <span class="fs-5 fw-bold text-success">12</span>
                        </div>
                        <div class="p-3 border rounded shadow-sm flex-fill bg-light">
                            <h6 class="mb-1 text-muted">Pending</h6>
                            <span class="fs-5 fw-bold text-warning">3</span>
                        </div>
                        <div class="p-3 border rounded shadow-sm flex-fill bg-light">
                            <h6 class="mb-1 text-muted">Active</h6>
                            <span class="fs-5 fw-bold text-primary">9</span>
                        </div>
                    </div>

                    <div class="mt-4 table-responsive">
                        <table class="table text-center align-middle table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Brand</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="cursor:pointer;" onclick="window.location.href='https://example.com/product/widget-pro-max';">
                                    <td><img src="https://preview.redd.it/my-current-setup-on-my-iphone-16-pro-max-v0-sry2pdcjr6sd1.jpeg" class="rounded img-fluid" width="50" height="50"></td>
                                    <td>Widget Pro Max</td>
                                    <td>NGen</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Product List Table -->
            <div class="gap-4 col-md-7 d-flex flex-column">
                <div class="p-4 bg-white border shadow-sm rounded-4 h-100" style="background: linear-gradient(145deg, #ffffff, #f9f9ff);">
                    <h3 class="mb-3 fs-5 fw-bold text-primary">Product List</h3>
                    <div class="table-responsive">
                        <table class="table text-center align-middle table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-start ps-4">Logo</th>
                                    <th>Name</th>
                                    <th>SKU</th>
                                    <th>Status</th>
                                    <th>Created Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="cursor:pointer;" onclick="window.location.href='https://example.com/product/widget-pro-max';">
                                    <td class="text-start"><img src="https://preview.redd.it/my-current-setup-on-my-iphone-16-pro-max-v0-sry2pdcjr6sd1.jpeg" class="rounded-2" style="width:50px;height:50px;object-fit:cover;border:2px solid #dee2e6;"></td>
                                    <td>Widget Pro Max</td>
                                    <td>WPM-001</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>2024-05-01</td>
                                    <td><button class="btn btn-sm btn-primary">View</button></td>
                                </tr>
                                <tr style="cursor:pointer;" onclick="window.location.href='https://example.com/product/gadget-mini';">
                                    <td class="text-start"><img src="https://preview.redd.it/my-current-setup-on-my-iphone-16-pro-max-v0-sry2pdcjr6sd1.jpeg" class="rounded-2" style="width:50px;height:50px;object-fit:cover;border:2px solid #dee2e6;"></td>
                                    <td>Gadget Mini</td>
                                    <td>GM-002</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td>2024-07-15</td>
                                    <td><button class="btn btn-sm btn-primary">View</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3 — AGREEMENTS & RESOURCES -->
        <div class="mt-2 row g-4">
            <!-- Useful Links & Notes -->
            <div class="col-md-6">
                <div class="p-4 bg-white border shadow-sm rounded-4">
                    <h3 class="mb-3 fs-4 fw-bold">Useful Links</h3>
                    <p><a href="#" class="text-primary">Principal Portal Login</a></p>
                    <p>
                        <a href="#" class="text-primary">Technical Library - Docs & Manuals</a>
                    </p>
                    <p>
                        <a href="#" class="text-primary">Technical Library - Docs & Manuals</a>
                    </p>
                    <p>
                        <a href="#" class="text-primary">Technical Library - Docs & Manuals</a>
                    </p>
                </div>
            </div>
            <!-- Security & Visibility -->
            <div class="col-md-6">
                <div class="p-4 bg-white border shadow-sm rounded-4">
                    <h3 class="mb-3 fs-4 fw-bold">Security & Visibility</h3>
                    <!-- Key Info Cards -->
                    <div class="flex-wrap gap-3 d-flex flex-column">
                        <div class="d-flex justify-content-between">
                            <!-- Visibility Scope -->
                            <div
                                class="p-3 text-center border rounded shadow-sm flex-fill bg-light">
                                <h6 class="mb-1 text-muted">Visibility Scope</h6>
                                <span class="fs-5 fw-bold">Global / Regional / Local</span>
                            </div>
                            <!-- Brand Access -->
                            <div
                                class="p-3 text-center border rounded shadow-sm flex-fill bg-light">
                                <h6 class="mb-1 text-muted">Brand Access</h6>
                                <span class="fs-5 fw-bold">Admin, Manager, Viewer</span>
                            </div>
                        </div>
                        <!-- Account Status -->
                        <div
                            class="p-3 text-center border rounded shadow-sm flex-fill bg-light">
                            <h6 class="mb-1 text-muted">Account Status</h6>
                            <span class="fs-5 fw-bold text-success">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SUMMARY -->
        <div class="mt-4 row row-cols-md-4 g-3">
            <div class="col">
                <div class="p-4 text-center shadow-sm bg-light rounded-4">
                    <h6 class="fw-semibold">Assigned Manager</h6>
                    <p>John Smith</p>
                </div>
            </div>
            <div class="col">
                <div class="p-4 text-center shadow-sm bg-light rounded-4">
                    <h6 class="fw-semibold">2024 Purchase</h6>
                    <p>$1.2M USD</p>
                </div>
            </div>
            <div class="col">
                <div class="p-4 text-center shadow-sm bg-light rounded-4">
                    <h6 class="fw-semibold">Risk Level</h6>
                    <p class="text-danger fw-bold">High (7/10)</p>
                </div>
            </div>
            <div class="col">
                <div class="p-4 text-center shadow-sm bg-light rounded-4">
                    <h6 class="fw-semibold">Relationship</h6>
                    <p>Since 2019</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADD NOTE MODAL -->
<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="noteModalLabel">Add Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="noteTitle" class="form-label">Note Title</label>
                        <input type="text" class="form-control" id="noteTitle" placeholder="Enter title">
                    </div>
                    <div class="mb-3">
                        <label for="noteType" class="form-label">Note Type</label>
                        <select class="form-select" id="noteType">
                            <option selected>Choose type</option>
                            <option value="1">Reminder</option>
                            <option value="2">Alert</option>
                            <option value="3">Comment</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="noteContent" class="form-label">Content</label>
                        <textarea class="form-control" id="noteContent" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="noteFile" class="form-label">Upload File</label>
                        <input class="form-control" type="file" id="noteFile">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Note</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection