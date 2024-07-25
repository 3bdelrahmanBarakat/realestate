<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddAdminRequest extends FormRequest
{
    use APIResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'min:11', 'max:13', 'unique:' . User::class],
            'role' => ['required', 'in:admin,superadmin'],
            'gender'=> ['nullable', 'string'],
            'password' => ['required', 'string', 'min:8','confirmed'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->error(422, "Validation Errors", $validator->errors()));
    }
}
