<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('ai_assistant.ai_assistant_api_key');
        $this->migrator->add('ai_assistant.ai_assistant_prompt');
    }
};
