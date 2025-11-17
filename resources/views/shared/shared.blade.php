@extends('principal.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-lg shadow p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Shared Links</h1>
        
        <div class="space-x-2">
            <a href="{{ route('principal.links.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                ← Back to Links
            </a>
            <a href="{{ route('principal.links.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Create New Link
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Shared Links Information</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Manage your shared links here. You can view statistics and revoke access at any time.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 border text-left">#</th>
                    <th class="px-4 py-3 border text-left">Original Link</th>
                    <th class="px-4 py-3 border text-left">Share URL</th>
                    <th class="px-4 py-3 border text-left">Expires At</th>
                    <th class="px-4 py-3 border text-left">Views</th>
                    <th class="px-4 py-3 border text-left">Settings</th>
                    <th class="px-4 py-3 border text-left">Status</th>
                    <th class="px-4 py-3 border text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $counter = ($shareTokens->currentPage() - 1) * $shareTokens->perPage() + 1;
                @endphp

                @forelse($shareTokens as $token)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 border">{{ $counter++ }}</td>
                        
                        <td class="px-4 py-3 border">
                            <div class="font-medium text-gray-900">
                                {{ $token->principalLink->label[0] ?? 'N/A' }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ Str::limit($token->principalLink->url[0] ?? 'N/A', 30) }}
                            </div>
                        </td>
                        
                        <td class="px-4 py-3 border">
                            <div class="flex items-center space-x-2">
                                <input type="text" 
                                       value="{{ route('shared.link.view', $token->token) }}" 
                                       readonly 
                                       class="flex-1 text-sm border border-gray-300 rounded px-2 py-1 bg-gray-50">
                                <button onclick="copyShareUrl('{{ route('shared.link.view', $token->token) }}')"
                                        class="bg-blue-600 text-white px-2 py-1 rounded text-sm hover:bg-blue-700">
                                    Copy
                                </button>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                Created: {{ $token->created_at->format('M j, Y g:i A') }}
                            </div>
                        </td>
                        
                        <td class="px-4 py-3 border">
                            <div class="{{ $token->isExpired() ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $token->expires_at->format('M j, Y g:i A') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $token->expires_at->diffForHumans() }}
                            </div>
                        </td>
                        
                        <td class="px-4 py-3 border text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $token->view_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $token->view_count }} views
                            </span>
                        </td>
                        
                        <td class="px-4 py-3 border">
                            <div class="text-xs space-y-1">
                                @php $settings = $token->settings ?? []; @endphp
                                <div class="flex items-center">
                                    <span class="w-2 h-2 rounded-full {{ $settings['mask_fields'] ?? true ? 'bg-green-500' : 'bg-gray-300' }} mr-1"></span>
                                    Mask Fields
                                </div>
                                <div class="flex items-center">
                                    <span class="w-2 h-2 rounded-full {{ $settings['watermark'] ?? true ? 'bg-green-500' : 'bg-gray-300' }} mr-1"></span>
                                    Watermark
                                </div>
                                <div class="flex items-center">
                                    <span class="w-2 h-2 rounded-full {{ $settings['disable_copy_print'] ?? true ? 'bg-green-500' : 'bg-gray-300' }} mr-1"></span>
                                    Copy/Print Protection
                                </div>
                                <div class="flex items-center">
                                    <span class="w-2 h-2 rounded-full {{ $settings['allow_downloads'] ?? false ? 'bg-green-500' : 'bg-gray-300' }} mr-1"></span>
                                    Allow Downloads
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-4 py-3 border">
                            @if($token->isExpired())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Expired
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-4 py-3 border">
                            <div class="flex space-x-2">
                                <a href="{{ route('shared.link.view', $token->token) }}" 
                                   target="_blank"
                                   class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                    Preview
                                </a>
                                
                                <form action="{{ route('principal.links.revoke-share', $token->id) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Are you sure you want to revoke this share link? This action cannot be undone.')"
                                            class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                        Revoke
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 border text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                <p class="text-lg font-medium text-gray-600">No shared links found</p>
                                <p class="text-sm text-gray-500 mt-1">Create your first shared link from the Links page</p>
                                <a href="{{ route('principal.links.index') }}" 
                                   class="mt-3 bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                                    Go to Links
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($shareTokens->hasPages())
    <div class="mt-6">
        {{ $shareTokens->links() }}
    </div>
    @endif

    <!-- Statistics Card -->
    @if($shareTokens->count() > 0)
    <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Shared</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $shareTokens->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Views</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $shareTokens->sum('view_count') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Active</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $shareTokens->where('expires_at', '>', now())->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Expired</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $shareTokens->where('expires_at', '<=', now())->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function copyShareUrl(url) {
    navigator.clipboard.writeText(url).then(function() {
        // Show temporary success message
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        button.classList.add('bg-green-600');
        
        setTimeout(() => {
            button.textContent = originalText;
            button.classList.remove('bg-green-600');
            button.classList.add('bg-blue-600', 'hover:bg-blue-700');
        }, 2000);
    }).catch(function(err) {
        // Fallback for older browsers
        const tempInput = document.createElement('input');
        tempInput.value = url;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        alert('Share URL copied to clipboard!');
    });
}
</script>

<style>
/* Additional styling for better appearance */
.border {
    border-color: #e5e7eb !important;
}

.hover\:bg-gray-50:hover {
    background-color: #f9fafb;
}
</style>
@endsection