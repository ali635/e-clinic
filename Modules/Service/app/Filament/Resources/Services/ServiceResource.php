<?php

namespace Modules\Service\Filament\Resources\Services;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Service\Filament\Resources\Services\Pages\CreateService;
use Modules\Service\Filament\Resources\Services\Pages\EditService;
use Modules\Service\Filament\Resources\Services\Pages\ListServices;
use Modules\Service\Filament\Resources\Services\Pages\ViewService;
use Modules\Service\Filament\Resources\Services\Schemas\ServiceForm;
use Modules\Service\Filament\Resources\Services\Schemas\ServiceInfolist;
use Modules\Service\Filament\Resources\Services\Tables\ServicesTable;
use Modules\Service\Models\Service;
use UnitEnum;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    // protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): ?string
    {
        return __('Group Services');
    }
    public static function getNavigationLabel(): string
    {
        return __('Services');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Services');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Service');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Services');
    }
    public static function form(Schema $schema): Schema
    {
        return ServiceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ServiceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServicesTable::configure($table);
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
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'view' => ViewService::route('/{record}'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}
