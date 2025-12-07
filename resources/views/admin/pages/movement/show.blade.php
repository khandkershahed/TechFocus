<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movement Record Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Movement Record Details</h1>
            <div>
                <a href="{{ route('admin.movement.edit', $record->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('admin.movement.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Admin Information Column -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Admin Information</h5>
                    </div>
                    <div class="card-body">
                        @if($record->admin)
                            <div class="text-center mb-3">
                                @if($record->admin->photo)
                                    <img src="{{ asset('storage/' . $record->admin->photo) }}" 
                                         alt="{{ $record->admin->name }}" 
                                         class="rounded-circle mb-2" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mb-2" 
                                         style="width: 80px; height: 80px; margin: 0 auto;">
                                        <i class="bi bi-person" style="font-size: 2rem;"></i>
                                    </div>
                                @endif
                                <h5>{{ $record->admin->name }}</h5>
                                @if($record->admin->designation)
                                    <p class="text-muted">{{ $record->admin->designation }}</p>
                                @endif
                            </div>
                            
                            <div class="admin-details">
                                <div class="row mb-2">
                                    <div class="col-6"><strong>Employee ID:</strong></div>
                                    <div class="col-6">{{ $record->admin->employee_id ?? 'N/A' }}</div>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-6"><strong>Department:</strong></div>
                                    <div class="col-6">
                                        @if($record->admin->employeeDepartment)
                                            {{ $record->admin->employeeDepartment->name ?? 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-6"><strong>Email:</strong></div>
                                    <div class="col-6">{{ $record->admin->email ?? 'N/A' }}</div>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-6"><strong>Phone:</strong></div>
                                    <div class="col-6">{{ $record->admin->phone ?? 'N/A' }}</div>
                                </div>
                                
                                @if($record->admin->country)
                                    <div class="row mb-2">
                                        <div class="col-6"><strong>Country:</strong></div>
                                        <div class="col-6">{{ $record->admin->country->name ?? 'N/A' }}</div>
                                    </div>
                                @endif
                                
                                <div class="row mb-2">
                                    <div class="col-6"><strong>Status:</strong></div>
                                    <div class="col-6">
                                        <span class="badge bg-{{ $record->admin->status == 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($record->admin->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-muted">
                                <i class="bi bi-person-x" style="font-size: 3rem;"></i>
                                <p class="mt-2">No admin assigned</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Record Information Column -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Record Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>ID:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $record->id }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Status:</strong>
                            </div>
                            <div class="col-md-8">
                                <span class="badge bg-{{ $record->status == 'completed' ? 'success' : ($record->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($record->status ?? 'Pending') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Date:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ \Carbon\Carbon::parse($record->date)->format('F d, Y') }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Time:</strong>
                            </div>
                            <div class="col-md-8">
                                @if($record->start_time)
                                    {{ \Carbon\Carbon::parse($record->start_time)->format('h:i A') }}
                                    @if($record->end_time)
                                        to {{ \Carbon\Carbon::parse($record->end_time)->format('h:i A') }}
                                        @if($record->duration)
                                            (Duration: {{ $record->duration }})
                                        @endif
                                    @endif
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">Company Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Company:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $record->company ?? 'N/A' }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Contact Person:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $record->contact_person ?? 'N/A' }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Contact Number:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $record->contact_number ?? 'N/A' }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Meeting Type:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $record->meeting_type ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Information Row -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Financial & Location Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <strong>Cost:</strong><br>
                                ${{ number_format($record->cost ?? 0, 2) }}
                            </div>
                            <div class="col-md-3 mb-3">
                                <strong>Value:</strong><br>
                                ${{ number_format($record->value ?? 0, 2) }}
                            </div>
                            <div class="col-md-3 mb-3">
                                <strong>Value Status:</strong><br>
                                <span class="badge bg-info">{{ ucfirst($record->value_status ?? 'N/A') }}</span>
                            </div>
                            <div class="col-md-3 mb-3">
                                <strong>Transport:</strong><br>
                                {{ ucfirst($record->transport ?? 'N/A') }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Area:</strong><br>
                                {{ $record->area ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Purpose & Comments</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6>Purpose:</h6>
                            <p>{{ $record->purpose ?? 'No purpose specified.' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6>Comments:</h6>
                            <p>{{ $record->comments ?? 'No comments.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">System Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Created At:</strong><br>
                                {{ $record->created_at->format('Y-m-d H:i:s') }}
                            </div>
                            <div class="col-md-4">
                                <strong>Updated At:</strong><br>
                                {{ $record->updated_at->format('Y-m-d H:i:s') }}
                            </div>
                            <div class="col-md-4">
                                <strong>Record By:</strong><br>
                                @if($record->admin)
                                    {{ $record->admin->name }}
                                @else
                                    System
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <form action="{{ route('admin.movement.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Delete Record
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>