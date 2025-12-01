@extends('principal.layouts.app')

@section('content')
<div class="container min-h-screen p-4 mx-auto antialiased bg-slate-50 md:p-8">

    {{-- Header & Actions --}}
    <div class="flex flex-col items-start justify-between p-6 mb-6 bg-white border shadow-xl border-slate-100 rounded-2xl md:flex-row md:items-center">
        <div>
            <h1 class="mb-2 text-3xl font-extrabold text-slate-900 md:text-4xl">
                COMPANY NAME LLC
            </h1>
            <div class="flex flex-wrap items-center gap-3">
                <span class="px-3 py-1 text-xs font-semibold rounded-full shadow-sm text-cyan-700 bg-cyan-100">
                    <i class="mr-1 fa fa-industry"></i> Supplier Type: Manufacturer
                </span>
                <span class="text-sm font-medium text-slate-500">
                    <i class="mr-1 fa fa-hashtag"></i> Supplier ID: SUP-00123
                </span>
                <span class="px-3 py-1 text-xs font-semibold rounded-full text-emerald-700 bg-emerald-100">
                    <i class="mr-1 fa fa-check-circle"></i> Active
                </span>
                <span class="px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">
                    <i class="mr-1 fa fa-stamp"></i> Authorized
                </span>
                <span class="px-3 py-1 text-xs font-semibold rounded-full text-amber-800 bg-amber-100">
                    Key Vendor
                </span>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 p-3 mt-4 md:mt-0">
            <button onclick="openModal('noteModal')" class="flex items-center px-5 py-2 text-white transition duration-200 rounded-full shadow-md bg-cyan-600 hover:bg-cyan-700 hover:shadow-lg">
                <i class="mr-2 fa fa-pen"></i> Edit
            </button>
            <button onclick="openModal('shareModal')" class="flex items-center px-5 py-2 transition duration-200 border rounded-full text-slate-700 border-slate-300 hover:bg-slate-100">
                <i class="mr-2 fa fa-share-nodes"></i> Share
            </button>
            <button onclick="openModal('noteModal')" class="flex items-center px-5 py-2 transition duration-200 border rounded-full text-slate-700 border-slate-300 hover:bg-slate-100">
                <i class="mr-2 fa fa-sticky-note"></i> Add Note
            </button>
            <button onclick="openModal('archiveModal')" class="flex items-center px-5 py-2 text-red-600 transition duration-200 border border-red-200 rounded-full hover:bg-red-50">
                <i class="mr-2 fa fa-box-archive"></i> Archive
            </button>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 gap-6 mb-10 md:grid-cols-4">
        <div class="p-5 text-center bg-white rounded-xl shadow-md border-t-4 border-cyan-500 transition duration-300 hover:shadow-xl hover:scale-[1.01]">
            <h6 class="mb-1 text-sm font-medium text-slate-500">Assigned Manager</h6>
            <p class="text-xl font-extrabold text-slate-800 md:text-2xl">John Smith</p>
        </div>
        <div class="p-5 text-center bg-white rounded-xl shadow-md border-t-4 border-cyan-500 transition duration-300 hover:shadow-xl hover:scale-[1.01]">
            <h6 class="mb-1 text-sm font-medium text-slate-500">2024 Purchase</h6>
            <p class="text-xl font-extrabold text-green-600 md:text-2xl">$1.2M USD</p>
        </div>
        <div class="p-5 text-center bg-white rounded-xl shadow-md border-t-4 border-red-500 transition duration-300 hover:shadow-xl hover:scale-[1.01]">
            <h6 class="mb-1 text-sm font-medium text-slate-500">Risk Level</h6>
            <p class="text-xl font-extrabold text-red-600 md:text-2xl">High (7/10)</p>
        </div>
        <div class="p-5 text-center bg-white rounded-xl shadow-md border-t-4 border-cyan-500 transition duration-300 hover:shadow-xl hover:scale-[1.01]">
            <h6 class="mb-1 text-sm font-medium text-slate-500">Relationship Since</h6>
            <p class="text-xl font-extrabold text-slate-800 md:text-2xl">2019</p>
        </div>
    </div>

    <div class="grid gap-8 md:grid-cols-3">

        {{-- Left Column --}}
        <div class="space-y-8 md:col-span-2">

            {{-- Company Info --}}
            <div class="p-6 bg-white border shadow-xl border-slate-100 rounded-xl">
                <h2 class="pb-2 mb-4 text-2xl font-extrabold border-b-2 text-slate-800 border-cyan-100">Company & Contact Details</h2>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl hover:shadow-lg">
                        <h3 class="mb-4 text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-building"></i> Company Info</h3>
                        <p><strong>Company Name:</strong> Company LLC [cite: 31]</p>
                        <p><strong>Website:</strong> <a href="#" class="text-cyan-600 hover:underline">http://company.com</a></p>
                        <p><strong>Country:</strong> USA</p>
                        <p class="pt-2"><strong>Tags:</strong> <span class="px-3 py-1 text-xs font-semibold rounded-full text-amber-800 bg-amber-100">Key Vendor</span></p>
                    </div>
                </div>

                {{-- Contacts Tabs --}}
                <div class="p-6 mt-6 bg-white border shadow-xl border-slate-100 rounded-xl">
                    <h3 class="mb-3 text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-user-tie"></i> Contacts</h3>
                    <div class="mb-4 border-b border-slate-200">
                        <ul class="flex -mb-px space-x-4" role="tablist">
                            <li><button data-target="contact-primary" class="inline-block px-1 py-2 font-semibold border-b-2 tab-btn text-cyan-600 border-cyan-600">Primary</button></li>
                            <li><button data-target="contact-secondary" class="inline-block px-1 py-2 border-b-2 border-transparent tab-btn text-slate-500 hover:text-slate-600 hover:border-slate-300">Secondary</button></li>
                            <li><button data-target="contact-other" class="inline-block px-1 py-2 border-b-2 border-transparent tab-btn text-slate-500 hover:text-slate-600 hover:border-slate-300">Other</button></li>
                        </ul>
                    </div>

                    <div id="contact-primary" class="grid grid-cols-1 gap-4 tab-content text-slate-700 md:grid-cols-2">
                        <div>
                            <p><strong>Name:</strong> Jane Doe</p>
                            <p><strong>Designation:</strong> Head of Sales</p>
                            <p><strong>Social:</strong> <a href="#" class="text-cyan-600 hover:underline"><i class="fa-brands fa-linkedin"></i> LinkedIn</a></p>
                        </div>
                        <div>
                            <p><strong>Email:</strong> jane@company.com</p>
                            <p><strong>Phone:</strong> +1 555 123 4567</p>
                        </div>
                    </div>

                    <div id="contact-secondary" class="grid hidden grid-cols-1 gap-4 tab-content text-slate-700 md:grid-cols-2">
                        <div>
                            <p><strong>Name:</strong> Mark Johnson</p>
                            <p><strong>Designation:</strong> Logistics Coordinator</p>
                        </div>
                        <div>
                            <p><strong>Email:</strong> mark@company.com</p>
                            <p><strong>Phone:</strong> +1 555 987 6543</p>
                        </div>
                    </div>

                    <div id="contact-other" class="hidden tab-content">
                        <div>
                            <p><strong>Name:</strong> Lisa Ray</p>
                            <p><strong>Designation:</strong> Consultant</p>
                        </div>
                        <div>
                            <p><strong>Email:</strong> lisa@company.com</p>
                            <p><strong>Phone:</strong> +1 555 321 7654</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Brand & Product Info --}}
            <div class="grid gap-8 mt-6 md:grid-cols-2">
                <div class="p-6 space-y-3 bg-white border shadow-md border-slate-100 rounded-xl">
                    <h3 class="text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-certificate"></i> Brand Info</h3>
                    <p><strong>Brand List:</strong> Brand X, Brand Y, Brand Z</p>
                    <p><strong>Authorization Status:</strong> <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Authorized</span></p>
                    <p><strong>Authorization Expiry:</strong> 2026-12-31</p>
                    <p><strong>Product Categories:</strong> Electronics, Hardware, Accessories</p>
                    <div class="flex flex-wrap gap-3 pt-4 border-t border-slate-100">
                        <button class="flex items-center px-4 py-2 text-white rounded-lg bg-cyan-600 hover:bg-cyan-700"><i class="mr-2 fa fa-download"></i> Download Docs</button>
                        <button class="flex items-center px-4 py-2 border rounded-lg text-slate-700 border-slate-300 hover:bg-slate-100"><i class="mr-2 fa fa-upload"></i> Upload Docs</button>
                    </div>
                </div>
                <div class="p-6 space-y-4 bg-white border shadow-md border-slate-100 rounded-xl">
                    <h3 class="text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-boxes-stacked"></i> Product List</h3>
                    <table class="min-w-full divide-y table-auto divide-slate-200">
                        <thead class="bg-cyan-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-slate-700">Product Name</th>
                                <th class="hidden px-4 py-3 text-left text-slate-700 sm:table-cell">SKU</th>
                                <th class="px-4 py-3 text-left text-slate-700">Status</th>
                                <th class="px-4 py-3 text-left text-slate-700">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">Widget Pro Max</td>
                                <td class="hidden px-4 py-3 sm:table-cell">WPM-001</td>
                                <td class="px-4 py-3"><span class="px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">Active</span></td>
                                <td class="px-4 py-3"><button onclick="openModal('productModal')" class="text-sm font-medium text-cyan-600 hover:text-cyan-800">View Details</button></td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">Gadget Plus</td>
                                <td class="hidden px-4 py-3 sm:table-cell">GP-002</td>
                                <td class="px-4 py-3"><span class="px-3 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-full">Pending</span></td>
                                <td class="px-4 py-3"><button onclick="openModal('productModal')" class="text-sm font-medium text-cyan-600 hover:text-cyan-800">View Details</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-8">
            {{-- Addresses --}}
            <div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl">
                <h3 class="mb-4 text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-map-marked-alt"></i> Addresses</h3>
                <p>Head Office: 123 Main St, NY</p>
                <p>Factory: Industrial Zone, NY</p>
                <p>Shipping: 99 Warehouse Rd, NY</p>
                <p>Billing: Same as Head Office</p>
            </div>

            {{-- Quick Contact --}}
            <div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl">
                <h3 class="mb-4 text-xl font-semibold text-slate-700"><i class="mr-2 text-cyan-500 fa fa-bolt-lightning"></i> Quick Contact</h3>
                <div class="flex space-x-3">
                    <button class="flex items-center justify-center w-12 h-12 border rounded-full border-slate-300 hover:bg-slate-100"><i class="fa fa-phone"></i></button>
                    <button class="flex items-center justify-center w-12 h-12 border rounded-full border-slate-300 hover:bg-slate-100"><i class="fa fa-envelope"></i></button>
                    <button class="flex items-center justify-center w-12 h-12 text-green-600 border border-green-300 rounded-full hover:bg-green-100"><i class="fa-brands fa-whatsapp"></i></button>
                </div>
            </div>
        </div>
    </div>

    {{-- Timeline, Alerts, Agreements --}}
    <div class="grid gap-6 mt-8 md:grid-cols-3">
        {{-- Relationship Timeline --}}
        <div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl">
            <h3 class="mb-4 text-xl font-semibold text-slate-700">Relationship Timeline</h3>
            <ol class="relative border-l border-gray-200">
                <li class="mb-10 ml-4">
                    <div class="absolute w-3 h-3 bg-cyan-600 rounded-full -left-1.5 border border-white"></div>
                    <time class="mb-1 text-sm text-gray-500">2020</time>
                    <h4 class="text-lg font-semibold text-gray-900">Onboarded</h4>
                </li>
                <li class="mb-10 ml-4">
                    <div class="absolute w-3 h-3 bg-cyan-600 rounded-full -left-1.5 border border-white"></div>
                    <time class="mb-1 text-sm text-gray-500">2022</time>
                    <h4 class="text-lg font-semibold text-gray-900">Certified Supplier</h4>
                </li>
                <li class="ml-4">
                    <div class="absolute w-3 h-3 bg-cyan-600 rounded-full -left-1.5 border border-white"></div>
                    <time class="mb-1 text-sm text-gray-500">2024</time>
                    <h4 class="text-lg font-semibold text-gray-900">Preferred Vendor</h4>
                </li>
            </ol>
        </div>

        {{-- Document Expiry Alerts --}}
        <div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl">
            <h3 class="mb-4 text-xl font-semibold text-slate-700">Document Expiry Alerts</h3>
            <ul class="space-y-3 text-sm text-gray-700">
                <li class="p-3 border border-red-100 rounded-lg bg-red-50"><span class="font-semibold">Insurance Certificate:</span> Expiring in 30 days</li>
                <li class="p-3 border border-yellow-100 rounded-lg bg-yellow-50"><span class="font-semibold">ISO Certification:</span> Expiring in 90 days</li>
                <li class="p-3 border border-green-100 rounded-lg bg-green-50"><span class="font-semibold"></span>Contract Agreement:</span></span> Active until 2026</li>
                <li class="p-3 border border-red-100 rounded-lg bg-red-50">Safety Audit: Expiring in 15 days</li>
            </ul>
        </div>

        {{-- Partner Agreements --}}
        <div class="p-6 bg-white border shadow-md border-slate-100 rounded-xl">
            <h3 class="mb-4 text-xl font-semibold text-slate-700">Partner Agreements</h3>
            <ul class="space-y-3 text-sm text-gray-700">
                <li class="p-3 bg-white border border-gray-200 rounded-lg hover:bg-cyan-50">2023 - Supply Contract</li>
                <li class="p-3 bg-white border border-gray-200 rounded-lg hover:bg-cyan-50">2024 - NDA Agreement</li>
                <li class="p-3 bg-white border border-gray-200 rounded-lg hover:bg-cyan-50">2025 - Logistics Partnership</li>
                <li class="p-3 bg-white border border-gray-200 rounded-lg hover:bg-cyan-50">2024 - Tech Support SLA</li>
            </ul>
        </div>
    </div>

