<?php

namespace Modules\Booking\Filament\Resources\VisitWaitings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VisitWaitingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable(),

                TextColumn::make('patient.name')
                    ->searchable(),

                TextColumn::make('patient.race.name')->label(__('Ethnicity'))
                    ->searchable(),
                TextColumn::make('patient.age')->label(__('Age'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('patient.gender')->label(__('Gender'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->sortable()
                    ->searchable(),

                ToggleColumn::make('is_arrival')
                    ->sortable()
            ])
            ->filters([
                SelectFilter::make('status')->label(__('status'))
                    ->options([
                        'pending' => __('Pending'),
                        'complete' => __('Complete'),
                        'cancelled' => __('Cancelled'),
                    ]),
                SelectFilter::make('is_arrival')->label(__('is arrival'))
                    ->options([
                        true => __('Yes'),
                        false => __('No'),
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
