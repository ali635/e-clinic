<?php

namespace Modules\Location\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class LocationPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Location';
    }

    public function getId(): string
    {
        return 'location';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
