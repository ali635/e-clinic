<?php

namespace Modules\Booking\Filament\Resources\Visits\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Booking\Filament\Resources\Visits\VisitResource;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;

class VisitsTable
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

                TextColumn::make('service.name')
                    ->searchable(),

                TextColumn::make('price')
                    ->searchable(),

                TextColumn::make('total_price')
                    ->searchable(),

                TextColumn::make('arrival_time'),

                BooleanColumn::make('is_arrival'),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('activities')->label(__('Activities Log'))->url(fn($record) => VisitResource::getUrl('activities', ['record' => $record]))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                // ExportBulkAction::make()
            ]);
    }
    
}
