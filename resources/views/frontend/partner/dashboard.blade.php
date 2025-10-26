@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
   @include('frontend.pages.client.partials.page_header')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-0 p-4">

                <!-- Dashboard Header -->
                <h2 class="text-center fw-bold mb-3 font-poppins">
                    Welcome to Your <span class="main-color">Partner Dashboard</span>
                </h2>
                <p class="text-center text-muted mb-4">
                    Manage your activities, view RFQs, and track your business progress here.
                </p>

                <hr>

                <!-- Stats Cards -->
                <div class="row text-center my-4">
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-0 p-4 h-100">
                            <h4 class="fw-bold">Total RFQs</h4>
                            <p class="display-6 main-color mb-0">{{ $totalRfqs ?? 0 }}</p>
                            <small class="text-muted">Received this month</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-0 p-4 h-100">
                            <h4 class="fw-bold">Pending Quotations</h4>
                            <p class="display-6 main-color mb-0">{{ $pendingQuotations ?? 0 }}</p>
                            <small class="text-muted">Awaiting response</small>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-0 p-4 h-100">
                            <h4 class="fw-bold">Approved Deals</h4>
                            <p class="display-6 main-color mb-0">{{ $approvedDeals ?? 0 }}</p>
                            <small class="text-muted">Confirmed by clients</small>
                        </div>
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="card border-0 rounded-0 shadow-sm p-3 mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold">My Profile</h5>
                        @auth
                        <form method="POST" action="{{ route('partner.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm rounded-0">Logout</button>
                        </form>
                        @endauth
                    </div>

                    <form class="row g-3 profileValidation" novalidate
                          method="POST" enctype="multipart/form-data"
                          action="{{ route('partner.profile.update') }}">
                        @csrf

                        {{-- Profile Photo --}}
                        <div class="col-12 text-center mb-3">
                            <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://cdn-icons-png.flaticon.com/512/547/547590.png' }}"
                                 class="rounded-circle shadow-lg border border-2 border-success"
                                 width="100" height="100" alt="Profile Image">
                        </div>
                        <div class="col-12 text-center mb-3">
                            <input type="file" name="profile_image" class="form-control" id="profile_image">
                        </div>

                        {{-- Name --}}
                        <div class="col-md-6">
                            <label for="name" class="form-label">First Name</label>
                            <input type="text" class="form-control rounded-0" id="name" name="name"
                                   value="{{ auth()->user()->name ?? '' }}" required>
                        </div>

                        {{-- Username --}}
                        <div class="col-md-6">
                            <label for="username" class="form-label">Last Name</label>
                            <input type="text" class="form-control rounded-0" id="username" name="username"
                                   value="{{ auth()->user()->username ?? '' }}">
                        </div>

                       

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control rounded-0" id="email" name="email"
                                   value="{{ auth()->user()->email ?? '' }}" required>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control rounded-0" id="phone" name="phone"
                                   value="{{ auth()->user()->phone ?? '' }}">
                        </div>

                        {{-- Company --}}
                        <div class="col-md-6">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control rounded-0" id="company" name="company"
                                   value="{{ auth()->user()->company_name ?? '' }}">
                        </div>

                        {{-- City --}}
                        <div class="col-md-6">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control rounded-0" id="city" name="city"
                                   value="{{ auth()->user()->city ?? '' }}">
                        </div>

                        {{-- Address --}}
                        <div class="col-md-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control rounded-0" id="address" name="address"
                                   value="{{ auth()->user()->address ?? '' }}">
                        </div>

                        {{-- Postal --}}
                        <div class="col-md-6">
                            <label for="postal" class="form-label">Postal Code</label>
                            <input type="text" class="form-control rounded-0" id="postal" name="postal"
                                   value="{{ auth()->user()->postal ?? '' }}">
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control rounded-0" id="status" name="status">
                                <option value="active" {{ auth()->user()->status=='active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ auth()->user()->status=='inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ auth()->user()->status=='suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="disabled" {{ auth()->user()->status=='disabled' ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>

                        {{-- Support Tier --}}
                        <div class="col-md-6">
                            <label for="support_tier" class="form-label">Support Tier</label>
                            <input type="text" class="form-control rounded-0" id="support_tier" name="support_tier"
                                   value="{{ auth()->user()->support_tier ?? '' }}">
                        </div>

                        {{-- Support Tier Description --}}
                        <div class="col-md-6">
                            <label for="support_tier_description" class="form-label">Support Tier Description</label>
                            <input type="text" class="form-control rounded-0" id="support_tier_description" name="support_tier_description"
                                   value="{{ auth()->user()->support_tier_description ?? '' }}">
                        </div>

                        {{-- Company Phone --}}
                        <div class="col-md-6">
                            <label for="company_phone_number" class="form-label">Company Phone</label>
                            <input type="text" class="form-control rounded-0" id="company_phone_number" name="company_phone_number"
                                   value="{{ auth()->user()->company_phone_number ?? '' }}">
                        </div>

                        {{-- Company URL --}}
                        <div class="col-md-6">
                            <label for="company_url" class="form-label">Company URL</label>
                            <input type="text" class="form-control rounded-0" id="company_url" name="company_url"
                                   value="{{ auth()->user()->company_url ?? '' }}">
                        </div>

                        {{-- Company Established Date --}}
                        <div class="col-md-6">
                            <label for="company_established_date" class="form-label">Company Established Date</label>
                            <input type="date" class="form-control rounded-0" id="company_established_date" name="company_established_date"
                                   value="{{ auth()->user()->company_established_date ?? '' }}">
                        </div>

                        {{-- Company Address --}}
                        <div class="col-md-6">
                            <label for="company_address" class="form-label">Company Address</label>
                            <input type="text" class="form-control rounded-0" id="company_address" name="company_address"
                                   value="{{ auth()->user()->company_address ?? '' }}">
                        </div>

                        {{-- VAT Number --}}
                        <div class="col-md-6">
                            <label for="vat_number" class="form-label">VAT Number</label>
                            <input type="text" class="form-control rounded-0" id="vat_number" name="vat_number"
                                   value="{{ auth()->user()->vat_number ?? '' }}">
                        </div>

                        {{-- Tax Number --}}
                        <div class="col-md-6">
                            <label for="tax_number" class="form-label">Tax Number</label>
                            <input type="text" class="form-control rounded-0" id="tax_number" name="tax_number"
                                   value="{{ auth()->user()->tax_number ?? '' }}">
                        </div>

                        {{-- Update Button --}}
                        <div class="col-12 mt-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary rounded-0">Update Information</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
