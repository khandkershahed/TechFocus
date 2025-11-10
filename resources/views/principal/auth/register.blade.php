@extends('frontend.master')

@section('metadata')
@endsection

@section('content')

<section class="d-flex align-items-center justify-content-center" 
         style="min-height: 100vh; background: linear-gradient(135deg, #e3f2fd, #bbdefb);">

    <div class="p-4 border-0 shadow-lg card rounded-4" style="max-width: 450px; width: 100%; background: #fff;">

        <!-- Title -->
        <h3 class="mb-2 text-center fw-bold">Principal Register</h3>
        <p class="mb-4 text-center text-muted">
            Create your account to get started
        </p>

       <form method="POST" action="{{ route('principal.register.submit') }}">
    @csrf

    <!-- Principal Basics -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Legal Name <span class="text-danger">*</span></label>
        <input type="text" name="legal_name" class="form-control" value="{{ old('legal_name') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Trading Name</label>
        <input type="text" name="trading_name" class="form-control" value="{{ old('trading_name') }}">
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Entity Type</label>
        <select name="entity_type" class="form-select">
            <option value="">Select Entity Type</option>
            <option value="Manufacturer">Manufacturer</option>
            <option value="Distributor">Distributor</option>
            <option value="Supplier">Supplier</option>
            <option value="Other">Other</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Website URL</label>
        <input type="url" name="website_url" class="form-control" value="{{ old('website_url') }}">
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">HQ City</label>
        <input type="text" name="hq_city" class="form-control" value="{{ old('hq_city') }}">
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Country</label>
        <select name="country_iso" class="form-select">
            <option value="">Select Country</option>
            @foreach($countries as $country)
                <option value="{{ $country->iso }}">{{ $country->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Email & Password -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <hr>

    <!-- Contacts (multiple) -->
    <h5>Contacts</h5>
    <div id="contacts-wrapper">
        <div class="contact-row mb-3">
            <input type="text" name="contacts[0][contact_name]" placeholder="Contact Name" class="form-control mb-1" required>
            <input type="text" name="contacts[0][job_title]" placeholder="Job Title" class="form-control mb-1">
            <input type="email" name="contacts[0][email]" placeholder="Email" class="form-control mb-1">
            <input type="text" name="contacts[0][phone_e164]" placeholder="Phone (E.164)" class="form-control mb-1">
            <input type="text" name="contacts[0][whatsapp_e164]" placeholder="WhatsApp (E.164)" class="form-control mb-1">
            <input type="text" name="contacts[0][wechat_id]" placeholder="WeChat ID" class="form-control mb-1">
            <select name="contacts[0][preferred_channel]" class="form-select mb-1">
                <option value="">Preferred Channel</option>
                <option value="Email">Email</option>
                <option value="WhatsApp">WhatsApp</option>
                <option value="WeChat">WeChat</option>
                <option value="Phone">Phone</option>
            </select>
            <label>
                <input type="checkbox" name="contacts[0][is_primary]" value="1"> Primary
            </label>
        </div>
    </div>
    <button type="button" id="add-contact" class="btn btn-sm btn-secondary mb-3">Add Another Contact</button>

    <hr>

    <!-- Addresses (multiple) -->
    <h5>Addresses</h5>
    <div id="addresses-wrapper">
        <div class="address-row mb-3">
            <select name="addresses[0][type]" class="form-select mb-1">
                <option value="HQ">HQ</option>
                <option value="Billing">Billing</option>
                <option value="Shipping">Shipping</option>
                <option value="Other">Other</option>
            </select>
            <input type="text" name="addresses[0][line1]" placeholder="Address Line 1" class="form-control mb-1" required>
            <input type="text" name="addresses[0][line2]" placeholder="Address Line 2" class="form-control mb-1">
            <input type="text" name="addresses[0][city]" placeholder="City" class="form-control mb-1">
            <input type="text" name="addresses[0][state]" placeholder="State" class="form-control mb-1">
            <input type="text" name="addresses[0][postal]" placeholder="Postal Code" class="form-control mb-1">
            <select name="addresses[0][country_iso]" class="form-select mb-1">
                @foreach($countries as $country)
                    <option value="{{ $country->iso }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button type="button" id="add-address" class="btn btn-sm btn-secondary mb-3">Add Another Address</button>

    <!-- Submit -->
    <button type="submit" class="btn btn-primary w-100 btn-lg">Register</button>
</form>

        <!-- Links -->
        <div class="mt-4 text-center">
            <p class="text-muted">
                Already have an account?
                <a href="{{ route('principal.login') }}" 
                   class="fw-semibold text-primary text-decoration-underline">
                    Login here
                </a>
            </p>
        </div>

    </div>

</section>
@endsection


{{-- JS to clone contact/address rows --}}
@push('scripts')
<script>
let contactIndex = 1;
let addressIndex = 1;

document.getElementById('add-contact').addEventListener('click', function() {
    let wrapper = document.getElementById('contacts-wrapper');
    let newRow = wrapper.querySelector('.contact-row').cloneNode(true);
    newRow.querySelectorAll('input, select').forEach(input => {
        let name = input.getAttribute('name');
        input.setAttribute('name', name.replace(/\d+/, contactIndex));
        if(input.type !== 'checkbox') input.value = '';
        if(input.type === 'checkbox') input.checked = false;
    });
    wrapper.appendChild(newRow);
    contactIndex++;
});

document.getElementById('add-address').addEventListener('click', function() {
    let wrapper = document.getElementById('addresses-wrapper');
    let newRow = wrapper.querySelector('.address-row').cloneNode(true);
    newRow.querySelectorAll('input, select').forEach(input => {
        let name = input.getAttribute('name');
        input.setAttribute('name', name.replace(/\d+/, addressIndex));
        if(input.tagName === 'INPUT') input.value = '';
        if(input.tagName === 'SELECT') input.selectedIndex = 0;
    });
    wrapper.appendChild(newRow);
    addressIndex++;
});
</script>
@endpush