<?php

namespace Modules\Location\Filament\Resources\Cities;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Location\Filament\Resources\Cities\Pages\CreateCity;
use Modules\Location\Filament\Resources\Cities\Pages\EditCity;
use Modules\Location\Filament\Resources\Cities\Pages\ListCities;
use Modules\Location\Filament\Resources\Cities\Schemas\CityForm;
use Modules\Location\Filament\Resources\Cities\Tables\CitiesTable;
use Modules\Location\Models\City;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    public static function getNavigationGroup(): ?string
    {
        return __('Locations');
    }

    public static function getNavigationLabel(): string
    {
        return __('Cities');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Cities');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('City');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Cities');
    }


    public static function form(Schema $schema): Schema
    {
        return CityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CitiesTable::configure($table);
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
            'index' => ListCities::route('/'),
            'create' => CreateCity::route('/create'),
            'edit' => EditCity::route('/{record}/edit'),
        ];
    }
}
