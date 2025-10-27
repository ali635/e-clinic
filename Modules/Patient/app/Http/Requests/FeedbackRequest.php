<?php

namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow all to login
    }

    public function rules(): array
    {
        return [
            'visit_id'    => 'required|integer|exists:visits,id',
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'visit_id.required' => __('Please select a visit.'),
            'rating.required' => __('Please select a rating.'),
            'comments.max' => __('The comments may not be greater than 1000 characters.'),
            'comments.required' => __('Please enter comments.'),
        ];
    }
}
