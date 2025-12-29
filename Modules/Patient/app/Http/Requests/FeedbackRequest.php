<?php

namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Devrabiul\ToastMagic\Facades\ToastMagic;

class FeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow all to login
    }

    public function rules(): array
    {
        return [
            'visit_id' => 'required|integer|exists:visits,id',
            'rating' => 'required|integer|min:1|max:10',
            'comments' => 'required_unless:rating,10',
        ];
    }

    public function messages(): array
    {
        return [
            'visit_id.required' => __('Please select a visit.'),
            'rating.required' => __('Please select a rating.'),
            'comments.max' => __('The comments may not be greater than 1000 characters.'),
            'comments.required_unless' => __('Please provide feedback for ratings below 10.'),
        ];
    }

    protected function failedValidation(Validator $validator)
{
    // Add each error as a toast message
    foreach ($validator->errors()->all() as $error) {
        ToastMagic::error($error);
    }

    // Redirect back with input
    throw new HttpResponseException(
        redirect()->back()->withInput()
    );
}
}
