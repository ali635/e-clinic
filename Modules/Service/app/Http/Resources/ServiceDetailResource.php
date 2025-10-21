<?php

namespace Modules\Service\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDetailResource extends JsonResource
{
    public function toArray($request): array
    {
        // smart image URL:
        $imageUrl = null;
        if ($this->image) {
            // public disk
            if (file_exists(storage_path('app/public/' . $this->image))) {
                $imageUrl = asset('storage/' . $this->image);
            }
            // private disk -> use a serving route (see below)
            elseif (file_exists(storage_path('app/private/' . $this->image))) {
                // route defined below: /service-image/{filename}
                $imageUrl = url('service-image/' . basename($this->image));
            }
        }

        return [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'short_description'    => $this->short_description,
            'description'          => $this->description,
            'price'                => $this->price,
            'patient_time_minute'  => (int) $this->patient_time_minute,
            'image'                => $imageUrl,
            'is_home'              => (bool) $this->is_home,
            'schedules'            => ScheduleResource::collection($this->schedules),
        ];
    }
}
