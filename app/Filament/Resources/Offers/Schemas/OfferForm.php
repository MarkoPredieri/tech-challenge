<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Set;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('provider_name')
                    ->label('Nome Provider')
                    ->required(),
                TextInput::make('offer_name')
                    ->label('Nome Offerta')
                    ->required(),
                Select::make('supply_type')
                    ->label('Tipo Fornitura')
                    ->options([
                        'electricity' => 'Luce',
                        'gas'         => 'Gas',
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('price_unit', match ($state) {
                            'electricity' => 'kWh',
                            'gas'         => 'Smc',
                            default       => null,
                        });
                    }),
                TextInput::make('unit_price')
                    ->label('Prezzo unitario')
                    ->required()
                    ->numeric()
                    ->prefix('€'),
                Select::make('price_unit')
                    ->label('Unità consumi')
                    ->options([
                        'kWh' => 'kWh',
                        'Smc' => 'Smc',
                    ])
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
