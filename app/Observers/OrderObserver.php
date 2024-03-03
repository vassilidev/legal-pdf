<?php

namespace App\Observers;

use App\Actions\Stripe\PaymentIntent\CreatePaymentIntent;
use App\Models\Order;
use Stripe\Exception\ApiErrorException;

class OrderObserver
{
    /**
     * Handle the Order "creating" event.
     * @throws ApiErrorException
     */
    public function creating(Order $order): void
    {
        if (!$order->payment_intent_id) {
            $paymentIntent = app(CreatePaymentIntent::class)->execute(
                price: $order->price,
            );

            $order->payment_intent_id = $paymentIntent->id;
            $order->payment_status = $paymentIntent->status;
        }
    }
}
