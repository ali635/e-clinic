<?php

namespace Modules\Booking\Filament\Resources\VisitWaitings;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Booking\Filament\Resources\VisitWaitings\Pages\CreateVisitWaiting;
use Modules\Booking\Filament\Resources\VisitWaitings\Pages\EditVisitWaiting;
use Modules\Booking\Filament\Resources\VisitWaitings\Pages\ListVisitWaitings;
use Modules\Booking\Filament\Resources\VisitWaitings\Pages\ViewVisitWaiting;
use Modules\Booking\Filament\Resources\VisitWaitings\Schemas\VisitWaitingForm;
use Modules\Booking\Filament\Resources\VisitWaitings\Schemas\VisitWaitingInfolist;
use Modules\Booking\Filament\Resources\VisitWaitings\Tables\VisitWaitingsTable;
use Modules\Booking\Models\VisitWaiting;

class VisitWaitingResource extends Resource
{
    protected static ?string $model = VisitWaiting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'status';

    // public static function form(Schema $schema): Schema
    // {
    //     return VisitWaitingForm::configure($schema);
    // }

    public static function infolist(Schema $schema): Schema
    {
        return VisitWaitingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VisitWaitingsTable::configure($table);
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
            'index' => ListVisitWaitings::route('/'),
            // 'create' => CreateVisitWaiting::route('/create'),
            'view' => ViewVisitWaiting::route('/{record}'),
            'edit' => EditVisitWaiting::route('/{record}/edit'),
        ];
    }
}