</div>

{{-- Modals --}}
<dialog id="noteModal" class="fixed inset-0 z-50 flex items-center justify-center hidden p-4 bg-black/30">
    <div class="w-full max-w-lg p-6 bg-white rounded-xl">
        <h3 class="mb-4 text-xl font-bold text-slate-800">Add Note</h3>
        <textarea class="w-full p-3 border rounded-md" rows="5" placeholder="Type your note here..."></textarea>
        <div class="flex justify-end mt-4 space-x-3">
            <button onclick="closeModal('noteModal')" class="px-4 py-2 text-white rounded-lg bg-cyan-600 hover:bg-cyan-700">Save</button>
            <button onclick="closeModal('noteModal')" class="px-4 py-2 border rounded-lg border-slate-300 hover:bg-slate-100">Cancel</button>
        </div>
    </div>
</dialog>

<dialog id="productModal" class="fixed inset-0 z-50 flex items-center justify-center hidden p-4 bg-black/30">
    <div class="w-full max-w-2xl p-6 bg-white rounded-xl">
        <h3 class="mb-4 text-xl font-bold text-slate-800">Product Details</h3>
        <p><strong>Name:</strong> Widget Pro Max</p>
        <p><strong>SKU:</strong> WPM-001</p>
        <p><strong>Status:</strong> Active</p>
        <p><strong>Description:</strong> This is a sample description for the product.</p>
        <div class="flex justify-end mt-4">
            <button onclick="closeModal('productModal')" class="px-4 py-2 text-white rounded-lg bg-cyan-600 hover:bg-cyan-700">Close</button>
        </div>
    </div>
