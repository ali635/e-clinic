<?php

namespace Modules\Booking\Filament\Resources\VisitFollows\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VisitFollowsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable(),

                TextColumn::make('patient.name')->label(__('Patient Name'))
                    ->searchable(),
                TextColumn::make('patient.phone')->label(__('Patient Phone'))
                    ->searchable(),
                TextColumn::make('patient.other_phone')->label(__('Patient Other Phone'))
                    ->searchable(),
                TextColumn::make('type')->label(__('Type'))
                    ->searchable(),

                TextColumn::make('date')->label(__('Date'))
                    ->searchable(),

                TextColumn::make('visit.service.name')->label(__('Service Name'))
                    ->searchable(),

                TextColumn::make('comments')->label(__('Comments'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                    
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
