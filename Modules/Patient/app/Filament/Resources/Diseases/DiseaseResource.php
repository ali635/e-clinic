<?php

namespace Modules\Patient\Filament\Resources\Diseases;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Patient\Filament\Resources\Diseases\Pages\CreateDisease;
use Modules\Patient\Filament\Resources\Diseases\Pages\EditDisease;
use Modules\Patient\Filament\Resources\Diseases\Pages\ListDiseases;
use Modules\Patient\Filament\Resources\Diseases\Schemas\DiseaseForm;
use Modules\Patient\Filament\Resources\Diseases\Tables\DiseasesTable;
use Modules\Patient\Models\disease;

class DiseaseResource extends Resource
{
    protected static ?string $model = disease::class;

     protected static ?string $recordTitleAttribute = 'display_name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['translations.name'];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Patient Information');
    }

    public static function getNavigationLabel(): string
    {
        return __('Diseases');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Diseases');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Disease');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Diseases');
    }

    public static function form(Schema $schema): Schema
    {
        return DiseaseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DiseasesTable::configure($table);
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
            'index' => ListDiseases::route('/'),
            'create' => CreateDisease::route('/create'),
            'edit' => EditDisease::route('/{record}/edit'),
        ];
    }
}
