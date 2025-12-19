<?php

namespace Modules\Room\Filament\Resources\Rooms;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Modules\Room\Filament\Resources\Rooms\Pages\CreateRoom;
use Modules\Room\Filament\Resources\Rooms\Pages\EditRoom;
use Modules\Room\Filament\Resources\Rooms\Pages\ListRooms;
use Modules\Room\Filament\Resources\Rooms\Schemas\RoomForm;
use Modules\Room\Filament\Resources\Rooms\Tables\RoomsTable;
use Modules\Room\Models\Room;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    public static function getNavigationGroup(): ?string
    {
        return __('Room Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Rooms');
    }

    public static function getPluralLabel(): string
    {
        return __('Rooms');
    }

    public static function getModelLabel(): string
    {
        return __('Room');
    }

    public static function getBreadcrumb(): string
    {
        return __('Rooms');
    }

    public static function form(Schema $schema): Schema
    {
        return RoomForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RoomsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRooms::route('/'),
            'create' => CreateRoom::route('/create'),
            'edit' => EditRoom::route('/{record}/edit'),
        ];
    }
}
