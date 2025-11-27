<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.home_video');
        $this->migrator->add('general.hero_banner');
        $this->migrator->add('general.banner_title');
        $this->migrator->add('general.banner_description');

    }
};
