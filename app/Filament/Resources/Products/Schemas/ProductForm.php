<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([
                        FileUpload::make('pic')
                            ->label('Foto Produk')
                            ->image()
                            ->maxSize(2048)
                            ->directory('products')
                            ->visibility('public')
                            ->disk('public')
                            ->required()
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ]),
                        TextInput::make('name')
                            ->required(),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required(),
                        Textarea::make('description')
                            ->required(),
                        Repeater::make('variation')
                            ->relationship()
                            ->schema([
                                TextInput::make('variation')->required(),
                                TextInput::make('price')->required()->numeric(),
                            ])
                            ->columns(2),
                        Toggle::make('is_active')
                    ])
                    ->columnSpan('full')
            ]);
    }
}
