@extends('admin.master')

@section('title', 'Staff Meetings')

@section('content')

<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Meetings</h6>
                            <h2>{{ $stats['total'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-calendar fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Scheduled</h6>
                            <h2>{{ $stats['scheduled'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-clock fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Upcoming</h6>
                            <h2>{{ $stats['upcoming'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Cancelled</h6>
                            <h2>{{ $stats['cancelled'] ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-calendar-times fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-users me-2"></i>Staff Meetings</h1>
    <div>
        <a href="{{ route('admin.staff-meetings.calendar') }}" class="btn btn-info me-2">
            <i class="fas fa-calendar-alt"></i> Calendar View
        </a>
        <a href="{{ route('admin.staff-meetings.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Schedule New Meeting
        </a>
    </div>
</div>
<!-- Replace the existing filter form with this -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-filter me-2"></i>Filters
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3" id="filter-container">
            <!-- Month Filter -->
            <div class="col-md-2">
                <label class="form-label">Month</label>
                <select name="month" class="form-select filter-input" data-filter="month">
                    <option value="">All Months</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>
            
            {{-- <!-- Year Filter -->
            <div class="col-md-2">
                <label class="form-label">Year</label>
                <select name="year" class="form-select filter-input" data-filter="year">
                    <option value="">All Years</option>
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div> --}}
            
            <!-- Department Filter -->
            <div class="col-md-2">
                <label class="form-label">Department</label>
                <select name="department" class="form-select filter-input" data-filter="department">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                            {{ $dept }}
                        </option>
                    @endforeach
                </select>
            </div>
            
          <!-- Organizer Filter -->
<div class="col-md-2">
    <label class="form-label">Organizer</label>
    <select name="organizer" class="form-select filter-input" data-filter="organizer">
        <option value="">All Organizers</option>
        @if(isset($admins) && count($admins) > 0)
            @foreach($admins as $admin)
                <option value="{{ $admin->id }}" {{ request('organizer') == $admin->id ? 'selected' : '' }}>
                    {{ $admin->name }}
                </option>
            @endforeach
        @else
            <!-- Fallback if $admins is not available -->
            @php
                $admins = \App\Models\Admin::all(); // Fetch directly in view (not recommended)
            @endphp
            @foreach($admins as $admin)
                <option value="{{ $admin->id }}" {{ request('organizer') == $admin->id ? 'selected' : '' }}>
                    {{ $admin->name }}
                </option>
            @endforeach
        @endif
    </select>
</div>
            
            <!-- Meeting Type Filter -->
            <div class="col-md-2">
                <label class="form-label">Meeting Type</label>
                <select name="meeting_type" class="form-select filter-input" data-filter="meeting_type">
                    <option value="">All Types</option>
                    <option value="internal" {{ request('meeting_type') == 'internal' ? 'selected' : '' }}>Internal</option>
                    <option value="external" {{ request('meeting_type') == 'external' ? 'selected' : '' }}>External</option>
                    <option value="client" {{ request('meeting_type') == 'client' ? 'selected' : '' }}>Client</option>
                </select>
            </div>
            
            {{-- <!-- Category Filter -->
            <div class="col-md-2">
                <label class="form-label">Category</label>
                <select name="category" class="form-select filter-input" data-filter="category">
                    <option value="">All Categories</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div> --}}
            
            <!-- Status Filter -->
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select filter-input" data-filter="status">
                    <option value="">All Status</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            
            {{-- <!-- Search Filter -->
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <div class="input-group">
                    <input type="text" name="search" class="form-control filter-input" 
                           placeholder="Search by title, agenda..." 
                           value="{{ request('search') }}"
                           data-filter="search"
                           id="search-input">
                    <button class="btn btn-outline-secondary" type="button" id="clear-search">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
             --}}
            <!-- Action Buttons -->
            <div class="col-md-12">
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <button type="button" id="clear-filters" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Clear All Filters
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Loading indicator -->
        <div id="loading-indicator" class="text-center mt-3" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading results...</p>
        </div>
        
        <!-- Active Filters Display -->
        <div id="active-filters" class="mt-3">
            <!-- Will be populated by JavaScript -->
        </div>
    </div>
</div>
    <!-- Filter Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.staff-meetings.index') }}">All</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'scheduled' ? 'active' : '' }}" 
               href="{{ route('admin.staff-meetings.filter.status', 'scheduled') }}">Scheduled</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'rescheduled' ? 'active' : '' }}" 
               href="{{ route('admin.staff-meetings.filter.status','rescheduled') }}">Upcoming</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" 
               href="{{ route('admin.staff-meetings.filter.status', 'completed') }}">Completed</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}" 
               href="{{ route('admin.staff-meetings.filter.status', 'cancelled') }}">Cancelled</a>
        </li>
    </ul>
<!-- Replace the table section with this -->
<div id="meetings-container">
    <!-- This will be dynamically loaded -->
    @include('admin.pages.staff-meetings.partials.meetings-table', ['meetings' => $meetings])
</div>

{{-- @push('scripts')
<script>
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
</script>
@endpush --}}
@push('scripts')
<script>
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
</script>
<script>
$(document).ready(function() {
    let filterTimeout;
    const debounceDelay = 500; // Delay in milliseconds
    
    // Initialize filters from URL
    updateActiveFilters();
    
    // Event listener for all filter inputs
    $('.filter-input').on('change keyup', function() {
        if ($(this).attr('name') === 'search') {
            // Debounce search input
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(() => {
                loadMeetings();
            }, debounceDelay);
        } else {
            // Immediate filter for selects
            loadMeetings();
        }
    });
    
    // Clear search button
    $('#clear-search').click(function() {
        $('#search-input').val('');
        loadMeetings();
    });
    
    // Clear all filters button
    $('#clear-filters').click(function() {
        $('.filter-input').val('');
        loadMeetings();
    });
    
    // Function to load meetings via AJAX
    function loadMeetings() {
        showLoading();
        
        // Collect all filter values
        const filters = {
            month: $('select[name="month"]').val(),
            year: $('select[name="year"]').val(),
            department: $('select[name="department"]').val(),
            organizer: $('select[name="organizer"]').val(),
            meeting_type: $('select[name="meeting_type"]').val(),
            category: $('select[name="category"]').val(),
            status: $('select[name="status"]').val(),
            search: $('input[name="search"]').val(),
            page: getUrlParameter('page') || 1
        };
        
        // Update URL without reloading page
        updateUrlParams(filters);
        
        // Make AJAX request
        $.ajax({
            url: "{{ route('admin.staff-meetings.filter.ajax') }}",
            type: 'GET',
            data: filters,
            success: function(response) {
                $('#meetings-container').html(response);
                updateActiveFilters();
                hideLoading();
            },
            error: function(xhr) {
                hideLoading();
                $('#meetings-container').html('<div class="alert alert-danger">Error loading data. Please try again.</div>');
            }
        });
    }
    
    // Function to update URL parameters
    function updateUrlParams(params) {
        const url = new URL(window.location);
        
        // Remove existing params
        url.searchParams.forEach((value, key) => {
            url.searchParams.delete(key);
        });
        
        // Add new params
        Object.keys(params).forEach(key => {
            if (params[key]) {
                url.searchParams.set(key, params[key]);
            }
        });
        
        // Update browser URL without reload
        window.history.pushState({}, '', url);
    }
    
    // Function to show loading indicator
    function showLoading() {
        $('#loading-indicator').show();
    }
    
    // Function to hide loading indicator
    function hideLoading() {
        $('#loading-indicator').hide();
    }
    
    // Function to update active filters display
    function updateActiveFilters() {
        let activeFiltersHtml = '';
        let hasActiveFilters = false;
        
        // Month
        const monthVal = $('select[name="month"]').val();
        if (monthVal) {
            const monthName = $('select[name="month"] option:selected').text();
            activeFiltersHtml += `<span class="badge bg-info me-2 mb-2">Month: ${monthName}</span>`;
            hasActiveFilters = true;
        }
        
        // Year
        const yearVal = $('select[name="year"]').val();
        if (yearVal) {
            activeFiltersHtml += `<span class="badge bg-info me-2 mb-2">Year: ${yearVal}</span>`;
            hasActiveFilters = true;
        }
        
        // Department
        const deptVal = $('select[name="department"]').val();
        if (deptVal) {
            activeFiltersHtml += `<span class="badge bg-info me-2 mb-2">Department: ${deptVal}</span>`;
            hasActiveFilters = true;
        }
        
        // Organizer
        const orgVal = $('select[name="organizer"]').val();
        if (orgVal) {
            const orgName = $('select[name="organizer"] option:selected').text();
            activeFiltersHtml += `<span class="badge bg-info me-2 mb-2">Organizer: ${orgName}</span>`;
            hasActiveFilters = true;
        }
        
        // Meeting Type
        const typeVal = $('select[name="meeting_type"]').val();
        if (typeVal) {
            const typeName = $('select[name="meeting_type"] option:selected').text();
            activeFiltersHtml += `<span class="badge bg-info me-2 mb-2">Type: ${typeName}</span>`;
            hasActiveFilters = true;
        }
        
        // Category
        const catVal = $('select[name="category"]').val();
        if (catVal) {
            const catName = $('select[name="category"] option:selected').text();
            activeFiltersHtml += `<span class="badge bg-info me-2 mb-2">Category: ${catName}</span>`;
            hasActiveFilters = true;
        }
        
        // Status
        const statusVal = $('select[name="status"]').val();
        if (statusVal) {
            const statusName = $('select[name="status"] option:selected').text();
            activeFiltersHtml += `<span class="badge bg-info me-2 mb-2">Status: ${statusName}</span>`;
            hasActiveFilters = true;
        }
        
        // Search
        const searchVal = $('input[name="search"]').val();
        if (searchVal) {
            activeFiltersHtml += `<span class="badge bg-info me-2 mb-2">Search: "${searchVal}"</span>`;
            hasActiveFilters = true;
        }
        
        // Update display
        if (hasActiveFilters) {
            $('#active-filters').html(`
                <small class="text-muted">Active Filters:</small>
                <div class="d-flex flex-wrap gap-2 mt-1">
                    ${activeFiltersHtml}
                </div>
            `);
        } else {
            $('#active-filters').html('');
        }
    }
    
    // Function to get URL parameter
    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }
    
    // Handle browser back/forward buttons
    window.onpopstate = function(event) {
        // Update filter values from URL
        const urlParams = new URLSearchParams(window.location.search);
        
        $('select[name="month"]').val(urlParams.get('month') || '');
        $('select[name="year"]').val(urlParams.get('year') || '');
        $('select[name="department"]').val(urlParams.get('department') || '');
        $('select[name="organizer"]').val(urlParams.get('organizer') || '');
        $('select[name="meeting_type"]').val(urlParams.get('meeting_type') || '');
        $('select[name="category"]').val(urlParams.get('category') || '');
        $('select[name="status"]').val(urlParams.get('status') || '');
        $('input[name="search"]').val(urlParams.get('search') || '');
        
        // Reload data
        loadMeetings();
    };
});
</script>
@endpush
@endsection