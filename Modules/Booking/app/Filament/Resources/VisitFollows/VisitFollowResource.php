<?php

namespace Modules\Booking\Filament\Resources\VisitFollows;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Booking\Filament\Resources\VisitFollows\Pages\CreateVisitFollow;
use Modules\Booking\Filament\Resources\VisitFollows\Pages\EditVisitFollow;
use Modules\Booking\Filament\Resources\VisitFollows\Pages\ListVisitFollows;
use Modules\Booking\Filament\Resources\VisitFollows\Pages\ViewVisitFollow;
use Modules\Booking\Filament\Resources\VisitFollows\Schemas\VisitFollowForm;
use Modules\Booking\Filament\Resources\VisitFollows\Schemas\VisitFollowInfolist;
use Modules\Booking\Filament\Resources\VisitFollows\Tables\VisitFollowsTable;
use VisitFollow\VisitFollow;

class VisitFollowResource extends Resource
{
    protected static ?string $model = VisitFollow::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'dispaly_name';

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
            'create' => CreateVisitFollow::route('/create'),
            'view' => ViewVisitFollow::route('/{record}'),
            'edit' => EditVisitFollow::route('/{record}/edit'),
        ];
    }
}
