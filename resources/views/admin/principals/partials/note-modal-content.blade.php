<div class="space-y-6">
    <!-- Note Content -->
    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center
                    @if($activity->type == 'note') bg-blue-100 text-blue-600
                    @elseif($activity->type == 'important') bg-red-100 text-red-600
                    @elseif($activity->type == 'task') bg-green-100 text-green-600
                    @else bg-gray-100 text-gray-600 @endif">
                    @if($activity->type == 'note')
                    <i class="text-sm fa-solid fa-note-sticky"></i>
                    @elseif($activity->type == 'important')
                    <i class="text-sm fa-solid fa-exclamation"></i>
                    @elseif($activity->type == 'task')
                    <i class="text-sm fa-solid fa-square-check"></i>
                    @else
                    <i class="text-sm fa-solid fa-circle"></i>
                    @endif
                </div>
                <div>
                    <h6 class="font-medium text-gray-900">
                        @if($activity->createdBy)
                            {{ $activity->createdBy->name ?? $activity->createdBy->legal_name ?? 'System' }}
                        @else
                            System
                        @endif
                    </h6>
                    <p class="text-sm text-gray-500">{{ $activity->created_at->format('M j, Y g:i A') }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                @if($activity->pinned)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    <i class="mr-1 fa-solid fa-thumbtack"></i>Pinned
                </span>
                @endif
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                    @if($activity->type == 'note') bg-blue-100 text-blue-800
                    @elseif($activity->type == 'important') bg-red-100 text-red-800
                    @elseif($activity->type == 'task') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($activity->type) }}
                </span>
            </div>
        </div>
        
        <div class="prose prose-sm max-w-none text-gray-700">
            {!! $activity->rich_content ?: nl2br(e($activity->description)) !!}
        </div>
    </div>

    <!-- Replies Section -->
    <div>
        @php
            $repliesCount = 0;
            $replies = collect();
            if (method_exists($activity, 'replies')) {
                $repliesCount = $activity->replies_count ?? $activity->replies()->count();
                $replies = $activity->replies;
            }
        @endphp

        <h6 class="text-lg font-medium text-gray-900 mb-4">
            Replies ({{ $repliesCount }})
        </h6>
        
        <!-- Replies List -->
        <div class="space-y-4 mb-6">
            @forelse($replies as $reply)
            <div class="flex items-start space-x-3 p-3 bg-white border border-gray-200 rounded-lg">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-sm font-medium">
                    {{ substr($reply->user_name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-900">{{ $reply->user_name }}</span>
                            <span class="text-xs text-gray-500">{{ $reply->created_at->format('M j, Y g:i A') }}</span>
                        </div>
                        @if($reply->user_id == auth('admin')->id() || auth('admin')->user()->hasRole('SuperAdmin'))
                        <button onclick="deleteReply('{{ $reply->id }}', '{{ $activity->id }}')" 
                                class="text-red-600 hover:text-red-800 text-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @endif
                    </div>
                    <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $reply->reply }}</p>
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-gray-500">
                <i class="fa-solid fa-comments text-2xl mb-2"></i>
                <p>No replies yet</p>
            </div>
            @endforelse
        </div>

        <!-- Add Reply Form -->
        @if(auth('admin')->user()->hasRole('SuperAdmin') || auth('admin')->user()->can('edit principals'))
        <div class="border-t pt-4">
            <form onsubmit="event.preventDefault(); submitModalReply('{{ $activity->id }}');">
                @csrf
                <div class="mb-3">
                    <label for="modalReplyText" class="block text-sm font-medium text-gray-700 mb-2">Add Reply</label>
                    <textarea 
                        id="modalReplyText" 
                        name="reply" 
                        rows="3" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Type your reply here..."
                        maxlength="1000"
                        required></textarea>
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-xs text-gray-500">Max 1000 characters</span>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <i class="mr-2 fa-solid fa-reply"></i>Post Reply
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>