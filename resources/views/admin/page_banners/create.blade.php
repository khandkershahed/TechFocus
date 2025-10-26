@extends('admin.master')
@section('content')
    <style>
        .hidden {
            display: none;
        }

        .invalid-feedback {
            display: block;
        }
    </style>
    <div class="container-fluid h-100">
        <div class="row">
            <div class="col-lg-12">
                <div class="card my-5 rounded-0">
                    <div class="main_bg card-header py-2 main_bg align-items-center">
                        <div class="col-lg-5 col-sm-12">
                            <div>
                                <a class="btn btn-sm btn-primary btn-rounded rounded-circle btn-icon back-btn"
                                    href="{{ URL::previous() }}">
                                    <i class="fa-solid fa-arrow-left text-white"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-7 col-sm-12 d-flex justify-content-end">
                            <h4 class="text-white p-0 m-0 fw-bold">Catalogue Add Form</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('page_banners.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Page Name</label>
                                <select name="page_name" class="form-select" required>
                                    <option value="">Select Page</option>
                                    <option value="home">Home</option>
                                    <option value="catalog">Catalog</option>
                                    <option value="rfq">RFQ</option>
                                    <option value="contact">Contact</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Banner Image</label>
                                <input type="file" name="image" class="form-control" required>

                            </div>

                            <div class="mb-3">
                                <label class="form-label">Badge</label>
                                <input type="text" name="badge" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Button Name</label>
                                <input type="text" name="button_name" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Button Link</label>
                                <input type="url" name="button_link" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Banner Link</label>
                                <input type="url" name="banner_link" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Banner</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
