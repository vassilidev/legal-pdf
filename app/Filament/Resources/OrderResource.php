<?php

namespace App\Filament\Resources;

use App\Enums\Currency;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email'),
                Forms\Components\Select::make('contract_id')
                    ->label('Contract')
                    ->relationship('contract', 'name'),
                Forms\Components\TextInput::make('price')
                    ->formatStateUsing(function (Order $order) {
                        return formatCurrency($order->getTotalDue(), $order->currency);
                    }),
                Forms\Components\Select::make('currency')
                    ->options(Currency::class),
                Forms\Components\KeyValue::make('answers')
                    ->columnSpanFull()
                    ->formatStateUsing(fn(Order $order) => $order->answers['data']),
                Forms\Components\TextInput::make('payment_status'),
                Forms\Components\TextInput::make('payment_intent_id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->getStateUsing(function (Order $order) {
                        return formatCurrency($order->getTotalDue(), $order->currency);
                    })
                    ->toggleable(),
                Tables\Columns\TextColumn::make('contract.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoicing_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoicing_address')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Final')
                    ->url(fn(Order $order) => route('order.succeeded', $order)),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
