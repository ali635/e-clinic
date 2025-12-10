<?php

namespace Modules\Booking\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VisitResource extends JsonResource
{
    public function toArray($request)
    {
        $lang = $request->query('lang', app()->getLocale());
        app()->setLocale($lang);

        return [
            'id' => $this->id,
            'price' => $this->price,
            'total_price' => $this->total_price,
            'total_after_discount' => $this->total_after_discount,
            'currency_lang' => __('IQD'),
            'arrival_time' => $this->arrival_time,
            'is_arrival' => (bool) $this->is_arrival,
            'status' => (bool) $this->is_arrival && $this->status == 'complete' ? __('completed') : ($this->arrival_time > Carbon::now() && $this->status == 'pending' ? __('pending') : __('cancelled')),
            'doctor_description' => $this->doctor_description,
            'treatment' => $this->treatment,
            'secretary_description' => $this->secretary_description,
            'notes' => $this->notes,
            'patient_description' => $this->patient_description,

            'chief_complaint' => $this->chief_complaint,
            'medical_history' => $this->medical_history,
            'diagnosis' => $this->diagnosis,
            'sys' => $this->sys,
            'dia' => $this->dia,
            'pulse_rate' => $this->pulse_rate,
            'weight' => $this->weight,
            'height' => $this->height,
            'body_max_index' => $this->body_max_index,
            'payment_method' => $this->payment_method,


            // ✅ Service info (translated)
            // 'medicines' => $this->whenLoaded('medicines', function () use ($lang) {
            //     return $this->medicines->map(function ($medicine) use ($lang) {
            //         return [
            //             'id' => $medicine->id,
            //             'name' => $medicine->medicine->name ?? '',
            //         ];
            //     });
            // }),

            // Medicines as TagsInput array
            'medicines_list' => $this->medicines_list,

            'service' => $this->whenLoaded('service', function () use ($lang) {
                return [
                    'id' => $this->service->id,
                    'name' => $this->service->name ?? '',
                    'price' => $this->service->price,
                    'currency_lang' => __('IQD'),
                ];
            }),

            // ✅ Related services (with names & prices)
            'related_services' => $this->whenLoaded('relatedService', function () use ($lang) {
                return $this->relatedService->map(function ($related) use ($lang) {
                    return [
                        'id' => $related->id,
                        'related_service_id' => $related->related_service_id,
                        'name' => $related->relatedService?->name ?? '',
                        'price' => $related->relatedService?->price ?? 0,
                        'qty' => $related->qty ?? 1,
                        'total' => $related->price_related_service ?? 0,
                        'currency_lang' => __('IQD'),
                    ];
                });
            }),

            'show_btn_feedback' => !isset($this->feedback) && (bool) $this->is_arrival && $this->status == 'complete' ? true : false,

            'feedback' => $this->whenLoaded('feedback', function () {
                return [
                    'id' => $this->feedback->id,
                    'rating' => (int) $this->feedback->rating,
                    'comments' => $this->feedback->comments,
                ];
            }),
            'lab_tests' => $this->mapFiles($this->lab_tests),
            // 'x_rays' => $this->mapFiles($this->x_rays),
            'attachment' => $this->mapFiles($this->attachment),
        ];
    }

    /**
     * Map file paths to full URLs.
     */
    private function mapFiles($files)
    {
        if (empty($files)) {
            return [];
        }

        if (is_string($files)) {
            $files = json_decode($files, true) ?? [$files];
        }

        return collect($files)->map(function ($path) {
            return asset('storage/' . $path);
        })->toArray();
    }
}
