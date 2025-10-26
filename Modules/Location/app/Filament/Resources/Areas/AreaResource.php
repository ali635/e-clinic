<?php

namespace Modules\Location\Filament\Resources\Areas;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Location\Filament\Resources\Areas\Pages\CreateArea;
use Modules\Location\Filament\Resources\Areas\Pages\EditArea;
use Modules\Location\Filament\Resources\Areas\Pages\ListAreas;
use Modules\Location\Filament\Resources\Areas\Schemas\AreaForm;
use Modules\Location\Filament\Resources\Areas\Tables\AreasTable;
use Modules\Location\Models\Area;

class AreaResource extends Resource
{
    protected static ?string $model = Area::class;
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
        return __('Areas');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Areas');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Area');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Areas');
    }

    public static function form(Schema $schema): Schema
    {
        return AreaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AreasTable::configure($table);
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
            'index' => ListAreas::route('/'),
            'create' => CreateArea::route('/create'),
            'edit' => EditArea::route('/{record}/edit'),
        ];
    }
}
