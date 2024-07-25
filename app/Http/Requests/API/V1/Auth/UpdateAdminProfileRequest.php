<?php

namespace App\Http\Requests\API\V1\Auth;

use Illuminate\Contracts\Validation\Validator;
use App\Http\Controllers\API\Traits\APIResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminProfileRequest extends FormRequest
{
    use APIResponse;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'phone' => ['sometimes', "regex:/^\+?[0-9]+$/", 'string', 'min:11', 'max:13', Rule::unique('users')->ignore($this->user()->id)],
            'password' => ['sometimes', 'string', 'max:255', 'confirmed'],
            'gender' => ['sometimes', 'string', 'max:255', 'in:male,female'],
            'image' => ['sometimes', 'image'],
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->error(422, "Validation Errors", $validator->errors()));
    }
}
