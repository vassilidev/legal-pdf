<?php

namespace App\Livewire;

use App\Models\Contract;
use Livewire\Component;

class UpdateContract extends Component
{
    public Contract $contract;

    public ?string $content = '';

    public array $rules = [
        'content' => [
            'required',
            'string',
        ],
    ];

    public function render()
    {
        return view('livewire.update-contract');
    }

    public function updatedContent(string $content)
    {
        $this->validateOnly('content');

        $this->contract->update([
            'content' => $content
        ]);
    }
}
