<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('author_id')
                ->relationship('author','name')
                ->required(),
                Select::make('news_category_id')
                ->relationship('newsCategory','title')
                ->required(),
                TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                ->readOnly(),
                FileUpload::make('thumbnail')
                ->required()
                ->image()
                ->directory('thumbnails')
                ->disk('public')
                ->columnSpanFull(),
                RichEditor::make('content')
                ->required()
                ->columnSpanFull()
            ]);
    }
}
