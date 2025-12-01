<!DOCTYPE html>
<html lang="en">

<!--begin::Head-->

<head>
	@include('principal.partials.head')
	<!-- Add this to ensure proper cookie handling -->
	<meta name="csrf-param" content="_token">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Font Awesome for icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

	<!-- Add Tailwind CSS -->
	<script src="https://cdn.tailwindcss.com"></script>

	<style>
		/* Your existing custom styles... */
		.line-clamp-2 {
			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}

		/* ... rest of your custom CSS */
	</style>

	<style>
		/* Custom styles for principal dashboard - Bootstrap compatible */
		.line-clamp-2 {
			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}

		.line-clamp-3 {
			display: -webkit-box;
			-webkit-line-clamp: 3;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}

		/* Smooth transitions */
		.transition-all {
			transition: all 0.3s ease;
		}

		/* Custom scrollbar */
		.custom-scrollbar::-webkit-scrollbar {
			width: 6px;
		}

		.custom-scrollbar::-webkit-scrollbar-track {
			background: #f8f9fa;
		}

		.custom-scrollbar::-webkit-scrollbar-thumb {
			background: #dee2e6;
			border-radius: 3px;
		}

		.custom-scrollbar::-webkit-scrollbar-thumb:hover {
			background: #adb5bd;
		}

		/* Modal animations */
		dialog {
			animation: fadeIn 0.3s ease-out;
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
				transform: scale(0.9);
			}

			to {
				opacity: 1;
				transform: scale(1);
			}
		}

		/* Loading states */
		.loading {
			opacity: 0.7;
			pointer-events: none;
		}

		/* Badge animations */
		.badge-pulse {
			animation: pulse 2s infinite;
		}

		@keyframes pulse {
			0% {
				box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4);
			}

			70% {
				box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
			}

			100% {
				box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
			}
		}

		/* Status indicators using Bootstrap colors */
		.status-approved {
			background-color: #d1e7dd;
			color: #0f5132;
			border-color: #badbcc;
		}

		.status-pending {
			background-color: #fff3cd;
			color: #664d03;
			border-color: #ffecb5;
		}

		.status-rejected {
			background-color: #f8d7da;
			color: #842029;
			border-color: #f5c2c7;
		}

		/* Custom shadows */
		.card-shadow {
			box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
		}

		.card-shadow:hover {
			box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
		}

		/* Print styles */
		@media print {
			.no-print {
				display: none !important;
			}
		}

		/* Custom colors for principal dashboard */
		.bg-cyan-50 {
			background-color: rgba(13, 202, 240, 0.1);
		}

		.bg-cyan-100 {
			background-color: rgba(13, 202, 240, 0.2);
		}

		.text-cyan-600 {
			color: #0891b2;
		}

		.text-cyan-700 {
			color: #0e7490;
		}

		.border-cyan-100 {
			border-color: rgba(13, 202, 240, 0.2);
		}

		.bg-slate-50 {
			background-color: #f8f9fa;
		}

		.bg-slate-100 {
			background-color: #e9ecef;
		}

		.text-slate-500 {
			color: #6c757d;
		}

		.text-slate-600 {
			color: #495057;
		}

		.text-slate-700 {
			color: #343a40;
		}

		.text-slate-800 {
			color: #212529;
		}

		.text-slate-900 {
			color: #1a1a1a;
		}

		.border-slate-100 {
			border-color: #dee2e6;
		}

		.border-slate-200 {
			border-color: #ced4da;
		}

		.border-slate-300 {
			border-color: #adb5bd;
		}

		.bg-emerald-100 {
			background-color: rgba(16, 185, 129, 0.2);
		}

		.text-emerald-700 {
			color: #047857;
		}

		.bg-purple-100 {
			background-color: rgba(168, 85, 247, 0.2);
		}

		.text-purple-600 {
			color: #9333ea;
		}

		.bg-amber-100 {
			background-color: rgba(245, 158, 11, 0.2);
		}

		.text-amber-800 {
			color: #92400e;
		}

		/* Hover states */
		.hover-bg-slate-50:hover {
			background-color: #f8f9fa;
		}

		.hover-bg-slate-100:hover {
			background-color: #e9ecef;
		}

		.hover-scale:hover {
			transform: scale(1.02);
		}

		/* Border colors */
		.border-t-4 {
			border-top-width: 4px;
		}

		.border-t-cyan-500 {
			border-top-color: #0dcaf0;
		}

		.border-t-green-500 {
			border-top-color: #198754;
		}

		.border-t-purple-500 {
			border-top-color: #6f42c1;
		}

		/* Custom utilities */
		.min-h-screen {
			min-height: 100vh;
		}

		.antialiased {
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale;
		}
	</style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">
	<!--begin::Main-->
	<!-- Also include CSRF token as hidden input for backup -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	<!--begin::Root-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="flex-row page d-flex flex-column-fluid">
			<!--begin::Aside-->
			@include('principal.partials.sidebar')
			<!--end::Aside-->
			<!--begin::Wrapper-->
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<!--begin::Header-->
				@include('principal.partials.header')
				<!--end::Header-->
				<!--begin::Content-->
				@if(isset($banner) && $banner)
				<section class="banner" style="background-image: url('{{ asset('uploads/page_banners/'.$banner->image) }}')">
					<div class="overlay">
						<h1>{{ $banner->title }}</h1>
						@if($banner->button_name)
						<a href="{{ $banner->button_link }}" class="btn btn-primary">{{ $banner->button_name }}</a>
						@endif
					</div>
				</section>
				@endif
				@yield('content')
				<!--end::Content-->

				<!--begin::Footer-->
				@include('admin.partials.footer')
				<!--end::Footer-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
	<!--end::Root-->

	<!--begin::Drawers-->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>
		// DataTable initialization
		class DataTableManager {
			constructor(selector = '.dataTable') {
				this.selector = selector;
			}

			init() {
				// Initialize all tables matching the class
				$(this.selector).each(function() {
					if (!$.fn.DataTable.isDataTable(this)) {
						$(this).DataTable({
							language: {
								lengthMenu: "Show _MENU_",
							},
							dom: "<'row mb-2'" +
								"<'col-sm-6 d-flex align-items-center justify-content-start dt-toolbar'l>" +
								"<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
								">" +
								"<'table-responsive'tr>" +
								"<'row'" +
								"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
								"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
								">",
						});
					}
				});
			}
		}

		// Initialize when DOM is ready
		$(document).ready(() => {
			const dtManager = new DataTableManager();
			dtManager.init();
		});
	</script>

	@include('admin.partials.drawers')

	<!--end::Engage toolbar-->
	<!--begin::Scrolltop-->
	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
		<span class="svg-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
				<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
			</svg>
		</span>
		<!--end::Svg Icon-->
	</div>
	<!--end::Scrolltop-->

	<!--begin::Modals-->
	@include('admin.partials.modals')
	@include('admin.partials.leave_modal')
	<!--end::Modals-->
	<!--begin::Javascript-->
	@include('admin.partials.script')

	<!-- Additional JavaScript for principal dashboard -->
	<script>
		// Principal Dashboard specific JavaScript
		document.addEventListener('DOMContentLoaded', function() {
			// Initialize Bootstrap tooltips
			const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
			const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
				return new bootstrap.Tooltip(tooltipTriggerEl);
			});

			// Auto-dismiss alerts after 5 seconds
			const alerts = document.querySelectorAll('.alert');
			alerts.forEach(alert => {
				setTimeout(() => {
					if (alert) {
						alert.style.transition = 'opacity 0.5s ease';
						alert.style.opacity = '0';
						setTimeout(() => alert.remove(), 500);
					}
				}, 5000);
			});

			// Add loading states to form buttons
			const forms = document.querySelectorAll('form');
			forms.forEach(form => {
				form.addEventListener('submit', function(e) {
					const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
					if (submitBtn) {
						submitBtn.classList.add('loading');
						submitBtn.disabled = true;
						const originalText = submitBtn.innerHTML;
						submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';

						// Store original content to restore if needed
						submitBtn.setAttribute('data-original-content', originalText);
					}
				});
			});
		});

		// Enhanced modal functions
		function openModal(modalId) {
			const modal = document.getElementById(modalId);
			if (modal) {
				modal.showModal();
				document.body.style.overflow = 'hidden';
			}
		}

		function closeModal(modalId) {
			const modal = document.getElementById(modalId);
			if (modal) {
				modal.close();
				document.body.style.overflow = 'auto';
			}
		}

		// WeChat Modal Functions
		function showWechatModal(wechatId) {
			document.getElementById('wechatId').textContent = wechatId;
			openModal('wechatModal');
		}

		function closeWechatModal() {
			closeModal('wechatModal');
		}

		// Close modal when clicking outside
		document.addEventListener('click', function(e) {
			if (e.target.tagName === 'DIALOG') {
				e.target.close();
				document.body.style.overflow = 'auto';
			}
		});

		// Keyboard navigation for modals
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape') {
				const openModal = document.querySelector('dialog[open]');
				if (openModal) {
					openModal.close();
					document.body.style.overflow = 'auto';
				}
			}
		});

		// Tab functionality for dashboard
		function initializeTabs() {
			const tabButtons = document.querySelectorAll('.tab-btn');

			tabButtons.forEach(button => {
				button.addEventListener('click', function() {
					const target = this.getAttribute('data-target');

					// Update active tab
					tabButtons.forEach(btn => {
						btn.classList.remove('active', 'text-primary', 'border-primary');
						btn.classList.add('text-muted', 'border-transparent');
					});
					this.classList.add('active', 'text-primary', 'border-primary');
					this.classList.remove('text-muted', 'border-transparent');

					// Show target content
					document.querySelectorAll('.tab-content').forEach(content => {
						content.classList.add('d-none');
					});
					document.getElementById(target).classList.remove('d-none');
				});
			});
		}

		// Initialize when DOM is ready
		document.addEventListener('DOMContentLoaded', initializeTabs);

		// Utility function to format numbers
		function formatNumber(number) {
			return new Intl.NumberFormat().format(number);
		}

		// Utility function to format currency
		function formatCurrency(amount, currency = 'USD') {
			return new Intl.NumberFormat('en-US', {
				style: 'currency',
				currency: currency
			}).format(amount);
		}
	</script>
	<!--end::Javascript-->

</body>
<!--end::Body-->

</html>