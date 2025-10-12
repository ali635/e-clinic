<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('sites.site_name', 'MOHAMED ALI');
        $this->migrator->add('sites.site_description', 'Creative Solutions');
        $this->migrator->add('sites.site_keywords', 'Graphics, Marketing, Programming');
        $this->migrator->add('sites.site_profile', '');
        $this->migrator->add('sites.site_logo', '');
        $this->migrator->add('sites.site_author', 'MOHAMED ALI');
        $this->migrator->add('sites.site_email', 'mohamedali7659@gmail.com');
        $this->migrator->add('sites.site_phone', '+201144016160');
        $this->migrator->add('sites.site_social', []);
    }
};
