<?php

namespace Modules\Slider\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $lang = $request->query('lang', app()->getLocale());
        app()->setLocale($lang);

        return [
            'id'          => $this->id,
            'name'        => $this->name ?? '',
            'description' => $this->description ?? '',
            'link'        => $this->link,
            'order'       => $this->order,
            'status'      => (bool) $this->status,
            'image_url'   => $this->image ? asset('storage/' . $this->image) : null,
        ];
    }
}
