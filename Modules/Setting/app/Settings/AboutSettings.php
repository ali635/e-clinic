<?php

namespace Modules\Setting\Settings;


use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;

class AboutSettings extends Settings
{

    use HasTranslations;

    protected array $translatable = [
        'about_us',
        'address',
    ];
    public array $about_us = [];
    public array $address = [];


    public static function group(): string
    {
        return 'about';
    }
}

