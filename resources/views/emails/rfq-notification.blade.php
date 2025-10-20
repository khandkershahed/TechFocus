<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New RFQ Submission</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .section { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .section-title { font-weight: bold; color: #2c3e50; margin-bottom: 10px; }
        .product-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .product-table th, .product-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .product-table th { background-color: #f8f9fa; }
        .code { font-size: 18px; font-weight: bold; color: #e74c3c; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New RFQ Submission Received</h1>
            <p><strong>RFQ Code:</strong> <span class="code">{{ $rfq->rfq_code }}</span></p>
            <p><strong>Deal Code:</strong> <span class="code">{{ $rfq->deal_code }}</span></p>
            <p><strong>Submission Date:</strong> {{ $rfq->create_date->format('F j, Y g:i A') }}</p>
        </div>

        <!-- Company Information -->
        <div class="section">
            <div class="section-title">Company Information</div>
            <p><strong>Company:</strong> {{ $rfq->company_name }}</p>
            <p><strong>Contact Person:</strong> {{ $rfq->name }} ({{ $rfq->designation }})</p>
            <p><strong>Email:</strong> {{ $rfq->email }}</p>
            <p><strong>Phone:</strong> {{ $rfq->phone }}</p>
            <p><strong>Address:</strong> {{ $rfq->address }}, {{ $rfq->city }}, {{ $rfq->country }} - {{ $rfq->zip_code }}</p>
            <p><strong>Reseller:</strong> {{ $rfq->is_reseller ? 'Yes' : 'No' }}</p>
        </div>

        <!-- Shipping Information -->
        @if($rfq->shipping_name)
        <div class="section">
            <div class="section-title">Shipping Information</div>
            <p><strong>Company:</strong> {{ $rfq->shipping_company_name }}</p>
            <p><strong>Contact Person:</strong> {{ $rfq->shipping_name }} ({{ $rfq->shipping_designation }})</p>
            <p><strong>Email:</strong> {{ $rfq->shipping_email }}</p>
            <p><strong>Phone:</strong> {{ $rfq->shipping_phone }}</p>
            <p><strong>Address:</strong> {{ $rfq->shipping_address }}, {{ $rfq->shipping_city }}, {{ $rfq->shipping_country }} - {{ $rfq->shipping_zip_code }}</p>
        </div>
        @endif

        <!-- End User Information -->
        @if($rfq->end_user_name)
        <div class="section">
            <div class="section-title">End User Information</div>
            <p><strong>Company:</strong> {{ $rfq->end_user_company_name }}</p>
            <p><strong>Contact Person:</strong> {{ $rfq->end_user_name }} ({{ $rfq->end_user_designation }})</p>
            <p><strong>Email:</strong> {{ $rfq->end_user_email }}</p>
            <p><strong>Phone:</strong> {{ $rfq->end_user_phone }}</p>
            <p><strong>Address:</strong> {{ $rfq->end_user_address }}, {{ $rfq->end_user_city }}, {{ $rfq->end_user_country }} - {{ $rfq->end_user_zip_code }}</p>
        </div>
        @endif

        <!-- Project Details -->
        <div class="section">
            <div class="section-title">Project Details</div>
            <p><strong>Project Name:</strong> {{ $rfq->project_name ?? 'N/A' }}</p>
            <p><strong>Budget:</strong> {{ $rfq->budget ? '$' . number_format($rfq->budget, 2) : 'N/A' }}</p>
            <p><strong>Project Status:</strong> {{ $rfq->project_status ?? 'N/A' }}</p>
            <p><strong>Approximate Delivery Time:</strong> {{ $rfq->approximate_delivery_time ?? 'N/A' }}</p>
            <p><strong>Project Brief:</strong> {{ $rfq->message ?? 'N/A' }}</p>
        </div>

        <!-- Products List -->
        <div class="section">
            <div class="section-title">Requested Products ({{ count($products) }})</div>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>SKU</th>
                        <th>Brand</th>
                        <th>Model No</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product['sl'] ?? $loop->iteration }}</td>
                        <td>{{ $product['product_name'] ?? 'N/A' }}</td>
                        <td>{{ $product['quantity'] ?? 'N/A' }}</td>
                        <td>{{ $product['sku_no'] ?? 'N/A' }}</td>
                        <td>{{ $product['brand_name'] ?? 'N/A' }}</td>
                        <td>{{ $product['model_no'] ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Additional Information -->
        <div class="section">
            <div class="section-title">System Information</div>
            <p><strong>Client Type:</strong> {{ $rfq->client_type }}</p>
            <p><strong>RFQ Type:</strong> {{ $rfq->rfq_type }}</p>
            <p><strong>User ID:</strong> {{ $rfq->user_id ?? 'Anonymous' }}</p>
        </div>

        <div style="margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
            <p><em>This email was automatically generated by the RFQ system. Please do not reply to this email.</em></p>
        </div>
    </div>
</body>
</html>