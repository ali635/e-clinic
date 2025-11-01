<?php

namespace Modules\Patient\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'email'          => $this->email,
            'phone'          => $this->phone,
            'gender'         => $this->gender,
            'date_of_birth'  => $this->date_of_birth?->toDateString(),
            'age'            => $this->age,
            'address'        => $this->address,
            'status'         => $this->status,
            'other_phone'    => $this->other_phone,
            'hear_about_us'  => $this->hear_about_us,

            'country' => $this->whenLoaded('country', function () {
                return [
                    'id' => $this->country->id,
                    'name' => $this->country->name ?? '',
                    'status' => $this->country->status,
                    'order' => $this->country->order,
                ];
            }),

            'city' => $this->whenLoaded('city', function () {
                return [
                    'id' => $this->city->id,
                    'name' => $this->city->name ?? '',
                    'status' => $this->city->status,
                    'order' => $this->city->order,

                ];
            }),

            'area' => $this->whenLoaded('area', function () {
                return [
                    'id' => $this->area->id,
                    'name' => $this->area->name ?? '',
                    'status' => $this->area->status,
                    'order' => $this->area->order,
                ];
            }),

            'diseases' => $this->whenLoaded('diseasesMany', function () {
                return $this->diseasesMany->map(function ($disease) {
                    return [
                        'id' => $disease->id,
                        'name' => $disease->getTranslation('name', app()->getLocale())->name,
                    ];
                });
            })

        ];
    }
}
