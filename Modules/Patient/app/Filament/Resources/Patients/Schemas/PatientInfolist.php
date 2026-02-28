<?php

namespace Modules\Patient\Filament\Resources\Patients\Schemas;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Modules\Booking\Models\Visit;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\IconPosition;

class PatientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Patient Visits'))
                    ->columnSpanFull()
                    ->schema([
                        Tabs::make('Visits')
                            ->tabs(function ($record) {
                                return $record->visits()
                                    ->orderBy('arrival_time', 'desc')
                                    ->get()
                                    ->map(function (Visit $visit) {
                                        return Tab::make('visit_' . $visit->id)
                                            ->label('Visit ' . $visit->id . ' (' . ($visit->arrival_time?->format('Y/m/d') ?? $visit->created_at->format('Y/m/d')) . ')')
                                            ->schema([
                                                Grid::make(3)
                                                    ->schema([
                                                        TextEntry::make('written_by')
                                                            ->label(__('Written by'))
                                                            ->state($visit->room?->name ?? '---')
                                                            ->color('success'),
                                                        
                                                        TextEntry::make('chief_complaint')
                                                            ->label(__('Chief complaint'))
                                                            ->state(is_array($visit->chief_complaint) ? implode(', ', $visit->chief_complaint) : ($visit->chief_complaint ?? '--'))
                                                            ->color('primary'),

                                                        TextEntry::make('doctor_description')
                                                            ->label(__('History of present illness'))
                                                            ->state(new HtmlString($visit->doctor_description ?? '--'))
                                                            ->columnSpanFull(),

                                                        TextEntry::make('medical_history')
                                                            ->label(__('Review of other systems'))
                                                            ->state('Not specified') // Placeholder if not directly in fields
                                                            ->color('gray'),

                                                        Section::make(__('Blood pressure'))
                                                            ->columnSpan(1)
                                                            ->compact()
                                                            ->schema([
                                                                Grid::make(2)
                                                                    ->schema([
                                                                        TextEntry::make('sys')
                                                                            ->label('SYS')
                                                                            ->state(($visit->sys ?? '--') . ' MMHG'),
                                                                        TextEntry::make('dia')
                                                                            ->label('DIA')
                                                                            ->state(($visit->dia ?? '--') . ' MMHG'),
                                                                    ]),
                                                            ]),

                                                        Grid::make(4)
                                                            ->columnSpan(2)
                                                            ->schema([
                                                                TextEntry::make('pulse_rate')
                                                                    ->label(__('Pulse rate'))
                                                                    ->state(($visit->pulse_rate ?? '--') . ' beats/minute'),
                                                                TextEntry::make('weight')
                                                                    ->label(__('Weight'))
                                                                    ->state(($visit->weight ?? '--') . ' KG'),
                                                                TextEntry::make('height')
                                                                    ->label(__('Height'))
                                                                    ->state(($visit->height ? number_format($visit->height / 100, 2) : '--') . ' M'),
                                                                TextEntry::make('body_max_index')
                                                                    ->label(__('Body mass index'))
                                                                    ->state($visit->body_max_index ?? '--'),
                                                            ]),

                                                        TextEntry::make('lab_tests')
                                                            ->label(__('Imaging and laboratory investigations'))
                                                            ->state(is_array($visit->lab_tests) ? implode(', ', $visit->lab_tests) : 'Not specified'),

                                                        TextEntry::make('diagnosis')
                                                            ->label(__('Diagnosis'))
                                                            ->state(is_array($visit->diagnosis) ? implode(', ', $visit->diagnosis) : ($visit->diagnosis ?? 'Not specified'))
                                                            ->color('primary'),

                                                        TextEntry::make('treatment')
                                                            ->label(__('prescription'))
                                                            ->state(is_array($visit->treatment) ? implode(', ', $visit->treatment) : ($visit->treatment ?? 'Not specified'))
                                                            ->columnSpanFull()
                                                            ->copyable()
                                                            ->copyMessage('Treatment copied!')
                                                            ->icon('heroicon-m-clipboard-document-check')
                                                            ->copyMessageDuration(1500)
                                                            ->iconPosition(IconPosition::After)
                                                            ->extraAttributes(['class' => 'p-2 rounded']),
                                                    ]),
                                            ]);
                                    })
                                    ->toArray();
                            }),
                    ])
            ]);
    }
}
