<?php

namespace Modules\Room\Filament\Resources\Rooms\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RoomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'asc')
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('Room Name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('code')
                    ->label(__('Code'))
                    ->searchable(),

                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'available' => 'success',
                        'unavailable' => 'danger',
                        default => 'gray',
                    }),

                IconColumn::make('is_ready')
                    ->label(__('Ready'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('currentVisit.patient.name')
                    ->label(__('Current Patient'))
                    ->placeholder(__('Empty'))
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
