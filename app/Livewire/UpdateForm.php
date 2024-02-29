<?php

namespace App\Livewire;

use App\Models\Contract;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UpdateForm extends Component
{
    public Contract $contract;

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
        $this->formType = $this->contract->form_schema['display'] ?? 'form';
    }

    public function render(): View
    {
        return view('livewire.update-form');
    }

    public function updatedFormSchema($value): void
    {
        $this->validateOnly('form_schema');

        $this->contract->update([
            'form_schema' => $value,
        ]);
    }

    public function updatedFormType($value)
    {
        $this->validateOnly('formType');

        $this->contract->update([
            'form_schema' => $this->getDefaultForm($value),
        ]);

        return to_route('backoffice.contract.edit', $this->contract);
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
