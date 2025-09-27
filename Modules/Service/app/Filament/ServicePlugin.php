<?php

namespace Modules\Service\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class ServicePlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Service';
    }

    public function getId(): string
    {
        return 'service';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
