<?php

namespace Modules\Patient\Filament\Resources\Patients\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Booking\Filament\Resources\Visits\VisitResource;

class VisitsRelationManager extends RelationManager
{
    protected static string $relationship = 'visits';

    protected static ?string $recordTitleAttribute = 'id';

    public static function getTitle($ownerRecord, string $pageClass): string
    {
        return __('Patient Visits');
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable(),

                TextColumn::make('service.name')
                    ->label(__('Service'))
                    ->searchable(),

                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'complete' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),

                TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('EGP')
                    ->sortable(),

                TextColumn::make('total_price')
                    ->label(__('Total Price'))
                    ->money('EGP')
                    ->sortable(),

                TextColumn::make('arrival_time')
                    ->label(__('Arrival Time'))
                    ->dateTime()
                    ->sortable(),

                BooleanColumn::make('is_arrival')
                    ->label(__('Arrived')),

                TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                Action::make('create_visit')
                    ->label(__('Create Visit'))
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->url(fn() => VisitResource::getUrl('create', [
                        'patient_id' => $this->getOwnerRecord()->id,
                    ])),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn($record) => VisitResource::getUrl('view', ['record' => $record])),
                EditAction::make()
                    ->url(fn($record) => VisitResource::getUrl('edit', ['record' => $record])),
                DeleteAction::make(),
            ]);
    }
    public function isReadOnly(): bool
    {
        return false;
    }
}
