<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movement Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .action-btns .btn {
            margin-right: 5px;
        }
        .table-container {
            margin-top: 20px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
        }
        .status-completed { background: #d4edda; color: #155724; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Movement Records</h1>
            <a href="{{ route('admin.movement.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Record
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card table-container">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Admin</th>
                                <th>Company</th>
                                <th>Contact Person</th>
                                <th>Area</th>
                                <th>Status</th>
                                <th>Cost</th>
                                <th>Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $record)
                                <tr>
                                    <td>{{ $record->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</td>
                                    <td>
                                        @if($record->admin)
                                            <div class="admin-info">
                                                <strong>{{ $record->admin->name }}</strong>
                                                @if($record->admin->designation)
                                                    <br><small class="text-muted">{{ $record->admin->designation }}</small>
                                                @endif
                                                @if($record->admin->employee_id)
                                                    <br><small class="text-muted">ID: {{ $record->admin->employee_id }}</small>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $record->company ?? 'N/A' }}</td>
                                    <td>{{ $record->contact_person ?? 'N/A' }}</td>
                                    <td>{{ $record->area ?? 'N/A' }}</td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($record->status ?? 'pending') }}">
                                            {{ $record->status ?? 'Pending' }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($record->cost ?? 0, 2) }}</td>
                                    <td>${{ number_format($record->value ?? 0, 2) }}</td>
                                    <td class="action-btns">
                                        <a href="{{ route('admin.movement.show', $record->id) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.movement.edit', $record->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.movement.destroy', $record->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No movement records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($records->hasPages())
                    <div class="mt-3">
                        {{ $records->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>