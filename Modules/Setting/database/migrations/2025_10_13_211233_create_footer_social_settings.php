<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('footer.facebook_url', 'www.facbook.com');
        $this->migrator->add('footer.x_url', 'www.x.com');
        $this->migrator->add('footer.instagram_url', 'www.instagram.com');
        $this->migrator->add('footer.youtube_url', 'www.youtube.com');

    }
};
