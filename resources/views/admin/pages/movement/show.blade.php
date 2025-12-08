@extends('admin.master')
@section('content')
<div class="container my-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-uppercase">
            Movement Record Details
        </h4>
        <div>
            <a href="{{ route('admin.movement.edit', $record->id) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.movement.index') }}" class="btn btn-secondary btn-sm">
                Back
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- Admin Info --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Admin Information
                </div>
                <div class="card-body text-center">

                    @if($record->admin->photo)
                        <img src="{{ asset('storage/'.$record->admin->photo) }}"
                             class="rounded-circle mb-2"
                             style="width:80px;height:80px;">
                    @else
                        <i class="bi bi-person-circle fs-1"></i>
                    @endif

                    <h6 class="mt-2">{{ $record->admin->name }}</h6>
                    <small class="text-muted">{{ $record->admin->designation ?? '' }}</small>

                    <hr>

                    <p class="mb-1"><strong>Employee ID:</strong> {{ $record->admin->employee_id ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $record->admin->email }}</p>
                    <p class="mb-1"><strong>Phone:</strong> {{ $record->admin->phone ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Status:</strong>
                        <span class="badge bg-success">{{ ucfirst($record->admin->status) }}</span>
                    </p>

                </div>
            </div>
        </div>

        {{-- Record Info --}}
        <div class="col-md-8">

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    Record Information
                </div>
                <div class="card-body row g-3">

                    <div class="col-md-4">
                        <strong>Date</strong><br>
                        {{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}
                    </div>

                    <div class="col-md-4">
                        <strong>Status</strong><br>
                        <span class="badge bg-info">{{ ucfirst($record->status) }}</span>
                    </div>

                    <div class="col-md-4">
                        <strong>Duration</strong><br>
                        {{ $record->duration ?? 'N/A' }}
                    </div>

                    <div class="col-md-6">
                        <strong>Time</strong><br>
                        {{ $record->start_time }} - {{ $record->end_time }}
                    </div>

                    <div class="col-md-6">
                        <strong>Area</strong><br>
                        {{ $record->area ?? 'N/A' }}
                    </div>

                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    Company Details
                </div>
                <div class="card-body row g-3">

                    <div class="col-md-6">
                        <strong>Company</strong><br>
                        {{ $record->company }}
                    </div>

                    <div class="col-md-6">
                        <strong>Meeting Type</strong><br>
                        {{ ucfirst($record->meeting_type) }}
                    </div>

                    <div class="col-md-6">
                        <strong>Contact Person</strong><br>
                        {{ $record->contact_person }}
                    </div>

                    <div class="col-md-6">
                        <strong>Contact Number</strong><br>
                        {{ $record->contact_number }}
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Financial Info --}}
    <div class="card shadow-sm mt-4">
        <div class="card-header">
            Financial & Purpose
        </div>
        <div class="card-body row g-3">

            <div class="col-md-3">
                <strong>Cost</strong><br>
                Tk. {{ number_format($record->cost ?? 0) }}
            </div>

            <div class="col-md-3">
                <strong>Value</strong><br>
                Tk. {{ number_format($record->value ?? 0) }}
            </div>

            <div class="col-md-3">
                <strong>Value Status</strong><br>
                {{ ucfirst($record->value_status) }}
            </div>

            <div class="col-md-3">
                <strong>Transport</strong><br>
                {{ ucfirst($record->transport) }}
            </div>

            <div class="col-md-12 mt-2">
                <strong>Purpose</strong><br>
                {{ $record->purpose }}
            </div>

            <div class="col-md-12">
                <strong>Comments</strong><br>
                {{ $record->comments ?? 'N/A' }}
            </div>

        </div>
    </div>

    {{-- Delete --}}
    <div class="mt-3 text-end">
        <form method="POST" action="{{ route('admin.movement.destroy', $record->id) }}"
              onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection