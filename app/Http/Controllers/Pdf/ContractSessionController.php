<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ContractSessionController extends Controller
{
    public function render(Contract $contract): Response
    {
        return Pdf::loadView('contracts.pdf', compact('contract'))
            ->stream($contract->name . '.pdf');
    }
}
