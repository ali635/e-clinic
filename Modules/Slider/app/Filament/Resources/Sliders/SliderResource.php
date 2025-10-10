<?php

namespace Modules\Slider\Filament\Resources\Sliders;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Slider\Filament\Resources\Sliders\Pages\CreateSlider;
use Modules\Slider\Filament\Resources\Sliders\Pages\EditSlider;
use Modules\Slider\Filament\Resources\Sliders\Pages\ListSliders;
use Modules\Slider\Filament\Resources\Sliders\Schemas\SliderForm;
use Modules\Slider\Filament\Resources\Sliders\Tables\SlidersTable;
use Modules\Slider\Models\Slider;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

     protected static ?string $recordTitleAttribute = 'display_name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['translations.name'];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('Sliders');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Sliders');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Slider');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Sliders');
    }

    public static function form(Schema $schema): Schema
    {
        return SliderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SlidersTable::configure($table);
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
            'index' => ListSliders::route('/'),
            'create' => CreateSlider::route('/create'),
            'edit' => EditSlider::route('/{record}/edit'),
        ];
    }
}
