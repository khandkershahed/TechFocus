<div id="cookie-banner" class="hidden fixed bottom-0 left-0 right-0 bg-gray-900 text-white p-4 z-50 shadow-lg">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
            <div class="mb-4 md:mb-0 md:mr-6 flex-1">
                <h3 class="font-bold text-lg mb-2">🍪 We Use Cookies</h3>
                <p class="text-sm text-gray-300">
                    We use cookies to enhance your browsing experience, serve personalized content, 
                    and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.
                </p>
                <div class="mt-2">
                    <a href="{{ route('cookie.policy') }}" 
                       class="text-blue-400 hover:text-blue-300 underline text-sm">
                        Read our Cookie Policy
                    </a>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-2">
                <button onclick="manageCookies()" 
                        class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded text-sm transition">
                    Manage Preferences
                </button>
                <button onclick="rejectAllCookies()" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded text-sm transition">
                    Reject All
                </button>
                <button onclick="acceptAllCookies()" 
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded text-sm transition">
                    Accept All
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cookie Preferences Modal -->
<div id="cookie-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Cookie Preferences</h3>
                <button onclick="closeCookieModal()" class="text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>
            
            <div class="space-y-4">
                <!-- Necessary Cookies (Always on) -->
                <div class="border rounded p-4">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <h4 class="font-semibold">Necessary Cookies</h4>
                            <p class="text-sm text-gray-600">Required for the website to function</p>
                        </div>
                        <div class="relative">
                            <input type="checkbox" id="necessary" checked disabled 
                                   class="opacity-50 cursor-not-allowed">
                            <label for="necessary" class="sr-only">Necessary Cookies</label>
                        </div>
                    </div>
                </div>
                
                <!-- Analytics Cookies -->
                <div class="border rounded p-4">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <h4 class="font-semibold">Analytics Cookies</h4>
                            <p class="text-sm text-gray-600">Help us understand how visitors interact</p>
                        </div>
                        <div class="relative">
                            <input type="checkbox" id="analytics" 
                                   class="cookie-toggle">
                            <label for="analytics" class="sr-only">Analytics Cookies</label>
                        </div>
                    </div>
                </div>
                
                <!-- Marketing Cookies -->
                <div class="border rounded p-4">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <h4 class="font-semibold">Marketing Cookies</h4>
                            <p class="text-sm text-gray-600">Used to track visitors across websites</p>
                        </div>
                        <div class="relative">
                            <input type="checkbox" id="marketing" 
                                   class="cookie-toggle">
                            <label for="marketing" class="sr-only">Marketing Cookies</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex gap-2">
                <button onclick="closeCookieModal()" 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button onclick="savePreferences()" 
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Save Preferences
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Check cookie consent on page load
document.addEventListener('DOMContentLoaded', function() {
    checkCookieConsent();
    
    // Load saved preferences if any
    loadSavedPreferences();
});

function checkCookieConsent() {
    fetch('{{ route("cookie.check") }}')
        .then(response => response.json())
        .then(data => {
            if (data.show_banner) {
                document.getElementById('cookie-banner').classList.remove('hidden');
            }
        })
        .catch(error => console.error('Error checking cookie consent:', error));
}

function acceptAllCookies() {
    const preferences = {
        necessary: true,
        analytics: true,
        marketing: true
    };
    
    saveConsent(true, preferences);
}

function rejectAllCookies() {
    const preferences = {
        necessary: true, // Always required
        analytics: false,
        marketing: false
    };
    
    saveConsent(false, preferences);
}

function manageCookies() {
    document.getElementById('cookie-modal').classList.remove('hidden');
}

function closeCookieModal() {
    document.getElementById('cookie-modal').classList.add('hidden');
}

function loadSavedPreferences() {
    fetch('{{ route("cookie.status") }}')
        .then(response => response.json())
        .then(data => {
            if (data.preferences) {
                // Set toggle states based on saved preferences
                if (data.preferences.analytics) {
                    document.getElementById('analytics').checked = true;
                }
                if (data.preferences.marketing) {
                    document.getElementById('marketing').checked = true;
                }
            }
        });
}

function savePreferences() {
    const preferences = {
        necessary: true,
        analytics: document.getElementById('analytics').checked,
        marketing: document.getElementById('marketing').checked
    };
    
    const accepted = preferences.analytics || preferences.marketing;
    saveConsent(accepted, preferences);
    closeCookieModal();
}

function saveConsent(accepted, preferences) {
    fetch('{{ route("cookie.consent.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            accepted: accepted,
            preferences: preferences
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hide the banner
            document.getElementById('cookie-banner').classList.add('hidden');
            
            // Reload page if needed to apply cookie settings
            if (preferences.analytics) {
                // Initialize analytics scripts
                initializeAnalytics();
            }
        }
    })
    .catch(error => console.error('Error saving cookie consent:', error));
}

function initializeAnalytics() {
    // Initialize your analytics scripts here
    // Example: Google Analytics, Facebook Pixel, etc.
    console.log('Analytics cookies accepted, initializing tracking...');
}
</script>

<style>
#cookie-banner {
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        transform: translateY(100%);
    }
    to {
        transform: translateY(0);
    }
}

.cookie-toggle {
    appearance: none;
    width: 44px;
    height: 24px;
    background: #d1d5db;
    border-radius: 12px;
    position: relative;
    cursor: pointer;
    transition: background-color 0.3s;
}

.cookie-toggle:checked {
    background: #10b981;
}

.cookie-toggle:after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 20px;
    height: 20px;
    background: white;
    border-radius: 50%;
    transition: transform 0.3s;
}

.cookie-toggle:checked:after {
    transform: translateX(20px);
}
</style>
@endpush