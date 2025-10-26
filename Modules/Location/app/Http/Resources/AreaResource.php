<?php

namespace  Modules\Location\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = $request->query('lang', app()->getLocale());
        app()->setLocale($lang);

        return [
            'id'         => $this->id,
            'name'       => $this->name ?? '',
            'city_id' => $this->city_id,
            'order'      => $this->order,
            'status'     => (bool) $this->status,
        ];
    }
}
