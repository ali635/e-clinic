<?php

namespace Modules\Booking\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitHomeResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = $request->query('lang', app()->getLocale());
        app()->setLocale($lang);

        return [
            'id' => $this->id,
            'price' => $this->price,
            'total_price' => $this->total_price,
            'currency_lang' => __('IQD'),
            'arrival_time' => $this->arrival_time,
            'is_arrival' => (bool) $this->is_arrival,
            'status' => (bool) $this->is_arrival ? __('completed') : ($this->arrival_time > Carbon::now() ? __('pending') : __('cancelled')),
            'secretary_description' => $this->secretary_description,
            'notes' => $this->notes,
            'show_btn_feedback' => $this->feedback && (bool) $this->is_arrival ? false : true,
               
        ];
    }

   
}
