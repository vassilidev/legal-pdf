<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('after_payment.title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            color: #007bff;
        }

        .card-text {
            color: #6c757d;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card mt-5">
                <div class="card-body">
                    <h2 class="card-title text-center">@lang('after_payment.thank_you')</h2>
                    <p class="card-text">@lang('after_payment.order_received')</p>
                    <ul class="list-group">
                        <li class="list-group-item">@lang('after_payment.contract'): {{ $order->contract->name }}</li>
                        <li class="list-group-item">@lang('after_payment.user'): {{ $order->email }}</li>
                        <li class="list-group-item">@lang('after_payment.date'): {{ $order->created_at }}</li>
                        <li class="list-group-item">
                            @lang('after_payment.price')
                            : {{ formatCurrency($order->getTotalDue(), $order->currency)}}</li>
                        <li class="list-group-item">@lang('after_payment.order'): {{$order->id }}</li>
                    </ul>
                    <hr>
                    <a href="{{ route('pdf.contract.order', $order) }}" class="btn btn-success" target="_blank">
                        @lang('after_payment.contract_btn')
                    </a>
                    <a href="{{ route('order.invoice', $order) }}" class="btn btn-primary" target="_blank">
                        @lang('after_payment.invoice_btn')
                    </a>
                    <p class="card-text mt-3">@lang('after_payment.email_notice')</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>
