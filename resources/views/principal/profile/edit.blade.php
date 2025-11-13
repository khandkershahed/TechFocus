@extends('principal.layouts.app')

@section('content')
@if(session('alert'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('alert') }}
    </div>
@endif

<h2 class="text-2xl font-semibold mb-6">Edit Profile Information</h2>
<form method="POST" action="{{ route('principal.profile.update') }}">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Legal Name</label>
            <input type="text" name="legal_name" value="{{ old('legal_name', $principal->legal_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Trading Name</label>
            <input type="text" name="trading_name" value="{{ old('trading_name', $principal->trading_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Entity Type</label>
            <select name="entity_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">-- Select --</option>
                @foreach(['Manufacturer', 'Distributor', 'Supplier', 'Other'] as $type)
                    <option value="{{ $type }}" @selected($principal->entity_type == $type)>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Website</label>
            <input type="url" name="website_url" value="{{ old('website_url', $principal->website_url) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">HQ City</label>
            <input type="text" name="hq_city" value="{{ old('hq_city', $principal->hq_city) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Country</label>
                            <select name="country_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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
            <select name="relationship_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @foreach(['Prospect', 'Active', 'Dormant', 'Closed'] as $status)
                    <option value="{{ $status }}" @selected($principal->relationship_status == $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Notes</label>
        <textarea name="notes" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('notes', $principal->notes) }}</textarea>
    </div>

    <div class="flex justify-between items-center mt-4">
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
            Save Changes
        </button>
    </div>
</form>
@endsection
