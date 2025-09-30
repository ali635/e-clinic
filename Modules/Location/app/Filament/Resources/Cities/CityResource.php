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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'City';

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
