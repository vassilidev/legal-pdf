<?php

namespace App\Filament\Resources\EditorUiResource\Pages;

use App\Filament\Resources\EditorUiResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEditorUis extends ManageRecords
{
    protected static string $resource = EditorUiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
