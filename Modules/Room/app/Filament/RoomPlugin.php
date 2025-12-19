<?php

namespace Modules\Room\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class RoomPlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'Room';
    }

    public function getId(): string
    {
        return 'room';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
