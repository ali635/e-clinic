<?php

namespace Modules\Booking\Filament\Resources\VisitFollows\Schemas;

// use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VisitFollowInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Patient Information'))
                    ->schema([
                        TextEntry::make('patient.name')
                            ->label(__('Patient Name'))
                            ->icon('heroicon-o-user'),

                        TextEntry::make('patient.phone')
                            ->label(__('Phone'))
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->color('success')
                            ->url(fn($record) => $record->patient?->phone ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $record->patient->phone) : null)
                            ->openUrlInNewTab(),

                        TextEntry::make('patient.other_phone')
                            ->label(__('Other Phone'))
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->color('success')
                            ->placeholder(__('Not provided'))
                            ->url(fn($record) => $record->patient?->other_phone ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $record->patient->other_phone) : null)
                            ->openUrlInNewTab(),
                    ])
                    ->columns(3),

                Section::make(__('Visit Information'))
                    ->schema([
                        TextEntry::make('visit.id')
                            ->label(__('Visit ID'))
                            ->badge()
                            ->color('info'),

                        TextEntry::make('visit.service.name')
                            ->label(__('Service Name'))
                            ->icon('heroicon-o-wrench-screwdriver')
                            ->placeholder(__('Not specified')),

                        TextEntry::make('visit.arrival_time')
                            ->label(__('Visit Date'))
                            ->dateTime()
                            ->icon('heroicon-o-calendar')
                            ->placeholder(__('Not specified')),
                    ])
                    ->columns(3),

                Section::make(__('Follow-up Details'))
                    ->schema([
                        TextEntry::make('date')
                            ->label(__('Follow-up Date'))
                            ->date()
                            ->icon('heroicon-o-calendar-days'),

                        TextEntry::make('type')
                            ->label(__('Contact Type'))
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
                            })
                            ->placeholder(__('Not specified')),

                        TextEntry::make('status')
                            ->label(__('Status'))
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'answer' => 'success',
                                'not_answer' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn(string $state): string => match ($state) {
                                'answer' => __('Answer'),
                                'not_answer' => __('Not Answer'),
                                default => $state,
                            })
                            ->placeholder(__('Not specified')),
                    ])
                    ->columns(3),

                Section::make(__('Comments'))
                    ->schema([
                        TextEntry::make('comments')
                            ->label(__('Comments'))
                            ->placeholder(__('No comments'))
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make(__('Record Information'))
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('Created At'))
                            ->dateTime()
                            ->icon('heroicon-o-clock'),

                        TextEntry::make('updated_at')
                            ->label(__('Updated At'))
                            ->dateTime()
                            ->icon('heroicon-o-clock')
                            ->since(),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
