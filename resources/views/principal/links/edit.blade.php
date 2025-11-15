@extends('principal.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-xl font-semibold mb-4">Edit Links</h1>

    <form action="{{ route('principal.links.update', $link->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div id="links-container" class="space-y-4">
            @foreach($link->label as $index => $label)
            <div class="link-row flex space-x-2 items-end border p-3 rounded" data-index="{{ $index }}">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Label</label>
                    <input type="text" name="links[{{ $index }}][label]" 
                           value="{{ $label }}" class="block w-full border rounded px-2 py-1" required>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">URL</label>
                    <input type="url" name="links[{{ $index }}][url]" 
                           value="{{ $link->url[$index] ?? '' }}" class="block w-full border rounded px-2 py-1" required>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Type</label>
                    <select name="links[{{ $index }}][type]" class="block w-full border rounded px-2 py-1">
                        @foreach($types as $type)
                            <option value="{{ $type }}" 
                                {{ ($link->type[$index] ?? '') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Files</label>
                    <input type="file" name="links[{{ $index }}][files][]" multiple 
                           class="block w-full border rounded px-2 py-1">
                    @if(isset($link->file[$index]) && count($link->file[$index]) > 0)
                        <div class="text-xs text-gray-600 mt-1">
                            Existing files: {{ count($link->file[$index]) }}
                        </div>
                    @endif
                </div>
                @if($index > 0)
                <div>
                    <button type="button" onclick="removeLinkRow(this)" class="bg-red-500 text-white px-3 py-2 rounded">-</button>
                </div>
                @else
                <div>
                    <button type="button" onclick="addLinkRow()" class="bg-green-500 text-white px-3 py-2 rounded">+</button>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Update Links</button>
    </form>
</div>

<script>
// Same JavaScript as create form
let rowIndex = {{ count($link->label) - 1 }};

function addLinkRow() {
    rowIndex++;
    const container = document.getElementById('links-container');
    const div = document.createElement('div');
    div.classList.add('link-row', 'flex', 'space-x-2', 'items-end', 'border', 'p-3', 'rounded');
    div.setAttribute('data-index', rowIndex);
    div.innerHTML = `
        <div class="flex-1">
            <label class="block text-sm font-medium mb-1">Label</label>
            <input type="text" name="links[${rowIndex}][label]" class="block w-full border rounded px-2 py-1" required>
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium mb-1">URL</label>
            <input type="url" name="links[${rowIndex}][url]" class="block w-full border rounded px-2 py-1" required>
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium mb-1">Type</label>
            <select name="links[${rowIndex}][type]" class="block w-full border rounded px-2 py-1">
                @foreach($types as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium mb-1">Files</label>
            <input type="file" name="links[${rowIndex}][files][]" multiple class="block w-full border rounded px-2 py-1">
        </div>
        <div>
            <button type="button" onclick="removeLinkRow(this)" class="bg-red-500 text-white px-3 py-2 rounded">-</button>
        </div>
    `;
    container.appendChild(div);
}

function removeLinkRow(button) {
    const row = button.closest('.link-row');
    if (row && row.getAttribute('data-index') !== '0') {
        row.remove();
    }
}
</script>
@endsection