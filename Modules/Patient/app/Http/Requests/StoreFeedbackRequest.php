<?php

namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Booking\Models\Feedback;
use Modules\Booking\Models\Visit;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'visit_id' => ['required', 'integer', 'exists:visits,id'],
            'comments' => ['nullable', 'string', 'max:1000'],
            'rating'   => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $patient = auth('api')->user();
            $visit = Visit::query()->find($this->visit_id);

            if (!$visit) {
                $validator->errors()->add('visit_id', __('The visit does not exist.'));
                return;
            }

            // 1️⃣ Check that the visit belongs to this patient
            if ((int)$visit->patient_id !== (int)$patient->id) {
                $validator->errors()->add('visit_id', __('This visit does not belong to you.'));
            }

            // 2️⃣ Check that the visit has been marked as arrived
            if (!$visit->is_arrival) {
                $validator->errors()->add('visit_id', __('You can only give feedback for visits that have arrived.'));
            }

            // 3️⃣ Check that feedback for this visit hasn’t been submitted before
            $alreadyExists = Feedback::query()
                ->where('visit_id', (int)$visit->id)
                ->where('patient_id', (int)$patient->id)
                ->exists();

            if ($alreadyExists) {
                $validator->errors()->add('visit_id', __('You have already submitted feedback for this visit.'));
            }
        });
    }
}
