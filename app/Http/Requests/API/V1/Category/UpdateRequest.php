<?php

namespace App\Http\Requests\API\V1\Category;

use App\Http\Controllers\API\Traits\APIResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{
    use APIResponse;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "name" => ['required', 'string', "max:255"],
            'image' => ['sometimes', 'file', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->error(422, "Validation Errors", $validator->errors()));
    }
}
