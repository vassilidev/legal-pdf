<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ContractSessionController extends Controller
{
    public function renderContract(Contract $contract): Response
    {
        return Pdf::loadView('contracts.pdf', compact('contract'))
            ->stream($contract->name . '.pdf');
    }

    public function renderOrder(Order $order)
    {
        $answers = $order->answers['data'];
        $contract = $order->contract;

        return Pdf::loadView('contracts.pdf', compact('contract', 'answers', 'order'))
            ->stream($contract->name . '.pdf');
    }
}
