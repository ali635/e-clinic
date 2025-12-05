<?php

namespace Modules\Medicine\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class MedicinePlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Medicine';
    }

    public function getId(): string
    {
        return 'medicine';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
