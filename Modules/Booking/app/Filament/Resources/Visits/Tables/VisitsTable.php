<?php

namespace Modules\Booking\Filament\Resources\Visits\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Booking\Models\Visit;
use Modules\Patient\Models\Patient;
use Modules\Service\Models\Service;
use Filament\Tables\Filters\SelectFilter;

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

                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('price')
                    ->searchable(),

                TextColumn::make('total_price')
                    ->searchable(),

                TextColumn::make('arrival_time'),

                BooleanColumn::make('is_arrival'),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => __('Pending'),
                        'complete' => __('Complete'),
                        'cancelled' => __('Cancelled'),
                    ]),
                SelectFilter::make('is_arrival')
                    ->options([
                        true => __('Yes'),
                        false => __('No'),
                    ]),

                SelectFilter::make('patient_id')
                    ->options(function () {
                        return Patient::all()->pluck('name', 'id');
                    }),
                SelectFilter::make('service_id')
                    ->options(function () {
                        return Service::all()->pluck('name', 'id');
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('cancelled')
                    ->label(__('Cancelled'))
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->modalHeading(__('Cancel Visit'))
                    ->modalDescription(__('Are you sure you want to cancel this visit? Please provide a reason.'))
                    ->modalSubmitActionLabel(__('Cancel Visit'))
                    ->form([
                        \Filament\Forms\Components\Textarea::make('cancel_reason')
                            ->label(__('Cancellation Reason'))
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Visit $record, array $data) {
                        $record->update([
                            'status' => 'cancelled',
                            'is_arrival' => false,
                            'cancel_reason' => $data['cancel_reason'],
                        ]);
                    })
                    ->visible(fn(Visit $record) => $record->status === 'pending'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                // ExportBulkAction::make()
            ]);
    }

}
