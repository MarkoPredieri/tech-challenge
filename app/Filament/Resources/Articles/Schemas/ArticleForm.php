<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use App\Filament\Resources\Articles\Actions\FetchFromNewsApiAction;


use App\Models\Category;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Actions::make([FetchFromNewsApiAction::make()])
                    ->visibleOn('create'),

                Section::make('Contenuto')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')->label('Titolo')
                            ->validationMessages([
                                'required' => 'Il Titolo è obbligatorio',
                            ])
                            ->required(),
                        Textarea::make('body')->label('Contenuto') 
                            ->validationMessages([
                                'required' => 'Il Contenuto è obbligatorio',
                            ])
                            ->required()->columnSpanFull(),

                        Grid::make(2)->schema([
                            Select::make('category_id')
                                ->options(Category::pluck('name', 'id')) 
                                ->validationMessages([
                                    'required' => 'La Categoria è obbligatoria',
                                ])
                                ->label('Categoria')
                                ->searchable()
                                ->required(),
                            DateTimePicker::make('published_at')
                                ->label('Data di pubblicazione'),
                        ]),
                    ]),
            ]);
    }
}
