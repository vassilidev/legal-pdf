<?php

namespace App\Http\Controllers;

use App\Enums\Stripe\PaymentIntentStatus;
use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;

class OrderController extends Controller
{
    /**
     * @throws ApiErrorException
     */
    public function paymentView(Order $order)
    {
        $paymentIntent = $order->stripePaymentIntent;

        if ($paymentIntent->status === PaymentIntentStatus::SUCCEEDED->value) {
            return to_route('order.succeeded', $order);
        }

        return view('backoffice.orders.payment', compact('order', 'paymentIntent'));
    }

    public function processPayment(Request $request, Order $order): mixed
    {
        if ($order->stripePaymentIntent->status === PaymentIntentStatus::SUCCEEDED->value) {
            if ($order->payment_status !== PaymentIntentStatus::SUCCEEDED) {
                $order->update(['payment_status' => PaymentIntentStatus::SUCCEEDED]);
            }

            return to_route('order.succeeded', $order);
        }

        die('why');
    }

    public function succeeded(Order $order)
    {
        return view('backoffice.orders.succeeded', compact('order'));
    }
}
