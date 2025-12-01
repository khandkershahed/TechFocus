<!DOCTYPE html>
<html lang="en">

<head>
	@include('principal.partials.head')
	<meta name="csrf-param" content="_token">
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="d-flex flex-column flex-root">
		<div class="flex-row page d-flex flex-column-fluid">
			@include('principal.partials.sidebar')
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				{{-- @include('admin.partials.toastr') --}}
				@include('principal.partials.header')
				@yield('content')
				@include('admin.partials.footer')
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
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

		// Initialize all when DOM is ready
		$(document).ready(() => {
			const dtManager = new DataTableManager(); // default selector: .datatable-custom
			dtManager.init();
		});
	</script>
	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<span class="svg-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
				<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
			</svg>
		</span>
	</div>
	@include('admin.partials.modals')
	@include('admin.partials.leave_modal')
	@include('admin.partials.script')
</body>

</html>