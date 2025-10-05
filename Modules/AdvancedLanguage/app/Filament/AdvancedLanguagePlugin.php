<?php

namespace Modules\AdvancedLanguage\Filament;

use Coolsam\Modules\Concerns\ModuleFilamentPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

class AdvancedLanguagePlugin implements Plugin
{
    use ModuleFilamentPlugin;

    public function getModuleName(): string
    {
        return 'AdvancedLanguage';
    }

    public function getId(): string
    {
        return 'advancedlanguage';
    }

    public function boot(Panel $panel): void
    {
        // TODO: Implement boot() method.
    }
}
