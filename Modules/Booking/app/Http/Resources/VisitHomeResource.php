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
            'total_after_discount'=> $this->total_after_discount,
            'currency_lang' => __('IQD'),
            'arrival_time' => $this->arrival_time,
            'is_arrival' => (bool) $this->is_arrival,
            'status' => (bool) $this->is_arrival && $this->status == 'complete' ? __('completed') : ($this->arrival_time > Carbon::now() && $this->status == 'pending' ? __('pending') : __('cancelled')),
            'secretary_description' => $this->secretary_description,
            'notes' => $this->notes,
            'patient_description' => strip_tags($this->patient_description),
            'doctor_description' => $this->doctor_description,
            'treatment' => $this->treatment,
            // 'show_btn_feedback' => $this->feedback && (bool) $this->is_arrival ? false : true,
            'show_btn_feedback' => $this->status == 'complete' &&  (bool) $this->is_arrival && !isset($this->feedback) ? true : false,
            // ✅ Service info (translated)
            'service' => $this->whenLoaded('service', function () use ($lang) {
                return [
                    'id' => $this->service->id,
                    'name' => $this->service->name ?? '',
                    'price' => $this->service->price,
                ];
            }),
        ];
    }
}
