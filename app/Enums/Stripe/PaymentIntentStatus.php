<?php

namespace App\Enums\Stripe;

enum PaymentIntentStatus: string
{
    case SUCCEEDED = 'succeeded';
    case REQUIRED_ACTION = 'requires_action';
    case REQUIRES_PAYMENT_METHOD = 'requires_payment_method';
}
