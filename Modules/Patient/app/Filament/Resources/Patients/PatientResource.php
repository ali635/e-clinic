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

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Patient';

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
