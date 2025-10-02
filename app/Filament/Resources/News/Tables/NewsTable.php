<?php

namespace App\Filament\Resources\News\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class NewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('author.name'),
                TextColumn::make('newsCategory.title'),
                TextColumn::make('title'),
                TextColumn::make('slug'),
                ImageColumn::make('thumbnail'),
            ])
            ->filters([
                SelectFilter::make('author_id')
                ->relationship('author','name')
                ->label('Select Author'),
                SelectFilter::make('news_category_id')
                ->relationship('newsCategory','title')
                ->label('Select Category')
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
