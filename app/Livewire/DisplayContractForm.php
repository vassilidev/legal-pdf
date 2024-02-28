<?php

namespace App\Livewire;

use App\Models\Contract;
use Livewire\Component;

class DisplayContractForm extends Component
{
    public Contract $contract;

    public array $data = [];

    public function render()
    {
        return view('livewire.display-contract-form');
    }
}
