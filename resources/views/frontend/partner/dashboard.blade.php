@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
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

                    <div class="text-center mb-3">
                        <img src="{{ auth()->user()->profile_image ?? 'https://cdn-icons-png.flaticon.com/512/547/547590.png' }}"
                             class="rounded-circle shadow-lg border border-2 border-success"
                             width="80px" height="80px" alt="Profile Image">
                    </div>

                    <form class="row g-3 profileValidation" novalidate>
                        {{-- First Name --}}
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control rounded-0" id="first_name"
                                   value="{{ auth()->user()->first_name ?? '' }}">
                        </div>

                        {{-- Last Name --}}
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control rounded-0" id="last_name"
                                   value="{{ auth()->user()->last_name ?? '' }}">
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control rounded-0" id="email"
                                   value="{{ auth()->user()->email ?? '' }}">
                        </div>

                        {{-- Phone Number --}}
                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control rounded-0" id="phone_number"
                                   value="{{ auth()->user()->phone_number ?? '' }}">
                        </div>

                        {{-- Company --}}
                        <div class="col-md-6">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control rounded-0" id="company"
                                   value="{{ auth()->user()->company ?? '' }}">
                        </div>

                        {{-- City --}}
                        <div class="col-md-6">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control rounded-0" id="city"
                                   value="{{ auth()->user()->city ?? '' }}">
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
