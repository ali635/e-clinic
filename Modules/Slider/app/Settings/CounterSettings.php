<?php

namespace Modules\Slider\Settings;


use Spatie\LaravelSettings\Settings;

class CounterSettings extends Settings
{
    public ?array $counter_settings = [];

    public static function group(): string
    {
        return 'counter';
    }
}

