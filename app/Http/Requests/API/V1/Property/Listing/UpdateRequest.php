<?php

namespace App\Http\Requests\API\V1\Property\Listing;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'property_id' => 'sometimes|integer|exists:properties,id',
            'admin_id' => 'sometimes|integer|exists:users,id',
            'status' => 'sometimes|string',
            'revenue' => 'sometimes|numeric',
        ];
    }
}
