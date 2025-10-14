<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('about.about_us', 'Creative Solutions');
        $this->migrator->add('about.address', 'Iraq');

    }
};
