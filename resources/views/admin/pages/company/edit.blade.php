@extends('admin.master')
@section('content')
<div class="container-fluid h-100">
    <div class="row">
        <div class="col-lg-12 card rounded-0 shadow-sm px-0">
            <div class="card card-flush">
                <div class="card-header align-items-center gap-2 gap-md-5 shadow-lg bg-light-primary px-0"
                     style="min-height: 45px;">
                    <div class="container-fluid px-3">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-sm-12 text-lg-start text-sm-center">
                                <div class="card-title ps-3">
                                    <h2 class="text-start">Company Edit Form</h2>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 text-lg-end text-sm-center">
                                <a href="{{ route('admin.company.index') }}"
                                   class="btn btn-icon btn-primary w-auto px-3 rounded-0">
                                    <i class="las la-arrow-left fs-2 me-2"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.company.update', $company->id) }}" class="needs-validation"
                          method="post" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="container-fluid px-2">
                            <div class="row">
                                {{-- Name --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Name</label>
                                    <input type="text" name="name" class="form-control form-control-solid form-control-sm"
                                           value="{{ old('name', $company->name) }}" placeholder="E.g: Your Company Name" required>
                                    <div class="invalid-feedback">Please provide a Name.</div>
                                </div>

                                {{-- Industry --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Industry</label>
                                    <select name="industry[]" id ="industry[]"class="form-select form-select-solid form-select-sm" multiple  data-control="select2">
                                        @foreach (getIndustry() as $industry)
                                            <option value="{{ $industry->id }}"
                                                @selected(in_array($industry->id, (array)json_decode($company->industry, true))) >
                                                {{ $industry->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Country --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Country</label>
                                    <select name="country[]" id ="country[]" class="form-select form-select-solid form-select-sm" multiple data-control="select2">
                                        @foreach (getAllCountry() as $country)
                                            <option value="{{ $country->id }}"
                                                @selected(in_array($country->id, (array)json_decode($company->country, true)))>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Location / Address --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Location</label>
                                    <select name="location[]" id="location[]" class="form-select form-select-solid form-select-sm" multiple data-control="select2"> 
                                        @foreach (getAddress() as $address)
                                            <option value="{{ $address->id }}"
                                                @selected(in_array($address->id, (array)json_decode($company->address, true)))>
                                                {{ $address->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Phone --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Phone</label>
                                    <input type="text" name="phone" class="form-control form-control-solid form-control-sm"
                                           value="{{ old('phone', $company->phone) }}" placeholder="E.g: 017 **** ****">
                                </div>

                                {{-- Email --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Email</label>
                                    <input type="email" name="email" class="form-control form-control-solid form-control-sm"
                                           value="{{ old('email', $company->email) }}" placeholder="E.g: yourmail@mail.com">
                                </div>

                                {{-- Website --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Website URL</label>
                                    <input type="text" name="website_url" class="form-control form-control-solid form-control-sm"
                                           value="{{ old('website_url', $company->website_url) }}" placeholder="E.g: example.com">
                                </div>

                                {{-- Logo --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Logo</label>
                                    <input type="file" name="logo" class="form-control form-control-solid form-control-sm">
                                    @if ($company->logo)
                                        <img src="{{ asset('storage/' . $company->logo) }}" alt="logo" class="mt-2" width="50">
                                    @endif
                                </div>

                                {{-- Postal Code --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Postal Code</label>
                                    <input type="text" name="postal_code" class="form-control form-control-solid form-control-sm"
                                           value="{{ old('postal_code', $company->postal_code) }}">
                                </div>

                                {{-- Contact Name --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Contact Name</label>
                                    <input type="text" name="contact_name" class="form-control form-control-solid form-control-sm"
                                           value="{{ old('contact_name', $company->contact_name) }}">
                                </div>

                                {{-- Contact Email --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Contact Email</label>
                                    <input type="email" name="contact_email" class="form-control form-control-solid form-control-sm"
                                           value="{{ old('contact_email', $company->contact_email) }}">
                                </div>

                                {{-- Contact Phone --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Contact Phone</label>
                                    <input type="text" name="contact_phone" class="form-control form-control-solid form-control-sm"
                                           value="{{ old('contact_phone', $company->contact_phone) }}">
                                </div>

                                {{-- Headquarter Country --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Headquarter Country</label>
                                    <select name="headquarter_country_id" class="form-select form-select-solid form-select-sm">
                                        <option value="">Select Country</option>
                                        @foreach (getAllCountry() as $country)
                                            <option value="{{ $country->id }}"
                                                @selected($company->headquarter_country_id == $country->id)>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Founder --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Founder</label>
                                    <input type="text" name="founder" class="form-control form-control-solid form-control-sm"
                                           value="{{ old('founder', $company->founder) }}">
                                </div>

                                {{-- CEO --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">CEO</label>
                                    <input type="text" name="ceo" class="form-control form-control-solid form-control-sm"
                                           value="{{ old('ceo', $company->ceo) }}">
                                </div>

                                {{-- Year Founded --}}
                                <div class="col-lg-3 mb-2">
                                    <label class="form-label mb-0">Year Founded</label>
                                    <input type="number" name="year_founded" class="form-control form-control-solid form-control-sm"
                                           value="{{ old('year_founded', $company->year_founded) }}" min="1000" max="9999">
                                </div>

                                {{-- Headquarter --}}
                                <div class="col-lg-12 mb-2">
                                    <label class="form-label mb-0">Headquarter</label>
                                    <textarea name="headquarter" rows="1" class="form-control form-control-solid">{{ old('headquarter', $company->headquarter) }}</textarea>
                                </div>

                                {{-- Mission --}}
                                <div class="col-lg-12 mb-2">
                                    <label class="form-label mb-0">Mission</label>
                                    <textarea name="mission" class="form-control form-control-solid">{!! old('mission', $company->mission) !!}</textarea>
                                </div>

                                {{-- Vision --}}
                                <div class="col-lg-12 mb-2">
                                    <label class="form-label mb-0">Vision</label>
                                    <textarea name="vision" class="form-control form-control-solid">{!! old('vision', $company->vision) !!}</textarea>
                                </div>

                                {{-- History --}}
                                <div class="col-lg-12 mb-2">
                                    <label class="form-label mb-0">History</label>
                                    <textarea name="history" class="form-control form-control-solid">{!! old('history', $company->history) !!}</textarea>
                                </div>

                                {{-- About --}}
                                <div class="col-lg-12 mb-2">
                                    <label class="form-label mb-0">About</label>
                                    <textarea name="about" class="form-control form-control-solid">{!! old('about', $company->about) !!}</textarea>
                                </div>

                                {{-- Submit Button --}}
                                <div class="col-lg-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-sm btn-light-primary rounded-0">
                                        Update Company
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
