<?php

namespace Modules\Booking\Filament\Resources\Visits\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class HistoryVisitFollowRelationManager extends RelationManager
{
    protected static string $relationship = 'history';

    public static function getTitle(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): string
    {
        return __('Follow-up History');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->required()
                    ->native(false),
                Select::make('type')
                    ->options([
                        'phone_call' => __('Phone Call'),
                        'sms' => __('SMS'),
                        'whatsapp' => __('WhatsApp'),
                        'email' => __('Email'),
                        'in_person' => __('In-Person'),
                    ])
                    ->required(),
                Select::make('status')
                    ->options([
                        'answer' => __('Answer'),
                        'not_answer' => __('Not Answer'),
                    ]),
                Textarea::make('comments')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'phone_call' => 'success',
                        'whatsapp' => 'success',
                        'sms' => 'info',
                        'email' => 'warning',
                        'in_person' => 'primary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'phone_call' => __('Phone Call'),
                        'sms' => __('SMS'),
                        'whatsapp' => __('WhatsApp'),
                        'email' => __('Email'),
                        'in_person' => __('In-Person'),
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'answer' => 'success',
                        'not_answer' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'answer' => __('Answer'),
                        'not_answer' => __('Not Answer'),
                        default => $state ?? '-',
                    }),
                Tables\Columns\TextColumn::make('comments')
                    ->limit(50),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
