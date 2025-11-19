@extends('principal.layouts.app')

@section('content')
@if(session('alert'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('alert') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2 class="text-2xl font-semibold mb-6">Edit Profile Information</h2>

<!-- Company Information Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4 text-primary border-b pb-2">Company Information</h3>
    
    <form method="POST" action="{{ route('principal.profile.update') }}">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Legal Name <span class="text-red-500">*</span></label>
                <input type="text" name="legal_name" value="{{ old('legal_name', $principal->legal_name) }}" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Trading Name</label>
                <input type="text" name="trading_name" value="{{ old('trading_name', $principal->trading_name) }}" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Entity Type</label>
                <select name="entity_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Select --</option>
                    @foreach(['Manufacturer', 'Distributor', 'Supplier', 'Other'] as $type)
                        <option value="{{ $type }}" {{ old('entity_type', $principal->entity_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Website</label>
                <input type="url" name="website_url" value="{{ old('website_url', $principal->website_url) }}" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">HQ City</label>
                <input type="text" name="hq_city" value="{{ old('hq_city', $principal->hq_city) }}" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Country</label>
                <select name="country_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Select Country --</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" 
                            {{ old('country_id', $principal->country_id) == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Relationship Status</label>
                <select name="relationship_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach(['Prospect', 'Active', 'Dormant', 'Closed'] as $status)
                        <option value="{{ $status }}" {{ old('relationship_status', $principal->relationship_status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Notes</label>
            <textarea name="notes" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes', $principal->notes) }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                Save Company Information
            </button>
        </div>
    </form>
</div>

<!-- Contacts Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-primary border-b pb-2">Contact Information</h3>
        <button type="button" onclick="addContact()" class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-1 px-3 rounded">
            + Add Contact
        </button>
    </div>

    <form method="POST" action="{{ route('principal.contacts.update') }}" id="contactsForm">
        @csrf
        @method('PUT')
        
        <div id="contacts-container">
            @foreach($principal->contacts as $index => $contact)
            <div class="contact-section border rounded-lg p-4 mb-4">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-medium text-gray-700">Contact {{ $index + 1 }}</h4>
                    @if(!$contact->is_primary && $principal->contacts->count() > 1)
                    <button type="button" onclick="removeContact(this)" class="text-red-600 hover:text-red-800 text-sm">
                        Remove
                    </button>
                    @endif
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="hidden" name="contacts[{{ $index }}][id]" value="{{ $contact->id }}">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contact Name <span class="text-red-500">*</span></label>
                        <input type="text" name="contacts[{{ $index }}][contact_name]" 
                               value="{{ old("contacts.$index.contact_name", $contact->contact_name) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Job Title</label>
                        <input type="text" name="contacts[{{ $index }}][job_title]" 
                               value="{{ old("contacts.$index.job_title", $contact->job_title) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="contacts[{{ $index }}][email]" 
                               value="{{ old("contacts.$index.email", $contact->email) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone (E.164)</label>
                        <input type="text" name="contacts[{{ $index }}][phone_e164]" 
                               value="{{ old("contacts.$index.phone_e164", $contact->phone_e164) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">WhatsApp (E.164)</label>
                        <input type="text" name="contacts[{{ $index }}][whatsapp_e164]" 
                               value="{{ old("contacts.$index.whatsapp_e164", $contact->whatsapp_e164) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">WeChat ID</label>
                        <input type="text" name="contacts[{{ $index }}][wechat_id]" 
                               value="{{ old("contacts.$index.wechat_id", $contact->wechat_id) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Preferred Channel</label>
                        <select name="contacts[{{ $index }}][preferred_channel]" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Channel</option>
                            @foreach(['Email', 'WhatsApp', 'WeChat', 'Phone'] as $channel)
                                <option value="{{ $channel }}" 
                                    {{ old("contacts.$index.preferred_channel", $contact->preferred_channel) == $channel ? 'selected' : '' }}>
                                    {{ $channel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <div class="flex items-center h-10">
                            <input type="checkbox" name="contacts[{{ $index }}][is_primary]" value="1" 
                                   id="primary_contact_{{ $index }}" 
                                   {{ old("contacts.$index.is_primary", $contact->is_primary) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="primary_contact_{{ $index }}" class="ml-2 text-sm font-medium text-gray-700">
                                Primary Contact
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                Save Contacts
            </button>
        </div>
    </form>
</div>

<!-- Addresses Section -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-primary border-b pb-2">Address Information</h3>
        <button type="button" onclick="addAddress()" class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-1 px-3 rounded">
            + Add Address
        </button>
    </div>

    <form method="POST" action="{{ route('principal.addresses.update') }}" id="addressesForm">
        @csrf
        @method('PUT')
        
        <div id="addresses-container">
            @foreach($principal->addresses as $index => $address)
            <div class="address-section border rounded-lg p-4 mb-4">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-medium text-gray-700">Address {{ $index + 1 }}</h4>
                    <button type="button" onclick="removeAddress(this)" class="text-red-600 hover:text-red-800 text-sm">
                        Remove
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="hidden" name="addresses[{{ $index }}][id]" value="{{ $address->id }}">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Address Type</label>
                        <select name="addresses[{{ $index }}][type]" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach(['HQ', 'Billing', 'Shipping', 'Other'] as $type)
                                <option value="{{ $type }}" 
                                    {{ old("addresses.$index.type", $address->type) == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Country</label>
                        <select name="addresses[{{ $index }}][country_id]" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" 
                                    {{ old("addresses.$index.country_id", $address->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Address Line 1 <span class="text-red-500">*</span></label>
                        <input type="text" name="addresses[{{ $index }}][line1]" 
                               value="{{ old("addresses.$index.line1", $address->line1) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Address Line 2</label>
                        <input type="text" name="addresses[{{ $index }}][line2]" 
                               value="{{ old("addresses.$index.line2", $address->line2) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">City</label>
                        <input type="text" name="addresses[{{ $index }}][city]" 
                               value="{{ old("addresses.$index.city", $address->city) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">State</label>
                        <input type="text" name="addresses[{{ $index }}][state]" 
                               value="{{ old("addresses.$index.state", $address->state) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Postal Code</label>
                        <input type="text" name="addresses[{{ $index }}][postal]" 
                               value="{{ old("addresses.$index.postal", $address->postal) }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                Save Addresses
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
let contactCount = {{ $principal->contacts->count() }};
let addressCount = {{ $principal->addresses->count() }};

function addContact() {
    const container = document.getElementById('contacts-container');
    const newIndex = contactCount++;
    
    const contactHtml = `
        <div class="contact-section border rounded-lg p-4 mb-4">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-medium text-gray-700">New Contact</h4>
                <button type="button" onclick="removeContact(this)" class="text-red-600 hover:text-red-800 text-sm">
                    Remove
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact Name <span class="text-red-500">*</span></label>
                    <input type="text" name="contacts[${newIndex}][contact_name]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Job Title</label>
                    <input type="text" name="contacts[${newIndex}][job_title]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="contacts[${newIndex}][email]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone (E.164)</label>
                    <input type="text" name="contacts[${newIndex}][phone_e164]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">WhatsApp (E.164)</label>
                    <input type="text" name="contacts[${newIndex}][whatsapp_e164]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">WeChat ID</label>
                    <input type="text" name="contacts[${newIndex}][wechat_id]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Preferred Channel</label>
                    <select name="contacts[${newIndex}][preferred_channel]" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Channel</option>
                        <option value="Email">Email</option>
                        <option value="WhatsApp">WhatsApp</option>
                        <option value="WeChat">WeChat</option>
                        <option value="Phone">Phone</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <div class="flex items-center h-10">
                        <input type="checkbox" name="contacts[${newIndex}][is_primary]" value="1" 
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label class="ml-2 text-sm font-medium text-gray-700">
                            Primary Contact
                        </label>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', contactHtml);
}

function removeContact(button) {
    button.closest('.contact-section').remove();
}

function addAddress() {
    const container = document.getElementById('addresses-container');
    const newIndex = addressCount++;
    
    const addressHtml = `
        <div class="address-section border rounded-lg p-4 mb-4">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-medium text-gray-700">New Address</h4>
                <button type="button" onclick="removeAddress(this)" class="text-red-600 hover:text-red-800 text-sm">
                    Remove
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Address Type</label>
                    <select name="addresses[${newIndex}][type]" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="HQ">HQ</option>
                        <option value="Billing">Billing</option>
                        <option value="Shipping">Shipping</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Country</label>
                    <select name="addresses[${newIndex}][country_id]" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Address Line 1 <span class="text-red-500">*</span></label>
                    <input type="text" name="addresses[${newIndex}][line1]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Address Line 2</label>
                    <input type="text" name="addresses[${newIndex}][line2]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" name="addresses[${newIndex}][city]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">State</label>
                    <input type="text" name="addresses[${newIndex}][state]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Postal Code</label>
                    <input type="text" name="addresses[${newIndex}][postal]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', addressHtml);
}

function removeAddress(button) {
    button.closest('.address-section').remove();
}
</script>
@endpush
@endsection