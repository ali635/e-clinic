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
use Service\Service;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Service';

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
