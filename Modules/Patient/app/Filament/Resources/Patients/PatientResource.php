<?php

namespace Modules\Patient\Filament\Resources\Patients;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Patient\Filament\Resources\Patients\Pages\CreatePatient;
use Modules\Patient\Filament\Resources\Patients\Pages\EditPatient;
use Modules\Patient\Filament\Resources\Patients\Pages\ListPatients;
use Modules\Patient\Filament\Resources\Patients\Pages\ViewPatient;
use Modules\Patient\Filament\Resources\Patients\Schemas\PatientForm;
use Modules\Patient\Filament\Resources\Patients\Schemas\PatientInfolist;
use Modules\Patient\Filament\Resources\Patients\Tables\PatientsTable;
use Modules\Patient\Models\Patient;
use UnitEnum;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    public static function getNavigationGroup(): ?string
    {
        return __('Patient Information');
    }

    // ✅ TRANSLATABLE navigation label (sidebar)
    public static function getNavigationLabel(): string
    {
        return __('Patients');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Patients');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Patient');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Patients');
    }

    public static function form(Schema $schema): Schema
    {
        return PatientForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PatientInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PatientsTable::configure($table);
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
            'index' => ListPatients::route('/'),
            'create' => CreatePatient::route('/create'),
            'view' => ViewPatient::route('/{record}'),
            'edit' => EditPatient::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
