<?php

namespace App\Filament\Resources\Bills\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\User;
use Filament\Tables\Filters\SelectFilter;

class BillsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('supply_type')
                    ->label('Tipologia Fornitura')
                    ->searchable(),
                TextColumn::make('consumption')
                    ->label('Consumi')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('consumption_unit')
                    ->label('Unità consumi')
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->label('Totale pagato')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('period_start')
                    ->label('Periodo di inzio')
                    ->date()
                    ->sortable(),
                TextColumn::make('period_end')
                    ->label('Periodo di fine')
                    ->date()
                    ->sortable(),
                TextColumn::make('provider_name')
                    ->label('Nome provider')
                    ->searchable(),
                TextColumn::make('invoice_number')
                    ->label('N° Fattura')
                    ->searchable(),
                TextColumn::make('due_date')
                    ->label('Data di scadenza')
                    ->date()
                    ->sortable(),
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
                SelectFilter::make('user_id')
                    ->label('Cliente')
                    ->options(User::whereHas('bills')->pluck('name', 'id')),
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
