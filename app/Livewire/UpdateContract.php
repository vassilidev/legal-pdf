<?php

namespace App\Livewire;

use App\Models\Contract;
use App\Models\EditorUi;
use App\Models\Font;
use Illuminate\Support\Str;
use Livewire\Component;

class UpdateContract extends Component
{
    public Contract $contract;

    public ?string $content = '';

    public array $rules = [
        'content' => [
            'nullable',
        ],
    ];

    public string $loop = '';

    private $editorUis;

    public string $fontNames;


    public function mount(): void
    {
        $this->editorUis = EditorUi::all();

        $fontNames = Font::pluck('name')->implode(';');

        if ($fontNames) {
            $fontNames .= ';';
        }

        $this->fontNames = $fontNames;
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

        session()->flash('message', 'Contract saved.');
    }
}
