<?php

namespace Modules\Patient\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiseaseResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = $request->query('lang', app()->getLocale());
        app()->setLocale($lang);

        return [
            'id'          => $this->id,
            'name'        => $this->name ?? '',
        ];
    }
}
