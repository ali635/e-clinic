<?php

namespace Modules\Booking\Filament\Resources\Feedback\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Mokhosh\FilamentRating\Columns\RatingColumn;

class FeedbackTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable(),
                TextColumn::make('patient.name')
                    ->searchable(),

                TextColumn::make('visit.service.name')
                    ->searchable(),

                TextColumn::make('comments')
                    ->searchable(),
                RatingColumn::make('rating')
                    ->color('warning')
                    ->size('md')
                    ->label(__('Rating')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
