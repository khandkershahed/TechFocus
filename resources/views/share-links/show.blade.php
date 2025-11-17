@extends('layouts.app')

@section('title', 'Shared Principal')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Shared Principal Information</h4>
            <small class="text-muted">This link expires: {{ $shareLink->expires_at ? $shareLink->expires_at->format('M j, Y H:i') : 'Never' }}</small>
        </div>
        <div class="card-body">
            <!-- Principal details here -->
            <div class="row">
                <div class="col-md-6">
                    <strong>Name:</strong> {{ $principal->name }}
                </div>
                <div class="col-md-6">
                    <strong>Email:</strong> {{ $principal->email }}
                </div>
                <!-- Add other fields as needed -->
            </div>
        </div>
    </div>

    @if(!$shareLink->allow_copy)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Disable text selection
            document.body.style.userSelect = 'none';
            document.body.style.webkitUserSelect = 'none';
            
            // Disable right-click
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            });
            
            // Disable copy
            document.addEventListener('copy', function(e) {
                e.preventDefault();
            });
        });
    </script>
    @endif
</div>
@endsection

