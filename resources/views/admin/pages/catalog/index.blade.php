@extends('admin.master')
@section('content')
    <div class="container h-100">
        <div class="row">
            <div class="col-lg-12 card rounded-0 shadow-sm">
                <div class="card card-p-0 card-flush">
                    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                        <div class="container px-0">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 text-lg-start text-sm-center">
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <span class="svg-icon svg-icon-2 svg-icon-gray-700 position-absolute top-50 translate-middle-y ms-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <input type="text" data-kt-filter="search"
                                            class="form-control form-control-sm form-control-solid w-150px ps-14 rounded-0"
                                            placeholder="Search" style="border: 1px solid #eee;" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 text-lg-center text-sm-center">
                                    <div class="card-title table_title">
                                        <h2 class="text-center">Catalogue Table</h2>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 text-lg-end text-sm-center">
                                    <button type="button" class="btn btn-sm btn-light-primary rounded-0"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        Export Report
                                    </button>
                                    <a href="{{ route('admin.catalog.create') }}" type="button"
                                        class="btn btn-sm btn-light-success rounded-0">
                                        Add Catalogue
                                    </a>
                                    <div id="kt_datatable_example_1_export_menu"
                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-kt-export="copy">Copy to clipboard</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-kt-export="excel">Export as Excel</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-kt-export="csv">Export as CSV</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-kt-export="pdf">Export as PDF</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover align-middle rounded-0 table-row-bordered border fs-6 g-5"
                            id="kt_datatable_example_1">
                            <thead class="table_header_bg">
                                <tr class="text-center text-gray-900 fw-bolder fs-7 text-uppercase">
                                    <th width="5%">Sl</th>
                                    <th width="20%">Category</th>
                                    <th width="30%">Source Name</th>
                                    <th width="25%">Related Items</th>
                                    <th width="10%">PDF</th>
                                    <th class="text-center" width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="fw-bold text-gray-600 text-center">
                                @if ($catalogs->count() > 0)
                                    @foreach ($catalogs as $catalog)
                                        <tr class="odd">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="badge badge-light-primary">{{ ucfirst($catalog->category) }}</span>
                                            </td>
                                            <td>{{ $catalog->name }}</td>
                                            <td>
                                                @if($catalog->category == 'brand' && $catalog->brands->count() > 0)
                                                    @foreach($catalog->brands as $brand)
                                                        <span class="badge badge-light-info me-1">{{ $brand->title ?? $brand->name }}</span>
                                                    @endforeach
                                                @elseif($catalog->category == 'product' && $catalog->products->count() > 0)
                                                    @foreach($catalog->products as $product)
                                                        <span class="badge badge-light-success me-1">{{ $product->name }}</span>
                                                    @endforeach
                                                @elseif($catalog->category == 'industry' && $catalog->industries->count() > 0)
                                                    @foreach($catalog->industries as $industry)
                                                        <span class="badge badge-light-warning me-1">{{ $industry->name }}</span>
                                                    @endforeach
                                                @elseif($catalog->category == 'company' && $catalog->companies->count() > 0)
                                                    @foreach($catalog->companies as $company)
                                                        <span class="badge badge-light-danger me-1">{{ $company->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">No items selected</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($catalog->document)
                                                    <a href="{{ asset('storage/catalog/document/' . $catalog->document) }}" 
                                                       target="_blank"
                                                       class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                                        <i class="fa-solid fa-file-pdf text-danger"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">No PDF</span>
                                                @endif
                                            </td>
                                            <td class="d-flex justify-content-center align-items-center">
                                                <a href="#"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                    data-bs-toggle="modal" data-bs-target="#catalogueViewModal{{ $catalog->id }}">
                                                    <i class="fa-solid fa-expand"></i>
                                                </a>
                                                <a href="{{ route('admin.catalog.edit', $catalog->id) }}"
                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                   <!-- Delete Button - Fixed Form -->
                                                      @if (Auth::guard('admin')->user()->role == 'admin') 
                                                                            <form action="{{ route('admin.catalog.destroy', $catalog->id) }}" method="POST" class="d-inline">
                                                                                                            @csrf
                                                                                                            @method('DELETE')
                                                                                                            <button type="submit" 
                                                                                                                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete-btn"
                                                                                                                    onclick="return confirm('Are you sure you want to delete this catalog?')">
                                                                                                                <i class="fa-solid fa-trash-can"></i>
                                                                                                            </button>
                                                                                                        </form>
                                                                                                        @endif
                                             </td>
                                        </tr>

                                        <!-- View Modal for each catalog -->
                                        <div class="modal fade" id="catalogueViewModal{{ $catalog->id }}" data-backdrop="static">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content rounded-0 border-0 shadow-sm">
                                                    <div class="modal-header p-2 rounded-0 bg-primary text-white">
                                                        <h5 class="modal-title">View Catalog Details</h5>
                                                        <div class="btn btn-icon btn-sm btn-active-light-white ms-2" data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="fa-solid fa-times"></i>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container px-0">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="card border rounded-0">
                                                                        <div class="card-header bg-light">
                                                                            <span class="badge badge-primary custom-badge">Catalog Information</span>
                                                                        </div>
                                                                        <div class="card-body p-3">
                                                                            <div class="row">
                                                                                <div class="col-lg-6 mb-3">
                                                                                    <strong>Title:</strong>
                                                                                    <p>{{ $catalog->name }}</p>
                                                                                </div>
                                                                                <div class="col-lg-6 mb-3">
                                                                                    <strong>Category:</strong>
                                                                                    <p><span class="badge badge-info">{{ ucfirst($catalog->category) }}</span></p>
                                                                                </div>
                                                                                <div class="col-lg-6 mb-3">
                                                                                    <strong>Page Number:</strong>
                                                                                    <p>{{ $catalog->page_number }}</p>
                                                                                </div>
                                                                                <div class="col-lg-12 mb-3">
                                                                                    <strong>Description:</strong>
                                                                                    <p>{{ $catalog->description }}</p>
                                                                                </div>
                                                                                @if($catalog->category == 'company')
                                                                                <div class="col-lg-6 mb-3">
                                                                                    <strong>Button Name:</strong>
                                                                                    <p>{{ $catalog->company_button_name }}</p>
                                                                                </div>
                                                                                <div class="col-lg-6 mb-3">
                                                                                    <strong>Button Link:</strong>
                                                                                    <p><a href="{{ $catalog->company_button_link }}" target="_blank">{{ $catalog->company_button_link }}</a></p>
                                                                                </div>
                                                                                @endif
                                                                                <div class="col-lg-6 mb-3">
                                                                                    <strong>Thumbnail:</strong>
                                                                                    <br>
                                                                                    @if($catalog->thumbnail)
                                                                                        <img src="{{ asset('storage/catalog/thumbnail/' . $catalog->thumbnail) }}" 
                                                                                             alt="Thumbnail" class="img-thumbnail mt-1" width="100">
                                                                                    @else
                                                                                        <span class="text-muted">No thumbnail</span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="col-lg-6 mb-3">
                                                                                    <strong>Document:</strong>
                                                                                    <br>
                                                                                    @if($catalog->document)
                                                                                        <a href="{{ asset('storage/catalog/document/' . $catalog->document) }}" 
                                                                                           target="_blank" class="btn btn-sm btn-danger mt-1">
                                                                                            <i class="fa-solid fa-file-pdf me-1"></i>View PDF
                                                                                        </a>
                                                                                    @else
                                                                                        <span class="text-muted">No document</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="text-muted">No catalogs found.</div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection