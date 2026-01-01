<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Booking Invoice #{{ $booking['id'] }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            height: 60px;
            margin-bottom: 10px;
        }

        table.details,
        table.totals {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table.details th,
        table.details td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table.totals td {
            padding: 8px;
            text-align: right;
        }

        table.totals tr:last-child td {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #555;
        }

        .qrcode {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <!-- Company Logo -->
    <div class="header">
        <img src="{{ public_path('images/company-logo.png') }}" alt="Company Logo">
        <h1>Car Rental Invoice</h1>
        <p>Booking ID: {{ $booking['id'] }} - Invoice #{{ $booking['invoice_number'] }}</p>
        <p>Date: {{ now()->format('d M Y') }}</p>
    </div>

    <!-- Booking Details -->
    <table class="details">
        <tr>
            <th>Customer:</th>
            <td>{{ $booking['customer'] }}</td>
        </tr>
        <tr>
            <th>Car:</th>
            <td>{{ $booking['car'] }}</td>
        </tr>
        <tr>
            <th>Plate Number:</th>
            <td>{{ $booking['plate'] }}</td>
        </tr>
        <tr>
            <th>Pickup Location:</th>
            <td>{{ $booking['pickup_location'] }}</td>
        </tr>
        <tr>
            <th>Start Date:</th>
            <td>{{ $booking['start_date'] }}</td>
        </tr>
        <tr>
            <th>End Date:</th>
            <td>{{ $booking['end_date'] }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>{{ $booking['status'] }}</td>
        </tr>
        @if ($booking['payment_method'])
            <tr>
                <th>Payment Method:</th>
                <td>{{ $booking['payment_method'] }}</td>
            </tr>
        @endif
        <tr>
            <th>Payment Status:</th>
            <td>{{ $booking['payment_status'] }}</td>
        </tr>
        @if ($booking['paid_at'])
            <tr>
                <th>Paid At:</th>
                <td>{{ $booking['paid_at'] }}</td>
            </tr>
        @endif
    </table>

    <!-- Totals -->
    <table class="totals">
        <tr>
            <td>Price per day:</td>
            <td>${{ $booking['price_per_day'] }}</td>
        </tr>
        <tr>
            <td>Number of days:</td>
            <td>{{ $booking['total_days'] }}</td>
        </tr>
        <tr>
            <td>Total Price:</td>
            <td>${{ $booking['total_price'] }}</td>
        </tr>
    </table>

    <!-- QR Code -->
    <div class="qrcode">
        <img src="{{ $qr }}" alt="Booking QR Code" style="height: 200px;">
        <p>Scan to view booking details</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Company Name - Address, Phone, Email</p>
        <p>Thank you for choosing our car rental service!</p>
    </div>

</body>

</html>
