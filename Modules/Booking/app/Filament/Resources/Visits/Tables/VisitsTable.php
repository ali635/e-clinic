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
use Illuminate\Database\Eloquent\Builder;
use Modules\Booking\Models\Visit;
use Modules\Patient\Models\Patient;
use Modules\Service\Models\Service;
use Filament\Tables\Filters\SelectFilter;
use Torgodly\Html2Media\Actions\Html2MediaAction;

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
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->orWhereHas('service.translations', function (Builder $query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                    }),

                TextColumn::make('status')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('total_price')
                    ->sortable()

                    ->searchable(),

                TextColumn::make('arrival_time')
                    ->sortable(),

                BooleanColumn::make('is_arrival')
                    ->sortable()
                ,

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

                // SelectFilter::make('patient_id')->label(__('patient'))
                //     ->options(function () {
                //         return Patient::all()->pluck('name', 'id');
                //     }),
                // SelectFilter::make('service_id')->label(__('service'))
                //     ->options(function () {
                //         return Service::all()->pluck('name', 'id');
                //     }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Html2MediaAction::make('print')->label(__('print'))
                    ->format('a5')
                    ->content(fn($record) => view('invoice', ['record' => $record]))
                    ->visible(fn(Visit $record) => $record->status === 'complete'),
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
