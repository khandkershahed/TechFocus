{{-- 
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Welcome Principal, {{ auth('principal')->user()->name }}</h1>

    <form method="POST" action="{{ route('principal.logout') }}">
        @csrf
        <button type="submit" 
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition duration-200">
            Logout
        </button>
    </form>
</div> --}}
@extends('principal.layouts.app')

@section('title', 'Principal Dashboard')

@section('content')
<!--begin::Content container-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_toolbar" class="toolbar" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar'}">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                    Principal Dashboard
                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                    <small class="text-muted fs-7 fw-bold my-1 ms-1">Welcome, {{ auth('principal')->user()->name }}</small>
                </h1>
                <!--end::Title-->
            </div>
            <!--end::Page title-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xl-3">
                    <!--begin::Card-->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-60px symbol-circle mb-5">
                                <span class="symbol-label bg-light-primary">
                                    <i class="fa-solid fa-cube fs-2x text-primary"></i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column">
                                <span class="fw-bolder text-gray-800 lh-1 fs-2">150</span>
                                <span class="text-gray-600 fw-bold pt-1">Total Products</span>
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-xl-3">
                    <!--begin::Card-->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-60px symbol-circle mb-5">
                                <span class="symbol-label bg-light-success">
                                    <i class="fa-solid fa-cart-shopping fs-2x text-success"></i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column">
                                <span class="fw-bolder text-gray-800 lh-1 fs-2">45</span>
                                <span class="text-gray-600 fw-bold pt-1">Active Orders</span>
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-xl-3">
                    <!--begin::Card-->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-60px symbol-circle mb-5">
                                <span class="symbol-label bg-light-warning">
                                    <i class="fa-solid fa-clock fs-2x text-warning"></i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column">
                                <span class="fw-bolder text-gray-800 lh-1 fs-2">12</span>
                                <span class="text-gray-600 fw-bold pt-1">Pending</span>
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-xl-3">
                    <!--begin::Card-->
                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-60px symbol-circle mb-5">
                                <span class="symbol-label bg-light-info">
                                    <i class="fa-solid fa-chart-line fs-2x text-info"></i>
                                </span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Title-->
                            <div class="d-flex flex-column">
                                <span class="fw-bolder text-gray-800 lh-1 fs-2">89%</span>
                                <span class="text-gray-600 fw-bold pt-1">Success Rate</span>
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-12">
                    <!--begin::Card-->
                    <div class="card card-xl-stretch">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Quick Actions</span>
                                <span class="text-muted mt-1 fw-bold fs-7">Manage your supply chain</span>
                            </h3>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-3">
                            <div class="row g-6 g-xl-9">
                                <div class="col-6 col-lg-3">
                                    <a href="{{ route('principal.supply-chain.products.index') }}" class="card bg-primary hoverable card-xl-stretch mb-5 mb-xl-8">
                                        <div class="card-body">
                                            <i class="fa-solid fa-cube text-white fa-3x mb-2"></i>
                                            <div class="text-white fw-bolder fs-2 mb-2 mt-5">Products</div>
                                            <div class="fw-bold text-white">Manage your products</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <a href="{{ route('principal.supply-chain.categories.index') }}" class="card bg-success hoverable card-xl-stretch mb-5 mb-xl-8">
                                        <div class="card-body">
                                            <i class="fa-solid fa-list text-white fa-3x mb-2"></i>
                                            <div class="text-white fw-bolder fs-2 mb-2 mt-5">Categories</div>
                                            <div class="fw-bold text-white">Product categories</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <a href="{{ route('principal.supply-chain.brands.index') }}" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
                                        <div class="card-body">
                                            <i class="fa-solid fa-tag text-white fa-3x mb-2"></i>
                                            <div class="text-white fw-bolder fs-2 mb-2 mt-5">Brands</div>
                                            <div class="fw-bold text-white">Manage brands</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <a href="#" class="card bg-warning hoverable card-xl-stretch mb-5 mb-xl-8">
                                        <div class="card-body">
                                            <i class="fa-solid fa-file-invoice text-white fa-3x mb-2"></i>
                                            <div class="text-white fw-bolder fs-2 mb-2 mt-5">Orders</div>
                                            <div class="fw-bold text-white">View orders</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<!--end::Content container-->
@endsection