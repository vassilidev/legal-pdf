<?php

namespace App\Actions\Stripe\PaymentIntent;

use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CreatePaymentIntent
{
    /**
     * @throws ApiErrorException
     */
    public function execute(
        int    $price,
        string $currency = 'eur',
        array  $paymentMethodTypes = ['card'],
    ): PaymentIntent
    {
        Stripe::setApiKey(config('cashier.secret'));

        return PaymentIntent::create([
            'amount'               => $price,
            'currency'             => $currency,
            'payment_method_types' => $paymentMethodTypes,
        ]);
    }
}