<?php

namespace App\Filament\Pages\Settings;

use Closure;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;

class Settings extends BaseSettings
{
    protected static ?string $navigationGroup = 'Settings';

    public function schema(): array|Closure
    {
        return [
            Tabs::make('Settings')
                ->schema([
                    Tabs\Tab::make('Contract')
                        ->schema([
                            Textarea::make('contract.css')
                                ->required()
                                ->autosize(),
                        ]),
                    Tabs\Tab::make('Builder')
                        ->schema([
                            Textarea::make('builder.signature_component')
                                ->required()
                                ->autosize(),
                            Textarea::make('builder.final_component')
                                ->required()
                                ->autosize(),
                        ]),
                ]),
        ];
    }
}
