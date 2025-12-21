@extends('admin.master')

@section('title', 'Staff Meetings')

@section('content')

<style>
    /* ================= DESIGN SYSTEM ================= */
    :root {
        /* Color System */
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --primary-light: #eef2ff;
        --secondary: #8b5cf6;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #06b6d4;
        
        /* Neutral Colors */
        --white: #ffffff;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        
        /* Effects */
        --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.05);
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        
        /* Border Radius */
        --radius-sm: 6px;
        --radius-md: 10px;
        --radius-lg: 16px;
        --radius-xl: 24px;
        --radius-full: 9999px;
        
        /* Transitions */
        --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
        --transition-normal: 250ms cubic-bezier(0.4, 0, 0.2, 1);
        --transition-slow: 350ms cubic-bezier(0.4, 0, 0.2, 1);
        
        /* Spacing */
        --space-xs: 0.5rem;
        --space-sm: 0.75rem;
        --space-md: 1rem;
        --space-lg: 1.5rem;
        --space-xl: 2rem;
    }

    /* ================= BASE STYLES ================= */
    .dashboard-wrapper {
        min-height: 100vh;
        padding: var(--space-md);
        position: relative;
    }

    @media (min-width: 1024px) {
        .dashboard-wrapper {
            padding: var(--space-xl);
        }
    }

    /* ================= CENTERED LOADING SPINNER ================= */
    .global-loading {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        flex-direction: column;
    }

    .spinner-container {
        position: relative;
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .spinner {
        width: 64px;
        height: 64px;
        border: 3px solid rgba(99, 102, 241, 0.1);
        border-radius: 50%;
        border-top-color: var(--primary);
        animation: spin 1s linear infinite;
        position: absolute;
    }

    .spinner-double {
        width: 56px;
        height: 56px;
        border: 3px solid rgba(139, 92, 246, 0.1);
        border-radius: 50%;
        border-top-color: var(--secondary);
        animation: spin 1.2s linear infinite reverse;
        position: absolute;
    }

    .loading-text {
        margin-top: var(--space-lg);
        color: var(--gray-600);
        font-size: 0.875rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    /* ================= HEADER SECTION ================= */
    .dashboard-header {
        margin-bottom: var(--space-xl);
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: var(--space-lg);
        flex-wrap: wrap;
        gap: var(--space-md);
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--gray-900);
        line-height: 1.2;
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }

    .page-title::before {
        content: '';
        width: 4px;
        height: 32px;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: var(--radius-full);
    }

    .page-subtitle {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin-top: var(--space-xs);
        margin-left: calc(var(--space-sm) + 4px);
    }

    .header-actions {
        display: flex;
        gap: var(--space-sm);
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 500;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        transition: all var(--transition-fast);
        position: relative;
        overflow: hidden;
    }

    .btn::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width var(--transition-normal), height var(--transition-normal);
    }

    .btn:hover::after {
        width: 300px;
        height: 300px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: var(--white);
        box-shadow: var(--shadow-md);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-secondary {
        background: var(--white);
        color: var(--gray-700);
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-sm);
    }

    .btn-secondary:hover {
        background: var(--gray-50);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--gray-300);
    }

    /* ================= STATS SECTION ================= */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: var(--space-md);
        margin-bottom: var(--space-xl);
    }

    .stat-card {
        background: #fff;
        border-radius: var(--radius-lg);
        padding: var(--space-lg);
        transition: all var(--transition-normal);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, transparent, currentColor, transparent);
        opacity: 0.3;
    }

    .stat-card-total::before { color: var(--primary); }
    .stat-card-scheduled::before { color: var(--success); }
    .stat-card-upcoming::before { color: var(--warning); }
    .stat-card-cancelled::before { color: var(--danger); }

    .stat-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-numbers h3 {
        font-size: 2.25rem;
        font-weight: 700;
        margin: 0;
        background: linear-gradient(135deg, var(--gray-900), var(--gray-700));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #000;
        font-weight: 500;
        margin-top: 0.25rem;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
        box-shadow: var(--shadow-md);
    }

    .stat-card-total .stat-icon {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
    }

    .stat-card-scheduled .stat-icon {
        background: linear-gradient(135deg, var(--success), #059669);
    }

    .stat-card-upcoming .stat-icon {
        background: linear-gradient(135deg, var(--warning), #d97706);
    }

    .stat-card-cancelled .stat-icon {
        background: linear-gradient(135deg, var(--danger), #dc2626);
    }

    /* ================= FILTER SECTION ================= */
    .filter-section {
        background: #fff;
        border-radius: var(--radius-lg);
        margin-bottom: var(--space-xl);
        overflow: hidden;
    }

    .filter-header {
        padding: var(--space-lg);
        background: linear-gradient(90deg, var(--gray-50), var(--white));
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .filter-header h3 {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-toggle {
        background: none;
        border: none;
        color: var(--gray-600);
        cursor: pointer;
        padding: var(--space-xs);
        border-radius: var(--radius-sm);
        transition: all var(--transition-fast);
    }

    .filter-toggle:hover {
        background: var(--gray-100);
        color: var(--gray-900);
    }

    .filter-body {
        padding: var(--space-lg);
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: var(--space-md);
        margin-bottom: var(--space-lg);
    }

    .filter-group {
        position: relative;
    }

    .filter-label {
        display: block;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #000;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .select-wrapper {
        position: relative;
    }

    .select-wrapper::after {
        content: '▼';
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.75rem;
        color: var(--gray-500);
        pointer-events: none;
    }

    .filter-select {
        width: 100%;
        padding: 0.75rem 1rem;
        padding-right: 2.5rem;
        border-radius: 0;
        font-size: 0.875rem;
        color: black;
        border: 1px solid gray;
        background: white;
        transition: all var(--transition-fast);
        appearance: none;
        -webkit-appearance: none;
    }

    .filter-select:focus {
        outline: none;
        border-color: black;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .filter-select:hover {
        border-color: black;
    }

    .filter-actions {
        display: flex;
        justify-content: flex-end;
        gap: var(--space-sm);
    }

    .btn-clear {
        background: transparent;
        color: black;
        border: 1px solid black;
    }

    .btn-clear:hover {
        background: var(--gray-50);
        color: var(--gray-900);
        border-color: var(--gray-400);
    }

    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: var(--space-md);
    }

    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.5rem 0.875rem;
        background: var(--primary-light);
        color: var(--primary-dark);
        border-radius: var(--radius-full);
        font-size: 0.8125rem;
        font-weight: 500;
    }

    .filter-chip i {
        font-size: 0.75rem;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity var(--transition-fast);
    }

    .filter-chip i:hover {
        opacity: 1;
    }

    /* ================= TABS SECTION ================= */
    .tabs-section {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        margin-bottom: var(--space-xl);
        padding: 0.5rem;
        border: 1px solid var(--gray-200);
    }

    .tabs-container {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .tab {
        padding: 0.75rem 1.25rem;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray-600);
        text-decoration: none;
        transition: all var(--transition-fast);
        border: 1px solid transparent;
    }

    .tab:hover {
        background: var(--gray-50);
        color: var(--gray-900);
    }

    .tab.active {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: #fff;
        box-shadow: var(--shadow-sm);
    }

    /* ================= TABLE SECTION ================= */
    .table-section {
        background: #fff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        border: 1px solid var(--gray-200);
    }

    .table-header {
        padding: var(--space-lg);
        background: linear-gradient(90deg, var(--gray-50), var(--white));
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-title {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-900);
    }

    .table-actions {
        display: flex;
        gap: var(--space-sm);
        align-items: center;
    }

    .search-box {
        position: relative;
    }

    .search-input {
        padding: 0.625rem 1rem 0.625rem 2.5rem;
        border: 1px solid var(--gray-300);
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        width: 240px;
        transition: all var(--transition-fast);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 0.875rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-500);
        font-size: 0.875rem;
    }

    .table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        min-height: 400px;
        position: relative;
    }

    .modern-table {
        width: 100%;
        min-width: 800px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .modern-table th {
        padding: 1rem 1.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: black;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #000 !important;
        white-space: nowrap;
    }

    .modern-table th:first-child {
        border-top-left-radius: var(--radius-lg);
    }

    .modern-table th:last-child {
        border-top-right-radius: var(--radius-lg);
    }

    .modern-table td {
        padding: 1.25rem 1.25rem;
        font-size: 0.875rem;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-100);
        vertical-align: middle;
    }

    .modern-table tbody tr {
        transition: all var(--transition-fast);
    }

    .modern-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(99, 102, 241, 0.02), rgba(139, 92, 246, 0.02));
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ================= TABLE LOADING SKELETON ================= */
    .skeleton-loader {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--white);
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 5;
    }

    .skeleton-spinner {
        width: 48px;
        height: 48px;
        border: 3px solid rgba(99, 102, 241, 0.1);
        border-radius: 50%;
        border-top-color: var(--primary);
        animation: spin 1s linear infinite;
        margin-bottom: var(--space-md);
    }

    .skeleton-text {
        color: var(--gray-500);
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* ================= STATUS BADGES ================= */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.875rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 500;
        border: 1px solid;
    }

    .status-scheduled {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
        border-color: #a7f3d0;
    }

    .status-rescheduled {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        border-color: #fde68a;
    }

    .status-completed {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
        border-color: #bfdbfe;
    }

    .status-cancelled {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
        border-color: #fecaca;
    }

    /* ================= TYPE BADGES ================= */
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.875rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 500;
        background: var(--gray-100);
        color: var(--gray-700);
        border: 1px solid var(--gray-200);
    }

    /* ================= ACTION BUTTONS ================= */
    .action-buttons {
        display: flex;
        gap: 0.375rem;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-md);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--gray-200);
        background: var(--white);
        color: var(--gray-600);
        transition: all var(--transition-fast);
        cursor: pointer;
    }

    .btn-icon:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    .btn-view:hover {
        background: #dbeafe;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .btn-edit:hover {
        background: #f0f9ff;
        color: #0ea5e9;
        border-color: #bae6fd;
    }

    .btn-delete:hover {
        background: #fef2f2;
        color: #ef4444;
        border-color: #fecaca;
    }

    /* ================= EMPTY STATE ================= */
    .empty-state {
        padding: var(--space-xl);
        text-align: center;
        color: var(--gray-500);
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: var(--space-md);
        opacity: 0.5;
    }

    /* ================= RESPONSIVE DESIGN ================= */
    @media (max-width: 768px) {
        .header-top {
            flex-direction: column;
            align-items: stretch;
        }
        
        .header-actions {
            width: 100%;
        }
        
        .header-actions .btn {
            flex: 1;
            justify-content: center;
        }
        
        .filter-grid {
            grid-template-columns: 1fr;
        }
        
        .search-input {
            width: 100%;
        }
        
        .table-header {
            flex-direction: column;
            gap: var(--space-md);
            align-items: stretch;
        }
        
        .table-actions {
            width: 100%;
        }
    }

    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .tabs-container {
            flex-direction: column;
        }
        
        .tab {
            text-align: center;
        }
    }

    /* ================= DARK MODE SUPPORT ================= */
    @media (prefers-color-scheme: dark) {
        :root {
            --white: #0f172a;
            --gray-50: #1e293b;
            --gray-100: #334155;
            --gray-200: #475569;
            --gray-300: #64748b;
            --gray-400: #94a3b8;
            --gray-500: #cbd5e1;
            --gray-600: #e2e8f0;
            --gray-700: #f1f5f9;
            --gray-800: #f8fafc;
            --gray-900: #ffffff;
        }
        
        
        .stat-numbers h3 {
            background: linear-gradient(135deg, var(--white), var(--gray-700));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    }
</style>

<!-- Centered Global Loading Overlay -->
<div class="global-loading" id="globalLoading">
    <div class="spinner-container">
        <div class="spinner"></div>
        <div class="spinner-double"></div>
    </div>
    <div class="loading-text">Loading meetings...</div>
</div>

<!-- Table Loading Skeleton -->
<div class="skeleton-loader" id="tableLoader">
    <div class="skeleton-spinner"></div>
    <div class="skeleton-text">Updating table...</div>
</div>

<div class="dashboard-wrapper">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-top">
            <div>
                <h1 class="page-title text-primary">Staff Meetings</h1>
                <p class="text-black">Manage and track all staff meetings efficiently</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.staff-meetings.calendar') }}" class="btn btn-secondary">
                    <i class="fas fa-calendar-alt"></i>
                    Calendar View
                </a>
                <a href="{{ route('admin.staff-meetings.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Schedule Meeting
                </a>
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card stat-card-total">
                <div class="stat-content">
                    <div class="stat-numbers">
                        <h3>{{ $stats['total'] ?? 0 }}</h3>
                        <div class="stat-label">Total Meetings</div>
                    </div>
                    <div class="stat-icon">
                        <i class="text-white fas fa-calendar"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card stat-card-scheduled">
                <div class="stat-content">
                    <div class="stat-numbers">
                        <h3>{{ $stats['scheduled'] ?? 0 }}</h3>
                        <div class="stat-label">Scheduled</div>
                    </div>
                    <div class="stat-icon">
                        <i class="text-white fas fa-clock"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card stat-card-upcoming">
                <div class="stat-content">
                    <div class="stat-numbers">
                        <h3>{{ $stats['upcoming'] ?? 0 }}</h3>
                        <div class="stat-label">Upcoming</div>
                    </div>
                    <div class="stat-icon">
                        <i class="text-white fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card stat-card-cancelled">
                <div class="stat-content">
                    <div class="stat-numbers">
                        <h3>{{ $stats['cancelled'] ?? 0 }}</h3>
                        <div class="stat-label">Cancelled</div>
                    </div>
                    <div class="stat-icon">
                        <i class="text-white fas fa-calendar-times"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <div class="filter-header">
            <h3><i class="fas fa-sliders-h"></i> Filters</h3>
            <button class="filter-toggle" id="filterToggle">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
        <div class="filter-body" id="filterBody">
            <div class="filter-grid">
                <!-- Month Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-calendar"></i>
                        Month
                    </label>
                    <div class="select-wrapper">
                        <select data-control="select2" name="month" class="filter-select filter-input" data-filter="month">
                            <option value="">All Months</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Department Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-building"></i>
                        Department
                    </label>
                    <div class="select-wrapper">
                        <select data-control="select2" name="department" class="filter-select filter-input" data-filter="department">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                                    {{ $dept }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Organizer Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-user-tie"></i>
                        Organizer
                    </label>
                    <div class="select-wrapper">
                        <select data-control="select2" name="organizer" class="filter-select filter-input" data-filter="organizer">
                            <option value="">All Organizers</option>
                            @if(isset($admins) && count($admins) > 0)
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ request('organizer') == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }}
                                    </option>
                                @endforeach
                            @else
                                @php
                                    $admins = \App\Models\Admin::all();
                                @endphp
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ request('organizer') == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <!-- Meeting Type Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-handshake"></i>
                        Meeting Type
                    </label>
                    <div class="select-wrapper">
                        <select data-control="select2" name="meeting_type" class="filter-select filter-input" data-filter="meeting_type">
                            <option value="">All Types</option>
                            <option value="internal" {{ request('meeting_type') == 'internal' ? 'selected' : '' }}>Internal</option>
                            <option value="external" {{ request('meeting_type') == 'external' ? 'selected' : '' }}>External</option>
                            <option value="client" {{ request('meeting_type') == 'client' ? 'selected' : '' }}>Client</option>
                        </select>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-circle"></i>
                        Status
                    </label>
                    <div class="select-wrapper">
                        <select data-control="select2" name="status" class="filter-select filter-input" data-filter="status">
                            <option value="">All Status</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Active Filters -->
            <div class="active-filters" id="activeFilters">
                <!-- Will be populated by JavaScript -->
            </div>

            <!-- Actions -->
            <div class="filter-actions">
                <button type="button" id="clearFilters" class="btn btn-clear">
                    <i class="fas fa-times"></i>
                    Clear All
                </button>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs-section">
        <div class="tabs-container">
            <a href="{{ route('admin.staff-meetings.index') }}" 
               class="tab {{ !request('status') ? 'active' : '' }}">
               All Meetings
            </a>
            <a href="{{ route('admin.staff-meetings.filter.status', 'scheduled') }}" 
               class="tab {{ request('status') == 'scheduled' ? 'active' : '' }}">
               Scheduled
            </a>
            <a href="{{ route('admin.staff-meetings.filter.status','rescheduled') }}" 
               class="tab {{ request('status') == 'rescheduled' ? 'active' : '' }}">
               Upcoming
            </a>
            <a href="{{ route('admin.staff-meetings.filter.status', 'completed') }}" 
               class="tab {{ request('status') == 'completed' ? 'active' : '' }}">
               Completed
            </a>
            <a href="{{ route('admin.staff-meetings.filter.status', 'cancelled') }}" 
               class="tab {{ request('status') == 'cancelled' ? 'active' : '' }}">
               Cancelled
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="table-section">
        <div class="table-header">
            <h3 class="table-title">Meetings List</h3>
            <div class="table-actions">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search meetings..." 
                           id="searchInput" data-filter="search">
                </div>
            </div>
        </div>
        
        <div class="table-container">
            <div id="meetings-container">
                <!-- This will be dynamically loaded -->
                @include('admin.pages.staff-meetings.partials.meetings-table', ['meetings' => $meetings])
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Design System JavaScript
    class MeetingDashboard {
        constructor() {
            this.debounceTimer = null;
            this.loading = false;
            this.init();
        }

        init() {
            // Auto-dismiss alerts
            this.autoDismissAlerts();
            
            // Initialize filter toggle
            this.initFilterToggle();
            
            // Initialize event listeners
            this.initEventListeners();
            
            // Update active filters display
            this.updateActiveFilters();
            
            // Smooth scroll for page load
            this.smoothScroll();
        }

        autoDismissAlerts() {
            setTimeout(() => {
                $('.alert').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);
        }

        initFilterToggle() {
            const toggle = $('#filterToggle');
            const body = $('#filterBody');
            
            toggle.on('click', () => {
                body.slideToggle(300);
                const icon = toggle.find('i');
                icon.toggleClass('fa-chevron-down fa-chevron-up');
            });
        }

        initEventListeners() {
            // Filter change handler
            $('.filter-input, #searchInput').on('input change', (e) => {
                if (e.target.name === 'search' || e.target.id === 'searchInput') {
                    this.debounce(() => this.loadMeetings(), 500);
                } else {
                    this.loadMeetings();
                }
            });

            // Clear filters
            $('#clearFilters').on('click', () => {
                $('.filter-input').val('');
                $('#searchInput').val('');
                this.loadMeetings();
            });

            // Search input clear
            $('#searchInput').on('keydown', (e) => {
                if (e.key === 'Escape') {
                    $(e.target).val('');
                    this.loadMeetings();
                }
            });

            // Handle browser back/forward
            $(window).on('popstate', () => this.handlePopState());
        }

        async loadMeetings() {
            if (this.loading) return;
            
            this.loading = true;
            this.showTableLoader();
            
            try {
                const filters = this.collectFilters();
                this.updateUrlParams(filters);
                
                const response = await $.ajax({
                    url: "{{ route('admin.staff-meetings.filter.ajax') }}",
                    type: 'GET',
                    data: filters,
                    dataType: 'html'
                });
                
                $('#meetings-container').html(response);
                this.updateActiveFilters();
                
                // Add entrance animation to new rows
                this.animateTableRows();
                
            } catch (error) {
                console.error('Error loading meetings:', error);
                this.showError();
            } finally {
                this.hideTableLoader();
                this.loading = false;
            }
        }

        collectFilters() {
            return {
                month: $('select[name="month"]').val(),
                department: $('select[name="department"]').val(),
                organizer: $('select[name="organizer"]').val(),
                meeting_type: $('select[name="meeting_type"]').val(),
                status: $('select[name="status"]').val(),
                search: $('#searchInput').val()
            };
        }

        updateUrlParams(params) {
            const url = new URL(window.location);
            
            // Clear all current params
            url.search = '';
            
            // Add non-empty params
            Object.entries(params).forEach(([key, value]) => {
                if (value && value !== '') {
                    url.searchParams.set(key, value);
                }
            });
            
            // Update URL without reload
            window.history.pushState({}, '', url);
        }

        handlePopState() {
            const urlParams = new URLSearchParams(window.location.search);
            
            // Update filter values from URL
            $('select[name="month"]').val(urlParams.get('month') || '');
            $('select[name="department"]').val(urlParams.get('department') || '');
            $('select[name="organizer"]').val(urlParams.get('organizer') || '');
            $('select[name="meeting_type"]').val(urlParams.get('meeting_type') || '');
            $('select[name="status"]').val(urlParams.get('status') || '');
            $('#searchInput').val(urlParams.get('search') || '');
            
            // Reload data
            this.loadMeetings();
        }

        updateActiveFilters() {
            const filters = this.collectFilters();
            let hasActiveFilters = false;
            let filtersHtml = '';
            
            // Month filter
            if (filters.month) {
                const monthName = $('select[name="month"] option:selected').text();
                filtersHtml += this.createFilterChip('Month', monthName, 'month');
                hasActiveFilters = true;
            }
            
            // Department filter
            if (filters.department) {
                filtersHtml += this.createFilterChip('Department', filters.department, 'department');
                hasActiveFilters = true;
            }
            
            // Organizer filter
            if (filters.organizer) {
                const organizerName = $('select[name="organizer"] option:selected').text();
                filtersHtml += this.createFilterChip('Organizer', organizerName, 'organizer');
                hasActiveFilters = true;
            }
            
            // Meeting type filter
            if (filters.meeting_type) {
                filtersHtml += this.createFilterChip('Type', filters.meeting_type, 'meeting_type');
                hasActiveFilters = true;
            }
            
            // Status filter
            if (filters.status) {
                filtersHtml += this.createFilterChip('Status', filters.status, 'status');
                hasActiveFilters = true;
            }
            
            // Search filter
            if (filters.search) {
                filtersHtml += this.createFilterChip('Search', filters.search, 'search');
                hasActiveFilters = true;
            }
            
            // Update display
            const container = $('#activeFilters');
            if (hasActiveFilters) {
                container.html(filtersHtml);
                container.parent().show();
            } else {
                container.empty();
                container.parent().hide();
            }
        }

        createFilterChip(label, value, type) {
            return `
                <div class="filter-chip">
                    <span>${label}: ${value}</span>
                    <i class="fas fa-times" data-filter="${type}"></i>
                </div>
            `;
        }

        animateTableRows() {
            $('.modern-table tbody tr').each(function(index) {
                $(this).css({
                    'opacity': 0,
                    'transform': 'translateY(20px)'
                }).delay(index * 50).animate({
                    'opacity': 1,
                    'transform': 'translateY(0)'
                }, 300);
            });
        }

        showGlobalLoading() {
            $('#globalLoading').css('display', 'flex');
        }

        hideGlobalLoading() {
            $('#globalLoading').hide();
        }

        showTableLoader() {
            $('#tableLoader').css('display', 'flex');
            $('#meetings-container').css('opacity', '0.5');
        }

        hideTableLoader() {
            $('#tableLoader').hide();
            $('#meetings-container').css('opacity', '1');
        }

        showError() {
            $('#meetings-container').html(`
                <div class="empty-state">
                    <i class="fas fa-exclamation-triangle empty-icon"></i>
                    <h4>Unable to Load Data</h4>
                    <p>Please check your connection and try again.</p>
                    <button class="mt-3 btn btn-secondary" onclick="dashboard.loadMeetings()">
                        <i class="fas fa-redo"></i>
                        Retry
                    </button>
                </div>
            `);
        }

        smoothScroll() {
            // Smooth scroll to top on page load
            $('html, body').animate({ scrollTop: 0 }, 0);
        }

        debounce(func, wait) {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(func, wait);
        }
    }

    // Initialize dashboard when DOM is ready
    $(document).ready(() => {
        // Show global loading on page load
        $('#globalLoading').css('display', 'flex');
        
        // Hide global loading after page is fully loaded
        $(window).on('load', () => {
            setTimeout(() => {
                $('#globalLoading').fadeOut(300);
            }, 500);
        });
        
        window.dashboard = new MeetingDashboard();
        
        // Add click handler for removing individual filters
        $(document).on('click', '.filter-chip i', function() {
            const filterType = $(this).data('filter');
            
            if (filterType === 'search') {
                $('#searchInput').val('');
            } else {
                $(`[name="${filterType}"]`).val('');
            }
            
            dashboard.loadMeetings();
        });
        
        // Add keyboard shortcuts
        $(document).on('keydown', (e) => {
            // Ctrl/Cmd + F to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                e.preventDefault();
                $('#searchInput').focus();
            }
            
            // Esc to clear search
            if (e.key === 'Escape' && $('#searchInput').is(':focus')) {
                $('#searchInput').val('');
                dashboard.loadMeetings();
            }
        });
    });
</script>
@endpush

@endsection