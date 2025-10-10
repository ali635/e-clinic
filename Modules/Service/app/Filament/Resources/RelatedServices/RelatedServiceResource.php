<?php

namespace Modules\Service\Filament\Resources\RelatedServices;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Service\Filament\Resources\RelatedServices\Pages\CreateRelatedService;
use Modules\Service\Filament\Resources\RelatedServices\Pages\EditRelatedService;
use Modules\Service\Filament\Resources\RelatedServices\Pages\ListRelatedServices;
use Modules\Service\Filament\Resources\RelatedServices\Schemas\RelatedServiceForm;
use Modules\Service\Filament\Resources\RelatedServices\Tables\RelatedServicesTable;
use Modules\Service\Models\RelatedService;
use UnitEnum;

class RelatedServiceResource extends Resource
{
    protected static ?string $model = RelatedService::class;

    protected static ?string $recordTitleAttribute = 'display_name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['translations.name'];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Group Services');
    }
    public static function getNavigationLabel(): string
    {
        return __('Related Services');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Related Services');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Related Service');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Related Services');
    }
    public static function form(Schema $schema): Schema
    {
        return RelatedServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RelatedServicesTable::configure($table);
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
            'index' => ListRelatedServices::route('/'),
            'create' => CreateRelatedService::route('/create'),
            'activities' => Pages\ListRelatedServiceActivities::route('/{record}/activities'),
            'edit' => EditRelatedService::route('/{record}/edit'),
        ];
    }
}
