<?php

namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow anyone to register
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:patients,email',
            'password'      => 'required|string|min:6|confirmed',
            'phone'         => 'required|string|max:20|unique:patients,phone',
            'gender'        => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'address'       => 'required|string|max:255',
            'country_id'    => 'nullable|integer|exists:countries,id',
            'city_id'       => 'required|integer|exists:cities,id',
        ];
    }

    public function messages(): array
    {
        return [
            // name
            'name.required' => __('The name field is required.'),
            'name.string'   => __('The name must be a valid string.'),
            'name.max'      => __('The name may not be greater than 255 characters.'),

            // email
            'email.required' => __('The email field is required.'),
            'email.email'    => __('Please enter a valid email address.'),
            'email.unique'   => __('This email is already registered.'),

            // password
            'password.required'  => __('The password field is required.'),
            'password.string'    => __('The password must be a valid string.'),
            'password.min'       => __('The password must be at least 6 characters.'),
            'password.confirmed' => __('The password confirmation does not match.'),

            // phone
            'phone.required' => __('The phone field is required.'),
            'phone.string'   => __('The phone number must be a valid string.'),
            'phone.max'      => __('The phone number may not be greater than 20 characters.'),
            'phone.unique'   => __('This phone number is already registered.'),

            // gender
            'gender.required' => __('The gender field is required.'),
            'gender.in'       => __('The selected gender is invalid.'),

            // date_of_birth
            'date_of_birth.required' => __('The date of birth is required.'),
            'date_of_birth.date'     => __('Please provide a valid date of birth.'),

            // address
            'address.required' => __('The address field is required.'),
            'address.string'   => __('The address must be a valid string.'),
            'address.max'      => __('The address may not be greater than 255 characters.'),

            // country_id
            'country_id.integer' => __('The selected country is invalid.'),
            'country_id.exists'  => __('The selected country does not exist.'),

            // city_id
            'city_id.required' => __('The city field is required.'),
            'city_id.integer'  => __('The selected city is invalid.'),
            'city_id.exists'   => __('The selected city does not exist.'),
        ];
    }
}
