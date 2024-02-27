<?php

namespace App\Livewire;

use App\Models\Form;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdateForm extends Component
{
    public Form $form;

    public ?array $formSchema = null;

    public string $formType = 'form';

    public array $rules = [
        'formSchema' => [
            'required',
            'nullable',
            'array',
        ],
        'formType'   => [
            'string',
            'in:form,wizard'
        ],
    ];

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->formType = $this->form->form_schema['display'] ?? 'form';
    }

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

    public function updatedFormType($value)
    {
        $this->validateOnly('formType');

        $this->form->update([
            'form_schema' => $this->getDefaultForm($value),
        ]);

        return to_route('backoffice.form.edit', $this->form);
    }

    private function getDefaultForm(string $type): array
    {
        if ($type === 'wizard') {
            return [
                'display'    => 'wizard',
                'components' => [],
            ];
        }

        return [
            'display'    => 'form',
            'components' => [],
        ];
    }
}
