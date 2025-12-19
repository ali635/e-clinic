<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.prescription_name');
        $this->migrator->add('general.prescription_title');
        $this->migrator->add('general.prescription_sub_title');
        $this->migrator->add('general.prescription_phone_one');
        $this->migrator->add('general.prescription_phone_two');
        $this->migrator->add('general.prescription_phone_three');
        $this->migrator->add('general.prescription_qr_code_one');
        $this->migrator->add('general.prescription_qr_code_two');
        $this->migrator->add('general.prescription_website');
        $this->migrator->add('general.prescription_social_title');
    }
};
