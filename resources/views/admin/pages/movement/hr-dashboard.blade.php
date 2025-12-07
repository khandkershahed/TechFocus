<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Admin Dashboard - Staff Movements</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .dashboard-header h1 {
            color: #2c3e50;
            font-weight: 600;
        }

        .date-filter {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 8px 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            cursor: pointer;
        }

        .date-filter i {
            color: #3498db;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stats-card {
            background: linear-gradient(135deg, #3498db, #2c3e50);
            color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.2);
        }

        .stats-card h2 {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .stats-card .total-number {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stats-card .sub-text {
            font-size: 14px;
            opacity: 0.8;
        }

        .dashboard-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .filters {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-item label {
            font-size: 13px;
            color: #7f8c8d;
            font-weight: 500;
        }

        .filter-item select,
        .filter-item input {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            background: white;
            min-width: 150px;
            font-size: 14px;
        }

        .add-movement-btn {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .add-movement-btn:hover {
            background: #27ae60;
            transform: translateY(-2px);
        }

        .movements-table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #eee;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        tbody tr {
            transition: all 0.2s;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-completed {
            background-color: #d5f4e6;
            color: #27ae60;
        }

        .status-pending {
            background-color: #fff4e6;
            color: #f39c12;
        }

        .status-cancelled {
            background-color: #ffe6e6;
            color: #e74c3c;
        }

        .movement-type {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .type-call {
            background-color: #e8f4fd;
            color: #3498db;
        }

        .type-meeting {
            background-color: #f0e8fd;
            color: #9b59b6;
        }

        .type-followup {
            background-color: #e8fdf0;
            color: #2ecc71;
        }

        .type-event {
            background-color: #fdf8e8;
            color: #f1c40f;
        }

        .type-conference {
            background-color: #fde8e8;
            color: #e74c3c;
        }

        .type-visit {
            background-color: #e8f8fd;
            color: #1abc9c;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
        }

        .edit-btn {
            background-color: #3498db;
            color: white;
        }

        .edit-btn:hover {
            background-color: #2980b9;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        .pagination-btn {
            padding: 8px 15px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pagination-btn:hover {
            background: #f5f5f5;
        }

        .pagination-btn.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: #7f8c8d;
            font-size: 14px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }

        .no-data i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #bdc3c7;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }

        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .filter-form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            width: 100%;
        }

        @media (max-width: 768px) {
            .dashboard-actions {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .filters {
                width: 100%;
            }
            
            .add-movement-btn {
                align-self: flex-end;
            }
            
            th, td {
                padding: 10px 8px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>HR Admin Dashboard</h1>
            <div class="date-filter" id="datePicker">
                <i class="fas fa-calendar-alt"></i>
                <span id="selectedDate">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</span>
                <input type="date" id="dateInput" style="display: none;" value="{{ $date }}">
            </div>
        </div>

        <div class="stats-container">
            <div class="stats-card">
                <h2>TOTAL MOVEMENTS</h2>
                <div class="total-number">{{ $totalMovements }}</div>
                <div class="sub-text">Staff movements tracked for {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</div>
            </div>
            
            <div class="stats-card" style="background: linear-gradient(135deg, #2ecc71, #27ae60);">
                <h2>COMPLETED</h2>
                <div class="total-number">{{ $stats['completed'] ?? 0 }}</div>
                <div class="sub-text">Successfully completed movements</div>
            </div>
            
            <div class="stats-card" style="background: linear-gradient(135deg, #f39c12, #d35400);">
                <h2>PENDING</h2>
                <div class="total-number">{{ $stats['pending'] ?? 0 }}</div>
                <div class="sub-text">Movements awaiting completion</div>
            </div>
            
            <div class="stats-card" style="background: linear-gradient(135deg, #e74c3c, #c0392b);">
                <h2>CANCELLED</h2>
                <div class="total-number">{{ $stats['cancelled'] ?? 0 }}</div>
                <div class="sub-text">Cancelled movements</div>
            </div>
        </div>

        <form action="{{ route('admin.movement.hr-dashboard') }}" method="GET" class="filter-form">
            <div class="filters">
                <div class="filter-item">
                    <label for="admin_id">Admin</label>
                    <select id="admin_id" name="admin_id">
                        <option value="">All Admins</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <label for="employee_department_id">Department</label>
                    <select id="employee_department_id" name="employee_department_id">
                        <option value="">All Departments</option>
                        @foreach($employeeDepartments as $department)
                            <option value="{{ $department->id }}" {{ request('employee_department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <label for="movement_type">Movement Type</label>
                    <select id="movement_type" name="movement_type">
                        <option value="">All Types</option>
                        <option value="call" {{ request('movement_type') == 'call' ? 'selected' : '' }}>Call</option>
                        <option value="meeting" {{ request('movement_type') == 'meeting' ? 'selected' : '' }}>Meeting</option>
                        <option value="follow_up" {{ request('movement_type') == 'follow_up' ? 'selected' : '' }}>Follow-up</option>
                        <option value="event" {{ request('movement_type') == 'event' ? 'selected' : '' }}>Event</option>
                        <option value="conference" {{ request('movement_type') == 'conference' ? 'selected' : '' }}>Conference</option>
                        <option value="visit" {{ request('movement_type') == 'visit' ? 'selected' : '' }}>Visit</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="">All Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" value="{{ request('date', $date) }}">
                </div>
            </div>
            <button type="submit" class="add-movement-btn" style="background: #3498db;">
                <i class="fas fa-filter"></i>
                Apply Filters
            </button>
        </form>

        <div class="dashboard-actions">
            <div></div> <!-- Empty div for spacing -->
            <a href="{{ route('admin.movement.create') }}" class="add-movement-btn">
                <i class="fas fa-plus"></i>
                Add Movement
            </a>
        </div>

        <div class="movements-table-container">
            @if($movements->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Admin</th>
                            <th>Department</th>
                            <th>Movement Type</th>
                            <th>Location</th>
                            <th>Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movements as $index => $movement)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($movement->date)->format('d M Y') }}</td>
                            <td>{{ $movement->admin->name ?? 'N/A' }}</td>
                            <td>{{ $movement->employeeDepartment->name ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $typeClass = 'type-call';
                                    if($movement->movement_type == 'meeting') $typeClass = 'type-meeting';
                                    elseif($movement->movement_type == 'follow_up') $typeClass = 'type-followup';
                                    elseif($movement->movement_type == 'event') $typeClass = 'type-event';
                                    elseif($movement->movement_type == 'conference') $typeClass = 'type-conference';
                                    elseif($movement->movement_type == 'visit') $typeClass = 'type-visit';
                                    
                                    $typeName = ucwords(str_replace('_', ' ', $movement->movement_type));
                                @endphp
                                <span class="movement-type {{ $typeClass }}">{{ $typeName }}</span>
                            </td>
                            <td>{{ $movement->location }}</td>
                            <td>{{ $movement->time_start }} - {{ $movement->time_end }}</td>
                            <td>{{ $movement->duration }}</td>
                            <td>
                                @php
                                    $statusClass = 'status-pending';
                                    if($movement->status == 'completed') $statusClass = 'status-completed';
                                    elseif($movement->status == 'cancelled') $statusClass = 'status-cancelled';
                                @endphp
                                <span class="status-badge {{ $statusClass }}">{{ ucfirst($movement->status) }}</span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.movement.edit', $movement->id) }}" class="action-btn edit-btn">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.movement.destroy', $movement->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this movement?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">
                    <i class="fas fa-clipboard-list"></i>
                    <h3>No Movements Found</h3>
                    <p>No movement records found for the selected date and filters.</p>
                    <a href="{{ route('admin.movement.create') }}" class="add-movement-btn" style="margin-top: 15px;">
                        <i class="fas fa-plus"></i>
                        Add Your First Movement
                    </a>
                </div>
            @endif
        </div>

        @if($movements->count() > 0)
            <div class="pagination">
                <button class="pagination-btn" onclick="changePage(1)" {{ $movements->currentPage() == 1 ? 'disabled' : '' }}>
                    <i class="fas fa-chevron-left"></i>
                </button>
                
                @for ($i = 1; $i <= $movements->lastPage(); $i++)
                    @if ($i == 1 || $i == $movements->lastPage() || ($i >= $movements->currentPage() - 2 && $i <= $movements->currentPage() + 2))
                        <button class="pagination-btn {{ $movements->currentPage() == $i ? 'active' : '' }}" onclick="changePage({{ $i }})">
                            {{ $i }}
                        </button>
                    @elseif ($i == $movements->currentPage() - 3 || $i == $movements->currentPage() + 3)
                        <span>...</span>
                    @endif
                @endfor
                
                <button class="pagination-btn" onclick="changePage({{ $movements->lastPage() }})" {{ $movements->currentPage() == $movements->lastPage() ? 'disabled' : '' }}>
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        @endif

        <div class="footer">
            <p>HR Admin Dashboard © {{ date('Y') }} | Showing {{ $movements->count() }} of {{ $totalMovements }} movements for {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Date picker functionality
            const datePicker = document.getElementById('datePicker');
            const dateInput = document.getElementById('dateInput');
            const selectedDate = document.getElementById('selectedDate');
            
            datePicker.addEventListener('click', function() {
                dateInput.style.display = 'block';
                dateInput.focus();
            });
            
            dateInput.addEventListener('change', function() {
                const selected = new Date(this.value);
                selectedDate.textContent = selected.toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
                
                // Submit the form with new date
                const form = document.querySelector('.filter-form');
                form.querySelector('#date').value = this.value;
                form.submit();
            });
            
            // Filter functionality
            const filters = ['admin_id', 'employee_department_id', 'movement_type', 'status'];
            filters.forEach(filterId => {
                const filter = document.getElementById(filterId);
                if (filter) {
                    filter.addEventListener('change', function() {
                        document.querySelector('.filter-form').submit();
                    });
                }
            });
            
            // Auto-refresh every 60 seconds
            setInterval(function() {
                // You can add auto-refresh logic here if needed
                // For now, we'll just log to console
                console.log('Auto-refresh check at ' + new Date().toLocaleTimeString());
            }, 60000);
        });
        
        function changePage(page) {
            const url = new URL(window.location.href);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        }
        
        // Confirm before deleting
        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('delete-form')) {
                if (!confirm('Are you sure you want to delete this movement?')) {
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>