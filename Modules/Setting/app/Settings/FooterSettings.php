<?php

namespace Modules\Setting\Settings;


use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;

class FooterSettings extends Settings
{
    use HasTranslations;
    public ?string $facebook_url = '';
    public ?string $instagram_url = '';
    public ?string $x_url = '';
    public ?string $youtube_url = '';

    public static function group(): string
    {
        return 'footer';
    }
}

