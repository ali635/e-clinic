<?php

namespace Modules\Patient\Filament\Resources\Diseases;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Patient\Filament\Resources\Diseases\Pages\CreateDisease;
use Modules\Patient\Filament\Resources\Diseases\Pages\EditDisease;
use Modules\Patient\Filament\Resources\Diseases\Pages\ListDiseases;
use Modules\Patient\Filament\Resources\Diseases\Schemas\DiseaseForm;
use Modules\Patient\Filament\Resources\Diseases\Tables\DiseasesTable;
use Modules\Patient\Models\disease;

class DiseaseResource extends Resource
{
    protected static ?string $model = disease::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'disease';

    public static function form(Schema $schema): Schema
    {
        return DiseaseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DiseasesTable::configure($table);
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
            'index' => ListDiseases::route('/'),
            'create' => CreateDisease::route('/create'),
            'edit' => EditDisease::route('/{record}/edit'),
        ];
    }
}
