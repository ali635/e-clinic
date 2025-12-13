<?php

namespace Modules\Location\Filament\Resources\Countries;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Location\Filament\Resources\Countries\Pages\CreateCountry;
use Modules\Location\Filament\Resources\Countries\Pages\EditCountry;
use Modules\Location\Filament\Resources\Countries\Pages\ListCountries;
use Modules\Location\Filament\Resources\Countries\Schemas\CountryForm;
use Modules\Location\Filament\Resources\Countries\Tables\CountriesTable;
use Modules\Location\Models\Country;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

     protected static ?string $recordTitleAttribute = 'display_name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['translations.name'];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Locations');
    }

    public static function getNavigationLabel(): string
    {
        return __('countries');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('countries');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('country');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('countries');
    }

    public static function form(Schema $schema): Schema
    {
        return CountryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CountriesTable::configure($table);
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
            'index' => ListCountries::route('/'),
            'create' => CreateCountry::route('/create'),
            'edit' => EditCountry::route('/{record}/edit'),
        ];
    }
}
