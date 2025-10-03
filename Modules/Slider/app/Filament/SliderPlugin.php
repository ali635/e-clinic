<?php

namespace Modules\Slider\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class SliderPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Slider';
    }

    public function getId(): string
    {
        return 'slider';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
