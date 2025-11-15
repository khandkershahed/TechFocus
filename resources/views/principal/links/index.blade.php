@extends('principal.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6">

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Shared Links</h1>

        <a href="{{ route('principal.links.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add New Link
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Label</th>
                    <th class="px-4 py-2 border">URL</th>
                    <th class="px-4 py-2 border">Type</th>
                    <th class="px-4 py-2 border">Files</th>
                    <th class="px-4 py-2 border">Actions</th>
                    <th class="px-4 py-2 border">Download File</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $counter = ($links->currentPage() - 1) * $links->perPage() + 1;
                @endphp

                @forelse($links as $link)
                    @foreach($link->label ?? [] as $i => $lbl)
                        <tr>
                            <td class="px-4 py-2 border text-center">{{ $counter++ }}</td>

                            <td class="px-4 py-2 border">{{ $lbl ?? 'N/A' }}</td>

                            <td class="px-4 py-2 border">
                                <a href="{{ $link->url[$i] ?? '#' }}" target="_blank" class="text-blue-600 underline">
                                    {{ $link->url[$i] ?? 'N/A' }}
                                </a>
                            </td>

                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 bg-gray-200 rounded text-xs">
                                    {{ $link->type[$i] ?? 'N/A' }}
                                </span>
                            </td>

                            <td class="px-4 py-2 border">
                                @if(isset($link->file[$i]) && is_array($link->file[$i]) && count($link->file[$i]))
                                    @foreach($link->file[$i] as $file)
                                        <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-blue-600 underline text-sm">
                                            {{ basename($file) }}
                                        </a><br>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>

                            <td class="px-4 py-2 border text-center space-x-2">
                                <a href="{{ route('principal.links.edit', $link->id) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                    Edit
                                </a>

                                <form action="{{ route('principal.links.destroy', $link->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this link?')"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-2 border">
                                @if(isset($link->file[$i]) && is_array($link->file[$i]) && count($link->file[$i]))
                                    @foreach($link->file[$i] as $file)
                                        <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-blue-600 underline text-sm">
                                            {{ basename($file) }}
                                        </a><br>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>

                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td class="px-4 py-4 border text-center text-gray-500" colspan="6">
                            No links found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $links->links() }}
    </div>
</div>
@endsection
