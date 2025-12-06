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
use Referral\Referral;

class ReferralResource extends Resource
{
    protected static ?string $model = Referral::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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
