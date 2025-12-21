<?php

namespace Modules\Firebase\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FirebasePlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Firebase';
    }

    public function getId(): string
    {
        return 'firebase';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
