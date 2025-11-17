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
                
                <!-- Expiry - FIXED: Uncommented and corrected -->
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

                <!-- Mask Fields -->
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="mask_fields" value="1" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Mask emails/phones (partially hide)</span>
                    </label>
                </div>

                <!-- Watermark -->
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="watermark" value="1" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Show watermark (viewer email/IP/time)</span>
                    </label>
                </div>

                <!-- Disable Copy/Print -->
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="disable_copy_print" value="1" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Disable copy/print (best effort)</span>
                    </label>
                </div>

                <!-- Allow Downloads -->
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="allow_downloads" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Allow download of attachments</span>
                    </label>
                </div>

                <!-- Share URL (will be populated after creation) -->
                <div class="mb-4 hidden" id="shareUrlSection">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Share URL</label>
                    <div class="flex">
                        <input type="text" id="shareUrl" readonly class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 text-sm bg-gray-50">
                        <button type="button" onclick="copyShareUrl()" class="bg-blue-600 text-white px-3 py-2 rounded-r-md text-sm hover:bg-blue-700">
                            Copy
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Share this URL with others</p>
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

function openShareModal(linkId) {
    document.getElementById('shareLinkId').value = linkId;
    document.getElementById('shareModal').classList.remove('hidden');
    document.getElementById('shareUrlSection').classList.add('hidden');
    
    // Reset form to default state
    document.getElementById('shareForm').reset();
    document.querySelector('select[name="expiry"]').value = '30';
    document.getElementById('customExpiry').classList.add('hidden');
}

function closeShareModal() {
    document.getElementById('shareModal').classList.add('hidden');
}

function copyShareUrl() {
    const shareUrl = document.getElementById('shareUrl');
    shareUrl.select();
    shareUrl.setSelectionRange(0, 99999); // For mobile devices
    
    try {
        navigator.clipboard.writeText(shareUrl.value).then(() => {
            // Show success feedback
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
        // Fallback for older browsers
        document.execCommand('copy');
        alert('Share URL copied to clipboard!');
    }
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
    
    // Validate custom date if custom expiry is selected
    const expiryType = formData.get('expiry');
    if (expiryType === 'custom') {
        const customDate = formData.get('custom_expiry_date');
        if (!customDate) {
            alert('Please select a custom expiry date');
            submitButton.textContent = originalText;
            submitButton.disabled = false;
            return;
        }
        
        // Validate date is in the future
        const selectedDate = new Date(customDate);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (selectedDate <= today) {
            alert('Please select a future date for expiry');
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
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            currentShareUrl = data.share_url;
            document.getElementById('shareUrl').value = data.share_url;
            document.getElementById('shareUrlSection').classList.remove('hidden');
            
            // Scroll to share URL section
            document.getElementById('shareUrlSection').scrollIntoView({ behavior: 'smooth' });
        } else {
            alert('Error: ' + (data.message || 'Unknown error occurred'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        let errorMessage = 'Error generating share link';
        
        if (error.errors) {
            // Handle Laravel validation errors
            errorMessage = Object.values(error.errors).flat().join('\n');
        } else if (error.message) {
            errorMessage = error.message;
        }
        
        alert(errorMessage);
    })
    .finally(() => {
        // Restore button state
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