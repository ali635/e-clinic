<?php

namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow all to login
    }

    public function rules(): array
    {
        return [
            'phone'    => 'required|exists:patients,phone',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.exists' => __('No account found with this phone.'),
            'password.min' => __('Password must be at least 6 characters long.'),
        ];
    }
}
