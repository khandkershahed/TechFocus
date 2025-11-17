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
                                <!-- Share Button -->
                                <button onclick="openShareModal({{ $link->id }})"
                                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                                    Share
                                </button>

                                <!-- Edit Button -->
                                <a href="{{ route('principal.links.edit', $link->id) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('principal.links.destroy', $link->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete this link?')"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
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
                        <td class="px-4 py-4 border text-center text-gray-500" colspan="7">
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

<!-- ========== ENHANCED SHARE MODAL WITH REAL EMAIL SENDING ========== -->
<div id="shareModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Header -->
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-medium">Share Link</h3>
                <button onclick="closeShareModal()" class="text-gray-400 hover:text-gray-600 text-xl">
                    &times;
                </button>
            </div>

            <!-- Form -->
            <form id="shareForm" method="POST">
                @csrf
                <input type="hidden" name="link_id" id="shareLinkId">
                
                <!-- Expiry -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Expiry</label>
                    <select name="expiry" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="7">7 days</option>
                        <option value="30" selected>30 days</option>
                        <option value="custom">Custom</option>
                    </select>
                    <div id="customExpiry" class="mt-2 hidden">
                        <input type="date" 
                               name="custom_expiry_date" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                        <p class="text-xs text-gray-500 mt-1">Please select a future date</p>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Security Settings</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="mask_fields" value="1" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Mask emails/phones (partially hide)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="watermark" value="1" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Show watermark (viewer IP/time)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="disable_copy_print" value="1" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Disable copy/print (best effort)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="allow_downloads" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Allow download of attachments</span>
                        </label>
                    </div>
                </div>

                <!-- Share URL (will be populated after creation) -->
                <div class="mb-4 hidden" id="shareUrlSection">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Share URL</label>
                    <div class="flex mb-2">
                        <input type="text" id="shareUrl" readonly class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 text-sm bg-gray-50">
                        <button type="button" onclick="copyShareUrl()" class="bg-blue-600 text-white px-3 py-2 rounded-r-md text-sm hover:bg-blue-700">
                            Copy
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mb-3">Share this URL with others</p>

                    <!-- Quick Share Options -->
                    <div class="border-t pt-3">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Quick Share</h4>
                        
                        <!-- Email Sharing -->
                        <div class="mb-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Share via Email</label>
                            <div class="flex space-x-2">
                                <input type="email" id="emailInput" placeholder="Enter email address" 
                                       class="flex-1 border border-gray-300 rounded-md px-2 py-1 text-sm">
                                <button type="button" onclick="shareViaEmail()" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                    Send Email
                                </button>
                            </div>
                            <div class="mt-1">
                                <button type="button" onclick="addEmailField()" class="text-xs text-blue-600 hover:text-blue-800">
                                    + Add another email
                                </button>
                            </div>
                            <div id="additionalEmails" class="mt-1 space-y-1"></div>
                            <p class="text-xs text-gray-500 mt-1">Emails will be sent directly from the system</p>
                        </div>

                        <!-- WhatsApp Sharing -->
                        <div class="mb-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Share via WhatsApp</label>
                            <div class="flex space-x-2">
                                <input type="text" id="whatsappInput" placeholder="Enter phone number" 
                                       class="flex-1 border border-gray-300 rounded-md px-2 py-1 text-sm"
                                       oninput="formatPhoneNumber(this)">
                                <button type="button" onclick="shareViaWhatsApp()" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                    WhatsApp
                                </button>
                            </div>
                        </div>

                        <!-- Email Client Options -->
                        <div class="mb-2">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Or open email client:</label>
                            <div class="flex space-x-2">
                                <button type="button" onclick="shareViaGmail()" class="flex-1 bg-red-600 text-white px-2 py-1 rounded text-sm hover:bg-red-700 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 4.5v15c0 .85-.65 1.5-1.5 1.5H21V7.387l-9 6.463-9-6.463V21H1.5C.65 21 0 20.35 0 19.5v-15c0-.425.162-.8.431-1.068C.7 3.16 1.076 3 1.5 3H2l10 7.25L22 3h.5c.425 0 .8.162 1.069.432.27.268.431.643.431 1.068z"/>
                                    </svg>
                                    Gmail
                                </button>
                                <button type="button" onclick="shareViaOutlook()" class="flex-1 bg-blue-600 text-white px-2 py-1 rounded text-sm hover:bg-blue-700 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12.713l-11.985-9.713h23.97l-11.985 9.713zm0 2.574l-12-9.725v15.438h24v-15.438l-12 9.725z"/>
                                    </svg>
                                    Outlook
                                </button>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="flex space-x-2 mt-2">
                            <button type="button" onclick="shareViaFacebook()" class="flex-1 bg-blue-800 text-white px-2 py-1 rounded text-sm hover:bg-blue-900">
                                Facebook
                            </button>
                            <button type="button" onclick="shareViaTwitter()" class="flex-1 bg-blue-400 text-white px-2 py-1 rounded text-sm hover:bg-blue-500">
                                Twitter
                            </button>
                            <button type="button" onclick="shareViaLinkedIn()" class="flex-1 bg-blue-700 text-white px-2 py-1 rounded text-sm hover:bg-blue-800">
                                LinkedIn
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeShareModal()" class="px-4 py-2 text-sm border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">
                        Generate Share Link
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
    document.getElementById('shareModal').classList.remove('hidden');
    document.getElementById('shareUrlSection').classList.add('hidden');
    
    // Reset form to default state
    document.getElementById('shareForm').reset();
    document.querySelector('select[name="expiry"]').value = '30';
    document.getElementById('customExpiry').classList.add('hidden');
    
    // Reset email fields
    document.getElementById('emailInput').value = '';
    document.getElementById('whatsappInput').value = '';
    document.getElementById('additionalEmails').innerHTML = '';
    emailCount = 0;
    
    // Set default checkboxes
    document.querySelector('input[name="mask_fields"]').checked = true;
    document.querySelector('input[name="watermark"]').checked = true;
    document.querySelector('input[name="disable_copy_print"]').checked = true;
    document.querySelector('input[name="allow_downloads"]').checked = false;
}

