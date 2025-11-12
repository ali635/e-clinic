<?php

namespace Modules\Service\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDetailResource extends JsonResource
{
    public function toArray($request): array
    {
        

        return [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'short_description'    => $this->short_description,
            'description'          => $this->description,
            'price'                => $this->price,
            'patient_time_minute'  => (int) $this->patient_time_minute,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'currency_lang' => __('IQD'),
            'is_home'              => (bool) $this->is_home,
            'schedules'            => ScheduleResource::collection($this->schedules),
        ];
    }
}
