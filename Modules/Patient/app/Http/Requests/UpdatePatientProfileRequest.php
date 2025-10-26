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
            'phone'         => ['sometimes', 'string', 'max:20', 'unique:patients,phone,' . auth('api')->id()],
            'other_phone'   => ['sometimes', 'string', 'max:20', 'unique:patients,phone,' . auth('api')->id()],
            'gender'        => ['sometimes', 'in:male,female'],
            'date_of_birth' => ['sometimes', 'date'],
            'address'       => ['sometimes', 'string', 'max:500'],
            'country_id'    => ['sometimes', 'exists:countries,id'],
            'city_id'       => ['sometimes', 'exists:cities,id'],
            'area_id'       => ['sometimes', 'exists:areas,id'],
            'password'      => ['nullable', 'string', 'min:8', 'confirmed'],
            'diseases'      => ['sometimes', 'array'],
            'diseases.*'    => ['exists:diseases,id'],
            'hear_about_us' => ['sometimes', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            // name
            'name.string' => __('The name must be a valid string.'),
            'name.max' => __('The name may not be greater than 255 characters.'),

            // email
            'email.email' => __('Please enter a valid email address.'),
            'email.unique' => __('This email is already registered.'),

            // phone
            'phone.string' => __('The phone number must be a valid string.'),
            'phone.max' => __('The phone number may not be greater than 20 characters.'),
            'phone.unique' => __('This phone number is already registered.'),

            // other_phone
            'other_phone.string' => __('The other phone number must be a valid string.'),
            'other_phone.max' => __('The other phone number may not be greater than 20 characters.'),
            'other_phone.unique' => __('This other phone number is already registered.'),

            // gender
            'gender.in' => __('The selected gender is invalid.'),

            // date_of_birth
            'date_of_birth.date' => __('Please provide a valid date of birth.'),

            // address
            'address.string' => __('The address must be a valid string.'),
            'address.max' => __('The address may not be greater than 500 characters.'),

            // country_id
            'country_id.exists' => __('The selected country does not exist.'),

            // city_id
            'city_id.exists' => __('The selected city does not exist.'),

            // area_id
            'area_id.exists' => __('The selected area does not exist.'),

            // password
            'password.string' => __('The password must be a valid string.'),
            'password.min' => __('The password must be at least 8 characters.'),
            'password.confirmed' => __('The password confirmation does not match.'),

            // diseases
            'diseases.array' => __('Diseases must be a valid array.'),
            'diseases.*.exists' => __('One or more selected diseases are invalid.'),

            // hear_about_us
            'hear_about_us.string' => __('The hear about us field must be a valid string.'),
            'hear_about_us.max' => __('The hear about us field may not be greater than 255 characters.'),
        ];
    }
}
