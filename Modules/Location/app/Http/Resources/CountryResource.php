<?php

namespace  Modules\Location\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = $request->query('lang', app()->getLocale());
        app()->setLocale($lang);

        return [
            'id'     => $this->id,
            'name'   => $this->name ?? '',
            'order'  => $this->order,
            'status' => (bool) $this->status,
        ];
    }
}
