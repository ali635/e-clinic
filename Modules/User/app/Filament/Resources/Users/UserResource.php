<?php

namespace Modules\User\Filament\Resources\Users;

use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\User\Filament\Resources\Users\Pages\CreateUser;
use Modules\User\Filament\Resources\Users\Pages\EditUser;
use Modules\User\Filament\Resources\Users\Pages\ListUsers;
use Modules\User\Filament\Resources\Users\Schemas\UserForm;
use Modules\User\Filament\Resources\Users\Tables\UsersTable;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    public static function getNavigationGroup(): ?string
    {
        return __('Filament Shield');
    }

    // ✅ TRANSLATABLE navigation label (sidebar)
    public static function getNavigationLabel(): string
    {
        return __('Users');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Users');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('User');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Users');
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
