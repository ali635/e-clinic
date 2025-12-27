<?php

namespace Modules\Setting\Settings;


use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;

class NotificationVisitRemindersSettings extends Settings
{

    use HasTranslations;

    protected array $translatable = [
       'visit_reminder_title',
       'visit_reminder_description',
    ];
    public ?array $visit_reminder_title = [];
    public ?array $visit_reminder_description = [];


    public static function group(): string
    {
        return 'notification_visit_reminders';
    }
}

