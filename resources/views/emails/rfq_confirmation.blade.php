<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>RFQ Confirmation</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            font-family: 'Poppins', Arial, sans-serif;
            color: #333;
        }

        table {
            border-collapse: collapse;
        }

        a {
            color: #0056b3;
            text-decoration: none;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        }

        .header {
            background-color: #002147; /* Deep blue */
            color: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header img {
            max-width: 110px;
            height: auto;
        }

        .content {
            padding: 20px 30px;
        }

        .details, .products {
            width: 100%;
            margin-top: 20px;
            border: 1px solid #eee;
        }

        .details th, .details td,
        .products th, .products td {
            padding: 10px;
            border: 1px solid #eee;
            text-align: left;
            font-size: 14px;
        }

        .products th {
            background-color: #002147;
            color: #fff;
        }

        .footer {
            background-color: #87ceeb; /* Sky blue */
            color: #002147; /* Dark text */
            text-align: center;
            padding: 15px;
            font-size: 15px;
        }

        @media only screen and (max-width: 620px) {
            .header, .content {
                padding: 15px;
            }

            .header img {
                max-width: 80px;
            }
        }
    </style>
</head>

<body>
    <table class="email-container">
        <!-- Header -->
        <tr>
            <td class="header">
                <a href="https://ngenitltd.com" target="_blank">
                    <img src="{{ asset('images/NGen-Logo-white.png') }}" alt="TechFocus Logo">
                </a>
                <div>
                    <h2 style="margin:0;">RFQ Confirmation</h2>
                </div>
            </td>
        </tr>

        <!-- Main Content -->
        <tr>
            <td class="content">
                <p>Dear <strong>{{ $rfq->name ?? 'Customer' }}</strong>,</p>
                <p>Thank you for your RFQ submission! Your request has been successfully received. Below are the details:</p>

                <!-- RFQ Details -->
                <table class="details">
                    <tr>
                        <th>RFQ Code</th>
                        <td>{{ $rfq->rfq_code ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Company Name</th>
                        <td>{{ $rfq->company_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><a href="mailto:{{ $rfq->email }}">{{ $rfq->email ?? 'N/A' }}</a></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $rfq->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Project Name</th>
                        <td>{{ $rfq->project_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Budget</th>
                        <td>{{ $rfq->budget ?? 'N/A' }}</td>
                    </tr>
                </table>

                <!-- Products -->
                <h4 style="margin-top:20px;">Products</h4>
                @if(!empty($products) && is_array($products))
                    <table class="products">
                        <tr>
                            <th>Sl.</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                        </tr>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product['product_name'] ?? 'N/A' }}</td>
                                <td>{{ $product['qty'] ?? 1 }}</td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p>No products added.</p>
                @endif

                <!-- Message -->
                @if(!empty($rfq->message))
                    <p style="margin-top:20px;"><strong>Message:</strong> {{ $rfq->message }}</p>
                @endif

                <p style="margin-top:20px;">We will review your request and get back to you shortly.</p>

                <p>Best regards,<br>TechFocus IT Sales Team</p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td class="footer">
                <p>https://www.techfocusltd.com/</p>
                <p>Email: sales@techfocusltd.com | Phone: +8801714243446</p>
            </td>
        </tr>
    </table>
</body>

</html>
