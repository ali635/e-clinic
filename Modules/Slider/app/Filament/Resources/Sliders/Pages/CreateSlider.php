<?php

namespace Modules\Slider\Filament\Resources\Sliders\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\App;
use Modules\Slider\Filament\Resources\Sliders\SliderResource;
use Modules\Slider\Models\Slider;

class CreateSlider extends CreateRecord
{
    protected static string $resource = SliderResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {

        return \DB::transaction(function () use ($data) {
            // Insert into sliders table
            $sliderId = \DB::table('sliders')->insertGetId([
                'link'    => $data['link']   ?? null,
                'image'    => $data['image']   ?? null,
                'status' => $data['status'] ?? true,
                'order'    => $data['order']   ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert into slider_translations table
                \DB::table('slider_translations')->insert([
                    'slider_id'  => $sliderId,
                    'locale'      => App::getLocale(),
                    'name'        => $data['name'],
                    'description' => $data['description'] ?? null,

                ]);
            
            // Return a fresh model instance
            return Slider::find($sliderId);
        });
    }
}
