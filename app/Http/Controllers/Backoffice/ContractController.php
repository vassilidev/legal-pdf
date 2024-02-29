<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Contract;

class ContractController extends Controller
{
    public function edit(Contract $contract)
    {
        return view('backoffice.contracts.builder', compact('contract'));
    }
}
