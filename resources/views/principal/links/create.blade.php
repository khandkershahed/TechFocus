@extends('principal.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-xl font-semibold mb-4">Share New Links</h1>

    <form action="{{ route('principal.links.store') }}" method="POST">
        @csrf

        <!-- Links Container -->
        <div id="links-container" class="mb-4">
            <div class="flex space-x-2 mb-2 items-end">
                <!-- Label -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Label</label>
                    <input type="text" name="label[]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                           placeholder="Enter label" required>
                </div>

                <!-- URL -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">URL</label>
                    <input type="url" name="url[]" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                           placeholder="Enter URL" required>
                </div>

                <!-- Type -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="type[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @foreach($types as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Add/Remove button -->
                <div class="flex-shrink-0">
                    <button type="button" onclick="addLinkRow()" 
                            class="bg-green-500 text-white px-3 py-2 rounded">+</button>
                </div>
            </div>
        </div>

        <button type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
            Share Links
        </button>
    </form>
</div>

<!-- Dynamic input scripts -->
<script>
function addLinkRow() {
    const container = document.getElementById('links-container');
    const div = document.createElement('div');
    div.classList.add('flex', 'space-x-2', 'mb-2', 'items-end');
    div.innerHTML = `
        <div class="flex-1">
            <input type="text" name="label[]" 
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                   placeholder="Enter label" required>
        </div>
        <div class="flex-1">
            <input type="url" name="url[]" 
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                   placeholder="Enter URL" required>
        </div>
        <div class="flex-1">
            <select name="type[]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @foreach($types as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-shrink-0">
            <button type="button" onclick="this.parentNode.parentNode.remove()" 
                    class="bg-red-500 text-white px-3 py-2 rounded">-</button>
        </div>
    `;
    container.appendChild(div);
}
</script>
@endsection
