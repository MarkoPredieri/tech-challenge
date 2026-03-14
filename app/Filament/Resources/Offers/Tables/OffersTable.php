<?php

namespace App\Filament\Resources\Offers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;


class OffersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('provider_name')
                    ->label('Nome provider')
                    ->searchable(),
                TextColumn::make('offer_name')
                    ->label('Nome offerta')
                    ->searchable(),
                TextColumn::make('supply_type')
                    ->label('Tipo di fornitura')
                    ->searchable(),
                TextColumn::make('unit_price')
                    ->label('Prezzo unitario')
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('price_unit')
                    ->label('Unità consumi')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Offerta attiva?')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('supply_type')
                    ->label('Tipo fornitura')
                    ->options([
                        'electricity' => 'Luce',
                        'gas' => 'Gas',
                    ]),
                SelectFilter::make('is_active')
                    ->label('Offerta attiva?')
                    ->options([
                        true => 'Si',
                        false => 'No',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
