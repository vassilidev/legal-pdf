<?php

namespace App\Observers;

use App\Models\Contract;
use Illuminate\Support\Str;

class ContractObserver
{
    /**
     * Handle the Contract "created" event.
     */
    public function creating(Contract $contract): void
    {
        if (!$contract->slug) {
            $contract->slug = Str::slug($contract->name);
        }

        if (!$contract->form_schema) {
            $contract->form_schema = [
                'display'    => 'form',
                'components' => [],
            ];
        }
    }
}
