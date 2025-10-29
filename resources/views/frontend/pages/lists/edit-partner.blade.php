@extends('admin.master')

@section('content')
<div class="container py-5">
    <h2>Edit Partner</h2>

    <form action="{{ route('partner.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Basic Info --}}
        <label>Name</label>
        <input type="text" name="name" value="{{ $partner->name }}" class="form-control mb-3" required>

        <label>Username</label>
        <input type="text" name="username" value="{{ $partner->username }}" class="form-control mb-3">

        <label>Email</label>
        <input type="email" name="email" value="{{ $partner->email }}" class="form-control mb-3" required>

        <label>Phone</label>
        <input type="text" name="phone" value="{{ $partner->phone }}" class="form-control mb-3">

        {{-- Company Info --}}
        <label>Company Name</label>
        <input type="text" name="company" value="{{ $partner->company_name }}" class="form-control mb-3">

        <label>Company Phone Number</label>
        <input type="text" name="company_phone_number" value="{{ $partner->company_phone_number }}" class="form-control mb-3">

        <label>Company URL</label>
        <input type="text" name="company_url" value="{{ $partner->company_url }}" class="form-control mb-3">

        <label>Company Established Date</label>
        <input type="date" name="company_established_date" value="{{ $partner->company_established_date }}" class="form-control mb-3">

        <label>Company Address</label>
        <textarea name="company_address" class="form-control mb-3">{{ $partner->company_address }}</textarea>

        {{-- Location --}}
        <label>City</label>
        <input type="text" name="city" value="{{ $partner->city }}" class="form-control mb-3">

        <label>Postal Code</label>
        <input type="text" name="postal" value="{{ $partner->postal }}" class="form-control mb-3">

        {{-- Tax & Industry --}}
        <label>VAT Number</label>
        <input type="text" name="vat_number" value="{{ $partner->vat_number }}" class="form-control mb-3">

        <label>Tax Number</label>
        <input type="text" name="tax_number" value="{{ $partner->tax_number }}" class="form-control mb-3">

        <label>Trade License Number</label>
        <input type="text" name="trade_license_number" value="{{ $partner->trade_license }}" class="form-control mb-3">

        <label>TIN Number</label>
        <input type="text" name="tin_number" value="{{ $partner->tin_number }}" class="form-control mb-3">

        <label>TIN</label>
        <input type="text" name="tin" value="{{ $partner->tin }}" class="form-control mb-3">

        <label>BIN Certificate</label>
        <input type="text" name="bin_certificate" value="{{ $partner->bin_certificate }}" class="form-control mb-3">

        <label>Audit Paper</label>
        <input type="text" name="audit_paper" value="{{ $partner->audit_paper }}" class="form-control mb-3">

        <label>Industry / ID / Percentage</label>
        <input type="text" name="industry_id_percentage" value="{{ $partner->industry_id_percentage }}" class="form-control mb-3">

        {{-- Product / Solution --}}
        <label>Product</label>
        <input type="text" name="product" value="{{ $partner->product }}" class="form-control mb-3">

        <label>Solution</label>
        <input type="text" name="solution" value="{{ $partner->solution }}" class="form-control mb-3">

        <label>Working Country</label>
        <input type="text" name="working_country" value="{{ $partner->working_country }}" class="form-control mb-3">

        <label>Yearly Revenue</label>
        <input type="text" name="yearly_revenue" value="{{ $partner->yearly_revenue }}" class="form-control mb-3">

        {{-- Contact Person --}}
        <label>Contact Person Name</label>
        <input type="text" name="contact_person_name" value="{{ $partner->contact_person_name }}" class="form-control mb-3">

        <label>Contact Person Email</label>
        <input type="email" name="contact_person_email" value="{{ $partner->contact_person_email }}" class="form-control mb-3">

        <label>Contact Person Phone</label>
        <input type="text" name="contact_person_phone" value="{{ $partner->contact_person_phone }}" class="form-control mb-3">

        <label>Contact Person Address</label>
        <input type="text" name="contact_person_address" value="{{ $partner->contact_person_address }}" class="form-control mb-3">

        <label>Contact Person Designation</label>
        <input type="text" name="contact_person_designation" value="{{ $partner->contact_person_designation }}" class="form-control mb-3">

        {{-- Tier / Status --}}
        <label>Tier</label>
        <input type="text" name="tier" value="{{ $partner->tier }}" class="form-control mb-3">

        <label>Status</label>
        <select name="status" class="form-control mb-3">
            <option value="active" {{ $partner->status=='active'?'selected':'' }}>Active</option>
            <option value="inactive" {{ $partner->status=='inactive'?'selected':'' }}>Inactive</option>
            <option value="suspended" {{ $partner->status=='suspended'?'selected':'' }}>Suspended</option>
            <option value="disabled" {{ $partner->status=='disabled'?'selected':'' }}>Disabled</option>
        </select>

        <label>Comments</label>
        <textarea name="comments" class="form-control mb-3">{{ $partner->comments }}</textarea>

        {{-- Profile Image --}}
        <label>Profile Image</label>
        <input type="file" name="profile_image" class="form-control mb-3">

        <label>Country</label>
        <select name="country_id" class="form-control mb-3">
            <option value="">Select Country</option>
            @foreach(\App\Models\Country::all() as $country)
                <option value="{{ $country->id }}" {{ $partner->country_id==$country->id?'selected':'' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-success">Update Partner</button>
    </form>
</div>
@endsection
