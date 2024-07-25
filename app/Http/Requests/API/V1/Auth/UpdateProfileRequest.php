<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Controllers\API\Traits\APIResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    use APIResponse;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:100'],
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'phone' => ['sometimes', 'string', 'min:11', 'max:13', Rule::unique('users')->ignore($this->user()->id)],
            'birthdate' => ['sometimes', 'date', 'date_format:Y-m-d'],
            'gender' => ['sometimes', 'in:male,female'],
            'about' => ['sometimes', 'string'],
            'image' => ['sometimes', 'image'],
            'password' => ['sometimes', 'string', 'max:255', 'confirmed'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->error(422, "Validation Errors", $validator->errors()));
    }
}
