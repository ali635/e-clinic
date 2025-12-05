<?php

namespace Modules\Medicine\Filament\Resources\Medicines;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Medicine\Filament\Resources\Medicines\Pages\CreateMedicine;
use Modules\Medicine\Filament\Resources\Medicines\Pages\EditMedicine;
use Modules\Medicine\Filament\Resources\Medicines\Pages\ListMedicines;
use Modules\Medicine\Filament\Resources\Medicines\Schemas\MedicineForm;
use Modules\Medicine\Filament\Resources\Medicines\Tables\MedicinesTable;
use Modules\Medicine\Models\Medicine;

class MedicineResource extends Resource
{
    protected static ?string $model = Medicine::class;


    protected static ?string $recordTitleAttribute = 'name';

     public static function getNavigationGroup(): ?string
    {
        return __('Patient Information');
    }

     // ✅ TRANSLATABLE navigation label (sidebar)
    public static function getNavigationLabel(): string
    {
        return __('Medicines');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Medicines');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Medicine');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Medicines');
    }


    public static function form(Schema $schema): Schema
    {
        return MedicineForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MedicinesTable::configure($table);
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
            'index' => ListMedicines::route('/'),
            'create' => CreateMedicine::route('/create'),
            'edit' => EditMedicine::route('/{record}/edit'),
        ];
    }
}
