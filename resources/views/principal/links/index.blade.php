@extends('principal.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">Shared Links</h1>
                        <a href="{{ route('principal.links.create') }}" 
                           class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i> Add New Link
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Label</th>
                                    <th>URL</th>
                                    <th>Type</th>
                                    <th>Files</th>
                                    <th class="text-center">Actions</th>
                                    <th>Download File</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $counter = ($links->currentPage() - 1) * $links->perPage() + 1;
                                @endphp

                                @forelse($links as $link)
                                    @foreach($link->label ?? [] as $i => $lbl)
                                        <tr>
                                            <td class="text-center">{{ $counter++ }}</td>

                                            <td>{{ $lbl ?? 'N/A' }}</td>

                                            <td>
                                                <a href="{{ $link->url[$i] ?? '#' }}" target="_blank" class="text-decoration-none">
                                                    {{ $link->url[$i] ?? 'N/A' }}
                                                </a>
                                            </td>

                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $link->type[$i] ?? 'N/A' }}
                                                </span>
                                            </td>

                                            <td>
                                                @if(isset($link->file[$i]) && is_array($link->file[$i]) && count($link->file[$i]))
                                                    @foreach($link->file[$i] as $file)
                                                        <a href="{{ asset('storage/' . $file) }}" target="_blank" class="d-block text-decoration-none mb-1">
                                                            <i class="fas fa-file me-1"></i>{{ basename($file) }}
                                                        </a>
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <!-- Share Button -->
                                                    <button onclick="openShareModal({{ $link->id }})"
                                                            class="btn btn-success">
                                                        <i class="fas fa-share-alt me-1"></i> Share
                                                    </button>

                                                    <!-- Edit Button -->
                                                    <a href="{{ route('principal.links.edit', $link->id) }}"
                                                       class="btn btn-warning text-white">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('principal.links.destroy', $link->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('Are you sure you want to delete this link?')"
                                                            class="btn btn-danger">
                                                            <i class="fas fa-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>

                                            <td>
                                                @if(isset($link->file[$i]) && is_array($link->file[$i]) && count($link->file[$i]))
                                                    @foreach($link->file[$i] as $file)
                                                        <a href="{{ asset('storage/' . $file) }}" target="_blank" class="d-block text-decoration-none mb-1">
                                                            <i class="fas fa-download me-1"></i>{{ basename($file) }}
                                                        </a>
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td class="text-center text-muted py-4" colspan="7">
                                            <i class="fas fa-exclamation-circle me-2"></i>No links found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $links->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========== ENHANCED SHARE MODAL WITH REAL EMAIL SENDING ========== -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share Link</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="shareForm" method="POST">
                @csrf
                <input type="hidden" name="link_id" id="shareLinkId">
                
                <div class="modal-body">
                    <!-- Expiry -->
                    <div class="mb-3">
                        <label class="form-label">Expiry</label>
                        <select name="expiry" class="form-select">
                            <option value="7">7 days</option>
                            <option value="30" selected>30 days</option>
                            <option value="custom">Custom</option>
                        </select>
                        <div id="customExpiry" class="mt-2 d-none">
                            <input type="date" 
                                   name="custom_expiry_date" 
                                   class="form-control"
                                   min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                            <small class="text-muted">Please select a future date</small>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="mb-4">
                        <h6 class="mb-2">Security Settings</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="mask_fields" value="1" checked>
                                    <label class="form-check-label">
                                        Mask emails/phones (partially hide)
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="watermark" value="1" checked>
                                    <label class="form-check-label">
                                        Show watermark (viewer IP/time)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="disable_copy_print" value="1" checked>
                                    <label class="form-check-label">
                                        Disable copy/print (best effort)
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="allow_downloads" value="1">
                                    <label class="form-check-label">
                                        Allow download of attachments
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Share URL (will be populated after creation) -->
                    <div class="mb-4 d-none" id="shareUrlSection">
                        <label class="form-label">Share URL</label>
                        <div class="input-group mb-2">
                            <input type="text" id="shareUrl" readonly class="form-control">
                            <button type="button" onclick="copyShareUrl()" class="btn btn-primary">
                                <i class="fas fa-copy me-1"></i> Copy
                            </button>
                        </div>
                        <small class="text-muted">Share this URL with others</small>

                        <!-- Quick Share Options -->
                        <div class="border-top pt-3 mt-3">
                            <h6 class="mb-2">Quick Share</h6>
                            
                            <!-- Email Sharing -->
                            <div class="mb-3">
                                <label class="form-label">Share via Email</label>
                                <div class="input-group mb-2">
                                    <input type="email" id="emailInput" placeholder="Enter email address" 
                                           class="form-control">
                                    <button type="button" onclick="shareViaEmail()" class="btn btn-danger">
                                        <i class="fas fa-envelope me-1"></i> Send Email
                                    </button>
                                </div>
                                <div class="mb-2">
                                    <button type="button" onclick="addEmailField()" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-plus me-1"></i> Add another email
                                    </button>
                                </div>
                                <div id="additionalEmails" class="mb-2"></div>
                                <small class="text-muted">Emails will be sent directly from the system</small>
                            </div>

                            <!-- WhatsApp Sharing -->
                            <div class="mb-3">
                                <label class="form-label">Share via WhatsApp</label>
                                <div class="input-group">
                                    <input type="text" id="whatsappInput" placeholder="Enter phone number" 
                                           class="form-control"
                                           oninput="formatPhoneNumber(this)">
                                    <button type="button" onclick="shareViaWhatsApp()" class="btn btn-success">
                                        <i class="fab fa-whatsapp me-1"></i> WhatsApp
                                    </button>
                                </div>
                            </div>

                            <!-- Email Client Options -->
                            <div class="mb-3">
                                <label class="form-label">Or open email client:</label>
                                <div class="d-grid gap-2 d-md-flex">
                                    <button type="button" onclick="shareViaGmail()" class="btn btn-danger flex-grow-1">
                                        <i class="fab fa-google me-1"></i> Gmail
                                    </button>
                                    {{-- <button type="button" onclick="shareViaOutlook()" class="btn btn-primary flex-grow-1">
                                        <i class="fab fa-microsoft me-1"></i> Outlook
                                    </button> --}}
                                </div>
                            </div>

                            <!-- Social Media -->
                            {{-- <div class="mb-3">
                                <label class="form-label">Share on social media:</label>
                                <div class="d-flex gap-2">
                                    <button type="button" onclick="shareViaFacebook()" class="btn btn-primary flex-fill">
                                        <i class="fab fa-facebook me-1"></i> Facebook
                                    </button>
                                    <button type="button" onclick="shareViaTwitter()" class="btn btn-info flex-fill">
                                        <i class="fab fa-twitter me-1"></i> Twitter
                                    </button>
                                    <button type="button" onclick="shareViaLinkedIn()" class="btn btn-primary flex-fill">
                                        <i class="fab fa-linkedin me-1"></i> LinkedIn
                                    </button>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-link me-1"></i> Generate Share Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentShareUrl = '';
let emailCount = 0;

function openShareModal(linkId) {
    console.log('Opening share modal for link ID:', linkId);
    document.getElementById('shareLinkId').value = linkId;
    
    // Reset form to default state
    document.getElementById('shareForm').reset();
    document.querySelector('select[name="expiry"]').value = '30';
    document.getElementById('customExpiry').classList.add('d-none');
    
    // Reset email fields
    document.getElementById('emailInput').value = '';
    document.getElementById('whatsappInput').value = '';
    document.getElementById('additionalEmails').innerHTML = '';
    document.getElementById('shareUrlSection').classList.add('d-none');
    emailCount = 0;
    
    // Set default checkboxes
    document.querySelector('input[name="mask_fields"]').checked = true;
    document.querySelector('input[name="watermark"]').checked = true;
    document.querySelector('input[name="disable_copy_print"]').checked = true;
    document.querySelector('input[name="allow_downloads"]').checked = false;
    
    // Show modal
    const shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
    shareModal.show();
}

function copyShareUrl() {
    const shareUrl = document.getElementById('shareUrl');
    shareUrl.select();
    shareUrl.setSelectionRange(0, 99999);
    
    try {
        navigator.clipboard.writeText(shareUrl.value).then(() => {
            const copyButton = document.querySelector('button[onclick="copyShareUrl()"]');
            const originalText = copyButton.innerHTML;
            copyButton.innerHTML = '<i class="fas fa-check me-1"></i> Copied!';
            copyButton.classList.remove('btn-primary');
            copyButton.classList.add('btn-success');
            
            setTimeout(() => {
                copyButton.innerHTML = originalText;
                copyButton.classList.remove('btn-success');
                copyButton.classList.add('btn-primary');
            }, 2000);
        });
    } catch (err) {
        document.execCommand('copy');
        alert('Share URL copied to clipboard!');
    }
}

// Email functionality
function addEmailField() {
    emailCount++;
    const emailDiv = document.createElement('div');
    emailDiv.className = 'input-group mb-2';
    emailDiv.innerHTML = `
        <input type="email" placeholder="Additional email address" 
               class="form-control additional-email">
        <button type="button" onclick="removeEmailField(this)" class="btn btn-outline-secondary">
            <i class="fas fa-times"></i>
        </button>
    `;
    document.getElementById('additionalEmails').appendChild(emailDiv);
}

function removeEmailField(button) {
    button.closest('.input-group').remove();
}

// REAL EMAIL SENDING FUNCTIONALITY
function shareViaEmail() {
    const mainEmail = document.getElementById('emailInput').value;
    const additionalEmails = Array.from(document.querySelectorAll('.additional-email'))
        .map(input => input.value)
        .filter(email => email.trim() !== '');
    
    const allEmails = [mainEmail, ...additionalEmails].filter(email => email.trim() !== '');
    
    if (allEmails.length === 0) {
        alert('Please enter at least one email address');
        return;
    }
    
    // Validate emails
    const invalidEmails = allEmails.filter(email => !isValidEmail(email));
    if (invalidEmails.length > 0) {
        alert('Invalid email addresses: ' + invalidEmails.join(', '));
        return;
    }
    
    // Show sending progress
    const emailButton = document.querySelector('button[onclick="shareViaEmail()"]');
    const originalText = emailButton.innerHTML;
    emailButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Sending...';
    emailButton.disabled = true;
    
    // Calculate expiry date
    const expirySelect = document.querySelector('select[name="expiry"]');
    const expiryType = expirySelect.value;
    let expiresAt;
    
    if (expiryType === 'custom') {
        expiresAt = document.querySelector('input[name="custom_expiry_date"]').value;
    } else {
        const days = parseInt(expiryType);
        const expiryDate = new Date();
        expiryDate.setDate(expiryDate.getDate() + days);
        expiresAt = expiryDate.toISOString().split('T')[0];
    }
    
    // Send emails via Laravel backend
    fetch('{{ route("principal.links.send-share-email") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            emails: allEmails,
            share_url: currentShareUrl,
            expires_at: expiresAt
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ Emails sent successfully to: ' + allEmails.join(', '));
            // Clear email fields after successful send
            document.getElementById('emailInput').value = '';
            document.querySelectorAll('.additional-email').forEach(input => input.value = '');
            document.getElementById('additionalEmails').innerHTML = '';
        } else {
            alert('❌ Failed to send emails: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error sending emails:', error);
        alert('❌ Error sending emails. Please try again or use the Gmail/Outlook buttons.');
    })
    .finally(() => {
        emailButton.innerHTML = originalText;
        emailButton.disabled = false;
    });
}

// Fallback email function (opens email client)
function shareViaEmailFallback() {
    const mainEmail = document.getElementById('emailInput').value;
    const additionalEmails = Array.from(document.querySelectorAll('.additional-email'))
        .map(input => input.value)
        .filter(email => email.trim() !== '');
    
    const allEmails = [mainEmail, ...additionalEmails].filter(email => email.trim() !== '');
    
    if (allEmails.length === 0) {
        alert('Please enter at least one email address');
        return;
    }
    
    const invalidEmails = allEmails.filter(email => !isValidEmail(email));
    if (invalidEmails.length > 0) {
        alert('Invalid email addresses: ' + invalidEmails.join(', '));
        return;
    }
    
    const subject = 'Shared Link from Principal';
    const body = `Hello,\n\nI'm sharing this link with you:\n${currentShareUrl}\n\nThis link will expire on the specified date.`;
    
    const mailtoLink = `mailto:${allEmails.join(';')}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    window.open(mailtoLink, '_blank');
}

// WhatsApp functionality
function formatPhoneNumber(input) {
    // Remove all non-numeric characters
    let value = input.value.replace(/\D/g, '');
    
    // Format as international number
    if (value.startsWith('0')) {
        value = value.substring(1); // Remove leading 0
    }
    
    input.value = value;
}

function shareViaWhatsApp() {
    const phoneNumber = document.getElementById('whatsappInput').value;
    
    if (!phoneNumber) {
        alert('Please enter a phone number');
        return;
    }
    
    if (phoneNumber.length < 10) {
        alert('Please enter a valid phone number');
        return;
    }
    
    const message = `Hello, I'm sharing this link with you: ${currentShareUrl}`;
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}

// Email client integrations
function shareViaGmail() {
    const subject = 'Shared Link from Principal';
    const body = `Hello,\n\nI'm sharing this link with you:\n${currentShareUrl}\n\nThis link will expire on the specified date.`;
    const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&su=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    window.open(gmailUrl, '_blank');
}

function shareViaOutlook() {
    const subject = 'Shared Link from Principal';
    const body = `Hello,\n\nI'm sharing this link with you:\n${currentShareUrl}\n\nThis link will expire on the specified date.`;
    const outlookUrl = `https://outlook.live.com/owa/?path=/mail/action/compose&subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    window.open(outlookUrl, '_blank');
}

// Social media sharing
function shareViaFacebook() {
    const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentShareUrl)}`;
    window.open(facebookUrl, '_blank', 'width=600,height=400');
}

function shareViaTwitter() {
    const text = 'Check out this shared link';
    const twitterUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(currentShareUrl)}&text=${encodeURIComponent(text)}`;
    window.open(twitterUrl, '_blank', 'width=600,height=400');
}

function shareViaLinkedIn() {
    const linkedinUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(currentShareUrl)}`;
    window.open(linkedinUrl, '_blank', 'width=600,height=400');
}

// Utility functions
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Handle expiry selection
document.querySelector('select[name="expiry"]').addEventListener('change', function(e) {
    const customExpiry = document.getElementById('customExpiry');
    if (e.target.value === 'custom') {
        customExpiry.classList.remove('d-none');
        // Set min date to tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        document.querySelector('input[name="custom_expiry_date"]').min = tomorrow.toISOString().split('T')[0];
        document.querySelector('input[name="custom_expiry_date"]').value = '';
    } else {
        customExpiry.classList.add('d-none');
    }
});

// Handle form submission
document.getElementById('shareForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Show loading state
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Generating...';
    submitButton.disabled = true;
    
    // Remove custom_expiry_date if expiry is not 'custom'
    const expiryType = formData.get('expiry');
    if (expiryType !== 'custom') {
        formData.delete('custom_expiry_date');
    } else {
        const customDate = formData.get('custom_expiry_date');
        if (!customDate) {
            alert('Please select a custom expiry date');
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
            return;
        }
    }
    
    fetch('{{ route("principal.links.generate-share") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            return response.json().then(err => { 
                console.log('Error response:', err);
                throw err; 
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Success response:', data);
        if (data.success) {
            currentShareUrl = data.share_url;
            document.getElementById('shareUrl').value = data.share_url;
            document.getElementById('shareUrlSection').classList.remove('d-none');
            document.getElementById('shareUrlSection').scrollIntoView({ behavior: 'smooth' });
        } else {
            let errorMessage = 'Error generating share link';
            if (data.errors) {
                errorMessage = Object.values(data.errors).flat().join('\n');
            } else if (data.message) {
                errorMessage = data.message;
            }
            alert(errorMessage);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        let errorMessage = 'Error generating share link';
        
        if (error.errors) {
            errorMessage = Object.values(error.errors).flat().join('\n');
        } else if (error.message) {
            errorMessage = error.message;
        }
        
        alert(errorMessage);
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
});
</script>
@endsection