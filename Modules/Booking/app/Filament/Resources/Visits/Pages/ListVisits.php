<?php

namespace Modules\Booking\Filament\Resources\Visits\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Booking\Filament\Resources\Visits\VisitResource;
use Modules\Booking\Filament\Widgets\VisitStatsOverview;
use EightyNine\ExcelImport\ExcelImportAction;
use Modules\Booking\Imports\VisitPatientImporter;

class ListVisits extends ListRecords
{
    protected static string $resource = VisitResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            VisitStatsOverview::class, // Register your StatsOverview widget here
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ExcelImportAction::make()
                ->use(VisitPatientImporter::class)
                ->color('success')
                ->icon('heroicon-o-arrow-up-tray')
                ->label(__('Import Visits & Patients')),
        ];
    }
}
