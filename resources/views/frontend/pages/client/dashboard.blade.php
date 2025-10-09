@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
    <!--Banner -->
    @include('frontend.pages.client.partials.page_header')

    <div class="container">
        <div class="row my-5">
            <div class="col-lg-8 offset-lg-2">
                <div class="card border-0 rounded-0 shadow-sm">
                    <div class="card-body">

                        {{-- Logout Button --}}
                        @auth
                            <div class="d-flex justify-content-end mb-3">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm rounded-0">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @endauth

                        <h5 class="card-title text-center fw-bold mb-3">My Profile</h5>

                        <form class="row g-3 profileValidation" novalidate
                              method="POST" enctype="multipart/form-data"
                              action="{{ route('client.profile.update') }}">
                            @csrf

                            {{-- Profile Photo --}}
                            <div class="col-12 text-center mb-3">
                                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://cdn-icons-png.flaticon.com/512/547/547590.png' }}"
                                     class="rounded-circle shadow-lg border border-2 border-success"
                                     width="100" height="100" alt="Profile Image">
                            </div>
                            <div class="col-12 text-center mb-3">
                                <input type="file" name="profile_image" class="form-control" id="profile_image">
                            </div>

                            {{-- Full Name --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control rounded-0" id="name" name="name"
                                       value="{{ auth()->user()->name ?? '' }}" required>
                            </div>

                            {{-- Username --}}
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control rounded-0" id="username" name="username"
                                       value="{{ auth()->user()->username ?? '' }}">
                            </div>

                            {{-- First Name --}}
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control rounded-0" id="first_name" name="first_name"
                                       value="{{ auth()->user()->first_name ?? '' }}">
                            </div>

                            {{-- Last Name --}}
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control rounded-0" id="last_name" name="last_name"
                                       value="{{ auth()->user()->last_name ?? '' }}">
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

                            {{-- Company Name --}}
                            <div class="col-md-6">
                                <label for="company_name" class="form-label">Company</label>
                                <input type="text" class="form-control rounded-0" id="company_name" name="company_name"
                                       value="{{ auth()->user()->company_name ?? '' }}">
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
                            <div class="col-md-12">
                                <label for="company_address" class="form-label">Company Address</label>
                                <input type="text" class="form-control rounded-0" id="company_address" name="company_address"
                                       value="{{ auth()->user()->company_address ?? '' }}">
                            </div>

                            {{-- City --}}
                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control rounded-0" id="city" name="city"
                                       value="{{ auth()->user()->city ?? '' }}">
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

                            {{-- Trade License Number --}}
                            <div class="col-md-6">
                                <label for="trade_license_number" class="form-label">Trade License Number</label>
                                <input type="text" class="form-control rounded-0" id="trade_license_number" name="trade_license_number"
                                       value="{{ auth()->user()->trade_license_number ?? '' }}">
                            </div>

                            {{-- TIN Number --}}
                            <div class="col-md-6">
                                <label for="tin_number" class="form-label">TIN Number</label>
                                <input type="text" class="form-control rounded-0" id="tin_number" name="tin_number"
                                       value="{{ auth()->user()->tin_number ?? '' }}">
                            </div>

                            {{-- Industry / Product / Solution / Working Country --}}
                            <div class="col-md-6">
                                <label for="industry_id_percentage" class="form-label">Industry IDs</label>
                                <input type="text" class="form-control rounded-0" id="industry_id_percentage" name="industry_id_percentage"
                                       value="{{ auth()->user()->industry_id_percentage ?? '' }}">
                            </div>

                            <div class="col-md-6">
                                <label for="product" class="form-label">Product IDs</label>
                                <input type="text" class="form-control rounded-0" id="product" name="product"
                                       value="{{ auth()->user()->product ?? '' }}">
                            </div>

                            <div class="col-md-6">
                                <label for="solution" class="form-label">Solution IDs</label>
                                <input type="text" class="form-control rounded-0" id="solution" name="solution"
                                       value="{{ auth()->user()->solution ?? '' }}">
                            </div>

                            <div class="col-md-6">
                                <label for="working_country" class="form-label">Working Countries</label>
                                <input type="text" class="form-control rounded-0" id="working_country" name="working_country"
                                       value="{{ auth()->user()->working_country ?? '' }}">
                            </div>

                            {{-- Yearly Revenue --}}
                            <div class="col-md-6">
                                <label for="yearly_revenue" class="form-label">Yearly Revenue</label>
                                <input type="text" class="form-control rounded-0" id="yearly_revenue" name="yearly_revenue"
                                       value="{{ auth()->user()->yearly_revenue ?? '' }}">
                            </div>

                            {{-- Contact Person --}}
                            <div class="col-md-6">
                                <label for="contact_person_name" class="form-label">Contact Person Name</label>
                                <input type="text" class="form-control rounded-0" id="contact_person_name" name="contact_person_name"
                                       value="{{ auth()->user()->contact_person_name ?? '' }}">
                            </div>

                            <div class="col-md-6">
                                <label for="contact_person_email" class="form-label">Contact Person Email</label>
                                <input type="email" class="form-control rounded-0" id="contact_person_email" name="contact_person_email"
                                       value="{{ auth()->user()->contact_person_email ?? '' }}">
                            </div>

                            <div class="col-md-6">
                                <label for="contact_person_phone" class="form-label">Contact Person Phone</label>
                                <input type="text" class="form-control rounded-0" id="contact_person_phone" name="contact_person_phone"
                                       value="{{ auth()->user()->contact_person_phone ?? '' }}">
                            </div>

                            <div class="col-md-6">
                                <label for="contact_person_designation" class="form-label">Contact Person Designation</label>
                                <input type="text" class="form-control rounded-0" id="contact_person_designation" name="contact_person_designation"
                                       value="{{ auth()->user()->contact_person_designation ?? '' }}">
                            </div>

                            {{-- Comments --}}
                            <div class="col-md-12">
                                <label for="comments" class="form-label">Comments</label>
                                <textarea class="form-control rounded-0" id="comments" name="comments">{{ auth()->user()->comments ?? '' }}</textarea>
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
