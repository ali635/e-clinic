<?php

namespace Modules\Firebase\Filament\Resources\FirebaseNotificationLogs;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\Pages\CreateFirebaseNotificationLog;
use Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\Pages\EditFirebaseNotificationLog;
use Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\Pages\ListFirebaseNotificationLogs;
use Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\Pages\ViewFirebaseNotificationLog;
use Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\Schemas\FirebaseNotificationLogForm;
use Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\Schemas\FirebaseNotificationLogInfolist;
use Modules\Firebase\Filament\Resources\FirebaseNotificationLogs\Tables\FirebaseNotificationLogsTable;
use Modules\Firebase\Models\FirebaseNotificationLog;

class FirebaseNotificationLogResource extends Resource
{
    protected static ?string $model = FirebaseNotificationLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationGroup(): ?string
    {
        return __('Firebase');
    }

    public static function getNavigationLabel(): string
    {
        return __('Firebase Notifications Logs');
    }
    public static function form(Schema $schema): Schema
    {
        return FirebaseNotificationLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FirebaseNotificationLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FirebaseNotificationLogsTable::configure($table);
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
            'index' => ListFirebaseNotificationLogs::route('/'),
            // 'create' => CreateFirebaseNotificationLog::route('/create'),
            'view' => ViewFirebaseNotificationLog::route('/{record}'),
            // 'edit' => EditFirebaseNotificationLog::route('/{record}/edit'),
        ];
    }
}
