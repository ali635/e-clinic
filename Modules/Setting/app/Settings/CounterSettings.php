<?php

namespace Modules\Setting\Settings;

use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;

class CounterSettings extends Settings
{
    use HasTranslations;

    protected array $translatable = ['counter_settings'];

    public ?array $counter_settings = [];

    public static function group(): string
    {
        return 'counter';
    }
}