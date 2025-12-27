<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('notification_visit_reminders.visit_reminder_title');
        $this->migrator->add('notification_visit_reminders.visit_reminder_description');

    }
};
