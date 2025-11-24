<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shared Principal Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            -webkit-user-select: none; /* Safari */
            -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* IE10+/Edge */
            user-select: none; /* Standard */
        }
        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .masked-field {
            font-family: monospace;
            letter-spacing: 2px;
        }
        .no-copy {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h1 class="h3 text-gray-900 mb-1">Shared Principal Information</h1>
                    <p class="text-muted">This is a secure view-only link</p>
                </div>

                <!-- Main Info Card -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Principal Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                @if($principal->legal_name)
                                    <p><strong>Legal Name:</strong> 
                                        <span class="no-copy">
                                            {{ $principal->legal_name }}
                                        </span>
                                    </p>
                                @endif
                                
                                @if($principal->trading_name)
                                    <p><strong>Trading Name:</strong> 
                                        <span class="no-copy">
                                            {{ $principal->trading_name }}
                                        </span>
                                    </p>
                                @endif
                                
                                @if($principal->company_name)
                                    <p><strong>Company Name:</strong> 
                                        <span class="no-copy">
                                            {{ $principal->company_name }}
                                        </span>
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if($principal->entity_type)
                                    <p><strong>Entity Type:</strong> 
                                        <span class="no-copy">{{ $principal->entity_type }}</span>
                                    </p>
                                @endif
                                
                                @if($principal->status)
                                    <p><strong>Status:</strong> 
                                        <span class="badge bg-{{ $principal->status == 'active' ? 'success' : 'warning' }} no-copy">
                                            {{ ucfirst($principal->status) }}
                                        </span>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Contact Information -->
                        @if($principal->email || $principal->website_url || $principal->hq_city)
                        <hr>
                        <h6>Contact Information</h6>
                        <div class="row">
                            @if($principal->email)
                            <div class="col-md-4">
                                <p><strong>Email:</strong><br>
                                    <span class="no-copy masked-field">
                                        {{ $principal->email }}
                                    </span>
                                </p>
                            </div>
                            @endif
                            
                            @if($principal->website_url)
                            <div class="col-md-4">
                                <p><strong>Website:</strong><br>
                                    <a href="{{ $principal->website_url }}" target="_blank" class="no-copy">
                                        {{ $principal->website_url }}
                                    </a>
                                </p>
                            </div>
                            @endif
                            
                            @if($principal->hq_city)
                            <div class="col-md-4">
                                <p><strong>HQ City:</strong><br>
                                    <span class="no-copy">{{ $principal->hq_city }}</span>
                                </p>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="alert alert-warning text-center">
                    <small>
                        <i class="fas fa-shield-alt"></i> 
                        This is a secure view-only link. Content is protected and cannot be copied.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Copy Protection Script -->
    @if($shareLink->disable_copy)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Disable right-click
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            });

            // Disable text selection
            document.addEventListener('selectstart', function(e) {
                e.preventDefault();
            });

            // Disable drag
            document.addEventListener('dragstart', function(e) {
                e.preventDefault();
            });

            // Disable copy
            document.addEventListener('copy', function(e) {
                e.preventDefault();
            });

            // Disable cut
            document.addEventListener('cut', function(e) {
                e.preventDefault();
            });

            // Disable paste
            document.addEventListener('paste', function(e) {
                e.preventDefault();
            });
        });
    </script>
    @endif
</body>
</html>