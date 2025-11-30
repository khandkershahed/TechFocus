@extends('principal.layouts.app')

@section('content')
<div class="container-fluid min-vh-100 p-4 bg-light">

    {{-- Header --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h2 text-dark fw-bold mb-2">
                        Notes & Activities
                    </h1>
                    <p class="text-muted mb-0">
                        For: <strong>{{ $principal->legal_name ?? $principal->name ?? 'Company Name' }}</strong>
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('principal.dashboard') }}" 
                       class="btn btn-outline-secondary d-inline-flex align-items-center">
                        <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Notes Content --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <!-- Activity & Notes Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 text-dark mb-0">Activity & Notes Timeline</h2>
                <button onclick="toggleNoteForm()" class="btn btn-primary d-inline-flex align-items-center">
                    <i class="fas fa-plus me-2"></i>Add Note
                </button>
            </div>

            <!-- Rich Text Note Form (Initially Hidden) -->
            <div id="noteFormContainer" class="card border mb-4 d-none">
                <div class="card-body">
                    <form id="noteForm" action="{{ route('principal.notes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Note Type</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input type="radio" name="type" value="note" class="form-check-input" checked>
                                    <label class="form-check-label">General Note</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="type" value="important" class="form-check-input">
                                    <label class="form-check-label">Important</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="type" value="task" class="form-check-input">
                                    <label class="form-check-label">Task</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="richNote" class="form-label fw-semibold">Your Note</label>
                            <div class="border rounded">
                                <!-- Rich Text Toolbar -->
                                <div class="d-flex align-items-center p-2 border-bottom bg-light rounded-top">
                                    <button type="button" class="btn btn-sm btn-light me-1" onclick="formatText('bold')">
                                        <i class="fas fa-bold"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light me-1" onclick="formatText('italic')">
                                        <i class="fas fa-italic"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light me-1" onclick="formatText('underline')">
                                        <i class="fas fa-underline"></i>
                                    </button>
                                    <div class="vr mx-2"></div>
                                    <button type="button" class="btn btn-sm btn-light me-1" onclick="insertMention()">
                                        <i class="fas fa-at"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light" onclick="insertLink()">
                                        <i class="fas fa-link"></i>
                                    </button>
                                </div>
                                <!-- Rich Text Area -->
                                <textarea
                                    id="richNote"
                                    name="note"
                                    rows="4"
                                    class="form-control border-0 rounded-bottom resize-none"
                                    placeholder="Type your note here... Use @ to mention team members or # to add tags"
                                    oninput="handleInput(this)"></textarea>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="text-muted small">
                                    <span id="charCount">0</span>/2000 characters
                                </span>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="pin" class="form-check-input">
                                        <label class="form-check-label small">Pin this note</label>
                                    </div>
                                    <button type="button" onclick="toggleNoteForm()" class="btn btn-sm btn-link text-muted p-0">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- File Upload Section -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Attachments</label>

                            <!-- Link Input -->
                            <div class="mb-3">
                                <label class="form-label small">Add Link</label>
                                <div class="row g-2">
                                    <div class="col-md-5">
                                        <input type="url"
                                            id="linkUrl"
                                            placeholder="https://example.com"
                                            class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text"
                                            id="linkTitle"
                                            placeholder="Link title (optional)"
                                            class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" onclick="addLink()" class="btn btn-sm btn-secondary w-100">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- File Upload -->
                            <div class="mb-3">
                                <label class="form-label small">Upload Files</label>
                                <input type="file"
                                    id="fileInput"
                                    multiple
                                    accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.xls,.xlsx"
                                    class="form-control form-control-sm">
                                <div class="form-text">Supported: PDF, DOC, TXT, Images, Excel (Max: 10MB)</div>
                            </div>

                            <!-- Attachments Preview -->
                            <div id="attachmentsPreview" class="d-none mt-3">
                                <h6 class="small fw-semibold">Attachments:</h6>
                                <div id="attachmentsList" class="mt-2"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" onclick="toggleNoteForm()" class="btn btn-secondary">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Note
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div id="activitiesList">
                @if($activities->count())
                @foreach($activities->sortByDesc('pinned') as $activity)
                <div class="card border mb-3 {{ $activity->pinned ? 'border-warning bg-warning bg-opacity-10' : '' }}"
                    data-activity-id="{{ $activity->id }}">

                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <!-- Activity Icon -->
                            <div class="flex-shrink-0 me-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center 
                                    @if($activity->type == 'note') bg-primary bg-opacity-10 text-primary
                                    @elseif($activity->type == 'important') bg-danger bg-opacity-10 text-danger
                                    @elseif($activity->type == 'task') bg-success bg-opacity-10 text-success
                                    @elseif($activity->type == 'created') bg-success bg-opacity-10 text-success
                                    @elseif($activity->type == 'edited') bg-info bg-opacity-10 text-info
                                    @elseif($activity->type == 'link_shared') bg-purple bg-opacity-10 text-purple
                                    @elseif($activity->type == 'file_uploaded') bg-warning bg-opacity-10 text-warning
                                    @else bg-secondary bg-opacity-10 text-secondary @endif"
                                    style="width: 40px; height: 40px;">
                                    @if($activity->type == 'note')
                                    <i class="fas fa-note-sticky"></i>
                                    @elseif($activity->type == 'important')
                                    <i class="fas fa-exclamation"></i>
                                    @elseif($activity->type == 'task')
                                    <i class="fas fa-check-square"></i>
                                    @elseif($activity->type == 'created')
                                    <i class="fas fa-plus"></i>
                                    @elseif($activity->type == 'edited')
                                    <i class="fas fa-pen"></i>
                                    @elseif($activity->type == 'link_shared')
                                    <i class="fas fa-link"></i>
                                    @elseif($activity->type == 'file_uploaded')
                                    <i class="fas fa-file"></i>
                                    @else
                                    <i class="fas fa-circle"></i>
                                    @endif
                                </div>
                            </div>

                            <!-- Activity Content -->
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <span class="fw-semibold text-dark">
                                            @if($activity->createdBy && method_exists($activity->createdBy, 'name'))
                                            {{ $activity->createdBy->name }}
                                            @else
                                            You
                                            @endif
                                        </span>
                                        <span class="text-muted">•</span>
                                        <span class="text-muted small">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </span>

                                        @if($activity->pinned)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-thumbtack me-1"></i>Pinned
                                        </span>
                                        @endif

                                        @if(isset($activity->metadata['last_edited_at']))
                                        <span class="text-muted small" title="Edited {{ \Carbon\Carbon::parse($activity->metadata['last_edited_at'])->diffForHumans() }}">
                                            <i class="fas fa-pen me-1"></i>Edited
                                        </span>
                                        @endif
                                    </div>

                                    <!-- Action Menu -->
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="dropdown-item" onclick="editNote('{{ $activity->id }}')">
                                                    <i class="fas fa-pen me-2"></i>Edit Note
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item" onclick="togglePinNote('{{ $activity->id }}')">
                                                    <i class="fas fa-thumbtack me-2"></i>
                                                    <span class="pin-text">{{ $activity->pinned ? 'Unpin' : 'Pin' }}</span> Note
                                                </button>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button class="dropdown-item text-danger" onclick="deleteNote('{{ $activity->id }}')">
                                                    <i class="fas fa-trash me-2"></i>Delete Note
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="text-dark mb-3" id="content-{{ $activity->id }}">
                                    {!! $activity->rich_content ?: nl2br(e($activity->description)) !!}
                                </div>

                                <!-- Enhanced Attachments Section -->
                                @if($activity->metadata && (isset($activity->metadata['attachments']) || isset($activity->metadata['file']) || isset($activity->metadata['link'])))
                                <div class="mb-3">
                                    <!-- Files Section -->
                                    @php
                                    $fileAttachments = [];
                                    $linkAttachments = [];

                                    if (isset($activity->metadata['attachments']) && is_array($activity->metadata['attachments'])) {
                                        foreach ($activity->metadata['attachments'] as $attachment) {
                                            if ($attachment['type'] === 'file') {
                                                $fileAttachments[] = $attachment;
                                            } elseif ($attachment['type'] === 'link') {
                                                $linkAttachments[] = $attachment;
                                            }
                                        }
                                    }

                                    if (isset($activity->metadata['file'])) {
                                        $fileAttachments[] = [
                                            'type' => 'file',
                                            'name' => $activity->metadata['file']['name'] ?? 'Attachment',
                                            'url' => $activity->metadata['file']['url'] ?? '#',
                                            'size' => $activity->metadata['file']['size'] ?? null
                                        ];
                                    }

                                    if (isset($activity->metadata['link'])) {
                                        $linkAttachments[] = [
                                            'type' => 'link',
                                            'name' => $activity->metadata['link']['title'] ?? 'Link',
                                            'url' => $activity->metadata['link']['url'] ?? '#'
                                        ];
                                    }
                                    @endphp

                                    <!-- File Attachments -->
                                    @if(count($fileAttachments) > 0)
                                    <div class="card border-primary mb-2">
                                        <div class="card-body py-2">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-paperclip text-primary me-2"></i>
                                                <span class="fw-semibold text-primary">Attached Files</span>
                                                <span class="badge bg-primary ms-2">
                                                    {{ count($fileAttachments) }} file{{ count($fileAttachments) > 1 ? 's' : '' }}
                                                </span>
                                            </div>
                                            <div class="row g-2">
                                                @foreach($fileAttachments as $file)
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-between align-items-center p-2 border rounded bg-white">
                                                        <div class="d-flex align-items-center flex-grow-1">
                                                            @php
                                                            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                                                            $icon = 'fa-file';
                                                            $color = 'text-muted';

                                                            switch(strtolower($fileExtension)) {
                                                                case 'pdf': $icon = 'fa-file-pdf'; $color = 'text-danger'; break;
                                                                case 'doc': case 'docx': $icon = 'fa-file-word'; $color = 'text-primary'; break;
                                                                case 'xls': case 'xlsx': $icon = 'fa-file-excel'; $color = 'text-success'; break;
                                                                case 'jpg': case 'jpeg': case 'png': case 'gif': $icon = 'fa-file-image'; $color = 'text-warning'; break;
                                                                case 'zip': case 'rar': $icon = 'fa-file-archive'; $color = 'text-secondary'; break;
                                                                case 'txt': $icon = 'fa-file-text'; $color = 'text-dark'; break;
                                                            }
                                                            @endphp
                                                            <i class="fas {{ $icon }} {{ $color }} me-3 fs-5"></i>
                                                            <div class="flex-grow-1">
                                                                <div class="fw-medium text-dark">{{ $file['name'] }}</div>
                                                                @if(isset($file['size']))
                                                                <div class="text-muted small">
                                                                    {{ round($file['size'] / 1024 / 1024, 2) }} MB
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ $file['url'] }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Download">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                            <a href="{{ $file['url'] }}" target="_blank" class="btn btn-sm btn-outline-success" title="View">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Link Attachments -->
                                    @if(count($linkAttachments) > 0)
                                    <div class="card border-success">
                                        <div class="card-body py-2">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-link text-success me-2"></i>
                                                <span class="fw-semibold text-success">Related Links</span>
                                                <span class="badge bg-success ms-2">
                                                    {{ count($linkAttachments) }} link{{ count($linkAttachments) > 1 ? 's' : '' }}
                                                </span>
                                            </div>
                                            <div class="row g-2">
                                                @foreach($linkAttachments as $link)
                                                <div class="col-12">
                                                    <div class="d-flex justify-content-between align-items-center p-2 border rounded bg-white">
                                                        <div class="d-flex align-items-center flex-grow-1">
                                                            <i class="fas fa-external-link-alt text-success me-3"></i>
                                                            <div class="flex-grow-1">
                                                                <div class="fw-medium text-dark">{{ $link['name'] }}</div>
                                                                <div class="text-muted small text-truncate">{{ $link['url'] }}</div>
                                                            </div>
                                                        </div>
                                                        <a href="{{ $link['url'] }}" target="_blank" class="btn btn-sm btn-success">
                                                            Visit
                                                        </a>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @endif

                                <!-- REPLIES SECTION -->
                                @if($activity->replies_count > 0)
                                <div class="mt-3">
                                    <div class="card border">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0 fw-semibold">Replies ({{ $activity->replies_count }})</h6>
                                        </div>
                                        <div class="card-body">
                                            @foreach($activity->replies as $reply)
                                            <div class="d-flex align-items-start mb-2 p-2 border rounded bg-white">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                                         style="width: 24px; height: 24px; font-size: 0.7rem;">
                                                        {{ substr($reply->user_name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="fw-medium small text-dark">{{ $reply->user_name }}</span>
                                                            <span class="text-muted small">{{ $reply->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        @if($reply->user_id == auth('principal')->id() && $reply->user_type == 'App\Models\Principal')
                                                        <button onclick="deletePrincipalReply('{{ $reply->id }}', '{{ $activity->id }}')" 
                                                                class="btn btn-sm btn-link text-danger p-0">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        @endif
                                                    </div>
                                                    <p class="mb-0 small text-dark">{{ $reply->reply }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <!-- Empty State -->
                <div class="text-center py-5 border-2 border-dashed rounded bg-light">
                    <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                    <p class="h5 text-muted mb-2">No activities yet</p>
                    <p class="text-muted mb-3">Start by adding your first note above</p>
                    <button onclick="toggleNoteForm()" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Add Your First Note
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Note Modal -->
<div class="modal fade" id="noteModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('principal.notes.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="note" class="form-control" rows="5" placeholder="Type your note here..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Note</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- WeChat Modal -->
<div class="modal fade" id="wechatModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">WeChat Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fab fa-weixin text-success mb-3" style="font-size: 3rem;"></i>
                <p class="text-muted mb-2">WeChat ID:</p>
                <p class="h5 text-dark mb-3" id="wechatId"></p>
                <p class="text-muted small">Add this ID in WeChat to connect</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Global variables
    let currentEditingNoteId = null;
    let attachments = []; // Store attachments for the current note

    // ===== MAIN TOGGLE NOTE FORM FUNCTION =====
    function toggleNoteForm() {
        const formContainer = document.getElementById('noteFormContainer');
        const form = document.getElementById('noteForm');

        if (formContainer) {
            if (formContainer.classList.contains('d-none')) {
                formContainer.classList.remove('d-none');
                // Show form - focus on textarea
                const noteField = form?.querySelector('textarea[name="note"]');
                if (noteField) {
                    noteField.focus();
                }
                
                // Scroll to form for better UX
                formContainer.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            } else {
                formContainer.classList.add('d-none');
                // Hide form - reset to create mode
                resetNoteForm();
            }
        }
    }

    function resetNoteForm() {
        const form = document.getElementById('noteForm');
        if (!form) return;

        form.removeAttribute('data-mode');
        form.removeAttribute('data-activity-id');
        form.reset();
        attachments = []; // Clear attachments
        updateAttachmentsPreview();

        // Reset type to default
        const defaultType = form.querySelector('input[name="type"][value="note"]');
        if (defaultType) {
            defaultType.checked = true;
        }

        // Reset pin to default
        const pinInput = form.querySelector('input[name="pin"]');
        if (pinInput) {
            pinInput.checked = false;
        }

        // Clear link inputs
        const linkUrl = document.getElementById('linkUrl');
        const linkTitle = document.getElementById('linkTitle');
        if (linkUrl) linkUrl.value = '';
        if (linkTitle) linkTitle.value = '';

        // Reset submit button
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.textContent = 'Save Note';
            submitButton.classList.remove('btn-success');
            submitButton.classList.add('btn-primary');
        }

        // Reset character count
        const charCount = document.getElementById('charCount');
        if (charCount) charCount.textContent = '0';
    }

    // Helper function to get CSRF token safely
    function getCsrfToken() {
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) {
            return metaTag.content;
        }

        const formToken = document.querySelector('input[name="_token"]');
        if (formToken) {
            return formToken.value;
        }

        console.warn('CSRF token not found');
        return '';
    }

    // Character counter function
    function updateCharCount(textarea) {
        const charCount = document.getElementById('charCount');
        if (charCount && textarea) {
            charCount.textContent = textarea.value.length;
        }
    }

    // ===== ATTACHMENT MANAGEMENT =====
    function addLink() {
        const urlInput = document.getElementById('linkUrl');
        const titleInput = document.getElementById('linkTitle');
        const url = urlInput.value.trim();
        const title = titleInput.value.trim() || 'Link';

        if (!url) {
            showNotification('Please enter a URL', 'error');
            return;
        }

        // Validate URL
        try {
            new URL(url);
        } catch (e) {
            showNotification('Please enter a valid URL', 'error');
            return;
        }

        const link = {
            type: 'link',
            url: url,
            name: title,
            title: title
        };

        attachments.push(link);
        updateAttachmentsPreview();

        // Clear inputs
        urlInput.value = '';
        titleInput.value = '';

        showNotification('Link added to attachments', 'success');
    }

    function handleFileSelect(event) {
        const files = Array.from(event.target.files);

        files.forEach(file => {
            // Check file size (10MB limit)
            if (file.size > 10 * 1024 * 1024) {
                showNotification(`File ${file.name} is too large. Max size is 10MB.`, 'error');
                return;
            }

            const fileAttachment = {
                type: 'file',
                file: file,
                name: file.name,
                size: file.size
            };

            attachments.push(fileAttachment);
        });

        updateAttachmentsPreview();
        event.target.value = ''; // Reset file input
    }

    function updateAttachmentsPreview() {
        const previewContainer = document.getElementById('attachmentsPreview');
        const attachmentsList = document.getElementById('attachmentsList');

        if (attachments.length === 0) {
            previewContainer.classList.add('d-none');
            attachmentsList.innerHTML = '';
            return;
        }

        previewContainer.classList.remove('d-none');
        attachmentsList.innerHTML = '';

        attachments.forEach((attachment, index) => {
            const attachmentElement = document.createElement('div');
            attachmentElement.className = 'd-flex justify-content-between align-items-center bg-light p-2 rounded border mb-2';

            if (attachment.type === 'link') {
                attachmentElement.innerHTML = `
                    <div class="d-flex align-items-center flex-grow-1">
                        <i class="fas fa-link text-primary me-2"></i>
                        <div class="flex-grow-1">
                            <div class="fw-medium text-dark">${attachment.name}</div>
                            <div class="text-muted small text-truncate">${attachment.url}</div>
                        </div>
                    </div>
                    <button type="button" onclick="removeAttachment(${index})" class="btn btn-sm btn-link text-danger">
                        <i class="fas fa-times"></i>
                    </button>
                `;
            } else if (attachment.type === 'file') {
                const size = (attachment.size / 1024 / 1024).toFixed(2);
                const fileExtension = attachment.name.split('.').pop().toLowerCase();
                const icon = getFileIcon(fileExtension);

                attachmentElement.innerHTML = `
                    <div class="d-flex align-items-center flex-grow-1">
                        <i class="fas ${icon} text-success me-2"></i>
                        <div class="flex-grow-1">
                            <div class="fw-medium text-dark">${attachment.name}</div>
                            <div class="text-muted small">${size} MB</div>
                        </div>
                    </div>
                    <button type="button" onclick="removeAttachment(${index})" class="btn btn-sm btn-link text-danger">
                        <i class="fas fa-times"></i>
                    </button>
                `;
            }

            attachmentsList.appendChild(attachmentElement);
        });
    }

    function getFileIcon(extension) {
        const iconMap = {
            'pdf': 'fa-file-pdf',
            'doc': 'fa-file-word',
            'docx': 'fa-file-word',
            'txt': 'fa-file-text',
            'jpg': 'fa-file-image',
            'jpeg': 'fa-file-image',
            'png': 'fa-file-image',
            'xls': 'fa-file-excel',
            'xlsx': 'fa-file-excel',
            'zip': 'fa-file-archive',
            'rar': 'fa-file-archive'
        };

        return iconMap[extension] || 'fa-file';
    }

    function removeAttachment(index) {
        attachments.splice(index, 1);
        updateAttachmentsPreview();
        showNotification('Attachment removed', 'info');
    }

    // ===== NOTE ACTIONS =====
    async function editNote(activityId) {
        try {
            console.log('Editing note:', activityId);

            const response = await fetch(`/principal/notes/${activityId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': getCsrfToken()
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                const activity = result.activity;
                currentEditingNoteId = activityId;

                // Populate the form
                const noteField = document.getElementById('richNote');
                if (noteField) {
                    noteField.value = activity.description || '';
                    updateCharCount(noteField);
                }

                // Set note type
                const typeInputs = document.querySelectorAll('input[name="type"]');
                typeInputs.forEach(input => {
                    if (input.value === activity.type) {
                        input.checked = true;
                    }
                });

                // Set pin status
                const pinInput = document.querySelector('input[name="pin"]');
                if (pinInput) {
                    pinInput.checked = !!activity.pinned;
                }

                // Load existing attachments if any
                attachments = [];
                if (activity.metadata && activity.metadata.attachments) {
                    attachments = activity.metadata.attachments.map(att => ({
                        type: att.type,
                        url: att.url,
                        name: att.name,
                        size: att.size
                    }));
                }
                updateAttachmentsPreview();

                // Change form to update mode
                const form = document.getElementById('noteForm');
                if (form) {
                    form.setAttribute('data-mode', 'edit');
                    form.setAttribute('data-activity-id', activityId);

                    const submitButton = form.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.textContent = 'Update Note';
                        submitButton.classList.remove('btn-primary');
                        submitButton.classList.add('btn-success');
                    }
                }

                // Show the form if hidden
                const formContainer = document.getElementById('noteFormContainer');
                if (formContainer && formContainer.classList.contains('d-none')) {
                    toggleNoteForm();
                }

                // Scroll to form
                if (formContainer) {
                    formContainer.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }

                showNotification('Note loaded successfully', 'success');

            } else {
                throw new Error(result.message || 'Failed to load note');
            }
        } catch (error) {
            console.error('Error loading note:', error);
            showNotification('Error loading note: ' + error.message, 'error');
        }
    }

    async function deleteNote(activityId) {
        if (!confirm('Are you sure you want to delete this note? This action cannot be undone.')) {
            return;
        }

        try {
            console.log('Deleting note:', activityId);

            const response = await fetch(`/principal/notes/${activityId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                // Remove the note from the DOM
                const noteElement = document.querySelector(`[data-activity-id="${activityId}"]`);
                if (noteElement) {
                    noteElement.remove();
                    updateActivityStats();
                    
                    // Check if no activities left, show empty state
                    const activitiesList = document.getElementById('activitiesList');
                    const remainingActivities = activitiesList.querySelectorAll('[data-activity-id]');
                    if (remainingActivities.length === 0) {
                        showEmptyState();
                    }
                }

                showNotification('Note deleted successfully!', 'success');

            } else {
                throw new Error(result.message || 'Failed to delete note');
            }
        } catch (error) {
            console.error('Error deleting note:', error);
            showNotification('Error deleting note: ' + error.message, 'error');
        }
    }

    async function togglePinNote(activityId) {
        try {
            console.log('Toggling pin for note:', activityId);

            const response = await fetch(`/principal/notes/${activityId}/pin`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                // Reload the page to reflect changes
                window.location.reload();
                showNotification(result.message, 'success');
            } else {
                throw new Error(result.message || 'Failed to toggle pin');
            }
        } catch (error) {
            console.error('Error toggling pin:', error);
            showNotification('Error toggling pin: ' + error.message, 'error');
        }
    }

    // ===== UTILITY FUNCTIONS =====
    async function deletePrincipalReply(replyId, activityId) {
        if (!confirm('Are you sure you want to delete this reply?')) {
            return;
        }

        try {
            const response = await fetch(`/principal/notes/replies/${replyId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                showNotification('Reply deleted successfully', 'success');
                // Reload the page to reflect changes
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                throw new Error(result.message || 'Failed to delete reply');
            }
        } catch (error) {
            console.error('Error deleting reply:', error);
            showNotification('Error deleting reply: ' + error.message, 'error');
        }
    }

    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-success' :
            type === 'error' ? 'bg-danger' :
            type === 'warning' ? 'bg-warning' : 'bg-info';

        notification.className = `position-fixed top-0 end-0 m-3 ${bgColor} text-white px-4 py-3 rounded shadow z-3`;
        notification.style.zIndex = '1060';
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'} me-2"></i>
                <span class="fw-medium">${message}</span>
                <button type="button" class="btn-close btn-close-white ms-3" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    }

    function updateActivityStats() {
        const activityCount = document.querySelectorAll('[data-activity-id]').length;
        const activityStatsElement = document.querySelector('[data-activity-stats]');

        if (activityStatsElement) {
            activityStatsElement.textContent = activityCount;
        }
    }

    function showEmptyState() {
        const activitiesList = document.getElementById('activitiesList');
        activitiesList.innerHTML = `
            <div class="text-center py-5 border-2 border-dashed rounded bg-light">
                <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                <p class="h5 text-muted mb-2">No activities yet</p>
                <p class="text-muted mb-3">Start by adding your first note above</p>
                <button onclick="toggleNoteForm()" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Add Your First Note
                </button>
            </div>
        `;
    }

    // ===== RICH TEXT EDITOR FUNCTIONS =====
    function formatText(command) {
        const textarea = document.getElementById('richNote');
        if (!textarea) return;

        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selectedText = textarea.value.substring(start, end);

        let formattedText = '';
        switch (command) {
            case 'bold':
                formattedText = `**${selectedText}**`;
                break;
            case 'italic':
                formattedText = `*${selectedText}*`;
                break;
            case 'underline':
                formattedText = `__${selectedText}__`;
                break;
            default:
                formattedText = selectedText;
        }

        textarea.setRangeText(formattedText, start, end, 'select');
        textarea.focus();
    }

    function insertMention() {
        const textarea = document.getElementById('richNote');
        if (!textarea) return;

        const start = textarea.selectionStart;
        textarea.setRangeText('@', start, start, 'end');
        textarea.focus();
    }

    function insertLink() {
        const textarea = document.getElementById('richNote');
        if (!textarea) return;

        const url = prompt('Enter URL:');
        if (url) {
            const title = prompt('Enter link title (optional):') || 'Link';
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            const linkText = selectedText || title;

            textarea.setRangeText(`[${linkText}](${url})`, start, end, 'select');
            textarea.focus();
        }
    }

    function handleInput(textarea) {
        updateCharCount(textarea);
    }

    // ===== INITIALIZATION =====
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - initializing notes functionality');
        
        updateActivityStats();

        // Initialize character counter
        const noteField = document.querySelector('textarea[name="note"]');
        if (noteField) {
            updateCharCount(noteField);
        }

        // Initialize file input event listener
        const fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.addEventListener('change', handleFileSelect);
        }

        // Initialize form submission
        const noteForm = document.getElementById('noteForm');
        if (noteForm) {
            // Add input event listener for character count
            const noteField = noteForm.querySelector('textarea[name="note"]');
            if (noteField) {
                noteField.addEventListener('input', function() {
                    updateCharCount(this);
                });
            }

            noteForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const mode = this.getAttribute('data-mode');
                const activityId = this.getAttribute('data-activity-id');

                // Get form values explicitly to ensure they're captured
                const noteField = this.querySelector('textarea[name="note"]');
                const noteValue = noteField ? noteField.value.trim() : '';
                const typeInput = this.querySelector('input[name="type"]:checked');
                const typeValue = typeInput ? typeInput.value : 'note';
                const pinInput = this.querySelector('input[name="pin"]');
                const pinValue = pinInput ? pinInput.checked : false;

                // Validate required fields
                if (!noteValue) {
                    showNotification('Please enter a note before saving.', 'error');
                    if (noteField) noteField.focus();
                    return;
                }

                if (!typeValue) {
                    showNotification('Please select a note type.', 'error');
                    return;
                }

                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.textContent;

                // Show loading state
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>' +
                    (mode === 'edit' ? 'Updating...' : 'Saving...');
                submitButton.disabled = true;

                try {
                    let url = '/principal/notes';
                    let method = 'POST';

                    if (mode === 'edit' && activityId) {
                        url = `/principal/notes/${activityId}`;
                        method = 'PUT';
                    }

                    // Create form data properly with explicit values
                    const formData = new FormData();
                    formData.append('note', noteValue);
                    formData.append('type', typeValue);
                    formData.append('pin', pinValue ? '1' : '0');

                    // Add attachments
                    if (attachments.length > 0) {
                        attachments.forEach((attachment, index) => {
                            if (attachment.type === 'file' && attachment.file) {
                                formData.append(`attachments[${index}][file]`, attachment.file);
                                formData.append(`attachments[${index}][type]`, 'file');
                                formData.append(`attachments[${index}][name]`, attachment.name);
                            } else if (attachment.type === 'link') {
                                formData.append(`attachments[${index}][type]`, 'link');
                                formData.append(`attachments[${index}][url]`, attachment.url);
                                formData.append(`attachments[${index}][name]`, attachment.name);
                            }
                        });
                    }

                    // For PUT requests, we need to add _method for Laravel to recognize it
                    if (method === 'PUT') {
                        formData.append('_method', 'PUT');
                    }

                    // Add CSRF token
                    formData.append('_token', getCsrfToken());

                    const response = await fetch(url, {
                        method: 'POST', // Always use POST when using FormData with _method
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const result = await response.json();

                    if (result.success) {
                        showNotification(result.message, 'success');

                        // Reset form and hide it
                        this.reset();
                        attachments = []; // Clear attachments
                        updateAttachmentsPreview();
                        const charCount = document.getElementById('charCount');
                        if (charCount) charCount.textContent = '0';
                        
                        // Close the form after successful submission
                        toggleNoteForm();

                        // Reset form mode
                        this.removeAttribute('data-mode');
                        this.removeAttribute('data-activity-id');
                        submitButton.textContent = originalText;

                        // Reload the page to show updated activities
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);

                    } else {
                        // Show validation errors from server
                        if (result.errors) {
                            const errorMessages = Object.values(result.errors).flat().join(', ');
                            throw new Error(errorMessages);
                        } else {
                            throw new Error(result.message || 'Unknown error occurred');
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('Error: ' + error.message, 'error');
                } finally {
                    // Reset button state
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }
            });
        }

        console.log('Notes functionality initialized successfully');
    });
</script>
@endpush