<?php

if (!function_exists('setting_lang')) {
    /**
     * Retrieve a setting by key from the settings table, respecting the current user's language for translatable fields.
     *
     * @param string $key The setting key (e.g., 'about_us', 'address', 'content')
     * @param mixed $default The default value to return if the setting is not found
     * @param string|null $group Optional group to filter settings (e.g., 'about')
     * @return mixed The setting value or the default value
     */
    function setting_lang(string $key, mixed $default = null, ?string $group = null): mixed
    {
        try {
            // Build the query for the settings table
            $query = \TomatoPHP\FilamentSettingsHub\Models\Setting::query()
                ->where('name', $key);
            
            // Apply group filter if provided
            if ($group) {
                $query->where('group', $group);
            }

            $setting = $query->first(['payload']);

            // Return default if setting or payload is not found
            if (!$setting || !$setting->payload) {
                return $default;
            }

            $value = $setting->payload;

            // Check if the payload is an array and contains locale-like keys
            $availableLocales = config('app.available_locales', [config('app.fallback_locale', 'en')]);
            if (is_array($value) && !empty(array_intersect(array_keys($value), $availableLocales))) {
                $locale = app()->getLocale();
                // Return the translated value or fall back to the default locale or default value
                return $value[$locale] ?? $value[config('app.fallback_locale')] ?? $default;
            }

            // Return non-translatable field value
            return $value ?? $default;
        } catch (\Exception $e) {
            // Log the error for debugging
            \Illuminate\Support\Facades\Log::error('Failed to retrieve setting: ' . $e->getMessage());
            return $default;
        }
    }
}