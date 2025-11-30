   // Global variables
    let currentEditingNoteId = null;
    let attachments = []; // Store attachments for the current note

    // ===== MAIN TOGGLE NOTE FORM FUNCTION =====
    function toggleNoteForm() {
        console.log('Toggle note form function called');
        const formContainer = document.getElementById('noteFormContainer');
        const form = document.getElementById('noteForm');
        const submitButton = form?.querySelector('button[type="submit"]');

        if (formContainer) {
            formContainer.classList.toggle('hidden');

            if (!formContainer.classList.contains('hidden')) {
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
                // Hide form - reset to create mode
                if (form) {
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
                    if (submitButton) {
                        submitButton.innerHTML = '<i class="mr-2 fa-solid fa-save"></i>Save Note';
                        submitButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                        submitButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
                    }

                    // Reset character count
                    const charCount = document.getElementById('charCount');
                    if (charCount) charCount.textContent = '0';
                }
            }
        } else {
            console.error('Note form container not found!');
        }
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

    // Add link to attachments
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

    // Handle file selection
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

    // Update attachments preview
    function updateAttachmentsPreview() {
        const previewContainer = document.getElementById('attachmentsPreview');
        const attachmentsList = document.getElementById('attachmentsList');

        if (attachments.length === 0) {
            previewContainer.classList.add('hidden');
            attachmentsList.innerHTML = '';
            return;
        }

        previewContainer.classList.remove('hidden');
        attachmentsList.innerHTML = '';

        attachments.forEach((attachment, index) => {
            const attachmentElement = document.createElement('div');
            attachmentElement.className = 'flex items-center justify-between bg-gray-50 p-3 rounded-lg border border-gray-200';

            if (attachment.type === 'link') {
                attachmentElement.innerHTML = `
                    <div class="flex items-center flex-1 space-x-3">
                        <i class="text-blue-500 fa-solid fa-link"></i>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">${attachment.name}</p>
                            <p class="text-xs text-gray-500 truncate">${attachment.url}</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeAttachment(${index})" class="ml-2 text-red-500 hover:text-red-700">
                        <i class="fa-solid fa-times"></i>
                    </button>
                `;
            } else if (attachment.type === 'file') {
                const size = (attachment.size / 1024 / 1024).toFixed(2);
                const fileExtension = attachment.name.split('.').pop().toLowerCase();
                const icon = getFileIcon(fileExtension);

                attachmentElement.innerHTML = `
                    <div class="flex items-center flex-1 space-x-3">
                        <i class="fa-solid ${icon} text-green-500"></i>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">${attachment.name}</p>
                            <p class="text-xs text-gray-500">${size} MB</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeAttachment(${index})" class="ml-2 text-red-500 hover:text-red-700">
                        <i class="fa-solid fa-times"></i>
                    </button>
                `;
            }

            attachmentsList.appendChild(attachmentElement);
        });
    }

    // Get appropriate file icon
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

    // Remove attachment
    function removeAttachment(index) {
        attachments.splice(index, 1);
        updateAttachmentsPreview();
        showNotification('Attachment removed', 'info');
    }

    // ===== EDIT NOTE FUNCTION =====
    async function editNote(activityId) {
        try {
            console.log('Editing note:', activityId);
            
            // Close any open dropdowns
            closeAllDropdowns();

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
                        submitButton.innerHTML = '<i class="mr-2 fa-solid fa-save"></i>Update Note';
                        submitButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        submitButton.classList.add('bg-green-600', 'hover:bg-green-700');
                    }
                }

                // Show the form if hidden
                const formContainer = document.getElementById('noteFormContainer');
                if (formContainer && formContainer.classList.contains('hidden')) {
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

    // ===== DELETE NOTE FUNCTION =====
    async function deleteNote(activityId) {
        if (!confirm('Are you sure you want to delete this note? This action cannot be undone.')) {
            return;
        }

        try {
            console.log('Deleting note:', activityId);
            
            // Close any open dropdowns
            closeAllDropdowns();

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
                // Remove the note from the DOM with animation
                const noteElement = document.querySelector(`[data-activity-id="${activityId}"]`);
                if (noteElement) {
                    noteElement.style.opacity = '0';
                    noteElement.style.transform = 'translateX(-100%)';
                    setTimeout(() => {
                        noteElement.remove();
                        updateActivityStats();
                        
                        // Check if no activities left, show empty state
                        const activitiesList = document.getElementById('activitiesList');
                        const remainingActivities = activitiesList.querySelectorAll('[data-activity-id]');
                        if (remainingActivities.length === 0) {
                            showEmptyState();
                        }
                    }, 300);
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

    // ===== TOGGLE PIN NOTE FUNCTION =====
    async function togglePinNote(activityId) {
        try {
            console.log('Toggling pin for note:', activityId);
            
            // Close any open dropdowns
            closeAllDropdowns();

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
                // Update the note element immediately
                const noteElement = document.querySelector(`[data-activity-id="${activityId}"]`);
                if (noteElement) {
                    const isPinned = result.activity.pinned;

                    // Toggle pinned styles
                    if (isPinned) {
                        noteElement.classList.add('bg-yellow-50', 'border-yellow-200');
                        noteElement.classList.remove('bg-white');
                    } else {
                        noteElement.classList.remove('bg-yellow-50', 'border-yellow-200');
                        noteElement.classList.add('bg-white');
                    }

                    // Update pinned badge
                    let pinnedBadge = noteElement.querySelector('.pinned-badge');
                    if (isPinned) {
                        if (!pinnedBadge) {
                            pinnedBadge = document.createElement('span');
                            pinnedBadge.className = 'inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full pinned-badge';
                            pinnedBadge.innerHTML = '<i class="mr-1 fa-solid fa-thumbtack"></i>Pinned';
                            // Find the flex-wrap container and append the badge
                            const flexWrap = noteElement.querySelector('.flex-wrap');
                            if (flexWrap) {
                                flexWrap.appendChild(pinnedBadge);
                            }
                        }
                        pinnedBadge.classList.remove('hidden');
                    } else if (pinnedBadge) {
                        pinnedBadge.remove(); // Remove the badge entirely when unpinned
                    }

                    // Update pin button text in dropdown
                    const pinButton = noteElement.querySelector('.pin-note-btn');
                    if (pinButton) {
                        const pinText = pinButton.querySelector('.pin-text');
                        if (pinText) {
                            pinText.textContent = isPinned ? 'Unpin' : 'Pin';
                        }
                    }

                    // Move pinned notes to top
                    if (isPinned) {
                        const activitiesList = document.getElementById('activitiesList');
                        activitiesList.insertBefore(noteElement, activitiesList.firstChild);
                    }
                }

                showNotification(result.message, 'success');
            } else {
                throw new Error(result.message || 'Failed to toggle pin');
            }
        } catch (error) {
            console.error('Error toggling pin:', error);
            showNotification('Error toggling pin: ' + error.message, 'error');
        }
    }

    // ===== CANCEL EDIT FUNCTION =====
    function cancelEdit(activityId) {
        const editForm = document.getElementById(`edit-form-${activityId}`);
        if (editForm) {
            editForm.classList.add('hidden');
        }
        showNotification('Edit cancelled', 'info');
    }

    // ===== DELETE PRINCIPAL REPLY FUNCTION =====
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

    // Enhanced notification system
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.custom-notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' :
            type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';

        notification.className = `custom-notification fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 translate-x-full`;
        notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="fa-solid ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'}"></i>
                <span class="font-medium">${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 5000);

        // Click to dismiss
        notification.addEventListener('click', () => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        });
    }

    // Update activity stats
    function updateActivityStats() {
        const activityCount = document.querySelectorAll('[data-activity-id]').length;
        const activityStatsElement = document.querySelector('[data-activity-stats]');

        if (activityStatsElement) {
            activityStatsElement.textContent = activityCount;
        }
    }

    // Show empty state
    function showEmptyState() {
        const activitiesList = document.getElementById('activitiesList');
        activitiesList.innerHTML = `
            <div class="py-12 text-center text-gray-500 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50">
                <i class="mb-4 text-5xl text-gray-300 fa-solid fa-inbox"></i>
                <p class="mb-2 text-lg font-medium text-gray-400">No activities yet</p>
                <p class="mb-4 text-sm text-gray-400">Start by adding your first note above</p>
                <button onclick="toggleNoteForm()" class="inline-flex items-center px-4 py-2 text-white transition duration-200 bg-blue-600 rounded-lg hover:bg-blue-700">
                    <i class="mr-2 fa-solid fa-plus"></i>
                    Add Your First Note
                </button>
            </div>
        `;
    }

    // Close all dropdowns
    function closeAllDropdowns() {
        document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }

    // Toggle dropdown function
    function toggleDropdown(button) {
        const dropdown = button.nextElementSibling;
        const allDropdowns = document.querySelectorAll('.dropdown-menu');

        // Close all other dropdowns
        allDropdowns.forEach(dd => {
            if (dd !== dropdown) {
                dd.classList.add('hidden');
            }
        });

        // Toggle current dropdown
        dropdown.classList.toggle('hidden');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.group')) {
            closeAllDropdowns();
        }
    });

    // Rich text formatting functions
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

    // ===== INITIALIZE EVERYTHING WHEN PAGE LOADS =====
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
                const originalText = submitButton.innerHTML;
                const originalClass = submitButton.className;

                // Show loading state
                submitButton.innerHTML = '<i class="mr-2 fa-solid fa-spinner fa-spin"></i>' +
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
                        submitButton.innerHTML = '<i class="mr-2 fa-solid fa-save"></i>Save Note';
                        submitButton.className = originalClass;

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
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }
            });
        }

        console.log('Notes functionality initialized successfully');
    });



    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Show notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-check"></i>
                    <span>Copied to clipboard!</span>
                </div>
            `;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 2000);
        });
    }
