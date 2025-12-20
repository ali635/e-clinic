<?php

namespace Modules\Setting\Settings;


use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;

class AiAssistantSettings extends Settings
{
    use HasTranslations;

    public ?string $ai_assistant_prompt = '';
    public ?string $ai_assistant_api_key = '';


    public static function group(): string
    {
        return 'ai_assistant';
    }
}

