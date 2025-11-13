@extends('principal.layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-xl font-semibold mb-4">Share a New Link</h1>

    <form action="{{ route('principal.links.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="label" class="block text-sm font-medium text-gray-700">Label</label>
            <input type="text" name="label" id="label" 
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                   value="{{ old('label') }}" required>
            @error('label')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
            <input type="url" name="url" id="url" 
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                   value="{{ old('url') }}" required>
            @error('url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <button type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
            Share Link
        </button>
    </form>
</div>
@endsection
