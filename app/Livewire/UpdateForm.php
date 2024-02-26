<?php

namespace App\Livewire;

use App\Models\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UpdateForm extends Component
{
    public Form $form;

    public ?array $formSchema = null;

    public array $rules = [
        'formSchema' => [
            'required',
            'nullable',
            'array',
        ],
    ];

    public function render(): View
    {
        return view('livewire.update-form');
    }

    public function updatedFormSchema($value): void
    {
        $this->validateOnly('form_schema');

        $this->form->update([
            'form_schema' => $value,
        ]);
    }
}
