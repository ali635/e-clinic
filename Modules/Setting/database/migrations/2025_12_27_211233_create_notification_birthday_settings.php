<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('notification_birthday.birthday_title');
        $this->migrator->add('notification_birthday.birthday_description');

    }
};
