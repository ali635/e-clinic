<?php

namespace Modules\Booking\Filament\Resources\Visits;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Booking\Filament\Resources\Visits\Pages\CreateVisit;
use Modules\Booking\Filament\Resources\Visits\Pages\EditVisit;
use Modules\Booking\Filament\Resources\Visits\Pages\ListVisits;
use Modules\Booking\Filament\Resources\Visits\Pages\ViewVisit;
use Modules\Booking\Filament\Resources\Visits\Schemas\VisitForm;
use Modules\Booking\Filament\Resources\Visits\Schemas\VisitInfolist;
use Modules\Booking\Filament\Resources\Visits\Tables\VisitsTable;
use Modules\Booking\Models\Visit;

class VisitResource extends Resource
{
    protected static ?string $model = Visit::class;

    public static function getNavigationGroup(): ?string
    {
        return __('Patient Information');
    }

    // ✅ TRANSLATABLE navigation label (sidebar)
    public static function getNavigationLabel(): string
    {
        return __('Visits');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Visits');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Visit');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Visits');
    }


    public static function form(Schema $schema): Schema
    {
        return VisitForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VisitInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VisitsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVisits::route('/'),
            'create' => CreateVisit::route('/create'),
            'view' => ViewVisit::route('/{record}'),
            'edit' => EditVisit::route('/{record}/edit'),
        ];
    }
}
