<?php

namespace Modules\Setting\Settings;


use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;

class GeneralSettings extends Settings
{

    use HasTranslations;

    protected array $translatable = [
       'banner_title',
       'banner_description',
       'hero_banner',
       'home_video',
    ];
    public ?array $banner_title = [];
    public ?array $banner_description = [];
    public ?array $hero_banner = [];
    public ?array $home_video = [];


    public static function group(): string
    {
        return 'general';
    }
}

