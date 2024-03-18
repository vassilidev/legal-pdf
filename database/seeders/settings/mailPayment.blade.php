<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Purchase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
            text-align: center;
            margin-top: 0;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        li {
            margin-bottom: 10px;
        }
        a {
            display: inline-block;
            text-decoration: none;
            color: #ffffff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            margin-right: 10px;
        }
        p {
            text-align: center;
            margin-top: 20px;
        }
        @media only screen and (max-width: 600px) {
            .container {
                padding: 0 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Thank You for Your Purchase!</h2>
    <p>We have received your order:</p>
    <ul>
        <li><strong>Contract:</strong> {{ $order->contract->name }}</li>
        <li><strong>User:</strong> {{ $order->email }}</li>
        <li><strong>Date:</strong> {{ $order->created_at }}</li>
        <li><strong>Price:</strong> {{ formatCurrency($order->getTotalDue(), $order->currency) }}</li>
        <li><strong>Order:</strong> {{ $order->id }}</li>
    </ul>
    <hr>
    <div style="text-align: center;">
        <a href="{{ route('pdf.contract.order', $order) }}" target="_blank">View Contract</a>
        <a href="{{ route('order.invoice', $order) }}" target="_blank">View Invoice</a>
    </div>
</div>
</body>
</html>
