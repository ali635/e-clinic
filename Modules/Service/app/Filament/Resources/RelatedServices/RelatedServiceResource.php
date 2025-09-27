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

class RelatedServiceResource extends Resource
{
    protected static ?string $model = RelatedService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'RelatedService';

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
            'edit' => EditRelatedService::route('/{record}/edit'),
        ];
    }
}
