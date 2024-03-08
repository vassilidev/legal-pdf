<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Invoice</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body class="invoice-box">
<div>
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="4">
                <table>
                    <tr>
                        <td class="title">
{{--                            <img--}}
{{--                                    src="https://sparksuite.github.io/simple-html-invoice-template/images/logo.png"--}}
{{--                                    style="width: 100%; max-width: 300px"--}}
{{--                            />--}}
                            {{ config('app.name') }}
                        </td>

                        <td>
                            Invoice # {{ $order->id }}<br/>
                            Created: {{ $order->created_at->format('d/m/Y H:i') }}<br/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="4">
                <table>
                    <tr>
                        <td>
                            {{ config('app.name') }}<br/>
                            12345 Sunny Road<br/>
                            Sunnyville, CA 12345
                        </td>

                        <td>
                            {{ $order->invoicing_name }}<br/>
                            {{ $order->invoicing_address }}<br/>
                            {{ $order->email }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td>Item</td>
            <td>Unit Price</td>
            <td>Quantity</td>
            <td>Total</td>
        </tr>

        @foreach($order->products as $product)
            <tr class="item">
                <td>{{ $product->name }}</td>

                <td>{{ formatCurrency($product->unit_price, $order->currency) }}</td>

                <td>{{ $product->quantity }}</td>

                <td>{{ formatCurrency($product->getTotalPrice(), $order->currency) }}</td>
            </tr>
        @endforeach

        <tr class="total">
            <td></td>

            <td colspan="3">Total: {{ formatCurrency($order->getTotalDue(), $order->currency) }}</td>
        </tr>
    </table>
</div>
</body>
</html>