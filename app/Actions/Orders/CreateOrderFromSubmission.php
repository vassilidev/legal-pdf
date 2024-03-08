<?php

namespace App\Actions\Orders;

use App\Models\Contract;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CreateOrderFromSubmission
{
    public function execute(Collection $submission, Contract $contract): Order
    {
        /** @var Collection $data */
        $data = $submission->get('data');

        $email = (Auth::check())
            ? Auth::user()->email
            : $data->get('surveyUserEmail');

        $signatureOption = $data->get('signatureOption') ?? false;

        /** @var Order $order */
        $order = $contract->orders()->create([
            'email'            => $email,
            'answers'          => $submission,
            'currency'         => $contract->currency,
            'signature_option' => $signatureOption,
        ]);

        $order->products()->create([
            'name'       => 'PDF ' . $order->contract->name,
            'unit_price' => $order->contract->price,
        ]);

        if ($signatureOption) {
            $order->products()->create([
                'name'       => 'Option Signature',
                'unit_price' => $order->contract->signature_price,
            ]);
        }

        $order->createPaymentIntent();

        return $order;
    }
}