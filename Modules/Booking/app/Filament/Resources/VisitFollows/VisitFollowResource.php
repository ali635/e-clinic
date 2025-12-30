<?php

namespace Modules\Booking\Filament\Resources\VisitFollows;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Booking\Filament\Resources\VisitFollows\Pages\ListVisitFollows;
use Modules\Booking\Filament\Resources\VisitFollows\Pages\ViewVisitFollow;
use Modules\Booking\Filament\Resources\VisitFollows\Schemas\VisitFollowForm;
use Modules\Booking\Filament\Resources\VisitFollows\Schemas\VisitFollowInfolist;
use Modules\Booking\Filament\Resources\VisitFollows\Tables\VisitFollowsTable;
use Modules\Booking\Models\VisitFollow;

class VisitFollowResource extends Resource
{
    protected static ?string $model = VisitFollow::class;

   public static function getNavigationGroup(): ?string
    {
        return __('Patient Information');
    }

    // ✅ TRANSLATABLE navigation label (sidebar)
    public static function getNavigationLabel(): string
    {
        return __('Follow up');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Follow up');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Follow up');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Follow up');
    }

    public static function form(Schema $schema): Schema
    {
        return VisitFollowForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VisitFollowInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VisitFollowsTable::configure($table);
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
            'index' => ListVisitFollows::route('/'),
            // 'create' => CreateVisitFollow::route('/create'),
            'view' => ViewVisitFollow::route('/{record}'),
            // 'edit' => EditVisitFollow::route('/{record}/edit'),
        ];
    }
}
