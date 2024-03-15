<?php

namespace App\Filament\Resources;

use App\Enums\Currency;
use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Models\Contract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-text';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Creator')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->step('0.01')
                    ->formatStateUsing(fn(Contract $contract) => $contract->price / 100)
                    ->required(),
                Forms\Components\TextInput::make('signature_price')
                    ->numeric()
                    ->formatStateUsing(fn(Contract $contract) => $contract->signature_price / 100)
                    ->step('0.01')
                    ->nullable(),
                Forms\Components\Select::make('currency')
                    ->searchable()
                    ->required()
                    ->options(Currency::class),
                Forms\Components\TextInput::make('direction')
                    ->required()
                    ->default('ltr'),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(Contract::class, 'slug', ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('signature_url')
                    ->nullable()
                    ->url()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_published')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Creator')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Price/Signature/Currency')
                    ->getStateUsing(function (Contract $contract) {
                        return '<small>' .
                            $contract->price / 100
                            . '+'
                            . $contract->signature_price / 100
                            . $contract->currency->getSymbol()
                            . ' (' . $contract->currency->name . ')'
                            . '</small>';
                    })
                    ->html()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('price in cts')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('signature_price')
                    ->label('signature price in cts')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('signature_url')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('currency')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('direction')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_published')
                    ->sortable()
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ReplicateAction::make()
                    ->beforeReplicaSaved(function (Contract $replica) {
                        $name = $replica->name . ' Copy';

                        $replica->name = $name;
                        $replica->slug = Str::slug($name);
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Builder')
                    ->icon('heroicon-s-wrench-screwdriver')
                    ->color(Color::Blue)
                    ->url(fn(Contract $contract) => route('backoffice.contract.edit', $contract), true),
                Tables\Actions\Action::make('Public')
                    ->icon('heroicon-o-eye')
                    ->color(Color::Gray)
                    ->url(fn(Contract $contract) => route('survey.start', $contract), true),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit'   => Pages\EditContract::route('/{record}/edit'),
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
