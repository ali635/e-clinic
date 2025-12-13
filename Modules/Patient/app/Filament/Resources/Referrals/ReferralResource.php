<?php

namespace Modules\Patient\Filament\Resources\Referrals;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Modules\Patient\Filament\Resources\Referrals\Pages\CreateReferral;
use Modules\Patient\Filament\Resources\Referrals\Pages\EditReferral;
use Modules\Patient\Filament\Resources\Referrals\Pages\ListReferrals;
use Modules\Patient\Filament\Resources\Referrals\Schemas\ReferralForm;
use Modules\Patient\Filament\Resources\Referrals\Tables\ReferralsTable;
use Modules\Patient\Models\Referral;

class ReferralResource extends Resource
{
    protected static ?string $model = Referral::class;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;


     public static function getNavigationGroup(): ?string
    {
        return __('Patient Information');
    }

    // ✅ TRANSLATABLE navigation label (sidebar)
    public static function getNavigationLabel(): string
    {
        return __('Referrals');
    }

    // ✅ TRANSLATABLE plural label (used in list page titles)
    public static function getPluralLabel(): string
    {
        return __('Referrals');
    }

    // ✅ TRANSLATABLE singular label (used in forms)
    public static function getModelLabel(): string
    {
        return __('Referral');
    }

    // ✅ TRANSLATABLE breadcrumb (top navigation)
    public static function getBreadcrumb(): string
    {
        return __('Referrals');
    }

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ReferralForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReferralsTable::configure($table);
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
            'index' => ListReferrals::route('/'),
            'create' => CreateReferral::route('/create'),
            'edit' => EditReferral::route('/{record}/edit'),
        ];
    }
}
