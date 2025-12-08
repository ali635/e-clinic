<?php

namespace Modules\Patient\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientProfilePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only allow authenticated patients
        return true;
    }

    public function rules(): array
    {
        return [
           
            'old_password' => ['required', 'string', 'min:8', new MatchOldPassword()],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

  public function messages(): array
  {
    return [
      'old_password.required' => __('The old password field is required.'),
      'old_password.string' => __('The old password must be a valid string.'),
      'old_password.min' => __('The old password must be at least 8 characters.'),
      'old_password.confirmed' => __('The old password confirmation does not match.'),
      'password.required' => __('The password field is required.'),
      'password.string' => __('The password must be a valid string.'),
      'password.min' => __('The password must be at least 8 characters.'),
      'password.confirmed' => __('The password confirmation does not match.'),
    ];
  }
}
