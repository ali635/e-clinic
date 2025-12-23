<?php

namespace Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FirebaseNotificationLogsTable
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

                TextColumn::make('firebaseNotification.title')
                    ->searchable(),

                BooleanColumn::make('is_sent'),


            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
