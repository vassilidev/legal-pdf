<?php

namespace App\Livewire;

use App\Models\Contract;
use App\Models\EditorUi;
use Illuminate\Support\Str;
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

    public string $loop = '';

    private $editorUis;
    private string $templateNames = '';

    public function mount(): void
    {
        $this->editorUis = EditorUi::all();

        $names = $this->editorUis
            ->pluck('name')
            ->map(fn($value) => Str::slug($value))
            ->toArray();

        $this->templateNames = implode(' ', $names);
    }

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
