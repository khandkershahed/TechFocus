<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test RFQ Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h1>Send Test RFQ Email</h1>

        @if(isset($message))
            <div class="alert alert-{{ $success ? 'success' : 'danger' }} mt-3">
                {{ $message }}
            </div>
        @endif

        <form method="GET" action="{{ route('test.email') }}">
            <button type="submit" class="btn btn-primary mt-3">Send Test Email</button>
        </form>
    </div>
</body>
</html>
