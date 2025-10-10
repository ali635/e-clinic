<?php

namespace Modules\Service\Filament\Resources\Services\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Modules\Service\Filament\Resources\Services\ServiceResource;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
                    ->defaultSort('id', 'desc')

            ->columns([
                 TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('name'))
                    ->getStateUsing(fn($record) => $record->name) // use translated accessor
                    ->searchable(query: function ($query, $search) {
                        $query->whereHas('translations', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                    }),

                TextColumn::make('price')
                    ->label(__('price'))
                    ->searchable(),

                TextColumn::make('patient_time_minute')
                    ->label(__('patient time in minute'))
                    ->searchable(),


                ToggleColumn::make('status')
                    ->label(__('status')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('activities')->url(fn($record) => ServiceResource::getUrl('activities', ['record' => $record]))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
