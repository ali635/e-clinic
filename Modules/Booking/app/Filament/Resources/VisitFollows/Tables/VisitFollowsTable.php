<?php

namespace Modules\Booking\Filament\Resources\VisitFollows\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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

                BooleanColumn::make('status')->label(__('Status')),

                TextColumn::make('comments')->label(__('Comments'))
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        'answer' => __('Answer'),
                        'not_answer' => __('Not Answer'),
                    ])
                    ->placeholder(__('All Statuses')),

                SelectFilter::make('type')
                    ->label(__('Type'))
                    ->options([
                        'phone_call' => __('Phone Call'),
                        'sms' => __('SMS'),
                        'whatsapp' => __('WhatsApp'),
                        'email' => __('Email'),
                        'in_person' => __('In-Person'),
                    ])
                    ->placeholder(__('All Types')),

                Filter::make('date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('date_from')
                            ->label(__('Date From')),
                        \Filament\Forms\Components\DatePicker::make('date_until')
                            ->label(__('Date Until')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['date_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['date_from'] ?? null) {
                            $indicators['date_from'] = __('Date from') . ': ' . \Carbon\Carbon::parse($data['date_from'])->toFormattedDateString();
                        }
                        if ($data['date_until'] ?? null) {
                            $indicators['date_until'] = __('Date until') . ': ' . \Carbon\Carbon::parse($data['date_until'])->toFormattedDateString();
                        }
                        return $indicators;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('contact_followup')
                    ->label(__('Contact Follow-up'))
                    ->icon('heroicon-o-phone')
                    ->color('success')
                    ->form([
                        Select::make('type')
                            ->label(__('Type'))
                            ->options([
                                'phone_call' => __('Phone Call'),
                                'sms' => __('SMS'),
                                'whatsapp' => __('WhatsApp'),
                                'email' => __('Email'),
                                'in_person' => __('In-Person'),
                            ])
                            ->required()
                            ->placeholder(__('Select contact type')),

                        Select::make('status')
                            ->label(__('Status'))
                            ->options([
                                'answer' => __('Answer'),
                                'not_answer' => __('Not Answer'),
                            ])
                            ->required()
                            ->placeholder(__('Select status')),

                        Textarea::make('comments')
                            ->label(__('Comments'))
                            ->rows(4)
                            ->placeholder(__('Enter follow-up notes and comments'))
                            ->columnSpanFull(),
                    ])
                    ->fillForm(fn($record) => [
                        'type' => $record->type,
                        'status' => $record->status,
                        'comments' => $record->comments,
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'type' => $data['type'],
                            'status' => $data['status'],
                            'comments' => $data['comments'],
                        ]);

                        Notification::make()
                            ->title(__('Follow-up updated successfully'))
                            ->success()
                            ->send();
                    })
                    ->modalHeading(__('Contact Follow-up'))
                    ->modalSubmitActionLabel(__('Save'))
                    ->modalWidth('md'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
