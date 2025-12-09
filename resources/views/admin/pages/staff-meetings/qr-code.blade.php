{{-- resources/views/admin/pages/staff-meetings/qr-code.blade.php --}}
@extends('admin.master')

@section('title', 'Attendance QR Code')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Attendance QR Code for: {{ $meeting->title }}</h4>
        </div>
        <div class="card-body text-center">
            <div class="mb-4">
                <img src="{{ $qrCodeUrl }}" alt="QR Code" class="img-fluid" style="max-width: 300px;">
            </div>
            
            <div class="mb-3">
                <p class="mb-1"><strong>Attendance Link:</strong></p>
                <input type="text" class="form-control text-center" value="{{ $meeting->attendance_link }}" readonly>
                <small class="text-muted">Share this link or QR code with participants</small>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('admin.staff-meetings.show', $meeting) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Meeting
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Print QR Code
                </button>
                <a href="{{ $qrCodeUrl }}" download class="btn btn-success">
                    <i class="fas fa-download"></i> Download QR Code
                </a>
            </div>
        </div>
    </div>
</div>
@endsection