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

        $price = $contract->price + ($signatureOption ? $contract->signature_price : 0);

        return $contract->orders()->create([
            'email'    => $email,
            'answers'  => $submission,
            'price'    => $price,
            'currency' => $contract->currency,
        ]);
    }
}