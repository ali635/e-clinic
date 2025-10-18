<?php

namespace Modules\Slider\Filament\Resources\Sliders\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Modules\Slider\Filament\Resources\Sliders\SliderResource;

class EditSlider extends EditRecord
{
    protected static string $resource = SliderResource::class;


    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update or insert translation
        $sliderId = $record->id;
        $locale    = $data['locale'] ?? App::getLocale();

        // Prepare translation data
        $translationData = [
            'name'             => $data['name'] ?? null,
            'description'      => $data['description'] ?? null,
            'locale'           => $locale,
        ];

        // Check if translation exists
        $exists = \DB::table('slider_translations')
            ->where('slider_id', $sliderId)
            ->where('locale', $locale)
            ->exists();

        if ($exists) {
            // Update existing translation
            \DB::table('slider_translations')
                ->where('slider_id', $sliderId)
                ->where('locale', $locale)
                ->update($translationData);
        } else {
            // Insert new translation
            $translationData['slider_id'] = $sliderId;
            \DB::table('slider_translations')->insert($translationData);
        }

        // Update main post record (excluding translation fields)
        $sliderData = array_diff_key($data, array_flip(['name', 'description', 'locale']));
        if ($sliderData) {
            $record->update($sliderData);
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
