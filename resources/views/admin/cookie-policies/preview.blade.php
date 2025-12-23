<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview: {{ $cookiePolicy->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            padding-top: 20px;
            background-color: #f8f9fa;
        }
        .policy-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .policy-header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .policy-title {
            color: #343a40;
            font-weight: 700;
        }
        .policy-content {
            font-size: 16px;
            color: #495057;
        }
        .policy-content h1 {
            color: #343a40;
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }
        .policy-content h2 {
            color: #495057;
            font-size: 2rem;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
        }
        .policy-content h3 {
            color: #6c757d;
            font-size: 1.5rem;
            margin-top: 2rem;
            margin-bottom: 0.75rem;
        }
        .policy-content p {
            margin-bottom: 1.5rem;
        }
        .policy-content ul, .policy-content ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }
        .policy-content li {
            margin-bottom: 0.5rem;
        }
        .policy-content table {
            width: 100%;
            margin-bottom: 1.5rem;
            border-collapse: collapse;
        }
        .policy-content table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .policy-content table th,
        .policy-content table td {
            padding: 12px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        .badge-active {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        .admin-controls {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div class="admin-controls">
        <div class="btn-group" role="group">
            <a href="{{ route('admin.cookie-policies.edit', $cookiePolicy) }}" 
               class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.cookie-policies.index') }}" 
               class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button onclick="window.print()" class="btn btn-info btn-sm">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>

    <div class="container">
        <div class="policy-container">
            <div class="policy-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h1 class="policy-title">{{ $cookiePolicy->title }}</h1>
                        <p class="text-muted mb-2">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Last Updated: {{ $cookiePolicy->updated_at->format('F d, Y') }}
                        </p>
                    </div>
                    <div>
                        <span class="badge-active">
                            <i class="fas fa-circle mr-1"></i>
                            {{ $cookiePolicy->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="policy-content">
                {!! $cookiePolicy->content !!}
            </div>
            
            <div class="mt-5 pt-4 border-top">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-info-circle mr-1"></i>
                            Version: {{ $cookiePolicy->id }}
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            <i class="fas fa-clock mr-1"></i>
                            Generated: {{ now()->format('F d, Y \a\t h:i A') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4 text-muted">
            <small>
                <i class="fas fa-eye mr-1"></i>
                Preview Mode | This is how users will see the policy
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <script>
        // Add page break for printing
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                .admin-controls { display: none !important; }
                body { background: white !important; }
                .policy-container { 
                    box-shadow: none !important; 
                    padding: 0 !important;
                }
                .policy-content h2 {
                    page-break-after: avoid;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>