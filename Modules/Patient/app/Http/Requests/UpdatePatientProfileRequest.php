<?php

namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only allow authenticated patients
        return auth('api')->check();
    }

    public function rules(): array
    {
        return [
            'name'          => ['sometimes', 'string', 'max:255'],
            'email'         => ['sometimes', 'email', 'unique:patients,email,' . auth('api')->id()],
            'phone'         => ['sometimes', 'string', 'max:20','unique:patients,phone,' . auth('api')->id()],
            'gender'        => ['sometimes', 'in:male,female,other'],
            'date_of_birth' => ['sometimes', 'date'],
            'address'       => ['sometimes', 'string', 'max:500'],
            'country_id'    => ['sometimes', 'exists:countries,id'],
            'city_id'       => ['sometimes', 'exists:cities,id'],
            'password'      => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
