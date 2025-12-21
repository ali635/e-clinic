<?php

namespace Modules\Firebase\Filament\Resources\FirebaseNotificationResource\RelationManagers;

use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FirebaseNotificationLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'logs';

    protected static ?string $title = 'Notification Logs';

    protected static ?string $recordTitleAttribute = 'patient.name';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('patient.name')
            ->columns([
                TextColumn::make('id')
                    ->label('Log ID')
                    ->sortable(),

                TextColumn::make('patient.name')
                    ->label('Patient')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->patient->phone ?? 'No phone'),

                IconColumn::make('is_sent')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('is_sent')
                    ->label('Result')
                    ->badge()
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Sent' : 'Failed'),

                TextColumn::make('error_exceptions')
                    ->label('Error Message')
                    ->limit(50)
                    ->wrap()
                    ->placeholder('No errors')
                    ->tooltip(fn($state) => $state)
                    ->color('danger'),

                TextColumn::make('created_at')
                    ->label('Sent At')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_sent')
                    ->label('Status')
                    ->options([
                        1 => 'Sent',
                        0 => 'Failed',
                    ]),
            ])
            ->headerActions([
                // No create action - logs are created automatically
            ])
            ->actions([
                ViewAction::make()
                    ->form([
                        TextInput::make('patient.name')
                            ->label('Patient Name')
                            ->disabled(),

                        TextInput::make('patient.phone')
                            ->label('Patient Phone')
                            ->disabled(),

                        Toggle::make('is_sent')
                            ->label('Successfully Sent')
                            ->disabled(),

                        Textarea::make('error_exceptions')
                            ->label('Error Details')
                            ->rows(5)
                            ->disabled()
                            ->placeholder('No errors'),

                        DateTimePicker::make('created_at')
                            ->label('Timestamp')
                            ->disabled(),
                    ]),
            ])
            ->bulkActions([
                // No bulk delete - logs should be kept for auditing
            ])
            ->defaultSort('created_at', 'desc');
    }
}
