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
            "other_phone"   => ['sometimes', 'string', 'max:20','unique:patients,phone,' . auth('api')->id()],
            'gender'        => ['sometimes', 'in:male,female'],
            'date_of_birth' => ['sometimes', 'date'],
            'address'       => ['sometimes', 'string', 'max:500'],
            'country_id'    => ['sometimes', 'exists:countries,id'],
            'city_id'       => ['sometimes', 'exists:cities,id'],
            'area_id'       => ['sometimes', 'exists:areas,id'],
            'password'      => ['nullable', 'string', 'min:8', 'confirmed'],
            'diseases'      => ['sometimes', 'array', 'exists:diseases,id'],
            "hear_about_us" => ['sometimes', 'string', 'max:255'],
        ];
    }
}
