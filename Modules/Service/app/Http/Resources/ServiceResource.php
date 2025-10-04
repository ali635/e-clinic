<?php

namespace Modules\Service\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => $this->price,
            'patient_time_minute' => $this->patient_time_minute,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'is_home' => (bool) $this->is_home,
        ];
    }
}
