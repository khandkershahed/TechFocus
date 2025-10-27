<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>RFQ Notification</title>
    <style>
        body { margin:0; padding:0; background:#f4f4f4; font-family: Arial, sans-serif; color:#333; }
        table { border-collapse: collapse; }
        a { color:#ae0a46; text-decoration:none; }
        @media only screen and (max-width: 620px) {
            .u-row { width: 100% !important; }
            .u-col { display: block !important; width: 100% !important; max-width: 100% !important; }
            .mail-footers { font-size: 12px !important; }
            .stack-table td { display: block; width: 100% !important; padding-left:0 !important; padding-right:0 !important; }
        }
    </style>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f4f4f4;">
        <tr>
            <td align="center">
                <table class="u-row" cellpadding="0" cellspacing="0" border="0"
                    style="width:100%; max-width:620px; margin:0 auto; background:#fff;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#001430; padding:15px;">
                            <table width="100%">
                                <tr>
                                    <td align="left">
                                        <a href="https://ngenitltd.com" target="_blank">
                                            <img src="{{ !empty($site->system_logo_white) && file_exists(public_path('storage/webSetting/systemLogoWhite/' . $site->system_logo_white)) ? asset('storage/webSetting/systemLogoWhite/' . $site->system_logo_white) : asset('backend/images/no-image-available.png') }}"
                                                 height="60px" alt="TechFocus" />
                                        </a>
                                    </td>
                                    <td align="right" style="color:#ffffff;">
                                        <p style="font-size:2em; font-weight:600; margin:0;">RFQ</p>
                                        <p style="font-size:1.18em; font-weight:600; margin:0;">Received</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Greeting & Intro -->
                    <tr>
                        <td style="padding:30px;">
                            <p style="font-size:16px;">Dear <strong>Sales Manager</strong>,</p>
                            <p style="font-size:16px;">We have received a new RFQ. Please respond promptly for best customer service.</p>

                            <!-- RFQ Codes -->
                            <p><strong>RFQ Code:</strong> <span style="color:#e74c3c;">{{ $rfq->rfq_code }}</span></p>
                            <p><strong>Deal Code:</strong> <span style="color:#e74c3c;">{{ $rfq->deal_code }}</span></p>
                            <p><strong>Submission Date:</strong>
                                {{ $rfq->created_at ? $rfq->created_at->timezone('Asia/Dhaka')->format('F j, Y g:i A') : 'N/A' }}
                            </p>

                            <!-- Product Table -->
                            @if(isset($products) && count($products) > 0)
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:20px; box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px;">
                                <tr style="background-color:#d3d3d3;">
                                    <th style="padding:10px; text-align:center;">Sl.</th>
                                    <th style="padding:10px; text-align:left;">Product Name</th>
                                    <th style="padding:10px; text-align:center;">Qty</th>
                                </tr>
                                @foreach ($products as $product)
                                <tr>
                                    <td style="padding:10px; border:1px solid #eee; text-align:center;">{{ $loop->iteration }}</td>
                                    <td style="padding:10px; border:1px solid #eee;">{{ $product->product_name ?? 'N/A' }}</td>
                                    <td style="padding:10px; border:1px solid #eee; text-align:center;">{{ $product->qty ?? 1 }}</td>
                                </tr>
                                @endforeach
                            </table>
                            @endif

                            <!-- Company & Shipping Info -->
                            <table class="stack-table" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:20px;">
                                <tr>
                                    <!-- Company Info -->
                                    <td class="u-col" valign="top" width="50%" style="padding-right:10px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px;">
                                            <tr>
                                                <th colspan="2" style="background-color:#d3d3d3; padding:10px; text-align:center;">Company Info</th>
                                            </tr>
                                            @if(!empty($rfq->company_name))
                                            <tr>
                                                <th style="background:#f1f1f1; padding:10px; text-align:left; font-weight:400;">Company</th>
                                                <td style="padding:10px;">{{ $rfq->company_name }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <th style="background:#f1f1f1; padding:10px; text-align:left; font-weight:400;">Email</th>
                                                <td style="padding:10px;"><a href="mailto:{{ $rfq->email }}">{{ $rfq->email }}</a></td>
                                            </tr>
                                            <tr>
                                                <th style="background:#f1f1f1; padding:10px; text-align:left; font-weight:400;">Phone</th>
                                                <td style="padding:10px;">{{ $rfq->phone ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <!-- Shipping Info -->
                                    <td class="u-col" valign="top" width="50%" style="padding-left:10px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px;">
                                            <tr>
                                                <th colspan="2" style="background-color:#d3d3d3; padding:10px; text-align:center;">Shipping Info</th>
                                            </tr>
                                            @if(!empty($rfq->shipping_name))
                                            <tr>
                                                <th style="background:#f1f1f1; padding:10px; text-align:left; font-weight:400;">Contact</th>
                                                <td style="padding:10px;">{{ $rfq->shipping_name }}</td>
                                            </tr>
                                            <tr>
                                                <th style="background:#f1f1f1; padding:10px; text-align:left; font-weight:400;">Phone</th>
                                                <td style="padding:10px;">{{ $rfq->shipping_phone ?? 'N/A' }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Quote Button (Optional) -->
                            <div style="text-align:center; margin-top:30px;">
                                {{-- Add your quote button here if needed --}}
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9f9f9; padding:20px 30px;">
                            <table width="100%">
                                <tr>
                                    <td class="mail-footers" style="font-size:14px; width:50%; vertical-align:top;">
                                        <p style="margin:0 0 10px;"><strong>Thank You</strong></p>
                                        <p style="margin:0;color:#14abe7;">Techfocus SALES TEAM</p>
                                    </td>
                                    <td class="mail-footers" style="text-align:right; font-size:14px; width:50%; vertical-align:top;">
                                        <p style="margin:0;"><a href="tel:+19177203055">(☏) +1 917-720-3055</a></p>
                                        <p style="margin:0;"><a href="tel:+8801714243446">(✆) +880 1714 243446</a></p>
                                        <p style="margin:0;"><a href="mailto:sales@techfocusltd.com">(✉) sales@techfocusltd.com</a></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color:#14abe7; text-align:center; padding:15px;">
                            <a href="http://www.techfocusltd.com" style="color:#fff; font-size:18px;">www.techfocusltd.com</a>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
