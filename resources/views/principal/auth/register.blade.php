@extends('frontend.master')

@section('metadata')
@endsection

@section('content')
<section class="d-flex align-items-center justify-content-center" 
         style="min-height: 100vh; background: linear-gradient(135deg, #e3f2fd, #bbdefb);">

    <div class="p-4 border-0 shadow-lg card rounded-4" style="max-width: 700px; width: 100%; background: #fff;">

        <!-- Title -->
        <h3 class="mb-2 text-center fw-bold">Principal Register</h3>
        <p class="mb-4 text-center text-muted">Our multi-step form makes registration easy</p>

        <!-- Progress Steps -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                @foreach([1=>'Company',2=>'Account',3=>'Contact',4=>'Address'] as $stepNumber => $stepName)
                    <div class="step @if($stepNumber==1) active @endif" data-step="{{ $stepNumber }}">
                        <div class="step-circle">{{ $stepNumber }}</div>
                        <small class="step-label">{{ $stepName }}</small>
                    </div>
                    @if($stepNumber != 4)
                        <div class="step-connector @if($stepNumber < 1) active @endif"></div>
                    @endif
                @endforeach
            </div>
        </div>

        <form method="POST" action="{{ route('principal.register.submit') }}" id="multiStepForm">
            @csrf

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Step 1: Company Information -->
            <div class="step-content" id="step-1">
                <h6 class="mb-3 fw-semibold text-primary border-bottom pb-2">COMPANY INFORMATION</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Legal Name <span class="text-danger">*</span></label>
                        <input type="text" name="legal_name" class="form-control" value="{{ old('legal_name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Trading Name</label>
                        <input type="text" name="trading_name" class="form-control" value="{{ old('trading_name') }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Entity Type</label>
                        <select name="entity_type" class="form-select">
                            <option value="">Select Entity Type</option>
                            @foreach(['Manufacturer','Distributor','Supplier','Other'] as $type)
                                <option value="{{ $type }}" @if(old('entity_type')==$type) selected @endif>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Website URL</label>
                        <input type="url" name="website_url" class="form-control" value="{{ old('website_url') }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">HQ City</label>
                        <input type="text" name="hq_city" class="form-control" value="{{ old('hq_city') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Country</label>
                        <select name="country_id" class="form-select country-select" data-index="0" required>
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @endif>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="addresses[0][country_name]" class="country-name" value="{{ old('addresses.0.country_name') }}">
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <div></div>
                    <button type="button" class="btn btn-primary next-step" data-next="2">Next →</button>
                </div>
            </div>

            <!-- Step 2: Account Information -->
            <div class="step-content d-none" id="step-2">
                <h6 class="mb-3 fw-semibold text-primary border-bottom pb-2">ACCOUNT INFORMATION</h6>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Account Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="1">← Previous</button>
                    <button type="button" class="btn btn-primary next-step" data-next="3">Next →</button>
                </div>
            </div>

            <!-- Step 3: Contact Information -->
            <div class="step-content d-none" id="step-3">
                <h6 class="mb-3 fw-semibold text-primary border-bottom pb-2">PRIMARY CONTACT</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contact Name <span class="text-danger">*</span></label>
                        <input type="text" name="contacts[0][contact_name]" class="form-control" value="{{ old('contacts.0.contact_name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Job Title</label>
                        <input type="text" name="contacts[0][job_title]" class="form-control" value="{{ old('contacts.0.job_title') }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contact Email</label>
                        <input type="email" name="contacts[0][email]" class="form-control" value="{{ old('contacts.0.email') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone (E.164)</label>
                        <input type="text" name="contacts[0][phone_e164]" class="form-control" value="{{ old('contacts.0.phone_e164') }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">WhatsApp (E.164)</label>
                        <input type="text" name="contacts[0][whatsapp_e164]" class="form-control" value="{{ old('contacts.0.whatsapp_e164') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">WeChat ID</label>
                        <input type="text" name="contacts[0][wechat_id]" class="form-control" value="{{ old('contacts.0.wechat_id') }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Preferred Channel</label>
                        <select name="contacts[0][preferred_channel]" class="form-select">
                            <option value="">Preferred Channel</option>
                            @foreach(['Email','WhatsApp','WeChat','Phone'] as $channel)
                                <option value="{{ $channel }}" @if(old('contacts.0.preferred_channel')==$channel) selected @endif>{{ $channel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" name="contacts[0][is_primary]" value="1" {{ old('contacts.0.is_primary',1) ? 'checked':'' }}>
                            <label class="form-check-label">Primary Contact</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="button" id="add-contact" class="btn btn-sm btn-outline-secondary">+ Add Another Contact</button>
                </div>
                <div id="additional-contacts" class="mb-3"></div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="2">← Previous</button>
                    <button type="button" class="btn btn-primary next-step" data-next="4">Next →</button>
                </div>
            </div>

            <!-- Step 4: Address & Final Details -->
            <div class="step-content d-none" id="step-4">
                <h6 class="mb-3 fw-semibold text-primary border-bottom pb-2">ADDRESS & FINAL DETAILS</h6>

                <div id="address-wrapper">
                    <div class="address-section" data-index="0">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Address Type</label>
                                <select name="addresses[0][type]" class="form-select">
                                    @foreach(['HQ','Billing','Shipping','Other'] as $type)
                                        <option value="{{ $type }}" @if(old('addresses.0.type')==$type) selected @endif>{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Country</label>
                                <select name="addresses[0][country_id]" class="form-select country-select" data-index="0" required>
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" @if(old('addresses.0.country_id')==$country->id) selected @endif>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="addresses[0][country_name]" class="country-name" value="{{ old('addresses.0.country_name') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Address Line 1 <span class="text-danger">*</span></label>
                            <input type="text" name="addresses[0][line1]" class="form-control" value="{{ old('addresses.0.line1') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Address Line 2</label>
                            <input type="text" name="addresses[0][line2]" class="form-control" value="{{ old('addresses.0.line2') }}">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">City</label>
                                <input type="text" name="addresses[0][city]" class="form-control" value="{{ old('addresses.0.city') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">State</label>
                                <input type="text" name="addresses[0][state]" class="form-control" value="{{ old('addresses.0.state') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Postal Code</label>
                                <input type="text" name="addresses[0][postal]" class="form-control" value="{{ old('addresses.0.postal') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="button" id="add-address" class="btn btn-sm btn-outline-secondary">+ Add Another Address</button>
                </div>
                <div id="additional-addresses" class="mb-3"></div>

                <hr class="my-4">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Message (Optional)</label>
                    <textarea name="message" class="form-control" rows="3">{{ old('message') }}</textarea>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="newsletter" name="newsletter" value="1" {{ old('newsletter') ? 'checked' : '' }}>
                    <label class="form-check-label" for="newsletter">
                        I would like to receive exclusive offers, information, and news from DirectIndustry.
                    </label>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-secondary prev-step" data-prev="3">← Previous</button>
                    <button type="submit" class="btn btn-success">Complete Registration</button>
                </div>
            </div>
        </form>

        <!-- Links -->
        <div class="mt-4 text-center">
            <p class="text-muted">
                Already have an account?
                <a href="{{ route('principal.login') }}" class="fw-semibold text-primary text-decoration-underline">Login here</a>
            </p>
        </div>
    </div>
</section>

@push('scripts')
<script>
let contactIndex = 1;
let addressIndex = 1;
let currentStep = 1;

// Step Navigation
document.querySelectorAll('.next-step').forEach(button => {
    button.addEventListener('click', function() {
        const nextStep = this.getAttribute('data-next');
        goToStep(nextStep);
    });
});
document.querySelectorAll('.prev-step').forEach(button => {
    button.addEventListener('click', function() {
        const prevStep = this.getAttribute('data-prev');
        goToStep(prevStep);
    });
});

function goToStep(step) {
    document.querySelectorAll('.step-content').forEach(content => content.classList.add('d-none'));
    document.getElementById(`step-${step}`).classList.remove('d-none');
    document.querySelectorAll('.step').forEach(stepEl => {
        stepEl.classList.remove('active');
        if(parseInt(stepEl.getAttribute('data-step')) <= step) stepEl.classList.add('active');
    });
    document.querySelectorAll('.step-connector').forEach((connector,index) => {
        connector.classList.remove('active');
        if(index < step-1) connector.classList.add('active');
    });
    currentStep = parseInt(step);
}

// Contact Management
document.getElementById('add-contact').addEventListener('click', function() {
    const wrapper = document.getElementById('additional-contacts');
    const html = `
        <div class="contact-section border-top pt-3 mt-3">
            <h6 class="fw-semibold text-secondary">Additional Contact</h6>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Name</label>
                    <input type="text" name="contacts[${contactIndex}][contact_name]" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Job Title</label>
                    <input type="text" name="contacts[${contactIndex}][job_title]" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Email</label>
                    <input type="email" name="contacts[${contactIndex}][email]" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phone (E.164)</label>
                    <input type="text" name="contacts[${contactIndex}][phone_e164]" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">WhatsApp (E.164)</label>
                    <input type="text" name="contacts[${contactIndex}][whatsapp_e164]" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">WeChat ID</label>
                    <input type="text" name="contacts[${contactIndex}][wechat_id]" class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Preferred Channel</label>
                    <select name="contacts[${contactIndex}][preferred_channel]" class="form-select">
                        <option value="">Preferred Channel</option>
                        <option value="Email">Email</option>
                        <option value="WhatsApp">WhatsApp</option>
                        <option value="WeChat">WeChat</option>
                        <option value="Phone">Phone</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check mt-2">
                        <input type="checkbox" class="form-check-input" name="contacts[${contactIndex}][is_primary]" value="1">
                        <label class="form-check-label">Primary Contact</label>
                    </div>
                </div>
            </div>
        </div>
    `;
    wrapper.insertAdjacentHTML('beforeend', html);
    contactIndex++;
});

// Address Management
document.getElementById('add-address').addEventListener('click', function() {
    const wrapper = document.getElementById('additional-addresses');
    const countryOptions = `@foreach($countries as $country)<option value="{{ $country->id }}">{{ $country->name }}</option>@endforeach`;
    const html = `
        <div class="address-section border-top pt-3 mt-3" data-index="${addressIndex}">
            <h6 class="fw-semibold text-secondary">Additional Address</h6>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Address Type</label>
                    <select name="addresses[${addressIndex}][type]" class="form-select">
                        <option value="HQ">HQ</option>
                        <option value="Billing">Billing</option>
                        <option value="Shipping">Shipping</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Country</label>
                    <select name="addresses[${addressIndex}][country_id]" class="form-select country-select" data-index="${addressIndex}">
                        <option value="">Select Country</option>
                        ${countryOptions}
                    </select>
                    <input type="hidden" name="addresses[${addressIndex}][country_name]" class="country-name">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Address Line 1</label>
                <input type="text" name="addresses[${addressIndex}][line1]" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Address Line 2</label>
                <input type="text" name="addresses[${addressIndex}][line2]" class="form-control">
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">City</label>
                    <input type="text" name="addresses[${addressIndex}][city]" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">State</label>
                    <input type="text" name="addresses[${addressIndex}][state]" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Postal Code</label>
                    <input type="text" name="addresses[${addressIndex}][postal]" class="form-control">
                </div>
            </div>
        </div>
    `;
    wrapper.insertAdjacentHTML('beforeend', html);
    addressIndex++;
});

// Update hidden country_name on change
document.addEventListener('change', function(e){
    if(e.target.classList.contains('country-select')){
        const selectedText = e.target.options[e.target.selectedIndex].text;
        const hiddenInput = e.target.closest('.address-section').querySelector('.country-name');
        if(hiddenInput) hiddenInput.value = selectedText;
    }
});
</script>
@endpush
@endsection
