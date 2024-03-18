<?php

namespace App\Filament\Pages\Settings;

use Closure;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Auth;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;
use Riodwanto\FilamentAceEditor\AceEditor;

class Settings extends BaseSettings
{
    protected static ?string $navigationGroup = 'Settings';

    public static function canAccess(): bool
    {
        return Auth::user()->can('page_Settings');
    }

    public function schema(): array|Closure
    {
        return [
            Tabs::make('Settings')
                ->schema([
                    Tabs\Tab::make('Contract')
                        ->schema([
                            AceEditor::make('contract.css')
                                ->mode('css')
                                ->required()
                                ->theme('github')
                                ->darkTheme('dracula')
                                ->autosize(),
                        ]),
                    Tabs\Tab::make('Builder')
                        ->schema([
                            AceEditor::make('builder.signature_component')
                                ->required()
                                ->mode('json')
                                ->theme('github')
                                ->darkTheme('dracula')
                                ->autosize(),
                            AceEditor::make('builder.final_component')
                                ->required()
                                ->mode('json')
                                ->theme('github')
                                ->darkTheme('dracula')
                                ->autosize(),
                        ]),
                    Tabs\Tab::make('Front')
                        ->schema([
                            AceEditor::make('front.navbar')
                                ->required()
                                ->mode('php')
                                ->theme('dracula')
                                ->theme('github')
                                ->autosize(),
                            AceEditor::make('front.footer')
                                ->required()
                                ->mode('php')
                                ->theme('github')
                                ->darkTheme('dracula')
                                ->autosize(),
                            AceEditor::make('front.layout')
                                ->required()
                                ->mode('php')
                                ->theme('github')
                                ->darkTheme('dracula')
                                ->autosize(),
                        ]),
                    Tabs\Tab::make('PDF')
                        ->schema([
                            AceEditor::make('pdf.invoice')
                                ->required()
                                ->mode('php')
                                ->theme('dracula')
                                ->theme('github')
                                ->autosize(),
                            AceEditor::make('pdf.contract')
                                ->required()
                                ->mode('php')
                                ->theme('github')
                                ->darkTheme('dracula')
                                ->autosize(),
                        ]),
                    Tabs\Tab::make('Mail')
                        ->schema([
                            AceEditor::make('mail.paymentSucceeded')
                                ->required()
                                ->mode('php')
                                ->theme('dracula')
                                ->theme('github')
                                ->autosize(),
                        ]),
                    Tabs\Tab::make('Orders')
                        ->schema([
                            AceEditor::make('orders.payment')
                                ->required()
                                ->mode('php')
                                ->theme('dracula')
                                ->theme('github')
                                ->autosize(),
                            AceEditor::make('orders.succeeded')
                                ->required()
                                ->mode('php')
                                ->theme('dracula')
                                ->theme('github')
                                ->autosize(),
                        ]),
                ]),
        ];
    }
}
