<?php

namespace App\Filament\Resources\Authors\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                ->required(),
                TextInput::make('username')
                ->required(),
                FileUpload::make('avatar')
                ->required()
                ->directory('authors')
                ->image(),
                Textarea::make('bio')
                ->required(),
            ]);
    }
}
