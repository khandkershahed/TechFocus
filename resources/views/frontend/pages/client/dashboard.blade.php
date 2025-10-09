@extends('frontend.master')
@section('metadata')
@endsection
@section('content')
    <!--Banner -->
    @include('frontend.pages.client.partials.page_header')

    <div class="container">
        <div class="row my-5">
            <div class="col-lg-6 offset-lg-3">
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

                        <h5 class="card-title d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <img src="{{ auth()->user()->profile_image ?? 'https://cdn-icons-png.flaticon.com/512/547/547590.png' }}"
                                     class="shadow-lg border border-2 border-opacity-50 border-success"
                                     width="60px" height="60px" alt="">
                            </div>
                            <div class="fw-bold">
                                My Profile
                            </div>
                        </h5>

                        <h5 class="card-title text-center py-2 bg-light main-color"> My Personal Information</h5>

                        <form class="row g-3 profileValidation pt-3" novalidate>
                            {{-- First Name --}}
                            <div class="col-md-4">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control rounded-0" id="first_name"
                                       placeholder="Enter First Name" name="first_name"
                                       value="{{ auth()->user()->first_name ?? '' }}" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please provide a valid First Name.</div>
                            </div>

                            {{-- Last Name --}}
                            <div class="col-md-4">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control rounded-0" id="last_name"
                                       placeholder="Enter Last Name" name="last_name"
                                       value="{{ auth()->user()->last_name ?? '' }}" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please provide a valid Last Name.</div>
                            </div>

                            {{-- Company --}}
                            <div class="col-md-4">
                                <label for="company" class="form-label">Company</label>
                                <input type="text" class="form-control rounded-0" id="company"
                                       placeholder="Enter Company" name="company"
                                       value="{{ auth()->user()->company ?? '' }}" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please provide a valid Company.</div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control rounded-0" id="email"
                                       placeholder="Enter Email" name="email"
                                       value="{{ auth()->user()->email ?? '' }}" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please provide a valid Email.</div>
                            </div>

                            {{-- Phone Number --}}
                            <div class="col-md-4">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" class="form-control rounded-0" id="phone_number"
                                       placeholder="Enter Number" name="phone_number"
                                       value="{{ auth()->user()->phone_number ?? '' }}" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please provide a valid Phone Number.</div>
                            </div>

                            {{-- City --}}
                            <div class="col-md-4">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control rounded-0" id="city"
                                       placeholder="Enter City" name="city"
                                       value="{{ auth()->user()->city ?? '' }}" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please provide a valid City.</div>
                            </div>

                            {{-- Type of Company --}}
                            <div class="col-md-4">
                                <label for="type_of_company" class="form-label">Type Of Company</label>
                                <select class="form-select rounded-0" id="type_of_company" name="type_of_company" required>
                                    <option disabled value="">Choose...</option>
                                    <option {{ (auth()->user()->type_of_company ?? '') == 'Industrial sub-contractor' ? 'selected' : '' }}>Industrial sub-contractor</option>
                                    <option {{ (auth()->user()->type_of_company ?? '') == 'Design office, R&D' ? 'selected' : '' }}>Design office, R&D</option>
                                    <option {{ (auth()->user()->type_of_company ?? '') == 'Distributor, Retailer' ? 'selected' : '' }}>Distributor, Retailer</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please select a valid Type Of Company.</div>
                            </div>

                            {{-- Sector --}}
                            <div class="col-md-4">
                                <label for="sector" class="form-label">Sector</label>
                                <select class="form-select rounded-0" id="sector" name="sector" required>
                                    <option disabled value="">Choose...</option>
                                    <option {{ (auth()->user()->sector ?? '') == 'Aeronautics' ? 'selected' : '' }}>Aeronautics</option>
                                    <option {{ (auth()->user()->sector ?? '') == 'Agri-food' ? 'selected' : '' }}>Agri-food</option>
                                    <option {{ (auth()->user()->sector ?? '') == 'Automotive' ? 'selected' : '' }}>Automotive</option>
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please select a valid Sector.</div>
                            </div>

                            {{-- Website --}}
                            <div class="col-md-4">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" class="form-control rounded-0" id="website"
                                       placeholder="Enter Website" name="website"
                                       value="{{ auth()->user()->website ?? '' }}" required>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please provide a valid Website URL.</div>
                            </div>

                            {{-- Profile Image --}}
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <div class="col-lg-10">
                                        <div class="mb-3">
                                            <label for="profile_image" class="form-label">Profile Image</label>
                                            <input type="file" class="form-control rounded-0" name="profile_image" aria-label="file example">
                                            <div class="invalid-feedback">Please Choose Your Profile Photo</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <img src="{{ auth()->user()->profile_image ?? 'https://cdn-icons-png.flaticon.com/512/547/547590.png' }}"
                                             class="rounded-circle shadow-lg border border-2 border-opacity-50 border-success"
                                             width="60px" height="60px" alt="">
                                    </div>
                                </div>
                            </div>

                            {{-- Terms --}}
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="invalidCheck" required>
                                    <label class="form-check-label pt-1" for="invalidCheck">
                                        Agree to terms and conditions
                                    </label>
                                    <div class="invalid-feedback">
                                        You must agree before submitting.
                                    </div>
                                </div>
                            </div>

                            {{-- Password Change Accordion --}}
                            <div class="col-lg-12">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <span class="text-primary font-two">If Needed:</span>
                                            <button class="accordion-button collapsed border-0 bg-light" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                    aria-expanded="false" aria-controls="flush-collapseOne">
                                                I Want To Change My Password
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                                             aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="mb-2">
                                                    <label class="pb-2" for="old_password">Enter Old Password</label>
                                                    <input type="password" class="form-control rounded-0"
                                                           placeholder="Enter Your Old Password" name="old_password">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="pb-2" for="new_password">Enter New Password</label>
                                                    <input type="password" class="form-control rounded-0"
                                                           placeholder="Enter Your New Password" name="new_password">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="pb-2" for="confirm_password">Enter Confirm Password</label>
                                                    <input type="password" class="form-control rounded-0"
                                                           placeholder="Enter Confirm Password" name="confirm_password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3 d-flex justify-content-end">
                                <button class="btn signin w-auto rounded-0" type="submit">Update Information</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row p-3">
            <div class="col-lg-12 col-sm-12">
                <p class="sub-color text-center w-75 mx-auto">
                    *Prices are pre-tax. They exclude delivery charges and customs
                    duties and do not include additional charges for installation or
                    activation options. Prices are indicative only and may vary by
                    country, with changes to the cost of raw materials and exchange
                    rates.
                </p>
            </div>
        </div>
    </div>
@endsection
