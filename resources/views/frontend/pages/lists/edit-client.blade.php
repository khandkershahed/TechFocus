@extends('admin.master')

@section('content')
<div class="container py-5">
    <h2>Edit Client</h2>

    <form action="{{ route('client.update', $client->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Basic Info --}}
        <label>Name</label>
        <input type="text" name="name" value="{{ $client->name }}" class="form-control mb-3" required>

        <label>Username</label>
        <input type="text" name="username" value="{{ $client->username }}" class="form-control mb-3">

        <label>Email</label>
        <input type="email" name="email" value="{{ $client->email }}" class="form-control mb-3" required>

        <label>Phone</label>
        <input type="text" name="phone" value="{{ $client->phone }}" class="form-control mb-3">

        {{-- Company Info --}}
        <label>Company Name</label>
        <input type="text" name="company_name" value="{{ $client->company_name }}" class="form-control mb-3">

        <label>Company Phone Number</label>
        <input type="text" name="company_phone_number" value="{{ $client->company_phone_number }}" class="form-control mb-3">

        <label>Company URL</label>
        <input type="text" name="company_url" value="{{ $client->company_url }}" class="form-control mb-3">

        <label>Company Established Date</label>
        <input type="date" name="company_established_date" value="{{ $client->company_established_date }}" class="form-control mb-3">

        <label>Company Address</label>
        <textarea name="company_address" class="form-control mb-3">{{ $client->company_address }}</textarea>

        {{-- Location --}}
        <label>City</label>
        <input type="text" name="city" value="{{ $client->city }}" class="form-control mb-3">

        <label>Postal Code</label>
        <input type="text" name="postal" value="{{ $client->postal }}" class="form-control mb-3">

        {{-- Tax & Industry --}}
        <label>VAT Number</label>
        <input type="text" name="vat_number" value="{{ $client->vat_number }}" class="form-control mb-3">

        <label>Tax Number</label>
        <input type="text" name="tax_number" value="{{ $client->tax_number }}" class="form-control mb-3">

        <label>Trade License Number</label>
        <input type="text" name="trade_license_number" value="{{ $client->trade_license_number }}" class="form-control mb-3">

        <label>TIN Number</label>
        <input type="text" name="tin_number" value="{{ $client->tin_number }}" class="form-control mb-3">

        <label>Industry / ID / Percentage</label>
        <input type="text" name="industry_id_percentage" value="{{ $client->industry_id_percentage }}" class="form-control mb-3">

        {{-- Product / Solution --}}
        <label>Product</label>
        <input type="text" name="product" value="{{ $client->product }}" class="form-control mb-3">

        <label>Solution</label>
        <input type="text" name="solution" value="{{ $client->solution }}" class="form-control mb-3">

        <label>Working Country</label>
        <input type="text" name="working_country" value="{{ $client->working_country }}" class="form-control mb-3">

        <label>Yearly Revenue</label>
        <input type="text" name="yearly_revenue" value="{{ $client->yearly_revenue }}" class="form-control mb-3">

        {{-- Contact Person --}}
        <label>Contact Person Name</label>
        <input type="text" name="contact_person_name" value="{{ $client->contact_person_name }}" class="form-control mb-3">

        <label>Contact Person Email</label>
        <input type="email" name="contact_person_email" value="{{ $client->contact_person_email }}" class="form-control mb-3">

        <label>Contact Person Phone</label>
        <input type="text" name="contact_person_phone" value="{{ $client->contact_person_phone }}" class="form-control mb-3">

        <label>Contact Person Designation</label>
        <input type="text" name="contact_person_designation" value="{{ $client->contact_person_designation }}" class="form-control mb-3">

        {{-- Status & Comments --}}
        <label>Status</label>
        <select name="status" class="form-control mb-3">
            <option value="active" {{ $client->status=='active'?'selected':'' }}>Active</option>
            <option value="inactive" {{ $client->status=='inactive'?'selected':'' }}>Inactive</option>
            <option value="suspended" {{ $client->status=='suspended'?'selected':'' }}>Suspended</option>
            <option value="disabled" {{ $client->status=='disabled'?'selected':'' }}>Disabled</option>
        </select>

        <label>Comments</label>
        <textarea name="comments" class="form-control mb-3">{{ $client->comments }}</textarea>

        {{-- Profile Image --}}
        <label>Profile Image</label>
        <input type="file" name="profile_image" class="form-control mb-3">

        <button class="btn btn-success">Update Client</button>
    </form>
</div>
@endsection
