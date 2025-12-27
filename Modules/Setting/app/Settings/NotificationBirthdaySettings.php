<?php

namespace Modules\Setting\Settings;


use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;

class NotificationBirthdaySettings extends Settings
{

    use HasTranslations;

    protected array $translatable = [
       'birthday_title',
       'birthday_description',
    ];
    public ?array $birthday_title = [];
    public ?array $birthday_description = [];


    public static function group(): string
    {
        return 'notification_birthday';
    }
}

