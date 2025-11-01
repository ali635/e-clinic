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
            'country' => $this->country ? [
                'id' => $this->country->id,
                'name' => $this->country->getTranslation('name', app()->getLocale())->name,
            ] : null,

            'city' => $this->city ? [
                'id' => $this->city->id,
                'name' => $this->city->getTranslation('name', app()->getLocale())->name,
            ] : null,


            'area' => $this->area ? [
                'id' => $this->area->id,
                'name' => $this->area->getTranslation('name', app()->getLocale())->name,
            ] : null,

            'diseases' => $this->diseasesMany->map(function ($disease) {
                return [
                    'id' => $disease->id,
                    'name' => $disease->getTranslation('name', app()->getLocale())->name,
                ];
            }),
        ];
    }
}
