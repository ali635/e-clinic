<?php

namespace Modules\Location\Filament\Resources\Areas\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Location\Filament\Resources\Areas\AreaResource;

class EditArea extends EditRecord
{
    protected static string $resource = AreaResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update or insert translation
        $areaId = $record->id;
        $locale    = $data['locale'] ?? App::getLocale();

        // Prepare translation data
        $translationData = [
            'name'             => $data['name'] ?? null,
            'locale'           => $locale,
        ];

        // Check if translation exists
        $exists = DB::table('area_translations')
            ->where('area_id', $areaId)
            ->where('locale', $locale)
            ->exists();

        if ($exists) {
            // Update existing translation
            DB::table('area_translations')
                ->where('area_id', $areaId)
                ->where('locale', $locale)
                ->update($translationData);
        } else {
            // Insert new translation
            $translationData['area_id'] = $areaId;
            DB::table('area_translations')->insert($translationData);
        }

        // Update main post record (excluding translation fields)
        $areaData = array_diff_key($data, array_flip(['name', 'locale']));
        if ($areaData) {
            $record->update($areaData);
        }

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
