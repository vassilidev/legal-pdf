<?php

namespace App\Filament\Resources\ContractResource\Pages;

use App\Filament\Resources\ContractResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContract extends CreateRecord
{
    protected static string $resource = ContractResource::class;

    protected function getRedirectUrl(): string
    {
        return route('backoffice.contract.edit', $this->record);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['price'] *= 100;
        $data['signature_price'] *= 100;

        return $data;
    }
}