</dialog>

<dialog id="shareModal" class="fixed inset-0 z-50 flex items-center justify-center hidden p-4 bg-black/30">
    <div class="w-full max-w-lg p-6 bg-white rounded-xl">
        <h3 class="mb-4 text-xl font-bold text-slate-800">Share Company Info</h3>
        <input type="email" class="w-full p-3 border rounded-md" placeholder="Recipient Email">
        <div class="flex justify-end mt-4 space-x-3">
            <button onclick="closeModal('shareModal')" class="px-4 py-2 text-white rounded-lg bg-cyan-600 hover:bg-cyan-700">Share</button>
            <button onclick="closeModal('shareModal')" class="px-4 py-2 border rounded-lg border-slate-300 hover:bg-slate-100">Cancel</button>
        </div>
    </div>
</dialog>

<dialog id="archiveModal" class="fixed inset-0 z-50 flex items-center justify-center hidden p-4 bg-black/30">
    <div class="w-full max-w-md p-6 bg-white rounded-xl">
        <h3 class="mb-4 text-xl font-bold text-slate-800">Archive Company</h3>
        <p>Are you sure you want to archive this company? This action cannot be undone.</p>
        <div class="flex justify-end mt-4 space-x-3">
            <button onclick="closeModal('archiveModal')" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">Archive</button>
            <button onclick="closeModal('archiveModal')" class="px-4 py-2 border rounded-lg border-slate-300 hover:bg-slate-100">Cancel</button>
        </div>
    </div>
</dialog>

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Tabs
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.target;

            btn.closest('ul').querySelectorAll('button').forEach(b => b.classList.remove('text-cyan-600','border-cyan-600','text-slate-700'));
            btn.classList.add('text-cyan-600','border-cyan-600');

            const parent = btn.closest('div');
            parent.querySelectorAll('.tab-content').forEach(tc => tc.classList.add('hidden'));
            document.getElementById(target).classList.remove('hidden');
        });
    });
});

// Modal functions
window.openModal = function(id) {
    const modal = document.getElementById(id);
    if(modal) {
        modal.showModal ? modal.showModal() : modal.classList.remove('hidden');
    }
}
window.closeModal = function(id) {
    const modal = document.getElementById(id);
    if(modal) {
        modal.close ? modal.close() : modal.classList.add('hidden');
    }
}
</script>
@endsection
