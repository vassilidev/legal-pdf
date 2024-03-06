<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\EditorUi;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    public function edit(Contract $contract)
    {
        $editorUis = EditorUi::all();

        $names = $editorUis
            ->pluck('name')
            ->map(fn($value) => Str::slug($value))
            ->toArray();

        $templateNames = implode(' ', $names);

        return view('backoffice.contracts.builder', compact('contract', 'editorUis', 'templateNames'));
    }
}
