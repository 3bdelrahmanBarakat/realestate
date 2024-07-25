<?php

namespace App\Http\Requests\API\V1\Property\Action;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'property_id' => 'required|integer|exists:properties,id',
            'user_id' => 'required|integer|exists:users,id',
            'action' => 'required|string|max:255',
        ];
    }
}
