<?php

namespace Modules\Patient\Filament\Resources\Referrals\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Patient\Filament\Resources\Referrals\ReferralResource;

class CreateReferral extends CreateRecord
{
    protected static string $resource = ReferralResource::class;
}
