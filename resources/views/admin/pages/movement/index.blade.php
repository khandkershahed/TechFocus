@extends('admin.master')
@section('content')

<style>
    /* ================= VARIABLES ================= */
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --secondary: #6c757d;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #212529;
        --gray-100: #f8f9fa;
        --gray-200: #e9ecef;
        --gray-300: #dee2e6;
        --gray-600: #6c757d;
        --gray-700: #495057;
        --gray-800: #343a40;
        --border-radius: 12px;
        --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    /* ================= BASE ================= */
    .dashboard-container {
        padding: 1.5rem;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        min-height: 100vh;
    }

    /* ================= TITLE ================= */
    .dashboard-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 2rem;
        text-align: center;
        position: relative;
        padding-bottom: 1rem;
    }

    .dashboard-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), #7209b7);
        border-radius: 2px;
    }

    /* ================= SUMMARY CARDS ================= */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--primary), #7209b7);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }

    .stat-card:nth-child(1) .stat-icon { background: linear-gradient(135deg, #4361ee, #3a0ca3); }
    .stat-card:nth-child(2) .stat-icon { background: linear-gradient(135deg, #4cc9f0, #4361ee); }
    .stat-card:nth-child(3) .stat-icon { background: linear-gradient(135deg, #f72585, #7209b7); }
    .stat-card:nth-child(4) .stat-icon { background: linear-gradient(135deg, #4895ef, #4361ee); }

    .stat-icon i {
        color: white;
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--gray-600);
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0;
    }

    /* ================= FILTER BAR ================= */
    .filter-bar {
        background: white;
        padding: 1.25rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        border: 1px solid var(--gray-200);
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group label {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        display: block;
    }

    .filter-control {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        font-size: 0.875rem;
        color: var(--gray-800);
        background: white;
        transition: var(--transition);
    }

    .filter-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    /* ================= TABLE ================= */
    .table-container {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        border: 1px solid var(--gray-200);
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .data-table thead {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .data-table th {
        padding: 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--gray-700);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--gray-300);
        white-space: nowrap;
    }

    .data-table td {
        padding: 1rem;
        font-size: 0.875rem;
        color: var(--gray-800);
        border-bottom: 1px solid var(--gray-200);
        vertical-align: middle;
    }

    .data-table tbody tr {
        transition: var(--transition);
    }

    .data-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(67, 97, 238, 0.04), rgba(114, 9, 183, 0.02));
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ================= BADGES ================= */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .badge-department {
        background: linear-gradient(135deg, #eef2ff, #e0e7ff);
        color: #3730a3;
        margin: 0.125rem;
        border: 1px solid rgba(55, 48, 163, 0.1);
    }

    .badge-status {
        min-width: 100px;
        justify-content: center;
        text-transform: uppercase;
        font-size: 0.6875rem;
    }

    .badge-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border: 1px solid rgba(6, 95, 70, 0.1);
    }

    .badge-warning {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        border: 1px solid rgba(146, 64, 14, 0.1);
    }

    /* ================= ACTION BUTTONS ================= */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .btn-filter {
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-apply {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
    }

    .btn-apply:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    .btn-reset {
        background: var(--gray-200);
        color: var(--gray-700);
    }

    .btn-reset:hover {
        background: var(--gray-300);
        transform: translateY(-2px);
    }

    /* ================= PAGINATION ================= */
    .pagination-container {
        padding: 1.25rem;
        border-top: 1px solid var(--gray-200);
        background: white;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .page-link {
        padding: 0.5rem 0.875rem;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        color: var(--gray-700);
        font-size: 0.875rem;
        font-weight: 500;
        transition: var(--transition);
        text-decoration: none;
        display: inline-block;
    }

    .page-link:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    /* ================= LOADING ================= */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }
        
        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .filter-grid {
            grid-template-columns: 1fr;
        }
        
        .data-table {
            display: block;
            overflow-x: auto;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-filter {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .summary-grid {
            grid-template-columns: 1fr;
        }
        
        .stat-value {
            font-size: 1.5rem;
        }
    }
</style>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>

<div class="dashboard-container">

    <!-- Summary Statistics -->
    <div class="summary-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-people"></i>
            </div>
            <p class="stat-label">Total Movements</p>
            <h3 class="stat-value">{{ number_format($totalVisits) }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <p class="stat-label">Sales Value</p>
            <h3 class="stat-value">${{ number_format($highestValue, 2) }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-building"></i>
            </div>
            <p class="stat-label">Companies</p>
            <h3 class="stat-value">{{ number_format($totalCompanies) }}</h3>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="bi bi-telephone"></i>
            </div>
            <p class="stat-label">Total Calls</p>
            <h3 class="stat-value">{{ number_format($totalDays) }}</h3>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('admin.movement.index') }}" class="filter-bar" id="filterForm">
        <div class="filter-grid">
            <div class="filter-group">
                <label for="staffSelect"><i class="bi bi-person me-1"></i> Staff</label>
                <select name="staff" id="staffSelect" class="filter-control">
                    <option value="">All Staff</option>
                    @foreach($allStaff as $staff)
                    <option value="{{ $staff->id }}" {{ request('staff') == $staff->id ? 'selected' : '' }}>
                        {{ $staff->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="departmentSelect"><i class="bi bi-diagram-3 me-1"></i> Department</label>
                <select name="department" id="departmentSelect" class="filter-control">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                    <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $dept)) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="movementType"><i class="bi bi-arrow-left-right me-1"></i> Movement Type</label>
                <select name="movement_type" id="movementType" class="filter-control">
                    <option value="">All Types</option>
                    @foreach($movementTypes as $type)
                    <option value="{{ $type }}" {{ request('movement_type') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="dateFilter"><i class="bi bi-calendar me-1"></i> Date</label>
                <input type="date" name="date" id="dateFilter" value="{{ request('date') }}" class="filter-control">
            </div>

            <div class="filter-group">
                <label for="statusFilter"><i class="bi bi-circle-fill me-1"></i> Status</label>
                <select name="status" id="statusFilter" class="filter-control">
                    <option value="">All Status</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-3 action-buttons">
            <button type="button" class="btn-filter btn-reset" id="resetFilters">
                <i class="bi bi-x-circle"></i>
                Reset Filters
            </button>
            <button type="submit" class="btn-filter btn-apply">
                <i class="bi bi-funnel"></i>
                Apply Filters
            </button>
        </div>
    </form>

    <!-- Data Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="10%">Date</th>
                        <th width="10%">Staff</th>
                        <th width="30%">Department</th>
                        <th width="5%">Type</th>
                        <th width="10%">Location</th>
                        <th width="10%">Time</th>
                        <th width="10%">Duration</th>
                        <th width="10%" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                    <tr>
                        <td class="fw-semibold text-muted">{{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}</td>
                        <td>
                            @if($record->date)
                            <span class="d-block">{{ date('d M Y', strtotime($record->date)) }}</span>
                            <small class="text-muted">{{ date('D', strtotime($record->date)) }}</small>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="fw-medium">{{ $record->admin->name ?? '-' }}</td>
                        <td>
                            @php
                            $dept = json_decode($record->admin->department ?? '[]', true);
                            @endphp
                            @if(count($dept))
                                @foreach($dept as $d)
                                <span class="badge badge-department">
                                    {{ ucfirst(str_replace('_', ' ', $d)) }}
                                </span>
                                @endforeach
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $record->meeting_type ?? '-' }}</td>
                        <td>{{ $record->area ?? '-' }}</td>
                        <td class="text-nowrap">
                            @if($record->start_time && $record->end_time)
                            <div class="">
                                <span class="pb-1 badge bg-info">{{ \Carbon\Carbon::parse($record->start_time)->format('h:i A') }}</span>
                                <small class="text-muted">to</small>
                                <span class="pb-1 badge bg-primary">{{ \Carbon\Carbon::parse($record->end_time)->format('h:i A') }}</span>
                            </div>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($record->duration)
                            {{ gmdate('H\h i\m', strtotime($record->duration)) }}
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge badge-status {{ $record->status == 'Completed' ? 'badge-success' : 'badge-warning' }}">
                                {{ $record->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-4 text-center">
                            <div class="text-muted">
                                <i class="bi bi-inbox display-6"></i>
                                <p class="mt-2">No records found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($records->hasPages())
        <div class="pagination-container">
            {{ $records->appends(request()->except('page'))->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 with theme
        $('#staffSelect, #departmentSelect, #movementType, #statusFilter').select2({
            placeholder: "Select option",
            width: "100%",
            allowClear: true,
            theme: "bootstrap-5",
            dropdownParent: $('#filterForm')
        });

        // Show loading when form is submitted
        $('#filterForm').on('submit', function(e) {
            if (!$(this).hasClass('resetting')) {
                $('#loadingOverlay').fadeIn();
            }
        });

        // Reset filters
        $('#resetFilters').on('click', function() {
            $('#filterForm').addClass('resetting');
            $('#filterForm')[0].reset();
            
            // Reset Select2
            $('#staffSelect, #departmentSelect, #movementType, #statusFilter')
                .val('')
                .trigger('change');
            
            // Submit form to reset filters
            $('#filterForm').submit();
        });

        // Auto-submit on Enter key in date field
        $('#dateFilter').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                $('#filterForm').submit();
            }
        });

        // Clear date on double click
        $('#dateFilter').on('dblclick', function() {
            $(this).val('');
        });

        // Update pagination links to maintain filters
        $('.pagination .page-link').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url && url !== '#') {
                $('#loadingOverlay').fadeIn();
                window.location.href = url;
            }
        });

        // Add animation to table rows
        $('.data-table tbody tr').each(function(i) {
            $(this).css({
                'opacity': 0,
                'transform': 'translateY(10px)'
            }).delay(i * 30).animate({
                'opacity': 1,
                'transform': 'translateY(0)'
            }, 300);
        });

        // Hide loading if page loaded from cache
        $(window).on('load', function() {
            $('#loadingOverlay').fadeOut();
        });
    });
</script>

@endsection