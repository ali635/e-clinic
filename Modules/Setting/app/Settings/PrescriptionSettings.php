<?php

namespace Modules\Setting\Settings;


use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;

class PrescriptionSettings extends Settings
{
    use HasTranslations;

    public ?string $prescription_name = '';
    public ?string $prescription_title = '';
    public ?string $prescription_sub_title = '';
    public ?string $prescription_phone_one = '';
    public ?string $prescription_phone_two = '';
    public ?string $prescription_phone_three = '';
    public ?string $prescription_qr_code_one = '';
    public ?string $prescription_qr_code_two = '';
    public ?string $prescription_logo = '';
    public ?string $prescription_website = '';
    public ?string $prescription_social_title = '';


    public static function group(): string
    {
        return 'general';
    }
}

