<?php

namespace Modules\Booking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow all to register
    }

    public function rules(): array
    {
        return [
            'arrival_time' => 'required|date_format:Y-m-d H:i:s|unique:visits,arrival_time',
            'service_id'    => 'required|integer|exists:services,id',
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
