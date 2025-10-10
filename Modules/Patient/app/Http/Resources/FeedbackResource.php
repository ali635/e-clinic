<?php

namespace Modules\Patient\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'visit_id' => $this->visit_id,
            'comments' => $this->comments,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'visit' => [
                'id' => $this->visit?->id,
                'service_name' => $this->visit?->service?->getTranslation('name', app()->getLocale())->name,
            ],
        ];
    }
}
