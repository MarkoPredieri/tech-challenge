<?php

namespace App\Filament\Resources\Bills\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use App\Models\User;
use Filament\Schemas\Components\Utilities\Set;

class BillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->options(User::pluck('name', 'id')) 
                    ->validationMessages([
                        'required' => 'L\' Utente è obbligatorio',
                    ])
                    ->label('Utente')
                    ->searchable()
                    ->required(),
                Select::make('supply_type')
                    ->validationMessages([
                        'required' => 'Devi selezionare un tipo di fornitura',
                    ])
                    ->label('Tipo fornitura')
                    ->options([
                        'electricity' => 'Luce',
                        'gas'         => 'Gas',
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('consumption_unit', match ($state) {
                            'electricity' => 'kWh',
                            'gas'         => 'Smc',
                            default       => null,
                        });
                    }),
                TextInput::make('consumption')
                    ->label('Consumi')
                    ->validationMessages([
                        'required' => 'I consumi sono obbligatori',
                    ])
                    ->required()
                    ->numeric(),
                Select::make('consumption_unit')
                    ->label('Unità consumi')
                    ->options([
                        'kWh' => 'kWh',
                        'Smc' => 'Smc',
                    ])
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                DatePicker::make('period_start')
                    ->label('Periodo di inzio')
                    ->validationMessages([
                        'required' => 'Periodo di inzio obbligatorio',
                    ])
                    ->required(),
                DatePicker::make('period_end')
                    ->label('Periodo di fine')
                    ->validationMessages([
                        'required' => 'Periodo di fine obbligatorio',
                    ])
                    ->required(),
                TextInput::make('provider_name')
                    ->label('Nome provider')
                    ->validationMessages([
                        'required' => 'Nome provider obbligatorio',
                    ])
                    ->required(),
                TextInput::make('invoice_number')
                    ->label('N° Fattura')
                    ->validationMessages([
                        'required' => 'N° fattura obbligatorio',
                    ])
                    ->required(),
                TextInput::make('total_amount')
                    ->label('Totale')
                    ->validationMessages([
                        'required' => 'I consumi sono obbligatori',
                    ])
                    ->required()
                    ->prefix('€')
                    ->numeric(),
                DatePicker::make('due_date')
                    ->label('Scadenza'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
