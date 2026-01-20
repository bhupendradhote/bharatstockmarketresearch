<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $invoice->invoice_number }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            border-bottom: 2px solid #0939a4;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .company {
            font-size: 18px;
            font-weight: bold;
            color: #0939a4;
        }

        .small {
            font-size: 11px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        th {
            background: #f5f7fb;
        }

        .right {
            text-align: right;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div class="company">Bharat Stock Market Research</div>
        <div class="small">
            SEBI Registered Research Firm<br>
            Email: support@bharatstockmarket.com<br>
            Phone: +91-9876543210
        </div>
    </div>

    <!-- INVOICE INFO -->
    <table style="margin-bottom:20px;">
        <tr>
            <td>
                <b>Invoice No:</b> {{ $invoice->invoice_number }}<br>
                <b>Date:</b> {{ $invoice->invoice_date->format('d M Y') }}
            </td>
            <td class="right">
                <b>Status:</b> PAID<br>
                <b>Payment Mode:</b> Razorpay
            </td>
        </tr>
    </table>

    <!-- BILL TO -->
    <h4>Bill To</h4>
    <p class="small">
        {{ $invoice->user->name }}<br>
        Email: {{ $invoice->user->email }}<br>
        Phone: {{ $invoice->user->phone ?? 'N/A' }}<br>
        {{-- User ID: {{ $invoice->user->id }} --}}
    </p>

    <!-- PLAN DETAILS -->
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <b>{{ $invoice->subscription->plan->name }}</b><br>
                    Duration: {{ $invoice->subscription->duration->duration }}<br>
                    Period:
                    {{ $invoice->service_start_date->format('d M Y') }}
                    –
                    {{ $invoice->service_end_date->format('d M Y') }}
                </td>
                <td class="right">
                    ₹{{ number_format($invoice->amount, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- TOTAL -->
    <table style="margin-top:15px;">
        <tr>
            <td class="right total">Total Paid:</td>
            <td class="right total">₹{{ number_format($invoice->amount, 2) }}</td>
        </tr>
    </table>

    <!-- FOOTER -->
    <p class="small" style="margin-top:30px; text-align:center;">
        This is a system generated invoice. No signature required.
    </p>

</body>

</html>
