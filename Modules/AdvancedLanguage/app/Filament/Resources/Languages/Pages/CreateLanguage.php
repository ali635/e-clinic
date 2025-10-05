<?php

namespace Modules\AdvancedLanguage\Filament\Resources\Languages\Pages;

use Filament\Resources\Pages\CreateRecord;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\AdvancedLanguage\Filament\Resources\Languages\LanguageResource;

class CreateLanguage extends CreateRecord
{
    protected static string $resource = LanguageResource::class;
     protected function mutateFormDataBeforeCreate(array $data): array
    {
        $languageCodes = LaravelLocalization::getSupportedLanguagesKeys();
        $selectedLanguageCode = $languageCodes[$data['lang_code']] ?? null;
        $data['lang_code'] =  $selectedLanguageCode;    
        return $data;
    }
}
