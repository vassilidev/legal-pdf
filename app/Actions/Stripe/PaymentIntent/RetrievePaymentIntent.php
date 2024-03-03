<?php

namespace App\Actions\Stripe\PaymentIntent;

use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class RetrievePaymentIntent
{
    /**
     * @throws ApiErrorException
     */
    public function execute(?string $paymentIntentId): ?PaymentIntent
    {
        if (is_null($paymentIntentId)) {
            return null;
        }

        Stripe::setApiKey(config('cashier.secret'));

        return PaymentIntent::retrieve($paymentIntentId);
    }
}