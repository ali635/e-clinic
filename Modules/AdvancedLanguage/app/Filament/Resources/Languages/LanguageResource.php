<?php

namespace Modules\AdvancedLanguage\Filament\Resources\Languages;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\AdvancedLanguage\Filament\Resources\Languages\Pages\CreateLanguage;
use Modules\AdvancedLanguage\Filament\Resources\Languages\Pages\EditLanguage;
use Modules\AdvancedLanguage\Filament\Resources\Languages\Pages\ListLanguages;
use Modules\AdvancedLanguage\Filament\Resources\Languages\Schemas\LanguageForm;
use Modules\AdvancedLanguage\Filament\Resources\Languages\Tables\LanguagesTable;
use Modules\AdvancedLanguage\Models\Language;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('Languages');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Languages');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Language');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Languages');
    }

    public static function form(Schema $schema): Schema
    {
        return LanguageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LanguagesTable::configure($table);
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
            'index' => ListLanguages::route('/'),
            'create' => CreateLanguage::route('/create'),
            'edit' => EditLanguage::route('/{record}/edit'),
        ];
    }
}
