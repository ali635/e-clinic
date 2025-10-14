<?php

namespace Modules\Setting\Settings;


use Spatie\LaravelSettings\Settings;

class AboutSettings extends Settings
{
    public ?string $about_us = '';
    public ?string $address = '';

    public static function group(): string
    {
        return 'about';
    }
}

