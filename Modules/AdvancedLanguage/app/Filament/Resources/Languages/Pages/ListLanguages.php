<?php

namespace Modules\AdvancedLanguage\Filament\Resources\Languages\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\AdvancedLanguage\Filament\Resources\Languages\LanguageResource;

class ListLanguages extends ListRecords
{
    protected static string $resource = LanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
