@extends('principal.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-semibold mb-6">Shared Link Details</h1>

    <!-- Table of multiple rows -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Label</th>
                    <th class="px-4 py-2 border">URL</th>
                    <th class="px-4 py-2 border">Type</th>
                    <th class="px-4 py-2 border">Files</th>
                </tr>
            </thead>
            <tbody>
                @foreach($link->label ?? [] as $i => $lbl)
                <tr>
                    <td class="px-4 py-2 border text-center">{{ $i + 1 }}</td>

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
                        @if(isset($link->files[$i]) && is_array($link->files[$i]))
                            @foreach($link->files[$i] as $file)
                                <a href="{{ asset('storage/'.$file) }}" target="_blank" class="text-blue-600 underline text-sm">
                                    {{ basename($file) }}
                                </a><br>
                            @endforeach
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('principal.links.index') }}"
           class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">
            Back to List
        </a>
    </div>
</div>
@endsection
