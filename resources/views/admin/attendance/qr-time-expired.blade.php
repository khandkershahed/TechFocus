@extends('admin.master')

@section('title', 'QR Code Expired')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-danger text-white text-center py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-clock me-2"></i>QR Code Expired
                    </h4>
                </div>
                
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-clock fa-5x text-danger"></i>
                    </div>
                    
                    <h3 class="text-danger mb-3">Attendance Time Expired</h3>
                    
                    <div class="mb-4">
                        <p>The QR code for this meeting is no longer valid.</p>
                        <h5 class="text-primary">{{ $meeting->title }}</h5>
                        <p class="text-muted">
                            Scheduled: {{ $meeting->date->format('F d, Y') }} • 
                            {{ $meeting->start_time->format('h:i A') }}
                        </p>
                        <p class="text-muted">
                            Current time: {{ now()->format('F d, Y h:i A') }}
                        </p>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        QR codes are only valid 30 minutes before and 60 minutes after the meeting.
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Go to Dashboard
                        </a>
                        
                        <button onclick="window.history.back()" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Go Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection