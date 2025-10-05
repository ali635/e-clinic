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

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Language';

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