function closeShareModal() {
    document.getElementById('shareModal').classList.add('hidden');
}

function copyShareUrl() {
    const shareUrl = document.getElementById('shareUrl');
    shareUrl.select();
    shareUrl.setSelectionRange(0, 99999);
    
    try {
        navigator.clipboard.writeText(shareUrl.value).then(() => {
            const copyButton = document.querySelector('button[onclick="copyShareUrl()"]');
            const originalText = copyButton.textContent;
            copyButton.textContent = 'Copied!';
            copyButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            copyButton.classList.add('bg-green-600');
            
            setTimeout(() => {
                copyButton.textContent = originalText;
                copyButton.classList.remove('bg-green-600');
                copyButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
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
    emailDiv.className = 'flex space-x-2';
    emailDiv.innerHTML = `
        <input type="email" placeholder="Additional email address" 
               class="flex-1 border border-gray-300 rounded-md px-2 py-1 text-sm additional-email">
        <button type="button" onclick="removeEmailField(this)" class="bg-gray-500 text-white px-2 py-1 rounded text-sm hover:bg-gray-600">
            Remove
        </button>
    `;
    document.getElementById('additionalEmails').appendChild(emailDiv);
}

function removeEmailField(button) {
    button.parentElement.remove();
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
    const originalText = emailButton.textContent;
    emailButton.textContent = 'Sending...';
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
        emailButton.textContent = originalText;
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
        customExpiry.classList.remove('hidden');
        // Set min date to tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        document.querySelector('input[name="custom_expiry_date"]').min = tomorrow.toISOString().split('T')[0];
        document.querySelector('input[name="custom_expiry_date"]').value = '';
    } else {
        customExpiry.classList.add('hidden');
    }
});

// Handle form submission
document.getElementById('shareForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    
    // Show loading state
    submitButton.textContent = 'Generating...';
    submitButton.disabled = true;
    
    // Remove custom_expiry_date if expiry is not 'custom'
    const expiryType = formData.get('expiry');
    if (expiryType !== 'custom') {
        formData.delete('custom_expiry_date');
    } else {
        const customDate = formData.get('custom_expiry_date');
        if (!customDate) {
            alert('Please select a custom expiry date');
            submitButton.textContent = originalText;
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
            document.getElementById('shareUrlSection').classList.remove('hidden');
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
        submitButton.textContent = originalText;
        submitButton.disabled = false;
    });
});

// Close modal when clicking outside
document.getElementById('shareModal').addEventListener('click', function(e) {
    if (e.target.id === 'shareModal') {
        closeShareModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('shareModal').classList.contains('hidden')) {
        closeShareModal();
    }
});
</script>

<style>
#shareModal {
    backdrop-filter: blur(2px);
}
</style>
@endsection