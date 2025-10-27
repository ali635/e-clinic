<?php

namespace Modules\Patient\Filament\Resources\Diseases\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Patient\Filament\Resources\Diseases\DiseaseResource;

class EditDisease extends EditRecord
{
    protected static string $resource = DiseaseResource::class;

     protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $diseaseId = $record->id;
        $locale    = $data['locale'] ?? App::getLocale();

        $translationData = [
            'name'             => $data['name'] ?? null,
            'locale'           => $locale,
        ];

        $exists = DB::table('disease_translations')
            ->where('disease_id', $diseaseId)
            ->where('locale', $locale)
            ->exists();

        if ($exists) {
            DB::table('disease_translations')
                ->where('disease_id', $diseaseId)
                ->where('locale', $locale)
                ->update($translationData);
        } else {
            $translationData['disease_id'] = $diseaseId;
            DB::table('disease_translations')->insert($translationData);
        }

        $diseaseData = array_diff_key($data, array_flip(['name', 'locale']));
        if ($diseaseData) {
            $record->update($diseaseData);
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
