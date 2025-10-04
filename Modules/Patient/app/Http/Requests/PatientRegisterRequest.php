<?php

namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow all to register
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:patients,email',
            'password'      => 'required|string|min:6|confirmed',
            'phone'         => 'nullable|string|max:20',
            'gender'        => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date',
            'address'       => 'nullable|string|max:255',
            'country_id'    => 'nullable|integer|exists:countries,id',
            'city_id'       => 'nullable|integer|exists:cities,id',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Passwords do not match.',
        ];
    }
}
