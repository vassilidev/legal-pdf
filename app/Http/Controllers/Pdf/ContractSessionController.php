<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractSessionController extends Controller
{
    public function render(Contract $contract)
    {
        return Pdf::loadView('contracts.pdf', compact('contract'))->stream();
    }
}
