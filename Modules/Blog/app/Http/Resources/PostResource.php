<?php

namespace Modules\Blog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = $request->query('lang', app()->getLocale());
        app()->setLocale($lang);

        return [
            'id' => $this->id,
            'name' => $this->name ?? '',
            'description' => $this->description ?? '',
            'link' => $this->link,
            'order' => $this->order,
            'status' => (bool) $this->status,
            'image_url' => $this->image ? asset($this->image) : null,
        ];
    }
}
