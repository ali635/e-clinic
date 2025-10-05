<?php

namespace Modules\AdvancedLanguage\Filament\Resources\Languages\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\AdvancedLanguage\Filament\Resources\Languages\LanguageResource;

class EditLanguage extends EditRecord
{
    protected static string $resource = LanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $languageCodes = LaravelLocalization::getSupportedLanguagesKeys();
        $selectedLanguageCode = $languageCodes[$data['lang_code']] ?? null;
        if ($selectedLanguageCode != null) {
            $data['lang_code'] =  $selectedLanguageCode;
        }

        return $data;
    }
}
