@extends('principal.layouts.app')

@section('content')
<div class="container">
    @if(session('alert'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            {{ session('alert') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <h5 class="alert-heading">Validation Errors</h5>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <h2 class="h2 mb-4">Edit Profile Information</h2>

    <!-- Company Information Section -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="h5 mb-0">Company Information</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('principal.profile.update') }}">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Legal Name <span class="text-danger">*</span></label>
                        <input type="text" name="legal_name" value="{{ old('legal_name', $principal->legal_name) }}" 
                               class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trading Name</label>
                        <input type="text" name="trading_name" value="{{ old('trading_name', $principal->trading_name) }}" 
                               class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" 
                                value="{{ old('name', $principal->name) }}" 
                                class="form-control" required>
                        </div>


                    <div class="col-md-6 mb-3">
                        <label class="form-label">Entity Type</label>
                        <select name="entity_type" class="form-select">
                            <option value="">-- Select --</option>
                            @foreach(['Manufacturer', 'Distributor', 'Supplier', 'Other'] as $type)
                                <option value="{{ $type }}" {{ old('entity_type', $principal->entity_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Website</label>
                        <input type="url" name="website_url" value="{{ old('website_url', $principal->website_url) }}" 
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">HQ City</label>
                        <input type="text" name="hq_city" value="{{ old('hq_city', $principal->hq_city) }}" 
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country</label>
                        <select name="country_id" class="form-select">
                            <option value="">-- Select Country --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" 
                                    {{ old('country_id', $principal->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Relationship Status</label>
                        <select name="relationship_status" class="form-select">
                            @foreach(['Prospect', 'Active', 'Dormant', 'Closed'] as $status)
                                <option value="{{ $status }}" {{ old('relationship_status', $principal->relationship_status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="4" class="form-control">{{ old('notes', $principal->notes) }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        Save Company Information
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Contacts Section -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="h5 mb-0">Contact Information</h3>
            <button type="button" onclick="addContact()" class="btn btn-success btn-sm">
                + Add Contact
            </button>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('principal.contacts.update') }}" id="contactsForm">
                @csrf
                @method('PUT')
                
                <div id="contacts-container">
                    @foreach($principal->contacts as $index => $contact)
                    <div class="card mb-3">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h4 class="h6 mb-0">Contact {{ $index + 1 }}</h4>
                            @if(!$contact->is_primary && $principal->contacts->count() > 1)
                            <button type="button" onclick="removeContact(this)" class="btn btn-danger btn-sm">
                                Remove
                            </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="contacts[{{ $index }}][id]" value="{{ $contact->id }}">
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contact Name <span class="text-danger">*</span></label>
                                    <input type="text" name="contacts[{{ $index }}][contact_name]" 
                                           value="{{ old("contacts.$index.contact_name", $contact->contact_name) }}" 
                                           class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Job Title</label>
                                    <input type="text" name="contacts[{{ $index }}][job_title]" 
                                           value="{{ old("contacts.$index.job_title", $contact->job_title) }}" 
                                           class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="contacts[{{ $index }}][email]" 
                                           value="{{ old("contacts.$index.email", $contact->email) }}" 
                                           class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone (E.164)</label>
                                    <input type="text" name="contacts[{{ $index }}][phone_e164]" 
                                           value="{{ old("contacts.$index.phone_e164", $contact->phone_e164) }}" 
                                           class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">WhatsApp (E.164)</label>
                                    <input type="text" name="contacts[{{ $index }}][whatsapp_e164]" 
                                           value="{{ old("contacts.$index.whatsapp_e164", $contact->whatsapp_e164) }}" 
                                           class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">WeChat ID</label>
                                    <input type="text" name="contacts[{{ $index }}][wechat_id]" 
                                           value="{{ old("contacts.$index.wechat_id", $contact->wechat_id) }}" 
                                           class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Preferred Channel</label>
                                    <select name="contacts[{{ $index }}][preferred_channel]" 
                                            class="form-select">
                                        <option value="">Select Channel</option>
                                        @foreach(['Email', 'WhatsApp', 'WeChat', 'Phone'] as $channel)
                                            <option value="{{ $channel }}" 
                                                {{ old("contacts.$index.preferred_channel", $contact->preferred_channel) == $channel ? 'selected' : '' }}>
                                                {{ $channel }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-check mt-4">
                                        <input type="checkbox" name="contacts[{{ $index }}][is_primary]" value="1" 
                                               id="primary_contact_{{ $index }}" 
                                               {{ old("contacts.$index.is_primary", $contact->is_primary) ? 'checked' : '' }}
                                               class="form-check-input">
                                        <label for="primary_contact_{{ $index }}" class="form-check-label">
                                            Primary Contact
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        Save Contacts
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Addresses Section -->
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="h5 mb-0">Address Information</h3>
            <button type="button" onclick="addAddress()" class="btn btn-success btn-sm">
                + Add Address
            </button>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('principal.addresses.update') }}" id="addressesForm">
                @csrf
                @method('PUT')
                
                <div id="addresses-container">
                    @foreach($principal->addresses as $index => $address)
                    <div class="card mb-3">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h4 class="h6 mb-0">Address {{ $index + 1 }}</h4>
                            <button type="button" onclick="removeAddress(this)" class="btn btn-danger btn-sm">
                                Remove
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="addresses[{{ $index }}][id]" value="{{ $address->id }}">
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Address Type</label>
                                    <select name="addresses[{{ $index }}][type]" 
                                            class="form-select">
                                        @foreach(['HQ', 'Billing', 'Shipping', 'Other'] as $type)
                                            <option value="{{ $type }}" 
                                                {{ old("addresses.$index.type", $address->type) == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country</label>
                                    <select name="addresses[{{ $index }}][country_id]" 
                                            class="form-select">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" 
                                                {{ old("addresses.$index.country_id", $address->country_id) == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Factory Office<span class="text-danger">*</span></label>
                                    <input type="text" name="addresses[{{ $index }}][line1]" 
                                           value="{{ old("addresses.$index.line1", $address->line1) }}" 
                                           class="form-control" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Warehouse</label>
                                    <input type="text" name="addresses[{{ $index }}][line2]" 
                                           value="{{ old("addresses.$index.line2", $address->line2) }}" 
                                           class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" name="addresses[{{ $index }}][city]" 
                                           value="{{ old("addresses.$index.city", $address->city) }}" 
                                           class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">State</label>
                                    <input type="text" name="addresses[{{ $index }}][state]" 
                                           value="{{ old("addresses.$index.state", $address->state) }}" 
                                           class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" name="addresses[{{ $index }}][postal]" 
                                           value="{{ old("addresses.$index.postal", $address->postal) }}" 
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        Save Addresses
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let contactCount = {{ $principal->contacts->count() }};
let addressCount = {{ $principal->addresses->count() }};

function addContact() {
    const container = document.getElementById('contacts-container');
    const newIndex = contactCount++;
    
    const contactHtml = `
        <div class="card mb-3">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h4 class="h6 mb-0">New Contact</h4>
                <button type="button" onclick="removeContact(this)" class="btn btn-danger btn-sm">
                    Remove
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Name <span class="text-danger">*</span></label>
                        <input type="text" name="contacts[${newIndex}][contact_name]" 
                               class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Job Title</label>
                        <input type="text" name="contacts[${newIndex}][job_title]" 
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="contacts[${newIndex}][email]" 
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone (E.164)</label>
                        <input type="text" name="contacts[${newIndex}][phone_e164]" 
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">WhatsApp (E.164)</label>
                        <input type="text" name="contacts[${newIndex}][whatsapp_e164]" 
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">WeChat ID</label>
                        <input type="text" name="contacts[${newIndex}][wechat_id]" 
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Preferred Channel</label>
                        <select name="contacts[${newIndex}][preferred_channel]" 
                                class="form-select">
                            <option value="">Select Channel</option>
                            <option value="Email">Email</option>
                            <option value="WhatsApp">WhatsApp</option>
                            <option value="WeChat">WeChat</option>
                            <option value="Phone">Phone</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="contacts[${newIndex}][is_primary]" value="1" 
                                   class="form-check-input">
                            <label class="form-check-label">
                                Primary Contact
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', contactHtml);
}

function removeContact(button) {
    button.closest('.card').remove();
}

function addAddress() {
    const container = document.getElementById('addresses-container');
    const newIndex = addressCount++;
    
    const addressHtml = `
        <div class="card mb-3">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h4 class="h6 mb-0">New Address</h4>
                <button type="button" onclick="removeAddress(this)" class="btn btn-danger btn-sm">
                    Remove
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address Type</label>
                        <select name="addresses[${newIndex}][type]" 
                                class="form-select">
                            <option value="HQ">HQ</option>
                            <option value="Billing">Billing</option>
                            <option value="Shipping">Shipping</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country</label>
                        <select name="addresses[${newIndex}][country_id]" 
                                class="form-select">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" name="addresses[${newIndex}][line1]" 
                               class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" name="addresses[${newIndex}][line2]" 
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="addresses[${newIndex}][city]" 
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">State</label>
                        <input type="text" name="addresses[${newIndex}][state]" 
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" name="addresses[${newIndex}][postal]" 
                               class="form-control">
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', addressHtml);
}

function removeAddress(button) {
    button.closest('.card').remove();
}
</script>
@endpush
@endsection